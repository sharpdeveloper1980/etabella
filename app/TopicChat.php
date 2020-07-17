<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicChat extends Model
{
    protected $table="topic_chat";
    protected $primaryKey="id";
    protected $fillable=['message','topic_id','msg_type','file_type','recipient_ids','sender_id','sender_name','reader_ids','new_msg'];
}
