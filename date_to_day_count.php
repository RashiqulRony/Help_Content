<?php

	// $date1 = date('2017-12-10');
	// $date1 = date('2017-12-11');
	// // $date2 = date()


	//  $difference = $date1 - $date2;

	// echo $date1;

$startTimeStamp = strtotime("2011/07/01");
$endTimeStamp = strtotime("2011/07/17");

$timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);

echo $numberDays;

?>