<?php

namespace App\Services;

class Sms
{
	protected $service;

	public function __construct(string $provider)
	{
		switch ($provider)
		{
			case 'netgsm':
				$this->service = \App\Services\SmsProviders\NetgsmSmsProvider::class;
			break;
		}
	}

	public function send(string $phone, string $message)
	{
		return (new $this->service)->send($phone, $message);
	}
}
