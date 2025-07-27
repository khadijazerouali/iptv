<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function sendTicketReplyNotification($ticket, $reply)
    {
        // Notification au client quand l'admin répond
        if ($reply->is_admin_reply) {
            self::createNotification(
                $ticket->user_id,
                Notification::TYPE_TICKET_REPLY,
                'Nouvelle réponse à votre ticket',
                "L'équipe support a répondu à votre ticket : {$ticket->subject}",
                [
                    'ticket_id' => $ticket->id,
                    'ticket_uuid' => $ticket->uuid,
                    'reply_id' => $reply->id,
                ],
                route('support.show', $ticket->uuid)
            );
        }
        // Notification à l'admin quand le client répond
        else {
            // Notifier tous les admins
            $admins = User::where('role', 'admin')->orWhere('role', 'super_admin')->get();
            foreach ($admins as $admin) {
                self::createNotification(
                    $admin->id,
                    Notification::TYPE_TICKET_REPLY,
                    'Nouvelle réponse client',
                    "Le client {$ticket->user->name} a répondu au ticket : {$ticket->subject}",
                    [
                        'ticket_id' => $ticket->id,
                        'ticket_uuid' => $ticket->uuid,
                        'user_id' => $ticket->user_id,
                        'reply_id' => $reply->id,
                    ],
                    route('admin.support.show', $ticket->uuid)
                );
            }
        }
    }

    public static function sendTicketStatusNotification($ticket, $oldStatus, $newStatus)
    {
        $statusLabels = [
            'open' => 'en attente',
            'in_progress' => 'en cours',
            'resolved' => 'résolu',
            'closed' => 'fermé',
        ];

        $oldLabel = $statusLabels[$oldStatus] ?? $oldStatus;
        $newLabel = $statusLabels[$newStatus] ?? $newStatus;

        // Notification au client
        self::createNotification(
            $ticket->user_id,
            Notification::TYPE_TICKET_STATUS,
            'Statut de votre ticket mis à jour',
            "Votre ticket '{$ticket->subject}' est maintenant {$newLabel}",
            [
                'ticket_id' => $ticket->id,
                'ticket_uuid' => $ticket->uuid,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ],
            route('support.show', $ticket->uuid)
        );
    }

    public static function sendOrderConfirmedNotification($order)
    {
        self::createNotification(
            $order->user_id,
            Notification::TYPE_ORDER_CONFIRMED,
            'Commande confirmée',
            "Votre commande #{$order->id} a été confirmée et activée",
            [
                'order_id' => $order->id,
                'order_uuid' => $order->uuid,
                'total' => $order->total,
            ],
            route('dashboard.orders.show', $order->uuid)
        );
    }

    public static function sendOrderStatusNotification($order, $oldStatus, $newStatus)
    {
        $statusLabels = [
            'pending' => 'en attente',
            'confirmed' => 'confirmée',
            'active' => 'active',
            'cancelled' => 'annulée',
            'expired' => 'expirée',
        ];

        $newLabel = $statusLabels[$newStatus] ?? $newStatus;

        self::createNotification(
            $order->user_id,
            Notification::TYPE_ORDER_STATUS,
            'Statut de commande mis à jour',
            "Votre commande #{$order->id} est maintenant {$newLabel}",
            [
                'order_id' => $order->id,
                'order_uuid' => $order->uuid,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ],
            route('dashboard.orders.show', $order->uuid)
        );
    }

    private static function createNotification($userId, $type, $title, $message, $data = [], $actionUrl = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'action_url' => $actionUrl,
        ]);
    }
} 