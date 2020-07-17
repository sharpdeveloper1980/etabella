<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedTextComment extends Model
{
   	protected $table='selected_text_comment';
   	protected $primaryKey='id';
   	protected $fillable=['parent','comment','user_id'];
}
