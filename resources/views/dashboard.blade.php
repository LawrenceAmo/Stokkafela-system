<x-app-layout>
    <style>
        a:hover {
            text-decoration: none;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <main class="m-0  px-4 w-100" id="app">

        <form action="{{ route('portal') }}" method="GET" class=" justify-content-between border shadow rounded px-3 py-0 pt-3 mb-3 w-100">
            <div class="d-flex   w-100 ">
                <div class=" form-group  ">
                    <input type="date" class="form-control" name="from" value="{{$dates['from']}}" aria-describedby="emailHelpId" placeholder="">
                </div>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <div class="form-group ">
                    <input type="date" class="form-control" name="to" value="{{$dates['to']}}" aria-describedby="emailHelpId" placeholder="">
                </div>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <div class="form-group "> 
                    <select class="custom-select" name="store" id="">
                        @foreach ($stores as $store)
                        @if ($store->storeID == $selected_store->storeID)
                            <option class="font-weight-bold" value="{{$store->storeID}}" selected>{{$store->name}}</option>
                        @else
                            <option class="font-weight-bold" value="{{$store->storeID}}"  >{{$store->name}}</option>
                        @endif
                        @endforeach
                     </select>
                </div>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <div class="  ">
                    <button type="submit" class="btn btn-sm btn-outline-info"> Filter </button>
                </div>
            </div>
           
        </form>
      
    <div class="row border rounded p-3 w-100">
         
        <a href="{{ route('products') }}" class="col-md-3 text-dark" title=" Click see detailed Stock Data">
             <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Out of stock  </span>
                <span class="font-weight-bold h5 text-center text-danger"> {{$get_products_stats->out_of_stock_products}} </span>
                <span class="small  text-center">Stock on hand {{$get_products_stats->stock_onhand}}</span>
             </div>
        </a>
        <a href="{{ route('products') }}" class="col-md-3 text-dark" title="Click see detailed Stock Data">
            <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Stock Value </span> 
                <span class="font-weight-bold h5 text-center"> R{{number_format($get_products_stats->stock_value, 2)}} </span>
                <span class="small  text-center">Last stock count 22 Jan 23</span>
             </div>
        </a>
        <a href="{{ route('sales') }}" class="col-md-3 text-dark" title="Click see detailed Sales Data">
             <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Sales  </span>
                    <span class="font-weight-bold h5 text-center"> R
                        {{-- {{number_format($sales, 2)}} --}}
                        <span id="total_sales"> </span>
                    </span>
                <span class="small  text-center">From {{$dates['from']}} - {{$dates['to']}}</span>
                {{-- <span class="small  text-center">+1.03% than last 30 days</span> --}}
             </div>
        </a>
        <a href="{{ route('sales') }}" class="col-md-3 text-dark" title=" Click see detailed Sales Data">
            <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Nett Sales</span>
                    <span class="font-weight-bold h5 text-center"> R
                        {{-- {{number_format($nettsales, 2)}} --}}
                        <span id="nettsales"></span>
                    </span>
                <span class="small  text-center">From {{$dates['from']}} - {{$dates['to']}}</span>
                {{-- <span class="small  text-center">+13.03% than last 30 days</span> --}}
             </div>
        </div>

        
    </div>
    <hr>
    <div class="row border rounded p-3 w-100">
        <div class="  bg-white rounded border-info col-md-12 p-0">
            <canvas  id="myChart" class="m-0 border-danger" style="  height:100px"></canvas>
        </div>
        {{-- <div class="border bg-white rounded col-md-6 h-50 p-3">

        </div> --}}
    </div>
    <hr>
    <div class="ow border rounded p-3 w-100">
<p class="font-weight-bold h4">
   Top 10 perfoming Products
</p>
<table class="table table-striped table-inverse table-responsive"  style="height: 500px;">
    <thead class="thead-inverse">
        <tr>
            <th>#</th>
            <th>Barcode</th>
            <th>Description</th>
            <th>Ave Cost</th>
            <th>Sell Price</th>
            <th>Item Value</th>
            <th>On Hand</th>
            <th>Margin</th>
             <th>Store Name</th>
            <th>Created At</th>
         </tr>
        </thead>
        <tbody> 
              <tr v-for="product,i in top_products" > 
                <td scope="row">@{{i}}</td>
               <span class=" bg-danger text-success">
                <td>@{{product.barcode}}</td>
                <td>@{{product.descript}}</td>
               </span>
                <td>R@{{toDecimal(product.avrgcost)}}</td>
                <td>R@{{toDecimal(product.sellpinc1)}}</td>
                <td>R@{{toDecimal(toDecimal(product.avrgcost) * toDecimal(product.onhand)) }}</td>
                <td v-if="product.onhand < 1 " class="text-danger font-weight-bold">@{{product.onhand}}</td>
                <td v-else class="text-success font-weight-bold">@{{product.onhand}}</td>
                <td>@{{ toDecimal((toDecimal(product.sellpinc1) / (toDecimal(product.sellpinc1) - toDecimal(product.avrgcost) ) ) * 100) }}</td>
                <td>@{{product.name}}</td>
                <td>@{{product.created_at}}</td>                  
            </tr>
         </tbody> 
</table>
    </div>
    </main>
    <input type="hidden" name="" id="salesdata" value="{{$salesdata}}">
    <input type="hidden" name="" id="selected_store" value="{{$selected_store->storeID}}">
    <script>
  
const { createApp } = Vue;
      //  let
      createApp({
        data() {
          return {
            top_products: [], 
          }          
        },
       async created() {
        let selected_store = document.getElementById("selected_store").value;
            let response = await  await axios.get("{{route('get_top_products')}}");
            let data = await response.data;
 console.log(data)
            for (let i = 0; i < data.length; i++) {
                this.top_products.push(data[i]);
             }
            console.log(this.top_products);
        },
        methods:
        {
            toDecimal: function(num) 
            {
                number = Number.parseFloat(num)
                return number.toFixed(2);
            }
        }
   }).mount("#app");

    //  Charts.js start    
    let salesdata = JSON.parse(document.getElementById("salesdata").value);
  
    let xValues  = []; let yValues = [];  let sales = [];
    let total_sales = 0;
    let nettSales = 0;
    let stock_codes = [];
    let stock = [];

    // get float number from string
    function number(num) {
        let number = num;
            number = number.replace(/,/g, "");
            number = parseFloat(number);
         return number;
    }

    for (let i = 0; i < salesdata.length; i++) {
// console.log(salesdata[i])
        let date = salesdata[i].from.substring(0, 10)
        let barcode = salesdata[i].barcode
        let sale = number(salesdata[i].sales);
        let nettsale = number(salesdata[i].nettSales);
        
        // add days if not exist
        if (!xValues.includes(date)) {
            sales[ date ] =0;   // add array of sales for that day
            xValues.push(date); 
        }
        // console.log(nettsale)
        sales[ date ] += nettsale;
        total_sales += sale;
        nettSales += nettsale; 
     }
 
     total_sales =  Number(total_sales);
     nettSales =  Number(nettSales);

     document.getElementById("total_sales").innerHTML = total_sales.toLocaleString('en-US');
     document.getElementById("nettsales").innerHTML = nettSales.toLocaleString('en-US');

    yValues = Object.values(sales);
  
  var myChart = new Chart("myChart", {
  type: "bar",
  data: {
     labels: xValues,
    datasets: [{
        label: 'Nett Sales',
        fill: false,
        data: yValues,
        lineTension: 0.3,
        backgroundColor: "#2784ba",
        // borderColor: "rgba(0,0,255,0.1)",
        pointStyle: 'circle',
        pointRadius: 5,
        borderSkipped: false,
        borderRadius: 10,
        borderColor: "darckgreen",
        borderWidth: 2,
        pointHoverRadius: 10
    }]
  },
  options: {
    legend: {display: false},
     responsive: true,
    name: 'pointStyle: circle (default)',
 
    
  }
});
 
    </script>
</x-app-layout>
