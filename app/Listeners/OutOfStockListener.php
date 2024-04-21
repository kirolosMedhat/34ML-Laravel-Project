<?php

namespace App\Listeners;

use App\Mail\StockNotificationMail;
use App\Events\ProductOutOfStock;
use App\Mail\NotifyMail;
use App\Notifications\StockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class OutOfStockListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProductOutOfStock $event)
    {
         $adminEmail = 'kirolos.medhat.maksoud@gmail.com'; // Admin's email address

        // // Notify the admin via email
        // Notification::route('mail', $adminEmail)
        //     ->notify(new StockNotification($event->product));
        Mail::to($adminEmail)->send(new NotifyMail($event->product));
        // $event->product->notify(new StockNotification($event->product));
        // dd($event->product);

    }
}
