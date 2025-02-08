<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Image;

class ContentsController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $images = Image::all();
        return view('index', compact('items', 'images'));
    }
    public function item(Request $request)
    {
        $items = Item::all();
        $images = Image::all();
        return view('item', compact('items', 'images'));
    }
    public function mypage()
    {
        return view('mypage');
    }
    // public function aaa()
    // {
    //     return view('item');
    // }
    // public function aaa()
    // {
    //     return view('item');
    // }
    // public function aaa()
    // {
    //     return view('item');
    // }
    // public function aaa()
    // {
    //     return view('item');
    // }
}