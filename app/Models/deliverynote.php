<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deliverynote extends Model
{
        protected $fillable = ['slno','deli_note_no','so_no','customer','project_code','remarks','dates','cancelled_reason','manual_do','customer_po','from_so','executive','total','is_invoiced','is_dortn','is_deleted','createdby','cmpid','finyear','wdate'];


        public function deliverynotedetail()
{
 return $this->hasMany(deliverynotedetail::class,'dln_id');
}
}
