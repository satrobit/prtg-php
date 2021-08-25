<?php

/**
* Class prtg
* @package satrobit\prtg-php
*/
class prtg {
	private static $server;
	private static $username;
	private static $password;
	private static $passhash;

	/**
	* @param string $server
	* @param string $username
	* @param string $password
	*/
	function __construct($server, $username, $password)
	{
		if (empty($server)) throw new Exception('Server parameter cannot be empty.');

		self::$server = rtrim($server, '/\\');
		self::$username = $username;
		self::$password = $password;
		self::$passhash = $this->getpasshash();

		if (!self::$passhash) throw new Exception('Provided credentials are wrong.');
	}

	/**
	* @param string $url
	*
	* @return string
	*/
	private function sendRequest($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	/**
	* @param string $path
	* @param array $parameters
	* @param bool $auth
	* @param bool $json
	*
	* @return array
	*/
	private function get($path, $parameters, $json = true, $auth = true)
	{
		if ($auth)
		{
			$parameters['username'] = self::$username;
			$parameters['passhash'] = self::$passhash;
		}

		$baseUrl = self::$server;
		$queryString = http_build_query($parameters);
		$requestUrl = $baseUrl . '/' . $path . '?' . $queryString;

		$response = $this->sendRequest($requestUrl);

		if ($json) return json_decode($response, true);
		return $response;
	}

	/**
	* @return int
	*/
	public function getpasshash()
	{
		$response =  $this->get('api/getpasshash.htm', ['username' => self::$username, 'password' => self::$password], false, false);

		if (!is_numeric($response)) return false;

		return $response;
	}

	/**
	* @param int $sensorId
	*
	* @return array
	*/
	public function getsensordetails($sensorId)
	{
		$response =  $this->get('api/getsensordetails.json', ['id' => $sensorId]);

		if (is_null($response)) throw new Exception('Could not find the sensor.');
		
		return $response;
	}

	/**
	* @param int $sensorId
	* @param string $sdate
	* @param string $edate
	* @param int $avg
	*
	* @return array
	*/
	public function historicdata($sensorId, $sdate, $edate, $avg = 0)
	{
		$response =  $this->get('api/historicdata.json', ['id' => $sensorId, 'sdate' => $sdate, 'edate' => $edate, 'avg' => $avg]);
		if (is_null($response)) throw new Exception('Could not find the sensor.');

		return $response;
	}

	/**
	* @param int $sensorId
	* @param string $sdate
	* @param string $edate
	* @param int $graphid
	* @param string $type
	* @param int $avg
	* @param int $height
	* @param int $width
	*
	* @return string
	*/
	public function chart($sensorId, $sdate, $edate, $graphid, $type = 'svg', $avg = 15, $height = 270, $width = 850)
	{
		$response =  $this->get('chart.' . $type, ['id' => $sensorId, 'sdate' => $sdate, 'edate' => $edate, 'avg' => $avg, 'graphid' => $graphid, 'height' => $height, 'width' => $width], false);

		if ($response == 'Error creating chart.') throw new Exception('Error creating chart.');

		return $response;
	}

}

?>
