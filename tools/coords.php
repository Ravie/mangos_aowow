<?php
  require_once("includes/kernel.php");
  require_once("includes/game.php");

  print "Transform global coordinates into zone coordinates\n";
  if ($argc != 4)
  {
    print "USAGE:\n  coords.php <x> <y> <m>\nEXAMPLE:\n  coords.php 7061.78 -423.64 571\n";
    exit;
  }

  $points = array(
    array(
      'x' => floatval($argv[1]),
      'y' => floatval($argv[2]),
      'm' => floatval($argv[3])
    )
  );

  print_r(transform_coords2($points));
?>
