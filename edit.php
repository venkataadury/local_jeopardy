<!-- edit.php for editing a question -->
<?php
session_start();
if (!isset($_SESSION['edit_table_mode']) || !$_SESSION['edit_table_mode']) {
    header("Location: index.php");
    exit;
}
$DATA_FOLDER = "data/";
$QUESTION_PREFIX = $DATA_FOLDER . "/" . $_GET["category"] . "-" . $_GET["money"];
$QUESTION_FILE = $QUESTION_PREFIX . "q.txt";
$ANSWER_FILE = $QUESTION_PREFIX . "a.txt";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question <?php echo $_GET["category"] . " - " . $_GET["money"]; ?></title>
    <link rel="stylesheet" href="main-style.css">
    <link rel="stylesheet" href="floating-footer-style.css">
</head>
<body>
    <?php include("data.php"); ?>
    <?php include("floating_table_logic.php"); ?>
    <?php
     // After edit submit
        if(isset($_POST["qvideo"])) {
            // Remove video file
            unlink($QUESTION_PREFIX . "q.mp4");
        }
        if(isset($_POST["qaudio"])) {
            // Remove audio file
            unlink($QUESTION_PREFIX . "q.mp3");
        }
        if(isset($_POST["qimage"])) {
            // Remove image file
            unlink($QUESTION_PREFIX . "q.png");
        }
        if(isset($_POST["avideo"])) {
            // Remove video file
            unlink($QUESTION_PREFIX . "a.mp4");
        }
        if(isset($_POST["aaudio"])) {
            // Remove audio file
            unlink($QUESTION_PREFIX . "a.mp3");
        }
        if(isset($_POST["aimage"])) {
            // Remove image file
            unlink($QUESTION_PREFIX . "a.png");
        }

        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Save question
        if (isset($_POST["question"])) {
            file_put_contents($QUESTION_FILE, $_POST["question"]);
        }
        // Save answer
        if (isset($_POST["answer"])) {
            file_put_contents($ANSWER_FILE, $_POST["answer"]);
        }
        // Handle file uploads
        if (isset($_FILES["qvideo"]) && $_FILES["qvideo"]["error"] == UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES["qvideo"]["tmp_name"], $QUESTION_PREFIX . "q.mp4");
        }
        if (isset($_FILES["qaudio"]) && $_FILES["qaudio"]["error"] == UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES["qaudio"]["tmp_name"], $QUESTION_PREFIX . "q.mp3");
        }
        if (isset($_FILES["qimage"]) && $_FILES["qimage"]["error"] == UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES["qimage"]["tmp_name"], $QUESTION_PREFIX . "q.png");
        }

        if (isset($_FILES["avideo"]) && $_FILES["avideo"]["error"] == UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES["avideo"]["tmp_name"], $QUESTION_PREFIX . "a.mp4");
        }
        if (isset($_FILES["aaudio"]) && $_FILES["aaudio"]["error"] == UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES["aaudio"]["tmp_name"], $QUESTION_PREFIX . "a.mp3");
        }
        if (isset($_FILES["aimage"]) && $_FILES["aimage"]["error"] == UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES["aimage"]["tmp_name"], $QUESTION_PREFIX . "a.png");
        }

        // Update category name
        if (isset($_POST["category_name"])) {
            $newCategoryName = $_POST["category_name"];
            $headers[$_GET["category"]-1] = $newCategoryName;
            // Save the updated headers to the data.php file
            $dataFile = fopen("data/headers.txt", "w");
            fwrite($dataFile, implode("\n", $headers));
            fclose($dataFile);
        }
    }
    ?>
    <?php include("data.php"); ?>
    <form method="post" action="edit.php?category=<?php echo urlencode($_GET["category"]); ?>&money=<?php echo urlencode($_GET["money"]); ?>" enctype="multipart/form-data">
    <h1 style="color: #885511;">Edit Question for $<?php echo $_GET["money"] * 100; ?>
    <!-- Make the category name editable in a table -->
    (Category: <input type="text" name="category_name" value="<?php echo htmlspecialchars($headers[$_GET["category"]-1]); ?>">)
    </h1>

    <!-- Create a form to edit the question. It should have 2 large text blocks - question and answer. Then an option to upload 1.  a video, 2. an audio file, 3. an image -->
    
        <label for="question">Question:</label><br>
        <textarea id="question" name="question" rows="4" cols="50"><?php
            if (file_exists($QUESTION_FILE)) {
                echo htmlspecialchars(file_get_contents($QUESTION_FILE));
            }
        ?></textarea><br>
        <!-- If file already exists, show a message and instead show a 'remove' button. Otherwise allow upload -->
        <?php if (file_exists($QUESTION_PREFIX . "q.mp4")): ?>
            <p>Video file already exists.</p>
            <!-- Insert the video file -->
            <video width="640" height="360" controls>
                <source src="<?php echo $QUESTION_PREFIX . "q.mp4"; ?>" type="video/mp4">
                Your browser does not support the video element.
            </video><br>
            <p>To remove the video, click the button: <button type="submit" name="qvideo">Remove</button></p>
        <?php else: ?>
            <label for="video">Upload <b>MP4</b> Video (optional):</label>
            <input type="file" id="video" name="qvideo"><br>
        <?php endif; ?>

        <!-- If file already exists, show a message and instead show a 'remove' button. Otherwise allow upload -->
        <?php if (file_exists($QUESTION_PREFIX . "q.mp3")): ?>
            <p>Audio file already exists.</p>
            <!-- Insert the audio file -->
            <audio controls>
                <source src="<?php echo $QUESTION_PREFIX . "q.mp3"; ?>" type="audio/mp3">
                Your browser does not support the audio element.
            </audio><br>
            <p>To remove the audio, click the button: <button type="submit" name="qaudio">Remove</button></p>
        <?php else: ?>
            <label for="audio">Upload <b>MP3</b> Audio (optional):</label>
            <input type="file" id="audio" name="qaudio"><br>
        <?php endif; ?>

        <!-- If file already exists, show a message and instead show a 'remove' button. Otherwise allow upload -->
        <?php if (file_exists($QUESTION_PREFIX . "q.png")): ?>
            <p>Image file already exists.</p>
            <!-- Insert the image file -->
            <img src="<?php echo $QUESTION_PREFIX . "q.png"; ?>" alt="Question Image" style="max-width: 640px; max-height: 360px;"><br>
            <p>To remove the image, click the button: <button type="submit" name="qimage">Remove</button></p>
        <?php else: ?>
            <label for="image">Upload <b>PNG</b> Image (optional):</label>
            <input type="file" id="image" name="qimage"><br>
        <?php endif; ?>

        <label for="answer">Answer:</label><br>
        <textarea id="answer" name="answer" rows="4" cols="50"><?php
            if (file_exists($ANSWER_FILE)) {
                echo htmlspecialchars(file_get_contents($ANSWER_FILE));
            }
        ?></textarea><br>
        <!-- If file already exists, show a message and instead show a 'remove' button. Otherwise allow upload -->
        <?php if (file_exists($QUESTION_PREFIX . "a.mp4")): ?>
            <p>Video file already exists.</p>
            <video width="640" height="360" controls>
                <source src="<?php echo $QUESTION_PREFIX . "a.mp4"; ?>" type="video/mp4">
                Your browser does not support the video element.
            </video><br>
            <p>To remove the video, click the button: <button type="submit" name="avideo">Remove</button></p>
        <?php else: ?>
            <label for="video">Upload <b>MP4</b> Video (optional):</label>
            <input type="file" id="video" name="avideo"><br>
        <?php endif; ?>

        <!-- If file already exists, show a message and instead show a 'remove' button. Otherwise allow upload -->
        <?php if (file_exists($QUESTION_PREFIX . "a.mp3")): ?>
            <p>Audio file already exists.</p>
            <audio controls>
                <source src="<?php echo $QUESTION_PREFIX . "a.mp3"; ?>" type="audio/mp3">
                Your browser does not support the audio element.
            </audio><br>
            <p>To remove the audio, click the button: <button type="submit" name="aaudio">Remove</button></p>
        <?php else: ?>
            <label for="audio">Upload <b>MP3</b> Audio (optional):</label>
            <input type="file" id="audio" name="aaudio"><br>
        <?php endif; ?>

        <!-- If file already exists, show a message and instead show a 'remove' button. Otherwise allow upload -->
        <?php if (file_exists($QUESTION_PREFIX . "a.png")): ?>
            <p>Image file already exists.</p>
            <img src="<?php echo $QUESTION_PREFIX . "a.png"; ?>" alt="Answer Image" style="max-width: 640px; max-height: 360px;"><br>
            <p>To remove the image, click the button: <button type="submit" name="aimage">Remove</button></p>
        <?php else: ?>
            <label for="image">Upload <b>PNG</b> Image (optional):</label>
            <input type="file" id="image" name="aimage"><br>
        <?php endif; ?>

        <button type="submit">Save Changes</button>
        <button type="reset">Reset</button>
        <button type="button" onclick="window.location.href='index.php'">Cancel</button>
    </form>
    <p style="color: #0000AA;">
        <b>Instructions</b><br/>
    You can edit the question directly in the text area and save it.<br/>
    If you want to delete the question, simply remove the text in the question and answer fields and save.<br/>
    If you want to delete the video, audio, or image, simply remove the file from the input field and save.<br/>
    If you want to reset the question, click the reset button.<br/>
    If you want to cancel the edit and go back, click the cancel button.<br/>
    <?php include("floating_table.php"); ?>
</body>
</html>