<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Class NoteItem
 * @package App
 */
class NoteItem extends Model
{
    // include the soft delete trait scope
    // these allows querys records with a where deleted_at IS NOT NULL scope
    // Refer https://laravel.com/docs/7.x/eloquent#soft-deleting
    use SoftDeletes;

    /**
     * Hidden attrs
     * @var string[]
     */
    protected $hidden = [
        'id', 'deleted_at'
    ];

    /**
     * Autofill the uuid field when the model instance is being created.
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($noteInstance) {
            $noteInstance->uuid = Uuid::uuid4()->toString();
        });
    }

    /**
     * Returns route model key name
     * Overridden to uuid
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDateString();
    }
}
