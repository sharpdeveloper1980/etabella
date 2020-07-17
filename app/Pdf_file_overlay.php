<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdf_file_overlay extends Model
{
    protected $table="pdf_file_overlay";
    protected $primaryKey="id";
    protected $fillable=['file_id','file_name','file_type'];
}
