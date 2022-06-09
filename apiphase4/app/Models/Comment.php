<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['value', 'product_id', 'author_id']; //

    public function Product()
    {
        return $this->belongsTo(product::class);
    }
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
