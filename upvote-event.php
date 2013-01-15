<?php
	$id = $_POST['id'];
	$mongoId = new MongoID($id);
	
	// connect
	$m = new MongoClient("mongodb://jameslewis:14Selassia@ds045557.mongolab.com:45557/event-test");
	$db = $m->selectDB("event-test");
	$collection = $db->event;
	
	// get it
	$event = $collection->findOne(array("_id" => $mongoId));
	
	$upvotes = 0;
	if(isset($event['upvotes'])){
		$upvotes = $event['upvotes'];
	}
	$new_upvotes = $upvotes + 1;
	
	$newdata = array('$set' => array("upvotes" => $new_upvotes));
	$collection->update(array("_id" => $mongoId), $newdata);
?>

