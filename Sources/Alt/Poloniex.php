<?php

class Poloniex extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 1;

	/**
	 * Url for curl
	 *
	 * @var string
	 */
	protected $url = 'https://poloniex.com/public?command=returnTicker';

	/**
	 * Server answer is json
	 *
	 * @var boolean
	 */
	protected $isJson = true;

	protected $crypto = [
		'BTC_BTS'   => 'BTS',
		'BTC_XBC'   => 'XBC',
		'BTC_ETH'   => 'ETH',
		'BTC_XRP'   => 'XRP',
		'BTC_LTC'   => 'LTC',
		'BTC_XMR'   => 'XMR',
		'BTC_ETC'   => 'ETC',
		'BTC_STEEM' => 'STEEM',
		'BTC_DASH'  => 'DASH',
		'BTC_DOGE'  => 'DOGE',
		'BTC_FCT'   => 'FCT',
		'BTC_SC'    => 'SC',
		'BTC_STR'   => 'STR',
		'BTC_ZEC'   => 'ZEC',
		'BTC_XEM'   => 'XEM',
		'BTC_LBC'   => 'LBC',
		'BTC_MAID'  => 'MAID',
		'BTC_DCR'   => 'DCR',
		'BTC_GNT'   => 'GNT',
		'BTC_REP'   => 'REP',
		'BTC_LSK'   => 'LSK',
		'BTC_CLAM'  => 'CLAM',
		'BTC_STRAT' => 'STRAT',
		'BTC_GNO'   => 'GNO',
		'BTC_PINK'  => 'PINK',
		'BTC_OMNI'  => 'OMNI',
		'BTC_ARDR'  => 'ARDR',
		'BTC_SJCX'  => 'SJCX',
		'BTC_ZRX'   => 'ZRX',
		'BTC_SYS'   => 'SYS',
		'BTC_NEOS'  => 'NEOS',
	];

	/**
	 * Parse cron query result
	 *
	 * @return string price
	 */
	protected function parseResult()
	{
		$result = [];
		if(!empty($this->result)) {
			foreach($this->crypto as $pair => $coin) {
				if(!empty($this->result[$pair])) {
					$result[$coin] = $this->result[$pair]['last'];
				}
			}
			$this->price = $result;
			return;
		}

		throw new Exception("Price error " . __CLASS__);
	}
}