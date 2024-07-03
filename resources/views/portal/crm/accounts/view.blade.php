<x-app-layout>
    <main class="m-0   px-4   w-100" id="app">
 
      <x-crm.crm-nav :page="'Accounts'"/>

      <hr>
      <div class="card   rounded p-3 w-100">
        <div class="row pb-2">
          <div class="col-md-4"><a  href="{{ route('crm_accounts_update', [$account->accountID]) }}" class="btn btn-sm rounded btn-outline-dark">update account</a></div>
          <div class="col-md-4 text-center"><h3 class="font-weight-bold">Account</h3></div>
          <div class="col-md-4"></div>
        </div> <hr>
        <div class="row">
          <div class="col-md-6 px-3">
            <div class="text-center pb-3">
              <p class="font-weight-bold">Account Details</p>
            </div>
            <table class="table">
              <tbody>
                <tr>
                  <td class="font-weight-bold">Account Name</td>
                  <td class="font-weight-normal">{{ $account->company_name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Registration Number </td>
                  <td class="font-weight-normal">{{ $account->registration_number }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Annual Revenue</td>
                  <td class="font-weight-normal">R{{ number_format((int)$account->annual_revenue,2) }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Number of Employees</td>
                  <td class="font-weight-normal">{{ $account->number_of_employees }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Account Type</td>
                  <td class="font-weight-normal">{{ $account->account_type }}</td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  {{-- <td class="font-weight-bold">Account Name</td>
                  <td class="font-weight-normal">{{ $account->company_name }}</td> --}}
                </tr>
                
                
              </tbody>
            </table> 
          </div> 
{{-- <div class="col-md-2  "><div class="border-left"></div></div> --}}
          <div class="col-md-6 px-3">
            <div class="text-center pb-3">
              <p class="font-weight-bold">Account Address</p>
            </div>
            <table class="table">
              <tbody>
                <tr>
                  <td class="font-weight-bold">Street Address</td>
                  <td class="font-weight-normal">{{ $account->street }}, {{ $account->suburb }}</td>
                </tr>                
                <tr>
                  <td class="font-weight-bold">City </td>
                  <td class="font-weight-normal">{{ $account->city }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">State/Province </td>
                  <td class="font-weight-normal">{{ $account->state }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Country </td>
                  <td class="font-weight-normal">{{ $account->country }}</td>
                </tr><tr>
                  <td class="font-weight-bold">Postal Code </td>
                  <td class="font-weight-normal">{{ $account->zip_code }}</td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                </tr>
             
              </tbody>
            </table> 
          </div>
        </div>       
      </div>

      <hr class="my-3">
      <div class="card   rounded p-3 w-100">
        <div class="row pb-2">
          <div class="col-md-4"><a href="{{ route('crm_contacts_update', [$account->account_contactID]) }}" class="btn btn-sm rounded btn-outline-dark">update contact person</a></div>
          <div class="col-md-4 text-center"><h3 class="font-weight-bold">Contact Person</h3></div>
          <div class="col-md-4"></div>
        </div> <hr>
        <div class="row">
          <div class="col-md-6 px-3">
            <div class="text-center pb-3">
              <p class="font-weight-bold">Contact Person Details</p>
            </div>
            <table class="table">
              <tbody>
                <tr>
                  <td class="font-weight-bold">Full Names</td>
                  <td class="font-weight-normal">{{ $account->contact_name }} {{ $account->contact_surname }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold"> Email </td>
                  <td class="font-weight-normal">{{ $account->contact_email ? $account->contact_email  : 'N/A' }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Phone </td>
                  <td class="font-weight-normal">{{ $account->contact_phone ?  $account->contact_phone : 'N/A'}}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Position </td>
                  <td class="font-weight-normal">{{ $account->position ?  $account->position : 'N/A'}}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Gender </td>
                  <td class="font-weight-normal">{{ $account->gender ? $account->gender : 'N/A'}}</td>
                </tr>
                    
              </tbody>
            </table> 
          </div> 
{{-- <div class="col-md-2  "><div class="border-left"></div></div> --}}
          <div class="col-md-6 px-3">
            <div class="text-center pb-3">
              <p class="font-weight-bold">Rep Details</p>
            </div>
            <table class="table">
              <tbody>
                <tr>
                  <td class="font-weight-bold">Rep Full Names</td>
                  <td class="font-weight-normal">{{ $account->rep_name }} {{ $account->rep_surname }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Store </td>
                  <td class="font-weight-normal">{{ $account->store_name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Destribution </td>
                  <td class="font-weight-normal">{{ $account->destributor_name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Customer Account Created At </td>
                  <td class="font-weight-normal">{{ $account->account_created_at }}</td>
                </tr>
                <tr>
                  <td></td>  
                  <td></td>  
                </tr> 
             
              </tbody>
            </table> 
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
