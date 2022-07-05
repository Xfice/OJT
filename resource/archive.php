<?php
session_start();
if($_SESSION['user']!='admin'){
	header("location:../index.php");
}
include "backend.php";
$server = new Backend();
extract($_POST);
extract($_GET);
if(isset($delid)){
	$server->deleteDocArc($delid);
}

if(isset($logoutb)){
	$server->logOut();
}
?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/style.css">
<!------ Include the above in your HEAD tag ---------->

</head>
<body>
<div class="row bg-success pad margin border1">
		<div class="col">
		<h1 class="hdr">Central Luzon State University Office</h1>
		</div>
</div>

<div class="row bg-warning pad1 margin1 border2 shadow-lg">
		<div class="col-3 text-center" style="margin-top:5px; margin-bottom:5px">
		<a href="addash.php" class="btn text-white bg-success border3">Document Requests</a>
		</div>
		<div class="col-3 text-center" style="margin-top:5px; margin-bottom:5px">
		<a href="archive.php" class="btn text-white bg-success border3">Archive</a>
		</div>
		<div class="col-6 text-right" style="margin-top:5px; margin-bottom:5px">
		<form method="post" style="margin-bottom:-5px;">
		<input type="submit" class="btn text-white bg-success border3" name="logoutb" value="Logout">
		</form>
		</div>
</div>

<div class="container col-12">
		<div class="col-12">
		
			<div class="card" style="margin: 8px 0px 15px -5px; border: solid black 1px;">
				<div class="card-header" style="border-bottom:solid black 1px;background-color: yellow;">
				<h1>Archive</h1>
				</div>
				<div class="card-body">
					<table class="table table-success">	
						<thead class="text-center">
							<tr>
								<th scope="col">Date Received</th>
								<th scope="col">Date Claimed</th>
								<th scope="col">Document Title</th>
								<th scope="col">Sender</th>
								<th scope="col">E-mail</th>
								<th scope="col">Actions</th>
								
							</tr>
						</thead>
						<tbody class="text-center">
						<?php
						$con=$server->conDB();
						$sql=$server->displayArchive();
						$res=$con->query($sql);
						while($row=mysqli_fetch_assoc($res)){
						?>
						<tr>
							<td><?php echo $row['daterec'];?></td>
							<td><?php echo $row['dateclaim'];?></td>
							<td><?php echo $row['title'];?></td>
							<td><?php echo $row['sender'];?></td>
							<td><?php echo $row['email'];?></td>
							<td><?php echo '<button class="btn btn-danger" onclick="deleteDocArchive('.$row['id'].')">Delete</button>';?></td>
						</tr>
						<?php
						}
						?>
							</tbody>
					</table>
				</div>
		</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
		$('table').DataTable();		
	});
function deleteDocArchive(id){
	if(confirm("Delete Record?")){
			window.location.href='archive.php?delid='+id;
			return true;
		
	}
}
</script>
</body>
</html>