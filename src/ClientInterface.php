<?php

/**
 * ClientInterface.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 */

namespace MooglePost;

interface ClientInterface
{
    public function setApiKey(string $apiKey): self;

    public function sendEmail(EmailInterface $email): bool;
}
