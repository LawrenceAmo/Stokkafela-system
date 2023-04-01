<x-app-layout>
    <main class="m-0  px-4 py-5   w-100">
      
   
    <div class="card border rounded p-3 w-100 table-responsive">
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<p class="font-weight-bold h4 d-flex justify-content-between">
   <span> All Available Stores  </span>
   <a  class="btn btn-info rounded btn-sm" data-toggle="modal" data-target="#create_new_store">add new Store</a>
</p>
{{-- href="{{ route('create_store')}}" --}}
 <?php $i = 1 ?>
<table class="table table-striped w-auto p-0 " >
    <thead class=" m-0 p-0">
        <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
            <th>#</th>
            <th>Name</th>
            <th>Trading As</th>
            <th>Active</th>
            {{-- <th>Jobs</th> --}}
             <th>Created</th>
             <th>Action</th>
        </tr>
        </thead> 
        <tbody>
            {{-- {{dd($stores)}} --}}
            @foreach ($stores as $store)
             <tr>
                 <td scope="row">{{$i}}</td>
                <td><a href="{{ route('store', [$store->storeID])}}">{{$store->name}}</a></td>
                <td><a href="{{ route('store', [$store->storeID])}}">{{$store->trading_name}}</a></td> 
                <td>{{$store->active}}</td> 
                <td><?php
                echo date_format($store->created_at, 'd-m-Y h:i:s');
                // echo $date->format('l jS \o\f F Y h:i:s A'), "\n";
                ?></td>
                 <td class="text-center">
                     <a href="{{ route('store', [$store->storeID])}}" title="Click to View Store Data" class="px-1 text-info"><i class="fa fa-fas fa-eye    "></i></a>
                    {{-- <a href="{{ route('delete_store', [$store->storeID])}}" id="{{$store->storeID}}" class="px-1 text-danger"><i class="fas fa-trash-alt    "></i></a> --}}
                 </td>
             </tr>
             <?php $i++ ?>
            @endforeach
       
                      
        </tbody>
    </table>
    @if (count($stores) <= 0)
        <i class="font-weight-bold grey-text h3 text-center">
            No Data Available...
        </i>
    @endif
 
    </div>

    {{-- /////////////////////   MODAL START  ///////////////////////// --}}

    <div class="modal fade" id="create_new_store" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('save_store') }}" enctype="multipart/form-data" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Store</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="form-group">
                          <label for="">Store Name</label>
                          <input type="text" class="form-control" name="name" placeholder="Enter Store Name" >
                        </div>
                        <div class="form-group">
                          <label for="">Store Trading Name</label>
                          <input type="text" class="form-control" name="trading_name" placeholder="Enter Store trading Name" >
                          <small class="text-muted">e.g 'Stokkafela Tembisa' / 'Mabebeza Bambanani'</small>
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
    </main>
    <script> 
    </script>
</x-app-layout>
