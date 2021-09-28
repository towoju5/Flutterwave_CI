<?php
/**
* Multi file upload example
* @author Resalat Haque
* @link http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
**/

$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$max_file_size = 1024*1000; //1000 kb
$path = "uploads/"; // Upload directory
$count = 0;

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	// Loop $_FILES to execute all files
	foreach ($_FILES['files']['name'] as $f => $name) {     
	    if ($_FILES['files']['error'][$f] == 4) {
	        continue; // Skip file if any error found
	    }	       
	    if ($_FILES['files']['error'][$f] == 0) {	           
	        if ($_FILES['files']['size'][$f] > $max_file_size) {
	            $message[] = "$name is too large!.";
	            continue; // Skip large files
	        }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
	        else{ // No error found! Move uploaded files 
	            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name)) {
	            	$count++; // Number of successfully uploaded files
	            }
	        }
	    }
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Multiple File Upload</title>
<style type="text/css">
a{ text-decoration: none; color: #333}
h1{ font-size: 1.9em; margin: 10px 0}
p{ margin: 8px 0}
*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-font-smoothing: antialiased;
	-moz-font-smoothing: antialiased;
	-o-font-smoothing: antialiased;
	font-smoothing: antialiased;
	text-rendering: optimizeLegibility;
}
body{
	font: 12px Arial,Tahoma,Helvetica,FreeSans,sans-serif;
	text-transform: inherit;
	color: #333;
	background: #e7edee;
	width: 100%;
	line-height: 18px;
}
.wrap{
	width: 500px;
	margin: 15px auto;
	padding: 20px 25px;
	background: white;
	border: 2px solid #DBDBDB;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	overflow: hidden;
	text-align: center;
}
.status{
	/*display: none;*/
	padding: 8px 35px 8px 14px;
	margin: 20px 0;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	color: #468847;
	background-color: #dff0d8;
	border-color: #d6e9c6;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}
input[type="submit"] {
	cursor:pointer;
	width:100%;
	border:none;
	background:#991D57;
	background-image:linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-moz-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-webkit-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	color:#FFF;
	font-weight: bold;
	margin: 20px 0;
	padding: 10px;
	border-radius:5px;
}
input[type="submit"]:hover {
	background-image:linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-moz-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-webkit-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	-webkit-transition:background 0.3s ease-in-out;
	-moz-transition:background 0.3s ease-in-out;
	transition:background-color 0.3s ease-in-out;
}
input[type="submit"]:active {
	box-shadow:inset 0 1px 3px rgba(0,0,0,0.5);
}
</style>

</head>

<script type="text/javascript">
function imageval(){   /*Image size validation*/

	var fileUpload = document.getElementById("photoimg");
		    //Check whether the file is valid Image.
	var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.gif)$");
	//if (regex.test(fileUpload.value.toLowerCase())) {
	//Check whether HTML5 is supported.
	//if (typeof (fileUpload.files) != "undefined") {
	//Initiate the FileReader object.
	var reader = new FileReader();
	//Read the contents of Image File.
	reader.readAsDataURL(fileUpload.files[0]);
	reader.onload = function (e) {
	//Initiate the JavaScript Image object.
	var image = new Image();
	//Set the Base64 string return from FileReader as source.
	image.src = e.target.result;
	//Validate the File Height and Width.
	image.onload = function () {
	var height = this.height;
	var width = this.width;
	
	if (width < 700 || height < 467) {
	alert("Image Height and Width should be above 700 * 467 px.");
	return false;
	}
	
	document.getElementById('ImgForm').submit();
	//alert("Uploaded image has valid Height and Width.");

	//return true;
	
	};
	}
	//} else {
	//alert("This browser does not support HTML5.");
	//return false;
	//}
	/*} else {
	alert("Please select a valid Image file.");
	return false;
	}*/
	}
</script>



<body>

	<div class="wrap">
		<h1>Rentals Photo</h1>
		<?php
		# error messages
		if (isset($message)) {
			foreach ($message as $msg) {
				printf("<p class='status'>%s</p></ br>\n", $msg);
			}
		}
		# success message
		if($count !=0){
			printf("<p class='status'>%d files added successfully!</p>\n", $count);
		}
		?>
		<!-- (1349px X 500px)--><p>Photo size Above (700 X 467 px)..! Valid formats jpg, png, gif,jpeg..! </p>
		<br />
		<br />
		<!-- Multiple file upload html form-->
		<form action="admin/product/InsertProductImage1" method="post" id="ImgForm" enctype="multipart/form-data">
			<input type="file" name="files[]" multiple accept="image/*" id="photoimg" onchange="imageval();">
            
            <input type="hidden" name="prdiii" value="<?php echo $_GET['id']; ?>" />
			<!--<input type="submit" value="Upload">-->
		</form>
</div>
</body>
</html>