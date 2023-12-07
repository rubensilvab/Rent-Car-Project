<?php

session_start();

$id_delete_reservation = $_SESSION['id_delete_reservation'];
echo $id_delete_reservation;
$dbh = new PDO('sqlite:./db/rental_db2.sqlite');

$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function deleteReservation($id_delete_reservation)
{
  global $dbh;
  $stmt = $dbh->prepare('DELETE FROM Reservation, Payment WHERE id_reservation =?');
  $stmt->execute(array($id_delete_reservation));

}

if (deleteReservation($id_delete_reservation)) {
  $_SESSION["msg"] = "Deleted with success";
  header("Location: operator.php");

} else {
  $_SESSION["msg"] = "Deleted failed!";
  header("Location: operator.php");
}
