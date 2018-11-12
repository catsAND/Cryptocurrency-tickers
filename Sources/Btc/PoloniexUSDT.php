<?php

/**
* Polo usdt
*/
class PoloniexUSDT extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 1;

	/**
	 * Crypto currency cont id
	 *
	 * @var integer
	 */
	public $currency = 'USD';

	/**
	 * Url for curl
	 *
	 * @var string
	 */
	protected $url = 'https://poloniex.com/public?command=returnTicker';

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
		if(!empty($result['USDT_BTC'])) {
			if($result['USDT_BTC']['last'] > 0) {
				$this->price = $result['USDT_BTC']['last'];
				return;
			}
		}

		throw new Exception("Price error " . __CLASS__);
	}
}