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
// falta depois exigir que esteja logado, mas para ja n tou a por isso

$dbh = new PDO('sqlite:./db/rental_db2.sqlite');
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php include_once "head.php" ?>

<body>


    <?php include_once "nav.php" ?>

   
    <!-- Page content -->
    <div class="content1">

        <div class="choose_assurance" style="padding:5%;width: 100%;padding-right:5px">

        <h1 style="padding-left:0.5% ;padding-top:10px">Protection Packages for peace of mind </h1>

            <table class="assurance" style="width:65%; height:100%;float:left;padding-right:1px">

                <thead class="cabecalho">
                    <tr>
                        <td scope="col" r owspan="2" colspan="2"></td>
                        <th>Basic</th>
                        <th>Medium</th>
                        <th>Premium</th>
                    </tr>

                </thead>

                <tbody class="Price">
                    <tr>
                        <th scope="col" rowspan="2" colspan="2">Price</th>
                        <td>Free
                            <input type="radio" id="assurance_option" name="assurance_option">
                        </td>
                        <td>26.50 $
                            <input type="radio" id="assurance_option" name="assurance_option">
                        </td>
                        <td>27.20 $
                            <input type="radio" id="assurance_option" name="assurance_option">
                        </td>
                    </tr>
                </tbody>

                <tbody class="Details">
                    <tr>
                        <th>
                            <i class="fa-solid fa-person-walking-luggage"></i>
                        </th>
                        <th class="thbreak"><span>Theft Waiver </span></th>


                        <td class="yes"><i class="fa-solid fa-check"></i></td>
                        <td class="yes"><i class="fa-solid fa-check"></i></td>
                        <td class="yes"><i class="fa-solid fa-check"></i></td>
                    </tr>

                    <tr>
                        <th>
                            <i class="fa-solid fa-car-burst"></i>

                        </th>

                        <th class="thbreak"><span>Colision Damage Waiver </span> </th>

                        <td class="not"><i class="fa-solid fa-xmark"></i></td>
                        <td class="yes"><i class="fa-solid fa-check"></i></td>
                        <td class="yes"><i class="fa-solid fa-check"></i></td>
                    </tr>

                    <tr>
                        <th>
                            <i class="fa-solid fa-car"></i>

                        </th>
                        <th class="thbreak"> <span>Value Cover. Glass,Lights and Tyre Protection </span> </th>

                        <td class="not"><i class="fa-solid fa-xmark"></i></td>
                        <td class="not"><i class="fa-solid fa-xmark"></i></td>
                        <td class="yes"><i class="fa-solid fa-check"></i></td>
                    </tr>
                </tbody>
            </table>

            <div class="check_out" style=" float: right;width:20%;height:100%; padding: 5px; padding-bottom:0;">
                <h3>Your Selection</h3>
                <div class="choosen_car">
                    <img src="imgs/suv.png" alt="suv">
                </div>
                <h3 style="padding:0;margin-left:5px;margin-bottom:5px ;">Locations</h3>
                <h4 style="padding:0;margin:5px">Pick up</h4>
                <p style="padding:0;margin:0">Rua das conas</p>
                <p style="padding:0;margin:0">29/02/2023</p>
                <h4 style="padding:0;margin:5px">Return</h4>
                <p style="padding:0;margin:0">Rua das conas</p>
                <p style="padding:0;margin:0">29/02/2023</p>
            </div>

            <div class="payment" style="width:100%;height:50%;margin-left:12% ; ">
                <div class="information_Review" style="float:left; width:70% ;height:50%;">
                    <h2 style="background: white; text-align: center; border-radius: 16px;">Payment </h2>

                    <div class="information-costs">
                        <p> Car : Mercedes ; 220 $</p>
                    </div>

                    <div class="information-costs">
                        <p>Assurance choosen : A - 28$</p>
                    </div>

                    <div class="total_price_box" style="float:left;width:30% ">
                        Total price : 248 $
                    </div>
                    <div class="button_pay" style="float:right">
                        <h4>Pay</h4>
                    </div>

                </div>
               

            </div>
        </div>

    </div>

    

</body>

</html>