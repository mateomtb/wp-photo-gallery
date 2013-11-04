<?php
/**
 *  @package    dfm-base
 *  @author     Jonathan Boho
 *  @copyright  (c) 2012
 *  @version    1.0
 *  @license    xxx
 */

// GENERAL
function redirect_to($str) { header("Location:{$str}"); exit; }
function deepCopy($object) {  return unserialize(serialize($object)); }

// NETWORK
function curPageURL()
{
    $protocol = curSSL();
    $host     = $_SERVER['HTTP_HOST'];
    $script   = $_SERVER['SCRIPT_NAME'];
    $params   = $_SERVER['QUERY_STRING'];
    $currentUrl = $protocol . $host . $script . '?' . $params;

    return $currentUrl;
}
function curSSL()
{
    $pageSSL = 'http';
    if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
        $pageSSL .= "s";
    }
    $pageSSL .= "://";

    return $pageSSL;
}

// FORMATTING
function escape_string($str)
{
    $cleaned_string = trim(str_replace('\n', '', $str));

    return strtr($cleaned_string, array (
        "'"  => "\'"
    ));
}
function format_number($number, $fractional=false)
{
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }

    return $number;
}
function format_money($number, $fractional=false, $abbrev=false)
{
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    if ($abbrev) {
        if ($number >= 1000000) {
            $suffix = ($number >= 1000000000) ? "B" : "M";
            $number = ($number >= 1000000000) ? (string) number_format(($number/1000000000) , 2) : (string) number_format(($number/1000000), 2);
            $number .= $suffix;
        }
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    if (!strstr($number, ".")) {
        $number = $number . ".00";
    }
    if (substr($number, -2, 1) == ".") {
        $number = $number . "0";
    }

    return "$" . $number;
}

// DATES
function format_date($str)
{
    $months = array("", "Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");
    $date_array = explode('-', $str);
    $pos = strpos($date_array[1], '0');
    $index = ($pos !== 0) ? $date_array[1] : trim ($date_array[1], "0");
    $month = $months[$index];
    $pos = strpos($date_array[2], '0');
    $date = ($pos !== 0) ? $date_array[2] :trim($date_array[2], "0");
    $formatted_date = $month . " " . $date . ", " . $date_array[0];

    return $formatted_date;
}
function datetime_to_text($datetime="")
{
    return strftime("%B %d, %Y at %I:%M %p", $strtotime($datetime));
}
function strip_zeros_from_date($marked_string="")
{
    $no_zeros = str_replace('*0', '', $marked_string); // first remove the marked zeros
    $cleaned_string = str_replace('*', '', $no_zeros); // then remove any remaining marks

    return $cleaned_string;
}
function calculate_age($birth, $death)
{
    $days = 0;
    $months = 0;
    $years = 0;
    $dob = strtotime($birth);
    $dod = strtotime($death);
    $diff = $dod - $dob;
    $days = floor((($diff/60)/60)/24);
    $age = ($days > 1) ? $days . " days" : $days . " day";
    if ($days > 29) {
        $months = floor($days/30);
        $age = ($months > 1) ? $months . " mos." : $months . " mo.";
    }
    if ($months > 23) {
        $years = floor($months/12);
        $age = ($years > 1) ? $years . " yrs." : $years . " yr.";
    };

    return $age;
}

// ERRORS & LOGGING
function dbg($m = '')
{
  output_message($m);
}
function output_message($message = '')
{
  print_r (!empty($message)) ? '<pre>' . $message . '</pre>' : '';
}
function display_error_message($msg, $link)
{
    log_item("error: {$msg} :: links back to {$link}."); // logs error to error file.
    echo("<h2>Oops. We have a problem.</h2>");
    echo("<p>{$msg} To leave this page, just <a href=\"{$link}\">click here</a>.</p>");
}
// Prints messages to the log file
function log_item($msg, $err=array())
{
    $date = strftime("%Y-%m-%d %T");
    $log_item = $date . ": " . $msg . "\r\n";
    $str = $_SERVER['REQUEST_URI'];
    if (!empty($err)) { //cycle through errors and stores them to file
        foreach ($err as $key=>$error) {
            $log_item .= "Error: " . $error . "\r\n";
        }
    }
    $file_contents = (!strpos($str, "admin")) ? read_file("logs", "log.txt") : read_file("../logs", "log.txt");
    $write_to_file = $file_contents . $log_item;
    (!strpos($str, "admin")) ? write_file("logs", "log.txt", $write_to_file) : write_file("../logs", "log.txt", $write_to_file);
}
// Writes data to a file. if the file does not yet exist, the file is created.
function write_file($dir, $filename, $data) // arguments are the file directory, file name and data to be written
{
    $path = $dir . "/" . $filename; // path is the combination of the dir and filename.
    if (!file_exists($path)) { // if the file does not exist . . .
        if (!$filehandle = fopen($path, 'w')) { // if the file can't be created . . .
            echo ("<p><strong>The file \"{$filename}\" cannot be created.</strong></p>");

            return false; // . . . tell the user
        } else { // if the file is created . . .
            fwrite($filehandle, $data); // write the data to the file.
            fclose($filehandle); // close the file.

            return true;
        }
    } else { // if the file already exists . . .
        if (!$filehandle = fopen($path, 'w')) { // . . . see if it can be written to. if not . . .
            echo ("<p><strong>The file \"{$filename}\" can't be written to.</strong></p>"); // . . . tell the user.

            return false;
        } else { // if it can . . .
            if (!fwrite($filehandle, $data)) { // . . . attempt to write to the file. If writing fails . . .
                echo ("<p><strong>Writing to \"{$filename}\" failed.</strong></p>"); // . . . tell the user.

                return false;
            } else { // if writing succeeds . . .
                fclose($filehandle); // close the file

                return true;
            }
        }
    }
}
// This function reads a file and returns the data within the file.
function read_file($dir, $filename) // arguments are the file directory and name.
{
    $path = $dir . "/" . $filename; // set path to file
    if (file_exists($path)) { // if the file exists . . .
        if ($filehandle = fopen($path, 'r')) { // . . . and can be opened . . .
            $data = fread($filehandle, filesize($path)); // . . . store the file data in a variable.
            fclose($filehandle); // close the file

            return $data; // and return the data.
        } else {
            echo ("<p><strong>The file \"{$filename}\" cannot be read.</strong></p>"); // tell the user the file cannot be read.
        }
    } else {
        echo("<p><strong>The file \"{$filename}\" does not exist</strong></p>"); // the the user the file does not exist.
    }
}
// Sends an e-mail to a user -- prompted by user
function send_mail_to_user($name, $email, $sub, $message) // arguments are user email, username and the generated password.
{
    $to = $email;
    $from = "webmaster";
    $subject = $sub;
    $headers = "From: ". $from . "\n";
    $headers .= "Reply-To: noreply\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: text/plain; charset=iso-8859-1";
    $message =  strip_tags($message);
    $result = mail($to, $subject, $message, $headers);

    return $result;
}

// SEARCH
function clean_keywords ($arr)
{
    $unwanted_words = array("the", "of", "to", "a", "in", "is", "it", "you", "that", "he", "she", " was", "for", "on", "are", "with", "as", "I ", "his", "they", "be", "at", "one", "have", "this", "but");
    $new_array = array();
    foreach ($arr as $word) {
        $match = false;
        foreach ($unwanted_words as $unwanted) {
            if ($word == $unwanted) { $match = true; break; }
        }
        if (!$match) {array_push($new_array,$word);}
    }

    return $new_array;
}