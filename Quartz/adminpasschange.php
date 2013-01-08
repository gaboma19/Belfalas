<?php

//============================================================
//Filename : register.php
//Variables :
//  $_POST:
//      'submit' - has submit button been pressed.
//      'name' - users name submitted.
//      'email' - users email address.
//      'email2' - email address confirmation.
//      'pass' - users password.
//      'pass2' - password confirmation.
//      'buid' - users BU ID number.
//  $_SESSION:
//      'frmerror' - an error flag for the registration form.
//
//============================================================

//Comments End Here===========================================

    session_start();

	$thisfilename = "adminpasschange.php";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="Style.css" />
        <title></title>
    </head>

    <body bgcolor="#EEEEEE">

        <?php

            //Include website header.

			$headerincludedfrom = "adminpasschange.php";

            include 'dbvars.php';

            include 'header.php';

            // If the user has submitted the registration form

			// print("register.php@0 is POST['submit'] set? ".(isset($_POST['submit'])?"true":"false"));

			// die();

            if (isset($_POST['submit']))
            {
                // If there are any errors in the registration form set appropriate error code

                if (!$_POST['email'] | !$_POST['password1'] | !$_POST['password2'] | !$_POST['password3']
                	| ($_POST['password2'] != $_POST['password3']) 
					| ($_POST['email1'] != $_POST['email2']))
                {

                    if (!$_POST['email'])
                    {
                        $_SESSION['frmerror'] = 1;

                    }
					else if (!$_POST['password1'])
                    {
                        $_SESSION['frmerror'] = 2;

                    }
                    else if (!$_POST['password2'])
                    {
                        $_SESSION['frmerror'] = 3;

                    }
                    else if (!$_POST['password3'])
                    {
                        $_SESSION['frmerror'] = 3;

                    }
                    else if ($_POST['password2'] != $_POST['password3'])
                    {
                        $_SESSION['frmerror'] = 3;

                    }
					else if ($_POST['email1'] != $_POST['email2'])
                    {
                        $_SESSION['frmerror'] = 4;

                    }

                    //Since an error was encountered display the registration form again.

                	$regformincludedfrom = "adminpasschange.php@3";

                   // include 'adminpasschangeregform.php';
                }
                else
                {

                    // No errors were encountered in the registration form

                    $_SESSION['frmerror'] = 0;

                    // Create a connection to the MySQL server

                    mysql_connect($serverurl, $adminname, $adminp) or die(mysql_error());

                    mysql_select_db($dbname) or die(mysql_error());

                    // Encrypt password with MD5(one way hash) encryption

                    $_POST['password2'] = md5($_POST['password2']);
					mysql_query("UPDATE nLogin SET password = '".$_POST['password2']."' WHERE email = '".$_POST['email']."'");
                 	
					if ($_POST['email1']) {
						mysql_query("UPDATE nLogin SET email = '".$_POST['email1']."' WHERE email = '".$_POST['email']."'");
						$uname = substr($_POST['email'],0,strlen($_POST['email'])-7);
						mysql_query("DROP USER '".$uname."'@'localhost'");
						$uname1 = substr($_POST['email1'],0,strlen($_POST['email1'])-7);
						mysql_query("GRANT ALL ON profwebsitedb0.* TO '".$uname1."'@'localhost'");
						mysql_query("SET PASSWORD FOR '".$uname1."'@'localhost' = PASSWORD('".$_POST['password2']."')");
					}
						
        ?>
            <center>
                <div style="position: relative; <?php if (strstr($_SERVER['HTTP_USER_AGENT'],"Mozilla") != "") echo 'top:-15px;'; ?> width: 945px; height: 200px; background: url('images/Body.jpg');">
                    <br><br>You have successfully changed your password<br><br>
					<style type="text/css">
						a#passch:link {color:black}    /* unvisited link */
						a#passch:visited {color:red} /* visited link */
						a#passch:hover {color:blue}   /* mouse over link */
						a#passch:active {color:black}  /* selected link */s
					  </style>
				<?php	$_SESSION['usertype'] = 0; ?>
					<a id="passch" href="index.php">Go</a> to the main page
                </div>
            </center>

        <?php
                }
            }
            else
            {
                // if the user did not press submit yet then display the registration form

                $regformincludedfrom = "adminpasschange.php@9";
				?>

				        <center>
				            <div style="position: relative; <?php if (strstr($_SERVER['HTTP_USER_AGENT'],"Mozilla") != "") echo 'top:-15px;'; ?> width: 945px; height: 520px; background: url('images/Body.jpg');">

				                <div style="position: relative; top: 50px; background: url('images/Register.jpg'); width: 701px; height: 413px;">

				                    <div style="font-size:20; font-family:Tahoma; position:absolute; top:25px; left:30px; color:white;">
				                    </div>

				                    <form method="POST" action="adminpasschange.php">
				                   		<table border="0" style="position:absolute; top:59px; left:51px; font-family:Tahoma; font-size: 11px; height: 276px;">

										<tr>
				                            <td>Enter current email address: </td>
				                            <td><input type="text" name="email" value="<?php echo (isset($_POST['email'])?$_POST['email']:""); ?>" size="40" />
				                                <br>
				                                <div class="regsubt"><?php if (isset($_SESSION['frmerror']) && ( $_SESSION['frmerror'] == 1 ) && isset($_POST['submit'])) echo '*'; ?>
				                                </div>
				                            </td>
				                        </tr>
										<tr>
				                            <td>Enter new email address: </td>
				                            <td><input type="text" name="email1" value="<?php echo (isset($_POST['email1'])?$_POST['email1']:""); ?>" size="40" />
				                                <br>
				                                <div class="regsubt">You can leave this field empty<?php if (isset($_SESSION['frmerror']) && ( $_SESSION['frmerror'] == 4 ) && isset($_POST['submit'])) echo '*'; ?>
				                                </div>
				                            </td>
				                        </tr>
										<tr>
				                            <td>Confirm new email address: </td>
				                            <td><input type="text" name="email2" value="<?php echo (isset($_POST['email2'])?$_POST['email2']:""); ?>" size="40" />
				                                <br>
				                                <div class="regsubt">You can leave this field empty<?php if (isset($_SESSION['frmerror']) && ( $_SESSION['frmerror'] == 4 ) && isset($_POST['submit'])) echo '*'; ?>
				                                </div>
				                            </td>
				                        </tr>
										<tr>
				                            <td>Enter current password: </td>
				                            <td><input type="password" name="password1" value="<?php echo (isset($_POST['password1'])?$_POST['password1']:""); ?>" size="40" />
				                                <br>
				                                <div class="regsubt"><?php if (isset($_SESSION['frmerror']) && ( $_SESSION['frmerror'] == 2 ) && isset($_POST['submit'])) echo '*'; ?>
				                                </div>
				                            </td>
				                        </tr>
				                        <tr>
				                            <td>Enter new password: </td>
				                            <td><input type="password" name="password2" value="<?php echo (isset($_POST['password2'])?$_POST['password2']:""); ?>" size="40" />
				                                <br>
				                                <div class="regsubt"><?php if (isset($_SESSION['frmerror']) && ($_SESSION['frmerror'] == 3) && isset($_POST['submit'])) echo '*'; ?>
				                                </div>
				                            </td>
				                        </tr>
				                        <tr>
				                            <td>Confirm password: </td>
				                            <td><input type="password" name="password3" value="<?php echo (isset($_POST['password3'])?$_POST['password3']:""); ?>" size="40" />
				                                <br>
				                                <div class="regsubt"><?php if (isset($_SESSION['frmerror']) && ($_SESSION['frmerror'] == 3) && isset($_POST['submit'])) echo '*'; ?>
				                                </div>
				                            </td>
				                        </tr>
				               		</table>
				                    <div style="position:absolute; bottom:30px; right:35px;">
				                        <input type="reset" value="Reset" name="reset" /> &nbsp;
				                        <input type="submit" value="Submit" name="submit" />
				                    </div>
				                    </form>
				                </div>
				            </div>
				        </center>

				
            
			<?php
		}
            include 'footer.php';
        ?>

    </body>
</html>



