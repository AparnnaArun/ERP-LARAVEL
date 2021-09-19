<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockissuereturn extends Model
{
protected $fillable = ['slno','issuertn_no','stockissueno','issuertn_date','issuertn_from','return_type','createdby','cmpid','finyear','wdate','location','total_amount','remarks','is_deleted','is_returned'];


        public function stockissuereturndetail()
{
 return $this->hasMany(stockissuereturndetail::class,'stissrtn_id');
}
}
