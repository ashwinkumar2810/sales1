<?php
SESSION_START();
$temp = $_SESSION['uname'];
$temp1 = TRIM($temp,"\t");
header("refresh:180;url=index.php");

$conn = mysqli_connect("localhost","root","test","sales1_db");
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');


if (isset($_POST["import"]))
{
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $employid = "";
                if(isset($Row[0])) {
                    $employid = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                $fy = "";
                if(isset($Row[1])) {
                    $fy = mysqli_real_escape_string($conn,$Row[1]);
                }
				
                $school = "";
                if(isset($Row[2])) {
                    $school = mysqli_real_escape_string($conn,$Row[2]);
				}
				
				$city = "";
                if(isset($Row[3])) {
                    $city = mysqli_real_escape_string($conn,$Row[3]);
				}
				
				$subject = "";
                if(isset($Row[4])) {
                    $subject = mysqli_real_escape_string($conn,$Row[4]);
				}
				
				$class = "";
                if(isset($Row[5])) {
                    $class = mysqli_real_escape_string($conn,$Row[5]);
				}
				
				$revenue = "";
                if(isset($Row[6])) {
                    $revenue = mysqli_real_escape_string($conn,$Row[6]);
				}
				
				
                if (!empty($employid) || !empty($fy) || !empty($school) || !empty($city) || !empty($subject) || !empty($class) || !empty($revenue)) {
                 
				  //$query = "INSERT into details(employid,fy,school,city,subject,class,revenue) values('$employid','$fy','$school','$city','$subject','$class','$revenue')";
				  $query = "INSERT into details1(employid,fy,school,city,subject,class,revenue) values('$employid','$fy','$school','$city','$subject','$class','$revenue')";
                    $result = mysqli_query($conn, $query);
					
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
			 $query1="SELECT DISTINCT * into #temptbl from Detals1 
			  DELETE from details1
			  INSERT into details1
			  SELECT * from #tmptbl drop table #temptbl";
			  $result = mysqli_query($conn, $query1);
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
  
}
?>

<!DOCTYPE html>
<html>    
<head>
<style>  
body {
  background: url(op.png);
}  
body {
	font-family: Arial;
	width: 550px;
}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
    border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
    padding: 5px 20px;
    font-size:0.9em;
}

.tutorial-table {
    margin-top: 40px;
    font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
    background: #f0f0f0;
    border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
    background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
.logoutLblPos{

   position:fixed;
   right:950px;
   top:70px;
}
</style>
</head>

<body>
    <h2>Upload Your Data</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
     
<?php
	//$sqlSelect = "DELETE FROM details1 where employid=0";
	$sqlSelect = "DELETE FROM details1 where employid=0";
	$result = mysqli_query($conn, $sqlSelect);
    $sqlSelect = "SELECT DISTINCT * FROM details1 where employid='$temp1'";
	//$sqlSelect = "SELECT DISTINCT * FROM details1 where employid='$temp1'";
    $result = mysqli_query($conn, $sqlSelect);

if (mysqli_num_rows($result) > 0)
{
?>
        
    <table class='tutorial-table'>
        <thead>
            <tr>
                <th>employid</th>
                <th>fy</th>
				<th>school</th>
				<th>city</th>
				<th>subject</th>
				<th>class</th>
				<th>revenue</th>

            </tr>
        </thead>
<?php
    while ($row = mysqli_fetch_array($result)) {
?>                  
        <tbody>
        <tr>
            <td><?php  echo $row['employid']; ?></td>
            <td><?php  echo $row['fy']; ?></td>
			<td><?php  echo $row['school']; ?></td>
			<td><?php  echo $row['city']; ?></td>
			<td><?php  echo $row['subject']; ?></td>
			<td><?php  echo $row['class']; ?></td>
			<td><?php  echo $row['revenue']; ?></td>
        </tr>
<?php
    }
?>
        </tbody>
    </table>
<?php 
} 
?>
<form align="right" name="form1" method="post" action="logout.php">
  <label class="logoutLblPos">
  <input name="submit2" type="submit" id="submit2" value="log out">
  </label>
</form>
</body>
</html>