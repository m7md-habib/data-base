<?php
$conn = new mysqli("localhost", "root", "", "mydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $conn->query("INSERT INTO users (name, age) VALUES ('$name', $age)");
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>User Submission Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f6fc;
      padding: 30px;
      color: #333;
    }

    form input[type="text"],
    form input[type="number"],
    form input[type="submit"] {
      padding: 8px 12px;
      margin: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    form input[type="submit"] {
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }

    form input[type="submit"]:hover {
      background-color: #0056b3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 6px;
      overflow: hidden;
      margin-top: 20px;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
      text-align: center;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    button {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

<h2>📝 Submit Your Information</h2>
<form method="post">
  <input type="text" name="name" placeholder="Enter name" required>
  <input type="number" name="age" placeholder="Enter age" required>
  <input type="submit" value="Submit">
</form>

<hr>

<h2>📋 Submitted Records</h2>
<table>
  <tr>
    <th>ID</th><th>Name</th><th>Age</th><th>Status</th><th>Toggle</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr id="row-<?= $row['id'] ?>">
      <td><?= $row['id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['age'] ?></td>
      <td class="status"><?= $row['status'] ?></td>
      <td><button onclick="toggleStatus(<?= $row['id'] ?>)">Toggle</button></td>
    </tr>
  <?php endwhile; ?>
</table>

<script>
function toggleStatus(id) {
  fetch('toggle.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'id=' + id
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      document.querySelector('#row-' + id + ' .status').textContent = data.new_status;
    }
  });
}
</script>

</body>
</html>
