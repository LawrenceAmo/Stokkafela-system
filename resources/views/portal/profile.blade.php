 <x-app-layout>
    <main class="m-0  px-4   w-100">
 
      <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div> 

         <form method="POST"action="{{ route('update_profile')}}"
          class="form-container shadow-2xl bg-white border rounded p-3 mb-5 w-100"
        >
        @csrf
          
          <div class="row m-0   ">
            <div class="col-md-6 py-2  ">
              <div class="form-group">
                <label for="">First Name</label>
                <input
                  type="text"
                  class="form-control"
                  name="first_name"
                  value="{{$user->first_name}}"
                   placeholder="First Name"
                />
              </div>
            </div>
            <div class="col-md-6 py-2">
              <div class="form-group">
                <label for="">Last Name</label>
                <input
                  type="text"
                  class="form-control"
                  name="last_name"
                  value="{{$user->last_name}}"
                   placeholder="Last Name"
                />
              </div>
            </div>
          </div>
          <div class="row m-0 ">
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Email Address</label>
                <input
                  type="email"
                  class="form-control"
                  name="email"
                  autocomplete="off"
                  value="{{$user->email}}"
                  aria-describedby="emailHelpId"
                  placeholder="example@domain.com"
                />
                <small id="emailHelpId" class="form-text text-muted"
                  >strong</small
                >
              </div>
            </div>
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Enter your Password to update</label>
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  autocomplete="off"
                  value="" 
                  placeholder="Enter strong password"
                />
                <small id="" class="form-text text-muted">strong</small>
              </div>
            </div>
          </div>
          <div class="row m-0 ">
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Phone Number</label>
                <input
                  type="text"
                  class="form-control"
                  name="phone"
                  value="{{$user->phone}}"
                  placeholder="Enter your contact number"
                />
              </div>
            </div>
            <div class="col-md-6 py-2 ">
              {{-- --}} 
            </div>
          </div>
          <div class="row m-0  border-top mt-3">
            <div class="d-flex flex-column w-100">
         

              <h3>Address</h3>
            </div>
          </div>
          <div class="row m-0 ">
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Street Address</label>
                <input
                  type="text"
                  class="form-control"
                  name="street"
                  value="{{$contacts->street}}"
                   placeholder="street name and number"
                />
              </div>
            </div>
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Suburb</label>
                <input
                  type="text"
                  class="form-control"
                  name="suburb"
                  value="{{$contacts->suburb}}"
                   placeholder="Enter your surbub"
                />
              </div>
            </div>
          </div>
          <div class="row m-0 ">
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">City</label>
                <input
                  type="text"
                  class="form-control"
                  name="city"
                  value="{{$contacts->city}}"
                  placeholder="Enter your City"
                />
              </div>
            </div>
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Province</label>
                <input
                  type="text"
                  class="form-control"
                  name="pronvince"
                  value="{{$contacts->state}}"
                  placeholder="Enter Province"
                />
              </div>
            </div>
          </div>
          <div class="row m-0 ">
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Country</label>
                <input
                  type="text"
                  class="form-control"
                  name="country"
                  value="{{$contacts->country}}"
                  placeholder="Enter your Country"
                />
              </div>
            </div>
            <div class="col-md-6 py-2 ">
              <div class="form-group">
                <label for="">Zip Code</label>
                <input
                  type="number"
                  class="form-control"
                  name="zip_code"
                  value="{{$contacts->zip_code}}"
                  placeholder="Enter your zip code"
                />
              </div>
            </div>
          </div>
          <div class="row m-0  justify-content-center">
            <div class="w-50">
              <button
                type="submit"
                 
                class="btn btn-info w-100 rounded"
                
              >
                Save Address
              </button>
            </div>
          </div>
        </form>
     </main>
</x-app-layout>
