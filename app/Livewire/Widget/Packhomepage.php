<?php

namespace App\Livewire\Widget;

use Livewire\Component;

class Packhomepage extends Component
{
    // Define pricing plans as an array
    public $pricingPlans = [
        [
            'name' => 'Pack Gold',
            'duration' => '12 Mois',
            'price' => '€ 49',
            'features' => [
                '+ 14000 Chaines',
                '+ 50000 Vods multilingue',
                'Connexion simultanée',
                'Qualité FHD/HD/SD',
                'Technologie Antifreeze',
                'Chaines en Replay',
                'Satisfait ou Remboursé',
                'Support Technique 24h/7 par email ou whatsapp'
            ],
            'style' => 'background: linear-gradient(to bottom, #e0f0ff, #a0c4ff);'
        ],
        [
            'name' => 'Pack Premium',
            'duration' => '12 Mois',
            'price' => '€ 59',
            'features' => [
                '+ 15000 Chaines',
                '+ 90000 Vods multilingue',
                'Qualité 4K/FHD/HD/SD',
                'Technologie Antifreeze',
                'Smart TV & Box Android',
                'Chaines en Replay',
                'Satisfait ou Remboursé',
                'Support Technique 24h/7 par email ou whatsapp'
            ],
            'style' => 'background: linear-gradient(to bottom, #333, #111); color: white;'
        ],
        [
            'name' => 'Pack Ultra Premium',
            'duration' => '12 Mois',
            'price' => '€ 79',
            'features' => [
                '+ 22000 Chaines',
                '+ 120000 Vods multilingue',
                'Qualité 4K/FHD/HD/SD',
                'Technologie Antifreeze',
                'Smart TV & Box Android',
                'Chaines en Replay',
                'Satisfait ou Remboursé',
                'Support Technique 24h/7 par email ou whatsapp'
            ],
            'style' => 'background: linear-gradient(to bottom, #e0f0ff, #a0c4ff);'
        ]
    ];

    public function render()
    {
        return view('livewire.widget.packhomepage');
    }
}
