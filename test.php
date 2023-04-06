<?php
 	
	/*
	$fields = array(
    "sender_id" => "FSTSMS",
    "message" => "Your OTP is ",
    "language" => "english",
    "route" => "p",
    "numbers" => "9106126536",
    "flash" => "0"
);
		
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
    "authorization: qLORQhevX7Hj1ZzCfsYciBxN2k0tFUVab8lmI5gr3KAMnpE9DysiUZb56Q2jIPGxTvSAekcOK07hBdty",
    "accept: *//*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));	
		
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

*/
 
/* echo $response = '{"return":true,"request_id":"lygvun5k0rw394d","message":["Message sent successfully to NonDND numbers"]}';
 
   $decoded_json = json_decode($response,true);
  
  echo "<br>";
  $request_id = $decoded_json['request_id'];
  
  echo $request_id;
  
  */
  
//
	//return true;




$code = mt_rand(1000,999999);

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
//require 'src/PHPMailer.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);                    

    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'rinkubhagat2403@gmail.com';                 // SMTP username
    $mail->Password = 'Rinku2403';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

     
    $mail->setFrom('rinkubhagat2403@gmail.com', 'PHP');
     // $mail->addAddress($email,'');     // Add a recipient
    $mail->addAddress('rg703612@gmail.com','');     // Add a recipient
    
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Change Password!!';
	//$mail->Body    = ' Your Account has been Hacked. <br> <br> Your OTP is : <h2>'. $otp . '</h2>';
    $mail->Body    = 'Your Verification Code is : <h2>'. $code . '</h2>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // $mail->send();

	if(!$mail->send()) {
   return false;
} else {

  $conn = mysqli_connect("localhost","root","","royal");

 $q = "INSERT INTO forgot_password (`verification_code`) VALUES ('$code')";
   
  if(mysqli_query($conn,$q)){
  
      $q="SELECT * FROM `forgot_password` where verification_code='$code' and is_expired=0";
      $data = mysqli_query($conn,$q);
      $num = mysqli_num_rows($data);

      if($num>0){

$heroes = array();

        while($rs = mysqli_fetch_assoc($data)){
        $hero = array();
        $hero['forgot_pwd_id'] = $rs['forgot_pwd_id'];
        $hero['verification_code'] = $rs['verification_code'];

array_push($heroes, $hero);
} 

        var_dump($heroes);
      }
      else{
        return false;
      }  



   
      }
}
	



	?>
	