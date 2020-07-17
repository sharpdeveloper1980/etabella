<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adminrole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admin_roles';
    protected $primaryKey = 'id';
    public $timestamps = false;



    protected $fillable = [
        'role','slug'
    ];
}

// Note : This Model class linked with user_level column in users table for admins role