<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Category;

class MenuController extends Controller
{
    public function menu()
    {
        return MenuResource::collection(Category::all());
    }
}
