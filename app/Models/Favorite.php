<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Favorite extends Model
{
    //
	

	public function users(){
        $this->belongsTo('App\User');
    }


    public static function has_liked_a_product($user_id,$product_id){
        $has_liked_a_product = Favorite::where(['user_id'=>$user_id,'product_id'=>$product_id])->first();
        return !empty($has_liked_a_product) ? true : false;
    }


    public function product_variation(){
        return $this->belongsTo(ProductVariation::class);
    }


    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopeCreateOrDelete(Builder $builder,$user_id,$id){

        $favorite = where(['user_id'=>$user_id,'product_variation_id'=>$id])->first();
         if ( null !== $favorite ) { 
             $favorite->delete();

             $favorites = $builder->where(['user_id'=>$user_id,'product_variation_id'=>$id])->all();

             return $favorites;
         }  else {
            $favorite = new Favorite;
            $favorite->user_id = $user_id;
            $favorite->product_variation_id = $id;
            $favorite->save();
            $favorites = $builder->where(['user_id'=>$user_id,'product_variation_id'=>$id])->all();
            return $favorites;

         }
     }
	
}
