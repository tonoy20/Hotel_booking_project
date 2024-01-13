
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $minValue = $_POST['min'];
    $maxValue = $_POST['max'];

    // Process the values as needed

    $specificValue = $maxValue;

    $_SESSION['minValue'] = $minValue;
    $_SESSION['specificValue'] = $specificValue;
    echo json_encode(['specificValue' => $specificValue]);
} else {
    echo "Invalid request method";
}
?>




