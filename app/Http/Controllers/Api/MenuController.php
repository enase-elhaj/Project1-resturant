<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

use App\Models\Menu;

class MenuController extends Controller
{
    public function index(){

        $items = Menu::all();
        return response()->json($items);
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required',
    //         'price' => 'required',
    //         'title' => 'required',
    //         'desc' => 'required',
            
    //     ]);

    //     $imagePath = $request->file('image')->store('images', 'public');

    //     $item = new Menu;
    //     $item->image = $imagePath;
    //     $item->price = $request->price;
    //     $item->title = $request->name;
    //     $item->desc = $request->price;
        
    //     $item->save();

    //     return response()->json(['message' => 'Item created successfully'], 201);
    // }

public function store(Request $request){
   $request->validate([
        'image' => 'required',
        'price'=>'required',
        'title' => 'required',
        'desc' => 'required',
    ]);

    if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('images', 'public');
    $item = new Menu;
    $item->image = $imagePath; // Save the relative path
    $item->price = $request->price;
    $item->title = $request->title;
    $item->desc = $request->desc; 
    $item->save();
    return response()->json([
        'data' => $item,
        'image_url' => asset('storage/' . $imagePath),
        'message' => 'Item created successfully'
    ], 201);
} else {
    return response()->json(['message' => 'Image upload failed'], 400);
}

}
}

