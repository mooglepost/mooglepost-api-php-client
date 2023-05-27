<?php

/**
 * ClientException.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 */

namespace MooglePost;

use Exception;
use Throwable;

class ClientException extends Exception
{
    private array $recipients = [];

    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null, array $recipients = [])
    {
        parent::__construct($message, $code, $previous);

        $this->recipients = $recipients;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
