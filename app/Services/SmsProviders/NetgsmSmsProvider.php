<?php

namespace App\Services\SmsProviders;

use Meng\Soap\Interpreter;

class NetgsmSmsProvider
{
	private function XML2JSON($xml)
	{
		$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
		$xml = simplexml_load_string($xml);
		$json = json_encode($xml);

		return json_decode($json, true);
	}

	public function send(string $phone, string $message)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		    CURLOPT_URL => 'http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl/',
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => '',
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 0,
		    CURLOPT_FOLLOWLOCATION => true,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => 'POST',
		    CURLOPT_POSTFIELDS => '<?xml version="1.0"?>
		    <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
		                 xmlns:xsd="http://www.w3.org/2001/XMLSchema"
		      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
		        <SOAP-ENV:Body>
		            <ns3:smsGonder1NV2 xmlns:ns3="http://sms/">
		                <username>'.config('services.netgsm.username').'</username>
		                <password>'.config('services.netgsm.password').'</password>
		                <header>'.config('services.netgsm.header').'</header>
		                <msg>'.$message.'</msg>
		                <gsm>'.$phone.'</gsm>
		                <encoding>TR</encoding>
		            </ns3:smsGonder1NV2>
		        </SOAP-ENV:Body>
		    </SOAP-ENV:Envelope>',
		    CURLOPT_HTTPHEADER => array(
		        'Content-Type: text/xml'
		    ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$kod = intval(@$this->XML2JSON($response)['SBody']['ns2smsGonder1NV2Response']['return']);

		switch ($kod)
		{
			case 20:
				// Log::create([
				// 	'mesaj' => 'Mesaj metninde ki problemden dolayı gönderilemediğini veya standart maksimum mesaj karakter sayısını geçtiğini ifade eder.(Standart maksimum karakter sayısı 917 dir. Eğer mesajınız türkçe karakter içeriyorsa Türkçe Karakter Hesaplama menüsunden karakter sayılarının hesaplanış şeklini görebilirsiniz.)',
				// 	'phone' => $phone
				// ]);
			break;
			case 30:

			break;
			case 40:

			break;
			case 50:

			break;
			case 51:

			break;
			case 70:

			break;
			case 80:

			break;
			case 85:

			break;
			case 100:
			case 101:

			break;
		}

		return $kod > 1000 ? true : false;
	}
}
