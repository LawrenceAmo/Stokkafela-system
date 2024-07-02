<x-app-layout>
  <main class="m-0 mb-5  px-4 py-3   w-100">
       <div class="">
        <p class="h4 font-weight-bold">Select Store to view Reps</p>
       </div>
    <hr>

      <div class="">

        <div class="row">

          @for ($i = 0; $i < count($stores); $i++)

          <a href="{{ route('reps',[$stores[$i]->storeID]) }}" class="col-3 p-3 text-black " style="color: black; text-decoration: none;">
            <div class="card border rounded shadow px-3 pb-3  ">
              <span class=" d-flex justify-content-end font-weight-italic p-0 m-0"><small>{{$stores[$i]->trading_name}}</small></span>
              <div class="d-flex flex-column justify-content-center p-0 m-0 " style="height: 80px">
                <h3 class="font-weight-bold ">{{$stores[$i]->name}}</h3>
              </div>

              <div class="">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci, unde. Praesentium, labore. Vitae earum aperiam, beatae ex ipsa alias, cum quis fugiat eum, optio voluptate amet totam esse dolorem tempora.
              </div>
            </div>
          </a>

          @endfor

        </div>

      </div>

      <hr>

  <div class="card border rounded p-3 w-100 table-responsive  d-none">
      <div class="row mx-0 animated fadeInDown">
          <div class="col-12 text-center p-0 m-0">
              <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
          </div>
      </div>
      
<p class="font-weight-bold h4 d-flex justify-content-between">
 <span> All Reps  </span>
 <a href="{{ route('create_rep')}}" class="btn btn-info rounded btn-sm font-weight-bold" data-toggle="modal" data-target="#create_new_rep">add new Rep</a>
</p>

<table class="table table-striped w-auto p-0 " >
  <thead class=" m-0 p-0">
      <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
          <th>#</th>
          <th class="" >Full Names</th>
          <th>Rep Number</th>
          <th>Destribution Center</th>         
          <th>Action</th>         
      </tr>
      </thead>
      <tbody>
          @foreach ($reps as $rep)
           <tr>
              <td scope="row"></td>
              <td>{{$rep->first_name}} {{$rep->last_name}}</td>
               <td >{{$rep->rep_number}}</td>
              <td >{{$rep->name}}</td>  
              <td class="">
                <a href=" {{ route('update_rep', [$rep->repID]) }}" class="text-info"><i class="fas fa-pencil-alt    "></i></a> &nbsp; |  &nbsp;  
                <a href="{{ route('update_rep', [$rep->repID, true]) }}" class="text-danger"><i class="fas fa-trash-alt    "></i></a>  
              </td>
           <?php $i++ ?>
           </tr>
          @endforeach 
         
      </tbody>
</table>
@if (count($reps) <= 0)
<i class="font-weight-bold grey-text h3 text-center">
  No Data Available...
</i>
@endif
<br>
<hr>
<br>

<p class="font-weight-bold h4 d-flex justify-content-between">
  <span> All Desstribution Centers  </span>
  <a href="{{ route('create_rep')}}" class="btn btn-info rounded btn-sm font-weight-bold" data-toggle="modal" data-target="#create_new_destributor">add new Destribution Center</a>
 </p>
 <?php $i = 1 ?>
 <table class="table table-striped w-auto p-0 " >
   <thead class=" m-0 p-0">
       <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
           <th>#</th>
           <th>Destribution Center</th>         
           {{-- <th>Rep Number</th> --}}
           <th>Region</th>         
           <th>Action</th>         
       </tr>
       </thead>
       <tbody>  
           @foreach ($destributors as $destributor)
            <tr>
               <td scope="row">{{$i}}</td>
               <td>{{$destributor->name}}</td>
               <td >{{$destributor->address}}</td> 
               <td class="">
                <a href=" {{ route('update_destributor', [$destributor->destributorID]) }}" class="text-info"><i class="fas fa-pencil-alt "></i></a> &nbsp; |  &nbsp;  
                <a href="{{ route('update_destributor', [$destributor->destributorID, true]) }}" class="text-danger"><i class="fas fa-trash-alt "></i></a>  
              </td> 
            <?php $i++ ?>
           @endforeach 
          
       </tbody>
 </table>
 @if (count($destributors) <= 0)
 <i class="font-weight-bold grey-text h3 text-center">
   No Data Available...
 </i>
 @endif

  </div>

{{-- ////////////////////////// DESTRIBUTION CENTERS --}}
<div class="modal fade" id="create_new_destributor" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="{{ route('create_destributor') }}" enctype="multipart/form-data" method="post" class="modal-content">
          @csrf
          <div class="modal-header">
              <h5 class="modal-title">Create New Destribution Center</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
          </div>
          <div class="modal-body">
              <div class="">
                  <div class="form-group">
                    <label for="">Center Name</label>
                    <input type="text"   class="form-control" name="name" placeholder="Enter Name" id="products_file" >
                  </div>
                  <div class="form-group">
                    <label for="">Center Region</label>
                    <input type="text"   class="form-control" name="address" placeholder="Enter Destribution Region" id="products_file" >
                  </div>
                  
                  <div class="form-group">
                    <label for="">Select Store</label>
                    <select class="form-control" name="store" required>
                      <option class="" @disabled(true) selected>Select Store</option>
                      @foreach ($stores as $store)
                          <option value="{{$store->storeID}}" >{{$store->name}}</option>
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
  </main> 
</x-app-layout>
