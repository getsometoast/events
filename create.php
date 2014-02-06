<?php
	$data = $_POST['data'];

	// connect
	$m = new MongoClient("mongodb://jameslewis:XXXXXXXXX@ds045557.mongolab.com:45557/event-test");

	// select a database
	$db = $m->selectDB("event-test");

	// select a collection (analogous to a relational database's table)
	$collection = $db->event;

	$collection->insert($data);
?>
<h1>Share Your Event!</h1>

<p>Send this link to your friends to let them know about your event: <a href="http://localhost/test/event.php?id=<?=$data['_id']?>">http://www.event-app.com/event.php?id=<?=$data['_id']?></a></p>
