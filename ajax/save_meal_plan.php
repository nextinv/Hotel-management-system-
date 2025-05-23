<?php
include("../includes/db.php");

$guest_id = $_POST['guest_id'];
$date = $_POST['date'];
$breakfast = isset($_POST['breakfast']) ? 1 : 0;
$lunch = isset($_POST['lunch']) ? 1 : 0;
$dinner = isset($_POST['dinner']) ? 1 : 0;

$conn->query("INSERT INTO tbl_meal_plans (guest_id, date, breakfast, lunch, dinner)
  VALUES ($guest_id, '$date', $breakfast, $lunch, $dinner)");

header("Location: ../add_meal_plan.php");
