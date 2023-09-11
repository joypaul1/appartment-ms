<?php

namespace App\Imports;

use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\WareHouse;
use App\Models\Item\Item;
use App\Models\Item\Strength;
use App\Models\Item\Subcategory;
use App\Models\Item\Type;
use App\Models\Item\Unit;
use App\Models\ItemCount;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportItem implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {


        

    }
}
