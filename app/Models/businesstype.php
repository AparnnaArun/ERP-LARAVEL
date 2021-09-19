<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class businesstype extends Model
{
   protected $fillable = ['btype','active','createdby','cmpid','finyear','wdate'];
}
