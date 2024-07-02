 
<div class="card rounded p-1 w-100">
    <div class="d-flex justify-content-between">
      <div class="d-flex flex-column  pl-3 justify-content-center">
       <div class="  font-weight-bold"><span class="">{{$page}}</span></div>
      </div>
      <div class="">
        <a href="{{ route('crm_accounts') }}" class="btn btn-sm rounded btn-dark">Accounts</a>
        <a href="{{ route('crm_contacts') }}" class="btn btn-sm rounded btn-dark">Contacts</a>
        <a href="{{ route('crm_accounts') }}" class="btn btn-sm rounded btn-dark">Task</a>
        <a href="{{ route('crm_accounts') }}" class="btn btn-sm rounded btn-dark">Deals</a>
        <a href="{{ route('crm_accounts') }}" class="btn btn-sm rounded btn-dark">Leads</a>
        <a href="{{ route('crm_accounts') }}" class="btn btn-sm rounded btn-dark">Meetings</a>
      </div>
    </div>
  </div>
  <hr>
