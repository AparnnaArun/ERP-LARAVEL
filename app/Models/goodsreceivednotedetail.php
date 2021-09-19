<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class goodsreceivednotedetail extends Model
{
    protected $fillable = ['grnid','item_id','item_code','item_name','unit','location','batch','quantity','invqnty','balqnty','rate','amount','createdby','finyear','wdate','cmpid'];

            public function goodsreceivednote()
{
 return $this->belongsTo(goodsreceivednote::class,'id');
}
}
