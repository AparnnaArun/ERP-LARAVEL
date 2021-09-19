<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class goodsreceivednote extends Model
{
        protected $fillable = ['slno','grn_no','po_no','dc','dc_date','vendor','project_code','tot_qnty','dates','remarks','is_deleted','is_invoiced','createdby','finyear','wdate','cmpid','locations'];


        public function goodsreceivednotedetail()
{
 return $this->hasMany(goodsreceivednotedetail::class,'grnid');
}
}
