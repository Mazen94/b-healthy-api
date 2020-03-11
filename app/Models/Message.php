<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Message
 * @package App
 * @property int $id
 * @property string $message
 * @property int $conversation_id
 */
class Message extends Model
{

    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * One To Many (Inverse)
     * @return BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }

}
