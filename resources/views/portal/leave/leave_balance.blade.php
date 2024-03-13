<x-app-layout>
    <style>
        
    </style>
    <main class="m-0  p-4    w-100" id="app">

        <div class="card p-3">
            <div class="d-flex justify-content-between">
                <div class=""></div>
                <div class=""></div>
                <div class="">
                    <a data-toggle="modal" data-target="#create_leave_balance"   class="btn btn-sm rounded btn-dark">Create Staff Leave Balance</a>
                    <a data-toggle="modal" data-target="#create_leave_type" @click="update_leave_types(false)" class="btn btn-sm rounded btn-dark"> Create leave type</a>
                    <a  href="{{ route('leave_admin')}}" class="btn btn-sm btn-info rounded">manage staff Leaves</a>
                </div>
            </div>
        </div>
        <hr>

 <div class="row mx-0 animated fadeInDown">
    <div class="col-12 text-center p-0 m-0">
        <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
    </div>
 </div>
 <div class="card   rounded p-3 w-100">
    <div class="">
        <p class="h5">Leave Types</p>
    </div>
   <div class="">
    <table class="table   table-striped table-inverse ">
        <thead class="thead-inverse">
            <tr class="h5 ">
                <th>#</th>
                <th>Leave Type Name</th>
                <th>Allocated Days</th>
                <th>Expire in</th>
                <th>Description</th>
                 <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for=" type,i in leave_types">
                <td scope="row">@{{i+1}}</td>
                <td>@{{type.name}} Leave</td>
                <td>@{{type.days}} days</td>
                <td>@{{type.expire_in_days}} days</td> 
                <td v-if="type.description">@{{type.description}}</td>
                <td v-else>N/A</td>
                <td>@{{type.created_at}}</td>
                <td class="text-center"> 
                    <a class="text-primary" data-toggle="modal" data-target="#create_leave_type"  @click="update_leave_types(type)" >
                        <i class="fa fa-pencil-alt" aria-hidden="true"></i> 
                    </a> 
                </td>
            </tr>           
        </tbody>
    </table>
 </div>
 
 </div> <hr>
 <div class="card   rounded p-3 w-100">
    <div class="">
        <p class="h5">Staff Leave Balances</p>
    </div>
    <table class="table   table-striped table-inverse ">
        <thead class="thead-inverse">
            <tr class="h5">
                <th>#</th>
                <th>First Names</th>
                <th>Last Names</th>
                <th>Leave Type</th>
                <th>Leave Balance</th>         
                <th>Action</th>         
            </tr>
        </thead>
        <tbody>
             
            <tr v-for=" balance,i in leave_balances">
                <td scope="row">@{{i}}</td>
                <td>@{{balance.first_name}} </td>
                <td> @{{balance.last_name}}</td>
                <td> 
                    <div class="border-bottom" v-for=" bal,x in balance.leave_balances">
                        <div class="d-flex justify-content-between">@{{ bal.name }}</div>
                    </div>
                </td>
                <td>
                    <div class="border-bottom" v-for=" bal,x in balance.leave_balances">
                        <div class="d-flex justify-content-between">@{{ bal.bal }} days </div>
                    </div>
                </td>
                <td ><a class="" data-toggle="modal" data-target="#update_leave_balance" @click="update_leave_balance(balance)">
                    <i class="fa fa-pencil-alt" aria-hidden="true"></i> 
                </a></td>

            </tr>           
        </tbody>
    </table>
 </div>
 
<!-- Modal -->
<div class="modal fade" id="create_leave_type" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('create_leave_type') }}" enctype="multipart/form-data" method="post" class="modal-content">
           @csrf <div class="modal-header">
                <h5 class="modal-title">Create Leave Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
              <div class="row ">
                <div class="col-md-6"> 
                  <div class="form-group">
                    <label for="">Leave Name</label>
                    <input type="text"
                      class="form-control" name="leave_type_name" id="" v-model="leave_type.name" placeholder="Leave Name">
                  </div>                    
                </div>  
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Expire in (X) days</label>
                    <input type="number"
                      class="form-control"  name="expire_in"  v-model="leave_type.expire_in_days" placeholder="Enter number of days">
                      <small>* e.g 365 days</small>
                  </div>
                </div>
              </div> 
               
              <div class="row ">
                <div class="col-md-6"> 
                  <div class="form-group">
                    <label for="">Accumulation Rate in Days</label>
                    <input type="text"
                      class="form-control" name="accumulation_rate" v-model="leave_type.accumulation_rate" id="" placeholder=" Accumulation Rate in Days">
                      <small>* e.g 1.25 days</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Accumulation Period in Days</label>
                    <input type="number"
                      class="form-control"  name="accumulation_period"  v-model="leave_type.accumulation_period" placeholder="Accumulation Period in Days">
                      <small>* e.g 30 days</small>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Allocate Days for this Leave</label>
                    <input type="number"
                      class="form-control" name="allocated_days" v-model="leave_type.days" id="" placeholder="Number of days">
                  </div>
                </div>                 
              </div>
              <div class="row">
                <div class="col-md-12">
                 <div class="form-group">
                   <label for="">Comments</label>
                   <textarea class="form-control" name="description" v-model="leave_type.description" id="" rows="3"></textarea>
                 </div>
                </div>
              </div>  
              <input type="hidden" name="create_type" v-model="create_type">
              <input type="hidden" name="leave_typeID" v-model="leave_type.leave_typeID">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-dark btn-sm rounded">Save leave type</button>
            </div>
          </form>
     </div>
</div>
     {{-- //////////////////////////////       Modal         //////////////////////////////// --}}
<!-- Modal -->
<div class="modal fade" id="create_leave_balance" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('create_staff_leave_balance') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
             <div class="modal-header">
                <h5 class="modal-title"> Create Staff Leave Balance </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
 
                <div class="form-group">
                  <label for="staff">
                    Select Staff
                  </label>
                  <select class="form-control" name="staff"  id="staff">
                    <option selected disabled>Select Staff</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id}}">{{ $staff->first_name}} {{ $staff->last_name}}</option>
                    @endforeach

                </select>
                </div>

                <div class="form-group">
                    <label for="leave_type">
                      Select Leave Type
                    </label>
                    <select class="form-control" name="leave_type" id="leave_type">
                        <option selected disabled>Select Leave Type</option>
                        @foreach ($leave_types as $leave_type)
                            <option value="{{ $leave_type->leave_typeID }}">{{ $leave_type->name}}</option>
                        @endforeach
                    </select>
                  </div>

               <div class="form-group">
                 <label for="">Balance</label>
                 <input type="text" name="balance" class="form-control" placeholder="Enter staff leave balance (in days)" aria-describedby="helpId">
               </div>

               <div class="form-group">
                <label for="">Description <small><i>(optional)</i></small></label>
                <textarea class="form-control" name="description" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-dark btn-sm rounded"> upload</button>
            </div>
        </form>
     </div>
</div>
{{-- //// End Modal 1 --}}
     {{-- //////////////////////////////       Modal         //////////////////////////////// --}}
<!-- Modal -->
<div class="modal fade" id="update_leave_balance" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('update_staff_leave_balance') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
             <div class="modal-header">
                <h5 class="modal-title"> Update Staff Leave Balance </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
 
                <div class="form-group">
                  <label for="">Staff Names</label>
                  <input type="text" class="form-control" name=" " disabled v-model="leave_balance.names" placeholder="">
                </div>
                <input type="hidden" class="form-control" name="userID" v-model="leave_balance.userID" placeholder="">

                <div class="form-group">
                    <label for="leave_type">
                      Select Leave Type
                    </label>
                    <select class="form-control" name="leave_type" v-model="leave_balance.selected_leave"  id="leave_type" >
                        <option selected disabled>Select Leave Type</option>
                        <option v-for="balance in leave_balance.leave_balances" :value="balance.leave_balanceID" @click="update_selected_leave(leave_balance, balance)">
                            @{{balance.name}}    
                        </option> 
                    </select>
                  </div>

               <div class="form-group">
                 <label for="">Balance</label>
                 <input type="text" name="balance" class="form-control" v-model="leave_balance.balance" placeholder="Enter staff leave balance (in days)">
               </div>

               <div class="form-group">
                 <label for="">Description <small><i>(optional)</i></small></label>
                 <textarea class="form-control" name="description" rows="3"></textarea>
               </div>
               <div class="form-group">
                <label for="">Give a reason why you edit this <small class="text-danger">*</small></label>
                <textarea class="form-control" name="reason_to_edit" rows="3"></textarea>
              </div>
               {{-- <input type="text" name="balance" class="form-control" placeholder="Enter staff leave balance (in days)" aria-describedby="helpId"> --}}
            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-dark btn-sm rounded"> upload</button>
            </div>
        </form>
     </div>
</div>   
    </main>
    <script>
//  document.getElementById('leave').addEventListener('keypress', function (e) {
//     if (e.key === 'Enter') {
//       e.preventDefault();
//     }
//   });
        const { createApp } = Vue;
             createApp({
                data() {
                  return {                       
                    leave_balances: [], 
                    leave_balance: [], 
                    selected_leave_type: '',
                    dailyTotals: [],
                    leave_types: [], 
                    leave_type: [], 
                    number_of_days: 0,  // the number of days requested                 
                    leave_days: 3,    // the number of days for current leave selected             
                    remaining_leave_days: 3,    // the number of days for current leave selected             
                    dateFrom: '',                 
                    dateTo: '',                 
                    msg: '',
                    off_days: 0,
                    create_type: 0,
                  }          
                },
               async created() { 
                let leave_balances = @json($leave_balances);
                let leave_types = @json($leave_types);
 
                this.leave_balances = leave_balances;
                this.leave_types = leave_types;
                      console.log(leave_balances)
                },
               methods:{  
                update_leave_types: function(leave){
                    if (!leave) {
                        this.leave_type = [];
                        this.create_type = 1;
                        return false;
                    }
                    this.create_type = 0;
                    this.leave_type = leave;
                },
                update_selected_leave: function(user, bal){
                    user.balance = bal.bal
                    this.leave_balance = user;

                    console.log(user,bal)
                    console.log("this.leave_balance")
                    console.log(this.leave_balance)
                },
                update_leave_balance: function(bal){
                    bal.names = bal.first_name+" "+bal.last_name
                    bal.balance = 0 //bal.first_name
                    console.log(bal)
                    this.leave_balance = bal;
                },               
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
            apply_for_leave: function(  ){
                console.log(this.selected_leave_type)

                if ((this.number_of_days <= 0) || !this.selected_leave_type ) {
                    this.res_display('Please fill in all fields!!! ')
                    return false;
                }
                console.log(this.number_of_days +" - "+ this.selected_leave_type)
            },
            calculateDays: async function(){
                    if (!this.dateFrom || !this.dateTo) return;
                    let number_of_days = (new Date(this.dateTo) - new Date(this.dateFrom)) ;
                    number_of_days = Math.round(number_of_days / (1000 * 3600 * 24)) + 1;
                    number_of_days = number_of_days - this.off_days;

                    if (number_of_days <= 0) {
                    this.res_display('Invalid date selected. Please select a valid date')
                    this.dateTo = '';
                    return false;
                    }else{
                    this.res_display('')
                    }
                    let leave_days =  this.leave_days
                    leave_days = leave_days - number_of_days

                    if (leave_days < 0) {
                        this.res_display('You have insufficient leave days')
                        this.dateTo = '';
                        return false;
                    }

                    this.leave_days =  leave_days
                    this.number_of_days =  number_of_days

                    console.log(this.number_of_days)
                },
               }
           }).mount("#app");
        </script>

</x-app-layout>
