<?php

class QuoineUSD extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 9;

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
	protected $url = 'https://api.quoine.com/products/1';

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
		if($result['last_traded_price'] > 0) {
			$this->price = $result['last_traded_price'];
			return;
		}

		throw new Exception("Price error " . __CLASS__);
	}
}