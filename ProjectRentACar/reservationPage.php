<?php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION["email"])) {
  $_SESSION["msg"] = "Please login.";
  header("Location: login.php");
}

if ($_SESSION["role"] != "customer") {
  header("Location: operator.php");
}

$dbh = new PDO('sqlite:./db/rental_db2.sqlite');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_POST['search_button'])) {

  $_SESSION["pick_location"] = $_POST["pick_location"];
}

$localy = $_SESSION["pick_location"];

$stmt = $dbh->prepare('SELECT * FROM ParkingArea');
$stmt->execute();
$parking_area = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Car');
$stmt->execute();
$cars = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Car WHERE id_category=3 AND locations=?');   // Falta if availability=1
$stmt->execute(array($localy));
$brands = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Car WHERE id_category=1 AND locations=?');
$stmt->execute(array($localy));
$luxo = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Car WHERE id_category=4 AND locations=?');
$stmt->execute(array($localy));
$comerciais = $stmt->fetchAll();

function getBrands($id_category, $localy)
{

  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM Car WHERE id_category=? AND locations=?');
  $stmt->execute(array($id_category, $localy));
  $brands = $stmt->fetchAll();
  return $brands;
}


$stmt = $dbh->prepare('SELECT * FROM Car WHERE id_category=2 AND locations=?');
$stmt->execute(array($localy));
$familiar = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM Car WHERE id_category=4 AND locations="Braga"');
$stmt->execute();
$fami = $stmt->fetchAll();


function getCarCategoryName($id_category)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT  category_name FROM CarCategory WHERE id_category=?');
  $stmt->execute(array($id_category));
  $category_ = $stmt->fetch();
  $category = reset($category_);
  return $category;
}

function getCarsFromLocation($location, $id_category)
{
  global $dbh;
  $stmt = $dbh->prepare('SELECT  category_name FROM CarCategory WHERE id_category=? AND locations=?');
  $stmt->execute(array($id_category, $location));
  $cars = $stmt->fetchAll();

  return $cars;
}


?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "head.php" ?>


<body>


  <?php include_once "nav.php" ?>

  <!-- Reservations Section -->

  <!-- Page content -->
  <div class="content">

  </div class="cars">

  <form action="reservationPage.php" method="post">

    <div id="reservation">

      <div class="column_reservation">
        <h4>Pick up Location</h4>
        <select name="pick_location">
          <?php foreach ($parking_area as $locations) { ?>
            <option value="<?php echo $locations['locations']; ?>"><?php echo $locations['locations'] ?> </option>
          <?php } ?>

        </select>


      </div>

      <div class="column_reservation">
        <h4>Drop Location</h4>
        <select name="drop_location">
          <?php foreach ($parking_area as $locations) { ?>

            <option value="<?php echo $locations['locations']; ?>"><?php echo $locations['locations'] ?> </option>
          <?php } ?>

        </select>
      </div>

      <div class="column_reservation">
        <h4>Pick-up date</h4>
        <input type="date" id="pick-up-date" name="pick-up-date" value="2022-05-17" min="2022-05-07" max="2025-06-14">
      </div>

      <div class="column_reservation">
        <h4>Time</h4>
        <input type="time" id="pick_time" name="pick_time" min="09:00" max="18:00">
      </div>

      <div class="column_reservation">
        <h4>Drop-off date</h4>
        <input type="date" id="drop-off-date" name="drop-off-date" value="2022-05-17" min="2022-05-07" max="2025-06-14">
      </div>

      <div class="column_reservation">
        <h4>Time</h4>
        <input type="time" id="drop_time" name="drop_time" min="09:00" max="18:00">
      </div>

      <div class="column_reservation" id="search_button">
        <button name="search_button" type="submit" class="registerbtn" value="Search">Search</button>

      </div>
    </div>

  </form>


  <div id="car">
    <h2 class="reservation_location" style="align-items: center;"> This are the cars available at  <?php echo  $localy ?></h2>

    <div id="car_infos">

      <form action="" method="post">
        <div>
          <h4 class="car_class">ECONOMIC </h4>
          <select name="choosen_car">
            <?php
            $brands = getBrands(3, $localy);
            foreach ($brands as $brand) { ?>
              <option value="<?php echo $brand['id_car']; ?>"><?php echo $brand['brand'] ?> </option>
            <?php } ?>
          </select>
          <button class="ref" type="submit" name="refresh_button1"><i class="fa-solid fa-arrows-rotate"></i></button>
        </div>
        <img src="imgs/city.png" alt="econimc">
      </form>

    </div>

    <div id="car_infos">

      <?php $id_car = 1;
      if (isset($_POST['refresh_button1'])) {
        $selected = $_POST['choosen_car'];
        $id_car = strval($selected);
      }
      $stmt = $dbh->prepare('SELECT * FROM Car WHERE id_car=?');
      $stmt->execute(array($id_car));
      $fami = $stmt->fetchAll(); ?>

      <form action="Payment.php" method="post">


        <?php foreach ($fami as $row)
          $passengers = $row["number_passengers"];
        $km = $row["kilometers"];
        $custo = $row["cost"];
        $caixa = $row["box"];
        $tipo = getCarCategoryName($row["id_category"]); ?>

        <h4><i class="fa-solid fa-user"></i> <?php echo $passengers ?> Seats </h4>
        <h4><i class="fa-solid fa-gear"></i> <?php echo $caixa ?> </h4>
        <h4><i class="fa-solid fa-car"></i> <?php echo $tipo ?></h4>
        <h4><i class="fa-solid fa-gauge"></i> <?php echo $km ?> Kilometers </h4>
        <h3><i class="fa-solid fa-dollar-sign"></i> <?php echo $custo ?></h3>

        <button type="submit" name="deal_button"> View deal </button>

      </form>

    </div>

  </div>

  <div id="car">

    <div id="car_infos">

      <form action="" method="post">
        <div>
          <h4 class="car_class">SUV</h4>
          <select name="choosen_car">
            <?php
            $brands = getBrands(2, $localy);
            foreach ($brands as $brand) { ?>
              <option value="<?php echo $brand['id_car']; ?>"><?php echo $brand['brand'] ?> </option>
            <?php } ?>
          </select>
          <button class="ref" type="submit" name="refresh_button2"><i class="fa-solid fa-arrows-rotate"></i></button>
         </div>
        <img src="imgs/SUV.png" alt="econimc">
      </form>

    </div>

    <div id="car_infos">

      <?php $id_car = 1;
      if (isset($_POST['refresh_button2'])) {
        $selected = $_POST['choosen_car'];
        $id_car = strval($selected);
      }
      $stmt = $dbh->prepare('SELECT * FROM Car WHERE id_car=?');
      $stmt->execute(array($id_car));
      $fami = $stmt->fetchAll(); ?>

      <form action="Payment.php" method="post">


        <?php foreach ($fami as $row)
          $passengers = $row["number_passengers"];
        $km = $row["kilometers"];
        $custo = $row["cost"];
        $caixa = $row["box"];
        $tipo = getCarCategoryName($row["id_category"]); ?>

        <h4><i class="fa-solid fa-user"></i> <?php echo $passengers ?> Seats </h4>
        <h4><i class="fa-solid fa-gear"></i> <?php echo $caixa ?> </h4>
        <h4><i class="fa-solid fa-car"></i> <?php echo $tipo ?></h4>
        <h4><i class="fa-solid fa-gauge"></i> <?php echo $km ?> Kilometers </h4>
        <h3><i class="fa-solid fa-dollar-sign"></i> <?php echo $custo ?></h3>

        <button type="submit" name="deal_button"> View deal </button>

      </form>

    </div>

  </div>

  <div id="car">

    <div id="car_infos">

      <form action="" method="post">
        <div>
          <h4 class="car_class">COMERCIAL</h4>
          <select name="choosen_car">
            <?php
            $brands = getBrands(4, $localy);
            foreach ($brands as $brand) { ?>
              <option value="<?php echo $brand['id_car']; ?>"><?php echo $brand['brand'] ?> </option>
            <?php } ?>
          </select>
          <button class="ref" type="submit" name="refresh_button3"><i class="fa-solid fa-arrows-rotate"></i></button>
        </div>
        <img src="imgs/eletric.png" alt="econimc">
      </form>

    </div>

    <div id="car_infos">

      <?php $id_car = 1;
      if (isset($_POST['refresh_button3'])) {
        $selected = $_POST['choosen_car'];
        $id_car = strval($selected);
      }
      $stmt = $dbh->prepare('SELECT * FROM Car WHERE id_car=?');
      $stmt->execute(array($id_car));
      $fami = $stmt->fetchAll(); ?>

      <form action="Payment.php" method="post">


        <?php foreach ($fami as $row)
          $passengers = $row["number_passengers"];
        $km = $row["kilometers"];
        $custo = $row["cost"];
        $caixa = $row["box"];
        $tipo = getCarCategoryName($row["id_category"]); ?>

        <h4><i class="fa-solid fa-user"></i> <?php echo $passengers ?> Seats </h4>
        <h4><i class="fa-solid fa-gear"></i> <?php echo $caixa ?> </h4>
        <h4><i class="fa-solid fa-car"></i> <?php echo $tipo ?></h4>
        <h4><i class="fa-solid fa-gauge"></i> <?php echo $km ?> Kilometers </h4>
        <h3><i class="fa-solid fa-dollar-sign"></i> <?php echo $custo ?></h3>

        <button type="submit" name="deal_button"> View deal </button>

      </form>

    </div>

  </div>

  <div id="car">

    <div id="car_infos">

      <form action="" method="post">
        <div>
          <h4 class="car_class">LUXURIOUS</h4>
          <select name="choosen_car">
            <?php
            $brands = getBrands(1, $localy);
            foreach ($brands as $brand) { ?>
              <option value="<?php echo $brand['id_car']; ?>"><?php echo $brand['brand'] ?> </option>
            <?php } ?>
          </select>
          <button class="ref" type="submit" name="refresh_button4"><i class="fa-solid fa-arrows-rotate"></i></button>
        </div>
        <img src="imgs/lux.png" alt="econimc">
      </form>

    </div>

    <div id="car_infos">

      <?php $id_car = 1;
      if (isset($_POST['refresh_button4'])) {
        $selected = $_POST['choosen_car'];
        $id_car = strval($selected);
      }
      $stmt = $dbh->prepare('SELECT * FROM Car WHERE id_car=?');
      $stmt->execute(array($id_car));
      $fami = $stmt->fetchAll(); ?>

      <form action="Payment.php" method="post">


        <?php foreach ($fami as $row)
          $passengers = $row["number_passengers"];
        $km = $row["kilometers"];
        $custo = $row["cost"];
        $caixa = $row["box"];
        $tipo = getCarCategoryName($row["id_category"]); ?>

        <h4><i class="fa-solid fa-user"></i> <?php echo $passengers ?> Seats </h4>
        <h4><i class="fa-solid fa-gear"></i> <?php echo $caixa ?> </h4>
        <h4><i class="fa-solid fa-car"></i> <?php echo $tipo ?></h4>
        <h4><i class="fa-solid fa-gauge"></i> <?php echo $km ?> Kilometers </h4>
        <h3><i class="fa-solid fa-dollar-sign"></i> <?php echo $custo ?></h3>

        <button type="submit" name="deal_button"> View deal </button>

      </form>

    </div>

  </div>


  </div>

  </div>


  <?php include_once "footer.php" ?>




</body>

</html>