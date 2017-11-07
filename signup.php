<style>
    .btn{
        Background-color:#981e32;
    }
    .btn:hover{
        Background-color:#bc233c;
    }
    /* The message box is shown when the user clicks on the password field */
    #message {
        display:none;
        background: #f1f1f1;
        color: #000;
        position: relative;
        padding: 20px;
        margin-top: 10px;
    }
    /*makes the success message go away*/
    #success_message{ display: none;}
    /* The message box is shown when the user clicks on the password field */
    #message {
        display:none;
        background: #f1f1f1;
        color: #000;
        position: relative;
        padding: 20px;
        margin-top: 10px;
    }

    #message p {
        padding: 10px 35px;
        font-size: 18px;
    }

    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
        color: green;
    }

    .valid:before {
        position: relative;
        left: -35px;
        content: "✔";
    }

    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
        color: red;
    }

    .invalid:before {
        position: relative;
        left: -35px;
        content: "✖";
    }
</style>
<script>
    //we probably don't need this js
//    $(document).ready(function() {
//        $('#contact_form').bootstrapValidator({
//            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
//            feedbackIcons: {
//                valid: 'glyphicon glyphicon-ok',
//                invalid: 'glyphicon glyphicon-remove',
//                validating: 'glyphicon glyphicon-refresh'
//            },
//            fields: {
//                first_name: {
//                    validators: {
//                        stringLength: {
//                            min: 2,
//                        },
//                        notEmpty: {
//                            message: 'Please supply your first name'
//                        }
//                    }
//                },
//                last_name: {
//                    validators: {
//                        stringLength: {
//                            min: 2,
//                        },
//                        notEmpty: {
//                            message: 'Please supply your last name'
//                        }
//                    }
//                },
//                email: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Please supply your email address'
//                        },
//                        emailAddress: {
//                            message: 'Please supply a valid email address'
//                        }
//                    }
//                },
//                phone: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Please supply your phone number'
//                        },
//                        phone: {
//                            country: 'US',
//                            message: 'Please supply a vaild phone number with area code'
//                        }
//                    }
//                },
//                address: {
//                    validators: {
//                        stringLength: {
//                            min: 8,
//                        },
//                        notEmpty: {
//                            message: 'Please supply your street address'
//                        }
//                    }
//                },
//                city: {
//                    validators: {
//                        stringLength: {
//                            min: 4,
//                        },
//                        notEmpty: {
//                            message: 'Please supply your city'
//                        }
//                    }
//                },
//                state: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Please select your state'
//                        }
//                    }
//                },
//                zip: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Please supply your zip code'
//                        },
//                        zipCode: {
//                            country: 'US',
//                            message: 'Please supply a vaild zip code'
//                        }
//                    }
//                },
//                comment: {
//                    validators: {
//                        stringLength: {
//                            min: 10,
//                            max: 200,
//                            message:'Please enter at least 10 characters and no more than 200'
//                        },
//                        notEmpty: {
//                            message: 'Please supply a description of your project'
//                        }
//                    }
//                }
//            }
//        })
//            .on('success.form.bv', function(e) {
//                $('#success_message').slideDown({ opacity: "show" }, "slow"); // Do something ...
//                $('#contact_form').data('bootstrapValidator').resetForm();
//
//                // Prevent form submission
//                e.preventDefault();
//
//                // Get the form instance
//                var $form = $(e.target);
//
//                // Get the BootstrapValidator instance
//                var bv = $form.data('bootstrapValidator');
//
//                // Use Ajax to submit form data
//                $.post($form.attr('action'), $form.serialize(), function(result) {
//                    console.log(result);
//                }, 'json');
//            });
//    });
    /////////////////////
    //password rules js//
    /////////////////////
    var myInput = document.getElementById("psw");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    };

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    };

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>
<?php
    error_reporting(E_ALL ^ E_WARNING);
	include 'header.php';
	include './dbh.php';
    echo "<head><Title>Signup</Title></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=empty') !== false){
        echo "<br>&nbsp&nbspPlease fill out all fields.<br>";
    }
    elseif(strpos($url, 'error=username') !== false){
        echo "<br>&nbsp&nbspUsername already in use.<br>";
    }
    elseif(strpos($url, 'error=email') !== false){
        echo "<br>&nbsp&nbspEmail Address already in use.<br>";
    }

    if(isset($_SESSION['id'])){
        echo "<br><class style=\"text-align:center;\"> <h2>Add user page</h2><br/>
        <div class=\"container\"><form class=\"well form-horizontal\" action='includes/signup.inc.php'
        method='POST' id=\"contact_form\"><fieldset>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">First Name</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
        <input name='first' placeholder='First Name' class=\"form-control\" type=\"text\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\" >Last Name</label> 
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
        <input name='last' placeholder='Last Name' class='form-control'  type='text'></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">E-Mail</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>
        <input name='email' placeholder='E-Mail Address' class='form-control'  type='email'></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Account Type</label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-list\"></i></span>
        <select class=\"form-control selectpicker\" name='acctType'>
        <option value='Standard User'>Standard User</option>";
        $currentID = $_SESSION['id'];
        $sql = "SELECT acctType FROM users WHERE id='$currentID'";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();
        $acctType = $row['acctType'];
        if($acctType == "Admin" || $acctType == "Super Admin"){
            echo "<option value='Admin'>Admin</option>";
        }
        if($acctType == "Super Admin"){
            echo "<option value='Super Admin'>Super Admin</option>";
        }

        echo "</select></div></div></div>
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Username</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
        <input type='text' class='form-control' placeholder='Username' name='uid'></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\" for=\"psw\">Password</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
        <input name='pwd' placeholder='Password' class='form-control' type='password' id='pwd'
         pattern=\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" 
         title=\"Must contain at least one number and one uppercase and lowercase letter,
          and at least 8 or more characters\" required></div></div></div><div id=\"message\">
        <h4>Password must contain the following:</h4><p id=\"letter\" class=\"invalid\">A <b>lowercase</b> letter</p>
        <p id=\"capital\" class=\"invalid\">A <b>capital (uppercase)</b> letter</p>
        <p id=\"number\" class=\"invalid\">A <b>number</b></p>
        <p id=\"length\" class=\"invalid\">Minimum <b>8 characters</b></p></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button name='submit' type=\"submit\" class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
        data-submit=\"...Sending\">Add User</button></div></div></fieldset></form></div>";
    }else {
        header("Location: ./login.php");
    }
?>