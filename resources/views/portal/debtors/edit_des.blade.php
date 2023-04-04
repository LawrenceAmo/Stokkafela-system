<x-app-layout>
    <main class="m-0 mb-5  px-4 py-5   w-100">
        


    <form action="{{ route('save_destributor')}}" method="POST" class=" card rounded p-3 mb-5">
      @csrf
      <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div> 
        <div class="">
            <div class="">
                <div class="form-group">
                  <label for="">Destributor Name</label>
                  <input type="text"   class="form-control" name="name" value="{{ $des->name}}" placeholder="Enter Name" >
                </div>
                <div class="form-group">
                  <label for="">Address/ Region</label>
                  <input type="text"   class="form-control" name="address" value="{{ $des->address}}" placeholder="Enter Region" >
                </div>
                <div class="form-group">
                  <label for="">Select Destributer</label>
                  <select class="form-control" name="storeID" required>
                    @foreach ($stores as $store)
                        @if ($des->storeID == $store->storeID)
                        <option  value="{{$store->storeID}}"  selected>{{$store->name}}</option>
                        @endif
                        <option value="{{$store->storeID}}" >{{$store->name}}</option>
                    @endforeach
                  </select>
                </div>
                 
            </div>
              <hr>
              <div class="   d-flex justify-content-between">
             
            @if ($delete)  
            <div class="">
              <p class=" h5 font-weight-bold text-danger">Are you sure, you want to permanently delete this Destributor?</p>
            </div> 
             
            @endif
             
            <div class="">
              <a  type="button"   class="btn btn-sm btn-outline-info rounded font-weight-bold" onclick="window.history.back()">go back</a>
              @if ($delete)
              <a  href=" {{ route('delete_rep', [$des->destributorID]) }}" class="btn btn-sm btn-danger rounded font-weight-bold">Yes Delete Rep Sale</a>
              @else
              <button class="btn btn-sm btn-success rounded font-weight-bold">Update</button>
              @endif
            </div>
          </div>
          </div> 

          <input type="hidden" class="form-control"  name="destributorID"  value="{{ $des->destributorID }}" >
          
    </form>
 </main>
   
</x-app-layout>
