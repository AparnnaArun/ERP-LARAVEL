<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crmdetail extends Model
{
    protected $fillable = ['crmid','contactperson','designation','contactno','email','createdby','cmpid','finyear','wdate'];
}
