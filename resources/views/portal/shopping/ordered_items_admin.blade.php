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
        .capitalize-first {
      text-transform: capitalize;
    }
    </style>
 
    <main class="shadow rounded p-3" id="app" v-cloak>
        <div class="card   rounded p-3">
            
            <div class="row p-0 m-0">
                <div class="col-md-3">
                    <div class="p-2 rounded border  text-center ">
                        <div>Order Number</div> <div class="font-weight-bold">@{{order_info.order_number}}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-2 rounded border  text-center">
                        <div>Total Price</div> <div class="font-weight-bold">R@{{order_info.total_price}}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-2 rounded border  text-center ">
                        <div class="">Total Quantity</div> <div class="font-weight-bold">@{{order_info.total_qty}}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class=" p-2 rounded    text-center">
                        <a href="{{ route('shopping_admin') }}" class="btn btn-sm rounded btn-outline-info">Back to orders</a>
                    </div>
                </div>
            </div>
            <div class="row pt-3 m-0">
                <div class="col-md-3">
                    <div class="p-2 rounded border  text-center ">
                        <div class="">Staff Names</div><div class="font-weight-bold">@{{order_info.staff_names}}</div>
                    </div>
                </div>
                    <div class="col-md-3">
                    <div class="p-2 rounded border  text-center ">
                       <div class="">Email Address</div><div class="font-weight-bold text-dark"> <a class="text-dark" :href="'mailto:' + order_info.staff_email">@{{ order_info.staff_email }}</a>
                       </div>
                    </div>
                </div>
                    <div class="col-md-3">
                    <div class="p-2 rounded border  text-center ">
                        <div class="">Delivery Method</div><div class="capitalize-first font-weight-bold"> @{{order_info.delivery_method}}</div>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="p-2 rounded    text-center ">
                        <div class="" v-if="order_info.current_status === 'pending'">
                            <a data-toggle="modal" data-target="#update_order" class="btn btn-sm rounded btn-outline-success">Update Order</a>
                        </div>
                        <div class="" v-else>
                            <div class="p-2 rounded border  text-center ">
                                <div class="">Order Status</div>
                                <div class="capitalize-first text-success font-weight-bold"v-if="order_info.current_status === 'completed'"> @{{order_info.current_status}}</div>
                                <div class="capitalize-first text-danger font-weight-bold" v-else> @{{order_info.current_status}}</div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>

    <hr>
    {{-- <div class="row mx-0 animated fadeInDown">
        <div class="col-12 text-center p-0 m-0">
            <p class="animated pulse w-100 pt-2 h5">@{{msg}}</p>
        </div>
     </div> --}}
    <div class="card   rounded p-3 w-100" >
<div class=" p-0 m-0  d-flex justify-content-between">
   <span class="   h5 ">Products Ordered</span>
    
   <div class=" pr-5">
    <div class="">Order: <span class="font-weight-bold capitalize-first">@{{ order_info.current_status}}</span></div>
   </div>
</div> <hr>
 <div class="tableFixHead" style="height: 500px;">
    <table class="table table-striped table-inverse  " >
        <thead class="thead-inverse  ">
            <tr class="bg-purple text-light">
                <th>#</th>
                <th>Barcode</th>
                <th>Description</th>
                <th>Unit Price</th>
                <th>Quantity</th>                
                <th>Total Price</th>
            </tr>
            </thead>
            <tbody>  
                <tr v-for="item,i in order" >
                     <td  > @{{i+1}} </td>
                     <td>
                        @{{item.barcode}} 
                     </td>
                   <td>
                        @{{item.descript}}
                    </td>
                    <td>
                        @{{item.price}}
                    </td>                   
                    <td>
                        @{{item.qty}}
                    </td>
                    <td>
                        @{{item.qty * item.price }}
                    </td>                               
                     
                 </tr>  
            </tbody>
    </table>
    <div class="rounded border shadow p-2 m-0 text-center h5 text-muted font-weight-bold " v-if="order.length < 1">No Orders available</div>
</div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="update_order" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Order: @{{order_info.order_number}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body" v-if="msg">
                    <p class="  text-dark">@{{ msg }}</p>                                                  
                </div>
                <div class="modal-body" v-else>
                   <div class="">
                    <div class="form-group">
                      <label for="">Status</label>
                      <select class="form-control" v-model="order_info.status" name="" id="">
                        <option selected disabled>Select Order Status</option> 
                        <option value="completed">Complete</option>
                        <option value="cancelled">Cancelled</option>
                      </select>
                    </div> 
                   </div> 
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-sm rounded btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="button" @click="update_order()" class="btn btn-sm rounded btn-dark">Update</button>
                </div>
            </div>
        </div>
    </div>
 
     </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script> 
    <script>
     const { createApp } = Vue;
      createApp({
        data() {
          return {
            order: [],
            order_info: [],
            promotion_items: [],           
            searchorderText: '',
            msg: '',
            total_cart: 0,
            sending_order: false,
           };
        },
        async created(){
            let order = @json($order);
            console.log(order)
            this.order = order;

            let total_price = 0;    let total_qty = 0;
            for (let i = 0; i < order.length; i++) {
                total_price += order[i].price * order[i].qty
                total_qty += order[i].qty                
            }

            let order_info = {                
                        'delivery_method':  order[0].delivery_method,
                        'status': '',
                        'current_status': order[0].status,
                        'total_price': total_price,
                        'total_qty': total_qty,
                        'order_number': order[0].order_number,
                        'staff_email': order[0].email,
                        'staff_names': order[0].first_name+" "+order[0].last_name,
         };
        this.order_info = order_info
            // console.log(order_info) 
        },
        methods: {
            update_order: async function(){
                let order_info = this.order_info;
                if (!order_info.status) {
                    alert('Please select order status')
                    return false;
                }
                this.msg = 'Please wait while we are updating your order';

                let data = await axios.post( "{{ route('staff_order_update_admin') }}", {data: order_info} );  

                if (data.status === 200) {
                    this.msg = 'Order updated successfully, page will reload in 5 seconds to update changes...'
                        setTimeout(() => {
                        location.reload()
                    }, 5000);
                }else{
                    this.msg = 'Something went wrong, Please refresh and try again...'
                }

                console.log(await data)
            },
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

                console.log(cart)
            },
            save_added_items: async function(){
                
                let filteredProducts = items.filter(product => itemIDs.includes(product.productID));

                this.cart = [ ...filteredProducts ]
                this.cart_total()
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
                      let allProducts = this.products;
                      let searchWords = this.searchProductsText.toLowerCase().split(/\s+/); // Split by whitespace

                      this.products = [];
                      if (searchWords[0].length < 1) {
                          this.products = [ ...allProducts ]
                          return false;
                      } 
                      console.log(searchWords)

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
