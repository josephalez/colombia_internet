<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model{

  protected $fillable = [
    'name',
    'department_id',
    'trash'
  ];

}
