<x-app-layout>
  <main class="m-0 mb-5  px-4 py-3 w-100" >      
    <hr>
    <div class="row mx-0 animated fadeInDown">
      <div class="col-12 text-center p-0 m-0">
          <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
      </div>
    </div>
    <div class="" id="rep_app">
        
  <div class="card border rounded p-3 w-100 table-responsive" >
            
<div class=" d-flex justify-content-between w-100  ">
 <div class=" "><span class="font-weight-bold h4"> All Reps for {{ $current_store->name}}  </span></div>
  <div class=" ">
      <a href="{{ route('debtors')}}" class="btn btn-outline-warning rounded btn-sm font-weight-bold" >Go Back</a>
      <a href="{{ route('create_rep')}}" class="btn btn-info rounded btn-sm font-weight-bold" data-toggle="modal" data-target="#create_new_rep">add new Rep</a>
  </div>
</div>

<table class="table table-striped w-auto p-0 " >
  <thead class=" m-0 p-0">
      <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
          <th>#</th>
          <th class="" >Full Names</th>
          <th>Store</th>
          <th>Destribution Center</th>         
          <th>Action</th>         
      </tr>
      </thead>
      <tbody>
          @foreach ($reps as $rep)
           <tr>
              <td scope="row"></td>
              <td>{{$rep->first_name}} {{$rep->last_name}}</td>
               <td >{{$rep->name}}</td>
              <td >{{$rep->destributor_name}}</td>  
              <td class="">
                <a href=" {{ route('update_rep', [$rep->repID]) }}" class="text-info"><i class="fas fa-pencil-alt    "></i></a> &nbsp; |  &nbsp;  
                <a href="{{ route('delete_rep', [$rep->repID]) }}" class="text-danger"><i class="fas fa-trash-alt    "></i></a>  
              </td>
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
  </div>
  {{-- <div id="rep_app"> --}}

    {{-- //////////////////////////   MODALS START  reps //////////////////////////////////////// --}}
    <div class="modal fade" id="create_new_rep" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <form action="{{ route('create_rep') }}" enctype="multipart/form-data" method="post" class="modal-content">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title">Create New Rep</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
              </div>
              <div class="modal-body">
                  <div class="">
                      <div class="form-group">
                        <label >First Name <x-required /> </label>
                        <input type="text"   class="form-control" name="first_name" value="{{ old('first_name', $rep_data["first_name"])}}" placeholder="Enter First Name"   required>
                      </div>
                      <div class="form-group">
                        <label >Last Name</label>
                        <input type="text"   class="form-control" name="last_name" value="{{ old('last_name', $rep_data["last_name"])}}" placeholder="Enter Last Name"   >
                      </div>
                      <div class="form-group">
                        <label >Rep Number</label>
                        <input type="number"   class="form-control" name="rep_number" value="{{ old('rep_number', $rep_data["rep_number"])}}" placeholder="Enter Rep Number"   >
                      </div>
                      <div class="form-group">
                        <label >Select Destributer <x-required /> </label>
                        <select class="form-control" name="destributor" required>
                          <option class="" @disabled(true) selected>Select Destributor</option>
                          @foreach ($destributors as $destributor)
                              <option value="{{$destributor->destributorID}}" >{{$destributor->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label >
                        <input type="checkbox"   class=" " name="belong_to_stokkafela"    >
                          Belong to Stokkafela 
                        </label>
                      </div>
                      <div class="form-group">
                        <label >
                        <input type="checkbox" @click="enable_login_btn();"  class=" " v-model="enable_login" name="enable_login" >
                          Enable <span class="font-weight-bold">Log in</span> for this Rep? 
                        </label> 
                        <div class="border rounded p-1">
                          <small ><i>NB: If you enable login, Rep will be able to use their login details and login. But if not, Rep will remain virtual. If you're not sure, contact your IT or Administrator.</i></small>
                        </div>
                      </div>
                      <div class="" v-if="enable_login_form">
                        <div class="form-group">
                          <label >Rep Email Address</label>
                          <input type="email" class="form-control" value="{{ old('email', $rep_data["email"])}}" name="email" placeholder="Enter email address"   >
                        </div>
                        <div class="form-group">
                          <label >Password</label>
                          <input type="password" class="form-control" value="{{ old('password', $rep_data["password"])}}" name="password" placeholder="Enter Temp Password"   >
                        </div>
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
      </div>
  </main> 
  <script>
    const { createApp } = Vue;
         createApp({
            data() {
              return {
                enable_login: false,
                enable_login_form: false,
                update_selected_leave_request: '',
              }          
            },
           async created() { 

            },
           methods:{ 
            res_display: function( msg ){
                this.msg = msg;                  
                // Clear the existing setTimeout if it's set
                if (this.msgtimeoutId) {
                clearTimeout(this.msgtimeoutId);
                }
                // Set a new setTimeout to clear the messages after 10 seconds (10000 milliseconds)
                this.msgtimeoutId =  setTimeout(() => {
                    this.msg = '';    // set everything to empty string ''
                    }, 10000);
                    return true;
                },
            enable_login_btn: function(){
              if (this.enable_login) {
                this.enable_login_form = false;
              }else{
                this.enable_login_form = true;
              }
                },
           }
       }).mount("#rep_app");
    </script>

</x-app-layout>
