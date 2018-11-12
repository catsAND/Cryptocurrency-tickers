<?php

class KrakenEUR extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 5;

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
	protected $url = 'https://api.kraken.com/0/public/Ticker?pair=XBTEUR';

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
		if(!empty($result['result'])) {
			if($result['result']['XXBTZEUR']['c'][0] > 0) {
				$this->price = $result['result']['XXBTZEUR']['c'][0];
				return;
			}
		}

		throw new Exception("Price error " . __CLASS__);
	}
}