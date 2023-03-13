<x-app-layout>
  <style>
      a:hover {
          text-decoration: none;
      }
  </style>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> --}}
  <main class="m-0  px-4 py-5 w-100" id="app" v-cloak>

      {{-- <form action="{{ route('store') }}" method="GET" class="d-flex justify-content-between shadow rounded   py-0 pt-3 mb-3 w-100">
          <div class="d-flex"> 
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
                  <button type="submit" class="btn btn-sm btn-outline-info"> Prepare </button>
              </div>
          </div>
         
      </form> --}}
    
 
  {{-- <hr> --}}
  <div class="ow border rounded p-3 w-100 pb-5">
<p class="font-weight-bold h4">
    {{$selected_store->name}} &nbsp; &nbsp; Stock Analysis
</p> 
<table class="table table-striped table-inverse table-responsive"  style="height: 500px;">
  <thead class="thead-inverse">
      <tr class="bg-dark text-light rounded font-weight-bold">
          <th>#</th>
          <th>Barcode</th>
          <th>Description</th>
          <th>AVR Cost</th>
          <th>Sell Price</th>
          <th>Stock Value</th>
          {{-- <th>OnHand Value</th> --}}
          <th>AVR RR</th>
          <th>DOH</th>
          <th>Margin</th>
          {{-- <th>Nett Sales</th> --}}
       </tr>
      </thead>
      <tbody>
            <tr v-for="product,i in products" if="product.days_onhand" >

              <td scope="row">@{{i + 1}}</td>
              <td> @{{product.barcode}}</td>
              <td>@{{product.descript}}</td>
              <td>R@{{toDecimal(product.avrgcost).toFixed(2)}}</td>
              <td>R@{{toDecimal(product.sellpinc1).toFixed(2)}}</td>
              <td>R@{{toDecimal(product.stock_value.toFixed(2))}}</td>
              <td>R@{{toDecimal(product.avr_rr.toFixed(2))}}</td>
              <td>@{{product.days_onhand.toFixed(0) }} days</td>
              <td class="text-success">@{{ toDecimal( 100 - (toDecimal(product.avrgcost ) / toDecimal(product.sellpinc1)  * 100 )).toFixed(2) }}%</td>           
              {{-- <td v-if="(product.avrgcost * product.onhand) <= 0 " class="text-danger ">R@{{toDecimal(toDecimal(product.avrgcost) * toDecimal(product.onhand)) }}</td>
              <td v-else class="text-success  ">R@{{toDecimal(toDecimal(product.avrgcost) * toDecimal(product.onhand)) }}</td>

              <td v-if="product.onhand < 1 " class="text-danger font-weight-bold">@{{product.onhand}}</td>
              <td v-else class="text-success font-weight-bold">@{{product.onhand}}</td>  --}}  
              
              {{-- <td>@{{product.nett_sales}}</td> --}}
              {{-- <td>@{{product.created_at}}</td> --}}  
            </tr>
       </tbody> 
</table>
  </div>
  </main>
  <input type="hidden" name="" id="products" value="{{$products}}">
  <input type="hidden" name="" id="stock_analysis" value="{{$stock_analysis}}">
  <input type="hidden" name="" id="selected_store" value="{{$selected_store->storeID}}">
  <script>

const { createApp } = Vue;
    createApp({
      data() {
        return { 
          products: [], 
        }          
      },
     async created() { 

        let products = JSON.parse( document.getElementById("products").value );
        let stock_analysis = JSON.parse( document.getElementById("stock_analysis").value );
        // let stores_only = JSON.parse( document.getElementById("stores").value );
 
            let total_sales = 0; let items = []; let stock = [];   let codes = []; let itemCodes = []; let store_data = [];

            for (let i = 0; i < stock_analysis.length; i++) {
 
                let code = stock_analysis[i].code;

              if (!codes.includes(code)) {
                    items[ code ] = [];   // add array of sales for this code
                    codes.push(code);
                    items[ code ]['nett_sales'] = 0
                    items[ code ]['department'] = stock_analysis[i].department;
                    items[ code ]['code'] = code;
                    items[ code ]['invoices'] = 0
                    items[ code ]['purchases'] = 0                  
                }
                items[ code ]['invoices'] +=  this.toDecimal(stock_analysis[i].invoices)
                items[ code ]['purchases'] +=  this.toDecimal(stock_analysis[i].purchases)
                items[ code ]['nett_sales'] +=  this.toDecimal(stock_analysis[i].nettSales )
             }
                  
            ////////////////////////////////////////////////////////////////////////////////////
             for (let x = 0; x < products.length; x++) {
                let code = products[x].barcode;
 
                if (code in items) {
                      products[x].nett_sales = items[code]['nett_sales']
                      products[x].department = items[code]['department']
                      products[x].invoices = items[code]['invoices'] 
                      products[x].purchases = items[code]['purchases']
                }else{
                      products[x].nett_sales = 0
                      products[x].invoices = 0 
                      products[x].purchases = 0
                }

                products[x].avr_rr = this.toDecimal(products[x].nett_sales) / 3;
                products[x].stock_value = (this.toDecimal(products[x].avrgcost) * Number(products[x].onhand));
                products[x].days_onhand = ( products[x].stock_value / products[x].avr_rr) * 25;

                // if(!isNaN(products[x].avr_rr)){
                //   products.splice(x, 1)
                // }

              }

             let allProducts = products.filter(function (el) { return el.days_onhand && isFinite(el.days_onhand) });

              // console.log(products); 

              this.products = [ ...allProducts ] 

              

      },
      methods:
      {
          toDecimal: function(num)
          {
            let number = num.toString()
              number = number.replace(/,/g, "");
              number = Number.parseFloat(number)
              return number//.toFixed(2); 
          }
      }
 }).mount("#app");
 
  </script>
</x-app-layout>
