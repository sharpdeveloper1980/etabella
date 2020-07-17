<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Witness_file extends Model
{
    protected $table="witness_file";
	protected $primaryKey="id";
	protected $fillable=['witness_id','doc_id','doc_issuename','doc_color','list_order'];
}
