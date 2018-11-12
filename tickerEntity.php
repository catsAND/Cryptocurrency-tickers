<?php

/**
 * Cron ticker class
 */
abstract class Ticker
{
	protected $result;
	protected $price;

	protected function execute()
	{
		$ch = curl_init();

		$curl_options = array(
			CURLOPT_URL => $this->url,
			CURLOPT_HEADER => false,
			CURLOPT_HTTPHEADER => array("User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0", "Accept: text/html,application/xhtml+xml,application/xml,application/json;q=0.9,*/*;q=0.8", ),
			CURLOPT_AUTOREFERER => false,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 0,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POST => false,
		);

		curl_setopt_array($ch, $curl_options);

		$this->result = curl_exec($ch);

		if ($errno = curl_errno($ch)) {
			throw new Exception("Curl error 1" . $errno);
		}
		curl_close($ch);

		if ($this->isJson) {
			$this->result = json_decode($this->result, true);
			if (is_null($this->result)) {
				throw new Exception("Curl json_decode error");
			}
		}
	}

	abstract protected function parseResult();

	public function getPrice()
	{
		try {
			$this->execute();
			$this->parseResult();
		} catch (Exception $e) {
			return false;
		}

		return $this->price;
	}
}
