<?php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION["email"])) {
  $_SESSION["msg"] = "Please login.";
  header("Location: login.php");
}

if ($_SESSION["role"] == "admin") {
  header("Location: operator.php");
}


$_SESSION["msg"] = "";
$msg = $_SESSION["msg"];

$email =  $_SESSION["email"];


$dbh = new PDO('sqlite:./db/rental_db2.sqlite');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbh->prepare('SELECT * FROM Reservation');
$stmt->execute();
$reservation = $stmt->fetchAll();



$stmt = $dbh->prepare('SELECT * FROM Customer WHERE email=?');
$stmt->execute(array($email));
$customer_array = $stmt->fetch();
$id_customer = reset($customer_array);


$stmt = $dbh->prepare('SELECT name FROM Customer WHERE email=?');
$stmt->execute(array($email));
$customer_array = $stmt->fetch();
$name = reset($customer_array);


$stmt = $dbh->prepare('SELECT * FROM Payment WHERE id_customer=?');
$stmt->execute(array($id_customer));
$payment = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Insurance');
$stmt->execute();
$insu = $stmt->fetchAll();

function getLocation($reservation_id) {

  global $dbh;

  $stmt = $dbh->prepare('SELECT id_parking FROM Reservation WHERE id_reservation=?');
  $stmt->execute(array($reservation_id));
  $parkingId_ = $stmt->fetch();
  $parkingId = reset($parkingId_);
  

  $stmt = $dbh->prepare('SELECT locations FROM ParkingArea WHERE id_parking=?');
  $stmt->execute(array($parkingId));
  $parkingName_ = $stmt->fetch();
  $parkingName = reset($parkingName_);

  return $parkingName;
}



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php include_once "head.php" ?>

<body>


  <?php include_once "nav.php" ?>


  <!-- Page content -->


  <div class="content">

    <div>
    <h2>  <?php   echo  $name ?>, this are your reservations</h2> 

    </div>
    <div class="reservations_table">
      <?php

      echo "<table>
       <tr>
       <th> Resrvation Number </th>
       <th> Card Number </th>
       <th> Location </th>
       <th> Payment Date </th>
       <th> Payment Time </th>
       <th> Amount </th> </tr>";

      foreach ($payment as $pay) {
        $reservation_id = $pay['id_reservation'];
        $card = $pay['card_number'];
        $date = $pay['payment_date'];
        $time = $pay['payment_time'];
        $amount = $pay['amount'];
        $location = getLocation($reservation_id) ;
        echo "<tr><td>" . $reservation_id . "</td><td>" . $card . "</td><td>" . $location . "</td><td>" . $date . "</td><td>" . $time . "</td><td>" . $amount . "</td></tr>";
      }
      echo "</table>";         ?>



    </div>

    <!-- End page content -->
  </div>



  <?php include_once('footer.php'); ?>


</body>

</html>