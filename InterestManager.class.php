<?php
class InterestManager {
	
	private $connection;
	private $user_id;
	
	function __construct ($mysqli, $user_id) {
		
		$this->connection = $mysqli;
		$this->user_id = $user_id;
		
	}
	
	function addInterest($name){
		//kontrollime, et sellist veel ei ole
		
		$response = new StdClass();
        
        $stmt = $this->connection->prepare("SELECT id FROM interests WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        
        // kas saime rea andmeid
        if($stmt->fetch()){
            
            // huviala on juba olemas
            $error = new StdClass();
            $error->id = 0;
            $error->message = "Huviala '".$name."' on juba olemas";
            
            $response->error = $error;
            
            // pärast return käsku, fn'i enam edasi ei vaadata
            return $response;
            
        }
        $stmt->close();
        //siia olen jõudnud siis kui huviala ei olnud
        $stmt = $this->connection->prepare("INSERT INTO interests (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if($stmt->execute()){
            // sisestamine õnnestus
            $success = new StdClass();
            $success->message = "Huviala sisestatud";
            
            $response->success = $success;
            
        }else{
            //ei õnnestunud
            $error = new StdClass();
            $error->id = 1;
            $error->message = "Midagi läks katki";
            
            $response->error = $error;
        }
        $stmt->close();
        
        return $response;
        
    }
	
	function createDropdown(){
	  $html = '';		
		//lisan valikud
	  $html = '<select name="dropdown interest">';	
//// see lause tuleb teha nii, et näitaks ainult neid, mida kasutaja ei ole valinud.
	  $stmt=$this->connection->prepare("SELECT interests.id, interests.name, user_interests.id FROM interests 
	  JOIN user_interests ON WHERE user_interests.interests_id != ")
	  $stmt->bind_result($id, $name);
	  $stmt->execute();
	  
	  while($stmt->fetch()){
		   $html. = '<option value="'$id'">'.$name.'</option>';	
		  
	  }
	  
	    $stmt->close();
	  
	  //$html = '<option>Test 1</option>';	
	  //$html = '<option selected>Test 2</option>';	
	  $html .= '</select>';	

     return $html;	  
	}
	
	function addUserInterest($interests_id){
		//kontrollime, et sellist veel ei ole
		
		$response = new StdClass();
        
        $stmt = $this->connection->prepare("SELECT id FROM user_interests WHERE interests_id = ?");
        $stmt->bind_param("i", $interests_id);
        $stmt->execute();
        
        // kas saime rea andmeid
        if($stmt->fetch()){
            
            // huviala on juba olemas
            $error = new StdClass();
            $error->id = 0;
            $error->message = "Huviala '".$name."' on juba olemas";
            
            $response->error = $error;
            
            // pärast return käsku, fn'i enam edasi ei vaadata
            return $response;
            
        }
        $stmt->close();
        //siia olen jõudnud siis kui huviala ei olnud
        $stmt = $this->connection->prepare("INSERT INTO user_interests (user_id, interests_id) VALUES (?,?)");
        $stmt->bind_param("i,i", $this->user_id, $interests_id);
        if($stmt->execute()){
            // sisestamine õnnestus
            $success = new StdClass();
            $success->message = "Huviala lisatud";
            
            $response->success = $success;
            
        }else{
            //ei õnnestunud
            $error = new StdClass();
            $error->id = 1;
            $error->message = "Midagi läks katki";
            
            $response->error = $error;
        }
        $stmt->close();
        
        return $response;
        
    }
		
	function GetUserInterest();
		//saada kätte ja saata tagasi kõik kasutaja huvialad
		//kasutaja id $this->user_id
		//kõik tema huvialade nimed
		
	 $stmt = $this->connection->prepare("SELECT interests.name FROM user_interests INNER JOIN interests on user_interests.interests_id=interests_id WHERE user_interests_user_id=?");
     $stmt->bind_param("i", $this->user_id);
	 $stmt->bind_result($name);
	 $stmt->fetch()){
		echo $name." <br>"; 
		 
	 }
	
}
?>

