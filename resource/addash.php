<?php
session_start();

include "backend.php";
$server = new Backend;
extract($_POST);
extract($_GET);
if($_SESSION['user']!='admin'){
	header("location:../index.php");
}
if(isset($insertbutton)){
	
	$server->addDocs($name,$title,$email);
}

if(isset($notifyid)){
	$server->notifySender($notifyid);
}
if(isset($claimid)){	
	$server->claimedDoc($claimid);
	
}

if(isset($delid)){
	$server->deleteDocDash($delid);
}

if(isset($mupdate)){
	$server->updateDoc($updateid,$msender,$mtitle,$memail);
}
if(isset($logoutb)){
	$server->logOut();
}
?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.js"></script>
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

<div class="row margin1">
		<div class="col-4">
			<div class="card" style="margin: 8px -10px 10px 0px; border: solid black 1px;">
				<div class="card-header" style="border-bottom:solid black 1px;background-color: yellow;">
				<h1>Fill up Form</h1>
				</div>
				<div class="card-body" id="cardid">
				<form method="post" action="addash.php">
					
					<div class="form-group">
					<label>Name:</label>
					<input type="text" class="form-control" name="name" placeholder="Last Name, First Name, M.I." required>
					</div>
					<div class="form-group">
					<label>Document Title:</label>
					<input type="text" class="form-control" name="title" placeholder="Title" required>
					</div>
					<div class="form-group">
					<label>E-mail:</label>
					<input type="text" class="form-control" name="email" placeholder="username@mail.com" required>
					</div>
					<div class="form-group">
					<input type="submit" class="btn btn-success float-right " style="margin-left:5px;" name="insertbutton" id="insertbtn" data-toggle="modal" data-target="Modal">
					<input type="reset" class="btn btn-danger float-right">
					
					</div>
				</form>
				</div>
			</div>
		</div>
		<div class="col-8">
		
			<div class="card" style="margin: 8px 0px 15px -5px; border: solid black 1px;">
				<div class="card-header" style="border-bottom:solid black 1px;background-color: yellow;">
				<h1>Documents List</h1>
				</div>
				<div class="card-body">
					<table class="table table-success">	
						<thead class="text-center">
							<tr>
								<th scope="col" style="display:none">ID</th>
								<th scope="col">Date</th>
								<th scope="col">Document Title</th>
								<th scope="col">Sender</th>
								<th scope="col">E-mail</th>
								<th scope="col">Actions</th>
								
							</tr>
						</thead>
						<tbody class="text-center">
						<?php
						$con=$server->conDB();
						$sql=$server->displayDocsDash();
						$res=$con->query($sql);
						while($row=mysqli_fetch_assoc($res)){
						?>
						<tr>
							<td style="display:none"><?php echo $row['id']?></td>
							<td><?php echo $row['date'];?></td>
							<td><?php echo $row['title'];?></td>
							<td><?php echo $row['sender'];?></td>
							<td><?php echo $row['email'];?></td>
							<td><?php echo '<button class="btn" name="notify" style="background-color: orange; color:white" id="notifybtn" onclick="notifyUser('.$row['id'].')">Notify</button> 
							<button class="btn btn-primary updatebtn" name="update">Update</button>  
							<button class="btn btn-success" name="claimed" id="claimedbtn" onclick="claimedAlert('.$row['id'].')">Claimed</button> 
							<button class="btn btn-danger" name="delete" onclick="deleteDoc('.$row['id'].')">Delete</button>';?></td>
						</tr>
						<?php
						}
						?>
							</tbody>
					</table>
				</div>
			</div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:yellow; border: 1px solid black">
        <h5 class="modal-title" id="exampleModalLabel">Update Document</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"style="border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; ">
        <form method="post" action="addash.php">
							<input type="hidden" name="updateid" id="updateid">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" id="mname" name="msender"  required>
							</div>
							<div class="form-group">
								<label>Document Title</label>
								<input type="text" class="form-control" id="mtitle" name="mtitle"  required>
							</div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="text" class="form-control" id="memail" name="memail"  required>
							</div>
							
	
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="mupdate">Update</button>
      </div>
	  </form>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('table').DataTable();	
			
	});
	$('.updatebtn').on('click',function(){
			$('#Modal').modal('show');
			$tr=$(this).closest('tr');
			var data = $tr.children("td").map(function(){
				return $(this).text();
			}).get();
			
			$('#updateid').val(data[0]);
			$('#mname').val(data[3]);
			$('#mtitle').val(data[2]);
			$('#memail').val(data[4]);
			
		});		
	function claimedAlert(id){
		window.location.href='addash.php?claimid='+id;
		alert("Moved to Archive");
	}
	function deleteDoc(id){
		if(confirm("Delete Record?")){
			window.location.href='addash.php?delid='+id;
			return true;
		}
	}
	function notifyUser(id){
		window.location.href='addash.php?notifyid='+id;
		alert("E-mail has been sent");
	}
</script>
</body>
</html>