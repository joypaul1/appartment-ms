<?php

namespace App\Models\Item;

use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    protected $table = "childcategories";

    use GlobalScope, AutoTimeStamp,Sluggable;

    protected $guarded =['id'];

     /**
     * Get the ChildCategory that owns the category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

     /**
     * Get the ChildCategory that owns the subcategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }
}
