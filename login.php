<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>College of Nursing Inventory System</title>

<?php
  $bg = array('images/NAB_w_flowers.jpg', 'images/background1.jpg', 'images/background2.jpg', 'images/background3.jpg' ); // array of filenames

  $i = rand(0, count($bg)-1); // generate random number size of the array
  $selectedBg = $bg[$i]; // set variable equal to which random filename was chosen

echo'<style>
        body {
            background-image: url('.$selectedBg.'); 
            background-size: 100%;
        }
        </style>';
    ?>
		<style>
		.container{
		padding: 250px;
        position: relative;
        top:-50px;
		}
		.panel-transparent {
        background-color: transparent;
    }

    .panel-transparent .panel-heading{
        background: rgba(122, 130, 136, 0.2)!important;
    }

    .panel-transparent .panel-body{
        background: rgba(46, 51, 56, 0.2)!important;
    }
		
		p.form-title
{
    font-size: 20px;
    font-weight: 600px;
    text-align: center;
    color: #5F0000;
    margin-top: 5%;
    text-transform: uppercase;
    letter-spacing: 4px;
}
p.form-title
{
    font-size: 20px;
    font-weight: 600;
    text-align: center;
    color: #FFFFFF;
    margin-top: 5%;
    text-transform: uppercase;
    letter-spacing: 4px;
}

form
{
    width: 250px;
    margin: 0 auto;
}

form.login input[type="text"], form.login input[type="password"]
{
    width: 100%;
    margin: 0;
    padding: 5px 10px;
    background: 0;
    border: 0;
    border-bottom: 1px solid #FFFFFF;
    outline: 0;
    font-style: italic;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 1px;
    margin-bottom: 5px;
    color: #FFFFFF;
}

form.login input[type="submit"]
{
    width: 100%;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 500;
    margin-top: 16px;
    outline: 0;
    cursor: pointer;
    letter-spacing: 1px;
}

form.login input[type="submit"]:hover
{
    transition: background-color 0.5s ease;
}

form.login .remember-forgot
{
    float: left;
    width: 100%;
    margin: 10px 0 0 0;
}
form.login .forgot-pass-content
{
    min-height: 20px;
    margin-top: 10px;
    margin-bottom: 10px;
}
form.login label, form.login a
{
    font-size: 12px;
    font-weight: 400;
    color: #FFFFFF;
}

form.login a
{
    transition: color 0.5s ease;
}

form.login a:hover
{
    color: #2ecc71;
}

.pr-wrap
{
    width: 100%;
    height: 100%;
    min-height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 999;
    display: none;
}

.show-pass-reset
{
    display: block !important;
}

.pass-reset
{
    margin: 0 auto;
    width: 250px;
    position: relative;
    margin-top: 22%;
    z-index: 999;
    background: #FFFFFF;
    padding: 20px 15px;
}

.pass-reset label
{
    font-size: 12px;
    font-weight: 400;
    margin-bottom: 15px;
}

.pass-reset input[type="email"]
{
    width: 100%;
    margin: 5px 0 0 0;
    padding: 5px 10px;
    background: 0;
    border: 0;
    border-bottom: 1px solid #000000;
    outline: 0;
    font-style: italic;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 1px;
    margin-bottom: 5px;
    color: #000000;
    outline: 0;
}

.pass-reset input[type="submit"]
{
    width: 100%;
    border: 0;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 500;
    margin-top: 10px;
    outline: 0;
    cursor: pointer;
    letter-spacing: 1px;
}

.pass-reset input[type="submit"]:hover
{
    transition: background-color 0.5s ease;
}

.alert{
    width: 1050px;
    position: absolute;
    top: 70px;
    left: 190px;
}

    </style>
</head>
	<script src="js/bdposlgin.js"></script>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <body>
        <?php
        $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($url, 'error=input') !== false){
            echo "<div class='alert alert-danger'>Your username or password is incorrect!</div>";
        }
        ?>
            <div class="container" >
                	<div class="row vertical-offset-100">
                    	<div class="col-md-4 col-md-offset-4 col-lg-4">
                        	<div class="panel panel-transparent">
                            	<div class="panel-heading">                                
                                	<div class="row-fluid user-row">
                                    <img src="images/logowoutshadow.png" class="img-responsive" alt="umsl nursing logo" width="500" Height="200"/>
                                	</div>
                            	</div>
                            <div class="panel-body">
                                <?php
                                echo'<form accept-charset="UTF-8" role="form" class="form-signin" action="includes/login.inc.php" method="POST">
                                    <fieldset>
                                        <label class="panel-login">
                                            <div class="login_result"></div>
                                        </label>
                                       
                                        <input class="form-control" name="uid" placeholder="Username" id="username" type="text"><br>
                                        <input class="form-control" name="pwd" placeholder="Password" id="password" type="password">
                                        <br/><br/>
                                        <input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Login" href="index.html"></form>
                                    </fieldset>
                                </form>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </body>
            
</html>