<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

use App\Models\Ingredient;
use App\Models\Type;
use App\Models\Size;
use App\Models\Pizza;
use App\Models\Order;

class UserController extends Controller
{
    public function elements(Request $request) {
        $ingredients = Ingredient::all();
        $sizes = Size::all();
        $types = Type::all();

        return[$ingredients, $sizes, $types];
    }

    public function orders(Request $request) {
        $user = Auth::id();
        $orders = Order::where('user_id', $user ) -> orderBy('created_at', 'desc') ->with(['user','pizzas', 'pizzas.type', 'pizzas.size', 'pizzas.ingredients']) -> get();
        $selectedOrders = $orders;

        foreach ($selectedOrders as $order) {
            $date = Carbon::parse($order->created_at)->locale('it_IT')->isoFormat('LLLL');
            $order->{"date"} = $date;
            
        }

        return $selectedOrders;
    }

    public function newOrder (Request $request) {

        $pizzas = $request -> order;
        $pizzasID = [];
        foreach ($pizzas as $pizza) {

            $orderedPizza = new Pizza;
            $orderedPizza->size_id = $pizza['sizeId'];
            $orderedPizza->name = 'Pizzollo'. $pizza['sizeId'] . $pizza['sizeId'];
            $orderedPizza->type_id = $pizza['sizeId'];
            $orderedPizza->price = $pizza['price'];
                       
            $orderedPizza ->save();

            $ingredients = $pizza['ingredients'];
            $ingredientsId = [];

            foreach ($ingredients as $ingredient) {
                $ingredientId = $ingredient['id'];
                array_push($ingredientsId, $ingredientId);
            }

            $pizzo = Pizza::find($orderedPizza->id);
            $pizzo -> ingredients() -> attach($ingredientsId);

            array_push($pizzasID, $orderedPizza->id);
        }


        $newOrder = new Order;
        $newOrder->user_id = Auth::id();
        $newOrder->status = "ricevuto";
        $newOrder->total_price = $request -> total_price;
        $newOrder->save();

        $order = Order::find($newOrder->id);
        $order -> pizzas() -> attach($pizzasID);

        return $newOrder;

    } 
}
