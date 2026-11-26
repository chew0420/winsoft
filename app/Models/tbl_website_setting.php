<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_website_setting extends Model
{
    protected $table = 'tbl_website_setting';
    protected $primaryKey = 'setting_id';

    public const DEFAULT_NAME = 'Winsoft Solutions';
    public const DEFAULT_LOGO = 'img/winsoftlogo.png';

    protected $fillable = [
        'website_name',
        'website_logo',
        'favicon',
        'footer_description',
        'copyright_text',
        'contact_address',
        'contact_phone',
        'contact_email',
        'facebook_url',
        'instagram_url',
        'whatsapp_number',
        'show_footer_brand',
        'show_footer_links',
        'show_footer_contact',
        'show_footer_social'
    ];

    protected $casts = [
        'show_footer_brand' => 'boolean',
        'show_footer_links' => 'boolean',
        'show_footer_contact' => 'boolean',
        'show_footer_social' => 'boolean'
    ];

    public function getLogoUrlAttribute(){
        $path = $this->website_logo ?: self::DEFAULT_LOGO;
        return asset(is_file(public_path($path)) ? $path : self::DEFAULT_LOGO);
    }

    public function getFaviconUrlAttribute(){
        $path = $this->favicon ?: self::DEFAULT_LOGO;
        return asset(is_file(public_path($path)) ? $path : self::DEFAULT_LOGO);
    }

    public function getPhoneLinkAttribute(){
        if(!$this->contact_phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9+]/', '', $this->contact_phone);

        if(str_starts_with($phone, '0')) {
            $phone = '+60'.substr($phone, 1);
        }

        return 'tel:'.$phone;
    }

    public function getWhatsappUrlAttribute(){
        if(!$this->whatsapp_number) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp_number);

        return 'https://wa.me/'.$phone;
    }

    public function getContactMapUrlAttribute(){
        if(!$this->contact_address) {
            return null;
        }

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode($this->contact_address);
    }
}