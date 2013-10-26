<?php

// Include Mailjet's API Class
include_once('Mailjet.php');

// Create a new Object
$mj = new Mailjet();

$params = array(
    'method' => 'POST',
    'contact' => $_POST['ug-email'],
    'id' => $_POST['id']
);

# Call
$response = $mj->listsAddContact($params);

# Result
echo $response->contact_id;

?>
