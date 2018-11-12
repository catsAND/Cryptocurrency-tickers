<?php

class BittrexUSDT extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 13;

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
	protected $url = 'https://bittrex.com/api/v1.1/public/getticker?market=USDT-BTC';

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
		if ($result['success']) {
			if($result['result']['Last'] > 0) {
				$this->price = $result['result']['Last'];
				return;
			}
		}

		throw new Exception("Price error " . __CLASS__);
	}
}
