<x-app-layout>
    <main class="m-0  p-4    w-100" id="app">

        <div class="card p-3">
            <div class="d-flex justify-content-between">
                <div class=""></div>
                <div class=""></div>
                <div class="">
                  {{-- <a data-toggle="modal" data-target="#leave"  class="btn btn-sm rounded btn-info"> Staff leave balances</a> --}}
                  @can('isAdmin')
                  <a href="{{ route('leave_balances') }}" class="btn btn-sm rounded btn-info"> Staff leave balances</a>
                  @endcan
                </div>
            </div>
        </div>
        <hr>
         
        <div class="card   rounded p-3 w-100">
          <div class=" row">
             <div class="col-md-3">
                 <p class="h5">Staff Leave History</p>
             </div>
             <div class="col-md-9">
                 <div class="form-group">
                    {{-- <input type="text" name="" id="" class="form-control" placeholder="Search Document by Name" aria-describedby="helpId"> --}}
                 </div>
             </div>
          </div> <hr>
          <div class="row mx-0 animated fadeInDown">
             <div class="col-12 text-center p-0 m-0">
                 <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
             </div>
          </div>
          
          <div class="">
            <table class="table   table-striped table-inverse  ">
              <thead class="thead-inverse">
                  <tr class="h5">
                      <th>#</th>
                      <th>Staff Names</th>
                      <th>Leave Type</th>
                      <th>Date From</th>
                      <th>Date To</th>
                      <th>Requested Days</th>
                      <th>Days Taken</th>
                      <th>Off Days</th>
                      <th>Status</th>
                      <th>Approved/Cancelled By</th>
                      <th>Created At</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for=" request,i in leave_request">
                      <td scope="row">@{{i+1}}</td>
                      <td>@{{request.first_name}} @{{request.last_name}}</td>
                      <td>@{{request.name}}</td>
                      <td>@{{request.date_from}}</td>
                      <td>@{{request.date_to}}</td>
                      <td class="text-center">@{{request.number_of_days_requested}}</td>
                      <td class="text-center">@{{request.actual_number_of_days_requested}}</td>
                      <td class="text-center">@{{request.number_of_days_requested - request.actual_number_of_days_requested}}</td>
                      <td   class="text-bold">@{{request.status}}</td>
                      <td v-if="request.admin_name === null" class="text-center" > N/A</td>
                      <td v-else > @{{request.admin_name}}  @{{request.admin_surname}} </td>
                      <td>@{{request.created_at}}</td>
                      <td> 
                          <a class="text-primary" data-toggle="modal" data-target="#update_leave_request" @click="update_leave(request)"> <i class="fa fa-pencil-alt" aria-hidden="true"></i> </a> 
                      </td>
                  </tr>           
              </tbody>
          </table>
          </div>
             </div>
<!-- Modal -->

{{--  --}}
<div class="modal fade" id="update_leave_request" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <form method="POST" action="{{ route('update_leave_request') }}" class="modal-dialog" role="document">
      <div class="modal-content pb-3">
           <div class="modal-header">
              <h5 class="modal-title">Update Leave Request</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
          </div>  @csrf
          <div class="modal-body">
            <div class="row ">
              <div class="col-md-12"> 
                  <div class="form-group">
                    <label for="">Select Leave status</label>
                    <select class="form-control" name="status" >
                      <option disabled selected>Select Leave status</option>
                      <option value="cancelled">Cancel leave request</option>
                      <option value="approved">Approve leave request</option>
                      <option value="declined">Decline leave request</option>
                    </select>
                  </div>                       
              </div>                       
            </div>
            <div class="row ">
              <div class="col-md-12"> 
                  <div class="form-group">
                    <label for="">Reason for update</label>
                    <textarea class="form-control" name="reason" id="" rows="3"></textarea>
                  </div>                      
              </div>                       
            </div>
            <input type="hidden" name="selected_leave_request" v-model="update_selected_leave_request">
            <input type="hidden" name="admin" value="0">
          </div>
          <button type="submit" class="btn btn-dark btn-sm rounded">save changes</button>                
      </div>
   </form>
</div> 
{{--  --}}
  
    </main>
    
    <script>
      // document.getElementById('leave').addEventListener('keypress', function (e) {
      //    if (e.key === 'Enter') {
      //      e.preventDefault();
      //    }
      //  });
             const { createApp } = Vue;
                  createApp({
                     data() {
                       return {                       
                         leave_request: [], 
                         leave_types: [], 
                         leave_balances: [], 
                         selected_leave_type: '',
                         dailyTotals: [],
                         number_of_days_requested: 0,  // the number of days requested                 
                         actual_number_of_days_requested: 0,  // the number of days requested                 
                         available_leave_days: 0,    // the number of days for current leave selected             
                         current_leave_days_balance: 0,    // the number of days for current leave selected             
                         remaining_leave_days: 3,    // the number of days for current leave selected             
                         dateFrom: '',                 
                         dateTo: '',                 
                         msg: '',
                         submit_form: false,
                         off_days: 0,
                         update_selected_leave_request: '',
                       }          
                     },
                    async created() { 
                     let leave = @json($leave_requests);
                     let leave_types = @json($leave_types);
                     let leave_balances = @json($leave_balances);
     
                     this.leave_types = leave_types;
                     this.leave_request = leave;
                     this.leave_balances = leave_balances;
                     console.log(leave)
     
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
                     update_leave: function( leave_request ){
                       this.update_selected_leave_request = leave_request.leave_requestID 
                       console.log(leave_request)
                     },
                     selected_leave: function( leave_balance ){
                       this.current_leave_days_balance = leave_balance.balance
                       this.available_leave_days = 0
                       this.number_of_days_requested = 0
                       this.off_days = 0
                     console.log(leave_balance)
                     },
                 apply_for_leave: function(  ){
     
                     if ((this.number_of_days_requested <= 0) || !this.selected_leave_type ) {
                         this.res_display('Please fill in all fields!!! ')
                         return false;
                     }
                     if (!this.submit_form) {
                         this.res_display('Something went wrong, please make sure all data is entered correctly, or refresh the page and try again...')
                         return false;
                     }
     
     
                     document.getElementById('leave').submit();
                 },
                 calculateDays: async function(){
                         this.submit_form = false;
                         if (!this.dateFrom || !this.dateTo) return;
                         let number_of_days_requested = (new Date(this.dateTo) - new Date(this.dateFrom)) ;  // number of days requested
                         number_of_days_requested = Math.round(number_of_days_requested / (1000 * 3600 * 24)) + 1;     // get the actual days
                         // number_of_days_requested = number_of_days_requested - this.off_days;    // exclude the off days and holidays
     
                         if (number_of_days_requested <= 0) {
                         this.res_display('Invalid date selected. Please select a valid date')
                         this.dateTo = '';
                         return false;
                         } 
                         this.res_display('')
                          
                         // remove num days requested from available days for this leave type
                         let available_leave_days =  this.available_leave_days
                         available_leave_days = this.current_leave_days_balance - number_of_days_requested + this.off_days;
     
                         if (available_leave_days < 0) {
                             this.res_display('You have insufficient leave days')
                             this.dateTo = '';
                             return false;
                         }
      
                         this.available_leave_days =  available_leave_days
                         this.number_of_days_requested =  number_of_days_requested
                         this.actual_number_of_days_requested = this.number_of_days_requested - this.off_days ;
                         this.submit_form = true;
                     },
                    }
                }).mount("#app");
             </script>

</x-app-layout>
