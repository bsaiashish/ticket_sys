<html>

<head>
        <title>Sai Project</title>
        <link rel="stylesheet" type="text/css" href="includes/assets/css/madtest.css">


</head>


<body >

    <!--<div id="background">  background="https://wallpaper.wiki/wp-content/uploads/2017/05/Purple-Solid-Color-Bright-Gradient-Background-Wallpapers.jpg"  -->


<?php

/*
 * This class can be used to retrieve messages from an IMAP, POP3 and NNTP server
 * @author Kiril Kirkov
 * GitHub: https://github.com/kirilkirkov
 * Usage example:
  1. $imap = new Imap();
  2. $connection_result = $imap->connect('{imap.gmail.com:993/imap/ssl}INBOX', 'user@gmail.com', 'secret_password');
  if ($connection_result !== true) {
  echo $connection_result; //Error message!
  exit;
  }
  3. $messages = $imap->getMessages('text'); //Array of messages
 * in $attachments_dir property set directory for attachments
 * in the __destructor set errors log
 */





session_start();
    if (isset($_POST['hidden'])) {
    $myid = $_POST['hidden'];

    $bak2=-1;
    $bak3=-1;

    $GLOBALS['myid2'] = $myid;


    }





 
class Imap {
    private $imapStream;
    private $plaintextMessage;
    private $htmlMessage;
    private $emails;
    private $errors = array();
    private $attachments = array();
    private $attachments_dir = 'attachments';

    protected $marubox=''; 

    protected $is_connected = false;



    public function connect($hostname, $username, $password) {
        $connection = imap_open($hostname, $username, $password) or die('Cannot connect to Mail: ' . imap_last_error());
        if (!preg_match("/Resource.id.*/", (string) $connection)) {
            return $connection; //return error message
        }
        $this->imapStream = $connection;
        return true;
    }
    public function getMessages($type = 'text') {
        $this->attachments_dir = rtrim($this->attachments_dir, '/');
        $stream = $this->imapStream;
        $emails = imap_search($stream, 'ALL');
        $messages = array();
        if ($emails) {
            $this->emails = $emails;
            foreach ($emails as $email_number) {
                $this->attachments = array();



                $uid = imap_uid($stream, $email_number);


                $messages[] = $this->loadMessage($uid, $type);

                

               /* $con = mysqli_connect("localhost","root","","final");
                if (!$con){
                die("Can not connect: " . mysqli_error());
                }

                mysqli_select_db($con,"finaltable");
*/
                //echo $messages[];

     //  $AddQuery = "INSERT INTO finaltable (id, subject, body, name,email,my_date) VALUES ('',$messages['uid'], $messages['subject'], $messages['message'],$messages['from'],$messages['date']) ";         
       //         mysqli_query($con, $AddQuery);



            }
        }
		return array(
			"status" => "success",
			"data" => array_reverse($messages)
		);
    }
    public function getFiles($r) { //save attachments to directory
		$pullPath = $this->attachments_dir . '/' . $r['file'];
		$res = true;
        if (file_exists($pullPath)) {
			$res = false;
        } elseif (!is_dir($this->attachments_dir)) {
            $this->errors[] = 'Cant find directory for email attachments! Message ID:' . $r['uid'];
            return false;
        } elseif (!is_writable($this->attachments_dir)) {
            $this->errors[] = 'Attachments directory is not writable! Message ID:' . $r['uid'];
            return false;
        }
		if($res && !preg_match('/\.php/i', $r['file']) && !preg_match('/\.cgi/i', $r['file']) && !preg_match('/\.exe/i', $r['file']) && !preg_match('/\.dll/i', $r['file']) && !preg_match('/\.mobileconfig/i', $r['file'])){
			if (($filePointer = fopen($pullPath, 'w')) == false) {
				$this->errors[] = 'Cant open file at imap class to save attachment file! Message ID:' . $r['uid'];
				return false;
			}
			switch ($r['encoding']) {
				case 3: //base64
					$streamFilter = stream_filter_append($filePointer, 'convert.base64-decode', STREAM_FILTER_WRITE);
					break;
				case 4: //quoted-printable
					$streamFilter = stream_filter_append($filePointer, 'convert.quoted-printable-decode', STREAM_FILTER_WRITE);
					break;
				default:
					$streamFilter = null;
			}
			imap_savebody($this->imapStream, $filePointer, $r['uid'], $r['part'], FT_UID);
			if ($streamFilter) {
				stream_filter_remove($streamFilter);
			}
			fclose($filePointer);
			return array("status" => "success", "path" => $pullPath);
		}else{
			return array("status" => "success", "path" => $pullPath);
		}
    }



    public function loadMessage() { //private function loadMessage($uid, $type)


//////////////

                     $con = mysqli_connect("localhost","root","","final");
                        if (!$con)  {
                                die("Can not connect: " . mysqli_error());
                            }

                    mysqli_select_db($con,"finaltable");



                    $type = 'html';

                    $stream = $this->imapStream;
                    $emails = imap_search($stream, 'ALL');
                        //$messages = array();
                    if ($emails) {
                            $this->emails = $emails;
                            foreach ($emails as $email_number) {
                                $this->attachments = array();



                                $uid = imap_uid($stream, $email_number);




//////////////



                                $overview = $this->getOverview($uid);
                                $array = array();
                                $array['uid'] = $overview->uid;
                                $array['subject'] = isset($overview->subject) ? $this->decode($overview->subject) : '';
                                $array['date'] = date('Y-m-d h:i:sa', strtotime($overview->date));
                                $headers = $this->getHeaders($uid);
                                $array['from'] = isset($headers->from) ? $this->processAddressObject($headers->from) : array('');
                                $structure = $this->getStructure($uid);
                                if (!isset($structure->parts)) { // not multipart
                                    $this->processStructure($uid, $structure);
                                } else { // multipart
                                    foreach ($structure->parts as $id => $part) {
                                        $this->processStructure($uid, $part, $id + 1);
                                    }
                                }
                                

                                $array['message'] = $type == 'text' ? $this->plaintextMessage : $this->htmlMessage;
                                $array['attachments'] = $this->attachments;

/*
                                echo $array['uid']."</br>";
                                echo $array['subject']."</br>";
                                echo $array['date']."</br>";
                                echo $array['from']."</br>";
                                echo $array['message']."</br>";
                                echo "</br>";




                                print_r($array['uid']);
                                 echo "</br>";
                                print_r($array['subject']);
                                 echo "</br>";
                                print_r($array['date']);
                                 echo "</br>";
                                print_r($array['from']['address']);
*/
                                //$str = $array['from']['address'];
                                //echo $str;
                                 
                                //$str = print_r($array['from']['address']);



                                 //echo "</br>";
                               //  print_r($array['from']['address']);
                                // echo "</br>";
                               // print_r($array['message']);
                                 //echo "</br>";

                                 //echo "</br>";



                                

                              // echo $AddQuery = "INSERT INTO finaltable (id, subject, body, email, my_date) VALUES ('$array['uid']','$array['subject']', '$array['message']', '$array['from']['address']','$array['date']')";   

                                $id_check = mysqli_query($con, "SELECT * FROM finaltable WHERE id='$array[uid]' ");

                                $num_rows = mysqli_num_rows($id_check);

                                if($num_rows > 0){

                                }

                                else

                                    {
                                        mysqli_query($con, "INSERT INTO finaltable (id, subject, my_date) VALUES ('$array[uid]','$array[subject]','$array[date]')");
                                    }

        //return $array;        


   
                            }

                            mysqli_close($con);

                        }
            }


// new function
public function loadMessageSpecial($uidspecial) { //private function loadMessage($uid, $type)



                                $type = 'html';

                                $stream = $this->imapStream;
                                $emails = imap_search($stream, 'ALL');
                              
                                $this->attachments = array();


                                $overview = $this->getOverview($uidspecial);
                                $array = array();
                                $array['$uidspecial'] = $overview->uid;
                                $array['subject'] = isset($overview->subject) ? $this->decode($overview->subject) : '';
                                $array['date'] = date('Y-m-d h:i:sa', strtotime($overview->date));
                                $headers = $this->getHeaders($uidspecial);
                                $array['from'] = isset($headers->from) ? $this->processAddressObject($headers->from) : array('');
                                $structure = $this->getStructure($uidspecial);
                                if (!isset($structure->parts)) { // not multipart
                                    $this->processStructure($uidspecial, $structure);
                                } else { // multipart
                                    foreach ($structure->parts as $id => $part) {
                                        $this->processStructure($uidspecial, $part, $id + 1);
                                    }
                                }
                                

                                $array['message'] = $type == 'text' ? $this->plaintextMessage : $this->htmlMessage;
                                $array['attachments'] = $this->attachments;

                                print_r($array['message']);
                            

                }


         


public function loadEmailSpecial($uidspecial) { //private function loadMessage($uid, $type)



                                $type = 'html';

                                $stream = $this->imapStream;
                                $emails = imap_search($stream, 'ALL');
                              
                                $this->attachments = array();


                                $overview = $this->getOverview($uidspecial);
                                $array = array();
                                $array['$uidspecial'] = $overview->uid;
                                //$array['subject'] = isset($overview->subject) ? $this->decode($overview->subject) : '';
                                //$array['date'] = date('Y-m-d h:i:sa', strtotime($overview->date));
                                $headers = $this->getHeaders($uidspecial);
                                $array['from'] = isset($headers->from) ? $this->processAddressObject($headers->from) : array('');
                                $structure = $this->getStructure($uidspecial);
                                if (!isset($structure->parts)) { // not multipart
                                    $this->processStructure($uidspecial, $structure);
                                } else { // multipart
                                    foreach ($structure->parts as $id => $part) {
                                        $this->processStructure($uidspecial, $part, $id + 1);
                                    }
                                }
                                

                                //$array['message'] = $type == 'text' ? $this->plaintextMessage : $this->htmlMessage;
                                //$array['attachments'] = $this->attachments;

                                print_r($array['from']['address']);
                            

                }


    private function processStructure($uid, $structure, $partIdentifier = null) {
        $parameters = $this->getParametersFromStructure($structure);
        if ((isset($parameters['name']) || isset($parameters['filename'])) || (isset($structure->subtype) && strtolower($structure->subtype) == 'rfc822')
        ) {
            if (isset($parameters['filename'])) {
                $this->setFileName($parameters['filename']);
            } elseif (isset($parameters['name'])) {
                $this->setFileName($parameters['name']);
            }
            $this->encoding = $structure->encoding;
            $result_save = $this->saveToDirectory($uid, $partIdentifier);
            $this->attachments[] = $result_save;
        } elseif ($structure->type == 0 || $structure->type == 1) {
            $messageBody = isset($partIdentifier) ?
                    imap_fetchbody($this->imapStream, $uid, $partIdentifier, FT_UID | FT_PEEK) : imap_body($this->imapStream, $uid, FT_UID | FT_PEEK);
            $messageBody = $this->decodeMessage($messageBody, $structure->encoding);
            if (!empty($parameters['charset']) && $parameters['charset'] !== 'UTF-8') {
                if (function_exists('mb_convert_encoding')) {
                    if (!in_array($parameters['charset'], mb_list_encodings())) {
                        if ($structure->encoding === 0) {
                            $parameters['charset'] = 'US-ASCII';
                        } else {
                            $parameters['charset'] = 'UTF-8';
                        }
                    }
                    $messageBody = mb_convert_encoding($messageBody, 'UTF-8', $parameters['charset']);
                } else {
                    $messageBody = iconv($parameters['charset'], 'UTF-8//TRANSLIT', $messageBody);
                }
            }
            if (strtolower($structure->subtype) === 'plain' || ($structure->type == 1 && strtolower($structure->subtype) !== 'alternative')) {
                $this->plaintextMessage = '';
                $this->plaintextMessage .= trim(htmlentities($messageBody));
                $this->plaintextMessage = nl2br($this->plaintextMessage);
            } elseif (strtolower($structure->subtype) === 'html') {
                $this->htmlMessage = '';
                $this->htmlMessage .= $messageBody;
            }
        }
        if (isset($structure->parts)) {
            foreach ($structure->parts as $partIndex => $part) {
                $partId = $partIndex + 1;
                if (isset($partIdentifier))
                    $partId = $partIdentifier . '.' . $partId;
                $this->processStructure($uid, $part, $partId);
            }
        }
    }

    
    private function setFileName($text) {
        $this->filename = $this->decode($text);
    }
   private function saveToDirectory($uid, $partIdentifier) { //save attachments to directory
		$array = array();
		$array['part'] = $partIdentifier;
		$array['file'] = $this->filename;
		$array['encoding'] = $this->encoding;
        return $array;
    }
    
    private function decodeMessage($data, $encoding) {
        if (!is_numeric($encoding)) {
            $encoding = strtolower($encoding);
        }
        switch (true) {
            case $encoding === 'quoted-printable':
            case $encoding === 4:
                return quoted_printable_decode($data);
            case $encoding === 'base64':
            case $encoding === 3:
                return base64_decode($data);
            default:
                return $data;
        }
    }


public function get_every_email()
    {
        $result = imap_search($this->marubox, '');
        return $result;
    }

public function getAttachmentSpecial($mid=null,$path='./',$prefix='') 
    { 
        $attachments = array();
        if(!$this->is_connected || is_null($mid)) 
            return false; 

        $struct = imap_fetchstructure($this->marubox,$mid); 
        if($struct->parts) 
        { 
            foreach($struct->parts as $key => $value) 
            { 
                $enc=$struct->parts[$key]->encoding; 
                if($struct->parts[$key]->ifdparameters) 
                { 
                    $name = 'UNKNOWN';
                    for($i=0;$i<count($struct->parts[$key]->dparameters);$i++) {
                        if($struct->parts[$key]->dparameters[$i]->attribute == 'FILENAME')
                            $name=$struct->parts[$key]->dparameters[$i]->value; 
                    }
                    $message = imap_fetchbody($this->marubox,$mid,$key+1); 
                    if ($enc == 0) 
                        $message = imap_8bit($message); 
                    if ($enc == 1) 
                        $message = imap_8bit ($message); 
                    if ($enc == 2) 
                        $message = imap_binary ($message); 
                    if ($enc == 3) 
                        $message = imap_base64 ($message); 
                    if ($enc == 4) 
                        $message = quoted_printable_decode($message); 
                    if ($enc == 5) 
                        $message = $message; 
                    /*
                    Strip all characters but letters, numbers, and whitespace:
                    If you want to strip all characters from your string other than letters, 
                    numbers, and whitespace, this regular expression will do the trick:
                    $res = preg_replace("/[^a-zA-Z0-9s]/", "", $string);
                    */
                    $fileName_1 = $prefix.$name;
                    $fileName=preg_replace("/[^a-zA-Z0-9\s\-\_\.]/", "", $fileName_1);
                    
                    $fp=fopen($path.$fileName,"w"); 
                    fwrite($fp,$message); 
                    fclose($fp); 
                    
                    array_push($attachments,$fileName);
                } 
                // Support for embedded attachments starts here 
                if(isset($struct->parts[$key]->parts)) 
                { 
                    foreach($struct->parts[$key]->parts as $keyb => $valueb) 
                    { 
                        $enc=$struct->parts[$key]->parts[$keyb]->encoding; 
                        if($struct->parts[$key]->parts[$keyb]->ifdparameters) 
                        { 
                            $name = 'UNKNOWN';
                            for($i=0;$i<count($struct->parts[$key]->parts[$keyb]->dparameters);$i++) {
                                if($struct->parts[$key]->parts[$keyb]->dparameters[$i]->attribute == 'FILENAME')
                                    $name=$struct->parts[$key]->parts[$keyb]->dparameters[$i]->value; 
                            }
                            $partnro = ($key+1).".".($keyb+1); 
                            $message = imap_fetchbody($this->marubox,$mid,$partnro); 
                            if ($enc == 0) 
                                   $message = imap_8bit($message); 
                            if ($enc == 1) 
                                   $message = imap_8bit ($message); 
                            if ($enc == 2) 
                                   $message = imap_binary ($message); 
                            if ($enc == 3) 
                                   $message = imap_base64 ($message); 
                            if ($enc == 4) 
                                   $message = quoted_printable_decode($message); 
                            if ($enc == 5) 
                                   $message = $message; 
                            
                            $fileName_1 = $prefix.$name;
                            $fileName=preg_replace("/[^a-zA-Z0-9\s\-\_\.]/", "", $fileName_1);
                            $fp=fopen($path.$fileName,"w"); 
                            fwrite($fp,$message); 
                            fclose($fp); 
                            
                            array_push($attachments,$fileName);
                        } 
                    } 
                } 
            } 
        } 
        return $attachments; 
    } 






    private function getParametersFromStructure($structure) {
        $parameters = array();
        if (isset($structure->parameters))
            foreach ($structure->parameters as $parameter)
                $parameters[strtolower($parameter->attribute)] = $parameter->value;
        if (isset($structure->dparameters))
            foreach ($structure->dparameters as $parameter)
                $parameters[strtolower($parameter->attribute)] = $parameter->value;
        return $parameters;
    }
    private function getOverview($uid) {
        $results = imap_fetch_overview($this->imapStream, $uid, FT_UID);
        $messageOverview = array_shift($results);
        if (!isset($messageOverview->date)) {
            $messageOverview->date = null;
        }
        return $messageOverview;
    }
    private function decode($text) {
        if (null === $text) {
            return null;
        }
        $result = '';
        foreach (imap_mime_header_decode($text) as $word) {
            $ch = 'default' === $word->charset ? 'ascii' : $word->charset;
            $result .= iconv($ch, 'utf-8', $word->text);
        }
        return $result;
    }
    private function processAddressObject($addresses) {
        $outputAddresses = array();
        if (is_array($addresses))
            foreach ($addresses as $address) {
                if (property_exists($address, 'mailbox') && $address->mailbox != 'undisclosed-recipients') {
                    $currentAddress = array();
                    $currentAddress['address'] = $address->mailbox . '@' . $address->host;
                    if (isset($address->personal)) {
                        $currentAddress['name'] = $this->decode($address->personal);
                    }
                    $outputAddresses = $currentAddress;
                }
            }
        return $outputAddresses;
    }
    private function getHeaders($uid) {
        $rawHeaders = $this->getRawHeaders($uid);
        $headerObject = imap_rfc822_parse_headers($rawHeaders);
        if (isset($headerObject->date)) {
            $headerObject->udate = strtotime($headerObject->date);
        } else {
            $headerObject->date = null;
            $headerObject->udate = null;
        }
        $this->headers = $headerObject;
        return $this->headers;
    }
    private function getRawHeaders($uid) {
        $rawHeaders = imap_fetchheader($this->imapStream, $uid, FT_UID);
        return $rawHeaders;
    }
    private function getStructure($uid) {
        $structure = imap_fetchstructure($this->imapStream, $uid, FT_UID);
        return $structure;
    }
    public function __destruct() {
        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                //SAVE YOUR LOG OF ERRORS
            }
        }
    }
}


$email = new Imap();
$connect = $email->connect(
    '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX', //host
    'testppottest@gmail.com', //username
    'kamehameha13' //password
);



$email->loadMessage();

$con = mysqli_connect("localhost","root","","final");
if (!$con){
die("Can not connect: " . mysqli_error());
}

mysqli_select_db($con,"finaltable");



if(isset($_POST['submit_issues'])) {

            $UpdateQuery = "UPDATE finaltable SET  issues_faced='$_POST[issues_faced]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);


        }

if(isset($_POST['submit_steps'])) {

            $UpdateQuery = "UPDATE finaltable SET  steps_taken='$_POST[steps_taken]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);


        }

if(isset($_POST['submit_steps_issues'])) {

            $UpdateQuery = "UPDATE finaltable SET  issues_faced='$_POST[issues_faced]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);

            $UpdateQuery = "UPDATE finaltable SET  steps_taken='$_POST[steps_taken]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);


            $my_issues = $_POST["issues_faced"];
            $my_steps = $_POST["steps_taken"];


        }



/*

if(isset($_POST['issue_pending'])&&isset($_POST['hidden'])){ 

    global $myid;

    


    echo "

        <form action='madtest.php' method='post'>
            <input type=text name=solution>
            <input type='hidden' name='hidden' value='".$_POST['hidden']."'>
            <input type=submit name=send_solution value='Send Solution'> 
        </form>     

        

    ";







};  

*/

/*
if( isset($_POST['issue_pending']) && isset($_POST['hidden'] ) ){ 


    //echo $_POST['solution'] ;


    global $myid;



    echo "ISSUE IS RESOLVED!

        <form action=madtest.php method=post>
        <input type='hidden' name='hidden' value='".$_POST['hidden']."'>
        <input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'>
        </form>
            

        ";

        

};*/

if(isset(  $_POST['issue_pending'] ) && isset($_POST['hidden'] )  ){ 

    global $myid;

    

    $savid = $GLOBALS['myid2'] ;


    $UpdateQuery = "UPDATE finaltable SET  status='resolved' WHERE id= '$_POST[hidden]' "; //the problem was solved by dragging the $_POST[hidden] meaning using the line <input type='hidden' name='hidden' value='".$_POST['hidden']."'> BEFORE using the <input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'> wala line

    
    mysqli_query( $con,$UpdateQuery);

};



if(isset($_POST['no']) && isset($_POST['hidden'])) { 

    echo "

        Ticket no: ".$_POST['hidden'].  " is still marked as pending!



    ";


};



$con = mysqli_connect("localhost","root","","final");
                if (!$con){
                die("Can not connect: " . mysqli_error());
                }

                mysqli_select_db($con,"finaltable");


$fullread = $email->get_every_email();


$sql = "SELECT * FROM finaltable";

$myData = mysqli_query($con,$sql);

/*

echo "<table border=1>
<tr>
<th>id</th>
<th>subject</th>
<th>message</th>
<th>received from</th>
<th>date and time task was received</th>
<th>issues faced</th>
<th>steps taken to resolve the issue</th>
<th>status</th>


</tr>";
while($record = mysqli_fetch_array($myData)){
echo "<form action=testing.php method=post>";
echo "<tr>";
echo "<td>" . $record['id'] . " </td>";
echo "<td>" . $record['subject'] . " </td>";

echo "<td>" . $email->loadMessageSpecial($record['id']) . "</td>";

echo "<td>" . $email->loadEmailSpecial($record['id']) . "</td>";
echo "<td>" . $record['my_date'] . " </td>";
echo "<td><textarea name=issues_faced>" . $record['issues_faced'] . " </textarea></td>";
echo "<td><textarea name=steps_taken>" . $record['steps_taken'] . " </textarea>";
echo "<input type=submit name=submit_steps_issues value='submit both issues and steps'> ";
echo "<td>" . $record['status'] . " </td>";
//echo "<td>" . $record['handler'] . " </td>";


echo "<td>" . "<input type='hidden' name='hidden' value='".$record['id']."' </td>";


$myid = $record['id'];



$_POST['kewl'] = $record['id'];

if($record['status']=="pending")
    echo "<td>" . "<input type='submit' name='issue_pending' value='ISSUE PENDING...RESOLVE!!!' " . " </td>";
else 
    echo "<td>" . "ISSUE IS RESOLVED " . " </td>";
 



//echo "</tr>";
echo "</form>";




}

//old format display

*/





while($record = mysqli_fetch_array($myData)){


echo "</br>";

echo "</br>EMAIL/TICKET ID: " . $record['id'] . "</br> ";
echo "</br>EMAIL SUBJECT: " . $record['subject'] . "</br> EMAIL/TICKET MESSAGE BODY:";

echo "</br> " . $email->loadMessageSpecial($record['id']) . "</br> RECEIVED FROM:";

echo "</br>" . $email->loadEmailSpecial($record['id']) . "</br>";


//attachment stuff...

echo "hahaha";

$arrFiles=$email->getAttachmentSpecial($record['id'],"./"); 
            if($arrFiles)
            {
                foreach($arrFiles as $key=>$value) 
                {
                    echo ($value=="")?"":"Attached File :: ".$value."<br>"; 
                    echo "<a href='$value'>$value</a>";
                }
                echo "<br>------------------------------------------------------------------------------------------<BR>"; 
            }
            else{
                echo "f off";
            }


//


echo "</br>DATE RECEIVED:" . $record['my_date'] . " </br>";


//i changed the contents of the form....took out the ones that were not a part of the input type and put them above this line/comment

echo "<form id='myForm' method='post'>";//removed action='ticketInfo.php'
echo "<tr>";


echo "</br>ISSUES FACED:</br><textarea name='issues_faced'>" . $record['issues_faced'] . " </textarea></br>";
echo "</br>STEPS TAKEN TO RESOLVE THE ISSUE:</br><textarea name='steps_taken'>" . $record['steps_taken'] . " </textarea></br>";

echo "</br><input type=submit name=submit_steps_issues value='submit both issues and steps'></br> ";

//echo "</br><button name='submit_steps_issues' id='sub'>Submit Both Issues and Steps</button>";

echo "</br>STATUS: " . $record['status'] . " </br>";
//echo "<td>" . $record['handler'] . " </td>";


echo "" . "<input type='hidden' name='hidden' value='".$record['id']."' ";

echo "<span id='result'></span>";



$myid = $record['id'];



$_POST['kewl'] = $record['id'];

//echo "</form>";

if($record['status']=="PENDING")
    echo "</br>" . "<input type='submit' name='issue_pending' value='*** YES...ISSUE RESOLVED ***' " . " </br>";
else 
    echo "</br>" . "ISSUE IS RESOLVED " . " </br>";
 

echo "</form>";


echo "</tr>";


echo "<hr>";

}


/*


//echo "<form action=mydata5.php method=post>";
echo "<tr>";
echo "<td><input type=text name=uid></td>";
echo "<td><input type=text name=utask></td>";
echo "<td><input type=text name=ustatus></td>";     
//echo "<td><input type=text name=uhandler></td>";
echo "<td>" . "<input type=submit name=add value=add" . " </td>";
echo "</tr>";
echo "</form>";
echo "</table>";


*/


?>

<!--</div>-->


 <!--<script src="my_script.js" type="text/javascript"></script>-->
 <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
 


</body>
</html>

<!--
<script>
    

$(document).ready(function(){ 
 //the problem is: it works for only one form button\


 $('#myForm').on('submit', function(event){
  event.preventDefault();
  
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"ticketInfo.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {    
    
    }
   })
  }
  
 });
 
});  



</script>

-->
