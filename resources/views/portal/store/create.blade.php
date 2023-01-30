 <x-app-layout>

<main class="m-0  px-4 w-100">

    <div class="card border rounded p-5  ">
         <div class="row mx-0 animated fadeInDown">
        <div class="col-12   p-0 m-0">
            <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
        </div>
     </div> 

       <form class="" action="{{ route("save_store")}}" method="POST">
         @csrf
      <div class="row">   
          <div class="col-md-6 pt-3">
            <div class=" ">
                <label for="" class="  ">Store Name</label>
                <input type="text" class="form-control " name="store_name"    placeholder="Store Name">
            </div>
          </div>

            <div class="col-md-6 pt-3">
            <div class=" ">
                <label for="" class="  ">Trading or Short Name</label>
                <input type="text" class="form-control " name="trading_name" id=""   placeholder="Trading or Short Store Name">
            </div>
          </div>
      </div>

          <div class="row pt-md-4">   
            <div class="col-md-6 pt-3">
                <div class=" ">
                    <label for="" class="  ">Store Slogan</label>
                <textarea name="slogan" class="form-control" id="" cols="2" rows="2"></textarea>
            </div>
          </div>

            <div class="col-md-6 pt-3">
            <div class=" ">
                <label for="" class="  ">Store Description</label>
                 
                  <textarea class="form-control" name="description" id=""    rows="2"></textarea>
             </div>
          </div>
      </div>
      
      {{-- ////////////////////////////////////////////////////////////////// --}}

      <div class="d-flex flex-column w-100 my-3 pt-3">
         

        <h3>Address</h3>
      </div>
     <div class="row m-0 ">
      <div class="col-md-6 py-2 ">
        <div class="form-group">
          <label for="">Store Phone Number</label>
          <input
            type="text"
            class="form-control"
            name="phone"
            value=""
            placeholder="Enter your contact number"
          />
        </div>
      </div>
      <div class="col-md-6 py-2 ">
        <div class="form-group">
          <label for="">Store Email Address</label>
          <input
            type="text"
            class="form-control"
            name="email"
            value=""
            placeholder="Enter your contact number"
          />
        </div>
      </div>
    </div>
    <hr>
    <div class="row m-0 ">
      <div class="col-md-6 py-2 ">
        <div class="form-group">
          <label for="">Street Address</label>
          <input
            type="text"
            class="form-control"
            name="street"
            value=""
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
            value=""
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
            value=""
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
            value="Gauteng"
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
            value="South Africa"
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
            value=""
            placeholder="Enter your zip code"
          />
        </div>
      </div>
    </div>


      {{-- /////////////////////////////////////////////////////////////////////////// --}}

      {{-- <div class="row mt-3 pt-3">
        <label class="custom-control custom-checkbox ">
          <input type="checkbox" name="terms_and_conditions" value="true" class="custom-control-input">
          <span class="custom-control-indicator small">By creating a store you agree to our Terms & Conditions</span>
         </label>
       </div> --}}

      <div class="row-cols-12 mt-3 py-3  ">
        <button type="submit" class="btn btn-info w-100">Create Your Store</button>
      </div>

       </form>
    </div>


</main>

 </x-app-layout>
