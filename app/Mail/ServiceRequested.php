<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Service; // Import the Service model

class ServiceRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $service;

    /**
     * Create a new message instance.
     *
     * @param  \App\Service  $service
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Service Requested')
                    ->view('mail.service_mail');
    }
}
