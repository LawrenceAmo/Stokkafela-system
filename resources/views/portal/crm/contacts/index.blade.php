<x-app-layout>
    <main class="m-0   px-4   w-100" id="app">
 
      <x-crm.crm-nav :page="'Contacts'"/>

      <div class="card   rounded p-3 w-100">

      <div class="row mx-0 animated fadeInDown">
          <div class="col-12 text-center p-0 m-0">
              <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
          </div>
      </div>
      <div class="">
        <div class="d-flex justify-content-between">
          <p class="">
            All Customers
          </p>
          <div class="w-75 row   ">
            <div class="form-group col-9  px-0">
              <input type="text"
                class="form-control" name="" id=""   placeholder="Seach Customer by Name...">
            </div>
            <div class=" col-3  ">
              <a href="{{ route('crm_contacts_create') }}" class="btn btn-sm btn-dark py-2 rounded">Create new Customer</a>
            </div>

          </div>
           
        </div>
        <hr>
        <div class="">
          <div class="">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Names</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address (City)</th>
                  <th>Position</th>
                  <th>Company Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
               @foreach ($contacts as $i => $contact)
                  <tr>
                    <td scope="row">{{$i+1}}</td>
                      <td><a class="" href="{{ route('crm_contacts_update', [$contact->account_contactID]) }}">{{ $contact->first_name }} {{ $contact->last_name }}</a></td>
                      <td>{{ $contact->email ? $contact->email : "N/A"}}</td>
                      <td>{{ $contact->phone ? $contact->phone : "N/A"}}</td>
                      <td>{{ $contact->city ? $contact->city : "N/A"}} </td>
                      <td>{{ $contact->position ? $contact->position : "N/A"}}</td>
                      <td>{{ $contact->company_name }}</td>
                      <td>
                          <a class="" href="{{ route('crm_contacts_update', [$contact->account_contactID]) }}"><i class="fa fa-pencil-alt" aria-hidden="true"></i> update</a>
                      </td>
                  </tr>
               @endforeach
              </tbody>
            </table>
          </div>
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
