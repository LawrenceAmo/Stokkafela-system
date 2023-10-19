<x-app-layout>
    <style>
      .tableFixHead          { overflow: auto !important;    }
      .tableFixHead table{
        height: 500px !important;
      }
      .tableFixHead thead th { position: sticky !important; top: 0 !important; z-index: 0 !important;background-color: rgb(37, 37, 37)  !important; }
      #map {
           height: 400px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

    <main class="m-0  px-4 pb-5 pt-3   w-100" id="app">

        <div class=" card mb-3 border rounded p-3 w-100 table-responsive">
            <div class="row">
                <div class="col-md-4  ">
                    <div class="border rounded p-0 p-3 d-flex flex-column justify-content-center">
                        <p class=" font-weight-bold  m-0 d-flex justify-content-around"><span>Total Store Locations:</span> <span class=" pl-3">@{{storesDB.length}}</span></p>
                    </div>
                </div>
                <div class="col-md-3   text-center">
                    
                </div> 
                {{-- <div class="  ">
                    <div class="  rounded p-0 p-3 d-flex flex-column justify-content-center">
                        <p class=" font-weight-bold  m-0">   
                            <a  class="btn btn-info rounded btn-sm  m-0 font-weight-bold" data-toggle="modal" data-target="#upload_bulk_store"> <i class="fa fa-cloud"  ></i> Upload bulk Shops</a>
                        </p>
                    </div>
                </div> --}}
                <div class="col-md-5   d-flex   justify-content-around">
                    <div class="  rounded p-0 p-3 d-flex flex-column justify-content-center">
                        <p class=" font-weight-bold  m-0">
                            <a  class="btn btn-primary rounded btn-sm  m-0 font-weight-bold" data-toggle="modal" data-target="#create_new_store"> <i class="fa fa-plus" aria-hidden="true"></i> add new Store Location</a>
                        </p>
                    </div>
                    <div class="  rounded p-0 p-3 d-flex flex-column justify-content-center">
                        <p class=" font-weight-bold  m-0">
                            <a @click="download_data()"  class="btn btn-success rounded btn-sm m-0 font-weight-bold" ><i class="fa fa-download"></i> download  </a> 
                        </p>
                    </div>
                </div>       
              
            </div>
        </div>
   
    <div class="card border rounded p-3 w-100 table-responsive">
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<div class="font-weight-bold h4 row">
    <div class="col-md-3 pl-3 m-0">
        <span class="  "> Store Locations  </span>
    </div>
    {{-- <div class="   col-md-9 p-0 m-0   pr-3">
        <div class="form-group   p-0 m-0">
           <input type="text" class="form-control" v-model="searchtext" v-on:keyup="SearchShop()" placeholder="Search Shop by name">
        </div>
    </div> --}}
 </div>
 <div class="tableFixHead ">
    <table class="table table-striped table-inverse    table-responsive w-100" >
    <thead class="">
         <tr class="  font-weight-bold shadow bg-dark text-light rounded w-100"  >
            <th>#</th>
            <th>Photo</th>
            <th>Store Name</th>
             <th>Physical Address</th>
             <th>Google Map Link</th>
             <th>Geo Coordinates</th>
             <th>Action</th>
        </tr>
        </thead> 
        <tbody>
            <tr v-for="store,i in stores" class="w-100">
                <td> @{{i+1}} </td>
                <td class="  p-0">
                    <img :src="storeImg(store.photo)" height="50" class="  p-0 rounded m-0" alt="">
                </td>
                <td> @{{ store.name }} </td>
                <td :title="store.address"> <a target="blank" :href="store.address" class="text-dark">@{{store.address}}</a> </td>
                <td :title="store.address"> <a target="blank" :href="store.map_link" class="text-dark">Google Map Link</a> </td>
                <td> @{{ store.lat }} &nbsp; @{{ store.lng }} </td>
                 
                  <td class="text-center">
                    <a data-href='{{ route('store_location_update', ['store_locationID']) }}' @click="storeViewUrl(store.store_locationID )" id="storeViewUrl" class="px-1 text-info c-pointer"><i class="fas fa-pencil-alt  "></i></a> 
                     {{-- <a data-href='{{ route('store_location_update', ['store_locationID']) }}' @click="storeDeleteUrl(store.store_locationID )" id="storeDeleteUrl" class="px-1 text-danger c-pointer"><i class="fas fa-trash-alt    "></i></a>  --}}
                    </td>
             </tr>                      
        </tbody>
    </table>
 </div>
 {{-- //////////////////////////////////////////////////////// --}}
  {{-- /////////////////////   MODAL START  ///////////////////////// --}}

  <div class="modal fade" id="create_new_store" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {{--  --}}
        <form action="{{ route('save_store_locations') }}" enctype="multipart/form-data" method="post" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create New Store Location </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="form-group">
                      <label for="">Store Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Enter Store Name" >
                    </div>
                    <div class="form-group">
                        <label for="">Physical Address</label>
                        <input type="text" v-model="address"  class="form-control" name="address" placeholder="Enter Store Physical Address" >
                    </div>
                    <div class="form-group">
                        <label for="">Google Map Address Link</label>
                        <input type="text" v-model="map_link" @input="handleAddressChange" class="form-control" name="map_link" placeholder="Enter Store Google Map Address Link" >
                    </div>
                     
                    <div class="form-group">
                      <label for="">Store Coordinates (optional)</label>
                      <div class="w-100 d-flex">
                        <input type="text" v-model="lat" class="form-control w-50" name="lat" placeholder="Latitude" >
                        <input type="text" v-model="lng" class="form-control w-50" name="lng" placeholder="Longitude" >
                      </div>
                      <small class="text-muted">e.g 'Stokkafela Tembisa' / 'Mabebeza Bambanani'</small>
                    </div>
                    <div class="form-group">
                        <label for="">Store Photo</label>
                        <input type="file" class="form-control" name="photo" >
                    </div>                        
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>
 <hr>
 <div class="">
    <div class="border rounded p-3">

        <div class="" id="map">

        </div>
    </div>
 </div>
 
    </div>
   
    </main>

    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7uUbl0Ol0kXBam07UPsjThrxL18qoVzA&callback=initMap&v=weekly"
    defer ></script>
  
    <script> 

     
  const { createApp } = Vue;
      createApp({
        data() {
          return { 
            stores: [],
            storesDB: [], 
            searchtext: "",
            lat: "", 
            lng: "", 
            address: "", 
            doh_search: "", 
            map_link: "",
          }          
        },
       async created() {
        let store_locations = @json($stores);
        console.log(store_locations)
           
            this.stores = [ ...store_locations ]
            this.storesDB = [ ...store_locations ]
            console.log(store_locations)       
            this.map();
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
                 
                    this.map_link = this.convertCoordinatesToGoogleMapsURL(googleMapsUrl)['url'];
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
            storeImg: function (val) {
                return `{{ asset('storage/stores/${val}')}}`;
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
            storeViewUrl: function(val){
                var link = document.getElementById('storeViewUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('store_locationID', val)
                location.href = href
                // console.log(href)
            },
            storeDeleteUrl: function(val){
                var link = document.getElementById('shopDeleteUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('spaza_shopID', val)
                location.href = href
                // console.log(href)
            },     
            SearchShop: function( ) {
                      let storesDB = this.storesDB;
                      let searchWords = this.searchtext.toLowerCase();
                      searchWords = searchWords.split(/\s+/); // Split by whitespace
                      this.shops = [];
                      console.log(searchWords)

                      if (searchWords[0].length < 1) {
                          this.shops = [ ...storesDB ]
                          return false;
                      } 
                      for (let i = 0; i < storesDB.length; i++) {
                          let productName = storesDB[i].name.toLowerCase();                          
                          // Use every() to check if all search words are present in the product name
                          if (searchWords.every(word => productName.includes(word))) {
                              this.shops.push(storesDB[i]);
                          }
                      }       
                      return 1; 
                  }, 
            download_data: function(){   // Not yet done
                let dataDB = this.storesDB;
                let data = []

                for (let i = 0; i < dataDB.length; i++) {
                    let rep_name = (dataDB[i].first_name || "") + " " + (dataDB[i].last_name || "");
                let item  = {
                    'Shop Name': dataDB[i].name,
                    'Rep Name': rep_name,
                    Latitude: dataDB[i].lat,
                    Longitude: dataDB[i].lng,
                    Address: dataDB[i].address,
                    
                    }
                data.push(item)               
                } 

                const workbook = XLSX.utils.book_new();
                const worksheet = XLSX.utils.json_to_sheet(data);
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Spaza Shops DataBase');
                XLSX.writeFile(workbook, 'SpazastoresDB.xlsx');
             console.log(data)
          },     
          map: function(){
            function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 9,
             center: { lng: 28.202125, lat: -25.839784 },
            mapTypeId: "terrain",
            });

             let coord = [ ...@json($stores) ];  
             console.log(coord)  
            
            for (let i = 0; i < coord.length; i++) {

                let mt = { lng: parseFloat(coord[i]['lng']), lat: parseFloat(coord[i]['lat']) };  // 
                console.log(coord[i])
                    const mtm = new google.maps.Marker({
                    position: mt,
                    map: map,
                    title: coord[i]['name']+" - "+coord[i].address
                    });
            }
            
            // Define the LatLng coordinates for the polygon's path.
            const triangleCoords = [
            { lng: 28.253860, lat: -26.039158 },   //tembisa
            { lng: 28.233604, lat: -25.922497 },   // olif 
            { lng: 28.103484, lat: -25.890379 },   // oliv
            { lng: 27.991027, lat: -25.928719 },   //diepsloot   
            { lng: 27.913627, lat: -26.025276 },   //cosmo
            { lng: 27.999801, lat: -26.033297 },   // 4way
            { lng: 28.089065, lat: -26.051496 },   // woodmed
            { lng: 28.253860, lat: -26.039158 },   // tembisa
            ]; 
            // Construct the polygon.
            const bermudaTriangle = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: "#642c94",
            strokeOpacity: 0.01,
            strokeWeight: 2,
            fillColor: "#dd99b0",
            fillOpacity: 0.10,
            });
            bermudaTriangle.setMap(map);
        }
        window.initMap = initMap;
          }
        }
   }).mount("#app");
 
//    /////////////////////////////////////////////////////////////////


    </script>
</x-app-layout>
