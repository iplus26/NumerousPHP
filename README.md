# Overview

This is a [Numerous API](http://docs.numerous.apiary.io/) client, in PHP. You can retrieve and update data of Numerous, and do more interesting things with the Numerous app, using the API.

> [Numerous](http://numerousapp.com) is a mobile personal dashboard that allows you to follow and share the most important numbers in your life. The Numerous app is powered by the Numerous API.

# Example

``` php

	<?php

	require_once "Numerous.php";
	
	$numerous = new Numerous("###your api key here###");
	
	$self = $numerous->get_user_self_info();
	
	$metrics =  $numerous->list_user_metrics("me")->metrics;`

```

# Todo

The client is not complete, lacking Events, Interactions, Users, and Stream methods. 

I will finish it as soon as possible. 

Also feel free to help me with that.