<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function info ($id) {
        return Restaurant::where('id', $id)->with('categories', 'products')->get()->first();
    }
}
