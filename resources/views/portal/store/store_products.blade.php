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
 
  <div class="shadow rounded d-flex justify-content-between mb-3  px-2 py-1">
    <div class="d-flex justify-content-between   w-100 mr-5">
      <div class="form-group">
        <label for="" class="font-weight-bold">Stock Value</label>
        <select class="form-control" name="" @change="filter_stock_value($event)" >
          <option selected disabled>Select</option>
          <option value="low"> From Law</option>
          <option value="high">From High</option>
          <option value="zero">With Zero</option>
        </select>
      </div>

      <div class="form-group">
        <label for="" class="font-weight-bold">Nett Sales</label> 
        <select class="form-control" name="" @change="filter_nett_sales($event)">
          <option selected disabled>Select</option>
          <option value="low"> From Law</option>
          <option value="high">From High</option>
          <option value="zero">With Zero</option>
        </select>
      </div>

      <div class="form-group">
        <label for="" class="font-weight-bold">AVR RR</label>
        <select class="form-control" name="" @change="filter_avr_rr($event)">
          <option selected disabled>Select</option>
          <option value="low"> From Law</option>
          <option value="high">From High</option>
          <option value="zero">With Zero</option>
        </select>
      </div>

      <div class="form-group">
        <label for="" class="font-weight-bold">Days onHand</label>
        <select class="form-control" name="" @change="filter_days_onhand($event)">
          <option selected disabled>Select</option>
          <option value="low"> From Law</option>
          <option value="high">From High</option>
          <option value="zero">With Zero</option>
        </select>
      </div>
    </div>

    <div   class="d-flex flex-column justify-content-center ">
     <div class="d-flex fle"> 
      <div class="form-group "> 
        <label for="" class="font-weight-bold">Change Store</label>
        <select class="custom-select" name="store" onchange=" window.location.href = this.value;">
          <option value="" selected disabled>Select Store</option>
            @foreach ($stores as $store)
                 <option class="font-weight-bold" value="{{ route('stock_analysis', [$store->storeID] ) }}">{{$store->name}}</option>
            @endforeach
         </select>
      </div>
     </div>
    
    </div>

  </div>
  <div class=" shadow rounded row mb-3 p-2">
  <div class=" col-md-6  "> 
    <input type="search" name="" class="form-control rounded  " placeholder="Search by product name" id="search" v-model="searchtext" v-on:keyup="searchFun($event)">
  </div>
  <div class="col-md-6  d-flex justify-content-end">

    <a href="#" class="btn float-end btn-sm rounded font-weight-bold btn-outline-success" @click="clear_filters()">clear All Filters</a>
    <a href="#" class="btn float-end btn-sm rounded font-weight-bold btn-outline-info" @click="get_csv()">download stock analysis</a>
  </div>
  </div>
  <div class="ow border rounded p-3 w-100 pb-5">
<p class="font-weight-bold h4 P-0">
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
       </tr>
      </thead>
      <tbody>
            <template  v-for="product,i in products" :key="i">
               
              <tr class="text-uppercase categories accordion-toggle"
                 :data-target="'#ID'+i">
                  <td class="category-row"> @{{i+1}}.</td>
                  <td></td>
                  <td scope="row" class="bg-black   category-row" ><b class="">@{{product.category}}</b></td>
                  <td></td>
                  <td></td>
                  <td scope="row" class="category-row">R@{{product.tot_SV.toFixed(2)}}</td>
                  <td scope="row" class="category-row">R@{{product.nett_sales.toFixed(2) }}</td>
                  <td scope="row" class="category-row">R@{{(product.avr_rr).toFixed(2)}}</td>
                  <td scope="row" class="category-row" >@{{product.DOH.toFixed(0) }} Days</td>
                  <td></td>
              </tr>
              <tr v-for="item,x in product.items"  >                  
 
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

              </tr> 
            </template>
            <br>
          
       </tbody> 
</table>
</div>
  </div>
  <hr>
  <div class="card p-3 mb-5">
    <p class="h3 font-weight-bold">Product Level Filter</p>
    <small class="muted"><i class="">Please Only use these filters when exporting data...</i></small>
    <hr>
        <a class="btn float-end btn-sm rounded font-weight-bold btn-outline-danger" @click="clear_filters()">clear All Filters</a>
<br>
        <div class="">
          <a class="btn float-end btn-sm rounded font-weight-bold btn-outline-grey" @click="clear_filters()">SOH <= 0</a>
          <a class="btn float-end btn-sm rounded font-weight-bold btn-outline-grey" @click="clear_filters()">SOH > 0</a>
          <a class="btn float-end btn-sm rounded font-weight-bold btn-outline-grey" @click="clear_filters()">avr rr <= 0</a>
          <a class="btn float-end btn-sm rounded font-weight-bold btn-outline-grey" @click="clear_filters()">avr rr > 0</a>
          <a class="btn float-end btn-sm rounded font-weight-bold btn-outline-grey" @click="filter_doh_perproduct('slow_moving')">Slow Moving Items</a>
        </div>
        <div class="my-3 border rounded p-2 ">
          <input type="number" name="DOH"  v-model="doh_search" class="form-control" placeholder="Enter Days on Hand"> 
          <button class="btn  btn-sm rounded font-weight-bold btn-outline-grey" @click="filter_doh_perproduct('less')">less</button>
          <button class="btn  btn-sm rounded font-weight-bold btn-outline-grey" @click="filter_doh_perproduct('greater')">greater</button>
          {{-- <button class="btn  btn-sm rounded font-weight-bold btn-outline-grey" @click="filter_doh_perproduct('equal')">equal</button> --}}
        </div>
  </div>
  </main> 
  <input type="hidden" name="" id="selected_store" value="{{$selected_store->storeID}}">
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
        }          
      },
     async created() { 

        let selected_store = document.getElementById("selected_store").value ;
        let stock = await  await axios.get("{{route('get_stock_analysis', $selected_store->storeID)}}");
        products = await stock.data;
        this.raw_products_data = products

           function compare( a, b ) {
                    if ( a.descript.toLowerCase() < b.descript.toLowerCase() ){
                      return -1;
                    }
                    if ( a.descript.toLowerCase() > b.descript.toLowerCase() ){
                      return 1;
                    }
                    return 0;
                  }
          products =  products.sort(compare);

          let categories = this.create_categories(products)

          this.products = [ ...Object.values(categories) ]  
          this.productsDB = [ ...Object.values(categories) ]  
          // console.log(this.productsDB);

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
          // create categories to display data on table 
          create_categories: function(products){
            
             let categories = []; let categoryIDs = [];
              for (let y = 0; y < products.length; y++) {

                let category = products[y].descript.toLowerCase();
                    category = category.split(' ');
                    products[y].category = category[0]+" "+category[1];
                    
                let catID = products[y].category;
                
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
              
                categories[ catID ]['nett_sales'] += this.toDecimal(products[y].nett_sales);  
                categories[ catID ]['avr_rr'] = this.toDecimal(categories[ catID ]['nett_sales']) / 3;  
                categories[ catID ]['tot_SV'] += Number(products[y].onhand) * this.toDecimal(products[y].avrgcost);
                categories[ catID ]['DOH'] = ( this.toDecimal(categories[ catID ]['tot_SV']) / this.toDecimal(categories[ catID ]['avr_rr'])) * 25; //Math.max( ...categories[ catID ]['DOHs'] )  
                categories[ catID ]['items'].push(products[y]);

                if (isNaN(categories[ catID ]['DOH'])) {
                  categories[ catID ]['DOH'] = 0
                }                
              }
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
          },
          keyExists(obj, key) {
              return key in obj;
          },
          searchFun: function(event){
            const DBdata =  this.productsDB
            let products = this.products
            let search = this.searchtext.toLowerCase()
             
            this.products = [];
            for (let i = 0; i < DBdata.length; i++) {
                if (DBdata[i].category.includes(search)) {
                  this.products.push(DBdata[i])
                 } 
            } 
 
          },
          clear_filters: function() {
            this.searchtext = "";
            this.products = this.productsDB;
          },
          // filter stock by value
          filter_stock_value: function(event){
            let products = this.products;
            let sort = event.target.value;
 
                    if (sort == 'low') {
                      function compare( a, b ) {
                        if ( a.tot_SV < b.tot_SV ){        return -1;           }
                        if ( a.tot_SV > b.tot_SV ){        return 1;            }
                          return 0;
                      }
                      products = products.sort(compare);
                    }
                    if (sort == 'high') {
                      function compare( a, b ) {
                        if ( a.tot_SV > b.tot_SV ){   return -1;  }
                        if ( a.tot_SV < b.tot_SV ){   return 1;   }
                         return 0;
                    } products = products.sort(compare);                   
                  }
                  if (sort == 'zero') { products = products.filter(e => e.tot_SV <= 0);      } 
              this.products = products;
              console.log(products)
 
          },
          // 
          filter_nett_sales: function(event){
            let products = this.products;
            let sort = event.target.value;
 
                    if (sort == 'low') {
                      function compare( a, b ) {
                        if ( a.nett_sales < b.nett_sales ){        return -1;           }
                        if ( a.nett_sales > b.nett_sales ){        return 1;            }
                          return 0;
                      }
                      products = products.sort(compare);
                    }
                    if (sort == 'high') {
                      function compare( a, b ) {
                        if ( a.nett_sales > b.nett_sales ){   return -1;  }
                        if ( a.nett_sales < b.nett_sales ){   return 1;   }
                         return 0;
                    } products = products.sort(compare);                   
                  }
                  if (sort == 'zero') { products = products.filter(e => e.nett_sales <= 0);      } 
              this.products = products;
 
          },
          // 
           filter_avr_rr: function(event){
            let products = this.products;
            let sort = event.target.value;
 
                    if (sort == 'low') {
                      function compare( a, b ) {
                        if ( a.avr_rr < b.avr_rr ){        return -1;           }
                        if ( a.avr_rr > b.avr_rr ){        return 1;            }
                          return 0;
                      }
                      products = products.sort(compare);
                    }
                    if (sort == 'high') {
                      function compare( a, b ) {
                        if ( a.avr_rr > b.avr_rr ){   return -1;  }
                        if ( a.avr_rr < b.avr_rr ){   return 1;   }
                         return 0;
                    } products = products.sort(compare);                   
                  }
                  if (sort == 'zero') { products = products.filter(e => e.avr_rr <= 0);      } 
              this.products = products;
 
          },  //  

          filter_days_onhand: function(event){
            let products = this.products;
            let sort = event.target.value;
 
                    if (sort == 'low') {
                      function compare( a, b ) {
                        if ( a.DOH < b.DOH ){        return -1;           }
                        if ( a.DOH > b.DOH ){        return 1;            }
                          return 0;
                      }
                      products = products.sort(compare);
                    }
                    if (sort == 'high') {
                      function compare( a, b ) {
                        if ( a.DOH > b.DOH ){   return -1;  }
                        if ( a.DOH < b.DOH ){   return 1;   }
                         return 0;
                    } products = products.sort(compare);                   
                  }
                  if (sort == 'zero') { products = products.filter(e => e.DOH <= 0);      } 
              this.products = products; 
          },
          //  slow_moving_item

          filter_doh_perproduct: function(filter){
            let products = this.raw_products_data;
            let doh = this.doh_search;
            console.log(doh)
            if (filter == 'less') { products = products.filter(e => e.days_onhand < doh);      }
            if (filter == 'greater') { products = products.filter(e => e.days_onhand > doh);      }
            if (filter == 'slow_moving') { products = products.filter(e =>
              {
                let avr_rr = e.avr_rr;
                let expected_val = e.sellpinc1 * 10;
                if (e.days_onhand > 90 && e.stock_value > 0 && e.nett_sales > 0 ) {
                  return avr_rr < expected_val
                }

               });      }

            function compare( a, b ) {
              if ( a.days_onhand < b.days_onhand ){   return -1;  }
              if ( a.days_onhand > b.days_onhand ){   return 1;   }
                return 0;
            } products = products.sort(compare);

            // create categories
            let categories = this.create_categories(products)

          this.products = [ ...Object.values(categories) ]  
          this.productsDB = [ ...Object.values(categories) ] 
          },

           get_csv: function() {
              function convertToCSV(objArray) {
                var array =
                  typeof objArray != "object" ? JSON.parse(objArray) : objArray;
                var str = "";

                for (var i = 0; i < array.length; i++) {
                  var line = "";
                  for (var index in array[i]) {
                    if (line != "") line += ",";

                    line += array[i][index];
                  }

                  str += line + "\r\n";
                }

                return str;
        }

        function exportCSVFile(headers, items, fileTitle = "file") {
          if (headers) {
            items.unshift(headers);
          }

          // Convert Object to JSON
          var jsonObject = JSON.stringify(items);
          var csv = convertToCSV(jsonObject);
          var exportedFilenmae = fileTitle + ".csv" || "export.csv";
          var blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });

          if (navigator.msSaveBlob) {
             navigator.msSaveBlob(blob, exportedFilenmae);
          } else {
            var link = document.createElement("a");
            if (link.download !== undefined) {
               // Browsers that support HTML5 download attribute
              var url = URL.createObjectURL(blob);
              link.setAttribute("href", url);
              link.setAttribute("download", exportedFilenmae);
              link.style.visibility = "hidden";
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
            }
          }
        } 

        var headers = {
              barcode: "Barcode",
              descript: "Description",  
              avrgcost: "Average Cost",
              sellpinc1: "Selling Price",
              stock_value: "Stock Value",
              nett_sales: "Nett Sales",
              avr_rr: "Average Run Rate",
              days_onhand: "Days onHand",  
            };

        let uid = localStorage.getItem("uid");
        let products = this.products; //JSON.parse(localStorage.getItem("products")); 
        itemsNotFormatted = products;
        var itemsFormatted = [];
        // format the data
        itemsNotFormatted.forEach((item) => {
 
          for (let y = 0; y < item.items.length; y++) {
            
            itemsFormatted.push({
            barcode: "'"+item.items[y].barcode+"",
            descript: item.items[y].descript,  
            avrgcost: this.toDecimal(item.items[y].avrgcost).toFixed(2),
            sellpinc1: this.toDecimal(item.items[y].sellpinc1).toFixed(2),
            stock_value: this.toDecimal(item.items[y].stock_value).toFixed(2),
            nett_sales: this.toDecimal(item.items[y].nett_sales).toFixed(2),
            avr_rr: this.toDecimal(item.items[y].avr_rr).toFixed(2),
            days_onhand: this.toDecimal(item.items[y].days_onhand).toFixed(0),
              
          });
            
          }
          
        });
 
         var fileTitle = "Stokkafela"; // or 'my-unique-title'

        exportCSVFile(headers, itemsFormatted, fileTitle); // call the exportCSVFile() function to process the JSON and trigger the download
      } 

      }
 }).mount("#app");
 
  </script>
</x-app-layout>
             
