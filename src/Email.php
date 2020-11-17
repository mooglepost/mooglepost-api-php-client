<?php

/**
 * Email.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 */

namespace MooglePost;

class Email extends AbstractEmail
{
    private $subject;
    private $text;
    private $html;
    private $embeds = [];
    private $attachments = [];

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(?string $html): self
    {
        $this->html = $html;

        return $this;
    }

    public function getEmbeds(): array
    {
        return $this->embeds;
    }

    public function addEmbed(array $embed): self
    {
        $this->embeds[] = $embed;

        return $this;
    }

    public function addEmbeddedImage(string $path, string $cid): bool
    {
        $this->addEmbed([
            'type' => 'image/' . pathinfo($path, PATHINFO_EXTENSION),
            'cid' => $cid,
            'content' => base64_encode(file_get_contents($path))
        ]);

        return true;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function addAttachment(array $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    public function jsonSerialize()
    {
        $array = [];

        if ($this->getSubject() !== null) {
            $array['subject'] = $this->getSubject();
        }

        if ($this->getText() !== null) {
            $array['text'] = $this->getText();
        }

        if ($this->getHtml() !== null) {
            $array['html'] = $this->getHtml();
        }

        if (count($this->getEmbeds()) > 0) {
            $array['embeds'] = $this->getEmbeds();
        }

        if (count($this->getAttachments()) > 0) {
            $array['attachments'] = $this->getAttachments();
        }

        return array_merge(parent::jsonSerialize(), $array);
    }
}
