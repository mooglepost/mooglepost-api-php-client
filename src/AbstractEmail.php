<?php

/**
 * AbstractEmail.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 */

namespace MooglePost;

use JsonSerializable;
use Stringable;

abstract class AbstractEmail implements EmailInterface, JsonSerializable, Stringable
{
    private $recipients = [];
    private $templateName;
    private $variables = [];

    public function __construct(string $emailAddress = null)
    {
        if ($emailAddress !== null) {
            $this->addRecipient($emailAddress);
        }
    }

    public function getRecipients(): array
    {
        return array_values($this->recipients);
    }

    public function addRecipient(string $emailAddress): EmailInterface
    {
        foreach ($this->recipients as $k => $recipient) {
            if (strtolower($recipient->getEmail()) === strtolower($emailAddress)) {
                return $this;
            }
        }

        $this->recipients[] = new Email\Recipient($emailAddress);

        return $this;
    }

    public function removeRecipient(string $emailAddress): EmailInterface
    {
        foreach ($this->recipients as $k => $recipient) {
            if (strtolower($recipient->getEmail()) === strtolower($emailAddress)) {
                unset($this->recipients[$k]);
            }
        }

        return $this;
    }

    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    public function setTemplateName(string $templateName): EmailInterface
    {
        $this->templateName = $templateName;

        return $this;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function setVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'recipients' => $this->getRecipients(),
            'templateName' => $this->getTemplateName(),
            'variables' =>  $this->getVariables(),
        ];
    }

    public function __toString(): string
    {
        return json_encode($this);
    }
}
