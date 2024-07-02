<x-app-layout>
    <main class="m-0   px-4   w-100" id="app">
 
      <x-crm.crm-nav :page="'Accounts'"/>

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
                class="form-control" name="" id=""   placeholder="Seach Customer by Name...(not active yet)">
            </div>
            <div class=" col-3  ">
              <a href="{{ route('crm_accounts_create') }}" class="btn btn-sm btn-dark py-2 rounded">Create new Customer</a>
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
                  <th>Account</th>
                  <th>Rep Name</th>
                  <th>Contact Person</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Surbub & City</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
               @foreach ($accounts as $i => $account)
                  <tr>
                    <td scope="row">{{$i+1}}</td>
                      <td><a class="" href="{{ route('crm_accounts_update', [$account->accountID]) }}">{{ $account->company_name }}</a></td>
                      <td>{{ !is_null($account->first_name) ? $account->first_name.' '.$account->last_name : "N/A"}}</td>
                      <td>{{ !is_null($account->contact_name) ? $account->contact_name.' '.$account->contact_surname : "N/A"}}</td>
                      <td>{{ $account->phone ? $account->phone : "N/A"}}</td>
                      <td title="{{ !is_null($account->contact_email) ? $account->contact_email : "N/A"}}" >{{ $account->email ? $account->email : "N/A"}}</td>
                      <td>{{ $account->city ? $account->city : "N/A"}} </td>
                      <td> {{ $account->created_at }} </td>
                      <td>
                        <a class="text-info" href="{{ route('crm_accounts_update', [$account->accountID]) }}"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a> &nbsp; | &nbsp;
                        <a class="text-success" href="{{ route('crm_account', [$account->accountID]) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
