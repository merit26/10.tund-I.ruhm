<?php
    require_once("functions.php");
    require_once("InterestManager.class.php");
	
    if(!isset($_SESSION['id_from_db'])){
        header("Location: login.php");
        // ära enne suunamist midagi rohkem tee
        exit();
    }
    
    if(isset($_GET["logout"])){
        session_destroy();
		
        header("Location: login.php");
		exit();
    }
    //*************HALDUS
	$InterestManager=new InterestManager($mysqli, $_SESSION['id_from_db']);
	
	if(isset($_GET["new_interest"])){
		$add_interest_response = $InterestManager->addInterest($_GET["new_interest"]);
		}
	// siin on mingi jama	
	if(isset($_GET["dropdown_interest"])){
		$add_user_interest_response = $InterestManager->addUserInterest($_GET["dropdown_interest"]);
		}
?>
	
<p>   

Tere, <?=$_SESSION['user_email'];?> <a href="?logout=1">Logi välja</a>

<p/>


<h2>Lisa huviala</h2>

<?php if(isset($add_interest_response->error)): ?>
<p style="color:red;">
    <?=$add_interest_response->error->message;?>
</p>

<?php elseif(isset($add_interest_response->success)): ?>
<p style="color:green;">
  <?=$add_interest_response->success->message;?>
</p>

<?php endif; ?>  

<form>
  	<input name="new interest" > <br>
  	  	<input type="submit">
  </form>
 

<h2>Minu huvialad</h2>
<form> 
 <?php if(isset($add_user_interest_response->error)): ?>
 
 <p style="color:red;">
 <?=$add_user_interest_response->error->message;?>
 </p>
 
 <?php elseif(isset($add_user_interest_response->success)): ?>
 <p style="color:green;">
 <?=$add_user_interest_response->success->message;?>
 
 </p>
 <?php endif; ?>  
 <form> 
   <?=$InterestManager->createDropdown();?>
 <input value="lisa" type="submit">
</form>

<h2>Loetelu</h2>
<?=$InterestManager->getUserInterests();?>

