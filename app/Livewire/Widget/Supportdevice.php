<?php

namespace App\Livewire\Widget;

use Livewire\Component;

class Supportdevice extends Component
{
    // Define supported devices as an array
    public $supportedDevices = [
        ['image' => '/assets/images/10-300x100-1.png', 'alt' => 'VLC'],
        ['image' => '/assets/images/11-1-300x100-1.png', 'alt' => 'MAG BOX'],
        ['image' => '/assets/images/4-8-300x100-1.png', 'alt' => 'Roku TV'],
        ['image' => '/assets/images/5-7-300x100-1.png', 'alt' => 'Amazon Fire TV'],
        ['image' => '/assets/images/6-5-300x100-1.png', 'alt' => 'Xbox One'],
        ['image' => '/assets/images/7-2-300x100-1.png', 'alt' => 'PlayStation'],
        ['image' => '/assets/images/8-300x100-1.png', 'alt' => 'Other Device 1'],
        ['image' => '/assets/images/9-300x100-1-1.png', 'alt' => 'Other Device 2']
    ];

    public function render()
    {
        return view('livewire.widget.supportdevice');
    }
}
