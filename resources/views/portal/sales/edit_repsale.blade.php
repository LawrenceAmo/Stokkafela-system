<x-app-layout>
    <main class="m-0 mb-5  px-4 py-5   w-100">
        


    <form action="{{ route('save_rep_sale')}}" method="POST" class=" card rounded p-3 mb-5">
      @csrf
      <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div> 
        <div class="">
            <div class="form-group "> 
              <label for="" class="font-weight-bold pb-3">
                @if ($delete)
               <span class="text-danger font-weight-bold h4"> Delete Rep Sale</span>
                @else
                Update Rep Sale
                @endif
              </label>
              <select class="custom-select" name="rep" >
                <option value="{{$rep_sale->repID}}" selected >{{$rep_sale->rep_number}} {{$rep_sale->first_name}}</option> 
               </select>
            </div>
              <div class="form-group">
                <label for="">Nett Sale</label>
                <input type="number" class="form-control" value="{{$rep_sale->NettSales}}" name="nett_sale" placeholder="Rep Nett Sale" >
              </div>
              <div class="form-group">
                <label for="">Enter VAT</label>
                <input type="number" class="form-control" value="{{$rep_sale->VAT}}" name="vat" placeholder="Enter VAT" >
              </div>
              <div class="form-group">
                <label for="">Select a Date</label>
                <input type="date" class="form-control"  name="date"  id="mydate" placeholder="Enter Store trading Name" >
               </div>
              <hr>
              <div class="   d-flex justify-content-between">
             
            @if ($delete)  
            <div class="">
              <p class=" h5 font-weight-bold text-danger">Are you sure, you want to permanently delete this?</p>
            </div> 
            @else
            <div class="">
              <small class="text-danger font-weight-bold">NB: &nbsp; </small> 
              <small class="text-muted"><i>You only submit the record for one day only. <br>
              e.g: Nettsales for Rep X is R0.00 for 30/01/2000
              </i></small>    
            </div>
            @endif 
             
            <div class="">
              <a  type="button"   class="btn btn-sm btn-outline-info rounded font-weight-bold" onclick="window.history.back()">go back</a>
              @if ($delete)
              <a  href=" {{ route('delete_rep_sale', [$rep_sale->salesID]) }}" class="btn btn-sm btn-danger rounded font-weight-bold">Yes Delete Rep Sale</a>
              @else
              <button class="btn btn-sm btn-success rounded font-weight-bold">Update</button>
              @endif
            </div>
          </div>
          </div> 

          <input type="hidden" class="form-control"  name="salesID"  value="{{ $salesID }}" >
          
    </form>
    <input type="hidden" id="rdate" value="{{  $rep_sale->date}}">
    </main>
    <script>
             let d = document.getElementById("rdate").value
            document.getElementById("mydate").value  = d.substring(0, 10);
    
    </script>
</x-app-layout>
