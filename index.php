
<?php
date_default_timezone_set('Asia/Kolkata');


include('config.php');

$dates=date("Y-m-d h:i:sa");



$facebook_helper = $facebook->getRedirectLoginHelper();

if(isset($_GET['code']))
{
 if(isset($_SESSION['access_token']))
 {
  $access_token = $_SESSION['access_token'];
 }
 else
 {
  $access_token = $facebook_helper->getAccessToken();

  $_SESSION['access_token'] = $access_token;

  $facebook->setDefaultAccessToken($_SESSION['access_token']);
 }


 
 $graph_response = $facebook->get("/me?fields=name,email", $access_token);
 
 $facebook_user_info = $graph_response->getGraphUser();
//  print_r($facebook_user_info);
 
 if(!empty($facebook_user_info['name']))
 {
  $_SESSION['user_name'] = $facebook_user_info['name'];
 }
 
 if(!empty($facebook_user_info['email']))
 {
     $_SESSION['user_email'] = $facebook_user_info['email'];
    }
    
}
else
{

    $facebook_permissions = ['email']; 

    $facebook_login_url = $facebook_helper->getLoginUrl('http://localhost/task3/index.php', $facebook_permissions);
    
    
    $facebook_login_url = '<div style=" width: 12%;
    height:35px;
   
    font-size:15px;
    
    border: 2px solid black;  position: relative;
    left: 50%;
    text-align: center;
    display:flex;
    text-transform: capitalize;
    justify-content: center;
    align-items: center;
    border-radius: 50%;   
    transform:translate(-50%); "
    </style> <a href="'.$facebook_login_url.'" >login with facebook</a></div> <p style="text-align:center;">click to login</p>';
}

?>
<style>
    *{
        background-image: linear-gradient(to left,yellow,lightgreen);
        text-transform: capitalize;
    }
</style>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PHP Login using facebook</title>
<style>
    container{
        width: 100%;
        height: 100vh;
        
    }
  h2{
      
      width: 80%;
      height:30px;
      border-bottom: 1px solid black;
      position: relative;
      left: 50%;
      background-image: linear-gradient( blue,pink ,green);
      
      transform:translate(-50%);
  }

  #boxs{
    width: 30%;
      height:30px;
      position: absolute;
      color: yellow;
      top: 30px;
      transform: translate(-30px);
    
      border-bottom: 1px solid black;
  }
    a{
        
        text-decoration: none;
    }
</style>  
 </head>
 <body>
  <div class="container">
   <br />
   <h2 align="center">login with facebook</h2>
   <br />
   <div class="panel panel-default">
    <?php 
    if(!(isset($facebook_login_url)))
    {
                
	$name = $_SESSION['user_name'];
    $email =  $_SESSION['user_email'];
	
	$token=bin2hex(random_bytes(15));
	// echo $random; 
 
	$select="SELECT * FROM `facebook` WHERE `email`='$email'";
	$fire=mysqli_query($conn,$select);
	$row=mysqli_num_rows($fire);
	
	if($row>0){
		$data=mysqli_fetch_assoc($fire);
		$gettoken=$data['token'];
		$update="UPDATE `facebook` SET `token`='$token',`name`='$name',`email`='$email',`date`='$dates' WHERE `token`='$gettoken'";
		$updatequery=mysqli_query($conn,$update);
		if($updatequery){
            $_SESSION['token']=$token;
            $_SESSION['email']=$email;
           
			
			header("Location:done.php");

		}
	}else{

	

        $insert = "INSERT INTO `facebook`(`token`,`name`, `email`) VALUES ('$token','$name','$email')";
        $insertquery = mysqli_query($conn, $insert);
        
        if ($insertquery) {
            $_SESSION['token']=$token;
			$_SESSION['email']=$email;
			header("Location:done.php");

        }
    }
     echo '<div class="centre">Welcome User</div>';
     
     echo '<h3><b>Name :</b> '.$_SESSION['user_name'].'</h3>';
     echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
     echo '<h3><a href="logout.php">Logout</h3></div>';
    
    }
    
    else
    {
        
        echo $facebook_login_url;
    

    }
    ?>
   </div>
  </div>
 </body>
</html>

