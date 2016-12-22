<?php
/**
 * Client.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
**/

namespace MooglePost;

class Client {
	private $url = 'https://mooglepost.com/api/v1/send';
	private $apiKey;

	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
	}

	public function send($to, $templateName, array $variables = array(), $subject = NULL, $text = NULL, $html = NULL) {
		$email = new Email($to);
		$email->setTemplateName($templateName)
		      ->setVariables($variables)
		      ->setSubject($subject)
		      ->setText($text)
		      ->setHtml($html);

		return $this->sendEmail($email);
	}

	public function sendEmail(Email $email) {
		try {
			$HttpClient = new \Phyrexia\Http\Client();
			$HttpRequest = new \Phyrexia\Http\Request('POST', $this->url, array('X-Mglpst-ApiKey' => $this->apiKey));
			$HttpClient->setRequest($HttpRequest);
			$HttpClient->setPostData(json_encode($email));
			$HttpResponse = $HttpClient->send();
		} catch (\Phyrexia\Http\ClientException $e) {
			throw new ClientException($e->getMessage(), $e->getCode(), $e);
		}

		$ret = json_decode((string)$HttpResponse, true);
		if ($ret['status'] != 'OK') {
			throw new ClientException($ret['message'], $ret['code']);
		}

		return true;
	}
}
