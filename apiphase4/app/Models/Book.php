<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fileable = ["author_id", "name", "date_one", "date_two", "date_three", "dis_one", "dis_two", "dis_three", "exp_date", "price", "image", "quantity", "phone_number"]; //
}
