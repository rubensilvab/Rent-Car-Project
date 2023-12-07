<?php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION["email"])) {
  $_SESSION["msg"] = "Please login.";
  header("Location: login.php");
}

if ($_SESSION["role"] != "admin") {
  header("Location: start_page.php");
}

$dbh = new PDO('sqlite:./db/rental_db2.sqlite');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbh->prepare('SELECT * FROM Reservation');
$stmt->execute();
$reservation = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Payment');
$stmt->execute();
$pay = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Insurance');
$stmt->execute();
$insu = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Car');
$stmt->execute();
$cars = $stmt->fetchAll();

function getInsuranceName($id_insurance)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT Package_name FROM Insurance WHERE id_insurance=?');
  $stmt->execute(array($id_insurance));
  $ins_ = $stmt->fetch();
  $ins = reset($ins_);
  return $ins;
}

function getCustomerName($id_reservation)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT id_customer FROM Payment WHERE id_reservation=?');
  $stmt->execute(array($id_reservation));
  $customer_array = $stmt->fetch();
  $id_customer = reset($customer_array);

  $stmt = $dbh->prepare('SELECT name FROM Customer WHERE id_customer=?');
  $stmt->execute(array($id_customer));
  $name_ = $stmt->fetch();
  $name = reset($name_);
  return $name;
}

function getAmount($id_reservation)
{

  global $dbh;
  $stmt = $dbh->prepare('SELECT amount FROM Payment WHERE id_reservation=?');
  $stmt->execute(array($id_reservation));
  $amon = $stmt->fetch();
  $amount = reset($amon);
  return $amount;
}

function getParkingLocation($id_parking)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT locations FROM ParkingArea WHERE id_parking=?');
  $stmt->execute(array($id_parking));
  $location_ = $stmt->fetch();
  $location = reset($location_);
  return $location;
}

function getCategory($id_category) {
  global $dbh;
  $stmt = $dbh->prepare('SELECT category_name FROM CarCategory WHERE id_category=?');
  $stmt->execute(array($id_category));
  $carName_ = $stmt->fetch();
  $carName = reset($carName_);
  return $carName;

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
    <h2 style="padding-top: 20px;">Reservations </h2>
    </div>

    <div class="reservations_table">

    <form action="action_deleting.php" method="post">
        <?php
        echo "<table>
           <tr>
           <th> Resrvation Number </th>
           <th> Customer Name </th>
           <th> Departure Date </th>
           <th> Return Date </th>
           <th> Departure Location </th>
           <th> Insurance </th> 
           <th> Amount ($) </th>
            </tr>";

        foreach ($reservation as $reserv) {

          $reservation_id = $reserv['id_reservation'];
          $_SESSION["id_delete_reservation"] = $reservation_id;
          $customer_name = getCustomerName($reserv['id_reservation']);
          $departure_date = $reserv['departure_date'];
          $drop_date = $reserv['return_date'];
          $id_parking = getParkingLocation($reserv['id_parking']);
          $rervation_insurance = getInsuranceName($reserv['id_insurance']);
          $amount = getAmount($reserv['id_reservation']);
          echo "<tr><td>" . $reservation_id . "</td><td>" . $customer_name  .  "</td><td>" . $departure_date . "</td><td>" .
            $drop_date . "</td><td>" . $id_parking . "</td><td>" . $rervation_insurance . "</td><td>" . $amount . "<td> <button type=submit class=delete >Delete</button> </td>" . "</td></tr>";
        }

        echo "</table>"; ?>

      </form>
      

    </div>

    <div>
      <h2 style="padding-top: 20px;"> Cars </h2>
    </div>

    <div class="reservations_table">
    <form action="action_deleting.php" method="post">
        <?php
        echo "<table>
           <tr>
           <th> Car Id </th>
           <th> Brand </th>
           <th> Location </th>
           <th> Kilometers </th>
           <th> Number of passengers </th>           
           <th> Category </th>
           <th> On use </th> 
            </tr>";

        foreach ($cars as $car) {

          $car_id = $car['id_car'];
          $location = $car['locations'];
          $km = $car['kilometers'];
          $brand = $car['brand'];
          $seat = $car['number_passengers'];
          $availability = $car['availability'];
          if ($availability == 1){
            $availability = "ON";
          }
          else{
            $availability = "OFF";
          }

          $category = getCategory($car['id_category']);
          echo "<tr><td>" . $car_id . "</td><td>" . $brand  .  "</td><td>" . $location . "</td><td>" .
            $km . "</td><td>" .$seat. "</td><td>" . $category . "</td><td>" . $availability . "<td> <button type=submit class=delete >Delete</button> </td>" . "</td></tr>";
        }

        echo "</table>"; ?>

      </form>
      
    </div>



    <!-- End page content -->
  </div>


  <?php include_once('footer.php'); ?>


</body>

</html>