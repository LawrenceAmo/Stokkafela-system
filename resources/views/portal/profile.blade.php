 <x-app-layout>
    <main class="m-0  px-4 pt-5   w-100">
 
      <div class="card mx-1 p-3">
        <div class="d-flex justify-content-between ">
          <div class="">
            <div class="">
              My Job Title
            </div>
            <div class="d-flex flex-column">              
              <span class="m-0">
                 {{$data->role_title}}  
              </span> 
              <i class="small m-0">
                {{$data->name}} - Department
              </i>
            </div>
          </div>
          <div class="d-flex flex-column justify-content-center">
            <button type="button" data-toggle="modal" data-target="#modelId"  class="btn btn-sm rounded btn-dark"> view job profile</button>
          </div>
        </div>
      </div>
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
                  value="{{$data->first_name}}"
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
                  value="{{$data->last_name}}"
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
                  value="{{$data->email}}"
                  aria-describedby="emailHelpId"
                  placeholder="example@domain.com"
                />
                 
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
                  value="{{$data->phone}}"
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
                  value="{{$data->street}}"
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
                  value="{{$data->suburb}}"
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
                  value="{{$data->city}}"
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
                  value="{{$data->state}}"
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
                  value="{{$data->country}}"
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
                  value="{{$data->zip_code}}"
                  placeholder="Enter your zip code"
                />
              </div>
            </div>
          </div>
          <div class="row m-0  justify-content-center">
            <div class="w-100">
              <button
                type="submit"                 
                class="btn btn-dark w-100 rounded">
                Update Your info
              </button>
            </div>
          </div>
        </form>
             
        <!-- Modal -->
        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">My Job Description</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="">
                  {!! $data->description !!}
                </div>
              </div>
              <div class="modal-footer">
                {{-- <button type="button" class="btn btn-dark btn-sm rounded">send mail</button> --}}
              </div>
            </div>
          </div>
        </div>
     </main>
</x-app-layout>
