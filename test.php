<? 
	

	$feedBackLevel = "feedBackLevel=5";

	$curl = curl_init("https://prod.library.gvsu.edu/trafficapi/feedback/");

	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_USERPWD, ":bc2655e9dd");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $feedBackLevel);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HEADER  , true);  // we want headers
	curl_setopt($curl, CURLOPT_NOBODY  , true);

	curl_exec($curl);

	$httpcode =  (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

	curl_close ($curl);
	

    if ($httpcode == 200) {
	    echo "success";
    } else {
	    echo "api returned error code: " . $httpcode;
    }
