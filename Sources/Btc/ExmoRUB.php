<?php

class ExmoRUB extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 12;

	/**
	 * Currency
	 *
	 * @var integer
	 */
	public $currency = 'RUB';

	/**
	 * Url for curl
	 *
	 * @var string
	 */
	protected $url = 'https://api.exmo.com/v1/ticker/';

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
		if(!empty($result['BTC_RUB'])) {
			if($result['BTC_RUB']['last_trade'] > 0) {
				$this->price = $result['BTC_RUB']['last_trade'];
				return;
			}
		}

		throw new Exception("Price error " . __CLASS__);
	}
}