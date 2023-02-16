<x-app-layout>
    <style>
        a:hover {
            text-decoration: none;
        }
     
    </style>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> --}}
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
                    <span class="font-weight-bold h5"> R@{{store.sales.toLocaleString('en-US')}} </span>
                    <span class="small ">{{$dates['from']}} - {{$dates['to']}}</span>
               </div>
               <div class=" border-left col-md-6 d-flex flex-column">
                    <span class="font-weight-bold ">@{{store.name.replace('Tembisa','')}} <span>NettSales</span> </span> 
                    <span class="font-weight-bold h5"> R@{{store.nett_sales.toLocaleString('en-US')}} </span>
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
            <th>Store</th>
            <th>On Hand</th>
            <th>OOS</th>
            <th>Stock</th>
            <th>Sock Value</th>
            <th>Sales</th>
            <th>Nett Sales</th>
            <th>VAT</th>

             {{-- <th>Created At</th> --}}
         </tr>
        </thead>
        <tbody> 
              <tr v-for="store,i in all_stores_data" class="font-weight-bold"> 
                <td class="font-weight-bold" scope="row">@{{i + 1}}</td>
                <td class="font-weight-bold" v-if="store[0] !== undefined"><a href='{{ route('store', ['store[0].storeID'])}}'> @{{store[0].name}}</td>          <td class="font-weight-bold" v-else>  N/A </td>
                <td class="font-weight-bold" v-if="store[1] !== undefined">@{{store[1].soh}}</td>        <td class="font-weight-bold text-danger" v-else> N/A </td>
                <td class="font-weight-bold" v-if="store[1] !== undefined">@{{store[1].oos}}</td>        <td class="font-weight-bold text-danger" v-else> N/A </td>
                <td class="font-weight-bold" v-if="store[1] !== undefined">@{{store[1].stock}}</td>      <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold" v-if="store[1] !== undefined">R @{{store[1].stock_value.toLocaleString('en-US')}}</td> <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold" v-if="store[0] !== undefined">R @{{store[0].sales.toLocaleString('en-US')}}</td>      <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold" v-if="store[0] !== undefined">R @{{store[0].nett_sales.toLocaleString('en-US')}}</td> <td class="font-weight-bold text-danger" v-else> N/A </td> 
                <td class="font-weight-bold" v-if="store[0] !== undefined">R @{{store[0].vat.toLocaleString('en-US')}}</td> <td class="font-weight-bold text-danger" v-else> N/A </td> 
                         
            </tr>
         </tbody> 
</table>
    </div>
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
                    store_data[ id ]['stock'] = 0
                    store_data[ id ]['soh'] = 0; 
                }
                store_data[ id ]['soh'] += parseInt(products_data[x].onhand);
                store_data[ id ]['stock_value'] +=  parseInt( products_data[x].onhand) * this.toDecimal( products_data[x].avrgcost);
                store_data[ id ]['stock'] += 1;
                let oos = parseInt( products_data[x].onhand) ;
                if (oos <= 0) {
                    store_data[ id ]['oos'] += 1;
                }                             
             }

            //  stores = stores.filter( Boolean )
            //  store_data = store_data.filter( Boolean )

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

//    OnHandAvail 
// active 
// avrgcost 
// barcode 
// created_at 
// department 
// descript 
// discription 
// name
// : 
// "Stokkafela Tembisa"
// onhand
// : 
// "0"
// planID
// : 
// 1
// productID
// : 
// 2935
// sellpinc1
// : 
// "0"
// sellprice1
// : 
// null
// slogan
// : 
// null
// storeID
// : 
// 17
// trading_name
// : 
// "Stokkafela 01"
// updated_at
// : 
// "2023-01-26 11:56:16"
// userID
// : 
// 7

    // //  Charts.js start    
    // let salesdata = JSON.parse(document.getElementById("salesdata").value);
    // console.log('salesdata')
    // console.log(salesdata)
    // console.log('salesdata')
    // let xValues  = []; let yValues = [];  let sales = [];
    // let total_sales = 0;
    // let nettSales = 0;
    // let stock_codes = [];
    // let stock = [];
 
    // for (let i = 0; i < salesdata.length; i++) {
 
    //     let date = salesdata[i].from.substring(0, 10)
    //     let barcode = salesdata[i].barcode
    //     let sale = number(salesdata[i].sales);
    //     let nettsale = number(salesdata[i].nettSales);

    //     // add days if not exist
    //     if (!xValues.includes(date)) {
    //         sales[ date ] = 0;   // add array of sales for that day
    //         xValues.push(date);
    //     }

    //     sales[ date ] += nettsale;  // add nettsales for each day;
    //     total_sales += sale;    // add each sale

    //     // don't add negetive nettsales 
    //     if ( nettsale > 0) {
    //         nettSales += nettsale;
    //     }
    //  }

    //  total_sales =  Number(total_sales);
    //  nettSales =  Number(nettSales) + Number(nettSales * 0.15);  // add 15% VAT

    //  document.getElementById("total_sales").innerHTML = total_sales.toLocaleString('en-US');
    //  document.getElementById("nettsales").innerHTML = nettSales.toLocaleString('en-US');

    // yValues = Object.values(sales);
  
 
 
    </script>
</x-app-layout>
