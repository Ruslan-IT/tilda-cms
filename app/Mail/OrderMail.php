<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $orderId;

    public function __construct($data, $orderId)
    {
        $this->data = $data;
        $this->orderId = $orderId;
    }

    public function build()
    {


        return $this->subject('Новый заказ #'.$this->orderId)

            ->view('emails.order');
    }
}
