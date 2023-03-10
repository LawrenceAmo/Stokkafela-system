<x-app-layout>

<main class="m-0  px-4 py-5   w-100">
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
        </div>
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
{{-- /// --}}
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
                        {{-- @foreach ($stores as $store)
                            <option value="{{$store->storeID}}">{{$store->name}}</option>
                        @endforeach --}}
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
</x-app-layout>
