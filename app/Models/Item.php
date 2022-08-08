<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasUUID, hasFactory;

    protected $fillable = [
        'description',
        'duration',
        'price',
        'obligatory',
    ];

    protected $casts = [
        'obligatory' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($item) {
            $item->position = $item->section->getNextItemPosition();
        });
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
