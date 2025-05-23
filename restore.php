<?php
// restore.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['sql_file'])) {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'hotel_db';

    $sqlFile = $_FILES['sql_file']['tmp_name'];

    $conn = new mysqli($host, $user, $pass, $dbname);
    $sql = file_get_contents($sqlFile);

    if ($conn->multi_query($sql)) {
        echo "✅ Database restored successfully.";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Restore Database</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2>🛠 Restore Hotel DB</h2>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Choose SQL File:</label>
      <input type="file" name="sql_file" class="form-control" accept=".sql" required>
    </div>
    <button class="btn btn-success">Restore</button>
  </form>
</body>
</html>
