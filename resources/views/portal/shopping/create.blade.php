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
   
    </style>

    <main class="shadow rounded p-3" id="app" v-cloak>
        <div class="card   rounded p-3">
            
            <div class="d-flex justify-content-between">
                <div class="border">

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
        <button class="btn btn-info rounded btn-sm mx-2" data-toggle="modal" data-target="#modelId" >preview order</button>
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
                    <td @click="addItem(product.productID)"> @{{i+1}} </td>
                    <td @click="addItem(product.productID)"> 
                        <input type="checkbox" :id="product.productID" name="" class="form-text form-control-sm text-muted">
                    </td>
                    <td @click="addItem(product.productID)">
                        @{{product.sku}}
                    </td>
                    <td @click="addItem(product.productID)">
                        @{{product.name}}
                    </td>                   
                    <td @click="addItem(product.productID)">
                        @{{product.price}}
                    </td>
                    <td>
                       <input type="number" v-model="product.qty" class="form-text form-control-sm text-muted"  @keyup="updateQty()" :id="'price'+product.sku">                       
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
            <div class="modal-content">
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
                        <span>
                            <span>Total Price:</span> &nbsp; <b>@{{ total_cart }}</b>
                        </span>
                        <span><a @click="save_added_items()" class="btn btn-sm btn-success rounded">confirm order</a></span>
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
            promotion_items: [],           
            searchProductsText: '',
            msg: '',
            total_cart: 0,
            id: 0,
           };
        },
        async created(){
            let productsDB = @json($products);
            // let id = @json($id);

            // Parse the JSON string back into an array
            this.cart = JSON.parse(localStorage.getItem("cart"));

            this.products = productsDB
            let productIDs = [];
            let products = [];
            let stock_value = 0;
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
            this.stock_value = stock_value;
            this.products = [ ...filteredArray ];
            this.productDB = [ ...filteredArray ];
            let rearrangedArray = filteredArray.sort();
            this.total_stock_units = rearrangedArray.length ;

            const replaceProducts = (cart, originalProducts) => {
                return originalProducts.map(originalProduct => {
                    const cartProduct = cart.find(product => product.productID === originalProduct.productID);

                    return cartProduct ? { ...originalProduct, ...cartProduct } : originalProduct;
                });
            };

            replaceProducts(this.cart, this.products )
            console.log(this.cart)
            console.log(this.products)

        },
        methods: {
            productUpdateUrl: function(val){
                var link = document.getElementById('productUpdateUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('productID', val)
                location.href = href
            },
            updateQty: function(){
                this.cart_total()
            },
            cart_total: function(){
                let cart = this.cart;
                let itemIDs = this.promotion_items;
                let items = this.products;

                let filteredProducts = items.filter(product => itemIDs.includes(product.productID));

                this.cart = [ ...filteredProducts ]
                this.total_cart = filteredProducts.reduce((total, product) => total + (product.qty*product.price), 0).toFixed(2);
                console.log( this.cart)
                localStorage.setItem("cart", JSON.stringify(this.cart));
            },
            save_added_items: async function(){
                 let data = { id: @json($id) };
                let res = await axios.post(" {{ route('staff_save_order') }}", {items: this.cart, data: data} );  
                    // res = await res.status
                    if (res.status === 200) {
                        // this.msg = 'Your changes were saved successful. This page will refresh in 5 seconds...'
                        // $('#modelID').modal('show');
                        // setTimeout(() => {
                            location.href = "{{ route('staff_order_thank_you') }}";
                        // }, 5000);
                    }
                    console.log(this.cart) 
                    console.log(await res ) 
             },
            addItem: function(id){
                let itemID = document.getElementById(id)
                 if (itemID.checked) { 
                     itemID.checked = false;
                     this.addItemDB(id, false)
                 } else {
                    itemID.checked = true; 
                    this.addItemDB(id, true)
                }
            },
            removeItemQtyDB: function(itemID, qty){
                this.products = this.products.map(product => {
                if (product.productID === itemID) {
                    // Update the price for the target product
                    return { ...product, qty: qty };
                }
                return product;
                });
            },
            addItemDB: function(itemID, type){
                if (type) {
                    if (!this.promotion_items.includes(itemID)) {
                        this.promotion_items.push(itemID)
                        this.removeItemQtyDB(itemID, 1);
                    }
                } else {
                    if (this.promotion_items.includes(itemID)) {
                        this.promotion_items = this.promotion_items.filter(item => item !== itemID);
                        this.removeItemQtyDB(itemID, 0);
                    }
                } 
                this.cart_total()
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
                      return false; 
                  },
            }
     }).mount("#app"); 
    </script>
</x-app-layout>
