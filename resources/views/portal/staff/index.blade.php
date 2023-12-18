<x-app-layout>
    <main class="m-0  px-4   w-100"> 
    <hr>   
    <div class="card border rounded p-3 w-100 table-responsive">
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div>
<p class="font-weight-bold h4 d-flex justify-content-between">
   <span> All Staff Members  </span> <a href="{{ route('create_staff')}}" class="btn btn-info rounded btn-sm">add new Staff Member</a>
</p>
 <?php $i = 1 ?>
<table class="table table-striped w-auto p-0 " >
    <thead class=" m-0 p-0">
        <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
            <th>#</th>
            <th class="" >Full Names</th>
            {{-- <th>Phone</th> --}}
            <th>Email</th>
            <th>Department</th>
            <th>Role</th>
            <th>Status</th>   
            <th>Joined</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($staffs as $staff)
             <tr> 
                <td scope="row">{{$i}}</td>
                <td>{{$staff->first_name}} {{$staff->last_name}}</td>
                {{-- <td title="{{$staff->email}}"> {{$staff->phone}}</td>  --}}
                <td >{{$staff->email}}</td>
                <td>{{$staff->department_name}}</td> 
                <td >{{$staff->role_title}}</td>
                @if ($staff->role_status)
                    <td class="text-success">Active</td>
                @else
                    <td class="text-danger">Inactive</td>
                @endif
                <td>{{$staff->created_at}}</td>
                 <td class=" px-0">
                    {{-- <a href="" class="px-1 text-info"><i class="fas fa-eye    "></i></a> | --}}
                    <a href="{{ route('edit_staff', [$staff->id])}}" class="px-1 text-primary"><i class="fa fa-fas fa-pencil-alt    "></i></a>
                    {{-- <a href="{{ route('delete_staff', [$staff->id])}}" id="{{$staff->id}}" class="px-1 text-danger"><i class="fas fa-trash-alt    "></i></a> --}}
                 </td>
            </tr>
             <?php $i++ ?>
            @endforeach 
           
        </tbody>
</table>
@if (count($staffs) <= 0)
<i class="font-weight-bold grey-text h3 text-center">
    No Data Available...
</i>
@endif
 
    </div>
    </main>
    <script> 
    </script>
</x-app-layout>
