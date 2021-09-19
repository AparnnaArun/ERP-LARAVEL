<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stocktransfer extends Model
{
    protected $fillable = ['slno','transfer_no','transfer_date','transfer_to','remarks','is_deleted','createdby','cmpid','finyear','wdate','is_returned','total_amount'];


        public function stocktransferdetail()
{
 return $this->hasMany(stocktransferdetail::class,'transfer_id');
}
}
