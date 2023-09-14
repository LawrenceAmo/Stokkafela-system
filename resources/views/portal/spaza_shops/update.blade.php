<x-app-layout>
    <main class="m-0  px-4 py-4   w-100" id="app">
      
   
    <form action="{{ route('update_spaza_shop') }}" enctype="multipart/form-data" method="post" class="card border rounded p-3 w-100 table-responsive">
        @csrf
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<div class="font-weight-bold h4 p-2 row">
    <div class="col-md-6 p-0 m-0">
        <span class="  "> Update Spaza Shop  </span>
    </div> 
    <div class=" col-md-6 p-0 m-0 d-flex justify-content-end pr-3  ">
     <button  class="btn btn-info rounded btn-sm" type="submit" >  Update Shop  </button> 
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
          <label for="">Shop Name</label>
          <input type="text" class="form-control" v-model="name" name="name" placeholder="Enter Store Name" >
        </div>
        <div class="form-group">
            <label for="">Address</label>
            <input type="text" v-model="address" @input="handleAddressChange" class="form-control" name="address" placeholder="Enter Store Address" >
        </div>
        <div class="form-group">
            <label for="">Select Rep</label>
            <select class="form-control" name="rep" id="">
              <option selected disabled>Select Rep</option>
             @foreach ($reps as $rep)
                @if ((int)$rep->repID === (int)$shop->repID )
                   <option class="" value="{{ $rep->repID}}" selected>{{ $rep->first_name}} {{ $rep->last_name}}</option>
                @else
                  <option class="" value="{{ $rep->repID}}">{{ $rep->first_name}} {{ $rep->last_name}}</option>
                @endif
             @endforeach

            </select>
          </div>
        <div class="form-group">
          <label for="">Shop Coordinates (optional)</label>
          <div class="w-100 d-flex">
            <input type="text" v-model="lat" class="form-control w-50" name="lat" placeholder="Latitude" >
            <input type="text" v-model="lng" class="form-control w-50" name="lng" placeholder="Longitude" >
          </div>
          <small class="text-muted">e.g 'Stokkafela Tembisa' / 'Mabebeza Bambanani'</small>
        </div>
        <div class="form-check pb-3">
          <label class="form-check-label">
            <input class="form-check-input" name="delete_photo" id="" type="checkbox"   aria-label="Text for screen reader">
          Delete Photo
        </label>
        </div>
        <div class="form-group">
            <label for="">Shop Photo</label>
            <input type="file" class="form-control"   name="photo" placeholder="Enter Store Address" >
        </div> 
        
        <input type="hidden" name="spaza_shopID" value="{{ $shop->spaza_shopID}}" id="">
       
    </div>
    <div class="col-md-6">

        <div class="d-flex justify-content-center">
            <img src="{{ asset('storage/spazashops/'.$shop->photo) }}" class="w-75 rounded p-1 border shadow" alt="">
        </div>
    </div>
</div>
 
    </form>

  
    </main>
    <script> 

     
  const { createApp } = Vue;
      createApp({
        data() {
          return { 
            shops: [],
            name: "",
            lat: "", 
            lng: "", 
            address: "", 
          }          
        },
       async created() {
        let shop = @json($shop);
        this.shop = shop
        this.lat = shop.lat;
        this.lng = shop.lng;
        this.address = shop.address;
        this.name = shop.name;
        console.log(shop)   
       
        },
        methods:
        {
            handleAddressChange: function(){
                let googleMapsUrl = this.address
                let regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;

                // Extract coordinates using the regular expression
                let matches = googleMapsUrl.match(regex);                
                if (matches && matches.length === 3) {
                    this.lat = parseFloat(matches[1]);
                    this.lng = parseFloat(matches[2]);  
                }
            },   
            shopImg: function (val) {
                return `{{ asset('storage/spazashops/${val}')}}`;
            },    
            titleCase: function(str) {
                var splitStr = str.toLowerCase().split(' ');
                for (var i = 0; i < splitStr.length; i++) {
                     // Assign it back to the array
                    splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
                }
                // Directly return the joined string
                return splitStr.join(' '); 
            },
            productUpdateUrl: function(val){
                var link = document.getElementById('productUpdateUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('productID', val)
                location.href = href
            },
            shopDeleteUrl: function(val){
                var link = document.getElementById('shopDeleteUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('spaza_shopID', val)
                location.href = href
                // console.log(href)
            },           
        }
   }).mount("#app");
 
    </script>
</x-app-layout>
