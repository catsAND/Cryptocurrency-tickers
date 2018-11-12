<?php

class BitstampEUR extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 7;

	/**
	 * Currency
	 *
	 * @var integer
	 */
	public $currency = 'EUR';

	/**
	 * Url for curl
	 *
	 * @var string
	 */
	protected $url = 'https://www.bitstamp.net/api/v2/ticker/btceur/';

	/**
	 * Online / Offline state
	 *
	 * @var boolean
	 */
	protected $active = true;

	/**
	 * Server answer is json
	 *
	 * @var boolean
	 */
	protected $isJson = true;

	/**
	 * Parse cron query result
	 *
	 * @return string price
	 */
	protected function parseResult()
	{
		$result = $this->result;
		if($result['last'] > 0) {
			$this->price = $result['last'];
			return;
		}

		throw new Exception("Price error " . __CLASS__);
	}
}