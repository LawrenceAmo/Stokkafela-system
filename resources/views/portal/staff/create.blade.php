<x-app-layout>

<main class="m-0  px-4 py-5   w-100">

<form class="card border rounded p-3 w-100">
  <div class="">
    <p class="h3">Enter Stuff Information</p>
  </div>
  <hr>
    <!-- 2 column grid layout with text inputs for the first and last names -->
    <div class="row mb-4">
      <div class="col">
        <div class="form-outline">
          <label class="form-label" for="form6Example1">First name</label>
          <input type="text" id="form6Example1" class="form-control" />
        </div>
      </div>
      <div class="col">
        <div class="form-outline">
          <label class="form-label" for="form6Example2">Last name</label>
          <input type="text" id="form6Example2" class="form-control" />
        </div>
      </div>
    </div>
  
    <!-- Text input -->
    <div class="form-outline mb-4">
      <label class="form-label" for="form6Example3">ID Number</label>
      <input type="text" id="form6Example3" class="form-control" />
    </div>

    <div class="row mb-4">
      <div class="col">
        <div class="form-group">
          <label for="">Gender</label>
          <select class="form-control" name="" id="">
            <option selected disabled>Select Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Prefer Not to Say</option>
          </select>
        </div>
      </div>
    <div class="col">
      <div class="form-group">
        <label for="">Gender</label>
        <select class="form-control" name="" id="">
          <option selected disabled>Select Gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Prefer Not to Say</option>
        </select>
      </div>
    </div>
   </div>

    <div class="py-3">
      <p class="h5">Address Information</p>
    </div>
  
    <!-- Text input -->
    <div class="form-outline mb-4">
      <input type="text" id="form6Example4" class="form-control" />
      <label class="form-label" for="form6Example4">Street Address</label>
    </div>
  
    <!-- Email input -->
    <div class="form-outline mb-4">
      <input type="text" id="form6Example5" class="form-control" />
      <label class="form-label" for="form6Example5">Surbub</label>
    </div>
  
    <!-- Text input -->
    <div class="form-outline mb-4">
      <input type="text" id="form6Example6" class="form-control" />
      <label class="form-label" for="form6Example6">City</label>
    </div>

     <!-- Text input -->
     <div class="form-outline mb-4">
      <input type="text" id="form6Example6" class="form-control" />
      <label class="form-label" for="form6Example6">Zip Code</label>
    </div>

     <!-- Text input -->
     <div class="form-outline mb-4">
      <input type="text" id="form6Example6" class="form-control" />
      <label class="form-label" for="form6Example6">Country</label>
    </div>


    <div class="py-3">
      <p class="h5">Job Description</p>
    </div>
    <hr>

    <!-- Message input -->
    <div class="form-outline mb-4">
      <textarea class="form-control" id="form6Example7" rows="4"></textarea>
      <label class="form-label" for="form6Example7">Additional information</label>
    </div>

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

    <!-- Submit button -->
    <button type="submit" class="btn btn-info btn-block mb-4">Create user</button>
  </form>
</main>
</x-app-layout>


