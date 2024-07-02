<x-app-layout>
    <main class="m-0   px-4   w-100" id="app">
 
      <x-crm.crm-nav :page="'Create New Account Contacts'"/>

      <form action="{{ route('crm_contacts_store') }}" method="POST" class="card   rounded p-3 mb-5 w-100">
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
            <button class="btn btn-sm rounded btn-dark">Create New Contact Person</button>
          </div>
       </div>
           <div class="row  ">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">First Name</label>
                  <input type="text"
                    class="form-control" name="first_name" value="{{ old('first_name', $data["first_name"])}}" placeholder="Enter First Name">
                 </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Last Name</label>
                  <input type="text"
                    class="form-control" name="last_name" value="{{ old('last_name', $data["last_name"])}}" placeholder="Enter Last Name">
                 </div>
              </div>
           </div>
           <div class="row  ">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Title</label>
                     <select class="form-control"  name="title">
                      <option value="Mr.">Mr.</option>
                      <option value="Mrs.">Mrs.</option>
                      <option value="Miss">Miss</option>
                      <option value="Ms.">Ms.</option>
                      <option value="Dr.">Dr.</option>
                      <option value="Prof.">Prof.</option>
                      <option value="Rev.">Rev.</option>
                      <option value="Hon.">Hon.</option>
                      <option value="Capt.">Capt.</option>
                      <option value="Sir">Sir</option>
                      <option value="Madam">Madam</option>
                      <option value="Lord">Lord</option>
                  </select>
               </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Position</label>
                <input type="text"
                  class="form-control" name="position" value="{{ old('position', $data["position"])}}" placeholder="Enter position or job for this user">
               </div>
            </div>
         </div>

          <div class="row  ">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Phone</label>
                <input type="number"
                  class="form-control" name="phone" value="{{ old('phone', $data["phone"])}}" placeholder="Enter Phone Number">
               </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Secondary Phone</label>
                <input type="number"
                  class="form-control" name="alt_phone" value="{{ old('alt_phone', $data["alt_phone"])}}" id="" placeholder="Enter Email Secondary Phone">
               </div>
            </div>
        </div>

        <div class="row  ">                   
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Email</label>
              <input type="email"
                class="form-control" name="email" id="" value="{{ old('email', $data["email"])}}"  placeholder="Enter email address">
             </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Secondary Email</label>
              <input type="email"
                class="form-control" name="alt_email" id="" value="{{ old('alt_email', $data["alt_email"])}}"  placeholder="Enter Secondary Email Address">
             </div>
          </div>
      </div>
      <div class="row  ">                   
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Gender</label>
            <select class="form-control" name="gender" >
              <option value="male" selected>Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
           </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Date of Birth</label>
            <input type="date" class="form-control" value="{{ old('date_of_birth', $data["date_of_birth"])}}"  name="date_of_birth"  placeholder="Enter DOB">
           </div>
        </div>
    </div>
     
    <div class="row  ">
      <div class="col-md-6">
         <div class="form-group">
          <label for="">Preferred Contact Method </label>
          <select class="form-control" name="preferred_contact_method" >
            <option value="email" selected>Email</option>
            <option value="phone">Phone</option>
            <option value="mail">Mail</option>
            <option value="sms">SMS</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <div class="form-group">
              <label> Opt-in for Marketing </label>
              <select class="form-control" name="marketing_opt_in" id="">
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
              </select>
            </div>
         </div>
      </div>
  </div>
  <div class="row  ">
    <div class="col-md-6">
       <div class="form-group">
        <label for="">Status</label>
        <select class="form-control"  name="status">
              <option value="active" selected>active</option>
              <option value="inactive">inactive</option>
              <option value="pending">pending</option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
          <div class="form-group">
            <label for="">Account where this user belongs to </label>
            <select class="form-control"  name="accountID" id="">
              <option selected disabled>Select Company Name</option>
              @foreach ($accounts as $account)               
                  <option value="{{$account->accountID}}">{{$account->company_name}}</option>
              @endforeach
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
            class="form-control" name="street" value="{{ old('street', $data["street"])}}"  placeholder="Enter Street Address">
         </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Suburb</label>
          <input type="text"
            class="form-control" name="suburb" value="{{ old('suburb', $data["suburb"])}}"  placeholder="Enter Suburb">
         </div>
      </div>
  </div>
  <div class="row  ">
    <div class="col-md-6">
      <div class="form-group">
        <label for="">City</label>
        <input type="text"
          class="form-control" name="city" value="{{ old('city', $data["city"])}}"  placeholder="Enter Enter">
       </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="">State</label>
        <input type="text"
          class="form-control" name="state" value="{{ old('state', $data["state"])}}"  placeholder="Enter State/Province">
       </div>
    </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="">Country</label>
      <input type="text"
        class="form-control" name="country" value="{{ old('country', $data["country"]) }}"  placeholder="Enter Country">
     </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="">Zip Code</label>
      <input type="text"
        class="form-control" name="zip_code" value="{{ old('zip_code', $data["zip_code"]) }}"  placeholder="Enter Zip Code">
     </div>
  </div>
</div><br>
<div class="">
  <div class="form-group">
    <label for="">Description/Notes</label>
    <textarea class="form-control" name="description" value="{{ old('description', $data["description"])}}" id="" rows="5"></textarea>
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
