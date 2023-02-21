<x-app-layout>
    <style>
        a:hover {
            text-decoration: none;
        }
     
    </style>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> --}}
    <main class="m-0  px-4 w-100" id="app" >
        <section v-cloak>
            
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
                 
                <div class="  ">
                    <button type="submit" class="btn btn-sm btn-outline-info"> Filter </button>
                </div>
            </div>
           
        </form>
      
    <div class="row  border rounded p-3 w-100">
         
        <div class="col-md-6 " title=" Click see detailed Stock Data"  v-for="store,i in stores_data">
             <a href="{{ route('store') }}" class="w-100 row  rounded text-dark shadow px-2 py-1 border border-danger">
                <div class=" border-right col-md-6 d-flex flex-column">
                    <span class="font-weight-bold ">@{{store.name.replace('Tembisa','')}} <span>Sales</span> </span> 
                    <span class="font-weight-bold h5"> R@{{store.nett_sales.toLocaleString('en-US')}} </span>
                    <span class="small ">{{$dates['from']}} - {{$dates['to']}}</span>
               </div>
               <div class=" border-left col-md-6 d-flex flex-column">
                    <span class="font-weight-bold ">@{{store.name.replace('Tembisa','')}} <span>Sales + VAT</span> </span> 
                    <span class="font-weight-bold h5"> R@{{(store.nett_sales + store.vat).toLocaleString('en-US')}} </span>
                    <span class="small ">{{$dates['from']}} - {{$dates['to']}}</span>
               </div> 
             </a>
        </div> 
    
    </div>
    <hr>
    
    <div class="ow border rounded p-3 w-100">
<p class="font-weight-bold h4">
   All Stores Data
</p>
<table class="table table-striped table-inverse table-responsive"  style="height: 500px;">
    <thead class="thead-inverse">
        <tr>
 
            <th>#</th>
            <th>Store Name</th>
            <th>On Hand</th>
            <th>OOS</th>
            <th>OOS Value</th>
            <th>Sock Value</th>
            <th>Sales</th>
            <th>Nett Sales</th>
            <th>VAT</th>
            <th>VAT Inclusive</th>
         </tr>
        </thead>
        <tbody> 
              <tr v-for="store,i in all_stores_data" class="font-weight-bold"> 
                <td class="font-weight-bold" scope="row">@{{i + 1}}</td>
                <td class="font-weight-bold" v-if="store[0] !== undefined"><a href='{{ route('store', ['store[0].storeID'])}}'> @{{store[0].name}}</td>          <td class="font-weight-bold" v-else>  N/A </td>
                <td class="font-weight-bold" v-if="store[1] !== undefined">@{{store[1].soh}}</td>        <td class="font-weight-bold text-danger" v-else> N/A </td>
                <td class="font-weight-bold" v-if="store[1] !== undefined">@{{store[1].oos}}</td>        <td class="font-weight-bold text-danger" v-else> N/A </td>
                <td class="font-weight-bold text-danger" v-if="store[1] !== undefined">R@{{store[1].oosv.toLocaleString('en-US')}}</td>      <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold" v-if="store[1] !== undefined">R @{{store[1].stock_value.toLocaleString('en-US')}}</td> <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold" v-if="store[0] !== undefined">R @{{store[0].sales.toLocaleString('en-US')}}</td>      <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold text-info" v-if="store[0] !== undefined">R @{{store[0].nett_sales.toLocaleString('en-US')}}</td> <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold" v-if="store[0] !== undefined">R @{{store[0].vat.toLocaleString('en-US')}}</td> <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold text-success" v-if="store[0] !== undefined">R @{{(store[0].nett_sales + store[0].vat).toLocaleString('en-US')}}</td> <td class="font-weight-bold text-danger" v-else> N/A </td> 
                         
            </tr>
         </tbody> 
</table>
    </div>
        </section>
    </main>
    <input type="hidden" name="" id="products_data" value="{{$products_data}}">
    <input type="hidden" name="" id="sales_data" value="{{$sales_data}}">
    <input type="hidden" name="" id="stores" value="{{$stores}}">
    <script>
  
  const { createApp } = Vue;
      createApp({
        data() {
          return {
            top_products: [],
            stores_data: [],
            all_stores_data: [],
          }          
        },
       async created() {

        let products_data = JSON.parse( document.getElementById("products_data").value );
        let sales_data = JSON.parse( document.getElementById("sales_data").value );
        let stores_only = JSON.parse( document.getElementById("stores").value );
 
             let total_sales = 0; let stores = [];   let storeIDs = []; let storesIDs = []; let store_data = [];

            for (let i = 0; i < sales_data.length; i++) {
                
                let storeID = sales_data[i].storeID;
                // console.log(sales_data[i])
                if (!storeIDs.includes(storeID)) {
                    stores[ storeID ] = [];   // add array of sales for that day
                    storeIDs.push(storeID);
                    stores[ storeID ]['nett_sales'] = 0
                    stores[ storeID ]['sales'] = 0
                    stores[ storeID ]['vat'] = 0
                    stores[ storeID ]['storeID'] = storeID;
 
                    // add store name
                    for (let x = 0; x < stores_only.length; x++) { 
                           if (stores_only[x].storeID == storeID) {
                            stores[ storeID ]['name'] = stores_only[x].name
                         } 
                    }
                }
                if (storeID == 18) {
                    console.log(sales_data[i])
                }
                stores[ storeID ]['nett_sales'] += this.toDecimal(sales_data[i].nettSales)
                stores[ storeID ]['sales'] += this.toDecimal(sales_data[i].sales)
                stores[ storeID ]['vat'] += this.toDecimal(sales_data[i].vat)
             }
             this.stores_data = [ ...stores ]
             this.stores_data = this.stores_data.filter( Boolean )
             console.log(stores)
             ////////////////////////////////////////////////////////////////////////////////////
             for (let x = 0; x < products_data.length; x++) {
                let id = products_data[x].storeID;
                 if (!storesIDs.includes(id)) {
                    store_data[ id ] = [];   // add array of sales for that day
                    storesIDs.push(id);
                    store_data[ id ]['stock_value'] = 0
                    store_data[ id ]['oos'] = 0
                    store_data[ id ]['oosv'] = 0
                    // store_data[ id ]['stock'] = 0
                    store_data[ id ]['soh'] = 0; 
                }
                store_data[ id ]['soh'] += parseInt(products_data[x].onhand);
                store_data[ id ]['stock_value'] +=  parseInt( products_data[x].onhand) * this.toDecimal( products_data[x].avrgcost);
                // store_data[ id ]['stock'] += 1;
                let oos = parseInt( products_data[x].onhand) ;
                if (oos <= 0) {
                    store_data[ id ]['oos'] += 1;
                    store_data[ id ]['oosv'] += parseInt( products_data[x].onhand) * this.toDecimal( products_data[x].avrgcost);
                }                             
             }
 
            let all_stores_data = []
             for (let y = 0; y < stores_only.length; y++) {
                
                 let st_data = [ ...[ stores[stores_only[y].storeID]], ...[ store_data[stores_only[y].storeID]]];
      
                  all_stores_data.push(st_data)
                // console.log(st_data )
               }

               this.all_stores_data = [... all_stores_data]
               
              console.log(this.all_stores_data);   
            //   console.log(stores_only);   
            // console.log(stores);   
            //  console.log(store_data);   
             ////////////////
        },
        methods:
        {
            toDecimal: function(num)
            {
                let number = num.replace(/,/g, "");
                    number = Number.parseFloat(number)
                return number; 
            }
        }
   }).mount("#app");
  
    </script>
</x-app-layout>
