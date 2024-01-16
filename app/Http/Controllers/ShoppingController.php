<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\StaffOrderAdminMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\StaffOrders;
use App\Mail\StaffOrderMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ShoppingController extends Controller
{
    public function index()
    {
        $userID = Auth::id();
        $orders = DB::table('staff_orders')
                        ->where('userID', $userID)                        
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('portal.shopping.index')->with('orders', $orders);
    }

    public function index_admin()
    {
        $userID = Auth::id();
        $orders = DB::table('staff_orders')
                        ->leftJoin('users', 'users.id', '=', 'staff_orders.userID')
                        ->select('staff_orders.*', 'users.first_name', 'users.last_name', 'users.email')
                        ->orderBy('staff_orders.created_at', 'desc')
                        ->get();
        return view('portal.shopping.admin')->with('orders', $orders);
    }

   public function create_cart()
    {
        $userID = Auth::id();
        $products = DB::table('products')
                    ->leftJoin('stores', 'stores.storeID', '=', 'products.storeID')
                    ->where('stores.name', 'LIKE', '%embisa%')
                    ->where('stores.name', 'LIKE', '%fela%')
                    ->get();

        return view('portal.shopping.create')->with('products', $products)->with('id', $userID);
    }

    public function staff_order_thank_you()
    {
        $user = Auth::user();
        return view('portal.shopping.thank_you')->with('id', $user);
    }

    public function staff_ordered_items($orderID)
    {
         $order = DB::table('staff_orders')
                    ->leftJoin('staff_order_products', 'staff_order_products.staff_orderID', '=', 'staff_orders.staff_orderID')
                    ->leftJoin('products', 'products.productID', '=', 'staff_order_products.productID')
                    ->where('staff_orders.staff_orderID', $orderID)
                    ->where('staff_orders.userID',Auth::id())
                    ->get();
        return view('portal.shopping.ordered_items')->with('order', $order);
    }

    public function staff_ordered_items_admin($orderID)
    {
         $order = DB::table('staff_orders')
                    ->leftJoin('staff_order_products', 'staff_order_products.staff_orderID', '=', 'staff_orders.staff_orderID')
                    ->leftJoin('products', 'products.productID', '=', 'staff_order_products.productID')
                    ->leftJoin('users', 'users.id', '=', 'staff_orders.userID')
                    ->where('staff_orders.staff_orderID', $orderID)
                    ->select('users.first_name','users.last_name','users.email','products.*','staff_order_products.*','staff_orders.*', )
                    ->get();

        return view('portal.shopping.ordered_items_admin')->with('order', $order);
    }

    public function staff_order_update_admin(Request $request)
    {     
        DB::table('staff_orders')
                        ->where('order_number', $request->data['order_number'])
                        ->update([
                            'status' => $request->data['status'],                           
                        ]); 
                        return true;
    }

    public function staff_save_order(Request $request)  {

        $userID = (int)$request->data["id"];
        $delivery_method = $request->data["delivery_method"];
        // return $delivery_method;
        // get the last order for this user
        $lastOrder = DB::table('staff_orders')
                        ->where('ordered', false)
                        ->where('userID', $userID)
                        ->orderBy('created_at', 'desc')
                        ->first();              

        // if there's no order for this user then create a new order
        if (!$lastOrder) {
            // create a new order number
           $staff_order_number = $this->generate_staff_order_number();
           $lastOrder = new StaffOrders();
           $lastOrder->userID = $userID;
           $lastOrder->order_number = $staff_order_number;
           $lastOrder->save();

           $staff_orderID = (int)$lastOrder->id;
        }else{
            $staff_orderID = (int)$lastOrder->staff_orderID;
        }

        $items = $request->items;
        $total_price = 0;
        $total_qty = 0;

        // delete all items for this order
         DB::table('staff_order_products')
                ->where('staff_orderID', $staff_orderID)
                ->delete();

        $ordered_items = [];
        for ($i=0; $i < count($items) ; $i++) { 
            $total_price += (  (float)$items[$i]['price'] * $items[$i]['qty']);  // total order price         
            $total_qty += $items[$i]['qty'];          // total order qty

            $item = [
                'qty' => $items[$i]['qty'],
                'price' => (float)$items[$i]['price'],
                'staff_orderID' => $staff_orderID,
                'productID' => $items[$i]['productID'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            array_push($ordered_items, $item);             
        }

        DB::table('staff_orders')
                        ->where('staff_orderID', $staff_orderID )
                        ->update([
                            'delivery_method' => $delivery_method,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'total_price' => $total_price,
                            'total_qty' => $total_qty,
                            'ordered' => true,
                        ]); 

        // insert items for this order
        DB::table('staff_order_products')->insert($ordered_items);

        $order = DB::table('staff_orders')
                    ->leftJoin('staff_order_products', 'staff_order_products.staff_orderID', '=', 'staff_orders.staff_orderID')
                    ->leftJoin('products', 'products.productID', '=', 'staff_order_products.productID')
                    ->where('staff_orders.staff_orderID', $staff_orderID)
                    ->get();

        $user = User::find( $order[0]->userID);        
        $user_info = [
            'names' => $user->first_name.' '.$user->last_name,
            'email' => $user->email,
        ];
        $admin_info = [
            'names' => 'Billy Madubye',
            'email' => 'billy.madubye@stokkafela.com',
        ];
        $admin1_info = [
            'names' => 'Billy Madubye',
            'email' => 'audrey.sikhosana@stokkafela.com',
        ];
        $admin2_info = [
            'names' => 'Rorisang Makhubela',
            'email' => 'rorisang.makhubela@stokkafela.com',
        ];

        $test_info = [
            'names' => 'Amo Test',
            'email' => 'amocodes@gmail.com',
        ];

        // Staff Email
        Mail::to($user_info['email'])->send(new StaffOrderMail($user_info, $order));

        // Admin Email
        Mail::to($admin_info['email'])->send(new StaffOrderAdminMail($admin_info, $user_info, $order));

        // Admin Email
        Mail::to($admin1_info['email'])->send(new StaffOrderAdminMail($admin1_info, $user_info, $order));

        // Admin Email
        Mail::to($admin2_info['email'])->send(new StaffOrderAdminMail($admin2_info, $user_info, $order));

         // Admin Email
        //  Mail::to($test_info['email'])->send(new StaffOrderAdminMail($test_info, $user_info, $order));


        return true; 
    }

    private function generate_staff_order_number() {

        $order = DB::table('staff_orders')
                        ->orderBy('created_at', 'desc')
                        ->first();  

        // create new order_number
        return  $order ? $order->staff_orderID + 1 : 100000;
    }
} 
