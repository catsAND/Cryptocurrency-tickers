<?php

class Bittrex extends Ticker
{
	/**
	 * Source id
	 *
	 * @var integer
	 */
	public $source = 2;

	/**
	 * Url for curl
	 *
	 * @var string
	 */
	protected $url = 'https://bittrex.com/api/v1.1/public/getmarketsummaries';

	/**
	 * Server answer is json
	 *
	 * @var boolean
	 */
	protected $isJson = true;

	protected $crypto = [
		'BTC-BTS'   => 'BTS',
		'BTC-ETH'   => 'ETH',
		'BTC-XRP'   => 'XRP',
		'BTC-LTC'   => 'LTC',
		'BTC-XMR'   => 'XMR',
		'BTC-ETC'   => 'ETC',
		'BTC-STEEM' => 'STEEM',
		'BTC-DASH'  => 'DASH',
		'BTC-DOGE'  => 'DOGE',
		'BTC-FCT'   => 'FCT',
		'BTC-SC'    => 'SC',
		'BTC-ZEC'   => 'ZEC',
		'BTC-XEM'   => 'XEM',
		'BTC-LBC'   => 'LBC',
		'BTC-MAID'  => 'MAID',
		'BTC-DCR'   => 'DCR',
		'BTC-GNT'   => 'GNT',
		'BTC-REP'   => 'REP',
		'BTC-LSK'   => 'LSK',
		'BTC-CLAM'  => 'CLAM',
		'BTC-STRAT' => 'STRAT',
		'BTC-GNO'   => 'GNO',
		'BTC-PINK'  => 'PINK',
		'BTC-OMNI'  => 'OMNI',
		'BTC-ARDR'  => 'ARDR',
		'BTC-PIVX'  => 'PIVX',
		'BTC-NEO'   => 'NEO',
		'BTC-CVC'   => 'CVC',
		'BTC-BCC'   => 'BCH',
		'BTC-WAVES' => 'WAVES',
		'BTC-OMG'   => 'OMG',
		'BTC-PAY'   => 'PAY',
		'BTC-STORJ' => 'STORJ',
		'BTC-BAT'   => 'BAT',
		'BTC-LUN'   => 'LUN',
		'BTC-NXT'   => 'NXT',
		'BTC-DCT'   => 'DCT',
		'BTC-XVG'   => 'XVG',
		'BTC-SIB'   => 'SIB',
		'BTC-KMD'   => 'KMD',
		'BTC-SNT'   => 'SNT',
		'BTC-MCO'   => 'MCO',
		'BTC-SYS'   => 'SYS',
		'BTC-RISE'  => 'RISE',
		'BTC-QTUM'  => 'QTUM',
		'BTC-AEON'  => 'AEON',
		'BTC-NEOS'  => 'NEOS',
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
			foreach($this->result['result'] as $key => $val) {
				if(in_array($val['MarketName'], array_keys($this->crypto))) {
					$result[$this->crypto[$val['MarketName']]] = $val['Last'];
				}
			}
			$this->price = $result;
			return;
		}

		throw new Exception("Price error " . __CLASS__);
	}
}