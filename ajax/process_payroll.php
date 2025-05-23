<?php
include("../includes/db.php");

$month = $_POST['month']; // format: 2025-05
$start = $month . "-01";
$end = date("Y-m-t", strtotime($start));

$staffs = $conn->query("SELECT id, salary FROM users WHERE role != 'admin'");

while ($staff = $staffs->fetch_assoc()) {
  $id = $staff['id'];
  $salary_per_day = $staff['salary'];

  $result = $conn->query("
    SELECT 
      SUM(status = 'Present') as present, 
      SUM(status = 'Absent') as absent, 
      SUM(status = 'Leave') as leave_count 
    FROM tbl_attendance 
    WHERE staff_id = $id AND date BETWEEN '$start' AND '$end'
  ");

  $att = $result->fetch_assoc();
  $total_salary = $att['present'] * $salary_per_day;

  // Upsert payroll
  $conn->query("DELETE FROM tbl_payroll WHERE staff_id = $id AND month = '$month'");
  $conn->query("
    INSERT INTO tbl_payroll (staff_id, month, days_present, absents, leaves, salary_per_day, total_salary)
    VALUES ($id, '$month', {$att['present']}, {$att['absent']}, {$att['leave_count']}, $salary_per_day, $total_salary)
  ");
}

echo "✅ Payroll Generated.";
