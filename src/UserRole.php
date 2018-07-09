<?php

namespace Hanoivip\Admin;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $primaryKey = 'user_id';
    
    public $timestamps = false;
}
