<?php
    ob_start();
	session_start();
	include './dbh.php';
?>

<!DOCTYPE html>
<html>
<head>
    <style>
      /*  body {
            background-image: url("https://images.freecreatives.com/wp-content/uploads/2015/12/Plaid-Texture-Seamless-Pattern.jpg");
            background-size: 100%;
		}*/

.nav-tabs {
  display: inline-block;
  border-bottom: none;
  padding-top: 15px;
  font-weight: bold;
}
.nav-tabs > li > a, 
.nav-tabs > li > a:hover, 
.nav-tabs > li > a:focus, 
.nav-tabs > li.active > a, 
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
  border: none;
  border-radius: 0;
}
.nav-tabs > li > a:hover {
    color: #444444;
	TEXT-DECORATION: none; font-weight: none;
}
.nav-list {}
.nav-list > li { 
  padding: 20px 15px 15px;
 
}
.nav-list > li:last-child {}
.nav-list > li > a:hover { text-decoration: none; }
.nav-list > li > a > span {
  display: block;
  font-weight: bold;
  text-transform: uppercase;
}

.mega-dropdown { position: static !important; }
.mega-dropdown-menu {
  padding: 20px 15px 15px;
  text-align: center;
  width: 100%;
}


#login-dp{
    min-width: 250px;
    padding: 14px 14px 0;
    overflow:hidden;
    background-color:rgba(255,255,255,.8);
}
#login-dp .help-block{
    font-size:12px    
}
#login-dp .bottom{
    background-color:rgba(255,255,255,.8);
    border-top:1px solid #ddd;
    clear:both;
    padding:14px;
}

@media(max-width:768px){
    #login-dp{
        background-color: inherit;
        color: #fff;
    }
    #login-dp .bottom{
        background-color: inherit;
        border-top:0 none;
    }
}
.navbar-login
{
    width: 305px;
    padding: 10px;
    padding-bottom: 0px;
}

.navbar-login-session
{
    padding: 10px;
    padding-bottom: 0px;
    padding-top: 0px;
}

.icon-size
{
    font-size: 57px;
}
.navbar-brand {
    width: 100px;
    height: 50px;
    background-size: 50px;
    padding-top: 7px;
}
.navbar-nav {
    padding-left: 15px;
}
.navbar-default .navbar-collapse, .navbar-default .navbar-form {
    border-color: #EAAB00;
}
.container-fluid {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
    background-color: #981E32;
}

.navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:hover, .navbar-default .navbar-nav>.active>a:focus {
    color: white;
    background-color: #EAAB00;
    
}
.navbar-default .navbar-nav>li>a {
    color: white;
}
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0px;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 160px;
    padding: 5px 0px;
    margin: 2px 0px 0px;
    font-size: 14px;
    list-style: none;
    background-color: white;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.14902);
    border-image-source: initial;
    border-image-slice: initial;
    border-image-width: initial;
    border-image-outset: initial;
    border-image-repeat: initial;
    border-radius: 4px;
    box-shadow: rgba(0, 0, 0, 0.172549) 0px 6px 12px;

.nav-list > li {
    padding: 20px 15px 15px;
	border-left:0px;
	}
.nav-list {
    border-bottom: 0px;
	}
    </style>
<meta charset="UTF-8">
<!--<title>Nursing Inventory System</title>
<link rel="stylesheet" type="text/css" href="style.css">-->
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<body>
<header>
	<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
     
      <!-- goes to home when clicked-->
      <a style="width: 100px;
    height: 50px;
    background-size: 50px;
    padding-top: 7px;" class="navbar-brand" href="http://www.umsl.edu"><img src="images/logotn.png" ></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar-collapse collapse" id="bs-megadropdown-tabs" style="padding-left: 0px;">
        <ul class="nav navbar-nav">


           <!-- goes to the main menu with the giant thumbnails -->
            <li><a style="color: white;" href="index.php"><i class="fa fa-globe"></i> Main Menu</a></li>

            <!--Users function page -->
			 <li class="dropdown mega-dropdown">
			   <a style="color: white;" href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-users"></i> User Management <span class="caret"></span></a>
				<div id="filters" class="dropdown-menu mega-dropdown-menu">
                    <div style="text-align: center;" class="container-fluid2">
    				    <!-- Tab panes -->
                         <div class="tab-content">
                                <div class="tab-pane active" id="content-one">
                                    <ul class="nav-list list-inline">
                               <!-- check in check out tables-->
                                <li><a href="signup.php"><img src="images/placeholder_nvtn.png"><span>Add user</span></a></li>
                                <li><a href="searchUsersForm.php"><img src="images/placeholder_nvtn.png"><span>Search user</span></a></li>
                                <!-- This will link to Add inventory page-->
                                <li><a data-filter=".97" href="usersTable.php"><img src="images/placeholder_nvtn.png "><span>See User List</span></a></li>
                            </ul>
                          </div>
                          
                        </div>
                    </div>                                     
				</div>				
			</li>
             <!--<li><a style="color: white;" href="usersTable.php"><i class="fa fa-users"></i> Users</a></li>-->
           <li class="dropdown mega-dropdown">
			   <a style="color: white;" href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-gear"></i> Inventory Functions <span class="caret"></span></a>
				<div id="filters" class="dropdown-menu mega-dropdown-menu">
                    <div style="text-align: center;" class="container-fluid2">
    				    <!-- Tab panes -->
                        <div class="tab-content">
                     
                          <div class="tab-pane active" id="kids">
                            <ul class="nav-list list-inline">
                               <!-- check in check out tables-->
							   <li><a href="addInventory.php"><img src="images/placeholder_nvtn.png"><span>Add inventory</span></a></li>
                                <li><a href="checkout.php"><img src="images/placeholder_nvtn.png"><span>Check-out</span></a></li>
                                <!-- This will link to Add inventory page-->
                                <li><a data-filter=".97" href="inventory.php"><img src="images/placeholder_nvtn.png" width="100px"><span>View/Edit/Delete</span></a></li>
                                <!-- view/edit/delete colomns and items types/subtypes in the inventory tables-->
								<li><a data-filter=".96" href="dailyReports.php"><img src="images/placeholder_nvtn.png" ><span>Daily Reports</span></a></li>
                                <!-- Report generation Page-->
								<li><a data-filter=".96" href="otherReports.php"><img src="images/placeholder_nvtn.png" ><span>Other Reports</span></a></li>
                                <li><a data-filter=".87" href="searchInventoryForm.php"><img src="images/placeholder_nvtn.png"><span>Search Inventory</span></a></li>
                            </ul>
                          </div>
                          
                        </div>
                    </div>                                     
				</div>				
			</li>
         <li class="dropdown mega-dropdown">
			   <a style="color: white;" href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-usb"></i> Consumables <span class="caret"></span></a>				
				<div id="filters" class="dropdown-menu mega-dropdown-menu">
                    <div style="text-align: center;" class="container-fluid2">
    				    <!-- Tab panes -->
                        <div class="tab-content">
                     
                          <div class="tab-pane active" id="kids">
                            <ul class="nav-list list-inline">
                               <!-- -->
                                <li><a href="consume.php"><img src="images/placeholder_nvtn.png" width="100px"><span>Consume</span></a></li>
                                <!-- This will link to Add inventory page-->
                                <li><a data-filter=".97" href="addConsumable.php"><img src="images/placeholder_nvtn.png" width="100px"><span>Add Consumable</span></a></li>
                                <!-- view/edit/delete colomns and items types/subtypes in the consumables tables-->
                                <li><a data-filter=".96" href="consumables.php"><img src="images/placeholder_nvtn.png" width="100px"><span>View/Edit/Delete</span></a></li>
                                <!-- consumables Report generation Page-->
                                <li><a data-filter=".87" href="dailyReports.php"><img src="images/placeholder_nvtn.png" width="100px"><span>Daily Reports</span></a></li>
								 <li><a data-filter=".87" href="otherReports.php"><img src="images/placeholder_nvtn.png" width="100px"><span>Other Reports</span></a></li>
								<!-- Goes to  search consumables table-->
								<li><a data-filter=".87" href="searchConsumablesForm.php"><img src="images/placeholder_nvtn.png" width="100px"><span>Search</span></a></li>
								
                            </ul>
                          </div>
                          
                        </div>
                    </div>                                     
				</div>				
			</li>
        </ul>
       <!-- <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form> -->
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
                    <a style="color: white;" href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        <?php
                        $currentID = $_SESSION['id'];
                        $sql = "SELECT acctType, uid FROM users WHERE id='$currentID'";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        $acctType = $row['acctType'];
                        $uid = $row['uid'];

                        echo "<strong>$uid</strong>";
                        ?>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul style="background-color:white;" class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <?php
                                        echo '<p class="text-ce"><strong>'.$uid.'</strong></p>
                                        <p class="text-left small">'.$acctType.'</p>';
                                        ?>

                                        <p class="text-left"><!-- if we have account settings page-->
                                            <a href="changePassword.php" class="btn btn-primary btn-block btn-sm">Change Password</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <a href="includes/logout.inc.php" class="btn btn-danger btn-block">Log Out</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
            
<!--		</ul> </div></div>-->
<!--	</nav>-->
</header>