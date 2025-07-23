<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Applicationtype;
use App\Models\Devicetype;

class ApplicationTypesManager extends Component
{
    public $applicationTypes, $name, $applicationType_id;
    public $isOpen = 0;
    public $devicetype_uuid;
    public $devices;
    public $deviceid = false;
    public $devicekey = false;
    public $otpcode = false;
    public $smartstbmac = false;

    public function render()
    {
        $this->applicationTypes = Applicationtype::all();
        $this->devices = Devicetype::all();
        return view('livewire.admin.application-types-manager');
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
        $this->applicationType_id = '';
        $this->devicetype_uuid = '';
        $this->deviceid = false;
        $this->devicekey = false;
        $this->otpcode = false;
        $this->smartstbmac = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'devicetype_uuid' => 'required|exists:devicetypes,uuid',
        ]);

        Applicationtype::updateOrCreate(['uuid' => $this->applicationType_id], [
            'name' => $this->name,
            'devicetype_uuid' => $this->devicetype_uuid,
            'deviceid' => $this->deviceid,
            'devicekey' => $this->devicekey,
            'otpcode' => $this->otpcode,
            'smartstbmac' => $this->smartstbmac,
        ]);

        session()->flash('message',
            $this->applicationType_id ? "Type d'application modifié." : "Type d'application créé.");

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($uuid = null)
    {
        if (!$uuid) return;
        $applicationType = Applicationtype::where('uuid', $uuid)->firstOrFail();
        $this->applicationType_id = $uuid;
        $this->name = $applicationType->name;
        $this->devicetype_uuid = $applicationType->devicetype_uuid;
        $this->deviceid = $applicationType->deviceid;
        $this->devicekey = $applicationType->devicekey;
        $this->otpcode = $applicationType->otpcode;
        $this->smartstbmac = $applicationType->smartstbmac;
        $this->openModal();
    }

    public function delete($uuid = null)
    {
        if (!$uuid) return;
        Applicationtype::where('uuid', $uuid)->delete();
        session()->flash('message', "Type d'application supprimé.");
    }

    public function toggleField($id, $field, $value)
    {
        $type = Applicationtype::find($id);
        if ($type && in_array($field, ['deviceid', 'devicekey', 'otpcode', 'smartstbmac'])) {
            $type->$field = $value;
            $type->save();
            session()->flash('message', "Champ $field mis à jour !");
        }
    }
} 