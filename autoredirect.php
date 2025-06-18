<html>
<head><title>Redirecter</title></head>
<body>
<?php
$nstr=$_GET["visit"];
$nstr=str_replace(" ","",$nstr);
echo $nstr;
list($part1,$part2)=explode("-",$nstr);
echo $part1;
echo $part2;
$part2=(int)($part2/10);
#header("Location: ".$part1.".php?money=".$part2);
header("Location: question.php?category=".$part1."&money=".$part2);
?>
</body>
</html>
