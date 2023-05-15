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
   
    </style>
     <main class="m-0  px-4 pb-5 pt-3 w-100" id="app" v-cloak>
    
    
    {{-- <div class="row border rounded p-3 w-100">
         
      <div class="col-md-4 mx-0 " title=" Click see detailed Stock Data">
           <a href="#" class="card text-dark shadow px-2 py-1 border border-info">
              <span class="font-weight-bold ">Out of stock Value  </span>
              <span class="font-weight-bold h5 text-center text-danger"> R<span id="oosv">@{{ toDecimal(total_oosv.toFixed(2)).toLocaleString('en-US')}}</span> </span>
            </a>
      </div>
      <div class="col-md-4 mx-0 " title="Click see detailed Stock Data">
          <a href="#" class="card text-dark shadow px-2 py-1 border border-info">
              <span class="font-weight-bold ">Stock Value </span> 
              <span class="font-weight-bold h5 text-center"> R <span id="stock_value">@{{  toDecimal(total_sohv.toFixed(2)).toLocaleString('en-US')}}</span> </span>
            </a>
      </div>
      
      <div   class="col-md-4 py-0">
        <label class="d-flex flex-column justify-content-center card text-dark shadow px-2 py-1 border border-info"> 
         <div class="form-group  border-bottom"> 
            <select class="custom-select border-0 border-bottom" name="store" onchange=" window.location.href = this.value;">
             <option value="" selected disabled>Select to Change Store</option>
               @foreach ($stores as $store)
                    <option class="font-weight-bold" value="{{ route('stock_analysis', [$store->storeID] ) }}">{{$store->name}}</option>
               @endforeach
            </select>
         </div>
        </label>
       
       </div>
      
  </div>
  <hr>
   --}}
    <div class=" shadow rounded row mb-3 p-2">
    <div class=" col-md-3  "> 
      <input type="search" name="" class="form-control rounded  " placeholder="Search by product name" id="search" v-model="searchtext" v-on:keyup="searchFun($event)">
    </div>
    <div class="border rounded">
      <div class="form-group rounded overflow-auto   row   p-0 m-0">
        <div class="col-md-6">
            <input type="month" name="" id="" v-model="report_date" class="form-control" placeholder="">
        </div>
        <div class="col-md-6 pt-auto">
            <a @click="change_date()" class="btn btn-sm rounded py-2 form-control m-0  font-weight-bold btn-outline-grey border border-info ">  change Month </a>
        </div>
      </div>
    </div>
    <div class="col-md-4  d-flex justify-content-end">
  
       <a href="#" class="btn float-end btn-sm rounded font-weight-bold btn-outline-info" @click="get_csv()">download stock analysis</a>
    </div>
    </div>
    <div class=" d-flex justify-content-between  rounded w-100 pt-2 m-0">
        <div class="font-weight-bold h4 P-0">
            {{$selected_store->name}} &nbsp; &nbsp; Stock Analysis
        </div> 
        <div class=" font-weight-bold pr-5 h4">
          {{date("M", strtotime($date))}}
          {{date("Y", strtotime($date))}}
         </div>
    </div>
  
  <div class="tableFixHead  w-100" style="height: 500px;">
    <table class="table table-striped  border table-inverse  w-100"  style="height: 500px;">
    <thead class="thead-inverse rounded">
        <tr class="border font-weight-bold shadow bg-dark text-light rounded ">
          <th>#</th>
          <th></th>
            
            <th>Description</th>
          
            <th>Cost Price</th>
            <th>Sell Price</th>
            <th>Revenue</th>

            <th>Contr to Revenue</th>
            <th>Average GP</th>
             
         </tr>
        </thead>
        <tbody>
          <tr v-if="products.length < 1">
              <td colspan="10">
                <div class="">
                  <p class="h5 i text-muted text-center">No Data Available!!!...</p>
                </div>
              </td>
          </tr>
              <template  v-for="product,i in products" :key="i"> 
                {{-- categories --}}
                 
                <tr class="text-uppercase categories accordion-toggle"
                   :data-target="'#ID'+i">
                    <td class="category-row"> @{{i+1}}.</td>
                    <td></td>
                     <td colspan="3" scope="row" class="bg-black   category-row" ><b class="">@{{product.category}}</b></td>
                   
                    {{-- <td scope="row" class="category-row">R@{{product.tot_SV.toFixed(2)}}</td>  total_nett_sales contribution --}}
                    <td scope="row" class="category-row">R@{{product.nett_sales.toFixed(2) }}</td>
                    <td scope="row" class="category-row">@{{((product.nett_sales/total_nett_sales)*100).toFixed(2)}}%</td>
                    <td scope="row" class="category-row" >R@{{product.avr_gp.toFixed(0)  }} </td>
                 </tr>
                <tr v-for="item,x in product.items"  >  
                  {{-- <td> @{{x+1}}</td> --}}
                  <td></td>
                  <td> @{{item.barcode}}</td>
                  <td>@{{item.descript}}</td>
                  {{-- nettSales --}}
                  <td>R@{{toDecimal(item.avrgcost).toFixed(2)}}</td>
                  <td>R@{{toDecimal(item.sellpinc1).toFixed(2)}}</td>
                  <td>R@{{toDecimal(item.nettSales).toFixed(2)}}</td>
                  <td>@{{((toDecimal(item.nettSales)/total_nett_sales)*100).toFixed(2)}}%</td>
                  <td>R@{{ toDecimal(item.profit) }}</td> 
                  {{-- <td>R@{{toDecimal(item.nett_sales.toFixed(2))}}</td> --}}
                  {{-- <td>R@{{toDecimal(item.avr_rr.toFixed(2))}}</td> --}}
                  {{-- <td>@{{item.days_onhand.toFixed(0) }} days</td> --}}
                  {{-- <td class="text-success">@{{ toDecimal( 100 - (toDecimal(item.avrgcost ) / toDecimal(item.sellpinc1)  * 100 )).toFixed(2) }}%</td> --}}
                </tr> 
              </template>
              <br> 
         </tbody> 
  </table>
  
  </div>
    </div>
     
    </main> 
    <input type="hidden" name="" id="stock_analysis" value="{{$stock_analysis}}">
    <input type="hidden" name="" id="month" value="{{date("m", strtotime($date))}}">
    <script>
  
  const { createApp } = Vue;
      createApp({
        data() {
          return { 
            raw_products_data: [],
            products: [],
            productsDB: [], 
            searchtext: "",
            doh_search: "",
            total_sohv: 0,
            total_oosv: 0,
            total_oosv: 0,
            total_nett_sales: 0,
            // date: 0,
          }          
        },
       async created() { 
  
          let products = document.getElementById("stock_analysis").value ;
        //   let stock = await  await axios.get("{{route('get_stock_analysis', $selected_store->storeID)}}");
        products = JSON.parse(products)

        function compare( a, b ) {
            if ( a.descript.toLowerCase() < b.descript.toLowerCase() ){
                return -1;
            }
            if ( a.descript.toLowerCase() > b.descript.toLowerCase() ){
                return 1;
            }
            return 0;
        }

products = await products.sort(compare); 

        // console.log(products) 
        //  console.log( categories)
        this.products = await [ ...Object.values(this.create_categories(products))]
        console.log(Object.values(this.create_categories(products))) 

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
            change_date: function( )
            {
                let current_url = window.location.href.replace(/mabebeza.*/,'');
                location.href = current_url+"mabebeza/18/"+this.report_date;                
            },
            // create categories to display data on table 
            create_categories: function(products){
               
               let categories = []; let categoryIDs = [];  let total_oosv = 0; let total_nett_sales = 0;
                for (let y = 0; y < products.length; y++) {
   
                  let category = products[y].descript.toLowerCase();
                      category = category.split(' ');
                      products[y].category = category[0]+" "+category[1];
                      
                  let catID = products[y].category;
                  
                  if (!categoryIDs.includes(catID)) {
                    categories[ catID ] = [];   // add array of sales for this code
                    categoryIDs.push(catID);
                //     // categories[ catID ]['tot_SV'] = 0;
                    categories[ catID ]['items'] = [];  
                    categories[ catID ]['category'] = catID;  
                    // categories[ catID ]['total_nett_sales'] = catID;  
                    categories[ catID ]['nett_sales'] = 0;
                    categories[ catID ]['contribution'] = 0;    
                    categories[ catID ]['avr_gp'] = 0;  
                //     // categories[ catID ]['DOHs'] = [];  
                  }
                //   console.log(products[y].nettSales);
        
                categories[ catID ]['nett_sales'] += this.toDecimal(products[y].nettSales);  
                categories[ catID ]['contribution'] += this.toDecimal(products[y].nettSales);  
                categories[ catID ]['avr_gp'] += this.toDecimal(products[y].profit);  
                // //   categories[ catID ]['avr_rr'] = this.toDecimal(categories[ catID ]['nett_sales']) / 3;  
                // //   categories[ catID ]['tot_SV'] += Number(products[y].onhand) * this.toDecimal(products[y].avrgcost);
                // //   categories[ catID ]['DOH'] = ( this.toDecimal(categories[ catID ]['tot_SV']) / this.toDecimal(categories[ catID ]['avr_rr'])) * 25; //Math.max( ...categories[ catID ]['DOHs'] )  
                  categories[ catID ]['items'].push(products[y]);
                total_nett_sales += this.toDecimal(products[y].nettSales);
                this.total_nett_sales = total_nett_sales;
                }
                // console.log(total_sohv,total_oosv); 
                 return  categories;
            },
  
            titleCase: function(str) {
                var splitStr = str.toLowerCase().split(' ');
                for (var i = 0; i < splitStr.length; i++) {
                     // Assign it back to the array
                    splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
                }
                // Directly return the joined string
                return splitStr.join(' '); 
            }
            
  
        }
   }).mount("#app");
   
    </script>
  </x-app-layout>
               
  