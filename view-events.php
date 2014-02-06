<?php
	// get the data from mongo
	$m = new MongoClient("mongodb://jameslewis:XXXXXXXX@ds045557.mongolab.com:45557/event-test");
	$db = $m->selectDB("event-test");
	$collection = $db->event;

	// get events into variable
	$events = $collection->find();
	
	// this is how I need to sort the list on upvotes.  Also see here: http://www.the-art-of-web.com/php/sortarray/#.UO_DnaO5dj4
//	function compare_upvotes($eventOne, $eventTwo) { 
		
//		$eventOneUpvotes = 0;
//		$eventTwoUpvotes = 0;
		
//		if(isset($eventOne['upvotes']))
//			$eventOneUpvotes = $eventOne['upvotes'];
			
//		if(isset($eventTwo['upvotes']))
//			$eventTwoUpvotes = $eventTwo['upvotes'];
	
//		return strnatcmp($eventOneUpvotes, $eventTwoUpvotes); 
//	} 
	
	// sort the list by upvotes
//	usort($events, 'compare_upvotes');
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
            src="view-events.js">
    </script>
		  
    <title>View Events</title>
</head>
<body>
<header>
    <h1>The Events:</h1>
</header>

<div id="event-list">
    <div id="details">
	<?php foreach( $events as $event ) {?>
        <div class="detail">					
			<p>Votes: <?php if(isset($event['upvotes'])) echo $event['upvotes']; ?>
			<p>Name: <?php if(isset($event['name'])) echo $event['name']; ?></h1>
			<p>Description: <?php if(isset($event['description'])) echo $event['description']; ?></p>
			<p>Date: <?php if(isset($event['date'])) echo $event['date']; ?></p>
			<P>Link: <a href="event.php?id=<?=$event['_id']?>">http://www.event-app.com/event.php?id=<?=$event['_id']?></a></p>
        </div>
	<?php }?>
    </div>
</div>
</body>
</html>
