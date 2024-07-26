<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Menu;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 

class MenuItemController extends Controller
{
    // public function update(Request $request, $id)
    // {
    //     // Validate input
    //     $validator = Validator::make($request->all(), [
    //         'image' => 'required|string',
    //         'price' => 'required|numeric',
    //         'title' => 'required|string',
    //         'desc' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     try {
    //         // Find the menu item
    //         $menuItem = Menu::findOrFail($id);

    //         // Update fields
    //         $menuItem->image = $request->image;
    //         $menuItem->price = $request->price;
    //         $menuItem->title = $request->title;
    //         $menuItem->desc = $request->desc;
    //         $menuItem->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Menu item updated successfully',
    //             'menu_item' => $menuItem
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error updating menu item',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function update(Request $request, $id)

    {
        $item = Menu::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'price' => 'required',
            'image' => 'nullable', // Validate image file if provided
        ]);

        // Update the fields of the existing item
        $item->title = $validatedData['title'];
        $item->desc = $validatedData['desc'];
        $item->price = $validatedData['price'];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            // Store the new image file and update the path in the database.... uploads instead
            $imagePath = $request->file('image')->store('uploads', 'public');
            $item->image = $imagePath; // Save the relative path
            Log::info('Image stored at: ' . $imagePath); 
        } 
        else{ Log::info('No image file detected'); }

        // Save the updated menu item
        $item->save();

        return response()->json(['message' => 'Menu item updated successfully', 'menu' => $item]);
    }
    

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->delete();

            return response()->json(['message' => 'Menu item deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete menu item', 'message' => $e->getMessage()], 500);
        }
    }

}
