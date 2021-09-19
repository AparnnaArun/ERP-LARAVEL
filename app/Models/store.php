<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class store extends Model
{
     protected $fillable = ['locationtype','locationname','active','defaults','createdby','cmpid','finyear','wdate'];
}

