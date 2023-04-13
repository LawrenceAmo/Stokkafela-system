<x-app-layout>
    <main class="m-0 mb-5  px-4 py-5   w-100">
         
    <form action="{{ route('save_rep_target')}}" method="POST" class=" card rounded p-3 mb-5">
      @csrf
      <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div> 
        <div class="">
            <div class="form-group "> 
              <label for="" class="font-weight-bold h5 pb-3"> 
                Update Rep Target
               </label>
               
            </div>
            <div class="form-group">
              <label for="">Rep Name</label>
              <input type="text" disabled class="form-control" value="{{$rep->rep_number.' '.$rep->first_name}}" name="target" placeholder="Rep Nett Sale" >
            </div> 
            <div class="form-group">
              <label for="">Destributor</label>
              <input type="text" disabled class="form-control" value="{{$rep->name }}" name="target" placeholder="Rep Nett Sale" >
            </div>  
              <div class="form-group">
                <label for="">Target Amount</label>
                <input type="number" class="form-control" value="{{$rep->target_amount}}" name="target_amount" placeholder="Rep Nett Sale" >
              </div>                
              <hr>
              <div class="   d-flex justify-content-between">
              
            <div class="">
              <small class="text-danger font-weight-bold">NB: &nbsp; </small> 
              <small class="text-muted"><i>Set target in Rands. <br>
              e.g: target Amount R0.00
              </i></small>    
            </div>
              
            <div class="">
              <a  type="button"   class="btn btn-sm btn-outline-info rounded font-weight-bold" onclick="window.history.back()">go back</a>
              
              <button class="btn btn-sm btn-success rounded font-weight-bold">Update</button>
             </div>
          </div>
          </div> 

          <input type="hidden" class="form-control"  name="repID"  value="{{ $rep->repID }}" >
          
    </form>
    {{-- <input type="hidden" id="rdate" value="{{ $rep_sale->date}}"> --}}
    </main>
    <script>
            //  let d = document.getElementById("rdate").value
            // document.getElementById("mydate").value  = d.substring(0, 10);
    
    </script>
</x-app-layout>
