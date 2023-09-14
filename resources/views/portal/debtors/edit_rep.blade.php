<x-app-layout>
    <main class="m-0 mb-5  px-4 py-5   w-100">
        


    <form action="{{ route('save_rep')}}" method="POST" class=" card rounded p-3 mb-5">
      @csrf
      <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div> 
        <div class="">
            <div class="">
                <div class="form-group">
                  <label for="">First Name</label>
                  <input type="text"   class="form-control" name="first_name" value="{{ $rep->first_name}}" placeholder="Enter First Name" id="products_file" >
                </div>
                <div class="form-group">
                  <label for="">Last Name</label>
                  <input type="text"   class="form-control" name="last_name" value="{{ $rep->last_name}}" placeholder="Enter Last Name" id="products_file" >
                </div>
                <div class="form-group">
                  <label for="">Rep Number</label>
                  <input type="number"   class="form-control" name="rep_number" value="{{ $rep->rep_number}}" placeholder="Enter Rep Number" id="products_file" >
                </div>
 
                 <div class="form-check py-3">
                   <label class="form-check-label">
                     <input type="checkbox" class="form-check-input" name="belong_to_stokkafela" id="" value="checkedValue" {{ $rep->belong_to_stokkafela ? 'checked' : '' }}>
                     Rep Belong to Stokkafela?
                   </label>
                 </div>
                <div class="form-group">
                  <label for="">Select Destributer</label>
                  <select class="form-control" name="destributor" required>
                    @foreach ($destributors as $destributor)
                        @if ($rep->destributorID == $destributor->destributorID)
                        <option  value="{{$destributor->destributorID}}"  selected>{{$destributor->name}}</option>
                        @endif
                        <option value="{{$destributor->destributorID}}" >{{$destributor->name}}</option>
                    @endforeach
                  </select>
                </div>
            </div>
              <hr>
              <div class="   d-flex justify-content-between">
             
            @if ($delete)  
            <div class="">
              <p class=" h5 font-weight-bold text-danger">Are you sure, you want to permanently delete this Rep?</p>
            </div> 
             
            @endif
             
            <div class="">
              <a  type="button"   class="btn btn-sm btn-outline-info rounded font-weight-bold" onclick="window.history.back()">go back</a>
              @if ($delete)
              <a  href=" {{ route('delete_rep', [$rep->repID]) }}" class="btn btn-sm btn-danger rounded font-weight-bold">Yes Delete Rep Sale</a>
              @else
              <button class="btn btn-sm btn-success rounded font-weight-bold">Update</button>
              @endif
            </div>
          </div>
          </div> 

          <input type="hidden" class="form-control"  name="repID"  value="{{ $rep->repID }}" >
          
    </form>
    {{-- <input type="hidden" id="rdate" value="{{  $rep_sale->date}}"> --}}
    </main>
   
</x-app-layout>
