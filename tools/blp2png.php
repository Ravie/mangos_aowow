<?php
  if ($_SERVER["argc"] != 2)
  {
    print "Convert BLP image to PNG\n";
    print "USAGE:\n";
    print "  blp2png.php <image.blp>\n";
    print "EXAMPLE:\n";
    print "  php.exe blp2png.php ZulFarrak.blp\n";
    exit;
  }

  require("../setup/imagecreatefromblp.php");
  $filename = $_SERVER["argv"][1];
  $outfile = basename(strtolower($filename), ".blp") . ".png";
  $image = imagecreatefromblp($filename);
  imagepng($image, $outfile);
?>
