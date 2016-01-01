<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $fillable = ['title','content','excerpt'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];
}
