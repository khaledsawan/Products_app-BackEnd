<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;
use App\Models\Product;

use Laravel\Passport\HasApiTokens;

class Author extends Model implements AuthenticateContract
{
    use HasFactory, HasApiTokens, Authenticatable;

    public $timestamps = false;

    protected $fillable = ["name", "email", "password", "phone_number"];
    protected $hidden = ['password'];
    public function Products()
    {
        return $this->hasMany(Product::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
