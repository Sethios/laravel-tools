<?php

namespace App\Models;

use App\Listeners\¤ModelP¤Stored;
use App\Listeners\¤ModelP¤Updated;
use App\Listeners\¤ModelP¤Deleted;

class ¤ModelP¤ extends Model
{
    /**
     * Data type conversion
     */
    protected $casts = [

    ];

    /**
     * The event map for the model.
     *
     */
    protected $dispatchesEvents = [
        'created' => ¤ModelP¤Stored::class,
        'updated' => ¤ModelP¤Updated::class,
        'deleted' => ¤ModelP¤Deleted::class,
    ];
}
