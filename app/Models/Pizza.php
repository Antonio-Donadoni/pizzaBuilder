<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'size_id',
        'type_id'
        
      ];

      public function ingredients() {
        return $this -> belongsToMany(Ingredient::class);
      }
      public function orders() {
        return $this -> belongsToMany(Order::class);
      }

      public function type() {
        return $this -> belongsTo(Type::class);
      }

      public function size() {
        return $this -> belongsTo(Size::class);
      }
}
