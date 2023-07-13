<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'address', 'about', 'locale'];
    protected $fillable = ['user_id', 'email', 'website', 'mobile', 'telephone', 'fax', 'logo', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
