<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_order;
use App\Models\tbl_product;
use App\Models\tbl_category;

class StaffController extends Controller
{
    //
    public function updateOrderStatus(Request $request, $id){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }
        $order = tbl_order::find($id);

        if(!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        $newStatus = $request->input('status');
        $trackingNumber = $request->input('tracking_number');
        
        $order->status = $newStatus;
        if($newStatus == 'shipped' && $trackingNumber) {
            $order->tracking_number = $trackingNumber;
        }
        $order->save();
        
        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function productList()
    {
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $products = tbl_product::with('category')->orderBy('created_at')->get();

        return view('staff.productListPage.productListPage', ['products'=> $products]);
    }

    public function addProduct()
    {
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }
        $categories = tbl_category::where('status', 'active')->get();
        
        return view('staff.addProductPage.addProductPage', ['categories'=> $categories]);
    }

    public function storeProduct(Request $request){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:tbl_category,category_id'
        ]);

        $product = new tbl_product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock_quantity = $request->stock_quantity;
        $product->min_stock_level = $request->min_stock_level;
        $product->category_id = $request->category_id;
        $product->status = 'active';

        if($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Check file size (max 2MB)
            if($image->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Image size must be less than 2MB')->withInput();
            }
            
            // Check file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($image->getClientOriginalExtension());
            
            if(!in_array($extension, $allowedExtensions)) {
                return redirect()->back()->with('error', 'Only JPG, JPEG, PNG, GIF images are allowed')->withInput();
            }
            
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName = preg_replace('/[^A-Za-z0-9\-]/', '_', $originalName);
            $imageName = $originalName . '_' . date('Ymd_His') . '.' . $extension;

            $image->move(public_path('img'), $imageName);
            $product->image = 'img/' . $imageName;
        }
        $product->save();

        return redirect('/staff/productList')->with('success', 'Product added successfully!');
    }

    public function deleteProduct($id){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $product = tbl_product::find($id);

        if($product) {
            if($product->image && !empty($product->image)) {
                $imagePath = public_path($product->image);
                if(file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $product->delete();
            return redirect('/staff/productList')->with('success', 'Product deleted successfully!');
        }

        return redirect('/staff/productList')->with('error', 'Product not found');
    }

    public function editProduct($id){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }
        
        $product = tbl_product::find($id);
        
        if(!$product) {
            return redirect('/staff/productList')->with('error', 'Product not found');
        }
        
        $categories = tbl_category::where('status', 'active')->get();
        
        return view('staff.editProductPage.editProductPage', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function updateProduct(Request $request, $id){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $product = tbl_product::find($id);

        $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:tbl_category,category_id'
        ]);
    
        if(!$product) {
            return redirect('/staff/productList')->with('error', 'Product not found');
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock_quantity = $request->stock_quantity;
        $product->min_stock_level = $request->min_stock_level;
        $product->category_id = $request->category_id;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Check file size (max 2MB)
            if($image->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Image size must be less than 2MB')->withInput();
            }
            
            // Check file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($image->getClientOriginalExtension());
            
            if(!in_array($extension, $allowedExtensions)) {
                return redirect()->back()->with('error', 'Only JPG, JPEG, PNG, GIF images are allowed')->withInput();
            }
            
            // Delete old image if exists
            if($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            // Upload new image
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName = preg_replace('/[^A-Za-z0-9\-]/', '_', $originalName);
            $imageName = $originalName . '_' . date('Ymd_His') . '.' . $extension;

            $image->move(public_path('img'), $imageName);
            $product->image = 'img/' . $imageName;
        }

        $product->save();

        return redirect('/staff/productList')->with('success', 'Product updated successfully!');
    }

    public function categoryList(){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }
        
        $categories = tbl_category::all();
        
        foreach($categories as $category) {
            $category->product_count = tbl_product::where('category_id', $category->category_id)->count();
        }
        
        return view('staff.categoryListPage.categoryListPage', ['categories' => $categories]);
    }

    public function addCategory(){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }
        
        return view('staff.addCategoryPage.addCategoryPage');
    }

    public function storeCategory(Request $request){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }
    
        $request->validate([
            'name' => 'required|string|max:100|unique:tbl_category,name',
            'status' => 'required|in:active,inactive'
        ]);
        
        $category = new tbl_category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        
        return redirect('/staff/categoryList')->with('success', 'Category added successfully!');
    }

    public function deleteCategory($id){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $category = tbl_category::find($id);

        if(!$category) {
            return redirect('/staff/categories')->with('error', 'Category not found');
        }

        $productCount = tbl_product::where('category_id', $id)->count();
        if($productCount > 0) {
            return redirect('/staff/categoryList')->with('error', 'Cannot delete category. It contains ' . $productCount . ' product(s). Reassign them first.');
        }

        $category->delete();

        return redirect('/staff/categoryList')->with('success','Category deleted successfully!');
    }

    public function editCategory($id){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $category = tbl_category::find($id);

        if(!$category) {
            return redirect('/staff/categoryList')->with('error', 'Category not found');
        }

        $productCount = tbl_product::where('category_id', $id)->count();
        $products = tbl_product::where('category_id', $id)->get();

        return view('staff.editCategoryPage.editCategoryPage', [
            'category' => $category,
            'productCount' => $productCount,
            'products' => $products
        ]);
    }

    public function updateCategory(Request $request, $id){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $category = tbl_category::find($id);

        if(!$category) {
            return redirect('/staff/categoryList')->with('error', 'Category not found');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:tbl_category,name,' . $id . ',category_id',
            'status' => 'required|in:active,inactive'
        ]);

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return redirect('/staff/categoryList')->with('success', 'Category updated successfully!');
    }

    public function removeProductFromCategory($productId){
        if(!session()->has('LoggedStaff')) {
            return redirect('/login');
        }

        $product = tbl_product::find($productId);

        if($product) {
            $product->category_id = null;
            $product->save();
            return redirect()->back()->with('success', 'Product removed from category successfully!');
        }

        return redirect()->back()->with('error', 'Product not found');
    }
}
