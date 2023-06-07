<?php

namespace App\Message;

class RegisterVerificationMail
{
    public function __construct(public int $user)
    {
    }
}