<?php
function findTheRecent($folder,$filename){
	$files = glob("$folder/$filename *");
	$dateDiff2=10000;
	for($i = 0 ;$i<count($files); $i++){
		echo '<br>1. '.$firstName = end(explode("/", $files[$i]));
		$firstName = explode(" ",$firstName);
		echo '<Br>';
		var_dump($firstName);
		$count = count($firstName);
		$count = $count-4;
		$firstNameFinal='';
		for($j=0,$tmp=0; $j<=$count;$j++){
			$firstNameFinal.= $firstName[$j];
			if($tmp<$count){
				$firstNameFinal.=' ';
			}
		}
	$file = explode(' ',$files[$i]);	
		echo '<br>From: '.$from =$file[count($file)-3];
		$to =$file[count($file)-1];
			$to = explode('.',$to);
		echo '<br>To: '.$to = $to[0];
		$serverDate = Date('d-m-Y');
		$to = date_create($to);
		$serverDate= date_create($serverDate);
		$diff=date_diff($to,$serverDate);
		$dateDiff =  intval($diff->format("%R%a days"));
		if($dateDiff<$dateDiff2){
			$recent =  $files[$i];
			$dateDiff2= $dateDiff;
		}
		echo '<br><Br>';
	}
	return $recent;
}
echo '<br><h2>finally i found this file ::  '.$file = findTheRecent('../groups/Forex','U.S. Dollar   Swiss Franc  USD CHF');
?>