<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
  use HasFactory;

  // protected $fillable = [
  //   'title',
  //   'company',
  //   'location',
  //   'website',
  //   'email',
  //   'description',
  //   'tags',
  // ];

  public function getRouteKeyName() {
    return 'id';
  }

  public function scopeFilter($query, array $filters)
  {
    if ($filters['tag'] ?? false) {
      $query->where('tags', 'like', '%' . request('tag') . '%');
    }

    if ($filters['search'] ?? false) {
      $expression = ['like', '%' . request('search') . '%'];

      $query->where('title', ...$expression)
        ->orWhere('description', ...$expression)
        ->orWhere('tags', ...$expression);
    }
  }
}
