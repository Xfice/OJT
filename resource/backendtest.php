<?php
class Backend{
	public $db_host = "localhost";
	public $db_user = "root";
	public $db_pass = "";
	public $db_name = "ojt";
	
	public function conDB(){
		$con = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
		if($con->connect_error){
			echo "Connection error".$con->connect_eror;
		}else
			return $con;
	}
	
	public function logIn($user,$pass){
		$vrfy = $this->conDB();
		$qry = "select username,replace(cast(aes_decrypt(password,'key1234') as char(100)), salt, ''), salt from users";
		$res = $vrfy->query($qry);
		//echo 'alert("Invalid Username or Passwordasd");';
		if($res)
				while($row=$res->fetch_assoc()){
					if($row['username']==$user && $row['replace(cast(aes_decrypt(password,\'key1234\') as char(100)), salt, \'\')']==$pass)
					if($user=='admin')
							header('location:resource/addash.php');
						else if($user=='associate')
							header('location:resource/asdash.php');	
				}
			
		 echo 'alert("Invalid Username or Password");';
	}
	
	public function addDocs($paramname, $paramtitle, $paramemail){
		$con = $this->conDB();
		
		$qry = "insert into dashboard (date,title, sender, email) values (CURDATE(),'$paramtitle', '$paramname', '$paramemail');";
		$res = $con->query($qry);
		if($res){
			
		}else {
			
		}
	}
	
	public function filterresult(){
		
	}
	
	public function displayDocsDash(){
		$con = $this->conDB();
		return $sql='SELECT * FROM dashboard';
	}
	
	public function searchDocs($keyword){
		$con = $this->conDB();
		$keyword = preg_replace("#[^0-9a-z]#","",$keyword);
		$qry = "select * from dashboard where concat (date,title,sender,email) like '%$keyword%'";
		$res=$con->query($qry);
		/*(while($row=mysqli_fetch_assoc($res)){
			echo "".$row['id']." ".$row['date']." ".$row['title']." ".$row['sender']." ".$row['email']." ";
			
		}*/
		while($row=mysqli_fetch_assoc($res)){
		$qry1 = "insert into dashsearchtemp (id,date,title,sender,email) values (".$row['id'].",'". $row['date']."','". $row['title']."','". $row['sender']."','". $row['email']."')";
		$res2=$con->query($qry1);
		}
		$qry2 = "select * from dashsearchtemp";
		return $qry2;
	}
	
	public function displayArchive(){
		$con = $this->conDB();

		$results_per_page = 10;

		$sql='SELECT * FROM archive';
		$result = mysqli_query($con, $sql);
		$number_of_results = mysqli_num_rows($result);
		
		$number_of_pages = ceil($number_of_results/$results_per_page);

		if (!isset($_GET['page'])) {
		$page = 1;
		} else {
		$page = $_GET['page'];
		}

		$this_page_first_result = ($page-1)*$results_per_page;

		$sql='SELECT * FROM archive LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
		$result = mysqli_query($con, $sql);
		
		while($row = mysqli_fetch_array($result)) {
		echo '<tr>
								<td>'.$row['daterec'].'</td>	
								<td>'.$row['dateclaim'].'</td>	
								<td>'.$row['title'].'</td>
								<td>'.$row['sender'].'</td>
								<td>'.$row['email'].'</td>
								<td>
								<a href="archive.php?id=$row[\'id\']" class="btn btn-danger" name="deletebutton">Delete</a>
								</td>
							<tr>
						';
		}
		echo '</tbody>
					</table>
				</div>';
		echo '<div class="card-footer">
					<div class="text-center">';
		for ($page=1;$page<=$number_of_pages;$page++) {
		echo '<a href="archive.php?page=' . $page . '" class="btn btn-success">' . $page . '</a> ';
		}				
						
		echo'			</div>
				</div>';
		
	}
	

	public function paginateResultDash($pqry,$pageword){
		$con = $this->conDB();
		$res = $con->query($pqry);
		
		$results_per_page = 10;
		$number_of_results = mysqli_num_rows($res);
		
		$number_of_pages = ceil($number_of_results/$results_per_page);

		if (!isset($_GET['page'])) {
		$page = 1;
		} else {
		$page = $_GET['page'];
		}

		$this_page_first_result = ($page-1)*$results_per_page;

		$sql="".$pqry." limit " . $this_page_first_result . "," .  $results_per_page;
		$result = mysqli_query($con, $sql);

		while($row = mysqli_fetch_array($result)) {
		echo '<tr>
								<td>'.$row['date'].'</td>	
								<td>'.$row['title'].'</td>
								<td>'.$row['sender'].'</td>
								<td>'.$row['email'].'</td>
								<td>
								<a href="test.php?id=$row[\'id\']" class="btn btn-danger" name="notify">Notify</a>
								<a href="test.php?id=$row[\'id\']" class="btn btn-success" name="claimed">Claimed</a>
								</td>
							<tr>
						';
		}
		echo '</tbody>
					</table>
				</div>';
		echo '<div class="card-footer">
					<div class="text-center">';
		for ($page=1;$page<=$number_of_pages;$page++) {
		echo '<a href="test.php?'.$pageword.'=' . $page . '" class="btn btn-success">' . $page . '</a> ';
		}			
		/*$prev = $page-1;
		$next = $page+1;
		echo "<a href='test.php?page=$prev' class='btn btn-success'>prev</a> "; 
		echo " <a href='test.php?page=$next' class='btn btn-success'>next</a> ";
		*/
		echo'			</div>
				</div>';
		
	}
	
	public function paginateResultArchive($pqry){
		
	}
}
?>