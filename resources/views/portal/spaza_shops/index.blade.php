<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <main class="m-0  px-4 py-5   w-100" id="app">
      
   
    <div class="card border rounded p-3 w-100 table-responsive">
        <div class="row mx-0 animated fadeInDown">
            <div class="col-12 text-center p-0 m-0">
                <p class="animated pulse w-100 pt-2">@include('inc.messages')</p>
            </div>
         </div> 
<div class="font-weight-bold h4 row">
    <div class="col-md-2 p-0 m-0">
        <span class="  "> Spaza Shops  </span>
    </div>
    <div class="   col-md-6 p-0 m-0  ">
        <div class="form-group   p-0 m-0">
           <input type="text" class="form-control" v-model="searchtext" v-on:keyup="SearchShop()" placeholder="Search Shop by name">
        </div>
    </div>
    <div class=" col-md-4 p-0 m-0 d-flex  ">
    <a  class="btn btn-info rounded btn-sm  " data-toggle="modal" data-target="#create_new_store"> <i class="fa fa-plus" aria-hidden="true"></i> new Shop</a>
    <a @click="download_data()"  class="btn btn-success rounded btn-sm" ><i class="fa fa-download"></i> download  </a> 
    </div>
</div>
 <?php $i = 1 ?>
<table class="table table-striped w-auto p-0 " >
    <thead class=" m-0 p-0">
        <tr class="border font-weight-bold shadow bg-dark text-light rounded"  >
            <th>#</th>
            <th>Photo</th>
            <th>Shop Name</th>
            <th>Rep Name</th>
            <th>Address</th>
            <th>Coordinates</th>
            <th>Action</th>
        </tr>
        </thead> 
        <tbody>
            <tr v-for="shop,i in shops">
                <td> @{{i+1}} </td>
                <td class="  p-0">
                    <img :src="shopImg(shop.photo)" height="50" class="  p-0 rounded m-0" alt="">
                </td>
                <td> @{{ shop.name }} </td>
                <td> @{{ shop.first_name }} @{{ shop.last_name }} </td>
                <td :title="shop.address"><u > <a target="blank" :href="shop.address" class="text-info">Shop address</a> </u></td>
                <td> @{{ shop.lat }} &nbsp; @{{ shop.lng }} </td>
                 
                  <td class="text-center">
                    <a data-href='{{ route('spaza_shop_view', ['spaza_shopID']) }}' @click="shopViewUrl(shop.spaza_shopID )" id="shopViewUrl" class="px-1 text-info c-pointer"><i class="fas fa-pencil-alt  "></i></a> |
                     <a data-href='{{ route('spaza_shop_delete', ['spaza_shopID']) }}' @click="shopDeleteUrl(shop.spaza_shopID )" id="shopDeleteUrl" class="px-1 text-danger c-pointer"><i class="fas fa-trash-alt    "></i></a> 
                    </td>
             </tr>
                      
        </tbody>
    </table>
    {{-- @if (count($stores) <= 0)
        <i class="font-weight-bold grey-text h3 text-center">
            No Data Available...
        </i>
    @endif --}}
 
    </div>

    {{-- /////////////////////   MODAL START  ///////////////////////// --}}

    <div class="modal fade" id="create_new_store" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('save_spaza_shops') }}" enctype="multipart/form-data" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Spaza Shop </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="form-group">
                          <label for="">Shop Name</label>
                          <input type="text" class="form-control" name="name" placeholder="Enter Store Name" >
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
                           <option class="" value="{{ $rep->repID}}">{{ $rep->first_name}} {{ $rep->last_name}}</option>
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
                        <div class="form-group">
                            <label for="">Shop Photo</label>
                            <input type="file" class="form-control" name="photo" placeholder="Enter Store Address" >
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
    </main>
    <script> 

     
  const { createApp } = Vue;
      createApp({
        data() {
          return { 
            shops: [],
            shopsDB: [], 
            searchtext: "",
            lat: "", 
            lng: "", 
            address: "", 
            doh_search: "", 
          }          
        },
       async created() {
        const shops = @json($shops);
        this.shops = [ ...shops ]
        this.shopsDB = [ ...shops ]
        console.log(shops) 
  
       
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
            shopViewUrl: function(val){
                var link = document.getElementById('shopViewUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('spaza_shopID', val)
                location.href = href
                // console.log(href)
            },
            shopDeleteUrl: function(val){
                var link = document.getElementById('shopDeleteUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('spaza_shopID', val)
                location.href = href
                // console.log(href)
            },     
            SearchShop: function( ) {
                      let shopsDB = this.shopsDB;
                      let searchWords = this.searchtext.toLowerCase();
                      searchWords = searchWords.split(/\s+/); // Split by whitespace
                      this.shops = [];
                      console.log(searchWords)

                      if (searchWords[0].length < 1) {
                          this.shops = [ ...shopsDB ]
                          return false;
                      } 
                      for (let i = 0; i < shopsDB.length; i++) {
                          let productName = shopsDB[i].name.toLowerCase();                          
                          // Use every() to check if all search words are present in the product name
                          if (searchWords.every(word => productName.includes(word))) {
                              this.shops.push(shopsDB[i]);
                          }
                      }       
                      return 1; 
                  }, 
        download_data: function(){   // Not yet done
            let dataDB = this.shopsDB;
            let data = []

            for (let i = 0; i < dataDB.length; i++) {
              let item  = {
                  Name: dataDB[i].name,
                  Address: dataDB[i].address,
                  Latitude: dataDB[i].lat,
                  Longitude: dataDB[i].lng,
                }
              data.push(item)               
            } 

            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.json_to_sheet(data);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Spaza Shops DataBase');
            XLSX.writeFile(workbook, 'SpazaShopsDB.xlsx');
             console.log(data)
          },     
        }
   }).mount("#app");
 
    </script>
</x-app-layout>
