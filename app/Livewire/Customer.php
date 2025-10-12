<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customers;

class Customer extends Component
{

    public $isClicked = false;
    public $name = '';
    public $email;
    public $message;



    public function render()
    {
        return view('livewire.customer');
    }

    public function save(){
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message' => 'required|min:10'
        ]);

        Customers::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'reached_out' => false
        ]);


       
        $this->name = '';
        $this->email = '';
        $this->message = '';

        
    }
}
