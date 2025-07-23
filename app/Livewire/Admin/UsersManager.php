<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UsersManager extends Component
{
    public $users;
    public $roles = ['super-admin', 'user'];

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::with('roles')->get();
    }

    public function updateRole($id, $role)
    {
        $user = User::findOrFail($id);
        if ($user->email === 'admin@admin.com') {
            session()->flash('error', 'Impossible de modifier le rôle de l\'admin principal.');
            return;
        }
        $user->syncRoles([$role]);
        session()->flash('success', 'Rôle mis à jour.');
        $this->loadUsers();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->email === 'admin@admin.com') {
            session()->flash('error', 'Impossible de supprimer l\'admin principal.');
            return;
        }
        $user->delete();
        session()->flash('success', 'Utilisateur supprimé.');
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin.users-manager');
    }
}
