<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

abstract class BaseMailable extends Mailable
{
    public function __construct()
    {
        // Force From address to verified sender
        $this->from(
            config('mail.from.address'),
            config('mail.from.name')
        );
    }
}
