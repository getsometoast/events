<?php
	// get the id out of the query string
	$id = $_GET['id'];
	$mongoId = new MongoID($id);
	
	// get the data from mongo
	$m = new MongoClient("mongodb://jameslewis:XXXXXXXXx@ds045557.mongolab.com:45557/event-test");
	$db = $m->selectDB("event-test");
	$collection = $db->event;

	// get event into variable
	$event = $collection->findOne(array("_id" => $mongoId));
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <link rel="stylesheet"
          href="style.css"/>	

	<script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJbYvufTBKqM4fXCf0fxu9aAyKjx0N010&sensor=true">
    </script>
    <script type="text/javascript"
            src="event.js">
    </script>
		  
    <title>Event: <?=$event['name']?></title>
</head>
<body>
<header>
    <h1><?=$event['name']?></h1>
    <p><?=$event['description']?></p>
	<?=$event['date']?>

	<p>Votes: <?php if(isset($event['upvotes'])) echo $event['upvotes'] ?></p>
	<!--<img src="<?=$event['image']?>"/>-->
</header>

<div id="add-event">
    <p>Map of details</p>
    <div id="map_canvas" style="width:600px; height:600px"></div>

    <div id="details">
	<?php foreach( $event['places'] as $place ) {?>
        <div class="detail">
			<input type="hidden" name="lat" value="<?=$place['lat']?>">
			<input type="hidden" name="lng" value="<?=$place['long']?>">
            <p>Name: <strong><?=$place['name']?></strong></p>
            <p>Time: <strong><?=$place['time']?></strong></p>
            <p>Description: <strong><?=$place['description']?></strong></p>
        </div>
	<?php }?>
    </div>

	<div id="upvote">
		<input type="hidden" id="mongo-id" value="<?=$event['_id']?>"/>
		<button>upvote</button>
	</div>
    <!--<p>If you're attending you should say so by clicking here: <button type="submit">Attend</button></p>-->
</div>
</body>
</html>
