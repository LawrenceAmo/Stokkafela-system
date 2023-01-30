<x-app-layout>
    <main class="m-0  px-4   w-100" id="app">
        
      <div class="  row bg-white shadow border rounded p-3 w-100">
        <div class="col-md-3">
             <div class="card p-3 border border-info">
                <p class="font-weight-bold h5 text-center"> Total Stock <br> <span> {{$get_products_stats->total_stock}}</span></p>                 
             </div>
        </div>
        <div class="col-md-3">
             <div class="card p-3 border border-info">
                <p class="font-weight-bold h5 text-center">Stock onHand <br> <span> {{$get_products_stats->stock_onhand}}</span></p>
             </div>
        </div>
        <div class="col-md-3">
             <div class="card p-3 border border-info">
                <p class="font-weight-bold h5 text-center">  Stock Value <span>R{{number_format($get_products_stats->stock_value,2)}}</span></p>
             </div>
        </div>
        <div class="col-md-3">
             <div class="card p-3 border border-info">
                <p class="font-weight-bold h5 text-center">Out of Stock <br> <span>{{$get_products_stats->out_of_stock_products}}</span></p>
             </div>
        </div> 
    </div>
    <hr> 
    <div class="card border rounded p-3 w-100">

      <div class="border rounded p-3 my-1">

        <div class="">
          <div class="form-group">
            <label for="">Search</label>
            <input type="text"
              class="form-control" name="searchtext" id="searchtext" v-model="searchtext" v-on:keyup="seachFun($event)" placeholder="Type something" >
           </div>
        </div>
      </div>

      <div class="  row rounded   w-100">
        <div class=" col">
            <div class="card p-1 border border-info">
               <p class="font-weight-bold text-center"> Sales  <br /> <span>R@{{ (sales.toFixed(2)).toLocaleString('en-US') }}</span></p>
            </div>
       </div>
       <div class=" col">
        <div class="card p-1 border border-info">
           <p class="font-weight-bold text-center">Sales Cost  <br /> <span>R@{{ salescost.toFixed(2) }}</span></p>
        </div>
   </div>
        <div class=" col">
             <div class="card p-1 border border-info">
                <p class="font-weight-bold text-center">Refunds  <br /> <span>R@{{ refunds.toFixed(2) }}</span></p>                    
             </div>
        </div> 
        <div class=" col">
             <div class="card p-1 border border-info">
                <p class="font-weight-bold text-center">Refunds Cost  <br /> <span>R@{{ refundscost.toFixed(2) }}</span></p>
             </div>
        </div> 
        <div class=" col">
          <div class="card p-1 border border-info">
             <p class="font-weight-bold text-center">Nett Sales  <br /> <span>R@{{ nettsales.toFixed(2) }}</span></p>
          </div>
     </div> 
     <div class=" col">
      <div class="card p-1 border border-info">
         <p class="font-weight-bold text-center"> Profit <br /> <span>R@{{ profit.toFixed(2) }}</span></p>
      </div>
        </div>  
    </div>


        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div>
<div class="font-weight-bold  h4 d-flex justify-content-between">
   <div class=" font-weight-bold  h4 "> All Sales  </div>
 <div class=" rounded">
    <a href="{{ route('create_sales')}}" class="btn btn-success rounded btn-sm">add new product</a>
    {{-- <a href="{{ route('create_product')}}" class="btn btn-info rounded btn-sm">import product</a> --}}
    <a type="button"  data-toggle="modal" data-target="#import_sales" class="btn btn-info rounded btn-sm">import product</a>
</div>
</div>
<?php $i = 1 ?> 
<table class="table table-striped table-inverse table-responsive" style="height: 500px;">
    <thead class="thead-inverse">
      <tr class="border font-weight-bold shadow bg-dark text-light rounded">
        <th>#</th>
            <th>Code</th>
            <th>mainitem</th>
            <th>Department</th>
            <th>Sales</th>
            <th>Sales Cost</th>
            <th>Refunds</th>
             <th>Refunds Cost</th>
             <th>Nett Sales</th>
             <th>Profits</th>
             <th>Sales Date</th>
            <th>Created At</th>
         </tr>
        </thead>
        <tbody  class="border bg-light">
              <tr v-for="sale,i in salesnew"> 
                <td scope="row">@{{i}}</td>
                <td>@{{sale.barcode}}</td>
                <td>@{{sale.mainitem}}</td>
                <td>@{{sale.department}}</td>
                <td>@{{sale.sales}}</td>
                <td>@{{sale.salesCost}}</td>
                <td>@{{sale.reFunds}}</td>
                <td>@{{sale.reFundsCost}}</td>
                <td>@{{sale.nettSales}}</td>
                <td>@{{sale.profit}}</td>
                <td>@{{sale.from}}</td>
                <td>@{{sale.created_at}}</td>
                  
                 {{-- <td class=" px-0">
                     <a href="" class="px-1 text-primary"><i class="fa fa-fas fa-pencil-alt    "></i></a>|
                    <a href="" class="px-1 text-danger"><i class="fas fa-trash-alt    "></i></a>
                </td> --}}
            </tr>
                   
        </tbody>
        
</table>
{{-- <div class="text-center rounded p-2">{{ $products->onEachSide(5)->links() }}    </div> --}}
    </div>
    </main>
 

    <!-- Modal -->
    <div class="modal fade" id="import_sales" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('save_sales') }}" enctype="multipart/form-data" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import sales file</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="">
           
                        <div class="form-group">
                          <label for="">Select CSV, xlsx File</label>
                          <input type="file" name="sales_file" value="" accept=".csv, .xlsx, .xls, .xlsm" class="form-control-file"  id="sales_file" >
                          <small class="form-text text-muted d-none">
                            <span class="font-weight-bold">Note</span>
                            Only CSV or xlsx files are allowed... 
                          </small>
                        </div>
                        <div class="form-group">
                          <label for="">Select Store</label>
                          <select class="form-control" name="store" required>
                            <option class="" @disabled(true) selected>Select Store</option>
                            @foreach ($stores as $store)
                                <option value="{{$store->storeID}}">{{$store->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <hr>
                        <div class="d-grid b-3 ">
                              
                            <div class="form-group">
                              <label for="">Sales Date</label>
                              <input type="date" min="" name="date_from" id="date_from" class="form-control" placeholder="" aria-describedby="helpId">
                              {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                            </div>

                            {{-- <div class="form-group">
                              <label for="">Date To</label>
                              <input type="date" min="" name="date_to" id="date_to" class="form-control" placeholder="" aria-describedby="helpId">
                             </div> --}}

                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
{{-- ////////////////////////////////////////////////////////////////// --}} 
<script>
 
const { createApp } = Vue;
      //  let
      createApp({
        data() {
          return {
            salesdb: [], 
            salesnew: [], 
            sales: 0,
            salescost: 0,
            refunds: 0,
            refundscost: 0,
            nettsales: 0,
            profit: 0, 
            // 
            searchtext: "",
          }          
        },
       async created() {
 
            let response = await  await axios.get("{{route('get_sales')}}");
            let data = await response.data;

            console.log(await data)
            for (let i = 0; i < data.length; i++) {
               await this.salesnew.push(data[i]);
             } 
            //  let salef = 0;
             
             for (let x = 0; x < this.salesnew.length; x++) {

              this.sales += parseFloat(this.salesnew[x].sales);
              this.salescost += parseFloat(this.salesnew[x].salesCost);
              this.refunds += parseFloat(this.salesnew[x].reFunds);
              this.refundscost += parseFloat(this.salesnew[x].reFundsCost);
              this.nettsales += parseFloat(this.salesnew[x].nettSales);
              this.profit += parseFloat(this.salesnew[x].profit);
                            
              // console.log(Number(this.salesnew[x].sales)  ); 
              // salef += 1 +  parseFloat(this.salesnew[x].sales);
              }
     
              console.log(this.salesnew)
              this.salesdb = [ ...this.salesnew ]
           
        },
       methods:{

        seachFun(event) {          
            
            let salesnew = JSON.parse(JSON.stringify(this.salesnew))
            let salesdb = JSON.parse(JSON.stringify(this.salesdb))
            let search = this.searchtext.toLowerCase()
            let mysales = []
              
            if (search.length < 3) {
                mysales = [ ...salesdb ];  // show everything on the table

                      this.sales  = 0;
                      this.salescost = 0;
                      this.refunds = 0;
                      this.refundscost = 0;
                      this.nettsales = 0;
                      this.profit = 0;   

                for (let x = 0; x < this.salesdb.length; x++) {

                    this.sales += parseFloat(this.salesdb[x].sales);
                    this.salescost += parseFloat(this.salesdb[x].salesCost);
                    this.refunds += parseFloat(this.salesdb[x].reFunds);
                    this.refundscost += parseFloat(this.salesdb[x].reFundsCost);
                    this.nettsales += parseFloat(this.salesdb[x].nettSales);
                    this.profit += parseFloat(this.salesdb[x].profit);      
                                  
                    // console.log(this.salesnew[x].profit); 
                    } 
             }else{
             
              mysales = [];

            for (let i = 0; i < salesdb.length; i++) {
       
                if (salesdb[i].barcode.includes(search))
                   {
                      mysales.push(salesdb[i]);

                      this.sales  = 0;
                      this.salescost = 0;
                      this.refunds = 0;
                      this.refundscost = 0;
                      this.nettsales = 0;
                      this.profit = 0;    

                    for (let x = 0; x < mysales.length; x++) {

                        this.sales += parseFloat(mysales[x].sales);
                        this.salescost += parseFloat(mysales[x].salesCost);
                        this.refunds += parseFloat(mysales[x].reFunds);
                        this.refundscost += parseFloat(mysales[x].reFundsCost);
                        this.nettsales += parseFloat(mysales[x].nettSales);
                        this.profit += parseFloat(mysales[x].profit);      
                                      
                    // console.log(this.salesnew[x].profit); 
                    }
                   }else{
                    
                      this.sales  = 0;
                      this.salescost = 0;
                      this.refunds = 0;
                      this.refundscost = 0;
                      this.nettsales = 0;
                      this.profit = 0;    

                    for (let x = 0; x < mysales.length; x++) {

                        this.sales += parseFloat(mysales[x].sales);
                        this.salescost += parseFloat(mysales[x].salesCost);
                        this.refunds += parseFloat(mysales[x].reFunds);
                        this.refundscost += parseFloat(mysales[x].reFundsCost); 
                        this.nettsales += parseFloat(mysales[x].nettSales);
                        this.profit += parseFloat(mysales[x].profit);    
                    }
                   }
              } 

             }
             this.salesnew = [];
             this.salesnew = [ ...mysales ]; 

             //  //////////////////////////////////
            
            
        },

       }
   }).mount("#app");
 
</script>
</x-app-layout>


{{-- 
  tue 2pm - 3pm till june
  --}}


  {{-- 
    add date to each data

    
    --}}