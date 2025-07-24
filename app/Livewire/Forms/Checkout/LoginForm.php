<?php

namespace App\Livewire\Forms\Checkout;

use Livewire\Component;

class LoginForm extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function submit()
    {
        $this->validate();
        
        session()->flash('success', 'Vous êtes connecté avec succès.');
    }
    public function render()
    {
        return view('livewire.forms.checkout.login-form');
    }
}
