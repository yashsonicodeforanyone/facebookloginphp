
<?php

require_once 'vendor/autoload.php';

if (!session_id())
{
    session_start();
}

// Call Facebook API

$facebook = new \Facebook\Facebook([
  'app_id'      => 'enter api id',
  'app_secret'     => 'enter secret key',
  'default_graph_version'  => 'v2.10'
]);

$conn=mysqli_connect('localhost','root','','task2');


?>

