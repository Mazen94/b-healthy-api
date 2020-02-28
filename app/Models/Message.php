<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /* message Attributes:
     *      int id
     *      string message
     *      int conversation_id
     */

    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * One To Many (Inverse)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo('App\Models\Conversation');
    }

}
