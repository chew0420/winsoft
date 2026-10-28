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
use App\Models\tbl_page_section;

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
        if($page->page_name == 'Visitor Home Page'){
            $sections = tbl_page_section::where('page_id', $id)->orderBy('order')->get();

            return view('superadmin.pageBuilder.pageBuilder', ['page' => $page,'sections' => $sections]);
        }else{
            $filePath = $page->file_path;
            if(!view()->exists($filePath)) {
                return redirect('/superadmin/pageList')->with('error', 'View file not found: ' . $filePath);
            }
            $view = view($filePath);
            $fileContents = $view->render();

            // $originalRelativePath = str_replace('.', '/', trim($filePath));
            // $absoluteBladePath = resource_path('views/' . $originalRelativePath . '.blade.php');
            
            // if(!file_exists($absoluteBladePath)) {
            //     return redirect('/superadmin/pageList')->with('error', 'Blade file not found: ' . $absoluteBladePath);
            // }

            // $fileContents = File::get($absoluteBladePath);

            $editableContent = $this->generateEditableHTML($fileContents);
            return view('superadmin.editPage.editPage', ['editableContent' => $editableContent,'page' => $page]);
        }
        
    }

    public function addSection(Request $request, $pageId){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $request->validate([
            'section_type' => 'required|in:hero,products,categories,banner,featured,custom_html',
            'title' => 'nullable|string|max:255',
        ]);

        $maxOrder = tbl_page_section::where('page_id', $pageId)->max('order') ?? 0;

        $section = new tbl_page_section();
        $section->page_id = $pageId;
        $section->section_type = $request->section_type;
        $section->title = $request->title;
        $section->order = $maxOrder + 1;
        $section->is_active = true;
        
        $content = $this->getDefaultContent($request->section_type);
        $section->content = $content;
        $section->settings = [];
        $section->save();

        return redirect()->back()->with('success', 'Section added successfully!');
    }

    private function getDefaultContent($type){
        switch($type) {
            case 'hero':
                return [
                    'title' => 'Welcome to Winsoft Solutions',
                    'subtitle' => 'Your Trusted Tech Partner',
                    'image' => 'img/banner.jpg',
                    'button_text' => 'Shop Now',
                    'button_url' => '/shop'
                ];
            case 'products':
                return ['limit' => 8];
            case 'categories':
                return [
                    'limit' => 6
                ];
            case 'banner':
                return [
                    'image' => 'img/banner.jpg',
                    'link' => '#',
                    'alt' => 'Banner'
                ];
            case 'featured':
                return ['product_ids' => []];
            case 'custom_html':
                return ['html' => '<div class="custom-content"><h3>Custom Content</h3><p>Add your custom HTML here</p></div>'];
            default:
                return [];
        }
    }

    public function updateSection(Request $request, $sectionId){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $section = tbl_page_section::find($sectionId);

        if(!$section) {
            return response()->json([
                'error' => 'Section not found'
            ], 404);
        }

        $request->validate([
            'section_type' => 'sometimes|in:hero,products,categories,banner,featured,custom_html',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Basic fields
        |--------------------------------------------------------------------------
        */

        if($request->has('section_type')) {
            $section->section_type = $request->section_type;
        }

        if($request->has('title')) {
            $section->title = $request->title;
        }

        /*
        |--------------------------------------------------------------------------
        | Merge old + new content
        |--------------------------------------------------------------------------
        */

        $existingContent = $section->content ?? [];

        $newContent = $request->input(
            'content',
            []
        );

        $content = array_merge(
            $existingContent,
            $newContent
        );

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        if($request->hasFile('image')) {

            $image = $request->file('image');

            $extension = strtolower(
                $image->getClientOriginalExtension()
            );

            $imageName =
                'section_' .
                $section->section_id .
                '_' .
                date('Ymd_His') .
                '_' .
                uniqid() .
                '.' .
                $extension;

            $imageDirectory = public_path('img');

            if(!file_exists($imageDirectory)) {
                mkdir(
                    $imageDirectory,
                    0777,
                    true
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Save new image
            |--------------------------------------------------------------------------
            */

            $image->move(
                $imageDirectory,
                $imageName
            );

            /*
            |--------------------------------------------------------------------------
            | Delete previous Page Builder image
            |--------------------------------------------------------------------------
            */

            $oldImage =
                $existingContent['image'] ?? null;

            if($oldImage) {

                $oldImage =
                    ltrim(
                        $oldImage,
                        '/'
                    );

                if(
                    str_starts_with(
                        $oldImage,
                        'img/'
                    )
                    &&
                    str_starts_with(
                        basename($oldImage),
                        'section_'
                    )
                ) {

                    $oldImagePath =
                        public_path(
                            $oldImage
                        );

                    if(
                        file_exists($oldImagePath)
                        &&
                        is_file($oldImagePath)
                    ) {
                        unlink($oldImagePath);
                    }

                }
            }

            /*
            |--------------------------------------------------------------------------
            | Put path into content
            |--------------------------------------------------------------------------
            */

            $content['image'] =
                'img/' . $imageName;
        }

        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $section->content = $content;

        if($request->has('is_active')) {
            $section->is_active =
                $request->boolean('is_active');
        }

        $section->save();

        return response()->json([
            'success' => true,
            'message' => 'Section updated successfully!'
        ]);
    }

    public function reorderSections(Request $request){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $order = $request->input('order', []);
        
        foreach($order as $position => $sectionId) {
            tbl_page_section::where('section_id', $sectionId)
                ->update(['order' => $position + 1]);
        }

        return response()->json(['success' => 'Sections reordered successfully!']);
    }

    public function deleteSection($sectionId){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $section = tbl_page_section::find($sectionId);
        if($section) {
            $section->delete();
            return response()->json(['success' => 'Section deleted successfully!']);
        }

        return response()->json(['error' => 'Section not found'], 404);
    }

    public function getSectionEditor($sectionId){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $section = tbl_page_section::find($sectionId);
        if(!$section) {
            return response()->json(['error' => 'Section not found'], 404);
        }

        return view('superadmin.pageBuilder.partials.section_editor', [
            'section' => $section
        ]);
    }

    public function toggleSection($sectionId){
        if(!session()->has('LoggedSuperadmin')) {
            return redirect('/login');
        }

        $section = tbl_page_section::find($sectionId);
        if($section) {
            $section->is_active = !$section->is_active;
            $section->save();
            return response()->json(['success' => 'Section toggled successfully!']);
        }

        return response()->json(['error' => 'Section not found'], 404);
    }

    // Update visitor home page method
    public function visitorHome(){
        $page = tbl_website_page::where('page_name', 'Visitor Home Page')->first();
        
        if($page) {
            $sections = tbl_page_section::where('page_id', $page->page_id)->where('is_active', true)->orderBy('order')->get();
            
            return view('visitor.homePage.homePage', ['sections' => $sections]);
        }
        
        // Fallback
        $products = tbl_product::where('status', 'active')->limit(8)->get();
        $categories = tbl_category::where('status', 'active')->get();
        
        return view('visitor.homePage.homePage', [
            'products' => $products,
            'categories' => $categories
        ]);
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

        $oldContent = '';

        if (File::exists($originalFilePath)) {
            $oldContent = File::get($originalFilePath);
        }
        
        $updatedContent = $request->input('updatedContent');

        // Decode and persist data:image/*;base64 images into public/img/
        $updatedContent = $this->persistBase64Images($updatedContent);

        $updatedContent = $this->removeContentEditable($updatedContent);
        
        // Save the updated content to the original file
        File::put($originalFilePath, $updatedContent);

        // Delete images that were removed/replaced from this page
        $this->deleteRemovedImages($oldContent, $updatedContent);

        return redirect('superadmin/pageList')->with('success', 'Page updated successfully.');
    }

    private function deleteRemovedImages($oldContent, $newContent){
        // Find all images inside old content
        preg_match_all(
            '#<img[^>]+src=["\'](?:/)?img/([^"\']+)["\']#i',
            $oldContent,
            $oldMatches
        );

        // Find all images inside new content
        preg_match_all(
            '#<img[^>]+src=["\'](?:/)?img/([^"\']+)["\']#i',
            $newContent,
            $newMatches
        );

        $oldImages = $oldMatches[1] ?? [];
        $newImages = $newMatches[1] ?? [];

        // Images that existed before but are no longer used
        $removedImages = array_diff($oldImages, $newImages);

        foreach ($removedImages as $imageName) {

            $imageName = basename($imageName);

            $imagePath = public_path('img/' . $imageName);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
    }

    private function persistBase64Images($html){
        $pattern = '/<img([^>]*?)src=["\'](data:image\/(png|jpeg|jpg|gif|webp);base64,([^"\']+))["\']([^>]*)>/i';

        $html = preg_replace_callback($pattern, function ($matches) {

            $beforeSrc = $matches[1];
            $fullBase64 = $matches[2];
            $extension = strtolower($matches[3]);
            $base64Data = $matches[4];
            $afterSrc = $matches[5];

            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            /*
            |--------------------------------------------------------------------------
            | 1. Find old image path from data-old-src
            |--------------------------------------------------------------------------
            */

            $oldSrc = null;

            $fullAttributes = $beforeSrc . $afterSrc;

            if (
                preg_match(
                    '/data-old-src=["\']([^"\']+)["\']/i',
                    $fullAttributes,
                    $oldMatch
                )
            ) {
                $oldSrc = $oldMatch[1];
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Decode new base64 image
            |--------------------------------------------------------------------------
            */

            $decodedImage = base64_decode($base64Data);

            if ($decodedImage === false) {
                return $matches[0];
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Create new image filename
            |--------------------------------------------------------------------------
            */

            $filename =
                'editor_' .
                date('Ymd_His') .
                '_' .
                uniqid() .
                '.' .
                $extension;

            $relativePath = 'img/' . $filename;

            $fullPath = public_path($relativePath);

            /*
            |--------------------------------------------------------------------------
            | 4. Save new image first
            |--------------------------------------------------------------------------
            */

            file_put_contents($fullPath, $decodedImage);

            /*
            |--------------------------------------------------------------------------
            | 5. Delete old image if it exists
            |--------------------------------------------------------------------------
            */

            if ($oldSrc) {

                // If old src is full URL:
                // http://127.0.0.1:8000/img/xxx.jpg
                $parsedPath = parse_url($oldSrc, PHP_URL_PATH);

                if ($parsedPath) {
                    $oldSrc = $parsedPath;
                }

                // Remove leading slash
                $oldSrc = ltrim($oldSrc, '/');

                /*
                | Only delete files inside public/img
                | This avoids deleting external files or unrelated assets.
                */
                if (str_starts_with($oldSrc, 'img/')) {

                    $oldFullPath = public_path($oldSrc);

                    if (
                        file_exists($oldFullPath) &&
                        is_file($oldFullPath)
                    ) {
                        @unlink($oldFullPath);
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 6. Remove data-old-src from final HTML
            |--------------------------------------------------------------------------
            */

            $beforeSrc = preg_replace(
                '/\s*data-old-src=["\'][^"\']*["\']/i',
                '',
                $beforeSrc
            );

            $afterSrc = preg_replace(
                '/\s*data-old-src=["\'][^"\']*["\']/i',
                '',
                $afterSrc
            );

            /*
            |--------------------------------------------------------------------------
            | 7. Return clean img tag
            |--------------------------------------------------------------------------
            */

            return '<img'
                . $beforeSrc
                . 'src="/'
                . $relativePath
                . '"'
                . $afterSrc
                . '>';
        }, $html);

        return $html;
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
