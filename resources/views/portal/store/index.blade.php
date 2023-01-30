<x-app-layout>
    <main class="m-0  px-4   w-100">
        <div class="  row bg-white shadow border rounded p-3 w-100">
         
            <div class="col-md-3">
                 <div class="card p-3 border border-info">
                    <p class="font-weight-bold h5 text-center">Total Sites <span>{{$miniStats['stores']}}</span></p>
                    
                 </div>
            </div>
            <div class="col-md-3">
                 <div class="card p-3 border border-info">
                    <p class="font-weight-bold h5 text-center"> Products  <span>{{$miniStats['products']}}</span></p>
                 </div>
            </div>
            <div class="col-md-3">
                 <div class="card p-3 border border-info">
                    <p class="font-weight-bold h5 text-center">  Total Stuff <span>{{$miniStats['staff']}}</span></p>
                 </div>
            </div>
            <div class="col-md-3">
                 <div class="card p-3 border border-info">
                    <p class="font-weight-bold h5 text-center">Available Jobs <span>{{$miniStats['jobs']}}</span></p>
                 </div>
            </div>
    
            
        </div>
    <hr>
   
    <div class="card border rounded p-3 w-100 table-responsive">
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<p class="font-weight-bold h4 d-flex justify-content-between">
   <span> All Available Stores  </span> <a href="{{ route('create_store')}}" class="btn btn-info rounded btn-sm">add new Store</a>
</p>
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
                <td>{{$store->name}}</td>
                <td>{{$store->trading_name}}</td> 
                <td>{{$store->active}}</td> 
                <td><?php
                echo date_format($store->created_at, 'd-m-Y h:i:s');
                // echo $date->format('l jS \o\f F Y h:i:s A'), "\n";
                ?></td>
                 <td class=" px-0">
                    {{-- <a href="" class="px-1 text-info"><i class="fas fa-eye    "></i></a> | --}}
                    <a href="{{ route('edit_store', [$store->storeID])}}" class="px-1 text-primary"><i class="fa fa-fas fa-pencil-alt    "></i></a>|
                    <a href="{{ route('delete_store', [$store->storeID])}}" id="{{$store->storeID}}" class="px-1 text-danger"><i class="fas fa-trash-alt    "></i></a>
                 </td>
            </tr>
             <?php $i++ ?>
            @endforeach 
            {{-- 
            "name" => "fada of ecommerce"
            "trading_name" => "fadaeco"
            "slogan" => "By creating a store you agree to our Terms & Conditions"
            "active" => 0
            "discription" => 
            "created_at" => "2022-08-11 13:45:17"
            "updated_at" => "2022-08-11 13:45:17" --}}
                      
        </tbody>
</table>
@if (count($stores) <= 0)
<i class="font-weight-bold grey-text h3 text-center">
    No Data Available...
</i>
@endif
 
    </div>
    </main>
    <script> 
    </script>
</x-app-layout>
