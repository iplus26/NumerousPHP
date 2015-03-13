<?php
	require_once "Numerous.php";
	
	$numerous = new Numerous("nmrs_aCidzHX709iL");
	
	$self = $numerous->get_user_self_info();
	
	$metrics =  $numerous->list_user_metrics("me")->metrics;
	
	var_dump($numerous->create_metric("sample label"));
	
	//$numerous->cr
?>