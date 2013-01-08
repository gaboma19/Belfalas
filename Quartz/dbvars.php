<?php

	$serverurl = "localhost";
	$adminname = "pws_admin";
	$adminp = "pws_admin_password";
	$dbname = "profwebsitedb0";

	$serverhost = "http://localhost:81/";
	$rootpath = $serverhost."Quartz/";
	$canmail = false;
	
	$q = "\"";
/*
	$link = mysql_connect($serverurl, "root", "root");
	if (!$link) {
	 	passthru("./mysql -u .$adminname. -p .$adminp. .$dbname. < DATABASE.sql");
	}
	
*/	
	$filename = 'DATABASE.sql';

	$con = mysql_connect($serverurl, "root", "root") or die('Error connecting to MySQL server: ' . mysql_error());
	if (mysql_query("CREATE DATABASE profwebsitedb0",$con))
	  {
		mysql_select_db($dbname) or die('Error selecting MySQL database: ' . mysql_error());
		$tmp = '';
		$lines = file($filename);
		foreach ($lines as $line)
		{
		    if (substr($line, 0, 2) == '--' || $line == '')
		        continue;

		    $tmp .= $line;
		    if (substr(trim($line), -1, 1) == ';')
		    {
		        // Perform the query
		        mysql_query($tmp) or print('Error performing query \'<strong>' . $tmp . '\': ' . mysql_error() . '<br /><br />');
		        // Reset temp variable to empty
		        $tmp = '';
		    }
		}
		mysql_query("GRANT ALL ON profwebsitedb0.* TO '".$adminname."'@'localhost'") or print ('Error adding user');
		mysql_query("SET PASSWORD FOR '".$adminname."'@'localhost' = PASSWORD('".$adminp."')");
	}
	else
	  {}
	// Select database
	

	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file($filename);
	// Loop through each line
	
	
/*	$db_selected = mysql_select_db($dbname, $link);
	if (!$db_selected) {
		die ('Cannot use foo : ' . mysql_error());
	}
	
*/
	//phpinfo();

	//print("serverhost: [".$serverhost."]<br>");
	//print("rootpath: [".$rootpath."]<br>");

?>