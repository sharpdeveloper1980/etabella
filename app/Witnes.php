<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Witnes extends Model
{
	protected $table="witness";
	protected $primaryKey="id";
	protected $fillable=['client_id','witness_name','created_at','updated_at'];
}
