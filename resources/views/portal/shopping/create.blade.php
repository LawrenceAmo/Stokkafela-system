<x-app-layout>
    <style>
        a:hover {
            text-decoration: none;
        }
        .categories{
          background-color: rgb(59, 59, 59)  !important;
          color: aliceblue  !important;
          font-size: 900px !important;
        }
  
        .tableFixHead          { overflow: auto !important;    }
        .tableFixHead thead th { position: sticky !important; top: 0 !important; z-index: 1 !important;background-color: rgb(37, 37, 37)  !important; }
  
         table  { border-collapse: collapse; width: 100% !important; }
        th, td { padding: 8px 16px; } 

        .loader {
  width: 60px;
  aspect-ratio: 4;
  --_g: no-repeat radial-gradient(circle closest-side,#000 90%,#0000);
  background: 
    var(--_g) 0%   50%,
    var(--_g) 50%  50%,
    var(--_g) 100% 50%;
  background-size: calc(100%/3) 100%;
  animation: l7 1s infinite linear;
}
@keyframes l7 {
    33%{background-size:calc(100%/3) 0%  ,calc(100%/3) 100%,calc(100%/3) 100%}
    50%{background-size:calc(100%/3) 100%,calc(100%/3) 0%  ,calc(100%/3) 100%}
    66%{background-size:calc(100%/3) 100%,calc(100%/3) 100%,calc(100%/3) 0%  }
}

   
    </style>

    <main class="shadow rounded p-3" id="app" v-cloak>
        <div class="card   rounded p-3">
            
            <div class="d-flex justify-content-between">
                <div class=" ">
                    
                </div>
                <div class=" ">
                    {{-- <a href="" class="btn btn-sm rounded btn-dark">create order</a> --}}
                </div>
            </div>
        </div>
         
     
    <hr>
    <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2 h5">@{{msg}}</p>
        </div>
     </div>
    <div class="card   rounded p-3 w-100" >
<div class=" pb-3  row">
   <span class="  col-md-2 ">All Products</span>
   <div class="col-md-4">
    <div class="form-group">
       <input type="text" class="form-control" v-model="searchProductsText" v-on:keyup="SearchProducts($event)" placeholder="Search product by name">
     </div>
   </div>
  
   <div class="col-md-6 d-flex justify-content-end  ">
        <span class="h5   py-3 px-3">Total Cart: R
            <b>@{{ total_cart }}</b>
        </span>
        <div class="">
            <a href="{{ route('shopping') }}" class="btn btn-sm rounded btn-outline-success">Back to orders</a>
        </div>
        <div class="">
            <button class="btn btn-info rounded btn-sm " data-toggle="modal" data-target="#modelId" >preview order</button>
        </div>
    </div>
</div>
 <div class="tableFixHead" style="height: 500px;">
    <table class="table table-striped table-inverse table-responsive" >
        <thead class="thead-inverse  ">
            <tr class="bg-purple text-light">
                <th>#</th>
                <th>Select</th>
                <th>Code</th>
                <th>Description</th>
                <th>Price</th>                
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="product,i in products" >
                    <label :for="i">
                    <td @click="addItemClick(product.sku)"> @{{i+1}} </td>
                    <td @click="addItemClick(product.sku)"> 
                        <input type="checkbox" :id="product.sku" name="" class="form-text form-control-sm text-muted">
                    </td>
                    <td @click="addItemClick(product.sku)">
                        @{{product.sku}}
                    </td>
                    <td @click="addItemClick(product.sku)">
                        @{{product.name}}
                    </td>                   
                    <td @click="addItemClick(product.sku)">
                        @{{product.price}}
                    </td>
                    <td>
                       <input type="number" min="0" v-model="product.qty" class="form-text form-control-sm text-muted"  @change="updateQty(product.qty)" :id="'price'+product.sku">                       
                    </td>
                    <td>
                        @{{(product.qty * product.price).toFixed(2)}}
                    </td>                              
                    </label>
                </tr>  
            </tbody>
    </table>
    <div class="rounded border shadow p-2 m-0 text-center h5 text-muted font-weight-bold " v-if="products.length < 1">No products available</div>
</div>
    </div>
 
    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
               <div class="" v-if="!sending_order">
                    @csrf
                    <div class="modal-header "  v-if="total_cart">
                        <h5 class="modal-title">Are you sure you want to create this order?</h5>
                            <button type="button" class="close border-0 bg-white rounded text-danger " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-header "  v-else>
                        <h5 class="modal-title text-danger">Add items to your order...</h5>                        
                    </div>  
                    <div class="modal-body" v-if="total_cart">
                        <div class="d-flex justify-content-between">
                            <div>                                
                                <div class="form-group">
                                    <label for="deliveryMethod">Select Delivery Method</label>
                                    <select v-model="delivery_method" class="form-control form-control-sm" id="deliveryMethod" name="deliveryMethod">
                                        <option selected disabled>Select Delivery Method</option>
                                        <option value="collect">Collect at Stokkafela DC</option>
                                        <option value="deliver to branch">Collect from my Branch</option>
                                        <option value="deliver to home">Deliver to my Address</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                               <div class=""><span>Total Price:</span> &nbsp; <b>@{{ total_cart }}</b></div>
                                <div class="">
                                    <a @click="save_added_items()" class="btn btn-sm btn-success rounded">confirm order</a>
                                </div>
                            </div>
                         </div>
                         
                        <div class="">
                            <div class="tableFixHead" style="height: 500px;">
                                <table class="table table-striped table-inverse  " >
                                    <thead class="thead-inverse  ">
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Barcode</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item,i in cart" >
                                            <td scope="row">@{{i+1}}</td>
                                            <td>@{{item.sku}}</td>
                                            <td>@{{item.name}}</td>
                                            <td>@{{item.price}}</td>
                                            <td class="text-center">@{{item.qty}}</td>
                                            <td>@{{item.qty*item.price}}</td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                </div> 
                <div class="" v-else>
                    <div class="modal-header d-flex flex-column"  v-if="msg">
                        <h5 class="modal-title text-danger">@{{ msg }}</h5> 
                        <div class="text-center   d-flex justify-content-center w-100">
                            <a href="" class="btn btn-sm rounded btn-outline-warning"><b>refresh page</b></a>
                        </div>                            
                    </div>
                    <div class="modal-body py-5" v-else>
                        <div class=" d-flex  ">
                            <div class="px-3 h3">
                                <div class="loader"></div>
                            </div>
                            <div class="">
                                <p class="h5">Creating Your Order. Please Wait...</p>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <p>
                                If this take longer please refresh and try again
                            </p>
                        </div>
                    </div>
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
            cart: [],
            products: [],
            productDB: [],
            cart_itemdIDs: [],           
            searchProductsText: '',
            sending_order: false,
            msg: '',
            total_cart: 0,
            id: 0,
            delivery_method: '',
           };
        },
        async created(){
            let productsDB = @json($products);

            // Parse the JSON string back into an array
            let cart = JSON.parse(localStorage.getItem("cart"));

            this.products = productsDB
            let productIDs = [];
            let products = [];
            for (let i = 0; i < productsDB.length; i++) {
                let productID = productsDB[i].productID;
                if (!productIDs.includes(productID)) {
                    products[ productID ] = [];   // add array of sales for this code
                    productIDs.push(productID);
                    products[ productID ]['productID'] = productID;   // add array of sales for this code
                    products[ productID ]['sku'] = productsDB[i].barcode;    
                    products[ productID ]['cost_price'] = productsDB[i].avrgcost;    
                    products[ productID ]['price'] = productsDB[i].sellpinc1;    
                    products[ productID ]['qty'] = 0;     
                    products[ productID ]['name'] = productsDB[i].descript;    
                }
            }
            let filteredArray = products.filter(value => value !== "");
            this.products = [ ...filteredArray ];
            this.productDB = [ ...filteredArray ];
            let rearrangedArray = filteredArray.sort();
            this.total_stock_units = rearrangedArray.length ;
 
        setTimeout(() => {
            for (let x = 0; x < cart.length; x++) {
                 this.addItemClick(cart[x].sku, cart[x].qty);                
            }
        }, 1500);
 
        },
        methods: {
            productUpdateUrl: function(val){
                var link = document.getElementById('productUpdateUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('productID', val)
                location.href = href
            },
            updateQty: function(qty = 1){
                if (qty >= 0) {
                    this.cart_total()   
                }else{
                    alert('You can not set negetive qty...')
                    location.reload()
                }              
            },
            cart_total: function(){
                let cart = this.cart;
                let itemIDs = this.cart_itemdIDs;
                let items = this.products;

                let filteredProducts = items.filter(product => itemIDs.includes(product.sku));

                this.cart = [ ...filteredProducts ]
                this.total_cart = filteredProducts.reduce((total, product) => total + (product.qty*product.price), 0).toFixed(2);
                localStorage.setItem("cart", JSON.stringify(this.cart));
            },
            save_added_items: async function(){
                 let data = { id: @json($id), delivery_method: this.delivery_method };
                 if (!this.delivery_method) {
                    alert('Please select Delivery Method')
                    return false;
                 }
                this.sending_order = true
                let res = await axios.post(" {{ route('staff_save_order') }}", {items: this.cart, data: data} );  
                    if (res.status === 200) {
                        this.cart = []
                        localStorage.setItem("cart", JSON.stringify(this.cart));

                         setTimeout(() => {
                            location.href = "{{ route('staff_order_thank_you') }}";
                        }, 5000);
                    }else{
                        this.msg = 'Something went wrong, Please refresh and try again...'
                    }
             },
            addItemClick: async function (itemID, qty = 1) {

                let selected_item = document.getElementById(itemID)
                console.log(selected_item)
                console.log(itemID)
                if (!selected_item) {
                    return false;
                }

                // check/select and uncheck the item (for user)                 
                 if (selected_item.checked || qty < 1) {
                     selected_item.checked = false;
                     this.addItemDB(itemID, false, qty)  // remove item from cart
                 } else {
                    selected_item.checked = true;
                    this.addItemDB(itemID, true, qty)     // add item from cart
                }
            },
            removeItemQtyDB: function(itemID, qty){
                this.products = this.products.map(product => {
                    if (product.sku === itemID) {
                        // Update the qty for the target product
                        return { ...product, qty: qty };
                    }
                    return product;
                });
            },
            addItemDB: function(itemID, type, qty){
                // type = 'addItem' flag
                if (type) {
                    if (!this.cart_itemdIDs.includes(itemID)) {
                        this.cart_itemdIDs.push(itemID)
                        this.removeItemQtyDB(itemID, qty);
                    }
                } else {
                    if (this.cart_itemdIDs.includes(itemID)) {
                        this.cart_itemdIDs = this.cart_itemdIDs.filter(item => item !== itemID);
                        this.removeItemQtyDB(itemID, 0);
                    }
                }
                this.cart_total()
            },
            unselectAllItems: function(){
                // Select all checkbox input elements in the document
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');

                // Loop through the selected checkboxes (NodeList) and do something with each checkbox
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            },
            SearchProducts: function(event) {
                      let allProducts = this.productDB;
                      let searchWords = this.searchProductsText.toLowerCase().split(/\s+/); // Split by whitespace

                      this.products = [];
                      if (searchWords[0].length < 1) {
                          this.products = [ ...allProducts ]
                          return false;
                      }
                      for (let i = 0; i < allProducts.length; i++) {
                          let productName = allProducts[i].name.toLowerCase();
                          // Use every() to check if all search words are present in the product name
                          if (searchWords.every(word => productName.includes(word))) {
                              this.products.push(allProducts[i]);
                          }
                      }
                      this.unselectAllItems();

                      setTimeout(() => {
                        let cart = this.cart
                            for (let x = 0; x < cart.length; x++) {
                                this.addItemClick(cart[x].sku, cart[x].qty);                
                            }
                        }, 2000);
                      return false; 
                  },
            }
     }).mount("#app"); 
    </script>
</x-app-layout>
