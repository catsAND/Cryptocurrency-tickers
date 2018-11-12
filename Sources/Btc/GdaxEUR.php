<?php

class GdaxEUR extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 11;

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
	protected $url = 'https://api.gdax.com/products/btc-eur/ticker';

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