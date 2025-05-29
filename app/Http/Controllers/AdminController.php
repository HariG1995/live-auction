<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class AdminController extends Controller
{
    public function index(){
        return view('admin/admin_home');
    }

    public function productsList(){
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin/view_products', compact('products'));
    }

    public function addProduct(){
        return view('admin/add_products');
    }

    public function createProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $imageName = null;
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
        }

        $product = Product::create([
            'product_name' => trim($request->product_name),
            'image' => $imageName,
            'description' => trim($request->description),
            'base_price' => $request->base_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully!',
            'data' => $product
        ], 201);
    }

    public function editProduct($id){
        $product = Product::findOrFail($id);
        return view('admin/edit_products', compact('product'));
    }

    public function updateProduct(Request $request, $id){
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $imageName = $product->image;
        
        if ($request->hasFile('product_image')) {
            $oldImagePath = public_path('uploads/products/' . $product->image);
            if ($product->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image = $request->file('product_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
        }

        $product->update([
            'product_name' => trim($request->product_name),
            'image' => $imageName,
            'description' => trim($request->description),
            'base_price' => $request->base_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully!',
            'data' => $product
        ], 201);
    }

    public function deleteProduct(Request $request){
        $id = $request->id;
        $product = Product::findOrFail($id);

        if ($product->image) {
            $imagePath = public_path('uploads/products/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully!'
        ]);
    }

    public function updateProductStatus(Request $request){
        $request->validate([
            'id' => 'required|exists:products,id',
            'status' => 'required|in:active,closed',
        ]);

        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function completedBidList(){
        $completedBids = Product::whereNotNull('bid_price')
                                ->whereNotNull('highest_bidder_id')
                                ->where('status', 'closed')
                                ->with('highestBidder')
                                ->get();

        return view('admin/completed_bids', compact('completedBids'));
    }
}
