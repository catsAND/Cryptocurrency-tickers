<?php

class OkcoinUSD extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 3;

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
	protected $url = 'https://www.okcoin.com/api/v1/ticker.do?symbol=btc_usd';

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
		if(!empty($result['ticker'])) {
			if($result['ticker']['last'] > 0) {
				$this->price = $result['ticker']['last'];
				return;
			}
		}

		throw new Exception("Price error " . __CLASS__);
	}
}