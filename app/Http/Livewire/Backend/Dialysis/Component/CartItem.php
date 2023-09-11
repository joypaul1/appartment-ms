<?php

namespace App\Http\Livewire\Backend\Dialysis\Component;

use Livewire\Component;

class CartItem extends Component
{
    public $item,$itemId ;

    public function mount($item, $itemId)
    {

        $this->item= $item;
        $this->itemId= $itemId;
    }

    public function render()
    {
        return view('livewire.backend.dialysis.component.cart-item');
    }

    public function updateQty($qty,$itemId)
    {
        $this->emit('updateQty',$qty,$itemId);
    }
}
