<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hyperlink extends Model
{
    protected $table="hyperlinks";
	protected $primaryKey="id";
	protected $fillable=['file_id','url','annotation_id'];
}
