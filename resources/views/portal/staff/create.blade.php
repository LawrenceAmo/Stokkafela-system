<x-app-layout>

<main class="m-0  px-4 py-5   w-100">

<form class="card border rounded p-3 w-100">

    <!-- 2 column grid layout with text inputs for the first and last names -->
    <div class="row mb-4">
      <div class="col">
        <div class="form-outline">
          <input type="text" id="form6Example1" class="form-control" />
          <label class="form-label" for="form6Example1">First name</label>
        </div>
      </div>
      <div class="col">
        <div class="form-outline">
          <input type="text" id="form6Example2" class="form-control" />
          <label class="form-label" for="form6Example2">Last name</label>
        </div>
      </div>
    </div>
  
    <!-- Text input -->
    <div class="form-outline mb-4">
      <input type="text" id="form6Example3" class="form-control" />
      <label class="form-label" for="form6Example3">Company name</label>
    </div>
  
    <!-- Text input -->
    <div class="form-outline mb-4">
      <input type="text" id="form6Example4" class="form-control" />
      <label class="form-label" for="form6Example4">Address</label>
    </div>
  
    <!-- Email input -->
    <div class="form-outline mb-4">
      <input type="email" id="form6Example5" class="form-control" />
      <label class="form-label" for="form6Example5">Email</label>
    </div>
  
    <!-- Number input -->
    <div class="form-outline mb-4">
      <input type="number" id="form6Example6" class="form-control" />
      <label class="form-label" for="form6Example6">Phone</label>
    </div>
  
    <!-- Message input -->
    <div class="form-outline mb-4">
      <textarea class="form-control" id="form6Example7" rows="4"></textarea>
      <label class="form-label" for="form6Example7">Additional information</label>
    </div>
  
    <!-- Checkbox -->
    {{-- <div class="form-check d-flex  mb-4">
      <input class="form-check-input me-2" type="checkbox" value="" id="form6Example8" checked />
      <label class="form-check-label" for="form6Example8"> Create an account? </label>
    </div> --}}

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
