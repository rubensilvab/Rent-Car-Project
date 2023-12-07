<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$dbh = new PDO('sqlite:./db/rental_db2.sqlite');

$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function loginSuccessOperator($email, $password)
{

  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM Operator WHERE email = ? AND password = ?');
  $stmt->execute(array($email, $password));
  return $stmt->fetch();
}

function loginSuccessCostumer($email, $password)
{

  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM Customer WHERE email = ? AND password = ?');
  $stmt->execute(array($email, $password));
  return $stmt->fetch();
}

if (loginSuccessOperator($email, $password)) {
  $_SESSION["email"] = $email;
  $_SESSION["role"] = "admin";
  header("Location: operator.php");
} else if (loginSuccessCostumer($email, $password)) {
  $_SESSION["email"] = $email;
  $_SESSION["role"] = "customer";
  header("Location: start_page.php");
} else {
  $_SESSION["msg"] = "Login failed!";
  header("Location: login.php");
}
