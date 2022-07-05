<?php
	class DBConfig {

		// set attributes for database
		public $db_host = "localhost";
		public $db_user = "root";
		public $db_pass = "";
		public $db_name = "nameoop_db";

		// method for database connections
		public function dbConn() {
			// take note that this parameters must be in order
			// host, user, pass and finally database name
			// or else it will return an error
			$conn = mysqli_connect($this->db_host, 
				$this->db_user, $this->db_pass, $this->db_name);

				if ($conn->connect_error) {
					echo "Cannot connect to database." . $conn->connect_error;
				} else {
					return $conn;
				}
		}

		public function addUser($fname, $mi, $lname, $age, $birthdate) {
			// always create a local variable
			// $conn that will be used for
			// database connection
			$conn = $this->dbConn();

			// NULL is passed since our userID is auto incremented
			$sql = "INSERT INTO tbl_users (userID, userFname, userMI, userLname, userAge, userBirthdate) VALUES
			(NULL, '$fname', '$mi', '$lname', '$age', '$birthdate')";
			$conn->query($sql);
		}

		public function displayAll() {
			$conn = $this->dbConn();

			$sql = "SELECT * FROM tbl_users";
			$res = $conn->query($sql);
			
			echo '<table class="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>First Name</th>
							<th>M.I.</th>
							<th>Last Name</th>
							<th>Age</th>
							<th>Birthdate</th>
							<th>Actions</th>
						</tr>
					</thead>';

			if($res) {
				if($res->num_rows > 0) {
					while ($row = $res->fetch_assoc()) {
						echo '<tr>
								<td>'. $row['userID'] .'</td>
								<td>'. $row['userFname'] .'</td>
								<td>'. $row['userMI'] .'</td>
								<td>'. $row['userLname'] .'</td>
								<td>'. $row['userAge'] .'</td>
								<td>'. $row['userBirthdate'] .'</td>
								<td><a href=\'index.php?id='.$row['userID'].'\' name=\'del\' class=\'btn btn-danger\'>Delete</td>
								
							  </tr>';
					}
				} else {
					echo "<tr><td>No records found!</td></th>";
				}
			} else {
				echo "Query error!";
			}	
		}
		
		public function deleteUser($id){
			$conn = $this->dbConn();
			$sql = "delete from tbl_users where userID = '$id'";
			$res = $conn->query($sql);
			if ($res){	
			}else {	
			}	
		}
		public function updateUser($id,$upFname,$upLname,$upMI,$upAge,$upDay){
			$conn = $this->dbConn();
			$sql = "update tbl_users set userFname = '$upFname', userLname = '$upLname', userMI = '$upMI', userAge=$upAge, userBirthdate = '$upDay' where userID = $id";
			$res = $conn->query($sql);
			if ($res){	
			echo 'update sucess';
			}else {	
			echo $conn->error;
			}
		}
	}
?>