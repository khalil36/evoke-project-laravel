

<?php


function pc_array_power_set($array) { 
	$results = array(array()); 
    foreach ($array as $element) 
    	foreach ($results as $combination) array_push($results, array_merge(array($element), $combination)); 
    
    return $results; 
} 
$set = array('google', 'bing', 'yahooo', 'khalil'); 
$power_set = pc_array_power_set($set); 
foreach($power_set as $set){
	if(count($set) > 2 or count($set) < 2) continue;
    $temp_arr[] = $set;
}
echo "<br>";
echo "<pre>"; print_r($temp_arr);
