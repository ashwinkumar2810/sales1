<?php
include "connection.php";
//echo $_SESSION['uname']; 
$temp = $_SESSION['uname'];
$temp1 = TRIM($temp,"\t");

header("refresh:180;url=index.php");

$db_host = 'localhost'; // Server Name
$db_user = 'root'; // Username
$db_pass = 'root'; // Password
$db_name = 'sales1_db'; // Database Name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
}

$sql = "SELECT employid, name, emailid, contactno 
		FROM employ_db where employid='$temp1'";
		
$query = mysqli_query($conn, $sql);

if (!$query) {
	die ('SQL Error: ' . mysqli_error($conn));
}
?>
<html>
<head>
	<title>Employ Data</title>
	<style type="text/css">
body {
  background: url(op.png);
}	
div.absolute {
  position: absolute;
  bottom: 10px;
  width: 50%;
  border: 3px solid #8AC007;
}


}
	body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
			box-shadow: 0px 2px 2px 10px  gray;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: right;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
		#wrapper{
    border: 1px solid gray;
    border-radius: 5px;
    width: 320px;
    height: 220px;
    box-shadow: 0px 2px 2px 10px  gray;
    margin: 80 auto;
		}
		
	#wrapper input[type=submit]{
    padding: 7px;
    width: 100px;
    background-color: lightseagreen;
    border: 0px;
    color: white;
}
#wrapper button[type=submit]{
    padding: 7px;
    width: 100px;
    background-color: lightseagreen;
    border: 0px;
    color: white;
}

.logoutLblPos{

   position:fixed;
   right:650px;
   top:710px;
}
#format{
    border: 1px solid gray;
    border-radius: 5px;
    width: 320px;
    height: 150px;
    box-shadow: 0px 2px 2px 10px  gray;
    margin: 80 auto;
		}
	</style>
</head>
<body>
	<table class="data-table">
		<caption class="title"><h1>Employ Details</h1></caption>
		<h1>   </h1>
		<thead>
			<tr>
				<th>EmployId</th>
				<th>Name</th>
				<th>EmailId</th>
				<th>ContactNo</th>
			</tr>
			</p>
		</thead>
		<tbody>
		<?php
		$row = mysqli_fetch_array($query);
		{
			echo '<tr>
					<td>'.$row['employid'].'</td>
					<td>'.$row['name'].'</td>
					<td>'.$row['emailid'].'</td>
					<td>'.$row['contactno'].'</td>
				</tr>';
			//<input type="submit" value="import" name="but_import" id="but_import" />
		}?>
                
		</tbody>
	</table>

		<div id="wrapper">
		<h2>Upload Your Data</h2>
		<form method="post" action="index1.php" enctype="multipart/forms-data">
			
			<input type="submit" name="submit_file" value="Click to Upload"/>
			</form>
			<h2>Download Your Data</h2>
			<div class="btn">
				<form action="export.php" method="post">
					<button type="submit" id="btnExport" name='export'
					value="Export to Excel" class="btn btn-info">Click to Download </button>
					</form>
					</div>					
</form>	
<div id="format">
<h3>Download The Data Format to Upload your Data</h3>
<a href="details.xlsx">Download</a>		
</div>
<form align="right" name="form1" method="post" action="logout.php">
  <label class="logoutLblPos">
  <input name="submit2" type="submit" id="submit2" value="log out">
  </label>		
</body>
</html>