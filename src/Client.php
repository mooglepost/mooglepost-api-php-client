<?php

/**
 * Client.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 */

namespace MooglePost;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class Client implements ClientInterface
{
    private $apiKey;
    private $apiUrl;

    public function __construct(string $apiKey, string $apiUrl = 'https://mooglepost.com/api/v1/')
    {
        $this->setApiKey($apiKey);
        $this->setApiUrl($apiUrl);
    }

    public function setApiKey(string $apiKey): ClientInterface
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setApiUrl(string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    public function send(
        string $to,
        string $templateName,
        array $variables = [],
        string $subject = null,
        string $text = null,
        string $html = null
    ): bool {
        $email = new Email();
        $email->addRecipient($to);
        $email->setTemplateName($templateName);
        $email->setVariables($variables);

        $email->setSubject($subject);
        $email->setText($text);
        $email->setHtml($html);

        return $this->sendEmail($email);
    }

    public function sendEmail(EmailInterface $email): bool
    {
        try {
            $httpClient = new \GuzzleHttp\Client([
                'base_uri' => $this->apiUrl
            ]);
            $httpRequest = new Request(
                'POST',
                'send',
                [
                    'X-Mglpst-ApiKey' => $this->apiKey
                ],
                (string) $email
            );
            $httpResponse = $httpClient->send($httpRequest);
        } catch (GuzzleException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }

        $ret = json_decode((string) $httpResponse->getBody(), true);
        if ($ret['status'] !== 'OK') {
            throw new ClientException($ret['message'], $ret['code']);
        }

        return true;
    }
}
