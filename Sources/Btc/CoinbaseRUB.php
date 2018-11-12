<?php

/**
* Polo usdt
*/
class CoinbaseRUB extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 2;

	/**
	 * Crypto currency cont id
	 *
	 * @var integer
	 */
	public $currency = 'RUB';

	/**
	 * Url for curl
	 *
	 * @var string
	 */
	protected $url = 'https://api.coinbase.com/v2/prices/spot?currency=RUB';

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
		if(!empty($result['data'])) {
			if($result['data']['amount'] > 0) {
				$this->price = $result['data']['amount'];
				return;
			}
		}

		throw new Exception("Price error " . __CLASS__);
	}
}