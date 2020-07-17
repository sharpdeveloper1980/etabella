<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table="issue";
	protected $primaryKey="id";
	protected $fillable=['name','color','client_id'];
}
