<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "companyDB";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Connection Failed");
}

echo "Connected Successfully to MySQL<br>";

// ========================= INSERTING DATA =========================
// $name  = "Jamil";
// $email = "jamil123@gmail.com";
// $age   = 20;

// $sql = "INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)";
// mysqli_query($connection, $sql);

// ========================= SELECTING DATA =========================
// $result = mysqli_query($connection, "SELECT * FROM users");

// while ($row = mysqli_fetch_assoc($result)) {
//     echo "Name: " . $row['name'] . "<br>";
//     echo "Email: " . $row['email'] . "<br>";
//     echo "Age: " . $row['age'] . "<hr>";
// }

// ========================= UPDATING DATA =========================
// $sql = "UPDATE users SET age = 22 WHERE name = 'Jamil'";
// mysqli_query($connection, $sql);

// ========================= DELETING DATA =========================
$sql = "DELETE FROM users WHERE name = 'Jamil'";
mysqli_query($connection, $sql);

// ========================= CLOSING CONNECTION =========================
mysqli_close($connection);
?>
