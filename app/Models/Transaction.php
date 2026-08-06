<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'user_id',
        'service_id',
        'status',
        'current_handler_id',
        'notes',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function currentHandler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_handler_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
