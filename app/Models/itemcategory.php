<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemcategory extends Model
{
    protected $fillable = ['category','itemtype','active','createdby','cmpid','finyear','wdate'];

}
