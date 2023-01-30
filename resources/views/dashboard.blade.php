<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <main class="m-0  px-4 w-100">

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
                        <option class="font-weight-bold" value="{{$store->storeID}}" selected>{{$store->name}}</option>
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
         
        <div class="col-md-3">
             <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Total Stock  </span>
                <span class="font-weight-bold h5 text-center"> {{$get_products_stats->stock_onhand}} </span>
                <span class="small  text-center">Out of stock {{$get_products_stats->out_of_stock_products}}</span>
             </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Stock Value </span> 
                <span class="font-weight-bold h5 text-center"> R{{number_format($get_products_stats->stock_value, 2)}} </span>
                <span class="small  text-center">Last stock count 22 Jan 23</span>
             </div>
        </div>
        <div class="col-md-3">
             <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Sales  </span>
                <span class="font-weight-bold h5 text-center"> R 
                    {{-- {{number_format($sales, 2)}} --}}
                     <span id="total_sales"> </span>
                </span>
                <span class="small  text-center">From {{$dates['from']}} - {{$dates['to']}}</span>
                {{-- <span class="small  text-center">+1.03% than last 30 days</span> --}}
             </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow px-2 py-1 border border-info">
                <span class="font-weight-bold ">Nett Sales  </span>
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
<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr>
            <th>#</th>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Items Qty</th>
            <th>Total Cost</th>
            <th>Created At</th>
             <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
</table>
    </div>
    </main>
    <input type="hidden" name="" id="salesdata" value="{{$salesdata}}">
    <script>
 
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
        return parseFloat(number);
    }

    for (let i = 1; i < salesdata.length; i++) {

        let date = salesdata[i].from.substring(0, 10)
        let barcode = salesdata[i].barcode
        let sale = number(salesdata[i].sales);
        let nettsale = number(salesdata[i].nettSales);
        

        // add days if not exist
        if (!xValues.includes(date)) {
            xValues.push(date); 
            sales[ date ] = 0;   // add array of sales for that day
        }
        sales[ date ] += nettsale;
        total_sales += sale;
        nettSales += nettsale;

        // //////////////////////////////
        // if (!stock_codes.includes(barcode)) {
            // stock.push(barcode);
            // stock_codes.barcode  = salesdata[i].barcode;   // add array of sales for that day
            // stock_codes.count  = 0;   // add array of sales for that day
            // stock_codes.descript  = salesdata[i].descript;   // add array of sales for that day
            // // stock_codes[ sales_numbers ] = 0;
            // stock_codes.sales  = salesdata[i].sales;
            // stock_codes.onhand  = salesdata[i].onhand;
        // }

        // stock_codes[ count ] += 1;
        // stock_codes[ sales_numbers ] = 0;
        // stock_codes[ barcode ] += salesdata[i].sales;

     }
    //  console.log(stock_codes);
    //  console.log(nettSales);
     total_sales =  Number(total_sales);
     nettSales =  Number(nettSales);

     document.getElementById("total_sales").innerHTML = total_sales.toLocaleString('en-US');
     document.getElementById("nettsales").innerHTML = nettSales.toLocaleString('en-US');

    yValues = Object.values(sales);
    console.log(sales);
 
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
 
// const { createApp } = Vue;
//       //  let
//       createApp({
//         data() {
//           return {
//             // 
//             products: [], 

//           }          
//         },
//        async created() {
//             let response = await  await axios.get("{{route('get_products')}}");
//             let data = await response.data;
 
//             for (let i = 0; i < data.length; i++) {
//                 this.products.push(data[i]);
//              }
//             console.log(this.products);
//         },
//         methods:
//         {
//             toDecimal: function(num) 
//             {
//                 number = Number.parseFloat(num)
//                 return number.toFixed(2);
//             }


//         }
//    }).mount("#app");
    </script>
</x-app-layout>
