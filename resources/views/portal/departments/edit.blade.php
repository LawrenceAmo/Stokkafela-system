<x-app-layout>
    <main class="m-0  px-4   w-100">
        
        {{-- <div class="  row bg-white shadow border rounded p-3 w-100">
         
            <div class="col-md-3">
                 <div class="card p-3 border border-info">
                    <p class="font-weight-bold h5 text-center">Total Sites <span>{{$miniStats['stores']}}</span></p>
                    
                 </div>
            </div>
            <div class="col-md-3">
                 <div class="card p-3 border border-info">
                    <p class="font-weight-bold h5 text-center"> Departments  <span>{{$miniStats['departments']}}</span></p>
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
    
            
        </div> --}}
    <hr>
   
    <form action="{{ route('save_department')}}" method="POST" class="card border rounded p-3 w-100">
        @csrf
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<p class="font-weight-bold h5 d-flex justify-content-between">
   <span> Update {{$department->name}} Departments  </span>
    <button type="submit" class="btn btn-success rounded btn-sm"  >Save updates</button>
</p>


<div class="">
                    
    <div class="form-group">
      <label for="">Department Name</label>
      <input type="text" name="name" id="" value="{{$department->name}}" class="form-control" placeholder="" aria-describedby="helpId">
      <small id="helpId" class="text-muted">e.g Information Technology/ Human Resource</small>
    </div>
    <div class="form-group">
        <label for="">Department Other/Short Name <i class="small">(optional)</i></label>
        <input type="text" name="other_names" value="{{$department->other_names}}" class="form-control" placeholder="" aria-describedby="helpId">
        <small id="helpId" class="text-muted">e.g IT/HR</small>
      </div>
      <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="active" checked> Activate this department
        </label>
      </div>
      <input type="hidden" name="id" value="{{$id}}">
      
</div>
 
     </form>
    </main>
    <script>
        
    </script>
</x-app-layout>
