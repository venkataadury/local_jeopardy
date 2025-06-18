<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Media Page</title>
	<link rel="stylesheet" href="main-style.css">
	<link rel="stylesheet" href="floating-footer-style.css">
</head>
<body>
<?php include("floating_table_logic.php");?>
<h1>Question for $<?php echo $_GET["money"]*100; ?></h1>

    <div class="content">
        <?php
        if (isset($_GET['money'])) {
            $key = $_GET['money']; 
            $filename = "GuessThePeople/" . $key . "q.txt";
            if (file_exists($filename)) {
                echo nl2br(htmlspecialchars(file_get_contents($filename)));
	    }
	    else {
		    echo "<i>ERR: Question not found</i>";
	    }
        } else {
            echo "<p>ERR: Question key (money) variable not given!</p>";
        }
        ?>
    </div>
<?php
	if(isset($_GET["showtext"])) $ap="";
	else $ap="autoplay";
	# Optional (if file exists)
	if(file_exists("GuessThePeople/".$_GET["money"]."q.mp4")) {
    echo '<div class="media">
        <video width="640" height="360" controls '.$ap.'>
            <source src="GuessThePeople/'.$_GET["money"].'q.mp4" type="video/mp4">
            Your browser does not support the video element.
	</video></div>';}
	?>


    <form method="get">
	<input type="hidden" name="money" value="<?php echo isset($_GET['money']) ? htmlspecialchars($_GET['money']) : ''; ?>">
        <button type="submit" name="showText" value="1">Answer</button>
    </form>

    <?php
	if (isset($_GET['showText'])) {
	echo '<p></p><div class="content"><p style="font-size:24px">';
        if (isset($_GET['money'])) {
            $key = $_GET['money']; 
            $filename = "GuessThePeople/" . $key . "a.txt";
            if (file_exists($filename)) {
		    echo '<b>';
		    echo nl2br(htmlspecialchars(file_get_contents($filename)));
		    echo '</b>';
	    }
        } else {
            echo "<p>ERR: Answer key (money) not given!</p>";
        }
	echo '</p></div>';
	$ap = isset($_GET['money']);
	if($ap) $ap="autoplay";
	else $ap="";

	# Optional (if file exists)
	if(file_exists("GuessThePeople/".$_GET["money"]."a.mp3")) {
    echo '<div class="media">
        <audio controls autoplay>
            <source src="GuessThePeople/'.$_GET["money"].'a.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio></div>';}
    }
    ?>
<?php include("floating_table.php");?>
</body>
</html>
