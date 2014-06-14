<?php
// http://nathanj.github.io/gitguide/tour.html
$crlf = chr(13) . chr(10);
$d_quote = chr(34);
$cgi = $_SERVER['PHP_SELF'];
include ('include.txt');
$bio_table = "vt_test_biological";
$detail_table = "vt_test_detail";
$email_table = "vt_test_email";
$man_table = "vt_test_man";
$mydbf = "vaccine";
// $PHP_AUTH_USER is not used for the test application
// Set a var called $user_name
// The commented text is not changed
$user_name = "Test Web User";
$usr_access = "100";
// for pvaccine.php use $mytable = "p_detail";
// for pvaccine_state.php use $mytable = $mytable = "p_detail_mcd";
//$mytable = "p_detail"; // pvaccine.php
$mytable = $detail_table; // pvaccine.php
$content = "The following is an automated message from the Commercial Pediatric Vaccine Tracker.\r\nPlease do not respond via email reply because the reply mail box is bogus.\r\n\r\nMessage: %%message%%\r\n\r\n";
$from_string_addr = "From: Vaccine Tracker\r\n" ."Reply-To: webmaster@asthmaandallergy.com\r\n" ."X-Mailer: PHP/" . phpversion();
//$mytable = "p_detail_mcd"; // pvaccine_state.php
// in mybanner change the backgrounds pvaccine.php and pvaccine_state.php
  // use the top one for Pedi Commercial vaccines ---pvaccine.php---
  //$bk = "background='/backgrounds/water003.jpg'";
  // use the next one for Pedi State vaccines ---pvaccine_state.php--
  //$bk = "background='/backgrounds/comp010.jpg'";
// Also comment out the proper item below in the mybanner section  
//  echo "<title>Commercial Pediatric Vaccine Tracker</title>\n";
//  echo "<title>State Pediatric Vaccine Tracker</title>\n";  
  

$exp_window = 30;
// time needs to have the format of 99:99 or else the sort will not work properly
// ie order by r_date, r_time ASC as well as c_date, c_time ASC!!!
// vaccine_list and expire seem to be the same code!
// Need to consolidate if true
// Keep expire and remove vaccine_list
//-- 
//-- Database: `inventory`
//-- 
//-- --------------------------------------------------------
//-- 
//-- Table structure for table `biological`
//-- 
//CREATE TABLE `biological` (
//  `id` double NOT NULL auto_increment,
//  `name` varchar(32) NOT NULL default '',
//  `state_memo` text NOT NULL,
//  `comm_memo` text NOT NULL,
//  PRIMARY KEY  (`id`)
//) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;
//
//-- --------------------------------------------------------
//-- 
//-- Table structure for table `detail`
//-- 
//CREATE TABLE `detail` (
//  `id` double NOT NULL auto_increment,
//  `biological_id` double NOT NULL default '0',
//  `man_id` double NOT NULL default '1',
//  `exp_date` date NOT NULL default '0000-00-00',
//  `lot_num` varchar(80) NOT NULL default '',
//  `r_name` varchar(30) NOT NULL default '',
//  `r_date` date NOT NULL default '0000-00-00',
//  `r_time` varchar(5) NOT NULL default '',
//  `r_ip` varchar(15) NOT NULL default '',
//  `consumed_ynd` enum('Y','N','D') NOT NULL default 'N',
//  `c_name` varchar(30) NOT NULL default '',
//  `c_date` date NOT NULL default '0000-00-00',
//  `c_time` varchar(5) NOT NULL default '',
//  `c_ip` varchar(15) NOT NULL default '',
//  `note` varchar(132) NOT NULL default '',
//  PRIMARY KEY  (`id`),
//  KEY `exp_date` (`exp_date`),
//  KEY `r_date` (`r_date`),
//  KEY `c_date` (`c_date`),
//  KEY `bilogical_id` (`biological_id`)
//) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

//-- 
//-- Table structure for table `vt_test_man`
//-- 
//
//CREATE TABLE `vt_test_man` (
//  `id` double NOT NULL auto_increment,
//  `name` varchar(32) NOT NULL default '',
//  PRIMARY KEY  (`id`)
//) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
//
//-- 
//-- Dumping data for table `vt_test_man`
//-- 
//
//INSERT INTO `vt_test_man` (`id`, `name`) VALUES 
//(1, 'unknown'),
//(2, 'GSK'),
//(3, 'Merck'),
//(4, 'Norvatis'),
//(5, 'Sanofi'),
//(6, 'Wyeth'),
//(7, 'MedImmune');




// below is the short version of the program name ie secure.html
// use this one if we want the security to work reguardless of where the program lives
//$cgi = substr($PHP_SELF,strrpos($cgi,"/")+1);


// Select host here
$myHost = "local";
//$myHost = "ras";
//$myHost = "nec";
// end of Selection host

// Make dbf connection here ($dbh)
    $dbh = mysql_connect('localhost', 'vtracuser','74mgMqGeL1nySu7xzMfl') or die("unable to open database");
    // $mydbf can change
    $mydbf = "vaccine";

mysql_select_db("$mydbf") or die("unable to access database");


/*
// security code
if (!isset($PHP_AUTH_USER)) {
  Header("WWW-Authenticate: Basic realm=\"Pediatric Vaccine Tracker\"");
  Header("HTTP/1.0 401 Unauthorized");
  echo "Cancled by user\n";
  exit;
} else {
  // first let's do some self enrollment
  $q = "select count(id) from s_prog where name = $d_quote$cgi$d_quote";
  $r = mysql_query($q) or die(mysql_error());
  $found = mysql_result($r, 0, 0);
  if ($found < 1) { // time to enroll!
    $comment = "Name:" . chr(13) . "General:" . chr(13) . "Features:" . chr(13) . "Model:";
    $q = "insert into s_prog set name = $d_quote$cgi$d_quote, comment = $d_quote$comment$d_quote"; 
    $r = mysql_query($q) or die(mysql_error());
    // it is now enrolled!
  }
  $q = "select a.id
            from s_usr a, s_prog b, s_usr_prog_x c
            where a.name = $d_quote$PHP_AUTH_USER$d_quote and a.pass = $d_quote$PHP_AUTH_PW$d_quote and 
            b.id = c.s_prog_id and a.id = s_usr_id";
  $r = mysql_query($q) or die(mysql_error());
  $found = mysql_num_rows($r);
  if ($found < 1) { // User is not in database
    echo '<center><font size="+2">Access Forbidden!</font></center>';
    echo "<center><font size='+2'>User $PHP_AUTH_USER not on File<br>or password does not match</font></center>";
    exit;
  } else { // is this person registered with permission to this program?
    $row = mysql_fetch_array($r);
    $user_id = $row["id"]; // this is the user id
    // what is the program id??
    $q = "select id from s_prog where name = $d_quote$cgi$d_quote";
    $r = mysql_query($q) or die(mysql_error());
    $prog_id = mysql_result($r, 0, 0);
    // prepair the SQL
    $q = "select id, usr_access from s_usr_prog_x where s_usr_id = $d_quote$user_id$d_quote and s_prog_id = $d_quote$prog_id$d_quote";
    $r = mysql_query($q) or die(mysql_error());
    $found = mysql_num_rows($r);
    if ($found == 0) { //Houston, we have a problem
      echo '<center><font size="+2">Access Forbidden!</font></center>';
      echo "<center><font size='+2'>User $PHP_AUTH_USER does not have access to $cgi</font></center>";
      exit;
    } else {
      $row = mysql_fetch_array($r);
      $usr_access = $row["usr_access"];
    }
  }
}
// end of expermental code
//-------------------
*/


function SendEmail($comment, $bio_table, $detail_table, $email_table)
{
	$content = "The following is an automated message from the Commercial Pediatric Vaccine Tracker.\r\nPlease do not respond via email reply because the reply mail box is bogus.\r\n\r\nMessage: %%message%%\r\n\r\n";
	$from_string_addr = "From: Commercial Vaccine Tracker\r\n" ."Reply-To: webmaster@asthmaandallergy.com\r\n" ."X-Mailer: PHP/" . phpversion();
	$q = "select * from $bio_table order by name";
	$r = mysql_query($q) or die(mysql_error());
	$message = "The following is a listing of the existing Commercial Pediatric Vaccine Inventory\n";
	if (mysql_num_rows($r) > 0) {
		while ($row = mysql_fetch_array($r)) {
			$bio_id = $row["id"];
			$name = $row["name"];
			$q2 = "select count(*) as mycount from $detail_table where biological_id = '$bio_id' and consumed_ynd = 'N'";
			$r2 = mysql_query($q2) or die(mysql_error());
			$row2 = mysql_fetch_array($r2);			  
			$mycount = $row2["mycount"];
			if ($mycount > 0) {
				$message = $message . "$mycount - $name\n";
			}
		}
   } else {
		$message = $message . "No Stock to report for the Commercial Pediatric Vaccine Inventory";
   }
	$q = "select * from $bio_table order by name";
	$r = mysql_query($q) or die(mysql_error());
	$message = $message . "\n\nThe following is a listing of the existing State Pediatric Vaccine Inventory\n";
	if (mysql_num_rows($r) > 0) {
		while ($row = mysql_fetch_array($r)) {
			$bio_id = $row["id"];
			$name = $row["name"];
			$q2 = "select count(*) as mycount from $detail_table where biological_id = '$bio_id' and consumed_ynd = 'N'";
			$r2 = mysql_query($q2) or die(mysql_error());
			$row2 = mysql_fetch_array($r2);			  
			$mycount = $row2["mycount"];
			if ($mycount > 0) {
				$message = $message . "$mycount - $name\n";
			}
		}
		$content = str_replace("%%message%%", $message, $content);
	} else {
		$message = $message . "No Stock to report for the State Pediatric Vaccine Inventory";
	}
//	$content = $comment . "\n" . $content;
	$q = "select * from $email_table where active_yn = 'Y'";
	$r = mysql_query($q) or die(mysql_error());
	$content = $comment . "\n" . $content;
	while ($row = mysql_fetch_array($r)) {
		$to = $row["addr"];
		mail($to, "Automated Phone Message", $content, $from_string_addr);
//		mail($to, "$comment", $content, $from_string_addr);
//		echo "<br><center>Message has been sent to $to</center><br>";
	}
} // end SendEmail

//-------------------
function ValadateInput($txt, $type, $comment)
{
// send text and a type and get back an error comment
// if the error comment is empty, then it is ok
$retval = "";
switch ($type) {
  case "sname";
    $retval = "";
    if (strlen($txt) < 2) {
      $retval = "$comment '$txt' is too short<BR>\nMust be at least 2 characters long<br>\n";
    } 
    break;
  case "name";
    $retval = "";
    if (strlen($txt) < 3) {
      $retval = "$comment '$txt' is too short<BR>\nMust be at least 3 characters long<br>\n";
    } 
    break;
  case "date":
    $err_date = "Invalid date format for $comment: <BR>Cannot determine '$txt' as being a valid date<BR>";
    $retval = "";
    if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $txt, $regs)) {
      $mymonth = $regs[1];
      $mydate = $regs[2];
      $myyear = $regs[3];
      settype($mymonth, "integer");
      settype($mydate, "integer");
      settype($myyear, "integer");
      if ($myyear < 1 or $myyear > 2071) {
        $retval .= "<CENTER>$err_date The year is in question<br></CENTER><BR>";
      } else {
        if (($mymonth < 1) or ($mymonth > 12)) $retval .= "<CENTER>$err_date Month should be between 1 and 12<br></CENTER><BR>";
        if ($mydate < 1 or $mydate > 31) {
          $retval .= "<CENTER>$err_date No month has more than 31 days or less than 1 day<br></CENTER><BR>";
        } else {
          if ($mymonth == 4 or $mymonth == 6 or $mymonth == 9 or $mymonth == 11) {
            if ($mydate == 31) $retval .= "<CENTER>$err_date Only 30 days in this month (month #$mymonth)<BR></CENTER><BR>";
          } 
	  if ($mymonth == 2) {
	    if ($mydate > 29) $retval .= "<CENTER>$err_date There can never be more than 29 days in ANY Febuary<br></CENTER><BR>";
	    if ($mydate == 29 and $myyear % 4 > 0) $retval .= "<CENTER>$err_date Only 28 days in THIS Febuary<br></CENTER><BR>";
	  }
        } 
      } 
    } else {
      $retval .= "<center>$err_date Try using the MM/DD/YYYY format<BR></CENTER><BR>";
    } 
    break;
  case "email":
    $at_loc = strpos($txt, "@");
    $email_exp = "^[a-z0-9\._-]+@[a-z0-9\._-]+\.+[a-z]{2,3}$";
    if ($at_loc < 2) {
      $retval .= "Please check the prefix and @ sign<br>\n";
    } 
    $firstdot = strpos($txt, ".");
    $afterdot = substr($txt, $firstdot + 1);
    if ($firstdot < 1) {
      $retval .= "Please check the suffix for accuracy.<br>\n";
      $retval .= "(It should include a .com,.net,.org,.gov,.mil, or other)<br>\n";
      // 3/26/2003 jbt
      // Found email address with a dot prior to the @ ie john.trombly@goofy.org
      // making sure that there is a . after the @ and not allowing more than 2 dots prior to the @
    } else {
      if ($at_loc > $firstdot + strpos($afterdot, ".")) {
        $retval .= "Max of one dot prior to the @ sign<br>and<br>must have a dot after the @ sign<br>\n";
      } 
    } 
    if (!eregi($email_exp, $txt)) {
      $retval .= "Check Email address again for valid form";
    }
    if (strlen($retval) > 0) {
      $retval = "<center>Sorry. This $comment '$txt' seems wrong.<br>\n" . $retval . "</center><br>\n";
    } 
    break;
  case "num":
    if (strlen($txt) < 1) {
      $retval = "$comment is too short<BR>\nPut $comment in number format ie 999<br>\n";
    } else {
      if (!ereg("(^[0-9]{1,6})$", $txt)) {
        $retval = "$comment must be in this format<BR>9999<br>\n";
      } 
    } 
    if (strlen($retval) > 0) {
      $retval = "<center>Error in $comment ($txt).<br>\n" . $retval . "</center><br>\n";
    } 
    break;
  case "num62":
    if (strlen($txt) < 1) {
      $retval = "$comment is too short<BR>\nPut $comment in number format ie 999.99<br>\n";
    } else {
      if (!ereg("(^[0-9]{1,3}.[0-9]{1,2})$", $txt)) {
        $retval = "$comment must be in this format<BR>999.99<br>\n";
      } 
    } 
    if (strlen($retval) > 0) {
      $retval = "<center>Error in $comment ($txt).<br>\n" . $retval . "</center><br>\n";
    } 
    break;
  case "phone":
    if (strlen($txt) < 12) {
      $retval = "$comment is too short<BR>\nPut phone number in 999-999-9999<br>\n";
    } else {
      if (!ereg("([0-9]{3,3})-([0-9]{3,3})-([0-9]{3,3})", $txt)) {
        $retval = "Phone number must be in this format<BR>999-999-9999<br>\n";
      } 
    } 
    if (strlen($retval) > 0) {
      $retval = "<center>Error in $comment ($txt).<br>\n" . $retval . "</center><br>\n";
    } 
    break;
  case "time":
    if (strlen($txt) != 5) {
      $retval = "<br>$comment is not 5 characters long<br>Put time string like 99:99";
    } else {
      if (!ereg("([0-2]{1,1})([0-9]{1,1}):([0-5]{1,1})([0-9]{1,1})", $txt)) {
        $retval = "<br><b>$comment</b> is time and must be in this format<BR>hh:mm<br>hh must be less than 30<br>mm must be less than 60<br>\n";                                                                                                                }
    }
    break;
  case "time15":
    if (strlen($txt) != 5) {
      $retval = "<br>$comment is not 5 characters long<br>Put time string like 99:99";
    } else {
      if (!ereg("([0-2]{1,1})([0-9]{1,1}):([0-5]{1,1})([0-9]{1,1})", $txt)) {
        $retval = "<br><b>$comment</b> is time and must be in this format<BR>hh:mm<br>hh must be less than 30<br>mm must be less than 60<br>\n";
      } else {
        // 15 min or less!
        if (nJbtmin($txt) > 15 ) {
          $retval = "<br><b>$comment</b> is more than 15 min<BR>Try a setting of 15min or less<br>\n";
	}
      }
    }
    break;
  case "YN":
    if (strlen($txt) != 1) {
      $retval = "<br>$comment is not 1 characters long<br>Only put Y or N";
    } else {
      if ($txt != 'Y' and $txt != 'N') {
        $retval = "<br>$comment can only be <b>Y</b> or <b>N</b><br>\n";
      }
    }
    break;
  default:
    $retval = "<center>Error<BR>Unable to data<BR>Data Type unknown</center><br>\n";
    break;
}  // end switch
	return $retval;
} // end ValadateInput
//--------
 
function FixMyStringquote($mystring)
{
// *** ATTENTION ***
// Special Modified version allows single quotes to pass!
// Be sure that when this text is sent, double quites surround it in the SQL statement!
// *** ATTENTION ***
// This will remove the dangerous characters quotes and question mark
$temp = $mystring;
//$temp = str_replace("'", "",  $mystring); // byby single quote
$temp = str_replace('"', '"', $temp); // byby double quotes
$temp = str_replace("?", "", $temp); // byby question mark
$temp = str_replace("$", "", $temp); // byby Dollar sign (just for good measure
// no HTML tags should pass so no < or >
//$temp = str_replace("<", "", $temp); // byby start of HTML Tags
//$temp = str_replace(">", "", $temp); // byby end of HTML Tags
$mylen_now = strlen($temp);
$mylen_prior = $mylen_now + 1;
while ($mylen_now <> $mylen_prior) {
  $mylen_prior = strlen($temp);
  $temp = str_replace("  ", " ", $temp); // Get rid of ** ALL ** the white space!!
  $mylen_now = strlen($temp);
}
$bkslach = chr(92);
$temp = str_replace($bkslach, "", $temp); // byby Backslash because this is used to signal special characters)

return $temp;
} // end of FixMyStringquote


//--------
function LinuxDate($date)
{
// takes a date string in MM/DD/YYYY format
// and returns it in YYYY-MM-DD format (for Mysql)
if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $date, $regs)) {
  $retval = "$regs[3]-$regs[1]-$regs[2]";
}
return $retval;
} //end of LinuxDate function

//---------
function DosDate($date)
{
// takes a date string in YYYY-MM-DD format
// and returns it in MM/DD/YYYY format (for Regular People)
if (ereg ("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $date, $regs)) {
  $retval = "$regs[2]/$regs[3]/$regs[1]";
}
return $retval;
} //end of LinuxDate function

//----------

function FixMyString($mystring)
{
// *** ATTENTION ***
// Special Modified version allows single quotes to pass!
// Be sure that when this text is sent, double quites surround it in the SQL statement!
// *** ATTENTION ***
// This will remove the dangerous characters quotes and question mark
$temp = $mystring;
$temp = str_replace("'", "",  $mystring); // byby single quote
$temp = str_replace('"', "", $temp); // byby double quotes
$temp = str_replace("?", "", $temp); // byby question mark
$temp = str_replace("$", "", $temp); // byby Dollar sign (just for good measure
$temp = str_replace("&", "", $temp); // byby AND sign (makes html crankey
$temp = str_replace(",", "", $temp); // byby comma sign (makes html crankey as well
// no HTML tags should pass so no < or >
$temp = str_replace("<", "", $temp); // byby start of HTML Tags
$temp = str_replace(">", "", $temp); // byby end of HTML Tags
$mylen_now = strlen($temp);
$mylen_prior = $mylen_now + 1;
while ($mylen_now <> $mylen_prior) {
  $mylen_prior = strlen($temp);
  $temp = str_replace("  ", " ", $temp); // Get rid of ** ALL ** the white space!!
  $mylen_now = strlen($temp);
}
$bkslach = chr(92);
$temp = str_replace($bkslach, "", $temp); // byby Backslash because this is used to signal special characters)
return $temp;
} // end of FixMyString


function MeColorTR($count, $numCols)
{
// Puts in the color tag for a row (TR>
// numCols is the # of Colums desired
$setColor = $count % $numCols;
if ($setColor == 0 ) {
	// Here is where we plan the color for the new Row
	$setColor = intval($count / $numCols);
	$setColor = $setColor%3;
      switch ($setColor) {
        case "0":
          echo "\n<tr bgcolor=#DDDDDD>";
          break;
        case "1":
          echo "\n<tr bgcolor=#CCCCCC>";
          break;
        case "2":
          echo "\n<tr bgcolor=#C0C0C0>";
          break;
        case "3":
          echo "\n<tr>";
          break;
      } // end switch
}
  // increment the counter
  $retval = $count + 1;
  return $retval;
} // end of MeColorTR

function format_time($time)
{
  $retval = $time["hours"];
  if (strlen(trim($retval)) < 2) $ret_val = "0" . $retvalue;
  if (strlen(trim($time["minutes"])) < 2) {
    $retval = $retval . ":0" . $time["minutes"];
  } else {
    $retval = $retval . ":" . $time["minutes"];
  }
  $retval = str_pad($retval,5,"0",STR_PAD_LEFT);
  return $retval;
} // end of format_time

function mybanner($string, $ding,$user_name)
{
// default banner for this program
// in mybanner change the backgrounds pvaccine.php and pvaccine_state.php
  // use the top one for Pedi Commercial vaccines ---pvaccine.php---
  $bk = "background='/backgrounds/pa-sw-602.jpg'";
  $bk = "background='/backgrounds/1.gif'";
  $bk = "background='/backgrounds/2.gif'";
  $bk = "background='/backgrounds/3.gif'";
  $bk = "background='/backgrounds/4.gif'";
  $bk = "background='/backgrounds/1a.gif'";
  $bk = "background='/backgrounds/bg1.png'";
  $bk = "background='/backgrounds/bg1a.png'";
  $bk = "background='/backgrounds/bg1c.png'";
//  public_html
//  pa-sw-602.jpg
  $myheadder = "== VTRACNOW ==<br>Vaccine Tracker";
  // use the next one for Pedi State vaccines ---pvaccine_state.php--
//  $bk = "background='/backgrounds/comp010.jpg'";
//  $myheadder = "State Pediatric Vaccine Tracker";
  // use the top one for Pedi Commercial vaccines
  echo '<!doctype html public "-//w3c//dtd html 3.2//en">' . "\n";
  echo "<html>\n";
  echo "<head>\n";
//  echo "<title>$myheadder</title>\n";
  echo "</head>\n";
  switch  ($ding) {
    case "yes":	  
      echo '<body bgcolor="#ffffff"' . $bk . ' text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000"><bgsound src="cashregister.wav" loop="1">';
      break;
    case "foghorn":	  
      echo '<body bgcolor="#ffffff"' . $bk . ' text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000"><bgsound src="foghorn.wav" loop="1">';
      break;
    case "tadah":
      echo '<body bgcolor="#ffffff"' . $bk . ' text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000"><bgsound src="chimeup.wav" loop="1">';
      break;
    case "order":
      echo '<body bgcolor="#ffffff"' . $bk . ' text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000"><bgsound src="order.wav" loop="1">';
      break;
    default :	  
      echo '<body bgcolor="#ffffff"' . $bk . ' text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000">';
      break;
  }
  echo "<center><font size='+2'><b>$myheadder Administration</b></font></center><br>\n";
  echo "<center>Maintain Inventory<br><font size='+2'><b>User: $user_name</b></font></center>" . "\n";
  echo "<center><b><font size='+2'>== $string ==</font></b></center>\n";
  echo '<center>===================</center>' . "\n";
  $mydate = getdate(time());
  echo "<center><b>" . $mydate["month"] . " " . $mydate["mday"] . ", " .$mydate["year"] . "</b></center><br>\n";
  // No Back Button!!!!!
  echo "<script>\n";
  echo "history.forward();\n";
  echo "</script>\n";
  
} // end of mybanner

function NavBar($cgi, $act, $usr_access)
{
// Displays links for navigation in this program
  $d_quote = chr(34);
  echo "<center><table  width='80%' border='1' cellspacing='0' cellpadding='4'>\n";
  if ($usr_access > 50) {
	echo "<tr><td colspan='5'><center>== Main Navigation Controls $usr_access ==</center></td></tr>\n";
	$width = "20%";
  } else {
	echo "<tr><td colspan='4'><center>== Main Navigation Controls $usr_access ==</center></td></tr>\n";
	$width = "25%";
  }
  echo "<td width='$width'><center><a href='$cgi?act=menu'>List or Add Vaccine</a></center></td>\n";
  echo "<td width='$width'><center><a href='$cgi?act=vaccine_list'>List On-Hand</a></center></td>\n";
  echo "<td width='$width'><center><a href='$cgi?act=date_report'>Report by Date Range</a></center></td>\n";
  echo "<td width='$width'><center><a href='$cgi?act=lot_grid'>Lot Number Grid</a></center></td>\n";
  if ($usr_access > 50) {
//	echo "<td width='$width'><center><a href='$cgi?act=trash'>Remove Consume/Destroy History</a></center></td>\n";
  }
//  echo "<td width='25%'><center><a href='$cgi?act=income'>Incoming</a></center></td></tr>\n";

  echo "</table></center>\n";
  if ($usr_access > 50) {
		echo "<br><br><center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
		echo "<tr><td><center><a href='$cgi?act=dumpxl'>Dump All Records to Spreadsheet</a></center></td>";
		echo "<td><center><a href='$cgi?act=dumptxt'>Dump All Records to Text</a></center></td>";
		echo "</tr></table></center>";
  }
  
/*  
   $q = "select count(id) from counter where
act = $d_quote$act$d_quote and cgi = $d_quote$cgi$d_quote";
 //echo "$q<br>";
  $r = mysql_query($q) or die(mysql_error());
  $found = mysql_result($r, 0, 0);
  if ($found > 0) { // We have a counter
    $q = "select id, count from counter where act = $d_quote$act$d_quote and cgi = $d_quote$cgi$d_quote";
    $r = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($r);
    $myid = $row["id"];
    $mycount = $row["count"];
    ++$mycount;
    $q = "update counter set count = $d_quote$mycount$d_quote where id = $d_quote$myid$d_quote";
    $r = mysql_query($q) or die(mysql_error());
  } else {
    $mycount = 1;
    $q = "insert into counter set act = $d_quote$act$d_quote, cgi = $d_quote$cgi$d_quote, count = $d_quote$mycount$d_quote";
    $r = mysql_query($q) or die(mysql_error());
  }
  echo '<br><CENTER><A HREF="http://gnatbox/ccaac/index.php">Main page</A></CENTER>' . "\n";
  // now we have the digits to worry about. note that the text version is commented out
  $dig_array = array("bluesky", "curly", "default", "embwhite", "led", "led_g",
                                  "led_r", "links", "odometer", "plain_b", "pumpkin", "xmas");
  $dig_dir = "/images/digits/" . $dig_array[rand() % 11] . "/";
  $tempString = $mycount;
  $end = strlen($tempString);
  echo "<br><center>";
  //lets get the characters!
  for ($i = 0; $i < $end; $i++) {
    echo "<img src='";
    echo $dig_dir . substr($tempString,$i,1) . ".gif'>";
  }

  echo "</center>";
  echo '<H1 align=right><IMG SRC="/images/php-small-white.gif" ALT="Powered by PHP!"></H1>' . "\n";
echo "</body></html>";

*/
} // end of NavBar

function My_Lister($bio_name, $q, $type)
{
//  $type consumed
      $r = mysql_query($q) or die(mysql_error());
      $max = mysql_num_rows($r);
//	  echo "<br>$q<br>";
      if ($max > 0) {
//	    echo "<hr width='45%' align=center>";
	    echo "<center><table  width='95%' border='1' cellspacing='0' cellpadding='4'>\n";
		echo "<tr bgcolor=#ffffff><td colspan=7><center>$max records found</center></td></tr>";
        if ($type == "received") {
			echo "<tr bgcolor=#ffffff><td>Lot #</td><td>Exp Date</td>
			  <td>Recorded Reveived by</td><td>Date</td><td>Time</td><td>Computer</td><td>Note</td>
			  </tr>";
		} else {
			if ($type == "destroyed") {
				echo "<tr bgcolor=#ffffff><td>Lot #</td><td>Exp Date</td>
				  <td>Recorded Destroyed by</td><td>Date</td><td>Time</td><td>Computer</td><td>Note</td>
				  </tr>";
			} else {
				echo "<tr bgcolor=#ffffff><td>Lot #</td><td>Exp Date</td>
				  <td>Recorded Consumed by</td><td>Date</td><td>Time</td><td>Computer</td><td>Note</td>
				  </tr>";
			 } 
		}
      	$color = 0;
        while ($row = mysql_fetch_array($r)) {
          $color = MeColorTR($color, 1);
		  $lot_num = $row["lot_num"];
		  $exp_date = DosDate($row["exp_date"]);
		  $c_name = $row["c_name"];
		  $c_date = DosDate($row["c_date"]);
//   	      $c_time = str_pad($row["c_time"],5,"0",STR_PAD_LEFT);
   	      $c_time = $row["c_time"];
          $c_ip = $row["c_ip"];
		  $r_name = $row["r_name"];
		  $r_date = DosDate($row["r_date"]);
//   	      $r_time = str_pad($row["r_time"],5,"0",STR_PAD_LEFT);
		  $r_time = $row["r_time"];	
          $r_ip = $row["r_ip"];
   	      $bio_id = $row["bio_id"];
		  $det_id = $row["det_id"];
		  $note = $row["note"];
		  if (strlen($note) < 1) $note = "--";
		  //$computer = $row["computer"];
		  if ($type == "received") {
			  echo "<td>$lot_num</td><td>$exp_date</td><td>$r_name</td>
				<td>$r_date</td><td>$r_time</td><td>$r_ip</td><td>$note</td>";
			  echo "</tr>\n"; 
		  } else {
			  echo "<td>$lot_num</td><td>$exp_date</td><td>$c_name</td>
				<td>$c_date</td><td>$c_time</td><td>$c_ip</td><td>$note</td>";
			  echo "</tr>\n"; 
		  }
        }
      	echo "</table></center><br><br>\n";
      } else {
        echo "<center><font size='+2'><br><font color=#ff0000>ERROR</font><br>There are no consumed $bio_name</font></center><br><br>";
      }
//	  echo "<br><br><center>Done by My_Lister</center><br>";
} // end of My_Lister


function Full_Lister($bio_name, $q)
{
//  $type consumed
      $r = mysql_query($q) or die(mysql_error());
      $max = mysql_num_rows($r);
      if ($max > 0) {
//	    echo "<hr width='45%' align=center>";
	    echo "<center><table  width='95%' border='1' cellspacing='0' cellpadding='4'>\n";
		echo "<tr bgcolor=#ffffff><td colspan=12><center>$max records found</center></td></tr>";
		echo "<tr bgcolor=#ffffff>
		  <td>Consumed Destroyed  or Received</td>
		  <td>Lot #</td><td>Exp Date</td>
		  <td>Recorded Reveived by</td><td>Date</td><td>Time</td><td>Computer</td>
		  <td>Recorded Consumed or Destroyed by</td><td>Date</td><td>Time</td><td>Computer</td>
		  <td>Note</td>
		  </tr>";
      	$color = 0;
        while ($row = mysql_fetch_array($r)) {
          $color = MeColorTR($color, 1);
		  $lot_num = $row["lot_num"];
		  $exp_date = DosDate($row["exp_date"]);
		  $r_name = $row["r_name"];
		  $r_date = DosDate($row["r_date"]);
   	      $r_time = str_pad($row["r_time"],5,"0",STR_PAD_LEFT);
          $r_ip = $row["r_ip"];
		  $c_name = $row["c_name"];
		  if (strlen(trim($c_name)) < 1) $c_name = "--";
		  $c_date = DosDate($row["c_date"]);
		  if ($c_date == "00/00/0000") $c_date = "--";
   	      $c_time = str_pad($row["c_time"],5,"0",STR_PAD_LEFT);
		  if ($c_time == "00000") $c_time = "--";
          $c_ip = $row["c_ip"];
		  if (strlen(trim($c_ip)) < 1) $c_ip = "--";
   	      $bio_id = $row["bio_id"];
		  $det_id = $row["det_id"];
		  $ynd = $row["consumed_ynd"];
		  if ($ynd == "Y") $ynd = "Consumed";
		  if ($ynd == "N") $ynd = "Received";
		  if ($ynd == "D") $ynd = "Destroyed";
		  $note = $row["note"];
		  if (strlen($note) < 1) $note = "--";
		  //$computer = $row["computer"];
		  echo "<td>$ynd</td><td>$lot_num</td><td>$exp_date</td>
		    <td>$r_name</td><td>$r_date</td><td>$r_time</td><td>$r_ip</td>
		    <td>$c_name</td><td>$c_date</td><td>$c_time</td>";
		  if ($c_ip == "--") {
			echo "<td>$c_ip</td>";
          } else {
			echo "<td>$c_ip</td>";
          }		  
		  echo "<td>$note</td>";
		  echo "</tr>\n";
        }
      	echo "</table></center><br><br>\n";
      } else {
        echo "<center><font size='+2'><br><font color=#ff0000>ERROR</font><br>There are no consumed $bio_name</font></center><br><br>";
      }
//	  echo "<br><br><center>Done by Full_Lister</center><br>";
} // end of Full_Lister

function My_xls_dump($q)
{
	$r = mysql_query($q) or die(mysql_error());
	echo "<table>";
	echo "<tr><td>Vaccine</td><td>Man</td><td>Consumed Destroyed  or Received</td>
		  <td>Lot #</td><td>Exp Date</td>
		  <td>Recorded Reveived by</td><td>Date</td><td>Time</td><td>Computer</td>
		  <td>Recorded Consumed or Destroyed by</td><td>Date</td><td>Time</td><td>Computer</td>
		  <td>Notes</td></tr>";
	while ($row = mysql_fetch_array($r)) {
		$vac_name = $row["bio_name"];
		$man_name = $row["man_name"];
		$lot_num = $row["lot_num"];
		$exp_date = DosDate($row["exp_date"]);
		$r_name = $row["r_name"];
		$r_date = DosDate($row["r_date"]);
		$r_time = str_pad($row["r_time"],5,"0",STR_PAD_LEFT);
		$r_ip = $row["r_ip"];
		$c_name = $row["c_name"];
		if (strlen(trim($c_name)) < 1) $c_name = "--";
		$c_date = DosDate($row["c_date"]);
		if ($c_date == "00/00/0000") $c_date = "--";
		$c_time = str_pad($row["c_time"],5,"0",STR_PAD_LEFT);
		if ($c_time == "00000") $c_time = "--";
		$c_ip = $row["c_ip"];
		if (strlen(trim($c_ip)) < 1) $c_ip = "--";
		$bio_id = $row["bio_id"];
		$det_id = $row["det_id"];
		$ynd = $row["consumed_ynd"];
		if ($ynd == "Y") $ynd = "Consumed";
		if ($ynd == "N") $ynd = "Received";
		if ($ynd == "D") $ynd = "Destroyed";
		$note = $row["note"];
		if (strlen($note) < 1) $note = "--";
		//$computer = $row["computer"];
		echo "<td>$vac_name</td><td>$man_name</td><td>$ynd</td><td>$lot_num</td><td>$exp_date</td>
		<td>$r_name</td><td>$r_date</td><td>$r_time</td><td>$r_ip</td>
		<td>$c_name</td><td>$c_date</td><td>$c_time</td>";
		echo "<td>$c_ip</td>";
		echo "<td>$note</td>";
		echo "</tr>\n";
	}
	echo "</table>";
} // end of My_xls_dump

function My_txt_dump($q)
{
	$crlf = chr(13) . chr(10);
	$d_quote = chr(34);
	$tab = chr(9);
	$r = mysql_query($q) or die(mysql_error());
	echo str_pad("Vaccine",32) . $tab;
	echo str_pad("Man",32) . $tab;
	echo str_pad("Consumed Destroyed  or Received",31) . $tab;
	echo str_pad("Lot #",80) . $tab;
	echo str_pad("Exp Date",10) . $tab;
	echo str_pad("Recorded Reveived by", 30) . $tab;
	echo str_pad("Date", 10) . $tab;
	echo str_pad("Time", 5) . $tab;
	echo str_pad("Computer IP", 15) . $tab;
	echo str_pad("Recorded Consumed or Destroyed by", 30) . $tab;
	echo str_pad("Date", 10) . $tab;
	echo str_pad("Time", 5) . $tab;
	echo str_pad("Computer IP", 15) . $tab;
	echo str_pad("Comment", 132) . $tab;
	echo $crlf;
	while ($row = mysql_fetch_array($r)) {
		$vac_name = $row["bio_name"];
		$man_name = $row["man_name"];
		$lot_num = $row["lot_num"];
		$exp_date = DosDate($row["exp_date"]);
		$r_name = $row["r_name"];
		$r_date = DosDate($row["r_date"]);
		$r_time = str_pad($row["r_time"],5,"0",STR_PAD_LEFT);
		$r_ip = $row["r_ip"];
		$c_name = $row["c_name"];
		if (strlen(trim($c_name)) < 1) $c_name = "--";
		$c_date = DosDate($row["c_date"]);
		if ($c_date == "00/00/0000") $c_date = "--";
		$c_time = str_pad($row["c_time"],5,"0",STR_PAD_LEFT);
		if ($c_time == "00000") $c_time = "--";
		$c_ip = $row["c_ip"];
		if (strlen(trim($c_ip)) < 1) $c_ip = "--";
		$bio_id = $row["bio_id"];
		$det_id = $row["det_id"];
		$ynd = $row["consumed_ynd"];
		if ($ynd == "Y") $ynd = "Consumed";
		if ($ynd == "N") $ynd = "Received";
		if ($ynd == "D") $ynd = "Destroyed";
		$note = $row["note"];
		if (strlen($note) < 1) $note = "--";
		//$computer = $row["computer"];
		echo str_pad($vac_name,32) . $tab;
		echo str_pad($man_name,32) . $tab;
		echo str_pad($ynd,31) . $tab;
		echo str_pad($lot_num,80) . $tab;
		echo str_pad($exp_date,10) . $tab;
		echo str_pad($r_name, 30) . $tab;
		echo str_pad($r_date, 10) . $tab;
		echo str_pad($r_time, 5) . $tab;
		echo str_pad($r_ip, 15) . $tab;
		echo str_pad($c_name, 30) . $tab;
		echo str_pad($c_date, 10) . $tab;
		echo str_pad($c_time, 5) . $tab;
		echo str_pad($c_ip, 15) . $tab;
		echo str_pad($note, 132) . $tab;
		echo $crlf;
	}
} // end of My_txt_dump




// ---------------- End of Functions
// ---------------
// ---------------
// ---------------- Start of Code

$mydbf = "vaccine";
mysql_select_db("$mydbf") or die("unable to access database");    
$red = "<font color='#FF0000'>";
$pink = "<font color='#FF00FF'>";
$orange = "<font color='FF8040'>";
$yellow = "<font color='#FFFF00'>";
$black = "<font color='#000000'>";
$green = "<font color='#00FF00'>";
//$green = $pink;
$colorsafe = 60;
$colorwarn = 30;

if ($act == "") {
//	echo "act was blank!!<br>";
	$act = "menu";
}	
//$act="menu";
if ($act == "Please Change Me") {
   print ("<center><b><font size='+2'>*** ERROR ***</font></b></center>");
  print ("<center><b><font size='+2'>This page <u>MUST</u> be called from a menu</font></b></center>");
  }
else
{

  if ($act == "menu") $act = "mix";
  switch ($act) {
    case "menu":
      // Main menu
	  // force to mix
      mybanner("Main Menu", "none", $user_name);
      NavBar($cgi, $act, $usr_access);
    break;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// MemoChange
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "memo_change":
      // Edit/Show memo
      mybanner("Notes for Vaccine $name", "none", $user_name);
	  if ($usr_access > 50) {
		  $state_memo = FixMyString($mynotes);
		  $q = "update $bio_table set comm_memo = $d_quote$state_memo$d_quote where id = $d_quote$bio_id$d_quote";
		  $r = mysql_query($q) or die(mysql_error());
		  echo "<br><center>Memo has been changed</center><br><br>";
	  } else {
		echo "<br><br><center>You are not allowed access!</center>";
	  }
	  echo "<br><br>";
      NavBar($cgi, $act, $usr_access);
    break;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// My Memo
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "my_memo":
      // Edit/Show memo
	  mybanner("Notes for Vaccine $name", "none", $user_name);
	  if ($usr_access > 50) {
		  $q = "select * from $bio_table where id = $d_quote$bio_id$d_quote";
		  $r = mysql_query($q) or die(mysql_error());
		  $row = mysql_fetch_array($r);
		  $name = $row["name"];
		  $state_memo = $row["state_memo"];
		  $comm_memo = $row["comm_memo"];
		  echo "<br><center><font size='+2'>Edit Vaccine Memo for<br>$name</font></center><br>\n";
		  echo "<br><br>";
		  echo "<center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='memo_change'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<textarea name='mynotes' rows='6' cols='75'>\n";
		  echo "$comm_memo";
		  echo "</textarea>\n";
		  echo "<br><br><center><input type='submit' value='Change'>\n";
		  echo "<input type='reset' value='Undo'></form></center>\n";
	  } else {
		echo "<br><br><center>You are not allowed access!</center>";
	  }
	  echo "<br><br>";
      NavBar($cgi, $act, $usr_access);
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// mix * ok 
// Main Menu
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "mix":
      // Select injectable
      mybanner("Vaccine Selection", "none", $user_name);
      echo "<br><center><font size='+2'>Select Vaccine to List</font></center><br>\n";
      // passed NADA
      $q = "select * from $bio_table order by name";
      $r = mysql_query($q) or die(mysql_error());
      if (mysql_num_rows($r) > 0) {
        echo "<center><table  width='75%' border='1' cellspacing='0' cellpadding='4'>\n";
        echo "<tr><td><center>Name</center></td>";
        echo "<td colspan = '3'><center>State<br>In Stock | Consumed | Destroyed</center></td>
		  <td colspan = '3'><center>Commercial<br>In Stock | Consumed | Destroyed</center></td>
		  </tr>\n";
      	$color = 0;
        while ($row = mysql_fetch_array($r)) {
	      $form_txt = "<form action='$cgi' method='post'>
		    <input type='hidden' name='act' value='%%var1%%'>
	        <input type='hidden' name='bio_id' value='%%bio_id%%'>
	        <input type='hidden' name='stock_type' value='%%stock_type%%'>
            <input type='submit' value=%%value%%>
	        </form>";
      	  $bio_id = $row["id"];
          $name = $row["name"];
		  
		  $state_memo = $row["state_memo"];
		  $comm_memo = $row["comm_memo"];
		  
	      $temp = $form_txt;
	      $temp = str_replace('%%name%%', $name, $temp);
	      $temp = str_replace('%%bio_id%%', $bio_id, $temp);
		  $form_txt = $temp;
		  $q_instock_public_commercial = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'N' and stock_type = 'P'";
		  $q_instock_state_owned = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'N' and stock_type = 'S'";
		  $q_consumed_public_commercial = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'Y' and stock_type = 'P'";
		  $q_consumed_state_owned = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'Y' and stock_type = 'S'";
		  $q_deleted_public_commercial = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'D' and stock_type = 'P'";
		  $q_deleted_state_owned = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'D' and stock_type = 'S'";

		  $r_instock_public_commercial = mysql_query($q_instock_public_commercial) or die(mysql_error());
		  $r_instock_state_owned = mysql_query($q_instock_state_owned) or die(mysql_error());
		  $r_consumed_public_commercial = mysql_query($q_consumed_public_commercial) or die(mysql_error());
		  $r_consumed_state_owned = mysql_query($q_consumed_state_owned) or die(mysql_error());
		  $r_deleted_public_commercial = mysql_query($q_deleted_public_commercial) or die(mysql_error());
		  $r_deleted_state_owned = mysql_query($q_deleted_state_owned) or die(mysql_error());
		  
		  $row_instock_public_commercial = mysql_fetch_array($r_instock_public_commercial);
		  $row_instock_state_owned = mysql_fetch_array($r_instock_state_owned);
		  $row_consumed_public_commercial = mysql_fetch_array($r_consumed_public_commercial);
		  $row_consumed_state_owned = mysql_fetch_array($r_consumed_state_owned);
		  $row_deleted_public_commercial = mysql_fetch_array($r_deleted_public_commercial);
		  $row_deleted_state_owned = mysql_fetch_array($r_deleted_state_owned);
		  
		  $mycount_instock_public_commercial = $row_instock_public_commercial["mycount"];
		  $mycount_instock_state_owned = $row_instock_state_owned["mycount"];
		  $mycount_consumed_public_commercial = $row_consumed_public_commercial["mycount"];
		  $mycount_consumed_state_owned = $row_consumed_state_owned["mycount"];
		  $mycount_deleted_public_commercial = $row_deleted_public_commercial["mycount"];
		  $mycount_deleted_state_owned = $row_deleted_state_owned["mycount"];
		  
      	  $color = MeColorTR($color, 1);
          //echo "<td><center><a href='$cgi?act=order&bio_id=$bio_id'>$name</a><center></td>";
		  echo "<td><center>";
		  if ($usr_access > 50) {
			  echo "<form action='$cgi' method='post'>";
			  echo "<input type='hidden' name='act' value='my_memo'>";
			  echo "<input type='hidden' name='bio_id' value='$bio_id'>";

			  echo "<img src='info.gif' title=$d_quote$comm_memo$d_quote>&nbsp;";

			  echo "<input type='submit' value='$name'>";
			  echo "</form>";
		  } else {
			echo "<img src='info.gif' title=$d_quote$comm_memo$d_quote>&nbsp;$name";
		  }
		  
		  echo "<center></td>";
// State -> In Stock | Consumed | Destroyed
// State -> In Stock
	      $temp = $form_txt; // reset form data
	      if ($mycount_instock_state_owned > 0) 
		  {
	        $temp = str_replace('%%var1%%', 'stock_list', $temp);
	        $temp = str_replace('%%value%%', $mycount_instock_state_owned, $temp);
	        $temp = str_replace('%%stock_type%%', 'S', $temp);
            echo "<td><center>$temp</center></td>";
		  } else {
		    echo "<td><center>0</center></td>";
		  }

// State -> Consumed
	      $temp = $form_txt; // reset form data
	      if ($mycount_consumed_state_owned > 0) 
		  {
	        $temp = str_replace('%%var1%%', 'consumed_list', $temp);
	        $temp = str_replace('%%value%%', $mycount_consumed_state_owned, $temp);
	        $temp = str_replace('%%stock_type%%', 'S', $temp);
            echo "<td><center>$temp</center></td>";
		  } else {
		    echo "<td><center>0</center></td>";
		  }

// State -> Destroyed
	      $temp = $form_txt; // reset form data
	      if ($mycount_deleted_state_owned > 0) 
		  {
	        $temp = str_replace('%%var1%%', 'destroyed_list', $temp);
	        $temp = str_replace('%%value%%', $mycount_deleted_state_owned, $temp);
	        $temp = str_replace('%%stock_type%%', 'S', $temp);
            echo "<td><center>$temp</center></td>";
		  } else {
			echo "<td><center>0</center></td>";
		  }

// Commercial -> In Stock | Consumed | Destroyed
// Commercial -> In Stock
	      $temp = $form_txt; // reset form data
	      if ($mycount_instock_public_commercial > 0) 
		  {
	        $temp = str_replace('%%var1%%', 'stock_list', $temp);
	        $temp = str_replace('%%value%%', $mycount_instock_public_commercial, $temp);
	        $temp = str_replace('%%stock_type%%', 'P', $temp);
            echo "<td><center>$temp</center></td>";
		  } else {
		    echo "<td><center>0</center></td>";
		  }

// Commercial -> Consumed
	      $temp = $form_txt; // reset form data
	      if ($mycount_consumed_public_commercial > 0) 
		  {
	        $temp = str_replace('%%var1%%', 'consumed_list', $temp);
	        $temp = str_replace('%%value%%', $mycount_consumed_public_commercial, $temp);
	        $temp = str_replace('%%stock_type%%', 'P', $temp);
            echo "<td><center>$temp</center></td>";
		  } else {
		    echo "<td><center>0</center></td>";
		  }

// Commercial -> Destroyed
	      $temp = $form_txt; // reset form data
	      if ($mycount_deleted_public_commercial > 0) 
		  {
	        $temp = str_replace('%%var1%%', 'destroyed_list', $temp);
	        $temp = str_replace('%%value%%', $mycount_deleted_public_commercial, $temp);
	        $temp = str_replace('%%stock_type%%', 'P', $temp);
            echo "<td><center>$temp</center></td>";
		  } else {
			echo "<td><center>0</center></td>";
		  }
          echo "</tr>\n"; // End of Table Row
      	}
      	echo "</table></center><br><br>";
		
      } else {
        echo "<center><font size='+2'><br><font color=#ff0000>ERROR</font><br>Appears that there are no Vaccines in the Database<br>Press back and try again</font></center><br><br>";
      }
	  echo "<center><a href='$cgi?act=stock_add'>Add new Stock</a></center><br>";
      NavBar($cgi, $act, $usr_access);
    break;
	// end of mix

	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//stock & stock_list * ok but cargo not tested
// from Mix (Main Menu) selecting In Stock
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    case "stock_list":
      // bio_name, id, and stock_type is Passed
	  // if cargo = destroy or cargo = consume... need to mark that entry, then do the listing again
	  $stock_type_desc = "Commercial";
	  if ($stock_type == 'S') $stock_type_desc = "State Sponsored";
      mybanner("Listing of $stock_type_desc, <u>ON HAND</u> $bio_name", "none", $user_name);
      // Process the Mul check out as well as the single line 
      $q = "select a.exp_date as exp_date, a.lot_num as lot_num, a.r_name as r_name, 
	    a.r_date as r_date, a.r_time as r_time, a.r_ip as r_ip, 
		a.biological_id as bio_id, a.id as det_id, datediff( a.exp_date, now() ) as exp
	    from $mytable a
        where a.consumed_ynd = 'N' 
		and a.biological_id = $d_quote$bio_id$d_quote
		and stock_type = $d_quote$stock_type$d_quote
        order by a.exp_date, a.lot_num";
      //echo "<br>$q<br>";
      $r = mysql_query($q) or die(mysql_error());
      $max = mysql_num_rows($r);
      if ($max > 0) {
//	    echo "<hr width='45%' align=center>";
	    echo "<center><table  width='95%' border='1' cellspacing='0' cellpadding='4'>\n";
		echo "<tr bgcolor=#ffffff><td colspan=9><center>$max records found</center></td></tr>";
      	echo "<tr bgcolor=#ffffff><td>Lot #</td><td>Exp Date</td><td>Exp in</td>
		  <td>Recieved by</td><td>Date</td><td>Time</td><td>Computer</td>
		  <td colspan=2><center>Consume | Destroy</center></td></tr>";
      	$color = 0;
        while ($row = mysql_fetch_array($r)) {
          $color = MeColorTR($color, 1);
		  $lot_num = $row["lot_num"];
		  $exp_date = DosDate($row["exp_date"]);
		  $exp = $row["exp"];
		  $colorexp = "<font color='FFFF00'>"; // Yellow
		  if ($exp > $colorsafe) $colorexp = $black;
		  if ($exp < $colorwarn) {
		    $colorexp = $red;
			if ($exp > -1)  $colorexp = $green;
		  }	
		  $r_name = $row["r_name"];
		  $r_date = DosDate($row["r_date"]);
   	      $r_time = str_pad($row["r_time"],5,"0",STR_PAD_LEFT);
          $r_ip = $row["r_ip"];
   	      $bio_id = $row["bio_id"];
		  $det_id = $row["det_id"];
		  //$computer = $row["computer"];
          echo "<td>$lot_num</td><td>$exp_date</td>
		    <td>$colorexp$exp</font></td>
			<td>$r_name</td><td>$r_date</td><td>$r_time</td><td>$r_ip</td>";
   	      echo "<td><a href='$cgi?act=get_note&det_id=$det_id&bio_id=$bio_id&bio_name=$bio_name&cargo=consume'>Consume</a></td>
		    <td><a href='$cgi?act=get_note&det_id=$det_id&bio_id=$bio_id&bio_name=$bio_name&cargo=destroy'>Destroy</a></td>";
          echo "</tr>\n";
        }
      	echo "</table></center><br><br>\n";
		if ($usr_access > 50) {
		  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
		  echo "<tr>";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='xls'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<input type='hidden' name='bio_name' value='$bio_name'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='instock'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
		  echo "</form></center></td>\n";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='txt'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<input type='hidden' name='bio_name' value='$bio_name'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='instock'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
		  echo "</form></center></td>\n";
		  echo "</tr></table></center><br><br>\n";
		}
	  } else {
        echo "<center><font size='+2'><br><font color=#ff0000>ERROR</font><br>There is no $bio_name vaccines on hand<br>Please Select a different Vaccine<br>ICN# $det_id</font></center><br><br>";
      }
      NavBar($cgi, $act, $usr_access);
    break;
	// end of stock_list

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//consumed_list * ok
// From Mix (Main Menu) selecting Consumed
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    case "consumed_list":
      // bio_name, id, $stock_type is Passed
	  $stock_type_desc = "Commercial";
	  if ($stock_type == 'S') $stock_type_desc = "State Sponsored";
      mybanner("Listing of $stock_type_desc, <u>CONSUMED</u> $bio_name", "none", $user_name);
      $q = "select a.exp_date as exp_date, a.lot_num as lot_num, a.c_name as c_name, 
	    a.c_date as c_date, a.c_time as c_time, a.c_ip as c_ip,
		a.biological_id as bio_id, a.id as det_id, a.note as note
	    from $mydbf.$mytable a
        where a.consumed_ynd = 'Y' 
		and a.biological_id = $d_quote$bio_id$d_quote
        order by a.c_date ASC, a.c_time ASC";
	  //echo "<br>$q<br>";
	  My_Lister($bio_name, $q, "consumed");
	  if ($usr_access > 50) {
		  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
		  echo "<tr>";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='xls'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<input type='hidden' name='bio_name' value='$bio_name'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='Y'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
		  echo "</form></center></td>\n";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='txt'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<input type='hidden' name='bio_name' value='$bio_name'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='Y'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
		  echo "</form></center></td>\n";
		  echo "</tr></table></center><br><br>\n";
	  }
     NavBar($cgi, $act, $usr_access);
    break;
	// end of consumed_list

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//destroyed_list * ok
// From Mix (Main Menu) selecting Destroyed
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    case "destroyed_list":
		// bio_name, id, $stock_type is Passed
		// if cargo = destroy or cargo = consume... need to mark that entry, then do the listing again
		// Process the Mul check out as well as the single line
		$stock_type_desc = "Commercial";
		if ($stock_type == 'S') $stock_type_desc = "State Sponsored";
		mybanner("Listing of $stock_type_desc, <u>DESTROYED</u> $bio_name", "none", $user_name);
		$q = "select a.exp_date as exp_date, a.lot_num as lot_num, a.c_name as c_name, 
		a.c_date as c_date, a.c_time as c_time, a.c_ip as c_ip, 
		a.biological_id as bio_id, a.id as det_id, a.note as note
		from $mydbf.$mytable a
		where a.consumed_ynd = 'D' 
		and a.biological_id = $d_quote$bio_id$d_quote
		order by a.c_date ASC, a.c_time ASC";
		 //echo "<br>$q<br>";
		 My_Lister($bio_name, $q, "destroyed");
		if ($usr_access > 50) {
		  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
		  echo "<tr>";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='xls'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<input type='hidden' name='bio_name' value='$bio_name'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='D'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
		  echo "</form></center></td>\n";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='txt'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<input type='hidden' name='bio_name' value='$bio_name'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='D'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
		  echo "</form></center></td>\n";
		  echo "</tr></table></center><br><br>\n";
		}
      NavBar($cgi, $act, $usr_access);
    break;
	// end of Destroyed_list

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// stock_validate * ok
// From Navagation selecting List on Hand
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "stock_validate":
	  // Passed qty, stock_type, bio_id, exp_date, lot_num, r_name
	  mybanner("Validate the addition of Shots to Inventory", "none", $user_name);
	  $qty = FixMyString($qty);
	  //$bio_id = FixMyString($bio_id);
	  $exp_date = FixMyString($exp_date);
	  $lot_num= FixMyString($lot_num);
	  $r_name = FixMyString($r_name);
	  $mydate = getdate(time());
//echo "<br>mydate = $mydate<br>";	  
	  $r_date = $mydate["year"] . "-" . $mydate["mon"] . "-" . $mydate["mday"];
//echo "<br>mydate = $r_date<br>";	  
	  $r_time = format_time($mydate);
	  // need to make sure that 9:00 becomes 09:00
	  // otherwise the sorts will not work
//      $r_time = str_pad($r_time,5,"0",STR_PAD_LEFT);
	  $r_ip = $REMOTE_ADDR;
	  //$r_name = $PHP_AUTH_USER;
	  $errString = "";
	  $errString .= ValadateInput($qty, "num", "Quantity");
	  if ($qty == 0) $errString .= "<center>Quantity cannot be Zero!</center>";
	  $errString .= ValadateInput($exp_date, "date", "Expiration Date");
	  $errString .= ValadateInput($lot_num, "name", "Lot Number");
	  $errString .= ValadateInput($r_name, "name", "Receiver Name");
	  //$r_date = LinuxDate($r_date);
	  $exp_date = LinuxDate($exp_date);
	  if (strlen($errString) < 5) {
        for ($i = 1; $i <= $qty; $i++) 
		{
		  $q = "insert into $mytable set 
		    biological_id = $d_quote$bio_id$d_quote,
			stock_type = $d_quote$stock_type$d_quote,
			man_id =  $d_quote$man_id$d_quote,
			exp_date = $d_quote$exp_date$d_quote,
			lot_num = $d_quote$lot_num$d_quote,
			r_name = $d_quote$r_name$d_quote,
			r_date = $d_quote$r_date$d_quote,
			r_time = $d_quote$r_time$d_quote,
			r_ip = $d_quote$r_ip$d_quote,
			consumed_ynd = 'N'";
		  $r = mysql_query($q) or die(mysql_error());
		  //echo "<br>$i $q<br>";
		}
		$comment = "You have added $qty Shots into Inventory!";
		SendEmail($comment, $bio_table, $detail_table, $email_table);
	    echo "<br><center><font size='+1'>$comment</font></center><br>\n";
	  } else {
	    echo "<center><font size='+2'><br><font color=#ff0000>ERROR</font><br>$errString</font><br>Press back and try again</center><br><br>";
	  }  
      NavBar($cgi, $act, $usr_access);
    break;
	// end of stock_validate
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stock Add * ok
// From Main Menu - "Add New Stock"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "stock_add":
	  // Add inventory to b_detail
	  mybanner("Add Shots to Inventory", "none", $user_name);
	  echo "<center><font size='+2'>You are about to add new stock to inventory</font><br></center><br><br>\n";
   	  echo "<center><font size='+1'>Please enter the following information</font></center>\n";
	  echo "<hr width='25%' align=center>\n";
      $mydate = getdate(time());
	  $r_date = $mydate["year"] . "-" . $mydate["mon"] . "-" . $mydate["mday"];
	  $today =  $mydate["mon"] . "/" . $mydate["mday"] . "/" . $mydate["year"];
	  $r_time = format_time($mydate);
//      $r_time = str_pad($r_time,5,"0",STR_PAD_LEFT);
      $r_ip = $REMOTE_ADDR;
	  echo "<center><form action='$cgi' method='post'>\n";
      echo "<input type='hidden' name='act' value='stock_validate'>\n";
	  echo "<br>Qty to add: <input type='text' name='qty' maxlength='2' size='2' value='1'><br>\n";
	  echo "<br>Ownership: <select name='stock_type'>\n";
	  echo "<option value='P'>Privately Owned</option>\n";
	  echo "<option value='S'>State Owned</option>\n";
	  echo "</select><br>\n";
	  echo "Vaccine: <select name='bio_id'>\n";
	  $q = "select * from $bio_table order by name";
	  $r = mysql_query($q) or die(mysql_error());
	  while ($row = mysql_fetch_array($r)) 
	  {
		$name = $row["name"];
		$id = $row["id"];
		echo "<option value=$id>$name</option>\n";
      }
	  echo "</select><br>\n\n";
	  echo "Manufacturer: <select name='man_id'>\n";
	  $q = "select * from $man_table order by name";
	  $r = mysql_query($q) or die(mysql_error());
	  while ($row = mysql_fetch_array($r)) 
	  {
		$name = $row["name"];
		$id = $row["id"];
		echo "<option value=$id>$name</option>\n";
      }
	  echo "</select><br>\n\n";
	  echo "Expiration Date: <input type='text' name='exp_date' maxlength='10' size='10' value = '$today'> (mm/dd/yyyy)<br>\n";
	  echo "Lot #: <input type='text' name='lot_num' maxlength='80'><br>\n";
	  echo "<font size='+3'><b>Who Received: $user_name</b></font><br>\n";
      echo "<input type='hidden' name='r_name' value='$user_name'>\n";
	  echo "<br><input type='submit' value='Record new stock'>\n";
	  echo "</form></center>\n";
      NavBar($cgi, $act, $usr_access);
	break;
	// end of stock_add
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//vaccine_list * ok
// From Navigation "On Hand" in Module Expire
// Handles expire and consume Links
// From Navagation selecting List on Hand
// Need to make a deture for the consume and delete so a "note" can be entered.
// The "note" needs to be ran through the validation to prevent SQL injection
// Have this module accept info for Create or destroy, so it can be handled (Introduce by banner) properly
// After collection of the "note", return here for processing so they return to the  expire screen
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "vaccine_list":
	  // if cargo = destroy or cargo = consume... need to mark that entry, then do the listing again
//      mybanner("Total listing of <u>On-Hand</u> by vaccine then in order of expiration Date", "none", $PHP_AUTH_USER);
//      $q = "select a.exp_date, a.lot_num, a.r_name, 
//	    a.r_date, a.r_time, a.r_ip, b.name as bio_name,c.name as man_name,
//		a.biological_id as bio_id, a.id as det_id,
//		datediff( a.exp_date, now() ) as exp
//	    from $mydbf.$mytable a, $bio_table b, $man_table c
//        where a.consumed_ynd = 'N' and b.id = a.biological_id and a.man_id = c.id
//        order by bio_name, exp_date";
      mybanner("Total listing of <u>On-Hand</u> in order of expiration Date", "none", $user_name);
      $q = "select a.exp_date, a.lot_num, a.r_name, 
	    a.r_date, a.r_time, a.r_ip, b.name as bio_name,c.name as man_name,
		a.biological_id as bio_id, a.id as det_id,
		datediff( a.exp_date, now() ) as exp
	    from $mydbf.$mytable a, $bio_table b, $man_table c
        where a.consumed_ynd = 'N' and b.id = a.biological_id and a.man_id = c.id
        order by exp_date";
	  //echo "<br>$q<br>";
      $r = mysql_query($q) or die(mysql_error());
      $max = mysql_num_rows($r);
      if ($max > 0) {
//	    echo "<hr width='45%' align=center>";
	    echo "<center><table  width='95%' border='1' cellspacing='0' cellpadding='4'>\n";
		echo "<tr bgcolor=#ffffff><td colspan=11><center>$max records found</center></td></tr>";
      	echo "<tr bgcolor=#ffffff><td>Vaccine</td><td>Man</td><td>Lot #</td><td>Exp Date</td><td>Exp in</td>
		  <td>Received by</td><td>Date</td><td>Time</td><td>Computer</td>
		  <td colspan=2><center>Consume | Destroy</center></td></tr>";
      	$color = 0;
        while ($row = mysql_fetch_array($r)) {
          $color = MeColorTR($color, 1);
		  $lot_num = $row["lot_num"];
		  $exp_date = DosDate($row["exp_date"]);
		  $exp = $row["exp"];
		  $man_name = $row["man_name"];
		  $colorexp = "<font color='FFFF00'>"; // Yellow
		  if ($exp > $colorsafe) $colorexp = $black;
		  if ($exp < $colorwarn) {
		    $colorexp = $red;
			if ($exp > -1)  $colorexp = $green;
		  }	
		  $r_name = $row["r_name"];
		  $r_date = DosDate($row["r_date"]);
   	      $r_time = str_pad($row["r_time"],5,"0",STR_PAD_LEFT);
          $r_ip = $row["r_ip"];
   	      $bio_id = $row["bio_id"];
		  $bio_name = $row["bio_name"];
		  $det_id = $row["det_id"];
		  //$computer = $row["computer"];
          echo "<td>$bio_name</td><td>$man_name</td><td>$lot_num</td><td>$exp_date</td><td>$colorexp$exp</font></td><td>$r_name</td>
		    <td>$r_date</td><td>$r_time</td><td>$r_ip</td>";
   	      echo "<td><a href='$cgi?act=get_note&det_id=$det_id&bio_id=$bio_id&bio_name=$bio_name&cargo=consume'>Consume</a></td>
		    <td><a href='$cgi?act=get_note&det_id=$det_id&bio_id=$bio_id&bio_name=$bio_name&cargo=destroy'>Destroy</a></td>";
          echo "</tr>\n";
        }
      	echo "</table></center><br><br>\n";
		if ($usr_access > 50) {
		  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
		  echo "<tr>";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='xls'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='instock'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
		  echo "</form></center></td>\n";
		  echo "<td><center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='mul_dump'>\n";
		  echo "<input type='hidden' name='type' value='txt'>\n";
		  echo "<input type='hidden' name='consumed_ynd' value='instock'>\n";
		  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
		  echo "</form></center></td>\n";
		  echo "</tr></table></center><br><br>\n";
		}
      } else {
        echo "<center><font size='+2'><br><font color=#ff0000>ERROR</font><br>There are no Vaccines On Hand</font></center><br><br>";
      }
      NavBar($cgi, $act, $usr_access);
    break;
	// end of vaccine_list
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Date Report
// From Navigation "Report by Date Range"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "date_report":
	  // Report Usage by date/Date range
//	  echo "<center><font size='+2'>I as still working on this!</font><br></center><br><br>\n";
//	  echo "<hr width='25%' align=center>\n";
// Very carefull here. Colm says received and must include items that may be consumed or destroyed.
//    For received, you must only apply the date on the received column, not just the consumed_ynd flag
      $mydate = getdate(time());
	  $r_date = $mydate["year"] . "-" . $mydate["mon"] . "-" . $mydate["mday"];
	  $today =  $mydate["mon"] . "/" . $mydate["mday"] . "/" . $mydate["year"];
	  $r_time = format_time($mydate);
//      $r_time = str_pad($r_time,5,"0",STR_PAD_LEFT);
      $r_ip = $REMOTE_ADDR;
	  $c_date = $mydate["year"] . "-" . $mydate["mon"] . "-" . $mydate["mday"];
	  $c_time = format_time($mydate);
//      $c_time = str_pad($c_time,5,"0",STR_PAD_LEFT);
      $c_ip = $REMOTE_ADDR;
	  if (isset($cargo))
	  {
	    if ($cargo == "got_date") 
		{
		  // Need to do a sanity check on the dates
		  $err_str = ValadateInput($s_date, "date", "Start Date");
		  $err_str = $err_str . ValadateInput($e_date, "date", "End Date");
		  
// next need to make sure that the start date is less than the beginning date		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  if (strlen($err_str) > 5) {
		    mybanner("ERROR", "none", $user_name);
			echo $err_str;
			echo "<br><center><font size=+2>Try Again</font></center><br>";
		  } else {
            mybanner("Usage Report $s_date to $e_date", "none", $user_name);
			$q = "select * from $bio_table order by name";
			$r = mysql_query($q) or die(mysql_error());
			$s_date = LinuxDate($s_date);
			$e_date = LinuxDate($e_date);

			echo "<center><table  width='75%' border='1' cellspacing='0' cellpadding='4'>\n";
			echo "<tr><td><center>Name</center></td>";
			echo "<td><center>Received</center></td>
			  <td><center>Consumed</center></td>
			  <td><center>Destroyed</center></td>
			  </tr>\n";
			$color = 0;
			$form_txt = "<form action='$cgi' method='post'>
					<input type='hidden' name='act' value='%%var1%%'>
						<input type='hidden' name='bio_id' value='%%bio_id%%'>
					<input type='hidden' name='vac_name' value='%%name%%'>
					<input type='hidden' name='s_date' value='$s_date'>
					<input type='hidden' name='e_date' value='$e_date'>
						<input type='submit' value=%%value%%>
					</form>";
			 if (mysql_num_rows($r) > 0) {
			  while ($row = mysql_fetch_array($r)) {
			    $bio_id = $row["id"];
				$name = $row["name"];
//				$q2 = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'N'
//					and r_date >= $d_quote$s_date$d_quote and r_date <= $d_quote$e_date$d_quote";
				$q2 = "select count(*) as mycount from $mytable where biological_id = '$bio_id'
					and r_date >= $d_quote$s_date$d_quote and r_date <= $d_quote$e_date$d_quote";
				$qy = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'Y'
					and c_date >= $d_quote$s_date$d_quote and c_date <= $d_quote$e_date$d_quote";
				$qd = "select count(*) as mycount from $mytable where biological_id = '$bio_id' and consumed_ynd = 'D'
					and c_date >= $d_quote$s_date$d_quote and c_date <= $d_quote$e_date$d_quote";
				$r2 = mysql_query($q2) or die(mysql_error());
				$ry = mysql_query($qy) or die(mysql_error());
				$rd = mysql_query($qd) or die(mysql_error());
				$row2 = mysql_fetch_array($r2);
				$rowy = mysql_fetch_array($ry);
				$rowd = mysql_fetch_array($rd);
				$mycount1 = $row2["mycount"];
				$mycounty = $rowy["mycount"];
				$mycountd = $rowd["mycount"];
				$temp = $form_txt;
				$color = MeColorTR($color, 1);
				// Echo link for the Vaccine name
				if (($mycount1 + $mycounty + $mycountd) > 0) {
					$temp = str_replace('%%var1%%', 'date_vac_list', $temp);
					$temp = str_replace('%%value%%', $name, $temp);
					$temp = str_replace('%%bio_id%%', $bio_id, $temp);
					$temp = str_replace('%%name%%', $name, $temp);
					echo "<td><center>$temp</center></td>";
				} else {
					echo "<td><center>$name</center></td>";
				}
				$temp = $form_txt;
				if ($mycount1 > 0) {
				  $temp = str_replace('%%var1%%', 'one_received_list', $temp);
				  $temp = str_replace('%%value%%', $mycount1, $temp);
				  $temp = str_replace('%%bio_id%%', $bio_id, $temp);
				  $temp = str_replace('%%name%%', $name, $temp);
				  echo "<td><center>$temp</center></td>";
				} else {
				  echo "<td><center>0</center></td>";
				}
				$temp = $form_txt;
				if ($mycounty > 0) {
				  $temp = str_replace('%%var1%%', 'one_consumed_list', $temp);
				  $temp = str_replace('%%value%%', $mycounty, $temp);
				  $temp = str_replace('%%bio_id%%', $bio_id, $temp);
				  $temp = str_replace('%%name%%', $name, $temp);
				  echo "<td><center>$temp</center></td>";
				} else {
				  echo "<td><center>0</center></td>";
				}
				$temp = $form_txt;
				if ($mycountd > 0) {
				  $temp = str_replace('%%var1%%', 'one_destroyed_list', $temp);
				  $temp = str_replace('%%value%%', $mycountd, $temp);
				  $temp = str_replace('%%bio_id%%', $bio_id, $temp);
				  $temp = str_replace('%%name%%', $name, $temp);
				  echo "<td><center>$temp</center></td>";
				} else {
				  echo "<td><center>0</center></td>";
				}
				echo "</tr>\n";
			  }
			  echo "</table></center><br><br>";
			  if ($usr_access > 50) {
				  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
				  echo "<tr>";
				  echo "<td><center><form action='$cgi' method='post'>\n";
				  echo "<input type='hidden' name='act' value='mul_dump'>\n";
				  echo "<input type='hidden' name='type' value='xls'>\n";
				  echo "<input type='hidden' name='s_date' value=$s_date>\n";
				  echo "<input type='hidden' name='e_date' value=$e_date>\n";
				  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
				  echo "</form></center></td>\n";
				  echo "<td><center><form action='$cgi' method='post'>\n";
				  echo "<input type='hidden' name='act' value='mul_dump'>\n";
				  echo "<input type='hidden' name='type' value='txt'>\n";
				  echo "<input type='hidden' name='s_date' value=$s_date>\n";
				  echo "<input type='hidden' name='e_date' value=$e_date>\n";
				  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
				  echo "</form></center></td>\n";
				  echo "</tr></table></center><br><br>\n";
			  }
			} else {
			  echo "<center><font size='+2'><br><font color=#ff0000>ERROR</font><br>Appears that there are no Vaccines in the Database<br>Press back and try again</font></center><br><br>";
			}
		  }
			
		}
	  } else {
        mybanner("Enter Date Range for Usage Report", "none", $user_name);
	    echo "<center><form action='$cgi' method='post'>\n";
        echo "<input type='hidden' name='act' value='date_report'>\n";
		echo "<input type='hidden' name='cargo' value='got_date'>\n";
	    echo "Start Date: <input type='text' name='s_date' maxlength='10' size='10' value = '$today'> (mm/dd/yyyy)<br>\n";
	    echo "End Date: <input type='text' name='e_date' maxlength='10' size='10' value = '$today'> (mm/dd/yyyy)<br>\n";
	    echo "<br><input type='submit' value='Create Report'>\n";
	    echo "</form></center>\n";
	  }
      NavBar($cgi, $act, $usr_access);
	break;
	// end of date_report
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// one_received_list
// From Navigation, Report by Date Range, From Form "Received" Select button
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "one_received_list":
    mybanner("Received $vac_name Vaccine from $s_date to $e_date", "none", $user_name);
//	$q = "select * from $mytable where biological_id = '$bio_id' and consumed_ynd = 'N'
//		and r_date >= $d_quote$s_date$d_quote and r_date <= $d_quote$e_date$d_quote
//		order by r_date ASC, r_time ASC";
	$q = "select * from $mytable where biological_id = '$bio_id'
		and r_date >= $d_quote$s_date$d_quote and r_date <= $d_quote$e_date$d_quote
		order by r_date ASC, r_time ASC";
	My_Lister($vac_name, $q, "received");
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='N'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='N'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of one_received_list

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// one_consumed_list
// From Navigation, Report by Date Range, From Form "Consumed" Select button
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "one_consumed_list":
    mybanner("Consumed $vac_name Vaccine from $s_date to $e_date", "none", $user_name);
	$q = "select * from $mytable where biological_id = '$bio_id' and consumed_ynd = 'Y'
		and c_date >= $d_quote$s_date$d_quote and c_date <= $d_quote$e_date$d_quote
		order by c_date ASC, c_time ASC";
	My_Lister($vac_name, $q, "consumed");
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='Y'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='Y'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of one_consumed_list

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// one_destroyed_list
// From Navigation, Report by Date Range, From Form "Destroyed" Select button
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "one_destroyed_list":
    mybanner("Destroyed $vac_name Vaccine from $s_date to $e_date", "none", $user_name);
	$q = "select * from $mytable where biological_id = '$bio_id' and consumed_ynd = 'D'
		and c_date >= $d_quote$s_date$d_quote and c_date <= $d_quote$e_date$d_quote
		order by c_date ASC, c_time ASC";
	My_Lister($vac_name, $q, "destroyed");
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='D'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='D'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of one_destroyed_list
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// date_vac_list
// From Navigation, Report by Date Range, From Form "Name" Select button
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "date_vac_list":
    mybanner("All $vac_name Vaccine from $s_date to $e_date", "none", $user_name);
	$q = "select * from $mytable 
		where biological_id = '$bio_id'
		and ((r_date >= $d_quote$s_date$d_quote and r_date <= $d_quote$e_date$d_quote)
		or (c_date >= $d_quote$s_date$d_quote and c_date <= $d_quote$e_date$d_quote))
		order by consumed_ynd, r_date, r_time";
// echo "<BR><BR>$q<BR><BR>";		
	Full_Lister($bio_name, $q);
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of date_vac_list
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get_note
// From Navagation selecting "List on Hand" in the expire module and selecting 'consume' or 'expire'
// Need to collect the note and make sure the string is ok and then return to the "expire" module for update SQL
// Upon return to expire module you will need.
// Need to make a deture for the consume and delete so a "note" can be entered.
// The "note" needs to be ran through the validation to prevent SQL injection
// Have this module accept info for Create or destroy, so it can be handled (Introduce by banner) properly
// After collection of the "note", return here for processing so they return to the  expire screen
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case "get_note":
      $progress_str = "You have selected to $cargo a $bio_name vaccine";
      $mydate = getdate(time());
	  $r_date = $mydate["year"] . "-" . $mydate["mon"] . "-" . $mydate["mday"];
	  $today =  $mydate["mon"] . "/" . $mydate["mday"] . "/" . $mydate["year"];
	  $r_time = format_time($mydate);
//      $r_time = str_pad($r_time,5,"0",STR_PAD_LEFT);
      $r_ip = $REMOTE_ADDR;
	  $c_date = $mydate["year"] . "-" . $mydate["mon"] . "-" . $mydate["mday"];
	  $c_time = format_time($mydate);
//      $c_time = str_pad($c_time,5,"0",STR_PAD_LEFT);
      $c_ip = $REMOTE_ADDR;
	  if (isset($note)) {
	    $note = FixMyString($note);
	    $q1 = "update $mytable set c_name= $d_quote$user_name$d_quote,
		c_date = $d_quote$c_date$d_quote,
		c_time = $d_quote$c_time$d_quote,
		c_ip = $d_quote$c_ip$d_quote, 
		note = $d_quote$note$d_quote, 
		consumed_ynd = ";
		$q3 = " where id = $d_quote$det_id$d_quote";   
		if ($cargo == "destroy") 
		{
		  mybanner("one $bio_name has been marked DESTROYED", "none", $user_name);
		  $q2 = $d_quote . "D" . $d_quote;
		}
		if ($cargo == "consume")
		{
		  mybanner("one $bio_name has been marked CONSUMED", "none", $user_name);
    	  $q2 = $d_quote . "Y" . $d_quote;
		}
		$q = $q1 . $q2 . $q3;
//    	echo "<br>$q<br>";
		$r = mysql_query($q) or die(mysql_error());
		echo "<br><center><font size=+2>Success!</font></center><br>";
		SendEmail($progress_str, $bio_table, $detail_table, $email_table);
	  } else {
  	      mybanner($progress_str, "none", $user_name);
		  echo "<br><center><font +1><b>Please enter comment below</b></font></center><br>";
	//	  mybanner("Consume/Delete Comment Collection", "none", $PHP_AUTH_USER);
	//	  Go back to vaccine_list when done with collecting and validating note!
	//   Go back to stock_list when done with collecting and validating note!
	//    echo "<td><a href='$cgi?act=stock_list&det_id=$det_id&bio_id=$bio_id&bio_name=$bio_name&cargo=consume'>Consume</a></td>
	//    <td><a href='$cgi?act=stock_list&det_id=$det_id&bio_id=$bio_id&bio_name=$bio_name&cargo=destroy'>Destroy</a></td>";
		  echo "<center><form action='$cgi' method='post'>\n";
		  echo "<input type='hidden' name='act' value='get_note'>\n";
		  echo "<input type='hidden' name='cargo' value='$cargo'>\n";
		  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
		  echo "<input type='hidden' name='bio_name' value='$bio_name'>\n";
		  echo "<input type='hidden' name='det_id' value='$det_id'>\n";
		  echo "Note/Comment: <input type='text' name='note' maxlength='132' size='40' value = ''><br>\n";
		  echo "<br><input type='submit' value='Record $cargo of $bio_name'>\n";
		  echo "</form></center>\n";
//		  echo "<br>det_id=$det_id<br>bio_id=$bio_id<br>bio_name=$bio_name<br>cargo=$cargo<br>note=$note<br>";  
	  }
    NavBar($cgi, $act, $usr_access);
  break;
  // end of get_note
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// dumpxl
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case "dumpxl":
//die( "<br>Q_str = $q_str<br>\n");
	header("Cache-control: private");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment ; filename=vaccine_dump." . "xls");
      $q = "select a.exp_date, a.lot_num, a.r_name, 
	    a.r_date, a.r_time, a.r_ip, b.name as bio_name, c.name as man_name,
		a.biological_id as bio_id, a.id as det_id,
		datediff( a.exp_date, now() ) as exp
	    from $mydbf.$mytable a, $bio_table b, $man_table c
        where a.consumed_ynd = 'N' and b.id = a.biological_id and a.man_id = c.id
        order by bio_name, exp_date";
//echo "<br><br>$q<br><br>";		
	My_xls_dump($q);
  break;
  // end of dumpxl
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// dumptxt
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "dumptxt":
	header("Cache-control: private");
	header('Content-type: application/vnd.ms-notepad ; filename=biopsy_entry_dump.' . 'txt');
	header("Content-Disposition: attachment ; filename=vaccine_dump." . "txt");
	$q = "select a.exp_date, a.lot_num, a.note,
		a.r_name, a.r_date, a.r_time, a.r_ip,
		a.c_name, a.c_date, a.c_time, a.c_ip,
		b.name as bio_name, a.consumed_ynd,
		a.biological_id as bio_id, a.id as det_id
		from $mydbf.$mytable a, $bio_table b
		where b.id = a.biological_id
		order by bio_name, consumed_ynd, lot_num";
	My_txt_dump($q);
  break;
  // end of dumptxt


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// mul_dump
// Need a case for one Vaccine or all Vaccines - (bio_id, bio_name)
// Need to see if it is for all, received, consumed, or destroyed - (consumed_ynd)
// need to see if there is a date range - (s_date, e_date)
// $a as well as the file name need to adjust for each one!
// Passed possibilities are:
//	s_date, bio_id, bio_name, consumed_ynd
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
case "mul_dump":
//die( "<br>Q_str = $q_str<br>\n");
	$filename = "vaccine_dump";
	$q1 = "";
	$q2 = "";
	$q3 = "";
	if (isset($consumed_ynd)) {
		if ($consumed_ynd == "Y") {
			$filename = $filename . "-Consumed";
			$q2 = $q2 . " and consumed_ynd = $d_quote$consumed_ynd$d_quote";
		}
		if ($consumed_ynd == "D") {
			$filename = $filename . "-Destroyed";
			$q2 = $q2 . " and consumed_ynd = $d_quote$consumed_ynd$d_quote";
		}
		if ($consumed_ynd == "N") {
			$filename = $filename . "-Received";
			$q2 = $q2 . " and consumed_ynd = 'N'";
			// if this happens to be the in house, then apply the ynd filter
		}
		if ($consumed_ynd == "instock") {
			$filename = $filename . "-InStock";
			// if this happens to be the in house, then apply the ynd filter
			$q2 = $q2 . " and consumed_ynd = 'N'";
//			echo "<br><br>Here I am<br><br>";
		}
	}
	if (isset($lot_num)) {
		$q2 = $q2 . " and a.lot_num = $d_quote$lot_num$d_quote";
		$filename = $filename . "-lot_num:$lot_num";
	}
	
	if (isset($bio_id)) {
		$q2 = $q2 . " and a.biological_id = $d_quote$bio_id$d_quote";
		$filename = $filename . "-$bio_name";
	}
	if (isset($s_date) ) {
		if (isset($consumed_ynd)) {
			if ($consumed_ynd == "N") { 
				$q2 = $q2 . " and (r_date >= $d_quote$s_date$d_quote and r_date <= $d_quote$e_date$d_quote)";
			} elseif (($consumed_ynd == "Y") or ($consumed_ynd == "D")) {
				$q2 = $q2 . " and (c_date >= $d_quote$s_date$d_quote and c_date <= $d_quote$e_date$d_quote)";
			}// isset($consumed_ynd
		} else { // isset($consumed_ynd
			$q2 = $q2 . " and ((r_date >= $d_quote$s_date$d_quote and r_date <= $d_quote$e_date$d_quote)";
			$q2 = $q2 . " or (c_date >= $d_quote$s_date$d_quote and c_date <= $d_quote$e_date$d_quote))";
		} // isset($consumed_ynd
		$filename = $filename . "-$s_date-to-$e_date";
	}
    if ($type == "xls") $filename = $filename . ".xls";
    if ($type == "txt") $filename = $filename . ".txt";
//echo "<br><BR><BR>$filename<BR><BR>";	
	$q1 = "select a.exp_date, a.lot_num, a.note,
		a.r_name, a.r_date, a.r_time, a.r_ip,
		a.c_name, a.c_date, a.c_time, a.c_ip,
		b.name as bio_name, a.consumed_ynd,
		a.biological_id as bio_id, a.id as det_id, c.name as man_name
		from $mydbf.$mytable a, $bio_table b, $man_table c
		where b.id = a.biological_id and a.man_id = c.id"; 
	$q3 = " order by bio_name, consumed_ynd, lot_num";
	$q = $q1 . $q2 . $q3;
//echo "<br><br><br>$q<br><br><br>";
//echo "<br><br><br>$filename<br><br><br>";

	if ($type == "xls") {
		header("Cache-control: private");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment ; filename=$filename");
		My_xls_dump($q);
	}
	if ($type == "txt") {
		header("Cache-control: private");
		header("Content-type: application/vnd.ms-notepad ; filename=$filename");
		header("Content-Disposition: attachment ; filename=$filename");
		My_txt_dump($q);
	}
  break;
  // end of mul_dump

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// trash
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	case "trash":
		mybanner("Removal of Consumed and Destroyed History", "none", $user_name);
		if ($usr_access > 50) {
			if (isset($date_del_hist)) {
				$errString = "";
				$errString .= ValadateInput($date_del_hist, "date", "Delete History Date");
				if (strlen($errString) < 5) {
					if (isset($del_ok)) {
						$date_del_hist = LinuxDate($date_del_hist);
						$q = "delete from $mytable where consumed_ynd <> 'N' and c_date <= $d_quote$date_del_hist$d_quote";
						$r = mysql_query($q) or die(mysql_error());
						$comment = "You have successfully deleted history dated $date_del_hist and prior";
						echo "<br><center><font size='+3'>$comment</font></center>\n";
						echo "<br><center>$q</center>\n";
						SendEmail($comment, $bio_table, $detail_table, $email_table);
					} else { // isset(del_ok)
						echo "<font size='+3'><br><center>You are about to delete history from $date_del_hist and before<br>\n";
						echo "There is no <b>undo</b> from here<br>\n";
						echo "Are you sure!</center></font><br>\n";
						echo "<center>\n";
						echo "<center><form action='$cgi' method='post'>\n";
						echo "<input type='hidden' name='act' value='trash'>\n";
						echo "<input type='hidden' name='date_del_hist' value='$date_del_hist'>\n";
						echo "<input type='hidden' name='del_ok' value='ok'>\n";
						echo "<br><font><input type='submit' value='Click here to complete deletion' style='font-size:18px'>\n";
						echo "</form></center><br>\n";
					} // isset(del_ok)
				} else { // strlen errString < 5
					echo "$errString\n";
				} // strlen errString < 5
			} else {
				// need to ask for the date marking the most recent consumed/destroy date
				// All data from that point and before will be removed
				// This has no undo
				// first pre-populate with max(`c_date`)
				$q = "SELECT max(c_date) as mydate1, min(c_date) as mydate2 FROM $mytable where c_date <> '0000-00-00'"; 
				$r = mysql_query($q) or die(mysql_error());
				$row = mysql_fetch_array($r);
				$mydate1 = $row["mydate1"];
				$mydate1 = DosDate($mydate1);
				$mydate2 =$row["mydate2"]; 
				$mydate2 = DosDate($mydate2);
				echo "<center><br>First history entry was $mydate2 and the most recent is $mydate1<br><br>";
				echo "Please be careful of your selection<br>There is no undo from here!<br>\n";
				echo "The default selection below will <font size=+3>remove all history!</font><br>\n";
				echo "</center><br>";
				echo "<center><form action='$cgi' method='post'>\n";
				echo "<input type='hidden' name='act' value='trash'>\n";
				echo "Enter Date to remove history on this date and before: <input type='text' name='date_del_hist' maxlength='10' size='10' value = '$mydate1'><br>\n";
				echo "<br><font><input type='submit' value='Remove history for this date and before' style='font-size:18px'>\n";
				echo "</form></center>\n";
			}// date_del_hist is set	
		} else { // user_access > 50
			echo "<br><br><center><font size=+3>You do not have security settings for this page!</font></center><br><br>\n";
		} // user_access > 50
		NavBar($cgi, $act, $usr_access);
	break;
// end of trash

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lot_grid
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	case "lot_grid":
		mybanner("Vaccine Lot Number Grid", "none", $user_name);
		$q = "select distinct lot_num from $mydbf.$mytable order by lot_num"; 
		$r = mysql_query($q) or die(mysql_error());
		$max = mysql_num_rows($r);
		$color = 0;
		if ($max > 0) {
			echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
			echo "<tr bgcolor=#ffffff><td colspan=4><center>$max Lot numbers foud</center></td></tr>";
			echo "<tr bgcolor=#ffffff><td><center>Stock Number</center></td>";
			echo "<td><center>On Hand</center></td>";
			echo "<td><center>Consumed</center></td>";
			echo "<td><center>Destroyed</center></td>";
			echo "</tr>";
			$form_txt = "<form action='$cgi' method='post'>
				<input type='hidden' name='act' value='%%var1%%'>
				<input type='hidden' name='lot_num' value='%%lot_num%%'>
				<input type='submit' value='%%value%%'>
				</form>";
			while ($row = mysql_fetch_array($r)) {
				$lot = $row["lot_num"];
				$color = MeColorTR($color, 1);
				$temp = $form_txt;
				$temp = str_replace('%%lot_num%%', $lot, $temp);
				$temp = str_replace('%%var1%%', 'lot_detail', $temp);
				$temp = str_replace('%%value%%', $lot, $temp);
				echo "<td><center>$temp</center></td>"; // On Hand
//				echo "<td>$lot</td>";
				$q2 = "select count(*) as mycount from $mytable where lot_num = $d_quote$lot$d_quote and consumed_ynd = 'N'";
				$q3 = "select count(*) as mycount from $mytable where lot_num = $d_quote$lot$d_quote and consumed_ynd = 'Y'";
				$q4 = "select count(*) as mycount from $mytable where lot_num = $d_quote$lot$d_quote and consumed_ynd = 'D'";
				$r2 = mysql_query($q2) or die(mysql_error());
				$r3 = mysql_query($q3) or die(mysql_error());
				$r4 = mysql_query($q4) or die(mysql_error());
				$row2 = mysql_fetch_array($r2);
				$row3 = mysql_fetch_array($r3);
				$row4 = mysql_fetch_array($r4);
				$count2 = $row2["mycount"];
				if ($count2 < 1) {
					echo "<td><center>--</center></td>"; // On Hand
				} else { //$count2 < 1
					$temp = $form_txt;
					$temp = str_replace('%%lot_num%%', $lot, $temp);
					$temp = str_replace('%%var1%%', 'lot_on_hand', $temp);
					$temp = str_replace('%%value%%', $count2, $temp);
					echo "<td><center>$temp</center></td>"; // On Hand
				} //$count2 < 1
				$count3 = $row3["mycount"];
				if ($count3 < 1) {
					echo "<td><center>--</center></td>"; // Consumed
				} else { // $count3 < 1
					$temp = $form_txt;
					$temp = str_replace('%%lot_num%%', $lot, $temp);
					$temp = str_replace('%%var1%%', 'lot_consumed', $temp);
					$temp = str_replace('%%value%%', $count3, $temp);
					echo "<td><center>$temp</center></td>"; // Consumed
				} // $count3 < 1
				$count4 = $row4["mycount"];
				if ($count4 < 1) { //$count4 < 1
					echo "<td><center>--</center></td>"; // Destroyed
				} else { // $count4 < 1
					$temp = $form_txt;
					$temp = str_replace('%%lot_num%%', $lot, $temp);
					$temp = str_replace('%%var1%%', 'lot_destroyed', $temp);
					$temp = str_replace('%%value%%', $count4, $temp);
					echo "<td><center>$temp</center></td>"; // Destroyed
				} // $count4 < 1
				echo "</tr>"; 
			} // end while
			echo "</table></center><br><br>";
		} // end max > 0
		NavBar($cgi, $act, $usr_access);
	break;
	// end of lot_grid
	

// start of the 4 musketeers!

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lot_detail #1
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "lot_detail":
    mybanner("All Vaccines from lot #: $lot_num", "none", $user_name);
	$q = "select * from $mytable 
		where lot_num = '$lot_num'
		order by consumed_ynd, r_date, r_time";
	Full_Lister($lot_num, $q);
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of lot_detail


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lot_on_hand #2
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "lot_on_hand":
    mybanner("Oh Hand Vaccines for lot #: $lot_num", "none", $user_name);
	$q = "select * from $mytable 
		where lot_num = '$lot_num' and consumed_ynd = 'N' 
		order by consumed_ynd, r_date, r_time";
// echo "<BR><BR>$q<BR><BR>";		
	Full_Lister($lot_num, $q);
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='N'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='N'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of lot_on_hand


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lot_consumed #3
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "lot_consumed":
    mybanner("Consumed Vaccines from lot #: $lot_num", "none", $user_name);
	$q = "select * from $mytable 
		where lot_num = '$lot_num' and consumed_ynd = 'Y'
		order by consumed_ynd, r_date, r_time";
// echo "<BR><BR>$q<BR><BR>";		
	Full_Lister($lot_num, $q);
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='Y'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='Y'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of lot_consumed


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lot_destroyed #4
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  case "lot_destroyed":
    mybanner("Destroyed Vaccines from lot #: $lot_num", "none", $user_name);
	$q = "select * from $mytable 
		where lot_num = '$lot_num' and consumed_ynd = 'D'
		order by consumed_ynd, r_date, r_time";
// echo "<BR><BR>$q<BR><BR>";		
	Full_Lister($lot_num, $q);
//	echo "<br>$q<br>";
	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='D'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='lot_num' value='$lot_num'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='D'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
    NavBar($cgi, $act, $usr_access);
  break;
  // end of lot_destroyed

  } // end of switch
} // end of missing act=
/*
//// useful for cut and paste

	if ($usr_access > 50) {
	  echo "<center><table  width='60%' border='1' cellspacing='0' cellpadding='4'>\n";
	  echo "<tr>";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='xls'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='N'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Spreadsheet'>\n";
	  echo "</form></center></td>\n";
	  echo "<td><center><form action='$cgi' method='post'>\n";
	  echo "<input type='hidden' name='act' value='mul_dump'>\n";
	  echo "<input type='hidden' name='type' value='txt'>\n";
	  echo "<input type='hidden' name='s_date' value=$s_date>\n";
	  echo "<input type='hidden' name='e_date' value=$e_date>\n";
	  echo "<input type='hidden' name='bio_id' value='$bio_id'>\n";
	  echo "<input type='hidden' name='bio_name' value='$vac_name'>\n";
	  echo "<input type='hidden' name='consumed_ynd' value='N'>\n";
	  echo "<br><input type='submit' value='Dump Selected to Text'>\n";
	  echo "</form></center></td>\n";
	  echo "</tr></table></center><br><br>\n";
	}
      $r = mysql_query($q) or die(mysql_error());
      $max = mysql_num_rows($r);
	    echo "<center><table  width='95%' border='1' cellspacing='0' cellpadding='4'>\n";
		echo "<tr bgcolor=#ffffff><td colspan=9><center>$max records found</center></td></tr>";
$r_time = str_pad($r_time,5,"0",STR_PAD_LEFT);
UPDATE `p_detail` SET `r_time` = lpad(`r_time`,5,'0');
UPDATE `p_detail` SET `c_time` = lpad(`c_time`,5,'0'); 
	  
		
		
*/
?>
