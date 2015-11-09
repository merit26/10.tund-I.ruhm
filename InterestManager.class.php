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
		
		
		//kui ei ole, lisad uue
		
		
		
	
	
}
?>

