<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'slug', 'category_id', 'locale'];

    protected $fillable = [
        'user_id',
        'status',
        'image',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
