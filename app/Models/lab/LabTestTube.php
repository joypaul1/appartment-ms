<?php

namespace App\Models\lab;

use App\Models\Item\Brand;
use App\Models\Item\Gallery;
use App\Models\Item\GenericName;
use App\Models\Item\Strength;
use App\Models\Item\Type;
use App\Models\Item\Unit;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LabTestTube extends Model
{
    use GlobalScope, AutoTimeStamp;

    protected $guarded =['id'];

    /**
     * Get all of the galleries for the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'item_id', 'id');
    }







    /**
     * Get the unit that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the brand that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the genericName that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genericName(): BelongsTo
    {
        return $this->belongsTo(GenericName::class, 'generic_id', 'id');
    }

    /**
     * Get the genericName that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function strength(): BelongsTo
    {
        return $this->belongsTo(Strength::class, 'strength_id', 'id');
    }

    /**
     * Get the genericName that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
    public function itemCount()
    {
        return $this->hasOne(LabTestItemCount::class, 'item_id', 'id');
    }
}
