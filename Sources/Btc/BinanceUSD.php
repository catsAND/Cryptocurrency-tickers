<?php

class BinanceUSD extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 14;

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
	protected $url = 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT';

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
		if($result['price'] > 0) {
			$this->price = $result['price'];
			return;
		}

		throw new Exception("Price error " . __CLASS__);
	}
}
