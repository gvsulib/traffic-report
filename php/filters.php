<?php

//build a feedback string so we can show what filters are applied on the results page
$feedback = "";

if (isset($_GET['days'])){
	if (isset($_GET['days']['include'])){
		for ($i = 0; $i < count($_GET['days']['include']['begin']); $i++){
			if (!($_GET['days']['include']['begin'][$i] == "" || $_GET['days']['include']['begin'][$i] == "")){
				
				$q .= ("
					AND e.time BETWEEN TIMESTAMP('" . $_GET['days']['include']['begin'][$i] . "') AND TIMESTAMP('" . $_GET['days']['include']['end'][$i] . "')");
				$feedback .= "Data between dates:" . $_GET['days']['include']['begin'][$i] . " and " . $_GET['days']['include']['end'][$i] . " included<br>";
			}
		}
	}
	if (isset($_GET['days']['exclude'])){
		for ($i = 0; $i < count($_GET['days']['exclude']['begin']); $i++){
			if (!($_GET['days']['exclude']['begin'][$i] == "" || $_GET['days']['exclude']['begin'][$i] == "")){
			$q .= ("
				AND e.time NOT BETWEEN TIMESTAMP('" . $_GET['days']['exclude']['begin'][$i] . "') AND TIMESTAMP('" . $_GET['days']['exclude']['end'][$i] . "')");
				$feedback .= "Data between dates:" . $_GET['days']['exclude']['begin'][$i] . " and " . $_GET['days']['exclude']['end'][$i] . " excluded<br>";
						
			}
		}
	}
}
if (isset($_GET['hours'])){
	if (isset($_GET['hours']['include'])){
		for ($i = 0; $i < count($_GET['hours']['include']['begin']); $i++){
			if (!($_GET['hours']['include']['begin'][$i] == "" || $_GET['hours']['include']['begin'][$i] == "")){
				$q .= ("
					AND HOUR(e.time) BETWEEN " . $_GET['hours']['include']['begin'][$i] . " AND " . $_GET['hours']['include']['end'][$i]);
					$feedback .= "Data between times:" . $_GET['hours']['include']['begin'][$i] . " and " . $_GET['hours']['include']['end'][$i] . " included<br>";
									
			}
		}
	}
	if (isset($_GET['hours']['exclude'])){
		for ($i = 0; $i < count($_GET['hours']['exclude']['begin']); $i++){
			if (!($_GET['hours']['exclude']['begin'][$i] == "" || $_GET['hours']['exclude']['begin'][$i] == "")){
			$q .= ("
				AND HOUR(e.time) NOT BETWEEN " . $_GET['hours']['exclude']['begin'][$i] . " AND " . $_GET['hours']['exclude']['end'][$i]);
				$feedback .= "Data between times:" . $_GET['hours']['exclude']['begin'][$i] . " and " . $_GET['hours']['exclude']['end'][$i] . " excluded<br>";
									
			}
		}
	}
}
?>