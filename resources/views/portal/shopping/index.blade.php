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
                <div class=" ">
                    Total Orders: @{{order_info.total_orders}}
                </div>
                <div class=" ">
                    Total Spent: R@{{order_info.total_price}}
                </div>               
                <div class=" ">
                    <a href="{{ route('create_cart') }}" class="btn btn-sm rounded btn-dark">create order</a>
                
                    <a href="{{ route('shopping_admin') }}" class="btn btn-sm rounded btn-dark">Admin</a>
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
   <span class="  col-md-2 h5 ">All Your Orders</span>
   <div class="col-md-10">
    <div class="form-group">
       <input type="text" class="form-control" v-model="searchProductsText" v-on:keyup="SearchProducts($event)" placeholder="Search order by order number">
     </div>
   </div>
  
    
</div> <hr>
 <div class="tableFixHead" style="height: 500px;">
    <table class="table table-striped table-inverse  " >
        <thead class="thead-inverse  ">
            <tr class="bg-purple text-light">
                <th>#</th>
                <th>Order Number</th>
                <th>Status</th>
                <th>Order Sent</th>
                <th>Total Qty</th>                
                <th>Total Price</th>
                <th>Ordered At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>  
                <tr v-for="order,i in orders" >
                     <td  > @{{i+1}} </td>
                     <td>
                        @{{order.order_number}} 
                     </td>
                   <td>
                        @{{order.status}}
                    </td>
                    <td >
                        <div class="text-success" v-if="order.ordered">Yes</div>
                        <div class="text-danger" v-else>No</div>
                     </td>                   
                    <td>
                        @{{order.total_qty}}
                    </td>
                    <td>
                        R@{{order.total_price}}
                    </td>
                    <td>
                        @{{order.created_at}}
                    </td>
                    <td class="c-pointer" @click="orderUrl(order.staff_orderID)">
                        <i class="fa fa-eye text-info" aria-hidden="true"></i> 
                    </td>
                 </tr>  
            </tbody>
    </table>
    <div class="rounded border shadow p-2 m-0 text-center h5 text-muted font-weight-bold " v-if="orders.length < 1">No Orders available</div>
</div>
    </div>

    <!-- Modal --> 
    <div class="modal fade" id="modelID" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @csrf
                <div class="modal-header ">
                    <h5 class="modal-title">@{{msg}}</h5>
                        <button type="button" class="close border-0 bg-white rounded text-danger " data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>  
            </div>
        </div> 
    </div>
    <a href="" data-href="{{route('staff_ordered_items', ['orderID'])}}" id="orderUrl" class="d-none"></a>

     </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script> 
    <script>
     const { createApp } = Vue;
      createApp({
        data() {
          return {
            orders: [],        
            ordersDB: [],
            order_info: [],
            promotion_items: [],           
            searchorderText: '',
            msg: '',
            total_cart: 0,
           };
        },
        async created(){
            let orders = @json($orders);
            console.log(orders)
            this.orders = orders;
            this.ordersDB = orders;

            let total_price = 0;    let total_orders = 0;
            for (let i = 0; i < orders.length; i++) {
                total_price += parseFloat(orders[i].total_price)
                total_orders += 1                
            }

            let order_info = {
                        'total_price': total_price.toFixed(2),
                        'total_orders': total_orders,
                        // 'order_number': order[0].order_number,
        };
        this.order_info = order_info
            console.log(order_info)

        
        },
        methods: {
            orderUrl: function(val){
                var link = document.getElementById('orderUrl');
                var href = link.getAttribute('data-href');
                href = href.replace('orderID', val)
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
                let itemIDs = this.promotion_items;
                let items = this.products;
                // let data = await axios.post(' ', {data: items} );  
                    // data = await data.status
                    // if (data.status === 200) {
                    //     this.msg = 'Your changes were saved successful. This page will refresh in 5 seconds...'
                    //     $('#modelID').modal('show');
                    //     setTimeout(() => {
                    //         location.reload();
                    //     }, 5000);
                    // }
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
                let allOrders = this.ordersDB;
                      let searchWords = this.searchProductsText.toLowerCase().split(/\s+/); // Split by whitespace

                      this.orders = [];
                      if (searchWords[0].length < 1) {
                          this.orders = [ ...allOrders ]
                          return false;
                      } 
                      console.log(searchWords)

                      for (let i = 0; i < allOrders.length; i++) {
                          let orderName = allOrders[i].order_number.toLowerCase();
                          // Use every() to check if all search words are present in the product name
                          if (searchWords.every(word => orderName.includes(word))) {
                              this.orders.push(allOrders[i]);
                          }
                      }   
                      return false; 
                  },
            }
     }).mount("#app"); 
    </script>
</x-app-layout>
