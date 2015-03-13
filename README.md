# Overview

This is a [Numerous](http://www.numerousapp.com/) API client, in PHP. You can retrieve and update data of Numerous, and do more interesting things with the Numerous app, using the API.

> Numerous is a mobile personal dashboard that allows you to follow and share the most important numbers in your life. The Numerous app is powered by the Numerous API.

# Example

`<?php

	require_once "Numerous.php";
	
	$numerous = new Numerous("nmrs_aCidzHX709iL");
	
	$self = $numerous->get_user_self_info();
	
	$metrics =  $numerous->list_user_metrics("me")->metrics;`

?>`

# Todo

I have just finish the GET method. The POST/PUT/DEL method will be done soon, and more methods will be added.