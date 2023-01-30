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
                    <p class="font-weight-bold h5 text-center"> Departments  <span>{{$miniStats['products']}}</span></p>
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
   
    <div class="card border rounded p-3 w-100">
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<p class="font-weight-bold h4 d-flex justify-content-between">
   <span> All Departments  </span> <a type="button" class="btn btn-info rounded btn-sm" data-toggle="modal" data-target="#modelId">add new Department</a>
</p>
{{-- href="{{ route('create_department')}}" --}}
<?php $i = 1 ?>
<table class="table table-striped table-inverse w-auto ">
    <thead class="thead-inverse rounded ">
        <tr class="border font-weight-bold shadow bg-dark text-light rounded">
            <th>#</th>
            <th>Name</th>
            <th>Other names</th>
            {{-- <th>Stuff</th>
            <th>Jobs</th> --}}
             <th>Created</th>
             <th>Action</th>
        </tr>
        </thead>
        <tbody>
            {{-- {{dd($departments)}} --}}
            @foreach ($departments as $department)
           {{-- {{$product}} --}}
            <tr>
                <td scope="row">{{$i}}</td>
                <td>{{$department->name}}</td>
                <td>{{$department->other_names}}</td>
                {{-- <td>{{$department->stuff}}</td>
                <td>{{$department->jobs}}</td> --}}
                <td>{{$department->created_at}}</td>
                 <td class=" px-0">
                    {{-- <a href="" class="px-1 text-info"><i class="fas fa-eye    "></i></a> | --}}
                    <a href="{{ route('edit_department', [$department->departmentID])}}" class="px-1 text-primary"><i class="fa fa-fas fa-pencil-alt    "></i></a>|
                    <a href="{{ route('delete_department', [$department->departmentID])}}" id="{{$department->departmentID}}" class="px-1 text-danger"><i class="fas fa-trash-alt    "></i></a>
                {{--   --}}
                </td>
            </tr>
             <?php $i++ ?>
            @endforeach 
                      
        </tbody>
</table>
@if (count($departments) <= 0)
<i class="font-weight-bold grey-text h3 text-center">
    No Data Available...
</i>
@endif
 
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content"action="{{ route('create_department')}}" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="">
                    
                        <div class="form-group">
                          <label for="">Department Name</label>
                          <input type="text" name="name" id="" class="form-control" placeholder="" aria-describedby="helpId">
                          <small id="helpId" class="text-muted">e.g Information Technology/ Human Resource</small>
                        </div>
                        <div class="form-group">
                            <label for="">Department Other/Short Name <i class="small">(optional)</i></label>
                            <input type="text" name="other_names" class="form-control" placeholder="" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">e.g IT/HR</small>
                          </div>
                          <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="active" checked> Activate this department
                            </label>
                          </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
{{-- //// End Modal 1 --}}

<!-- Modal -->
<div class="modal fade" id="modeldelete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content"action="{{ route('create_department')}}" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="">
                    
                        <div class="form-group">
                          <label for="">Department Name</label>
                          <input type="text" name="name" id="" class="form-control" placeholder="" aria-describedby="helpId">
                          <small id="helpId" class="text-muted">e.g Information Technology/ Human Resource</small>
                        </div>
                        <div class="form-group">
                            <label for="">Department Other/Short Name <i class="small">(optional)</i></label>
                            <input type="text" name="other_names" class="form-control" placeholder="" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">e.g IT/HR</small>
                          </div>
                          <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="active" checked> Activate this department
                            </label>
                          </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
{{-- //// End Modal 2 delete --}}
    </div>
    </main>
    <script>
        // function amo(id) {
        //     console.log(id)

        //     // window.confirm();
        // }
        // console.log(delete(id))
    </script>
</x-app-layout>
