<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Contact;

class ContactsManager extends Component
{
    public $contacts;

    public function mount()
    {
        $this->loadContacts();
    }

    public function loadContacts()
    {
        $this->contacts = Contact::all();
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        session()->flash('success', 'Contact supprimé !');
        $this->loadContacts();
    }

    public function render()
    {
        return view('livewire.admin.contacts-manager');
    }
}
