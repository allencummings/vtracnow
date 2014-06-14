<?php
include 'include.txt';
$cgi = $PHP_SELF;

//$myHost = 'ccaac';
//$myHost = 'sme';
$email_to_Sec = $row["email_to_sec"];
$email_to_member = $row["email_to_member"];
$subject = $row["subject"];
$test_mode = $row["test_mode"];
If ($test_mode == "Yes") echo "<center>test mode = $test_mode</center>";


//
?>
<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

<head>
<title>Test Email Application</title>
<meta name="GENERATOR" content="Arachnophilia 4.0">
<meta name="FORMATTER" content="Arachnophilia 4.0">
</head>

<body bgcolor="#E7EBF1" text="#000000" link="#0000ff" vlink="#ffffff" alink="#ff0000">
  <center><table width=640 cellpadding=0 cellspacing=0 border=0> 
    <tr><td><center><h1><font face="trebuchet ms, arial, helvetica" color="#3A6EA5">Grand Lodge of Texas</font></h1></center></td></tr>
    <tr><td><center><h1><font face="trebuchet ms, arial, helvetica" size="+1" color="#3A6EA5">Test Email Form</font></h1></center></td></tr>
</table>

<?php
function FixMyString($mystring)
{
// ATTENTION
// Special Modified version allows single quotes to pass!
// Be sure that when this text is sent, double quotes surround it in the SQL statement!
// ATTENTION
// This will remove the dangerous characters quotes and question mark
$temp = trim($mystring);
//$temp = str_replace("'", "",  $mystring); // byby single quote
$temp = str_replace('"', "", $temp); // byby double quotes
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
} // end of FixMyString

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


function end_form($f1)
{
      echo "<table><tr><td>Any additional information or comments:</td></tr>";
      echo "</td></tr><tr><td>";
      echo "<TEXTAREA name=message ROWS=10 COLS=60></TEXTAREA><br>";
      echo "</td></tr>";
      echo "<tr><td>";
      echo "<input type='hidden' name='act' value='done'>\n";
      echo "<INPUT type='submit' value='Submit Entry'><input TYPE='reset' VALUE='Erase the form'>";
      echo "</td></tr>";
      echo "</table></center>";
      echo "</FORM>";
} // end of end_form





// Start of program here!

$f1 = "face='trebuchet ms, arial, helvetica'";
switch ($act) {
  case "done":
    $subject = "Test email from Vertbiz!";
    $cust_info = "Address (IP) Of Sender: \t" . $REMOTE_ADDR . "\n";
    $cust_info .= "This is a test to see if the email is working:\n\n";
    $cust_info .= "Please discard...  Thanks\n\n";
    $from_string_addr = "From: webmaster@grandlodgeoftexas.org\r\n" ."Reply-To: webmaster@grandlodgeoftexas.org\r\n" ."X-Mailer: PHP/" . phpversion();
    mail($sec_email, $subject, $cust_info, $from_string_addr);
    echo "<br>Email has been Sent!<br>TO<br>$sec_email<br>$subject<br>$cust_info<br>$from_string_addr<br><br>";
    break;

  default :
    echo "";
      echo "<FORM METHOD='POST' ACTION=$PHP_SELF>";
      echo "<hr width='95%' align=center>";
     echo"<h3><font $f1 color='#3A6EA5' size='-1'>";
      echo "Enter email address to send to and click on  'Next'</h3>";
      echo "<hr width='95%' align=center>";
      echo "<center>";
      echo "<font $f1>";
      echo "Email Addr <input type='text' name='sec_email' size='50' maxlength='80' value='$sec_name'>\n";
      echo "<input type='hidden' name='act' value='done'>";
      echo "<INPUT type='submit' value='Next'></center>\n";
      echo "</FORM>";
}
?>

        </table></center>


</body>
</html>
