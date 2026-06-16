<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_user;
use Illuminate\Support\Facades\Hash;
use App\Models\tbl_product;
use App\Models\tbl_category;
use App\Models\tbl_website_page;
use Illuminate\Support\Facades\File;
use App\Models\tbl_service_request;
use App\Models\tbl_order;

class SuperAdminController extends Controller
{
    //
    public function staffList(){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $users = tbl_user::whereIn('role', ['staff', 'technician'])->orderBy('created_at')->get();

        return view('superadmin.staffListPage.staffListPage', [
            'users' => $users
        ]);
    }

    public function addStaff()
    {
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }
        
        return view('superadmin.addStaffPage.addStaffPage');
    }

    public function storeStaff(Request $request){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:tbl_user,email',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:staff,technician',
            'password' => 'required|min:6'
        ]);

        $user = new tbl_user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->status = 'active';
        $user->save();

        return redirect('/superadmin/staffList')->with('success', 'Staff added successfully!');
    }

    public function deleteStaff($id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $user = tbl_user::find($id);

        if($user) {
            $user->delete();
            return redirect('/superadmin/staffList')->with('success', 'Staff deleted successfully!');
        }

        return redirect('/superadmin/staffList')->with('error', 'User not found');
    }

    public function productList()
    {
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $products = tbl_product::with('category')->orderBy('created_at')->get();

        return view('superadmin.productListPage.productListPage', ['products'=> $products]);
    }

    public function addProduct()
    {
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }
        $categories = tbl_category::where('status', 'active')->get();
        
        return view('superadmin.addProductPage.addProductPage', ['categories'=> $categories]);
    }

    public function storeProduct(Request $request){
        if(!session()->has('LoggedSuperadmin')) {
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

        return redirect('/superadmin/productList')->with('success', 'Product added successfully!');
    }

    public function deleteProduct($id){
        if(!session()->has('LoggedSuperadmin')) {
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
            return redirect('/superadmin/productList')->with('success', 'Product deleted successfully!');
        }

        return redirect('/superadmin/productList')->with('error', 'Product not found');
    }

    public function editProduct($id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }
        
        $product = tbl_product::find($id);
        
        if(!$product) {
            return redirect('/superadmin/productList')->with('error', 'Product not found');
        }
        
        $categories = tbl_category::where('status', 'active')->get();
        
        return view('superadmin.editProductPage.editProductPage', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function updateProduct(Request $request, $id){
        if(!session()->has('LoggedSuperadmin')) {
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
            return redirect('/superadmin/productList')->with('error', 'Product not found');
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

        return redirect('/superadmin/productList')->with('success', 'Product updated successfully!');
    }

    public function categoryList(){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }
        
        $categories = tbl_category::all();
        
        foreach($categories as $category) {
            $category->product_count = tbl_product::where('category_id', $category->category_id)->count();
        }
        
        return view('superadmin.categoryListPage.categoryListPage', ['categories' => $categories]);
    }

    public function addCategory(){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }
        
        return view('superadmin.addCategoryPage.addCategoryPage');
    }

    public function storeCategory(Request $request){
        if(!session()->has('LoggedSuperadmin')) {
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
        
        return redirect('/superadmin/categoryList')->with('success', 'Category added successfully!');
    }

    public function deleteCategory($id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $category = tbl_category::find($id);

        if(!$category) {
            return redirect('/superadmin/categories')->with('error', 'Category not found');
        }

        $productCount = tbl_product::where('category_id', $id)->count();
        if($productCount > 0) {
            return redirect('/superadmin/categoryList')->with('error', 'Cannot delete category. It contains ' . $productCount . ' product(s). Reassign them first.');
        }

        $category->delete();

        return redirect('/superadmin/categoryList')->with('success','Category deleted successfully!');
    }

    public function editCategory($id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $category = tbl_category::find($id);

        if(!$category) {
            return redirect('/superadmin/categoryList')->with('error', 'Category not found');
        }

        $productCount = tbl_product::where('category_id', $id)->count();
        $products = tbl_product::where('category_id', $id)->get();

        return view('superadmin.editCategoryPage.editCategoryPage', [
            'category' => $category,
            'productCount' => $productCount,
            'products' => $products
        ]);
    }

    public function updateCategory(Request $request, $id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $category = tbl_category::find($id);

        if(!$category) {
            return redirect('/superadmin/categoryList')->with('error', 'Category not found');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:tbl_category,name,' . $id . ',category_id',
            'status' => 'required|in:active,inactive'
        ]);

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return redirect('/superadmin/categoryList')->with('success', 'Category updated successfully!');
    }

    public function removeProductFromCategory($productId){
        if(!session()->has('LoggedSuperadmin')) {
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

    public function pageList(){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }
        
        $pages = tbl_website_page::all();

        return view('superadmin.pageListPage.pageListPage', ['pages' => $pages]);
    }

    public function webEditor($id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $page = tbl_website_page::find($id);

        if(!$page) {
            return redirect('/superadmin/pageList')->with('error', 'Page not found');
        }

        $filePath = $page->file_path;
        if(!view()->exists($filePath)) {
            return redirect('/superadmin/pageList')->with('error', 'View file not found: ' . $filePath);
        }

        // IMPORTANT: do NOT render the Blade here.
        // Rendering will evaluate placeholders like {{ $customer->name }} and may crash
        // when variables are not provided (Undefined variable / non-object property).
        $originalRelativePath = str_replace('.', '/', trim($filePath));
        $absoluteBladePath = resource_path('views/' . $originalRelativePath . '.blade.php');
        
        if(!file_exists($absoluteBladePath)) {
            return redirect('/superadmin/pageList')->with('error', 'Blade file not found: ' . $absoluteBladePath);
        }

        $fileContents = File::get($absoluteBladePath);

        $editableContent = $this->generateEditableHTML($fileContents);
        return view('superadmin.editPage.editPage', ['editableContent' => $editableContent,'page' => $page]);
    }

    public function generateEditableHTML($content){
        // Match all HTML opening tags
        $pattern = '/<(h[1-5]|p|label|a|span|td|[a-zA-Z]+[^>]*\bword\b[^>]*)([^>]*)>/';
    
        // Replace each opening tag with the same tag and the contenteditable attribute added
        $editableContent = preg_replace($pattern, '<$1$2 contenteditable="true">', $content);
    
        // Replace <a><img> tags with <img> tags only
        $editableContent = preg_replace('/<a[^>]*><img([^>]*)><\/a>/', '<img$1>', $editableContent);

        // Remove the "fixed-top" class from the generated HTML
        $editableContent = str_replace('fixed-top', '', $editableContent);

        $search = '/(<table[^>]*id="acceptancLetterDetailsTable"[^>]*)([^>]*contenteditable="true"[^>]*)(>.*?<\/table>)/s';

        $editableContent = preg_replace_callback($search, function($matches) {
            $tableHtml = $matches[1] . str_replace(' contenteditable="true"', '', $matches[2]) . $matches[3];
            $tableHtml = str_replace(' contenteditable="true"', '', $tableHtml);
            return $tableHtml;
        }, $editableContent);

        $search = '/(<div[^>]*class="acceptanceLetter"[^>]*)([^>]*)contenteditable="true"([^>]*>.*?<\/div>)/s';

        $editableContent = preg_replace_callback($search, function($matches) {
            $divHtml = $matches[1] . $matches[2] . $matches[3];
            return $divHtml;
        }, $editableContent);

        $search = '/(<div[^>]*id="editContainer"[^>]*)([^>]*)contenteditable="true"([^>]*>.*?<\/div>)/s';

        $editableContent = preg_replace_callback($search, function($matches) {
            $divHtml = $matches[1] . $matches[2] . $matches[3];
            return $divHtml;
        }, $editableContent);

        $search = '/(<div[^>]*)([^>]*)contenteditable="true"([^>]*>.*?<\/div>)/s';

        $editableContent = preg_replace_callback($search, function($matches) {
            $divHtml = $matches[1] . $matches[2] . $matches[3];
            return $divHtml;
        }, $editableContent);

        $search = '/(<div[^>]*)([^>]*)style="[^"]*"[^>]*contenteditable="true"([^>]*>.*?<\/div>)/s';

        $editableContent = preg_replace_callback($search, function($matches) {
            $divHtml = $matches[1] . $matches[2] . $matches[3];
            return $divHtml;
        }, $editableContent);

        $search = '/(<main[^>]*)([^>]*)contenteditable="true"([^>]*>.*?<\/main>)/s';

        $editableContent = preg_replace_callback($search, function($matches) {
            $divHtml = $matches[1] . $matches[2] . $matches[3];
            return $divHtml;
        }, $editableContent);
    
        return $editableContent;
    }

    public function saveEdit(Request $request, $id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $page = tbl_website_page::find($id);
        if(!$page) {
            return redirect('/superadmin/pageList')->with('error', 'Page not found');
        }

        // Clean the file_path - remove any whitespace or newlines
        $cleanPath = trim(preg_replace('/\s+/', '', $page->file_path));
        
        // Convert dot notation to path
        $relativePath = str_replace('.', '/', $cleanPath);
        $originalFilePath = resource_path('views/' . $relativePath . '.blade.php');
        
        // Create directory if it doesn't exist
        $directory = dirname($originalFilePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        
        $updatedContent = $request->input('updatedContent');
        $image = $request->file('images');
        
        if ($image){
            $extension = strtolower($image->getClientOriginalExtension());
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName = preg_replace('/[^A-Za-z0-9\-]/', '_', $originalName);
            $imageName = $originalName . '_' . date('Ymd_His') . '.' . $extension;
            $image->move(public_path('img'), $imageName);

            // Get the file path for the saved image
            $savedImagePath = 'img/' . $imageName;
            // Remove old src and add new one
            $pattern = '/<img([^>]*?)src=["\'].*?["\']([^>]*?)>/';
            $updatedContent = preg_replace($pattern, '<img$1 src="/'.$savedImagePath.'"$2>', $updatedContent);
        }

        // Decode and persist data:image/*;base64 images into public/img/
        $updatedContent = $this->persistBase64Images($updatedContent);

        $updatedContent = $this->removeContentEditable($updatedContent);
        
        // Save the updated content to the original file
        File::put($originalFilePath, $updatedContent);
        
        return redirect('superadmin/pageList')->with('success', 'Page updated successfully.');
    }

    private function persistBase64Images($content){
        // Replace <img src="data:image/{mime};base64,{data}"> with saved files in public/img
        $pattern = '/<img([^>]*?)src=["\'](data:image\/(png|jpe?g|gif|webp);base64,([^"\']+))["\']([^>]*?)>/i';

        return preg_replace_callback($pattern, function($matches){
            $beforeSrcAttrs = $matches[1] ?? '';
            $mime = strtolower($matches[3] ?? 'jpeg');
            $base64 = $matches[4] ?? '';

            // Guard: base64 may include whitespace/newlines
            $base64 = preg_replace('/\s+/', '', $base64);

            $afterAttrs = $matches[5] ?? '';

            if(!$base64) {
                return '<img'.$beforeSrcAttrs.' src=""'.$afterAttrs.'>';
            }

            $extension = match($mime){
                'png' => 'png',
                'jpg' => 'jpg',
                'jpeg' => 'jpeg',
                'gif' => 'gif',
                'webp' => 'webp',
                default => 'jpeg'
            };

            $binary = base64_decode($base64, true);
            if($binary === false) {
                return '<img'.$beforeSrcAttrs.' src="'.$matches[2].'"'.$afterAttrs.'>';
            }

            $filenameBase = 'editor';
            $oldSrcForName = $matches[2] ?? '';

            if (is_string($oldSrcForName) && preg_match('#/img/([^/\\"\']+?)(?:\.[A-Za-z0-9]+)?$#', $oldSrcForName, $mOld)) {
                $filenameBase = pathinfo($mOld[1], PATHINFO_FILENAME);
            } elseif (preg_match('/alt=["\']([^"\']*)["\']/i', $beforeSrcAttrs, $mAlt) && !empty(trim($mAlt[1] ?? ''))) {
                $filenameBase = pathinfo($mAlt[1], PATHINFO_FILENAME);
            }

            // Sanitize
            $filenameBase = preg_replace('/[^A-Za-z0-9\-]/', '_', $filenameBase);

            $filename = $filenameBase . '_' . date('Ymd_His') . '.' . $extension;

            $targetPath = public_path('img/' . $filename);

            if (is_string($oldSrcForName) && preg_match('#/img/([^/\\"\']+?\.[A-Za-z0-9]+)$#', $oldSrcForName, $mOldFile)) {
                $oldFile = public_path('img/' . $mOldFile[1]);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            file_put_contents($targetPath, $binary);

            $savedSrc = '/img/' . $filename;

            return '<img'.$beforeSrcAttrs.' src="'.$savedSrc.'"'.$afterAttrs.'>';
        }, $content);
    }

    private function removeContentEditable($content){
        // Remove the contenteditable attribute from all elements
        $pattern = '/\s*contenteditable="true"/';
        $updatedContent = preg_replace($pattern, '', $content);
    
        return $updatedContent;
    }

    public function serviceRequestList(){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $requests = tbl_service_request::orderBy('created_at','desc')->with('user','technician')->get();
        $technicians = tbl_user::where('role','technician')->get();

        return view('superadmin.serviceRequestListPage.serviceRequestListPage',['requests'=>$requests, 'technicians'=>$technicians]);
    }

    public function assignTechnician(Request $request, $id){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $serviceRequest = tbl_service_request::find($id);
        if(!$serviceRequest) {
            return redirect()->back()->with('error', 'Service request not found');
        }

        $technicianId = $request->input('technician_id');

        if($technicianId){
            $serviceRequest->technician_id = $technicianId;
            $serviceRequest->save();

            return redirect()->back()->with('success', 'Technician assigned successfully!');
        }

        return redirect()->back()->with('error', 'Please select a technician');
    }

    public function orderList(Request $request){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $status = $request->get('status', 'all');
        $query = tbl_order::orderBy('created_at', 'desc');

        switch($status) {
            case 'to_pay':
                $query->where('payment_status', 'unpaid');
                break;
            case 'to_ship':
                $query->whereIn('status', ['pending', 'processing']);
                break;
            case 'to_receive':
                $query->whereIn('status', ['shipped', 'delivered']);
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
            default:
                break;
        }

        $orders = $query->paginate(15);

        foreach($orders as $order) {
            $customer = tbl_user::find($order->user_id);
            $order->customer_name = $customer ? $customer->name : 'Unknown';

            $order->order_items = json_decode($order->order_items, true);
        }

        $counts = [
            'all' => tbl_order::count(),
            'to_pay' => tbl_order::where('payment_status', 'unpaid')->count(),
            'to_ship' => tbl_order::whereIn('status', ['pending', 'processing'])->count(),
            'to_receive' => tbl_order::whereIn('status', ['shipped', 'delivered'])->count(),
            'completed' => tbl_order::where('status', 'completed')->count(),
            'cancelled' => tbl_order::where('status', 'cancelled')->count(),
        ];

        return view('superadmin.orderListPage.orderListPage', [
            'orders' => $orders,
            'current_status' => $status,
            'counts' => $counts
        ]);
    }

    public function updateOrderStatus(Request $request, $id){
        if(!session()->has('LoggedSuperadmin')) {
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
}
