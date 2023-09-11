<?php

namespace App\Http\Livewire\Backend\Dialysis\Component;

use Livewire\Component;

class CartServiceName extends Component
{
    public $serviceName,$serviceNameId ;

    public function mount($serviceName, $serviceNameId)
    {
        $this->serviceName= $serviceName;
        $this->serviceNameId= $serviceNameId;
    }

    public function render()
    {
        return view('livewire.backend.dialysis.component.cart-serviceName');
    }

    public function updateQty($qty,$serviceNameId)
    {
        $this->emit('updateQty',$qty, $serviceNameId);
    }
}
