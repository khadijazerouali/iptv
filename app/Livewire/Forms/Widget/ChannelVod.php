<?php

namespace App\Livewire\Forms\Widget;

use App\Models\Vod;
use App\Models\Channel;
use Livewire\Component;

class ChannelVod extends Component
{
    public $channelList;
    public $vodOptions;
    public $channels = [];
    public $vods = [];
    public function mount()
    {
        $this->channelList = Channel::all();
        $this->vodOptions = Vod::all();
    }
    public function render()
    {
        return view('livewire.forms.widget.channel-vod');
    }
}
