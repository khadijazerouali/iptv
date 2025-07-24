<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderInfoToClient extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $product;
    public $subscription;
    public $formiptv;
    public $cart;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $product, $subscription = null, $formiptv = null, $cart = null)
    {
        $this->user = $user;
        $this->product = $product;
        $this->subscription = $subscription;
        $this->formiptv = $formiptv;
        $this->cart = $cart;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre commande - ' . ($this->product->title ?? 'Produit'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_info_to_client',
            with: [
                'user' => $this->user,
                'product' => $this->product,
                'subscription' => $this->subscription,
                'formiptv' => $this->formiptv,
                'cart' => $this->cart,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 