<?php
session_start();

if (!isset($_SESSION["email"])) {
  $_SESSION["msg"] = "Please login.";
}
$dbh = new PDO('sqlite:./db/rental_db2.sqlite');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>



<!DOCTYPE html>
<html lang="en">
<?php include_once "head.php" ?>


<body>

  <?php include_once "nav.php" ?>


  <!-- Page content -->
  <div class="content">

    <form action="action_register.php" method="post">

      <div class="register_form">

        <h1><i class="fa-solid fa-user-check"></i>Register</h1>

        <img src="imgs/registration.png" alt="login" style="width: 200px;; height: 200px; ">
        <p>Please fill in this form to create an account in R&B. The following data will be used for the solo purpose of the services provided.</p>
        <hr>

        <h3>Login information</h3>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" id="psw" required>

        <hr>
       <h3>Personal information</h3>

        <label for="name"><b>Name</b></label>
        <input type="name" placeholder="Full name" name="name" id="name" required>

        <label for="number"><b>Age</b></label>
        <input type="nubmer" placeholder="Age" name="age" id="age" required>

        <label for="address"><b>Address</b></label>
        <input type="text" placeholder="Adress" name="address" id="adress" required>

        <label for="number"><b>Fiscal Number</b></label>
        <input type="number" placeholder="Fiscal Number" name="tax_number" id="tax_number" required>

        <label for="number"><b>Phone Number</b></label>
        <input type="number" placeholder="Phone number" name="contact" id="contact" required>

        <hr>

        <label for="drivers"><b>Drivers License</b></label>
        <input type="number" placeholder="Drivers License" name="license_number" id="license_number" required>
        <hr>
        
        <label for="Type of license"><b>Type of license</b></label>
        <input type="text" placeholder="Type of license" name="type" id="type" required>
        <hr>

        <label for="License expiring date"><b>License expiring date</b></label>
        <input type="date" placeholder="Type of license" name="expiring_date" id="expiring_date" required>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" value="Register" class="registerbtn">Register</button>
       
        <p style="text-align:center;">Already have an account? <a href="login.php">Login</a>.</p>

      </div>


    </form>
    <?php if (isset($msg)) { ?>
        <p class = "msg"><?php echo $msg ?></p>
      <?php } ?>

  

    <!-- End page content -->
  </div>



  <?php include_once('footer.php'); ?>


</body>

</html>