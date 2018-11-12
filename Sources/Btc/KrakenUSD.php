<?php

class KrakenUSD extends Ticker
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
	public $currency = 'USD';

	/**
	 * Url for curl
	 *
	 * @var string
	 */
	protected $url = 'https://api.kraken.com/0/public/Ticker?pair=XBTUSD';

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
			if($result['result']['XXBTZUSD']['c'][0] > 0) {
				$this->price = $result['result']['XXBTZUSD']['c'][0];
				return;
			}
		}

		throw new Exception("Price error " . __CLASS__);
	}
}