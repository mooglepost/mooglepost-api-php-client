<?php

/**
 * EmailInterface.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 */

namespace MooglePost;

interface EmailInterface
{
    public function getRecipients(): array;

    public function addRecipient(string $emailAddress): self;

    public function removeRecipient(string $emailAddress): self;

    public function getTemplateName(): string;

    public function setTemplateName(string $templateName): self;
}
