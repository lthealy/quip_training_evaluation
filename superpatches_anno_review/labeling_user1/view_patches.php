<html>
<head>
<?php $y = $_COOKIE["y"];?>
<title>view_patches</title>
<style>
.page_container {
    width: 100%;
    margin: auto;
}
.instance_container {
    border: 2px solid #73AD21;
    padding: 2px;
    float: left;
}
.label_frame {
    float: left;
}
.img_frame {
    float: left;
}
</style>
</head>
<body>

<?php
print "<body onScroll=\"document.cookie='y=' + window.pageYOffset\" onLoad='window.scrollTo(0,$y)'>";
?>

<?PHP
$page = $_GET['page'];
$ctype = $_GET['ctype'];
$key_lbl = $_GET['key_lbl'];
if($key_lbl == "")
	$key_lbl = "*";
?>

<a href="../home.php">Home</a>
<br>
<a href=view_patches.php?ctype=<?PHP printf("%s", $ctype);?>&page=<?PHP printf("%d", $page - 1);?>&key_lbl=<?PHP printf("%s", $key_lbl);?>>Prev Page</a>
<a href=view_patches.php?ctype=<?PHP printf("%s", $ctype);?>&page=<?PHP printf("%d", $page + 1);?>&key_lbl=<?PHP printf("%s", $key_lbl);?>>Next Page</a>
<p>
<?PHP printf('You are in tumor [<b>%s</b>], page [<b>%d</b>]', $ctype, $page); ?>
<p>

<?PHP
$N_per_page = 6;
$folder = sprintf("patches_%s", $ctype);
$valid_patches_pattern =  sprintf("./label_files_%s/im_id_*_lbl_%s_*.json", $ctype, $key_lbl);
$valid_patches = glob($valid_patches_pattern);

printf("<section class=\"page_container\">\n\n");

// for ($i = 1; $i <= $N_per_page; ++$i) {
for ($i = 0; $i < $N_per_page; ++$i) {
    $im_indx = $i + $page * $N_per_page;
	if($im_indx >= count($valid_patches))
		break;
	$savef_json = $valid_patches[$im_indx];
	$split_filename = split("_", basename($savef_json));
	$im_id = $split_filename[2];
	// $lbl = $split_filename[4]
    // $savef = sprintf("./label_files_%s/im_id_%d.txt", $ctype, $im_id);
    // // $savef_json = sprintf("./label_files_%s/im_id_%d.json", $ctype, $im_id);
    // $savef_json_pattern = sprintf("./label_files_%s/im_id_%d_*.json", $ctype, $im_id);
	// $files_arr = glob($savef_json_pattern);
	// if(count($files_arr) > 0){
		// $savef_json = $files_arr[0];
	if(file_exists($savef_json)){
		// echo "<script type='text/javascript'>alert('$savef_json');</script>";
		// echo "<script type='text/javascript'>alert('$im_id');</script>";
	    $myfile = file_get_contents($savef_json);
    // $myfile = fopen($savef_json, 'r')
	    //echo "<script type='text/javascript'>alert('$myfile');</script>";
		// var_dump($myfile);
		$json_a = json_decode($myfile, true);
		$class = $json_a['label_new'];
		$class_old = $json_a['label'];
		// var_dump($json_a);
		// echo "<script type='text/javascript'>alert('$class');</script>";
		$prediction = $json_a['prediction_val'];
		// var_dump($json_a);
		// echo "<script type='text/javascript'>alert('$prediction');</script>";
		if($class == "low")
			$class = "c1";
		elseif($class == "med")
			$class = "c2";
		elseif($class == "high")
			$class = "c3";
		elseif($class == "ignore")
			$class = "c4";
		else
			$class = "";

		if($class_old == "low")
			$class_old = "c1";
		elseif($class_old == "med")
			$class_old = "c2";
		elseif($class_old == "high")
			$class_old = "c3";
		elseif($class_old == "ignore")
			$class_old = "c4";
		else
			$class_old = "";
	}		
    elseif ($myfile = fopen($savef, 'r')){
        $class = fread($myfile, 20);
		$class_old = $class;
		$prediction=-1;
	}
    else{
        $class = '';
		$class_old = $class;
		$prediction=-1;
	}

    printf("<section class=\"instance_container\">\n");

    printf("<div class=\"label_frame\">\n");
    printf("<form name=\"label\" method=\"POST\" action=label.php?ctype=%s&page=%d&im_id=%d>\n", $ctype, $page, $im_id);
    printf("<input type=\"submit\" name=\"c1\" value=\"%s\"> Low <br>\n", strpos($class,'c1')!==false ? 'x':'  ');
    printf("<input type=\"submit\" name=\"c2\" value=\"%s\"> Medium <br>\n", strpos($class,'c2')!==false ? 'x':'  ');
    printf("<input type=\"submit\" name=\"c3\" value=\"%s\"> High <br>\n", strpos($class,'c3')!==false ? 'x':'  ');
    printf("<input type=\"submit\" name=\"c4\" value=\"%s\"> Ignore <br>\n", strpos($class,'c4')!==false ? 'x':'  ');
    printf("<br>\n");
    printf("<input type=\"submit\" name=\"cr\" value=\"  \"> Clear <br>\n");
    printf("</form>\n");
	
	printf("<b>Label original:</b> <br>");
	if(strpos($class_old,'c1')!==false)
		printf("Low  <br>");
	elseif(strpos($class_old,'c2')!==false)
		printf("Medium <br>");
	elseif(strpos($class_old,'c3')!==false)
		printf("High <br>");
	elseif(strpos($class_old,'c4')!==false)
		printf("Ignore <br>");
	// else{
		
	// }
	
	if ($prediction > -1) {
		printf("<br><b>Prediction: </b> <br>");
		if($prediction < 21){
			printf("Low (%d) <br>", $prediction);
		}
		elseif($prediction > 43){
			// printf("High (44-64) <br>");
			printf("High (%d) <br>", $prediction);
		}
		else{
			// printf("Medium (21-43) <br>");
			printf("Medium (%d) <br>", $prediction);
		}
	}
    printf("</div>\n");
	
    printf("<div class=\"img_frame\">\n");
    printf("<img height=400px src=\"%s/%d.png\"/>\n", $folder, $im_id);
    printf("</div>\n");
    printf("</section>\n\n");
}
printf("</section>\n");
?>

</body>
</html>

