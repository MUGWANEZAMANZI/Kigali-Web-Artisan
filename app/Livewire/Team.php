<?php

namespace App\Livewire;

use Livewire\Component;

class Team extends Component
{
    public function render()
    {
        return view('livewire.team');
    }

    public function layout()
    {
        return view('components.layout');
    }

   
}
