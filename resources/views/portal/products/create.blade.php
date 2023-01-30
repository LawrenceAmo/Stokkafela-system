<x-app-layout>
    <form class="m-0  px-4 w-100" action="{{ route('save_product')}}" method="POST" id="app">
         @csrf
     <div class=" shadow rounded p-3">
        <div class="card border rounded p-3 w-100">
        <div class="d-flex justify-content-center "><p class="font-weight-bold h5">Product Information</p></div>
        <div class=" row">
            <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Product Name <x-required></x-required></label>
                    <input type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="">
                    </div> 
            </div>
             <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Product Name</label>
                    <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                    </div> 
            </div>
        </div>
{{-- 

    // Machines
4 mabebeza
1 mabopane 



1157422378


960
3500

acc

6500


--}}


        <div class=" row py-3">
          
             <div class="col-md-6 p-2">
                <div class="form-group">
                    <label for="">Select Vendor</label>
                    <select class="form-control" name="" id="">
                        <option selected>Select one</option>
                        <option value="">Takealot</option>
                        <option value="">Macro</option>
                        <option value="">Amazon</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 p-2">
                   <div class="form-group">
                   <label for=""> Select Collection</label>
                   <select multiple class="form-control" name="" id="">
                     <option>Mens</option>
                     <option>Womens</option>
                     <option>Youth Month</option>
                   </select>
                 </div>
            </div>
        </div>

        <div class=" row">
            <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Product Description</label>
                    <textarea class="form-control" name="description" id="" rows="3"></textarea>
                </div> 
            </div>
             <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Product Addition information</label>
                    <textarea class="form-control" name="product_info" placeholder="optional" id="" rows="3"></textarea>
                    </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- /////////////// --}}
     <div class="card border rounded p-3 w-100">
        <div class="d-flex justify-content-center "><p class="font-weight-bold h5">Product Pricing</p></div>
        <div class=" row">
            <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">(Vendor) Product Cost <x-required></x-required> </label>
                    <input type="number" class="form-control" v-on:change="pricing()" name="vendor_product_price" v-model="vendor_product_price"  placeholder="">
                    <small class="text-muted">Customers won't see this price</small>
                    </div> 
            </div>
             <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label  class="d-flex">
                        <span class="w-50">Add margin </span>
                        [<div class="px-2">
                            <span class="pr-3"><input type="radio" name="margin_type" v-on:change="margin_type('percent')" checked='true'> %</span>
                            <span><input type="radio" name="margin_type" v-on:change="margin_type('rand')" > R</span>
                        </div>]
                    </label>
                    <input type="number" class="form-control" name="margin" v-on:change="pricing()" v-model="margin" placeholderid="" placeholder="Optional">
                    </div> 
            </div>
        </div>
        <div class=" row">
            <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Your profit</label>
                    <input type="number" class="form-control" name="profit" v-on:change="pricing()" v-model="profit"  placeholder="">
                    </div> 
            </div>
             <div class="col-md-6 p-2">
                     <div class="form-group">
                        <label for="">Product price</label>
                        <input type="number" name="product_price" v-on:change="pricing()" v-model="product_price" class="form-control" placeholder=""  >
                        <small class="text-muted">Customers will only see this price</small>
                    </div>
             </div>
        </div> 
    </div>

    <hr>
     <div class="card border rounded p-3 w-100">
        <div class="d-flex justify-content-center "><p class="font-weight-bold h5">Inventory and Shipping</p></div>
        <div class=" row border-bottom pb-3">
            <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Available Stock <x-required></x-required></label>
                    <input type="number" class="form-control" name="stock" id=""  placeholder="">
                    </div> 
            </div>
            
        </div>
        <div class="row py-3 my-2">
             {{-- <div class="col-md-6 p-2 d-flex justify-content-around"> --}}
                 <div class=" col-md-4 pt-3 d-flex flex-column justify-content-center">
                    <label class=" ">
                    <input type="checkbox" class="  " name="track_quantity" id="track_quantity"  placeholder=""> Track Quantity</label>
                </div> 
                <div class=" col-md-4 pt-3 d-flex flex-column justify-content-center">
                    <label>
                <input type="checkbox" class=" " name="continue_selling_when_out_of_stock" id="continue_selling_when_out_of_stock"  placeholder=""> Continue selling when out of stock</label>
                </div> 
                <div class=" col-md-4 pt-3 d-flex flex-column justify-content-center">
                    <label class=" ">
                    <input type="checkbox" class="  " name="" id="is_physical_product"  placeholder=""> This is a physical product</label>
                </div>
            {{-- </div> --}}
        </div>
        <div class=" row shipping" id="shipping">
      
            <div class="col-md-6 p-2  ">
                 
                 <div class="form-group">
                    <label for="">Product Weight (in kg) </label>
                    <input type="number" class="form-control" name="weight" id="weight" aria-describedby="helpId" placeholder="">
                    </div> 
            </div>
             <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Shipping time period (in days) </label>
                    <input type="number" class="form-control" name="shipping_time_period" id="shipping_time_period" aria-describedby="helpId" placeholder="">
                    </div> 
            </div>
        </div> 
    </div>
    <hr>
      <div class="card border rounded p-3 w-100">
        <div class="d-flex justify-content-center "><p class="font-weight-bold h5">Product Files</p></div>
        <div class=" row">
            <div class="col-md-6 p-2">
                      <div class="form-group">
                      <label class="custom-file"> Choose files <x-required></x-required></label>
                        <input type="file" name=""  id="file" placeholder="" class="form-control" aria-describedby="fileHelpId">
                        <small id="fileHelpId" class="form-text small text-muted">Help text</small>
                    </div>
              </div>
             <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Product Name</label>
                    <input type="text" class="form-control" name=""  id=""  placeholder="">
                    </div> 
            </div>
        </div>
        <div class=" row">
            <div class="col-md-6 p-2">
                <label for="">Selected Files</label>
                 <div class="border rounded p-2">
                    <ul class=" px-3 " id="selected_files">
                  
                    </ul>

            </div> 
                <input type="json" name="files" hidden id="files" value=''>

            </div>
             <div class="col-md-6 p-2">
                 <div class="form-group">
                    <label for="">Shipping time period (in days) <x-required></x-required></label>
                    <input type="number" class="form-control" name=" " id="" aria-describedby="helpId" placeholder="">
                    </div> 
            </div>
        </div> 
    </div>
    <hr>

         <div class="card border rounded p-3 w-100">
            <button class="btn btn-sm  btn-success" type="submit">Create New Product</button>
         </div>
</div>
         <div class="my-5 py-5"></div>
    </form>
    <script>

             const { createApp } = Vue;
      createApp({
        data() {
          return {
            vendor_product_price: '',
            product_price: '',
            profit: '',
            margin: '',
            margin_value: 0,
           };
        },
        async created(){
            console.log("amo start pricing")
        },
        methods: {
            margin_type: function(margin_type_v){
                let margin_value = 0;
                if (margin_type_v == "percent") {
                    margin_value = (this.margin / 100) * this.vendor_product_price;
                }else{
                margin_value = this.margin; 
                }
                // console.log(margin_type_v +" ============ "+ margin_value)
                 this.margin_value = margin_value;
            },
            pricing: function(){
                            console.log(this.margin_value)
                            // console.log(this.margin_in_rand)

                // this.product_price = this.margin_type + this.vendor_product_price
            }
        }

     }).mount("#app");

 let selected_files = document.getElementById('selected_files');
//  files.innerHTML = "AMo amo";
     let files = document.getElementById('files');
     let file = document.getElementById('file');

     let all_files = [];
     file.addEventListener('change', function(e) {  
        console.log(e.target.files[0]);
        all_files.push(e.target.files[0])
        console.log(all_files);
        files = all_files;
        selected_files.innerHTML +=   "<li>"+e.target.files[0].name+"</li><br/>";   //  "<li><img src="+e.target.files[0]+"/></li><br/>";     //+"<br/>";
        setTimeout(() => {
                file.value = ''
        }, 1000);
    });

//  0681942528     nail and beauty
//  0658814653     Mpho Maupa make up artist
//  0834305989     Vanessa Naidoo women products supplier

 /*

 tracking the stock
 point of sale system.
 track who uses the maching, (like TILL number)

 */

let is_physical_product = document.getElementById('is_physical_product');
if (!is_physical_product.checked) {
        //  document.getElementById('shipping').classlist.add('d-none');
          document.getElementById('weight').disabled = true;
         document.getElementById('shipping_time_period').disabled = true;
    } else {
        //  document.getElementById('shipping').classlist.remove('d-none');
         document.getElementById('weight').disabled = false;
         document.getElementById('shipping_time_period').disabled = false;
    }
is_physical_product.addEventListener('change', function() {
    if (!is_physical_product.checked) {
        //  document.getElementById('shipping').classlist.add('d-none');
          document.getElementById('weight').disabled = true;
         document.getElementById('shipping_time_period').disabled = true;
    } else {
        //  document.getElementById('shipping').classlist.remove('d-none');
         document.getElementById('weight').disabled = false;
         document.getElementById('shipping_time_period').disabled = false;
    }
   
})


    </script>
</x-app-layout>
