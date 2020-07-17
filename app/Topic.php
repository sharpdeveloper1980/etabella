<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table="topics";
    protected $primaryKey="topic_id";
    protected $fillable=['client_id','topic_name','created_by','job_id'];
}
