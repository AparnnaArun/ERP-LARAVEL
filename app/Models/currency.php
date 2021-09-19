<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class currency extends Model
{
   protected $fillable = ['currency','shortname','decimal','createdby','cmpid','finyear','wdate'];

}
