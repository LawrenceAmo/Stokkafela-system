<x-app-layout>
    <main class="m-0  px-4 py-4   w-100" id="app">
      
   
    <form action="{{ route('update_store_location') }}" enctype="multipart/form-data" method="post" class="card border rounded p-3 w-100 table-responsive">
        @csrf
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<div class="font-weight-bold h4 p-2 row">
    <div class="col-md-6 p-0 m-0">
        <span class="  "> Update Store Location </span>
    </div> 
    <div class=" col-md-6 p-0 m-0 d-flex justify-content-end pr-3  ">
     <button  class="btn btn-info rounded btn-sm" type="submit" >  Update Shop  </button> 
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
          <label for="">Store Name</label>
          <input type="text" class="form-control" v-model="name" name="name" placeholder="Enter Store Name" >
        </div>
        <div class="form-group">
            <label for="">Address</label>
            <input type="text" v-model="address" @input="handleAddressChange" class="form-control" name="address" placeholder="Enter Store Address" >
        </div>
        <div class="form-group">
            <label for="">Google Map Address Link</label>
            <input type="text" v-model="map_link" @input="handleAddressChange" class="form-control" name="map_link" placeholder="Enter Store Google Map Address Link" >
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
        
        <input type="hidden" name="store_locationID" value="{{ $store->store_locationID}}" id="">
       
    </div>
    <div class="col-md-6">

        <div class="d-flex justify-content-center">
            <img src="{{ asset('storage/stores/'.$store->photo) }}" class="w-75 rounded p-1 border shadow" alt="">
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
            map_link: "", 
          }          
        },
       async created() {
        let shop = @json($store);
        this.shop = shop
        this.lat = shop.lat;
        this.lng = shop.lng;
        this.address = shop.address;
        this.map_link = shop.map_link;
        this.name = shop.name;
        console.log(shop)   
       
        },
        methods:
        {
          handleAddressChange: function(){
                let googleMapsUrl = this.map_link
                let regexLong = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
                let regexShort = /q=(-?\d+\.\d+),(-?\d+\.\d+)/;
 
                // Extract coordinates using the regular expression
                let longURL = googleMapsUrl.match(regexLong);                
                let shortURL = googleMapsUrl.match(regexShort);
                
                if (googleMapsUrl.includes("- Google Maps")) {
                    googleMapsUrl.replace(/- Google Maps/g, '')
                 
                    this.address = this.convertCoordinatesToGoogleMapsURL(googleMapsUrl)['url'];
                    this.lng = this.convertCoordinatesToGoogleMapsURL(googleMapsUrl)['lng'];
                    this.lat = this.convertCoordinatesToGoogleMapsURL(googleMapsUrl)['lat'];

                }else if (longURL && longURL.length === 3) {
                    this.lat = parseFloat(longURL[1]);
                    this.lng = parseFloat(longURL[2]);  
                }else if(shortURL && shortURL.length === 3){
                    this.lat = parseFloat(shortURL[1]);
                    this.lng = parseFloat(shortURL[2]); 
                }
            },   
             convertCoordinatesToGoogleMapsURL: function(coordinates) {
                const regex = /(\d+)°(\d+)'([\d.]+)"(\w+)\s+(\d+)°(\d+)'([\d.]+)"(\w+)/;
                const matches = coordinates.match(regex);

                if (!matches || matches.length < 9) {
                    return null; // Invalid input format
                }

                const latitude_degrees = matches[1];
                const latitude_minutes = matches[2];
                const latitude_seconds = matches[3];
                const latitude_direction = matches[4];

                const longitude_degrees = matches[5];
                const longitude_minutes = matches[6];
                const longitude_seconds = matches[7];
                const longitude_direction = matches[8];

                const latitude = `${latitude_degrees}°${latitude_minutes}'${latitude_seconds}"${latitude_direction}`;
                const longitude = `${longitude_degrees}°${longitude_minutes}'${longitude_seconds}"${longitude_direction}`;

                const url = `https://www.google.com/maps/place/${latitude}+${longitude}/@${latitude_degrees}.${latitude_minutes}${latitude_seconds},${longitude_degrees}.${longitude_minutes}${longitude_seconds},17z/data=!3m1!4b1!4m4!3m3!8m2!3d${latitude_degrees}.${latitude_minutes}${latitude_seconds}!4d${longitude_degrees}.${longitude_minutes}${longitude_seconds}?hl=en&entry=ttu`;

                const lat = `-${latitude_degrees}.${latitude_minutes}${latitude_seconds}`;
                const lng = `${longitude_degrees}.${longitude_minutes}${longitude_seconds}`;

                return { url, lat, lng };
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
