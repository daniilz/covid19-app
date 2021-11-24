<?php

$url = "https://data.covid19india.org/state_district_wise.json";

$json = file_get_contents($url);
$statesData = json_decode($json);

//print_r($statesData);
$statesForMap = array();
foreach($statesData as $key=>$stateData){
	//echo $key."   ";
	//print_r($stateData);
	$state = $key;
	$districtData = $stateData->districtData;
	//echo $stateData->statecode;
	$statecode = $stateData->statecode;
	//print_r($districtData);
	foreach($districtData as $key=>$cityData){
		$cityForMap['centered'] = $statecode;
		$cityForMap['fillkey'] = "MAJOR";
		$cityForMap['radius'] = $cityData->confirmed;
		$cityForMap['state'] = $state;
		$cityForMap['city'] = $key;
		$cityForMap['active'] = $cityData->active;
		$cityForMap['notes'] = $cityData->notes;
		$cityForMap['confirmed'] = $cityData->confirmed;
		$cityForMap['deceased'] = $cityData->deceased;
		$cityForMap['recovered'] = $cityData->recovered;
		$cityForMap['delta_confirmed'] = $cityData->delta->confirmed;
		$cityForMap['delta_deceased'] = $cityData->delta->deceased;
		$cityForMap['delta_recovered'] = $cityData->delta->recovered;


		$citiesForMap[] = $cityForMap;
		//print_r($cityData);
	}
	//print_r($districtData);
	$bubbles = json_encode($citiesForMap);
	//print_r($bubbles);
	echo $bubbles;
}

?>