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
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 

<div class="font-weight-bold  h4 d-flex justify-content-between">
   <div class=" font-weight-bold  h4 "> All Products  </div>
 <div class=" rounded">
    <a href="{{ route('create_product')}}" class="btn btn-success rounded btn-sm">add new product</a>
    {{-- <a href="{{ route('create_product')}}" class="btn btn-info rounded btn-sm">import product</a> --}}
    <a type="button"  data-toggle="modal" data-target="#import_products" class="btn btn-info rounded btn-sm">import product</a>
</div>
</div>
<?php $i = 1 ?>
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
              <tr v-for="product,i in products" > 
                <td scope="row">@{{i}}</td>
                <td>@{{product.barcode}}</td>
                <td>@{{product.descript}}</td>
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
<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr>
            <th>#</th>
            <th>Barcode</th>
            <th>Description</th>
            <th>Ave Cost</th>
            <th>Sell Price</th>
            <th>Item Value</th>
            <th>On Hand</th>
             <th>Store Name</th>
            <th>Created At</th>
         </tr>
        </thead>
</table>
{{-- <div class="text-center rounded p-2">{{ $products->onEachSide(5)->links() }}    </div> --}}
    </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="import_products" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('save_product') }}" enctype="multipart/form-data" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Products</h5>
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
{{-- ////////////////////////////////////////////////////////////////// --}}


<script>


const { createApp } = Vue;
      //  let
      createApp({
        data() {
          return {
            // 
            products: [], 

          }          
        },
       async created() {
            let response = await  await axios.get("{{route('get_products')}}");
            let data = await response.data;
 
            for (let i = 0; i < data.length; i++) {
                this.products.push(data[i]);
             }
            console.log(this.products);
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
</script>
</x-app-layout>
