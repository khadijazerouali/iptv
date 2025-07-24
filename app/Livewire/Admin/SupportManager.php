<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SupportTicket;

class SupportManager extends Component
{
    public $tickets;

    public function mount()
    {
        $this->tickets = SupportTicket::with('user')->get();
    }

    public function render()
    {
        return view('livewire.admin.support-manager');
    }
}
