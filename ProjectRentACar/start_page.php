<?php

if (!isset($_SESSION)) {
  session_start();
}


$dbh = new PDO('sqlite:./db/rental_db2.sqlite');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$stmt = $dbh->prepare('SELECT * FROM ParkingArea');

$stmt->execute();
$parking_area = $stmt->fetchAll();


?>


<!DOCTYPE html>
<html lang="en">
<?php include_once "head.php" ?>


<body>


  <?php include_once "nav.php" ?>

  <div class="img_home" id="home"></div>
  <div class="center_home">
    <div class="title">Drive through memories</div>
    <div class="sub_title">Available everywhere</div>

    <div class="center_btn">
      <button><a href="reservationPage.php">Rent a Car</a></button>
    </div>
  </div>

  <!-- Page content -->
  <div>


    <!-- Reservations Section -->
    <div class="row">

      <div class="column">
        <img src="imgs/suv.png" alt="suv" style="width:100%">
      </div>

      <div class="column">
        <img src="imgs/city.png" alt="city" style="width:100%">

      </div>

      <div class="column">
        <img src="imgs/eletric.png" style="width:100%">
      </div>

      <div class="column">
        <img src="imgs/lux.png" alt="lux" style="width:100%">
      </div>

    </div>


    <div id="reservation_marketing">

      <div class="reservation_marketing_column">
        <h2><i class="fa-solid fa-check"></i> Free cancellations</h2>
      </div>
      <div class="reservation_marketing_column">
        <h2><i class="fa-solid fa-check"></i> A car for everyone tastes</h2>
      </div>
      <div class="reservation_marketing_column">
        <h2><i class="fa-solid fa-check"></i> 4+ locations</h2>
      </div>

    </div>

    <form action="reservationPage.php" method="post">

      <div id="reservation">

        <div class="column_reservation">
          <h4>Pick up Location</h4>
          <select  name ="pick_location">
            <?php foreach ($parking_area as $locations) { ?>

              <option value="<?php echo $locations['locations']; ?>"><?php echo $locations['locations'] ?> </option>
            <?php } ?>

          </select>
          <!--<option value="Classe B"> Place B </option>
          <option value="Classe C"> Place C </option>
          <option value="Classe D"> Place D </option>
        </select>-->

        </div>

        <div class="column_reservation">
          <h4>Drop Location</h4>
          <select name ="drop_location">
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
          <button  name="search_button" type="submit" class="registerbtn" value="Search">Search</button>

        </div>
      </div>
    </form>



  </div>

  <div class="content">

    <!-- FAQS  -->


    <div class="maindiv" style="padding: 20px;">

      <h2 style="padding-bottom: 15px;">Frequently Asked Questions(FAQs)</h2>
      <div>
        <ul>
          <h3>What do I need to hire a car?</h3>
          <p>To book your car, all you need is a credit or debit card. When you pick the car up, you'll need: </p>
          <li>Your voucher / eVoucher, to show that you've paid for the car.</li>
          <li>The main driver's credit / debit card, with enough available funds for the car's deposit.</li>
          <li>The driver's full, valid driving licence, which they've held for at least 12 months (often 24).</li>
          <li>Your passport and any other ID the car hire company needs to see.</li>
        </ul>

      </div>

      <div>
        <ul>
          <h3>How old do I have to be to rent a car?</h3>
          <p>For most car hire companies, the age requirement is between 21 and 70 years old. If you're under 25 or
            over 70, you might have to pay an additional fee.
          </p>
        </ul>

      </div>

      <div>
        <ul>

          <h3>Can I book a hire car for someone else?</h3>

          <p>Yes, as long as they meet these requirements. Just fill in their details while you're making the
            reservation. </p>
        </ul>
      </div>

      <div>
        <ul>
          <h3>What should I look for when I'm choosing a car?</h3>
          <li>Space: You'll enjoy your rental far more if you choose a car with plenty of room for your passengers
            and luggage.</li>
          <li>Fuel policy: Not planning on driving much? A Like for like fuel policy can save you a lot of money.
          </li>
          <li> Location: You can't beat an 'on-airport' pick-up for convenience, but an 'off-airport' pick-up with
            a shuttle bus can be much cheaper.</li>
        </ul>
      </div>

    </div> <!-- cd-faq__items -->


    <!-- begin about -->
    <div class="maindiv" id="contact">

      <h2 style="padding-bottom: 15px;">Contact</h2>
      <div>
        <ul>
          <h3>Get in contact</h3>
          <p> You can get in contact with us by reaching using the <a href="https://trollface.dk/"> email </a> or throught our <a href="https://trollface.dk/"> facebook page. </a></p>
        </ul>
      </div>





    </div>











    <!-- End page content -->
  </div>









  <?php include_once('footer.php'); ?>


</body>

</html>