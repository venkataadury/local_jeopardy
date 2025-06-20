<?php 
  if(isset($_GET["hide_table"])) {
    // Add a show button to the main page
    echo '<form method="get">';
    foreach ($_GET as $key => $value) {
      if ($key !== 'hide_table' && $key !== 'show_table') {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
      }
    }
    echo '<button type="submit" name="show_table">Show Score Table</button>';
    echo '</form>';
    // Hide the floating table by not displaying it
    return;
  }
?>
<div id="floating-footer">
  <form method="get" id="reset-button">
    <?php foreach ($_GET as $key => $value): ?>
      <?php if ($key !== 'reset_table'): ?>
        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
      <?php endif; ?>
    <?php endforeach; ?>
    <button type="submit" name="reset_table">Reset Game</button>
  </form>
  <table>
    <tr>
      <?php foreach ($_SESSION['floating_table'][0] as $colIndex => $_): ?>
        <th>
          <div class="header-buttons">
            <form method="get">
              <input type="hidden" name="action" value="inc">
              <input type="hidden" name="row" value="0">
              <input type="hidden" name="col" value="<?= $colIndex ?>">
              <?php foreach ($_GET as $key => $value): ?>
                <?php if (!in_array($key, ['action', 'row', 'col'])): ?>
                  <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
              <?php endforeach; ?>
              <button type="submit">+</button>
            </form>
            <!-- When edit_table_mode is active, add a form to edit the column name -->
            <?php if (isset($_SESSION["edit_table_mode"]) && $_SESSION["edit_table_mode"]): ?>
              <form method="post">
                <input type="hidden" name="colIndex" value="<?= $colIndex ?>">
                <input type="text" name="newHeader" style="width: 60px;" value="<?= htmlspecialchars($_SESSION['floating_table_headers'][$colIndex] ?? ('Column ' . ($colIndex + 1))) ?>">
                <!--<button type="submit">Edit</button>-->
              </form>
            <?php else: ?>
              <!-- Display the column name -->
              <?= htmlspecialchars($_SESSION['floating_table_headers'][$colIndex] ?? ('Column ' . ($colIndex + 1))) ?>
             <?php endif; ?>
            <form method="get">
              <input type="hidden" name="action" value="dec">
              <input type="hidden" name="row" value="0">
              <input type="hidden" name="col" value="<?= $colIndex ?>">
              <?php foreach ($_GET as $key => $value): ?>
                <?php if (!in_array($key, ['action', 'row', 'col'])): ?>
                  <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
              <?php endforeach; ?>
              <button type="submit">-</button>
            </form>
          </div>
        </th>
      <?php endforeach; ?>
      
    </tr>
    <?php foreach ($_SESSION['floating_table'] as $rowIndex => $row): ?>
    <tr>
      <?php foreach ($row as $cell): ?>
        <td><?= htmlspecialchars($cell) ?></td>
      <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
  </table><br/>
  <form method="get" id="hide-button">
    <?php foreach ($_GET as $key => $value): ?>
      <?php if ($key !== 'hide_table'): ?>
        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
      <?php endif; ?>
    <?php endforeach; ?>
    <button type="submit" name="hide_table">Hide Scores</button>
  </form>

  
  <?php
  // Add edit table button only if on page 'index.php'
  if (basename($_SERVER['PHP_SELF']) == 'index.php') {
  echo '<form method="get" id="edit-button">';
    foreach ($_GET as $key => $value):
      if ($key !== 'edit_table' && $key !== 'freeze_table'):
        echo '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($value).'">';
      endif;
    endforeach;
    if(isset($_SESSION["edit_table_mode"]) && $_SESSION["edit_table_mode"]) {
      echo '<button type="submit" name="freeze_table">Commit Table (End Editing Mode)</button>';
    } else {
      echo '<button type="submit" name="edit_table">Edit Table</button>';
    }
  echo '</form>';}
  ?>
  <form method="get" id="home-button">
    <?php foreach ($_GET as $key => $value): ?>
      <?php if ($key !== 'reset_table'): ?>
        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
      <?php endif; ?>
    <?php endforeach; ?>
    <?php
    if (isset($_SESSION["edit_table_mode"]) && $_SESSION["edit_table_mode"]) {echo '<input type="hidden" name="edit_table" value="1">';}
    ?>
    <button type="submit" name="home_page">Home</button>
  </form>
</div>

