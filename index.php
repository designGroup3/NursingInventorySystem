<?php
include 'header.php';
if(isset($_SESSION['id'])) {
    ?>
<!doctype html>
<html>
	
	
<head>
<meta charset="utf-8">
<title>Nursing Inventory Menu</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>	
	
<body>
<style>
body{
	background-color: rgb(238,238,238);
}
.container{
	    background-color: #444444;

}
h1{
	text-align: center;
}

.center{
    background-color: transparent;
    padding: 10px;
	}
.footer-bottom {
	position: fixed;
	left: 0;
    bottom: 0;
    width: 100%;
    background-color: #444444;
}
.thumbnail{
	background-color:#f9F9f9
;

}
.copyright {
    color: #EAAB00;
    line-height: 30px;
    min-height: 30px;
    padding: 7px 0;
}
.design {
    color: #EAAB00;
    line-height: 30px;
    min-height: 30px;
    padding: 7px 0;
    text-align: right;
}
.design a {
    color: #fff;
}
</style>

<div class="parent"><button onclick="window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'">
        <i class='fa fa-question'></i></button></div>

<h1><strong>Welcome to NURSING IT Inventory System! (Beta)</strong></h1>
<br/><br/>
<div class="container center">
<div class="row">
  <div class="col-md-4 col-lg-4 col-sm-4">
    <div class="thumbnail text-center ce"><h3>View Inventory</h3><a href="inventory.php">
<img href="inventory.php" src="images/viewInventory.png" alt="Thumbnail Image 1" ></a>
      <div class="caption">
       <!-- <p>Add items to the inventory.</p><br/>-->
      </div>
    </div>
  </div>
   <div class="col-md-4 col-lg-4 col-sm-4 ">
    <div class="thumbnail text-center"><h3>Check-out</h3><a href="checkout.php">        
<img href="checkout.php"src="images/checkout.png" alt="Thumbnail Image 2"  ></a>
      <div class="caption">
        <!--<p>Edit and view inventory Tables</p><br/> -->
      </div>
    </div>
  </div>
   <div class="col-md-4 col-lg-4 col-sm-4">
    <div class="thumbnail text-center">        <h3>Consumables</h3>
<a href="consumables.php"><img src="images/consume.png" alt="Thumbnail Image 3" ></a>
      <div class="caption">
       <!-- <p>Student worker Check-list </p> -->
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4 col-lg-4 col-sm-4">
    <div class="thumbnail text-center">        <h3>ServiceAgreements</h3>
<a href="serviceAgreements.php"><img src="images/serviceAgreements.png" alt="Thumbnail Image 4" ></a>
      <div class="caption">
        <!--<p>Consumable items such as, USB drives.</p> -->
      </div>
    </div>
  </div>
  <div class="col-md-4 col-lg-4 col-sm-4">
    <div class="thumbnail text-center"><h3>View Clients List</h3><a href="clients.php"><img src="images/viewClientList.png" alt="Thumbnail Image 5" ></a>
      <div class="caption">
        
        <!-- <p>Report generation for items, people, and tables.</p> -->
      </div>
    </div>
  </div>
   <div class="col-md-4 col-lg-4 col-sm-4">
    <div class="thumbnail text-center"><h3>Repairs/Updates/Upgrades</h3><a href="repairsUpdatesUpgrades.php">
<img src="images/Upgrade.png"  alt="Thumbnail Image 6"></a>
      <div class="caption">
        <!--<p>Generate QR code</p><br/> -->
      </div>
    </div>
  </div>
</div>
</div>

</body>
</html>
<!--
if(isset($_SESSION['id'])) {
    echo "<head><Title>Main Menu</Title></head>";

        echo "&nbsp&nbsp<form action='inventory.php'>
               <input type='submit' value='Inventory'/>
              </form>";

        echo "&nbsp&nbsp<form action='usersTable.php'>
               <input type='submit' value='See Users'/>
              </form>";

        echo "&nbsp&nbsp<form action='changePassword.php'>
                   <input type='submit' value='Change My Password'/>
                  </form>";

        echo "&nbsp&nbsp<form action='checkout.php'>
                   <input type='submit' value='Check-out'/>
                  </form>";

        echo "&nbsp&nbsp<form action='consumables.php'>
               <input type='submit' value='Consumables'/>
              </form>";

        echo "&nbsp&nbsp<form action='clients.php'>
               <input type='submit' value='See Clients'/>
              </form>";

        echo "&nbsp&nbsp<form action='dailyReports.php'>
               <input type='submit' value='Daily Reports'/>
              </form>";

        echo "&nbsp&nbsp<form action='otherReports.php'>
               <input type='submit' value='Other Reports'/>
              </form>";

        echo "&nbsp&nbsp<form action='repairsUpdatesUpgrades.php'>
               <input type='submit' value='Repairs/Updates/Upgrades'/>
              </form>";

        echo "&nbsp&nbsp<form action='serviceAgreements.php'>
               <input type='submit' value='Service Agreements'/>
              </form>";
-->
    <?php
} else {
    header("Location: ./login.php");
}
?>