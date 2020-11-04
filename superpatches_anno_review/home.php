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
<h2 > Review patches with extreme difference between label and prediction <br> <br> </h2 >
<h3 >Label values are (low, medium, high) <br> </h3>
<h3 >Prediction value range is (0 - 64) <br> <br> </h3>
<h2 >Showing patches with the following criteria: <br>  </h2>
<h3 >Label = Low          &   Prediction >= 30  <br> </h3>
<h3 >Label = High         &   Prediction <= 30  <br> </h3>
<h3 >Label = Medium   &  Prediction >= 50  <br> </h3>
<h3 >Label = Medium   &  Prediction <= 15  <br> </h3>

<?PHP 
$ctype_list=array("acc","brca","esca","hnsc","kirc","lihc","meso","ov","paad","prad","sarc","tgct","thym");
printf('<h2><b>User 1 (John)<b></h3>'); 
foreach ($ctype_list as $ctype){
	// printf("<h2>&emsp; <b>%s <b></h2>", $ctype);
	printf("<h2>&emsp; <a href=labeling_user1/view_patches.php?ctype=%s&page=0>%s</a></h2>",$ctype,$ctype);
}
printf('<h2><b>User 2 (Ann)<b></h3>'); 
foreach ($ctype_list as $ctype){
	printf("<h2>&emsp; <a href=labeling_user2/view_patches.php?ctype=%s&page=0>%s</a></h2>",$ctype,$ctype);
}
printf('<h2><b>User 3 (Rebecca)<b></h3>'); 
foreach ($ctype_list as $ctype){
	printf("<h2>&emsp; <a href=labeling_user3/view_patches.php?ctype=%s&page=0>%s</a></h2>",$ctype,$ctype);
}

?>

</body>
</html>

