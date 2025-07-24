<?php

namespace App\Livewire\Forms\Widget;

use Livewire\Component;
use App\Models\Devicetype;
use App\Models\Applicationtype;

class DeviceProduct extends Component
{
    public $deviceTypes;
    public $selectedDeviceType;
    public $applicationTypes = [];
    public $selectedApplicationType;
    public $device_uuid;
    public $deviceSelected;
    public $applicationSelected;

    public function mount()
    {
        $this->deviceTypes = Devicetype::all();
        $this->applicationTypes = collect(); // Ensure it's initialized as an empty collection
    }

    public function updatedSelectedDeviceType($value)
    {
        if ($value) {
            $this->applicationTypes = Applicationtype::where('devicetype_uuid', $value)->get();
            $this->deviceSelected = Devicetype::find($value);
            // dd($this->deviceSelected);
        } else {
            $this->applicationTypes = collect(); // Clear application types if no device type is selected
        }
    }

    public function updatedSelectedApplicationType($value)
    {
        $this->applicationSelected = Applicationtype::find($value);
        // dd($this->applicationSelected);
    }

    public function render()
    {
        return view('livewire.forms.widget.device-product');
    }
}