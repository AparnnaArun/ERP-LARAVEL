<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regularvoucherentry extends Model
{
         protected $fillable = ['slno','keycode','voucher','voucher_no','dates','totdebit','totcredit','created_datetime','created_by','froms','remarks','approved_by','is_customeradnce','is_vendoradnce','optionalvoucher','from_where','regularized_by','createdby','cmpid','finyear','wdate','is_deleted'];

public function regularvoucherentrydetail()
{
 return $this->hasMany(regularvoucherentrydetail::class,'voucherid');
}
}
