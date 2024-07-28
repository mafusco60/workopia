<?php
use Framework\Database;

$config = require basepath('config/db.php');
$db = new Database($config);

$id = $_GET['id'] ?? '';

$params = [
  'id' => $id
];

$listing = $db->query ('SELECT * FROM listings WHERE id = :id', $params)->fetch();


loadview('/listings/show', ['listing' => $listing]);