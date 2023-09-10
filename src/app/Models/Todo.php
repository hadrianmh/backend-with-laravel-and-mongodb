<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Todo extends Model
{
    protected $collection = 'todo';
    
    protected $primaryKey = 'uuid';
    protected $fillable   = ['uuid','title', 'description'];
    protected $hidden     = ['_id','updated_at'];
}
