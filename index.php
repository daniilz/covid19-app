<?php

# Author: Daniel Zak
# Github: https://github.com/Daniel-Zak

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


curl_setopt($ch, CURLOPT_URL, 'https://covid19.mathdro.id/api');
$tresult = curl_exec($ch);
$tdata = json_decode($tresult, true);

if(isset($_GET['country']) && !empty($_GET['country'])) {

	$country = $_GET['country'];

} else {

	$country = "India";
}

curl_setopt($ch, CURLOPT_URL, 'https://covid19.mathdro.id/api/countries/' . urlencode($country));
$result = curl_exec($ch);
$data = json_decode($result, true);


//print_r($citiesForMap);


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
		$level = ceil($cityData->active/5);
		if($level<10) {
			$fillkey = "MINOR";
		} else if(($level>=10)&& ($level<20)) {
			$fillkey = "MEDIUM";
		} else {
			$fillkey = "MAJOR";
		}
		$cityForMap['centered'] = $statecode;
		$cityForMap['fillKey'] = $fillkey;
		$cityForMap['radius'] = ceil($cityData->confirmed/20000);
		$cityForMap['active'] = $cityData->active;
		$cityForMap['state'] = $state;
		$cityForMap['city'] = $key;
		
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
	
	//print_r($bubbles);
	//echo $bubbles;
}
//print_r($citiesForMap);
$bubbles = json_encode($citiesForMap);

//print_r($bubbles);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Covid 19 - Cases in the World by Country</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<!--<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>-->

<style>

body {
background: rgb(244, 246, 248);
    color: rgb(33, 43, 54);
    margin: 0px;
    padding: 0px;
    font-family: Roboto, sans-serif;
}
.container {
    max-width: 1040px;
    margin: 0px auto 8rem;
    min-height: 100vh;
}

h1 {
	padding: 2rem 0px;
}

section.cards-container {
    text-align: center;
    box-sizing: border-box;
	position: relative;
    display: block;
}

.card-container {
    display: inline-flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.card {
    margin: 10px 0px;
    min-height: 150px;
    min-width: 200px;
    border-radius: 10px;
    padding:20px;
    background-color: rgb(255, 255, 255);
}

h3.card-title {
    margin-bottom: 10px;
    font-size: 2em;
}

h3.active {
	color: rgb(247, 116, 39);
}
h3.recovered {
	color: rgb(5, 181, 132);
}
h3.deceased {
	color: rgb(236, 49, 75);
}
h3.total {
	color: blue;
}
</style>

</head>
<body>


	<div class="container">


		<h1 class="">Covid 19 - Cases in the World and by Country</h1>

<?php
//print_r($data);
?>
		<?php if(!empty($tdata['confirmed'])): ?>
			<h2>Case breakdown in the World</h2>
			<section class="cards-container">
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="active card-title">Active</h3>
					    <p class="card-text"><?php echo number_format($tdata['confirmed']['value']-$tdata['deaths']['value']-$tdata['recovered']['value'])?></p>
					  </div>
					</div>
				</div>
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="recovered card-title">Recovered</h3>
					    <p class="card-text"><?php echo number_format($tdata['recovered']['value']) ?></p>
					  </div>
					</div>
				</div>
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="deceased card-title">Deceased</h3>
					    <p class="card-text"><?php echo number_format($tdata['deaths']['value']) ?></p>
					  </div>
					</div>
				</div>
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="total card-title">Total</h3>
					    <p class="card-text"><?php echo number_format($tdata['confirmed']['value']) ?></p>
					  </div>
					</div>
				</div>				
			</section>
			<hr>
		<?php endif; ?>

		<form class="form-group" method="get">
			<input class="form-control" type="text" id="country" name="country" placeholder="Check Statistics By Country">
			<button class="btn btn-primary float-right mt-3" type="submit">Submit</button>
		</form>

		<?php if(!empty($data['confirmed'])): ?>
			<h2>Case breakdown for <?php echo htmlspecialchars($country, ENT_QUOTES); ?></h2>
			<section class="cards-container">
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="active card-title">Active</h3>
					    <p class="card-text"><?php echo number_format($data['confirmed']['value']-$data['deaths']['value']-$data['recovered']['value'])?></p>
					  </div>
					</div>
				</div>
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="recovered card-title">Recovered</h3>
					    <p class="card-text"><?php echo number_format($data['recovered']['value']) ?></p>
					  </div>
					</div>
				</div>
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="deceased card-title">Deceased</h3>
					    <p class="card-text"><?php echo number_format($data['deaths']['value']) ?></p>
					  </div>
					</div>
				</div>
				<div class="card-container">
					<div class="card" style="">
					  <div class="card-body">
					    <h3 class="total card-title">Total</h3>
					    <p class="card-text"><?php echo number_format($data['confirmed']['value']) ?></p>
					  </div>
					</div>
				</div>				
			</section>
			<hr>
		<?php endif; ?>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://d3js.org/topojson.v1.min.js"></script>
    <script src="https://rawgit.com/Anujarya300/bubble_maps/master/data/geography-data/datamaps.none.js"></script>

		<div id="india" style="height: 600px; width: 100%;border:1px solid #ddd;"></div>
    <script>
        var bubble_map = new Datamap({
            element: document.getElementById('india'),
            scope: 'india',
            geographyConfig: {
                popupOnHover: true,
                highlightOnHover: true,
                borderColor: '#444',
                borderWidth: 0.5,
                dataUrl: 'https://rawgit.com/Anujarya300/bubble_maps/master/data/geography-data/india.topo.json'
                //dataJson: topoJsonData
            },
            fills: {
                'MAJOR': 'red',
                'MEDIUM': 'rgb(247, 116, 39)',
                'MINOR': 'rgb(5, 181, 132)',
                defaultFill: '#dddddd'
            },
            data: {
                /*'JH': { fillKey: 'MINOR' },
                'MH': { fillKey: 'MINOR' }*/
            },
            setProjection: function (element) {
                var projection = d3.geo.mercator()
                    .center([78.9629, 23.5937]) // always in [East Latitude, North Longitude]
                    .scale(1000);
                var path = d3.geo.path().projection(projection);
                return { path: path, projection: projection };
            }
        });

        /*let bubbles = [
            {
                centered: "MH",
                fillKey: "MAJOR",
                radius: 20,
                active: 2002,
                state: "Maharastra"
            },
            {
                centered: "AP",
                fillKey: "MAJOR",
                radius: 22,
                active: 122,
                state: "Andhra Pradesh"
            },
            {
                centered: "TN",
                fillKey: "MAJOR",
                radius: 16,
                active: 345,
                state: "Tamil Nadu"
            },
            {
                centered: "UN",
                fillKey: "MAJOR",
                radius: 16,
                active: 345,
                state: "North and Middle Andaman"
            }            

        ]*/ 
        var data = '<?php echo $bubbles; ?>';     

        let bubbles = JSON.parse(data); 

        // // ISO ID code for city or <state></state>
        setTimeout(() => { // only start drawing bubbles on the map when map has rendered completely.
            bubble_map.bubbles(bubbles, {
                popupTemplate: function (geo, data) {
                     return ['<div class="hoverinfo" style="margin-top:600px;"><strong>' +  data.city + '</strong>',
		            '<br/>State: ' +  data.state,
		            '<br/>Notes: ' +  data.notes + '',
		            '<br/>Active: ' +  data.active + '',
		            '<br/>Confirmed: ' +  data.confirmed + '',
		            '<br/>Deceased: ' +  data.deceased + '',
		            '<br/>Recovered: ' +  data.recovered + '',	
		            '<br/>Delta Confirmed: ' +  data.delta_confirmed + '',
		            '<br/>Delta Deceased: ' +  data.delta_deceased + '',
		            '<br/>Delta Recovered: ' +  data.delta_recovered + '',			            	            		            
		            '</div>'].join('');
		            }
            });
        }, 1000);
    </script>


</body>
   
</html>