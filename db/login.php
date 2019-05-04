<?php
include 'mysql_connection.php';
$response = array();
$data= array();
 
//Check for mandatory parameters
if(isset($_POST['username'])&&isset($_POST['userpass'])&&isset($_POST['login_date'])){
	$username = $_POST['username'];
	$userpass = $_POST['userpass'];
	$login_date = $_POST['login_date'];
	
	//Query check user
	$query = "SELECT id_connection, id_user FROM connection WHERE username = ? AND userpass = ?";
	
	//Prepare the query
	if($stmt = $con->prepare($query)){
		//Bind parameters
		$stmt->bind_param("ss",$username,$userpass);
		
		//Exceting MySQL statement
		$stmt->execute();
		//Bind fetched result
		$stmt->bind_result($id_connection, $id_user);
		//Check for results		
		if($stmt->fetch()){
			$data["id_user"] = $id_user;
			$stmt->close();	
			
			$query = "INSERT INTO login( id_connection, login_date) VALUES (?,?)";
			if($stmt = $con->prepare($query)){
				//Bind parameters
				$stmt->bind_param("is",$id_connection,$login_date);
				//Exceting MySQL statement
				$stmt->execute();
				if($stmt->affected_rows == 1){
					$response["success"] = 1;
					$response["message"] = "USER CONNECTED";
					$response["data"] = $data;		
					$stmt->close();	
				}else{
					$response["success"] = 0;
					$response["message"] = "Error while connecting";
				}	
			}else{
				$response["success"] = 0;
				$response["message"] = "Error login";
			}	
		}else{
			$response["success"] = 0;
			$response["message"] = "User not found";
		}	
	}else{
		$response["success"] = 0;
		$response["message"] = "Error connection";
	}
 
}else{
	//parameters are missing
	$response["success"] = 0;
	$response["message"] = "missing parameters";
}
//Displaying JSON response
echo json_encode($response);
?>