<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class openingaccount extends Model
{
       protected $fillable = ['schedule','diffopenbal','totdebit','totcredit','dates','createdby','cmpid','finyear','wdate'];


        public function openingaccountdetail()
{
 return $this->hasMany(openingaccountdetail::class,'opaccid');
}
}
