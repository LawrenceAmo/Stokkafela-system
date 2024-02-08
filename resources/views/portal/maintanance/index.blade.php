<x-app-layout>

<main class="m-0  px-4 py-5   w-100" id="app">
    <div class="row p-3">
        <div class="col-12 border rounded shadow">
            <div v-if="loading"><p class="text-center h5">Please wait!!!...</p></div>
            <div class="text-center font-weight-bold" v-else><span class="h5 font-weight-bold">@{{jobs}}</span> tasks on queue. You can download DOH once there are no tasks on queue</div>
        </div>
    </div>
    <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div>

    <section class="card rounded p-2">
        <div class="row">
            <div class="col">
                <p class="font-weight-bold ">Stock </p>
                <div class="border rounded text-center">
                    <a href="" class="btn btn-sm btn-info rounded font-weight-bold" data-toggle="modal" data-target="#import_stock">Upload Stock</a>
                </div>
            </div>
            <div class="col">
                <p class="font-weight-bold">Stock Analysis</p>
                <div class="border rounded text-center">
                    <a href="" class="btn btn-sm btn-success rounded font-weight-bold" data-toggle="modal" data-target="#import_stock_analysis">Upload Stock Analysis</a>
                </div>
            </div>
            <div class="col">
                <p class="font-weight-bold">Upload manufacturers by product  </p>
                <div class="border rounded text-center">
                    <a href="" class="btn btn-sm btn-success rounded font-weight-bold" data-toggle="modal" data-target="#import_manufactures">Upload manufacturers</a>
                </div>
            </div>
        </div>
    </section>

<hr>
    
    <section class="card rounded p-2">
        <div class="row">
            <div class="col">
                <p class="font-weight-bold ">Sales </p>
                <div class="border rounded text-center">
                    <a type="button"  data-toggle="modal" data-target="#import_sales" class="btn btn-info rounded btn-sm">import Sales</a>
                </div>
            </div>
            <div class="col">
                <p class="font-weight-bold">Rep Sales</p>
                <div class="border rounded text-center">
                    <a href="" class="btn btn-sm btn-success rounded font-weight-bold" data-toggle="modal" data-target="#import_rep_sales">Upload Rep Sales</a>
                </div>
            </div>
        </div>
    </section>

    <hr>
    
    <section class="card rounded p-2">
        <form action="{{ route('delete_rep_sale_by_date') }}" method="POST" class="row">
            @csrf
            <div class="col">
                <p class="font-weight-bold ">delete sales where date =? </p>
                <div class="border rounded text-center">
                    <input type="date" class="form-control" name="date" id="" placeholder="Please enter the date">
                    <button type="submit" class="btn btn-info rounded btn-sm">import Sales</button>
                </div>
            </div> 
        </form>
    </section>
    <hr>
    <section class="card rounded p-2">
             <div class="col">
                <p class="font-weight-bold ">Start background Tasks</p>
                <div class="border rounded text-center">
                    {{-- <input type="date" class="form-control" name="date" id="" placeholder="Please enter the date"> --}}
                    <button   @click="queue_jobs_start()" class="btn btn-info rounded btn-sm">Start background Tasks</button>
                </div>
            </div> 
     </section> <hr>
     <section class="card rounded p-2">
    
       <form action="{{ route('delete_store_product') }}" method="POST" class="row">
        @csrf
        <div class="col">
            <p class="font-weight-bold ">Delete Product Per Store</p>
            <div class="border rounded text-center">
                <div class="form-group">
                    {{-- <label for="">Select Store</label> --}}
                    <select class="form-control" name="store" required>
                      <option class="" @disabled(true) selected>Select Store</option>
                      @foreach ($stores as $store)
                          <option value="{{$store->storeID}}">{{$store->name}}</option>
                      @endforeach
                    </select>
                  </div>
                <button type="submit" class="btn btn-danger rounded btn-sm">Delete Product</button>
            </div>
        </div> 
    </form>
</section>
 
</main>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

<div class="modal fade" id="import_stock_analysis" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('save_stock_analysis') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Import Stock Analysis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="form-group">
                      <label for="">Select Stock Analysis File</label>
                      <input type="file" value="" accept=".csv, .xlsx, .xls" class="form-control-file" name="file" id="products_file" >
                      <small class="form-text text-muted">
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
                    <div class=" " id="date"> 
                        <div class="form-group">
                        <label for="">Month & Year</label>
                        <input type="month" min="" name="date" id="date" class="form-control" placeholder="" aria-describedby="helpId">
                        {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                        </div> 
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

{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

<div class="modal fade" id="import_rep_sales" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('import_rep_sales') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Import Rep Sales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="form-group">
                      <label for="">Select Rep Sales File</label>
                      <input type="file" value="" accept=".csv, .xlsx, .xls" class="form-control-file" name="file" id="products_file" >
                      <small class="form-text text-muted">
                        <span class="font-weight-bold">Note</span>
                        Only CSV or xlsx files are allowed...
                    </small>
                    </div>
                   
                    <hr>
                    <div class=" " id="date"> 
                        <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" min="" name="date" id="date" class="form-control" placeholder="" aria-describedby="helpId">
                        {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                        </div> 
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
{{-- /// start modal --}}
<div class="modal fade" id="import_stock" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('save_product') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Import Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="form-group">
                      <label for="">Select CSV, xlsx File</label>
                      <input type="file" value="" accept=".csv, .xlsx, .xls" class="form-control-file" name="products_file" id="products_file" >
                      <small class="form-text text-muted">
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- Manufactures --}}
{{-- /// start modal --}}
<div class="modal fade" id="import_manufactures" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('save_product_manufacturers') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Import Product Manufacturers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="form-group">
                      <label for="">Select Manufacturers CSV, xlsx File</label>
                      <input type="file" value="" accept=".csv, .xlsx, .xls" class="form-control-file" name="file" id="products_file" >
                      <small class="form-text text-muted">
                        <span class="font-weight-bold">Note</span>
                        Only CSV or xlsx files are allowed... <br>
                        <span>The Excel file should contain ([code,description,manufacturers]) Columns <i>(description, is for Product Descriptio)</i></span>
                    </small>
                    </div> 
                    {{-- <div class="form-group">
                      <label for="">Select Store</label>
                      <select class="form-control" name="store" required>
                        <option class="" @disabled(true) selected>Select Store</option>
                        @foreach ($stores as $store)
                            <option value="{{$store->storeID}}">{{$store->name}}</option>
                        @endforeach
                      </select>
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>
{{-- /////////////////////////////// All Sales --}}
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

                      <div class="form-check   ">
                        <div >Are these daily Totals</div>
                        <label class="form-check-label pl-5">
                          <input type="radio" class="form-check-input" name="isDailyTotals" @change="isDailyTotals(true)" value="1"  >
                          Yes
                        </label>
                        <label class="form-check-label pl-5">
                          <input type="radio" class="form-check-input" name="isDailyTotals" @change="isDailyTotals(false)" value="" >
                            No
                        </label>
                      </div>
                      <hr>
                        <div class="d-none" id="date">
                          <div class="form-group">
                            <label for="">Sales Date</label>
                            <input type="date" min="" name="date_from" id="date_from" class="form-control" placeholder="" aria-describedby="helpId">
                           </div>
                        </div>                             
                  </div>
                </div>
            </div>
            <div class="d-none" id="buttons">
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm" :click="dailyTotals">Save</button>
            </div>
            </div>
        </form>
    </div>
</div>

{{-- ////////////////////////////////////////////////////////////////// --}} 
<script>
 
    const { createApp } = Vue;
         createApp({
            data() {
              return { 
                dailyTotals: [],
                jobs: 0,                 
                loading: true,                 
              }          
            },
           async created() { 
                   setInterval( async () => {
                    let jobs = await axios.get('{{route("get_jobs")}}'); 
                       jobs = await jobs.data
                       this.jobs = await jobs
                   }, 5000);

                   setTimeout(() => {
                    this.loading = false;
                   }, 5100);
                    //    console.log(await jobs)

            },
           methods:{ 
            queue_jobs_start: async function(){
                let jobs = await axios.get('{{route("queue_jobs_start")}}'); 
                    jobs = await jobs.data
                    console.log(await jobs)

                    alert(await jobs)

            },
            isDailyTotals(val){
                  let date = document.getElementById("date")
                  let buttons = document.getElementById("buttons")
    
                  if (val) {
                    date.classList.add('d-none');
                  } else{
                    date.classList.remove('d-none');
                  }
                   buttons.classList.remove('d-none');
                },
 
           }
       }).mount("#app");
     
//        $(document).ready(function() {
//     $('#start-queue-btn').click(function() {
//         $.get('/start-queue', function(data) {
//             alert(data);  // Show the response message
//         });
//     });
// });
    </script>
</x-app-layout>
