<?php
session_start();

$dbh = new PDO('sqlite:./db/rental_db2.sqlite');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$age = $_POST['age'];
$address = $_POST['address'];
$tax_number = $_POST['tax_number'];
$contact = $_POST['contact'];
$card_number = $_POST['card_number'];
$license_number = $_POST['license_number'];
$type = $_POST['type'];
$expiring_date = $_POST['expiring_date'];


function insertUser(
  $email,
  $password,
  $name,
  $age,
  $address,
  $tax_number,
  $contact,
  $license_number,
  $type,
  $expiring_date
) {
  global $dbh;
  $stmt = $dbh->prepare('INSERT INTO Customer (name, email, contact, tax_number, address, age, password) VALUES(?, ?, ?, ?, ?, ?, ?)');
  $stmt->execute(array($name,  $email, $contact, $tax_number, $address, $age, $password));

  $stmt3 = $dbh->prepare('SELECT * FROM Customer');
  $stmt3->execute();
  $customer = $stmt3->fetchAll();
  $id_max = 0;

  foreach ($customer as $cust) {
    $id   = $cust['id_customer'];
    if ($id > $id_max) {
      $id_max = $id;
    }
  }

  $stmt2 = $dbh->prepare('INSERT INTO DrivingLicense ( license_number, type, expiring_date, id_customer) VALUES(?, ?, ?, ?)');
  $stmt2->execute(array($license_number, $type, $expiring_date, $id_max));
}
if (strlen($email) < 1) {
  $_SESSION["msg"] = "Invalid username!";
  header("Location: register.php");
  die();
}

if (strlen($password) < 4) {
  $_SESSION["msg"] = "Password must have at least 4 characters.";
  header("Location: register.php");
  die();
}

if (strlen($name) < 2) {
  $_SESSION["msg"] = "Invalid name.";
  header("Location: register.php");
  die();
}
if (strlen($contact) != 9) {
  $_SESSION["msg"] = "Phone number must have 9 digits.";
  header("Location: register.php");
  die();
}

if (strlen($tax_number) != 9) {
  $_SESSION["msg"] = "Tax number must have 9 digits.";
  header("Location: register.php");
  die();
}

if (strlen($license_number) < 9) {
  $_SESSION["msg"] = "Tax number must have 9 digits.";
  header("Location: register.php");
  die();
}
if (strlen($age) < 18) {
  $_SESSION["msg"] = "You must be 18 or older to have an account";
  header("Location: register.php");
  die();
}
try {
  insertUser(
  $email,
  $password,
  $name,
  $age,
  $address,
  $tax_number,
  $contact,
  $license_number,
  $type,
  $expiring_date
  );
  $_SESSION["msg"] = "Registration successful!";
  header('Location: login.php');
} catch (PDOException $e) {
  $err_msg = $e->getMessage();
  if (strpos($err_msg, "UNIQUE")) {
    $_SESSION["msg"] = "Username already exists!";
    header("Location: register.php");
  } else {
    $_SESSION["msg"] = "Registration failed! ($err_msg)";
    header("Location: register.php");
  }
}
