<?php

/**
 * Email.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
**/

namespace MooglePost;

use JsonSerializable;

class Email implements JsonSerializable
{
    private $templateName;
    private $variables = array();
    private $subject;
    private $text;
    private $html;
    private $recipients = array();
    private $embedded = array();

    public function __construct($email)
    {
        $this->addRecipient($email);
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function addRecipient($email)
    {
        foreach ($this->recipients as $k => $recipient) {
            if (strtolower($recipient->getEmail()) == strtolower($email)) {
                return true;
            }
        }

        $recipient = new Email\Recipient();
        $recipient->setEmail($email);
        $this->recipients[] = $recipient;

        $this->recipients = array_values($this->recipients);

        return true;
    }

    public function removeRecipient($email)
    {
        foreach ($this->recipients as $k => $recipient) {
            if (strtolower($recipient->getEmail()) == strtolower($email)) {
                unset($this->recipients[$k]);
            }
        }

        $this->recipients = array_values($this->recipients);

        return true;
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function setVariables(array $variables)
    {
        $this->variables = $variables;

        return $this;
    }

    public function getTemplateName()
    {
        return $this->templateName;
    }

    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;

        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getHtml()
    {
        return $this->html;
    }

    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    public function addEmbedded(array $embedded)
    {
        $this->embedded[] = $embedded;

        return true;
    }

    public function getEmbedded()
    {
        return $this->embedded;
    }

    public function jsonSerialize()
    {
        $array = array(
            'templateName' => $this->getTemplateName(),
            'recipients' => $this->getRecipients()
        );

        if (is_array($this->getVariables()) && count($this->getVariables()) > 0) {
            $array['variables'] = $this->getVariables();
        }

        if (! is_null($this->getSubject())) {
            $array['subject'] = $this->getSubject();
        }
        if (! is_null($this->getText())) {
            $array['text'] = $this->getText();
        }
        if (! is_null($this->getHtml())) {
            $array['html'] = $this->getHtml();
        }

        if (count($this->getEmbedded()) > 0) {
            $array['embedded'] = $this->getEmbedded();
        }

        return $array;
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
