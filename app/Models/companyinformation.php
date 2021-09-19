<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companyinformation extends Model
{
    use HasFactory;
   
    protected $fillable = ['name','short_name','address','phone','email','active','trading','manufacturing','admin','inventory','accounts','hr','createdby','compid','finyear','wdate','fax'];
}
