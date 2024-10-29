<?php
require_once __DIR__ . '/DatabaseModel.php';

$db = new DatabaseModel();
$year = filter_input(INPUT_GET, 'year', FILTER_SANITIZE_NUMBER_INT);  // A kérésből az év kinyerése

$weeks = $db->select("huzas", "DISTINCT het", "ev = :year", "", [":year" => $year]);

header('Content-Type: application/json');
echo json_encode($weeks);
?>