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
if (isset($_POST['cr']))
    unlink($savef);
else {
    $myfile = fopen($savef, 'w') or die('Unable to open file for status saving! Please contact Le Hou');
    if (isset($_POST['c1']))
        fwrite($myfile, sprintf("c1"));
    if (isset($_POST['c2']))
        fwrite($myfile, sprintf("c2"));
    if (isset($_POST['c3']))
        fwrite($myfile, sprintf("c3"));
    if (isset($_POST['c4']))
        fwrite($myfile, sprintf("c4"));
    fclose($myfile);
}

$url = sprintf("Location: view_patches.php?ctype=%s&page=%d", $ctype, $page);
header($url);
?>

</body>
</html>

