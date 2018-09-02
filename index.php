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
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
<script src="js/jquery-1.11.1.js"></script>
	
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

<div class="parent"><button class="help" onclick="window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'">
        <i class='fa fa-question'></i></button></div>

<h1><strong>Welcome to NURSING IT Inventory System!</strong></h1>
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
    <div class="thumbnail text-center">        <h3>Service Agreements</h3>
<a href="serviceAgreements.php"><img src="images/serviceAgreements.png" alt="Thumbnail Image 4" ></a>
      <div class="caption">
        <!--<p>Consumable items such as, USB drives.</p> -->
      </div>
    </div>
  </div>
  <div class="col-md-4 col-lg-4 col-sm-4">
    <div class="thumbnail text-center"><h3>Clients</h3><a href="clients.php"><img src="images/viewClientList.png" alt="Thumbnail Image 5" ></a>
      <div class="caption">
        
        <!-- <p>Report generation for items, people, and tables.</p> -->
      </div>
    </div>
  </div>
   <div class="col-md-4 col-lg-4 col-sm-4">
    <div class="thumbnail text-center"><h3>Services</h3><a href="repairsUpdatesUpgrades.php">
<img src="images/Upgrade.png"  alt="Thumbnail Image 6"></a>
      <div class="caption">
        <!--<p>Generate QR code</p><br/> -->
      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Close</span></button>

      </div>
      <div class="modal-body">
       <iframe width="100%" height="700" style="overflow: hidden;" src="randy.pdf" frameborder="0" marginheight="0" marginwidth="0" scrolling="no">Loading&amp;#8230;</iframe>
      </div>
    </div>
  </div>
</div>

</body>
</html>
<?php
} else {
    header("Location: ./login.php");
}
?>