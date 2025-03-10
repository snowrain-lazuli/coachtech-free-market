<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class UsersController extends Controller
{
    public function purchase()
    {
        $categories = Category::all();
        return view('contact', compact('categories'));
    }
}