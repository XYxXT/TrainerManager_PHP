<?php
include 'mysql_connection.php';




for ($i = 1; $i <= 10; $i++) {
	$query = "INSERT INTO trainer(birthdate, gender, race, nacionality, blood_type) VALUES (?,?, ?, ?, ?)";
		if($stmt = $con->prepare($query) or trigger_error($con->error)){
			//Bind parameters
			$birthdate = rand(1970, 2010) . '-'. rand(01, 12) . '-' . rand(1, 28);
			$gender = rand(1, 2);
			$race = rand(1, 5);
			$nacionality = rand(1, 7);
			$blood_type = rand(1, 4);
			$stmt->bind_param("siiii",$birthdate,$gender, $race, $nacionality,$blood_type);
			//Exceting MySQL statement
			$stmt->execute();
			if($stmt->affected_rows == 1){	
				$stmt->close();	
				echo "INSERT SUCCESS";
			}else{
				echo $stmt->error;
			}

		}else{
			echo $stmt->error;
		}
}


?>