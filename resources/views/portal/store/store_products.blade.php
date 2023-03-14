<x-app-layout>
  <style>
      a:hover {
          text-decoration: none;
      }
      .categories{
        background-color: rgb(59, 59, 59)  !important;
        color: aliceblue  !important;
        font-size: 900px !important;
      }

      .tableFixHead          { overflow: auto !important;    }
      .tableFixHead thead th { position: sticky !important; top: 0 !important; z-index: 1 !important;background-color: rgb(37, 37, 37)  !important; }

       table  { border-collapse: collapse; width: 100% !important; }
      th, td { padding: 8px 16px; }
      /* th     { background:#eee; }  */

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
<div class="tableFixHead">
  <table class="table table-striped table-inverse table-responsive "  style="height: 500px;">
  <thead class="thead-inverse">
      <tr class="bg-dark text-light rounded font-weight-bold">
          <th>#</th>
          <th>Barcode</th>
          <th>Description</th>
          <th>AVR Cost</th>
          <th>Sell Price</th>
          <th>Stock Value</th>
          <th>Nett Sales</th>
          <th>AVR RR</th>
          <th>DOH</th>
          <th>Margin</th>
          {{-- <th>Nett Sales</th> --}}
       </tr>
      </thead>
      <tbody>
            <template  v-for="product,i in products" :key="i">
              {{--  v-if="keyExists(product, product.barcode)" --}}
              
              <tr class="text-uppercase categories">
                  <td></td>
                  <td></td>
                  <td scope="row" class="bg-black   category-row" ><b class="">@{{product.category}}</b></td>
                  <td></td>
                  <td></td>
                  <td scope="row">R@{{product.tot_SV.toFixed(2)}}</td>
                  <td scope="row">R@{{product.nett_sales.toFixed(2) }}</td>
                  <td scope="row">R@{{(product.avr_rr).toFixed(2)}}</td>
                  <td scope="row">@{{product.DOH.toFixed(0) }} Days</td>
                  <td></td>
              </tr>
              <tr v-for="item,x in product.items">
                  
                <td> @{{x+1}}</td>
                <td> @{{item.barcode}}</td>
                <td>@{{item.descript}}</td>
              <td>R@{{toDecimal(item.avrgcost).toFixed(2)}}</td>
              <td>R@{{toDecimal(item.sellpinc1).toFixed(2)}}</td>
              <td>R@{{toDecimal(item.stock_value.toFixed(2))}}</td>
              <td>R@{{toDecimal(item.nett_sales.toFixed(2))}}</td>
              <td>R@{{toDecimal(item.avr_rr.toFixed(2))}}</td>
              <td>@{{item.days_onhand.toFixed(0) }} days</td>
              <td class="text-success">@{{ toDecimal( 100 - (toDecimal(item.avrgcost ) / toDecimal(item.sellpinc1)  * 100 )).toFixed(2) }}%</td>           
              
              {{-- <td v-if="(product.avrgcost * product.onhand) <= 0 " class="text-danger ">R@{{toDecimal(toDecimal(product.avrgcost) * toDecimal(product.onhand)) }}</td>
              <td v-else class="text-success  ">R@{{toDecimal(toDecimal(product.avrgcost) * toDecimal(product.onhand)) }}</td>

              <td v-if="product.onhand < 1 " class="text-danger font-weight-bold">@{{product.onhand}}</td>
              <td v-else class="text-success font-weight-bold">@{{product.onhand}}</td>  --}}  
              
              {{-- <td>@{{product.nett_sales}}</td> --}}
              {{-- <td>@{{product.category}}</td>   --}}
              </tr> 
            </template>
            <br>
          
       </tbody> 
</table>
</div>
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

                let category = products[x].descript.toLowerCase();
                    category = category.split(' ');
                    products[x].category = category[0]+" "+category[1];
                    products[x].avr_rr = this.toDecimal(products[x].nett_sales) / 3;
                    products[x].stock_value = (this.toDecimal(products[x].avrgcost) * Number(products[x].onhand));
                    products[x].days_onhand = ( products[x].stock_value / products[x].avr_rr) * 25;

                // if(!isNaN(products[x].avr_rr)){
                //   products.splice(x, 1)
                // }

              }

             let allProducts = products.filter(function (el) { return el.days_onhand && isFinite(el.days_onhand) });


                  function compare( a, b ) {
                    if ( a.category < b.category ){
                      return -1;
                    }
                    if ( a.category > b.category ){
                      return 1;
                    }
                    return 0;
                  }
 
              allProducts = allProducts.sort(compare);

              let categories = []; let categoryIDs = [];
              for (let y = 0; y < allProducts.length; y++) {

                let catID = allProducts[y].category;
                
                if (!categoryIDs.includes(catID)) {
                  categories[ catID ] = [];   // add array of sales for this code
                  categoryIDs.push(catID);
                  categories[ catID ]['tot_SV'] = 0;
                  categories[ catID ]['items'] = [];  
                  categories[ catID ]['category'] = catID;  
                  categories[ catID ]['nett_sales'] = 0;  
                  categories[ catID ]['avr_rr'] = 0;  
                  categories[ catID ]['DOHs'] = [];  
                  categories[ catID ]['DOH'] = 0;  
                }
  
                categories[ catID ]['nett_sales'] += this.toDecimal(allProducts[y].nett_sales);  
                categories[ catID ]['avr_rr'] = this.toDecimal(categories[ catID ]['nett_sales']) / 3;  
                categories[ catID ]['tot_SV'] += Number(allProducts[y].onhand) * this.toDecimal(allProducts[y].avrgcost);
                categories[ catID ]['DOH'] = ( this.toDecimal(categories[ catID ]['tot_SV']) / this.toDecimal(categories[ catID ]['avr_rr'])) * 25; //Math.max( ...categories[ catID ]['DOHs'] )  
                categories[ catID ]['items'].push(allProducts[y]);
                
              }

              console.log(Object.values(categories)); 
              this.products = [ ...Object.values(categories) ]  

      },
      methods:
      {
          toDecimal: function(num)
          {
            let number = num.toString()
              number = number.replace(/,/g, "");
              number = Number.parseFloat(number)
              return number//.toFixed(2); 
          },
          titleCase: function(str) {
              var splitStr = str.toLowerCase().split(' ');
              for (var i = 0; i < splitStr.length; i++) {
                  // You do not need to check if i is larger than splitStr length, as your for does that for you
                  // Assign it back to the array
                  splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
              }
              // Directly return the joined string
              return splitStr.join(' '); 
          },
          keyExists(obj, key) {
              return key in obj;
          }
      }
 }).mount("#app");
 
  </script>
</x-app-layout>
