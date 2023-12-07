<?php
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION["msg"] = "";
$msg = $_SESSION["msg"];

$dbh = new PDO('sqlite:./db/rental_db2.sqlite');

$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function getName($role, $email)
{
    global $dbh;
    if ($role == "admin") {
        $stmt = $dbh->prepare('SELECT name FROM Operator WHERE email=?');
        $stmt->execute(array($email));
        $customer_array = $stmt->fetch();
        $name = reset($customer_array);
        return  $name;
    } else {
        $stmt = $dbh->prepare('SELECT name FROM Customer WHERE email=?');
        $stmt->execute(array($email));
        $customer_array = $stmt->fetch();
        $name = reset($customer_array);
        return  $name;
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<?php include_once "head.php" ?>

<body>
    <?php include_once "nav.php" ?>

    <!-- Page content -->
    <div class="content">



        <div class="register_form" style="margin:auto">
            <h1><i class="fa-solid fa-user"></i> Login</h1>

            <img src="imgs/login.png" alt="login" style="width: 200px;; height: 200px; ">

            <p>Please fill in with your login email and password.</p>
            <hr>

            <?php if (!isset($_SESSION["email"])) { ?>
                <form action="action_login.php" method="post">

                    <label for="email"><b>Email</b></label>
                    <input type="text" placeholder="Enter Email" name="email" id="email" required>

                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" id="password" required>

                    <button type="submit" class="registerbtn" value="Login">Login</button>

                    <p style="text-align:center;">Do not have an account? <a href="register.php">Register</a>.</p>
                </form>

            <?php } else {  ?>
                <form id="logout" action="action_logout.php">
                    <span><?php
                            $name = getName($_SESSION["role"], $_SESSION["email"]);
                            echo $_SESSION["role"] ?>, <?php echo $name; ?>         </span>
                    <button type="submit" class="registerbtn" value="Login">Logout</button>

                </form>
            <?php } ?>

            <?php if (isset($msg)) { ?>
                <p><?php echo $msg ?></p>
            <?php } ?>








        </div>


        <!-- End page content -->
    </div>




    <?php include_once('footer.php'); ?>

</body>

</html>