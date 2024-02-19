<?php

namespace App\Livewire;

use Livewire\Component;

class VoucherModal extends Component
{
    public $voucherId;

    public function show($voucherId)
    {
        $this->voucherId = $voucherId;
    }
    public function close()
    {
        $this->voucherId = null;
    }
    
    public function render()
    {
        return view('livewire.voucher-modal');
    }
}
