<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
 protected $fileable =['name','user_id','price','category','location','descirption','view','image'];
 use HasFactory;

}
