<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_page_section extends Model
{
    //
    protected $primaryKey = 'section_id';

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    public function page(){
        return $this->belongsTo(tbl_website_page::class, 'page_id', 'page_id');
    }

    public function render(){
        switch($this->section_type) {
            case 'products':
                return $this->renderProductsSection();
            case 'categories':
                return $this->renderCategoriesSection();
            case 'hero':
                return $this->renderHeroSection();
            case 'banner':
                return $this->renderBannerSection();
            case 'featured':
                return $this->renderFeaturedSection();
            case 'custom_html':
                return $this->renderCustomHtmlSection();
            default:
                return '<div class="alert alert-warning">Unknown section type: ' . $this->section_type . '</div>';
        }
    }

    private function renderProductsSection(){
        $content = $this->content ?? [];
        $limit = $content['limit'] ?? 8;
        $products = \App\Models\tbl_product::where('status', 'active')->limit($limit)->get();

        $html = '<div class="section-wrapper section-products" data-section-id="'.$this->section_id.'">';
        $html .= '<div class="container">';
        $html .= '<h2 class="mb-4">'.($this->title ?? 'Top Products').'</h2>';
        $html .= '<div class="row">';
        
        foreach($products as $product) {
            $html .= '<div class="col-md-3 col-sm-6 mb-4">';
            $html .= '<a href="/product/'.$product->product_id.'" style="text-decoration: none; color: inherit;">';
            $html .= '<div class="card h-100 product-card">';
            if($product->image) {
                $html .= '<img src="'.asset($product->image).'" class="card-img-top" alt="'.$product->name.'" style="height:200px; object-fit:cover;">';
            } else {
                $html .= '<div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">No Image</div>';
            }
            $html .= '<div class="card-body text-center">';
            $html .= '<h5 class="card-title">'.$product->name.'</h5>';
            $html .= '<p class="card-text text-danger fw-bold">RM '.number_format($product->price, 2).'</p>';
            $html .= '<p class="card-text small">'.substr($product->description, 0, 60).'...</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }

    private function renderCategoriesSection(){
        $categories = \App\Models\tbl_category::where('status', 'active')->get();

        $html = '<div class="section-wrapper section-categories" data-section-id="'.$this->section_id.'">';
        $html .= '<div class="container">';
        $html .= '<h2 class="mb-4">'.($this->title ?? 'Shop By Categories').'</h2>';
        $html .= '<div class="row">';
        
        foreach($categories as $category) {
            $html .= '<div class="col-md-3 col-sm-6 mb-4">';
            $html .= '<div class="card category-card text-center">';
            $html .= '<div class="card-body">';
            $html .= '<div class="category-icon" style="font-size: 48px;">📁</div>';
            $html .= '<a href="/shop?category='.urlencode($category->name).'" class="text-decoration-none">';
            $html .= '<h5 class="card-title mt-2">'.$category->name.'</h5>';
            $html .= '</a>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }

    private function renderHeroSection(){
        $content = $this->content ?? [];
        $title = $content['title'] ?? 'Welcome to Winsoft Solution';
        $subtitle = $content['subtitle'] ?? 'Your Trusted Tech Partner';
        $image = $content['image'] ?? 'img/banner.jpg';
        $button_text = $content['button_text'] ?? 'Shop Now';
        $button_url = $content['button_url'] ?? '/shop';

        $html = '<div class="section-wrapper section-hero" data-section-id="'.$this->section_id.'">';
        $html .= '<div class="hero-banner" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(\''.asset($image).'\'); background-size: cover; background-position: center; padding: 100px 0; text-align: center; color: white;">';
        $html .= '<div class="container">';
        $html .= '<h1 style="font-size: 48px; margin-bottom: 20px;">'.$title.'</h1>';
        $html .= '<p style="font-size: 24px; margin-bottom: 30px;">'.$subtitle.'</p>';
        if($button_text && $button_url) {
            $html .= '<a href="'.$button_url.'" class="btn btn-light btn-lg">'.$button_text.'</a>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }

    private function renderBannerSection(){
        $content = $this->content ?? [];
        $image = $content['image'] ?? 'img/banner.jpg';
        $link = $content['link'] ?? '#';
        $alt = $content['alt'] ?? 'Banner';

        $html = '<div class="section-wrapper section-banner" data-section-id="'.$this->section_id.'">';
        $html .= '<div class="container">';
        $html .= '<a href="'.$link.'">';
        $html .= '<img src="'.asset($image).'" alt="'.$alt.'" class="img-fluid rounded">';
        $html .= '</a>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }

    private function renderFeaturedSection(){
        $content = $this->content ?? [];
        $product_ids = $content['product_ids'] ?? [];
        $products = \App\Models\tbl_product::whereIn('product_id', $product_ids)
                    ->where('status', 'active')
                    ->get();

        $html = '<div class="section-wrapper section-featured" data-section-id="'.$this->section_id.'">';
        $html .= '<div class="container">';
        $html .= '<h2 class="mb-4">'.($this->title ?? 'Featured Products').'</h2>';
        $html .= '<div class="row">';
        
        foreach($products as $product) {
            $html .= '<div class="col-md-3 col-sm-6 mb-4">';
            $html .= '<div class="card h-100 product-card">';
            if($product->image) {
                $html .= '<img src="'.asset($product->image).'" class="card-img-top" alt="'.$product->name.'" style="height:200px; object-fit:cover;">';
            }
            $html .= '<div class="card-body text-center">';
            $html .= '<h5 class="card-title">'.$product->name.'</h5>';
            $html .= '<p class="card-text text-danger fw-bold">RM '.number_format($product->price, 2).'</p>';
            $html .= '<span class="badge bg-warning text-dark">⭐ Featured</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }

    private function renderCustomHtmlSection(){
        $content = $this->content ?? [];
        $html_content = $content['html'] ?? '';

        $html = '<div class="section-wrapper section-custom" data-section-id="'.$this->section_id.'">';
        $html .= '<div class="container">';
        $html .= $html_content;
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}
