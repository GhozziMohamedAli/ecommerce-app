<?php

namespace App\Livewire;

use Livewire\Component;

class Order extends Component
{
    public $title;
    public function render()
    {
        return view('livewire.order');
    }

    public function joking(){
        $this->boo = "lokolo";
    }
}
