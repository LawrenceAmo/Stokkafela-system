 <x-app-layout>
    <main class="m-0  px-4   w-100">
 
      <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div>
         <form method="POST"action="{{ route('update_staff_profile') }}"
          class="form-container card  p-3 border rounded">
        @csrf          
          <div class="row  m-0     ">
            <div class="col-md-6  w-100  "> 
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
             <div class="col-md-6  ">
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
          <div class="row m-0 w-100   ">
            <div class="col-md-6  ">
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

              </div>
            </div>
            <div class="col-md-6  ">
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
          </div>
       
          <div class="row m-0 w-100     -top mt-3">
            <div class="d-flex flex-column w-100">
         

              <h3>Address</h3>
            </div>
          </div>
          <div class="row m-0 w-100   ">
            <div class="col-md-6  ">
              <div class="form-group">
                <label for="">Street Address</label>
                <input
                  type="text"
                  class="form-control"
                  name="street"
                  value="{{$user->street}}"
                   placeholder="street name and number"
                />
              </div>
            </div>
            <div class="col-md-6  ">
              <div class="form-group">
                <label for="">Suburb</label>
                <input
                  type="text"
                  class="form-control"
                  name="suburb"
                  value="{{$user->suburb}}"
                   placeholder="Enter your surbub"
                />
              </div>
            </div>
          </div>
          <div class="row m-0 w-100   ">
            <div class="col-md-6  ">
              <div class="form-group">
                <label for="">City</label>
                <input
                  type="text"
                  class="form-control"
                  name="city"
                  value="{{$user->city}}"
                  placeholder="Enter your City"
                />
              </div>
            </div>
            <div class="col-md-6  ">
              <div class="form-group">
                <label for="">Province</label>
                <input
                  type="text"
                  class="form-control"
                  name="state"
                  value="{{$user->state}}"
                  placeholder="Enter Province"
                />
              </div>
            </div>
          </div>
          <div class="row m-0 w-100   ">
            <div class="col-md-6  ">
              <div class="form-group">
                <label for="">Country</label>
                <input
                  type="text"
                  class="form-control"
                  name="country"
                  value="{{$user->country}}"
                  placeholder="Enter your Country"
                />
              </div>
            </div>
            <div class="col-md-6  ">
              <div class="form-group">
                <label for="">Zip Code</label>
                <input
                  type="number"
                  class="form-control"
                  name="zip_code"
                  value="{{$user->zip_code}}"
                  placeholder="Enter your zip code"
                />
              </div>
            </div>
          </div>
          <div class="">
               <div class="py-3">
      <p class="h5">Job Description</p>
    </div>
    <hr>
 
    <div class="row">     
      <div class="col-md-6"     > <div class="form-outline mb-4">
          <div class="form-group">
            <label for="">Select Role / Job Title</label>
            <select class="form-control" name="role" id="">
              <option @disabled(true) @selected(true)>Select Job Title</option>          
              @foreach ($roles as $role)
                @if ($user->roleID === $role->roleID)
                  <option value="{{$role->roleID}}" @selected(true)>{{$role->role_title}}</option>
                @endif
                @if ($user->roleID != $role->roleID)
                  <option value="{{$role->roleID}}">{{$role->role_title}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6"   >   <div class="form-outline mb-4">
        <div class="form-group">
          <label for="">Staff Employment Status?</label>
          <select class="form-control" name="role_status" id="">
        
            @if ($user->role_status)
                <option value="1" selected>Active</option>
                <option value="">Inactive</option>
            @else
                <option value="" selected>Inactive</option>
                <option value="1">Active</option>
            @endif 
        </select>
       </div>
      </div>  
    </div>
    </div>
      <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="user_managers">Select Manager(s) for this User:</label>
          <select multiple class="form-control" name="user_managers[]" id="user_managers">
            <option selected disabled>Select Manager for this user</option>
            @foreach ($user_roles as $user_role)
            <option value="{{ $user_role->id }}">{{ $user_role->first_name }} {{ $user_role->last_name }} - <i class="">{{ $user_role->role_title }}</i></option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <label>Current managers for this user</label>
        <div class="">
              <div class="">
                <table class="table">
                  <thead>
                    <tr class="p-0">
                      <th>#</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user_managers as $managers)
                    <tr>
                      <td scope="row"></td>
                      <td>{{$managers->first_name}}</td>
                      <td>{{$managers->last_name}}</td>
                    </tr> 
                    @endforeach                
                  </tbody>
                </table>
              </div>
         
        </div>
      </div>
      </div>
      <div class="form-outline mb-4">
      <label class="form-label" for="form6Example7">Additional information</label>
      <textarea class="form-control" id="form6Example7" name="comments" rows="4"></textarea>
    </div>
          </div>
          <div class="row m-0 w-100 justify-content-center">
            <div class="w-100">
              <button type="submit" class="btn btn-dark w-100 rounded">
                Update Your info
              </button>
            </div>
          </div>
          <input type="hidden" name="id" value="{{ $user->id }}" id="">
        </form>
     </main>
</x-app-layout>
