<x-app-layout>
    <main class="m-0   px-4   w-100" id="app">
 
      <x-crm.crm-nav :page="'Update Account'"/>

      <form action="{{ route('crm_accounts_save') }}" method="POST" class="card   rounded p-3 mb-5 w-100">
@csrf
      <div class="row mx-0 animated fadeInDown">
          <div class="col-12 text-center p-0 m-0">
              <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
          </div>
      </div>
      <div class="">
        <div class="row pb-3"> 
          <div class="col-md-6">
            <p class="h5">Account Information</p>
          </div>
          <div class="col-md-6 d-flex justify-content-end">
            <button class="btn btn-sm rounded btn-dark">Update Account</button>
          </div>
       </div>
           <div class="row  ">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Company Name</label>
                  <input type="text"
                    class="form-control" name="company_name" value="{{$account->company_name}}" id="" placeholder="Enter Company Name">
                 </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Registration Number</label>
                  <input type="text"
                    class="form-control" value="{{$account->registration_number}}" name="registration_number" id="" placeholder="Enter Registration Number">
                 </div>
              </div>
          </div>

          <div class="row  ">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Phone</label>
                <input type="text"
                  class="form-control" value="{{$account->phone}}" name="phone" id="" placeholder="Enter Phone Number">
               </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Email</label>
                <input type="text"
                  class="form-control" value="{{$account->email}}" name="email" id="" placeholder="Enter Email Address">
               </div>
            </div>
        </div>

        <div class="row  ">
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Annual Revenue</label>
              <input type="text"
                class="form-control" value="{{$account->annual_revenue}}" name="annual_revenue" id="" placeholder="Enter Annual Revenue">
             </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Number of Employees</label>
              <input type="text"
                class="form-control" value="{{$account->number_of_employees}}" name="number_of_employees" id="" placeholder="Enter Number of Employees">
             </div>
          </div>
      </div>
      <div class="row  ">
        <div class="col-md-6">
           <div class="form-group">
            <label for="">Account Type</label>
            <select class="form-control"  name="account_type" id="">
              @if ( $account->account_type === 'individual' )
              <option selected>Individual</option>
              <option>Business</option>
              @else
              <option >Individual</option>
              <option selected>Business</option>
              @endif              
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <div class="form-group">
                <label for="">Select Industry </label>
                <select class="form-control"  name="industry" id="">
                  <option selected disabled>Select Industry</option>
                  @foreach ($industries as $industry)
                    @if ($industry->industryID === $account->industryID )
                      <option value="{{$industry->industryID}}" selected>{{$industry->industry_name}}</option>
                    @else
                      <option value="{{$industry->industryID}}">{{$industry->industry_name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
           </div>
        </div>
    </div>
    <div class="row  ">
      <div class="col-md-6">
         <div class="form-group">
          <label for="">preferred_contact_method Type</label>
          <select class="form-control"   name="preferred_contact_method" id="">
            @if ( $account->preferred_contact_method === 'email' )
              <option value="email" selected>Email</option>
              <option value="phone">Phone</option>
              <option value="mail">Mail</option>
              <option value="sms">SMS</option>
            @elseif( $account->preferred_contact_method === 'phone')
              <option value="email" >Email</option>
              <option value="phone" selected>Phone</option>
              <option value="mail">Mail</option>
              <option value="sms">SMS</option>
            @elseif( $account->preferred_contact_method === 'mail')
              <option value="email" >Email</option>
              <option value="phone" >Phone</option>
              <option value="mail" selected>Mail</option>
              <option value="sms">SMS</option>
            @elseif( $account->preferred_contact_method === 'sms')
              <option value="email" >Email</option>
              <option value="phone" >Phone</option>
              <option value="mail">Mail</option>
              <option value="sms" selected>SMS</option>
            @else
              <option value="email" >Email</option>
              <option value="phone" >Phone</option>
              <option value="mail">Mail</option>
              <option value="sms" >SMS</option>
            @endif     
           
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <div class="form-group">
              <label> Opt-in for Marketing </label>
              <select class="form-control"   name="marketing_opt_in" id="">
                  @if ($account->marketing_opt_in)
                      <option selected value="1">Yes</option>
                      <option value="0">No</option>
                  @else
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                  @endif               
              </select>
            </div>
         </div>
      </div>
  </div>
   
    <hr>

    <div class="pb-3"> 
       <p class="h5">Address</p>
    </div>
    <div class="row  ">
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Street</label>
          <input type="text"
            class="form-control" value="{{$account->street}}" name="street" id="" placeholder="Enter Street Address">
         </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Suburb</label>
          <input type="text"
            class="form-control" value="{{$account->suburb}}" name="suburb" id="" placeholder="Enter Suburb">
         </div>
      </div>
  </div>
  <div class="row  ">
    <div class="col-md-6">
      <div class="form-group">
        <label for="">City</label>
        <input type="text"
          class="form-control" value="{{$account->city}}" name="city" id="" placeholder="Enter Enter">
       </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="">State</label>
        <input type="text"
          class="form-control" value="{{$account->state}}" name="state" id="" placeholder="Enter State/Province">
       </div>
    </div>
</div>
<div class="row  ">
  <div class="col-md-6">
    <div class="form-group">
      <label for="">Country</label>
      <input type="text"
        class="form-control" value="{{$account->country}}" name="country" id="" placeholder="Enter Country">
     </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="">Zip Code</label>
      <input type="text"
        class="form-control" value="{{$account->zip_code}}" name="zip_code" id="" placeholder="Enter Zip Code">
     </div>
  </div>
</div>
    <input type="hidden" name="accountID" value="{{$account->accountID}}">
<br>
<div class="">
  <div class="form-group">
    <label for="">Description/Notes</label>
    <textarea class="form-control" value="{{$account->notes}}" name="description" id="" rows="5"></textarea>
  </div>
</div>
 
        </div>
     </main>
    
    <script>
        const { createApp } = Vue;
             createApp({
                data() {
                  return {
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
               }
           }).mount("#app");
        </script>
</x-app-layout>
