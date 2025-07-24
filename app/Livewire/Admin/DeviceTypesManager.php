<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Devicetype;

class DeviceTypesManager extends Component
{
    public $deviceTypes, $name, $deviceType_id;
    public $isOpen = 0;

    public function render()
    {
        $this->deviceTypes = Devicetype::all();
        return view('livewire.admin.device-types-manager');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->deviceType_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        Devicetype::updateOrCreate(['uuid' => $this->deviceType_id], [
            'name' => $this->name,
        ]);

        session()->flash('message',
            $this->deviceType_id ? "Type d'appareil modifié." : "Type d'appareil créé.");

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($uuid)
    {
        $devicetype = Devicetype::where('uuid', $uuid)->firstOrFail();
        $this->deviceType_id = $uuid;
        $this->name = $devicetype->name;
        $this->openModal();
    }

    public function delete($uuid)
    {
        Devicetype::where('uuid', $uuid)->delete();
        session()->flash('message', "Type d'appareil supprimé.");
    }
}
