<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crmform extends Model
{
  protected $fillable = ['dates','executive','customer','contactperson','designation','contactno','email','followupdate','feedback','is_deleted','is_returned','createdby','cmpid','finyear','wdate'];

          public function crmdetail()
{
 return $this->hasMany(crmdetail::class,'crmid');
}
}
