<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database', 'mail', 'broadcast'];
//        if($notifiable->notify_sms){
//            $via[] = 'nexmo';
//        }
//        if($notifiable->notify_email){
//            $via[] = 'mail';
//        }
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Order #' . $this->order->number)
                    ->from('invoices@localhost', 'GSG Billing')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('A new order has been created Order #:'.$this->order->number)
                    ->action('View Order', url('/'))
                    ->line('Thank you for shopping with us!');
//                    ->view('', [
//                        'order' => $this->order
//                    ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Order #'.$this->order->number,
            'body' => 'A new order has been created Order #:'.$this->order->number,
            'icon' => '',
            'url' => url('/'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'New Order #'.$this->order->number,
            'body' => 'A new order has been created Order #:'.$this->order->number,
            'icon' => '',
            'url' => url('/'),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
