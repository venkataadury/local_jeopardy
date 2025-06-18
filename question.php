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

<?php
    $DATA_FOLDER="data/";
    $QUESTION_PREFIX=$DATA_FOLDER."/".$_GET["category"]."-".$_GET["money"];
    $QUESTION_FILE=$QUESTION_PREFIX."q.txt";

    if(!isset($_GET["money"]) || !is_numeric($_GET["money"]) || $_GET["money"]<1 || $_GET["money"]>100) {
        echo "<p>ERR: Invalid money value!</p>";
        include("floating_table.php");
        exit;
    }
    if(!isset($_GET["category"])) {
        echo "<p>ERR: Category not given!</p>";
        include("floating_table.php");
        exit;
    }
    if(!file_exists($QUESTION_FILE)) {
        echo "<p>ERR: Question file not found! Looking for file '".$QUESTION_FILE."'</p>";
        include("floating_table.php");
        exit;
    }
    $question = file_get_contents($QUESTION_FILE);
    if ($question === false) {
        echo "<p>ERR: Could not read question file!</p>";
        include("floating_table.php");
        exit;
    }
    echo '<div class="content"><p style="font-size:24px">';
    echo nl2br(htmlspecialchars($question));
    echo '</p></div>';

	if(isset($_GET["showText"])) $ap="";
	else $ap="autoplay";
	# Optional (if file exists)
	if(file_exists($QUESTION_PREFIX."q.mp4")) {
    echo '<div class="media">
        <video width="640" height="360" controls '.$ap.'>
            <source src="'.$QUESTION_PREFIX."q.mp4".'" type="video/mp4">
            Your browser does not support the video element.
	</video></div>';}
	if(file_exists($QUESTION_PREFIX."q.mp3")) {
    echo '<div class="media">
        <audio controls '.$ap.'>
            <source src="'.$QUESTION_PREFIX."q.mp3".'" type="audio/mp3">
            Your browser does not support the video element.
	</audio></div>';}
	
    if(file_exists($QUESTION_PREFIX."q.png")) {
    echo '<div class="media">
        <img src="'.$QUESTION_PREFIX."q.png".'" alt="Question Image" style="max-width: 100%; height: auto;">
    </div>';} else if(file_exists($QUESTION_PREFIX."q.jpg")) {
    echo '<div class="media">
        <img src="'.$QUESTION_PREFIX."q.jpg".'" alt="Question Image" style="max-width: 100%; height: auto;">
    </div>';}
	?>


    <form method="get">
        <input type="hidden" name="money" value="<?php echo isset($_GET['money']) ? htmlspecialchars($_GET['money']) : ''; ?>">
        <input type="hidden" name="category" value="<?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category']) : ''; ?>">

        <button type="submit" name="showText" value="1">Answer</button>
    </form>

    <?php
	if (isset($_GET['showText'])) {
	    echo '<p></p><div class="content"><p style="font-size:24px">';
        $file_prefix = $DATA_FOLDER . "/" . $_GET['category'] . "-" . $_GET['money'];
        $filename = $file_prefix . "a.txt";
        if (file_exists($filename)) {
            echo '<b>';
            echo nl2br(htmlspecialchars(file_get_contents($filename)));
            echo '</b>';
        } else {
            echo "<p>ERR: Answer file not found! Looking for file '".$filename."'</p>";
        }
        echo '</p></div>';
    
        # Check if autoplay is requested
        $ap = isset($_GET['money']);
        if($ap) $ap="autoplay";
        else $ap="";

        # Optional (if file exists)
        if(file_exists($file_prefix."a.mp4")) {
        echo '<div class="media">
            <video width="640" height="360" controls '.$ap.'>
                <source src="'.$file_prefix."a.mp4".'" type="video/mp4">
                Your browser does not support the video element.
            </video></div>';}
        if(file_exists($file_prefix."a.mp3")) {
        echo '<div class="media">
            <audio controls '.$ap.'>
                <source src="'.$file_prefix."a.mp3".'" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio></div>';}
        if(file_exists($file_prefix."a.png")) {
        echo '<div class="media">
            <img src="'.$file_prefix."a.png".'" alt="Answer Image" style="max-width: 100%; height: auto;">
        </div>';} else if(file_exists($file_prefix."a.jpg")) {
        echo '<div class="media">
            <img src="'.$file_prefix."a.jpg".'" alt="Answer Image" style="max-width: 100%; height: auto;">
        </div>';}
    }
    ?>
<?php include("floating_table.php");?>
</body>
</html>
