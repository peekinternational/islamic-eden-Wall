<?php

namespace Edenmill;

use Illuminate\Database\Eloquent\Model;

class MoreSubNav extends Model
{
    protected $table = 'more_sub_navs';

        protected $fillable = ['title','sub_id','url','slug','order_by','page_id','hidden'];
        protected $dates = ['created_at','updated_at'];

        public function sub_navs(){
                return $this->hasOne(SubNavs::class,'id','sub_id');
        }
        public function page(){
             return $this->belongsTo(Pages::class,'page_id','id');
        }

        public function products(){
                return $this->belongsToMany(Products::class,'product_navs','sub_id','product_id');

        }
}
