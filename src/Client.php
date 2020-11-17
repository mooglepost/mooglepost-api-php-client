<?php

/**
 * Client.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
**/

namespace MooglePost;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class Client
{
    private $apiKey;
    private $apiUrl = 'https://mooglepost.com/api/v1/';

    public function __construct(string $apiKey, string $apiUrl = null)
    {
        $this->apiKey = $apiKey;

        if ($apiUrl !== null) {
            $this->apiUrl = $apiUrl;
        }
    }

    public function send(
        string $to,
        string $templateName,
        array $variables = [],
        ?string $subject = null,
        ?string $text = null,
        ?string $html = null
    ) {
        $email = new Email($to);
        $email->setTemplateName($templateName)
              ->setVariables($variables)
              ->setSubject($subject)
              ->setText($text)
              ->setHtml($html)
        ;

        return $this->sendEmail($email);
    }

    public function sendEmail(Email $email)
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

        $ret = json_decode((string) $httpResponse, true);
        if ($ret['status'] !== 'OK') {
            throw new ClientException($ret['message'], $ret['code']);
        }

        return true;
    }
}
