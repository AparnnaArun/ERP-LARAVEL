<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchasereturn extends Model
{
protected $fillable = ['slno','prtn','dates','vendor','project_code','currency','pi_no','discount_total','tot_qnty','tamount','nettotal','erate','totalamount','createdby','finyear','wdate','cmpid','is_deleted'];


        public function purchasereturndetail()
{
 return $this->hasMany(purchasereturndetail::class,'purrtn_id');
}
}
