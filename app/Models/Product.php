<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use Notifiable;
    
    
    
    
    
    protected $fillable = [
        'product_id', 'product_code', 'name', 'description', 'logo', 'claim',
        'images', 'highlights', 'fullitinerary', 'things_to_note', 'what_included',
        'meta_title','meta_description','meta_keyphrases','meta_keywords','url_personalizzato',
        'is_tour','priority','special_claim' , 'why_us' ,'special_claim_type',"private_tour"
    ];

    protected   $dates  =   ['created_at', 'updated_at'];

    /**
     * @$img_url url storage instance
     * @size of the image {small,featured,medium} 
     * 
     */
    static function getInstanceImage($img_url , $size){

        $img_url = str_replace("storage/" , "" , $img_url );
        $img_url = str_replace("product_images/" , "product_images/$size/" , $img_url );
        return $img_url;
    }

}
