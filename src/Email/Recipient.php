<?php
/**
 * Email/Recipient.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
**/

namespace MooglePost\Email;

class Recipient implements \JsonSerializable {
	private $email;

	public function __construct($email) {
		$this->setEmail($email);
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;

		return $this;
	}

	public function jsonSerialize() {
		$array = array(
			'email' => $this->getEmail()
		);

		return $array;
	}
}
