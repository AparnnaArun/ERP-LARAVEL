<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class openingstock extends Model
{
protected $fillable = ['location_id','item_type','category_id','createdby','cmpid','finyear','wdate'];


        public function openingstockdetail()
{
 return $this->hasMany(openingstockdetail::class,'opening_id');
}
}
