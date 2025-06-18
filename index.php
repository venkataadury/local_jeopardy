<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Local Jeopardy</title>
<link rel="stylesheet" href="main-style.css">
<link rel="stylesheet" href="floating-footer-style.css">
</head>
<body style="display: flex; justify-content: flex-start; align-items: center; height: 100vh; margin: 0; padding-left: 10vw; padding-right: 20vw;">
<?php include("floating_table_logic.php");?>
<?php
  session_start();

  // Initialize visited session array
  if (!isset($_SESSION['visited'])) {
      $_SESSION['visited'] = [];
  }

  // Record visited link if requested
  if (isset($_GET['visit'])) {
      $v = $_GET['visit'];
      if(!isset($_SESSION["edit_table_mode"]) || !$_SESSION["edit_table_mode"]) {
          // If not in edit mode, record the visit
          if (!in_array($v, $_SESSION['visited'])) {
              $_SESSION['visited'][] = $v;
          }
      }
      list($part1,$part2)=explode("-",$v);
      $part2=(int)($part2/10);
      
      if(isset($_SESSION["edit_table_mode"]) && $_SESSION["edit_table_mode"]) {
          // If in edit mode, redirect to edit page
          header("Location: edit.php?category=".$part1."&money=".$part2);
      } else {
          // Otherwise, redirect to question page
          header("Location: question.php?category=".$part1."&money=".$part2);
      }
      exit;
  }

  
  // Hardcoded column titles
  include("data.php");

  // Percent of space occupied by each column and row
  $total_occupied=80; // 80% of screen space
  $colPercent = $total_occupied/count($headers); 
  $rowPercent = $total_occupied/(count($matrix)+1);

  echo "<table border='1' style='width: 100%; height: 100vh; border-collapse: collapse; text-align: center; table-layout: fixed;'>";

  // Header row
  echo "<thead><tr>";
  foreach ($headers as $header) {
      echo "<th style='width: $colPercent%; height: $rowPercent%; font-size: 1.5em; text-align: center; vertical-align: middle; background-color: #003366; color: white;'>$header</th>";
  }
  echo "</tr></thead>";

  echo "<tbody>";
  foreach ($matrix as $rowIndex => $row) {
      echo "<tr>";
      foreach ($row as $colIndex => $cell) {
          #$header = $headers[$colIndex];
          #$link = "Category$colIndex.php?money=$cell";
          $category = $colIndex + 1;
          $key = "$category-$cell";
          $visited = in_array($key, $_SESSION['visited']);

          $bgColor = $visited ? "#ffffff" : "#cce6ff";
          $color = $visited ? "#888888" : "inherit";

          $displayValue = ($rowIndex + 1) * 100 + $colIndex * 0;

          echo "<td style='width: $colPercent%; height: $rowPercent%; font-size: 1.5em; text-align: center; vertical-align: middle; background-color: $bgColor;'>";
          echo "<a href='?visit=$key' style='text-decoration: none; color: $color;'>$displayValue</a>";
          echo "</td>";
      }
      echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
  echo '<br/>';
?>
<?php include("floating_table.php");?>
</body>
</html>
