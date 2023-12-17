<x-app-layout>

<main class="m-0  px-4 py-5   w-100">
  <div class="row mx-0 animated fadeInDown">
    <div class="col-12 text-center p-0 m-0">
        <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
    </div>
 </div>
<form action="{{ route('save_staff') }}" method="POST" class="card border rounded p-3 w-100">
  @csrf
  <div class="">
    <p class="h3">Enter Stuff Information</p>
  </div>
  <hr>
    <!-- 2 column grid layout with text inputs for the first and last names -->
    <div class="row mb-4">
      <div class="col">
        <div class="form-outline">
          <label class="form-label" for="form6Example1">First name</label>
          <input type="text" id="form6Example1" name="first_name" class="form-control" required />
        </div>
      </div>
      <div class="col">
        <div class="form-outline">
          <label class="form-label" for="form6Example2">Last name</label>
          <input type="text" id="form6Example2" name="last_name" class="form-control" required />
        </div>
      </div>
    </div>
  
    <!-- Text input -->
    <div class="row mb-4">
      <div class="col-md-6">
          <div class="form-outline mb-4">
            <label class="form-label" for="form6Example3">Email Address</label>
            <input type="email" id="form6Example3" name="email" class="form-control" required />
          </div>
      </div>
      <div class="col-md-6">
        <div class="form-outline mb-4">
          <label class="form-label" for="form6Example3">Phone Number</label>
          <input type="number" id="form6Example3" name="phone" class="form-control" />
        </div>
      </div>
    </div>
    <!-- Text input -->
    <div class="row mb-4">
      <div class="col-md-6">
          <div class="form-outline mb-4">
            <label class="form-label" for="form6Example3">New Password</label>
            <input type="password" id="form6Example3" name="password" class="form-control" required/>
          </div>
      </div>
      <div class="col-md-6">
        <div class="form-outline mb-4">
          <label class="form-label" for="form6Example3">Confirm Password</label>
          <input type="password" id="form6Example3" name="password_confirmation" class="form-control" required/>
        </div>
      </div>
    </div>
 
    
 
    {{-- <div class="py-3">
      <p class="h5">Job Description</p>
    </div>
    <hr>
 
    <div class="row">
      <div class="col-md-6">
        <div class="form-outline mb-4">
          <div class="form-group">
            <label for="">Select Store the Staff will work at...</label>
            <select class="form-control" name="role" id="">
              <option @disabled(true) @selected(true)>Select Store</option>          
              @foreach ($stores as $store)
              <option>{{$store->name}}</option>
              @endforeach
            </select>
          </div>
        </div>  
      </div>
      <div class="col-md-6">
        <div class="form-outline mb-4">
          <div class="form-group">
            <label for="">Select Role / Job Title</label>
            <select class="form-control" name="role" id="">
              <option @disabled(true) @selected(true)>Select Job Title</option>          
              @foreach ($departments as $role)
              <option>{{$role->role_title}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>

      <div class="form-outline mb-4">
      <label class="form-label" for="form6Example7">Additional information</label>
      <textarea class="form-control" id="form6Example7" name="comments" rows="4"></textarea>
    </div> --}}

    <!-- Submit button -->
    <button type="submit" class="btn btn-dark btn-block mb-4">Create new user</button>
  </form>
  <script>
      const API_TOKEN = "{{ env('API_TOKEN') }}";
      let api = API_TOKEN;
          console.log(API_TOKEN);
  </script>
</main>
</x-app-layout>
 

