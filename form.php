<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "Будь ласка, заповніть форму";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$visitor_phone = $_POST['phone'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email)||empty($phone))
{
    echo "Будь ласка, заповніть всі поля";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Перевірте корректність ел.пошти";
    exit;
}

$email_from = 'kutinova16@gmail.com';//<== update the email address
$email_subject = "Нова заявка з вебсайту";
$email_body = "Ви отримали нову заявку від $name.\n".
    "Повідомлення:\n $message \n телефон: $phone"

$to = 'kutinova16@gmail.com';//<== update the email address
$headers = 'From: $email_from \r\n';
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>
