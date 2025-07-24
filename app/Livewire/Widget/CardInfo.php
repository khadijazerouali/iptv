<?php

namespace App\Livewire\Widget;

use Livewire\Component;

class CardInfo extends Component
{
    public $cards = [
        ['icon' => 'fas fa-handshake',
        'title' => 'Satisfait ou Remboursé', 
        'text' => "Nous sommes sûrs que vous serez satisfait de notre abonnement IPTV. Dans le cas échéant, 
                    nous procéderons au remboursement de votre abonnement IPTV. A condition que ce soit signalé sous 48h
                    après l'installation de votre abonnement IPTV."],
        ['icon' => 'fas fa-rocket',
        'title' => 'Serveur IPTV Performant',
        'text' => "Nous offrons le serveur IPTV le plus performant sur le marché. Vous êtes connectés directement à notre
                    serveur IPTV avec la dernière technologie de sécurité. Nous offrons les chaines et les VOD en plusieurs
                    qualités d'image et notre liste est actualisée constamment."],
        ['icon' => 'fas fa-headset',
        'title' => 'Support IPTV 24h/7j',
        'text' => "L'installation IPTV est assurée à distance par l'intermédiaire de l'un de nos conseillers IPTV, elle ne 
                    nécessite aucune connaissance technique en IPTV. Il suffit de nous contacter par mail, un de nos 
                    conseillers techniques vous aidera à régler tout problème rencontré avec votre abonnement IPTV. "]
    ];
    public function render()
    {
        return view('livewire.widget.card-info');
    }
}
