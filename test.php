<?php
	require_once "Numerous.php";
	
	$numerous = new Numerous("###your api key here###");
	
	//$self = $numerous->get_user_self_info();
	
	$metrics = $numerous->list_user_metrics("me")->metrics;
	
	//var_dump($metrics);
	
	for($i = 0; $i < count($metrics); $i++){
		if($metrics[$i]->label === "Step Counter"){
			echo $metrics[$i]->value;
		}
	}
?>