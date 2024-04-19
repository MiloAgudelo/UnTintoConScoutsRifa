<?php
require_once('assets/connection.php');

$name = $_POST['name'];
$phone = $_POST['phone'];
$username = $_POST['username'];
$region = $_POST['region'];
$city = $_POST['city'];
$address = $_POST['address'];
$email = $_POST['email'];
$cupNumber = $_POST['cupNumber'];

$nombreImagen = $cupNumber . "." . pathinfo($_FILES["comprobante"]["name"], PATHINFO_EXTENSION);
$rutaDestino = "uploads/" . $nombreImagen;
move_uploaded_file($_FILES["comprobante"]["tmp_name"], $rutaDestino);

// Consulta preparada
$sql = "INSERT INTO contact (`cup-number`, `name`, `phone`, `username`, `region`, `city`, `address`, `email`, `img_path`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $cupNumber, $name, $phone, $username, $region, $city, $address, $email, $rutaDestino);

if ($stmt->execute()) {
  header("Location: confirmation.php?cupNumber=$cupNumber");
  exit();
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
