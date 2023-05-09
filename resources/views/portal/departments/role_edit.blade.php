<x-app-layout>
    <main class="m-0  px-4   w-100">
         
    <form action="{{ route('save_role')}}" method="POST" class="card border rounded p-3 w-100">
        @csrf
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<p class="font-weight-bold h5 d-flex justify-content-between">
   <span> Update {{$role->role_title}} Role  </span>
    <button type="submit" class="btn btn-success rounded btn-sm"  >Save updates</button>
</p>


<div class="">
              
    <div class="form-group">
        <label  >Role Title <small><i>(Job Title)</i></small></label>
        <input type="text" name="role_title" value="{{$role->role_title}}"  class="form-control" placeholder=""  >
        <small   class="text-muted">e.g Store Manager/ Cashier</small>
      </div>
      <div class="form-group">
          <label  >Description <i class="small">(optional)</i></label>
             <textarea class="form-control" name="description" id="" rows="3">{{$role->description}}</textarea>
      </div>
 
      <div class="form-group">
        <label  >Select Department for this Role</label>
        <select class="form-control" name="department" id="">
            <option   disabled>Select Department</option>
            @foreach ($departments as $department)
            @if ($department->departmentID === $role->departmentID)
            <option selected value="{{$department->departmentID}}">{{ $department->name }}</option>
            @else
            <option value="{{$department->departmentID}}">{{ $department->name }}</option>
            @endif
          @endforeach
           
        </select>
      </div>

      <input type="hidden" name="roleID" value="{{$role->roleID}}">
      
</div>
 
     </form>
    </main>
    <script>
        
    </script>
</x-app-layout>
