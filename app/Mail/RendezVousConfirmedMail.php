<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RendezVousConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public RendezVous $rendezVous)
    {
    }

    public function build(): self
    {
        return $this
            ->subject(__('Confirmation de votre rendez-vous'))
            ->view('emails.rendezvous-confirmed');
    }
}

