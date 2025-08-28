<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\View\View;

class Team extends Component
{
    public function render() : View
    {
        return view('livewire.team')->layout('components.layouts.app1');
    }


}
