<html>
<head>
<title>label</title>
</head>
<body>

<?PHP
$ctype = $_GET['ctype'];
$page = $_GET['page'];
$im_id = $_GET['im_id'];

$savef = sprintf("./label_files_%s/im_id_%d.txt", $ctype, $im_id);
$savef_json = sprintf("./label_files_%s/im_id_%d_*.json", $ctype, $im_id);
$savef_json = glob($savef_json)[0];
if(file_exists($savef_json)){
	// echo "<script type='text/javascript'>alert('$savef_json');</script>";
	$myfile = file_get_contents($savef_json);
	$json_a = json_decode($myfile, true);
	if (isset($_POST['cr']))
		$json_a['label_new']="";
	if (isset($_POST['c1']))
		$json_a['label_new']="low";
    if (isset($_POST['c2']))
		$json_a['label_new']="med";
    if (isset($_POST['c3']))
		$json_a['label_new']="high";
    if (isset($_POST['c4']))
		$json_a['label_new']="ignore";
	$newJsonString = json_encode($json_a);
	file_put_contents($savef_json, $newJsonString);
}
// if (isset($_POST['cr']))
    // unlink($savef);
// else {
    // $myfile = fopen($savef, 'w') or die('Unable to open file for status saving! Please contact Le Hou');
    // if (isset($_POST['c1']))
        // fwrite($myfile, sprintf("c1"));
    // if (isset($_POST['c2']))
        // fwrite($myfile, sprintf("c2"));
    // if (isset($_POST['c3']))
        // fwrite($myfile, sprintf("c3"));
    // if (isset($_POST['c4']))
        // fwrite($myfile, sprintf("c4"));
    // fclose($myfile);
// }

$url = sprintf("Location: view_patches.php?ctype=%s&page=%d", $ctype, $page);
header($url);
?>

</body>
</html>

