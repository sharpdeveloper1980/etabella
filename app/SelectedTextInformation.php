<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedTextInformation extends Model
{
    protected $table="selected_text_information";
    protected $primaryKey="id";
    protected $fillable=['text','instance_json','main_instance_json_id','comment'];

}
