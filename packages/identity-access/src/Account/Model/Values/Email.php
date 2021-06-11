<?php

namespace Derhub\IdentityAccess\Account\Model\Values;

use Derhub\Shared\Values\Email as BaseEmail;

class Email extends BaseEmail
{

    public function __toString()
    {
        if ($this->isEmpty()) {
            return 'empty user email account';
        }
        
        return 'user account email [secrete]';
    }
}