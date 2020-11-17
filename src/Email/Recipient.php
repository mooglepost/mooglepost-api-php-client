<?php

/**
 * Email/Recipient.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 */

namespace MooglePost\Email;

use JsonSerializable;
use Stringable;

class Recipient implements JsonSerializable, Stringable
{
    private $email;

    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'email' => $this->getEmail(),
        ];
    }

    public function __toString(): string
    {
        return json_encode($this);
    }
}
