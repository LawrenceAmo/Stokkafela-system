<x-app-layout>
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <main class="m-0   px-4   w-100" id="app">
 
      <x-crm.crm-nav :page="'Create New Account'"/>

      <form action="{{ route('crm_accounts_store') }}" method="POST" class="card   rounded p-3 mb-5 w-100">
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
            <button class="btn btn-sm rounded btn-primary">Create New Account</button>
          </div>
       </div>
       <div class="border p-3 rounded">
            <div class="row  ">
              <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                      <label for="">Select Rep</label>
                      <select class="form-control" name="rep" id="">
                        <option selected disabled>Select Rep</option>
                        @foreach ($reps as $rep)
                          <option value="{{$rep->repID}}">{{$rep->first_name}} {{$rep->last_name}} ({{$rep->name}} - {{$rep->destributor_name}})</option>
                        @endforeach
                      </select>
                    </div>
                 </div>
              </div>
              
          </div>
       </div> <hr>
           <div class="row  ">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Company Name</label>
                  <input type="text"
                    class="form-control" name="company_name" value="{{ old('company_name', $data["company_name"])}}" placeholder="Enter Company Name">
                 </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Registration Number</label>
                  <input type="text"
                    class="form-control" name="registration_number" value="{{ old('registration_number', $data["registration_number"])}}" placeholder="Enter Registration Number">
                 </div> 
              </div>
          </div>

          <div class="row  ">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Phone</label>
                <input type="text"
                  class="form-control" name="phone" value="{{ old('phone', $data["phone"])}}" placeholder="Enter Phone Number">
               </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Email</label>
                <input type="text"
                  class="form-control" name="email" value="{{ old('email', $data["email"])}}" placeholder="Enter Email Address">
               </div>
            </div>
        </div>

        <div class="row  ">
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Annual Revenue</label>
              <input type="text"
                class="form-control" name="annual_revenue" value="{{ old('annual_revenue', $data["annual_revenue"])}}" placeholder="Enter Annual Revenue">
             </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Number of Employees</label>
              <input type="text"
                class="form-control" name="number_of_employees" value="{{ old('number_of_employees', $data["number_of_employees"])}}" placeholder="Enter Number of Employees">
             </div>
          </div>
      </div>
      <div class="row  ">
        <div class="col-md-6">
           <div class="form-group">
            <label for="">Account Type</label>
            <select class="form-control" name="account_type" id="">
              <option>Individual</option>
              <option>Business</option>
              <option></option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <div class="form-group">
                <label for="">Select Industry</label>
                <select class="form-control" name="industry" id="">
                  <option selected disabled>Select Industry</option>
                  @foreach ($industries as $industry)
                    <option value="{{$industry->industryID}}">{{$industry->industry_name}}</option>
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
          <select class="form-control" name="preferred_contact_method" id="">
            <option value="email">Email</option>
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
                <option value="1">Yes</option>
                <option value="0">No</option>
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
      <div class="col-md-12">
        <div class="form-group">
          <label for="">Start typing address (To autocomplete address)</label>
          <input type="text"
            class="form-control" value="" id="location-input"  placeholder="Enter Street Address">
         </div>
      </div>     
  </div>
    <div class="row  ">
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Street</label>
          <input type="text"
            class="form-control" name="street" id="street" value="{{ old('street', $data["street"])}}"  placeholder="Enter Street Address">
         </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="">Suburb</label>
          <input type="text"
            class="form-control" name="suburb" id="suburb" value="{{ old('suburb', $data["suburb"])}}"  placeholder="Enter Suburb">
         </div>
      </div>
  </div>
  <div class="row  ">
    <div class="col-md-6">
      <div class="form-group">
        <label for="">City</label>
        <input type="text"
          class="form-control" name="city" id="city" value="{{ old('city', $data["city"])}}"  placeholder="Enter Enter">
       </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="">State</label>
        <input type="text"
          class="form-control" name="state" id="state" value="{{ old('state', $data["state"])}}"  placeholder="Enter State/Province">
       </div>
    </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="">Country</label>
      <input type="text"
        class="form-control" name="country"  id="country" value="{{ old('country', $data["country"]) }}"  placeholder="Enter Country">
     </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="">Zip Code</label>
      <input type="text"
        class="form-control" name="zip_code"  id="zip_code" value="{{ old('zip_code', $data["zip_code"]) }}"  placeholder="Enter Zip Code">
     </div>
  </div>
</div><br>
<div class="">
  <div class="form-group">
    <label for="">Description/Notes</label>
    <textarea class="form-control" name="description" id="notes" value="{!! old('description', $data["description"]) !!}" id="" cols="10" rows="10"></textarea>
  </div>
</div>
 
        </div>
     </main>

     <script>
        ClassicEditor.create( document.querySelector( '#notes' ) )
        .catch( error => {
          console.error( error );
        } );
        
     </script>
     <script>
      
         function initMap() {
        
         const getFormInputElement = (component) => document.getElementById(component + '-input');
         const getElementID = (component) => document.getElementById(component);
        const autocompleteInput = getFormInputElement('location');
        const autocomplete = new google.maps.places.Autocomplete(autocompleteInput, {
         componentRestrictions: { country: 'ZA' }, fields: ["address_components", "geometry", "name"], types: ["address"],
        });
        autocomplete.addListener('place_changed', function () {
           const place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert('No details available for input: \'' + place.name + '\'');
            return;
          }
           fillInAddress(place);
        });
   
        function fillInAddress(place) {  // optional parameter
          const addressNameFormat = {
            'street_number': 'long_name',
            'route': 'long_name',
            'locality': 'long_name',
            'administrative_area_level_1': 'long_name',
            'country': 'long_name',
            'postal_code': 'long_name',
            'sublocality': 'long_name', 
             'sublocality_level_1': 'long_name',  
             'sublocality_level_2': 'long_name'
          };
 
          const getAddressComp = function (type) {
            for (const component of place.address_components) {
              if (component.types[0] === type) {
 
                return component[addressNameFormat[type]];
              }
            }
            return '';
          };
          getElementID('street').value = getAddressComp('street_number')+ ' '+ getAddressComp('route');
          getElementID('suburb').value = getAddressComp('sublocality_level_1') || getAddressComp('sublocality_level_2');
          getElementID('city').value = getAddressComp('locality');
          getElementID('state').value = getAddressComp('administrative_area_level_1');
          getElementID('country').value = getAddressComp('country');
          getElementID('zip_code').value = getAddressComp('postal_code');
          let location = 
                     getAddressComp('street_number')+', '+
                     getAddressComp('route')+', '+
                     getAddressComp('sublocality_level_1') +', '+
                     getAddressComp('locality')+', '+
                     getAddressComp('administrative_area_level_1')+', '+
                     getAddressComp('country')+', '+
                     getAddressComp('postal_code');
 
                     getFormInputElement('location').value = location
 
                   // if locality = to my suburbs and county = gp then enable shop
           // set_location(getAddressComp('locality')) 
          //  console.log(location)
   
        } 
      }
   </script>

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
