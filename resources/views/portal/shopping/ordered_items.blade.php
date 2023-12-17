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
                    Order Number: @{{order_info.order_number}}
                </div>
                <div class=" ">
                    Total Price: R@{{order_info.total_price}}
                </div>
                <div class=" ">
                    Total Qty: @{{order_info.total_qty}}
                </div>
                <div class=" ">
                    <a href="{{ route('shopping') }}" class="btn btn-sm rounded btn-outline-info">Back to orders</a>
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
   <span class="  col-md-2 h5 ">Products Ordered</span>
   <div class="col-md-10">
    <div class="form-group">
       <input type="text" class="form-control" v-model="searchProductsText" v-on:keyup="SearchProducts($event)" placeholder="Search product by name">
     </div>
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
                        'total_price': total_price,
                        'total_qty': total_qty,
                        'order_number': order[0].order_number,
        };
        this.order_info = order_info
            console.log(order_info)

        
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
