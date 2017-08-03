<?php

require 'prtg.class.php';

try {

	/**
	* Connect to PRTG
	*/
	$stack = new prtg('https://prtg.paessler.com/', 'demo', 'demo');

	/**
	* Get passhash
	*/
	$passhash = $stack->getpasshash();

	/**
	* Get details about a sensor
	*/
	$sensorDetails = $stack->getsensordetails(2017);


	/**
	* Getting Historic Sensor Data
	*/
	$historicData = $stack->historicdata('2017', '2017-07-26', '2017-07-27', 15);

	/**
	* Using Live Sensor Graphs from PRTG in Other Web Pages
	*/
	$chart = $stack->chart(2017, '2017-07-26', '2017-07-27', 2, 'svg', 15, 270, 850);


} catch (Exception $e) {
	print_r($e->getMessage());
}




?>