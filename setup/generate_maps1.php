<pre>
<?php
/*
    generate_maps1.php - code for extracting regular maps for AoWoW
    This file is a part of AoWoW project.
    Copyright (C) 2010  Mix <ru-mangos.ru>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
  require("config.php");

  if (!isset($config["mpq"]))
    die("Path to extracted MPQ files is not configured");
  if (!isset($config["maps"]))
    die("Path where to extract maps is not configured");

  $mpqdir = $config["mpq"];
  $outmapdir = $config["maps"];
  if (isset($config["tmp"]))
  {
    $outtmpdir = $config["tmp"];
    @mkdir($outtmpdir);
  }

  $dbcdir = $mpqdir . "DBFilesClient/";
  if (@stat($dbcdir) == NULL)
    $dbcdir = $mpqdir . "dbfilesclient/";

  $worldmapdir = $mpqdir . "interface/worldmap/";
  $normaldir = $outmapdir . "enus/normal/";
  $zoomdir   = $outmapdir . "enus/zoom/";

  $blpmapwidth = 1002;
  $blpmapheight = 668;

  @mkdir($normaldir, 0777, true);
  @mkdir($zoomdir, 0777, true);

  require("dbc2array.php");
  require("imagecreatefromblp.php");

  function dbc2array_($filename, $format)
  {
    global $dbcdir;
    if (@stat($dbcdir . $filename) == NULL) $filename = strtolower($filename);
    return dbc2array($dbcdir . $filename, $format);
  }

  function status($message)
  {
    echo $message;
    @ob_flush();
    flush();
    @ob_end_flush();
  }

  function saveimage($mapimage, $filename, $overwrite)
  {
    global $normaldir, $zoomdir, $blpmapwidth, $blpmapheight;
    if ($overwrite || !file_exists($normaldir . $filename))
    {
      $imgnormal = imagecreatetruecolor(488,325);
      imagecopyresampled($imgnormal, $mapimage, 0,0, 0,0, 488,325, $blpmapwidth,$blpmapheight);
      imagejpeg($imgnormal, $normaldir . $filename);
      imagedestroy($imgnormal);
    }
    if ($overwrite || !file_exists($zoomdir . $filename))
    {
      $imgzoom = imagecreatetruecolor(772,515);
      imagecopyresampled($imgzoom, $mapimage, 0,0, 0,0, 772,515, $blpmapwidth,$blpmapheight);
      imagejpeg($imgzoom, $zoomdir . $filename);
      imagedestroy($imgzoom);
    }
  }

  status("Reading subzones list...");
  $dbc = dbc2array_("WorldMapOverlay.dbc", "niixxxxxsiiiixxxx");
  $wmo = array();
  foreach ($dbc as $row)
    if ($row[3])
      $wmo[$row[1]][] = array
      (
        "areaid" => $row[2],
        "name"   => strtolower($row[3]),
        "width"  => $row[4],
        "height" => $row[5],
        "left"   => $row[6],
        "top"    => $row[7]
      );
  status(count($dbc) . "\n");

  status("Reading zones list...");
  $dbc = dbc2array_("WorldMapArea.dbc", "nxisxxxxxxx");
  status(count($dbc) . "\n");

  $count = 0;
  foreach ($dbc as $row)
  {
    $count++;
    if ($row[1])
    {
      $zid = $row[0];
      $mapid = $row[1];
      $mapname = $row[2];
      status($mapname . "[" . $mapid . "]");
      $mapname = strtolower($mapname);

      $map = imagecreatetruecolor(1024, 768);

      $mapfg = imagecreatetruecolor(1024, 768);
      imagesavealpha($mapfg, true);
      imagealphablending($mapfg, false);
      $bgcolor = imagecolorallocatealpha($mapfg, 0, 0, 0, 127);
      imagefilledrectangle($mapfg, 0, 0, 1023, 767, $bgcolor);
      imagecolordeallocate($mapfg, $bgcolor);
      imagealphablending($mapfg, true);
      echo ".";

      $prefix = $worldmapdir . $mapname . "/" . $mapname;
      if (@stat($prefix . "1.blp") == NULL)
        $prefix = $prefix . "1_";
      if (@stat($prefix . "1.blp") == NULL)
      {
        status(" not found.\n");
        continue;
      }
      for ($i = 0; $i < 12; $i++)
      {
        $img = imagecreatefromblp($prefix . ($i+1) . ".blp");
        imagecopyresampled($map, $img, 256*($i%4), 256*intval($i/4), 0, 0, 256, 256, imagesx($img), imagesy($img));
        imagedestroy($img);
      }
      echo ".";

      if (isset($wmo[$zid]))
      {
        foreach ($wmo[$zid] as &$row)
        {
          $i = 1; $y = 0;
          while($y < $row["height"])
          {
            $x = 0;
            while($x < $row["width"])
            {
              $img = imagecreatefromblp($worldmapdir . $mapname . "/" . $row["name"] . $i . ".blp");
              imagecopy($mapfg, $img, $row["left"]+$x, $row["top"]+$y, 0, 0, imagesx($img), imagesy($img));

              if (!isset($row["maskimage"]))
              {
                $mapmask = imagecreatetruecolor($row["width"], $row["height"]);
                imagesavealpha($mapmask, true);
                imagealphablending($mapmask, false);
                $bgmaskcolor = imagecolorallocatealpha($mapmask, 0, 0, 0, 127);
                imagefilledrectangle($mapmask, 0, 0, imagesx($mapmask)-1, imagesy($mapmask)-1, $bgmaskcolor);
                imagecolordeallocate($mapmask, $bgmaskcolor);
                $row["maskimage"] = $mapmask;
                $row["maskcolor"] = imagecolorallocatealpha($mapmask, 255, 64, 192, 64);
              }
              for ($my = 0; $my < imagesy($img); $my++)
                for ($mx = 0; $mx < imagesx($img); $mx++)
                  if ((imagecolorat($img, $mx, $my)>>24) < 30)
                    imagesetpixel($row["maskimage"], $x+$mx, $y+$my, $row["maskcolor"]);

              imagedestroy($img);
              $x += 256;
              $i++;
            }
            $y += 256;
          }
        }
        echo ".";

        if (isset($outtmpdir))
        {
          $tmp = imagecreate(1000,1000);
          $cbg = imagecolorallocate($tmp, 255,255,255);
          $cfg = imagecolorallocate($tmp, 0,0,0);
          for ($y = 0; $y < 1000; $y++)
            for ($x = 0; $x < 1000; $x++)
            {
              $a = imagecolorat($mapfg, ($x*$blpmapwidth)/1000, ($y*$blpmapheight)/1000)>>24;
              imagesetpixel($tmp, $x, $y, $a < 30 ? $cfg : $cbg);
            }
          imagepng($tmp, $outtmpdir . $mapid . ".png");
          imagecolordeallocate($tmp, $cbg);
          imagecolordeallocate($tmp, $cfg);
          imagedestroy($tmp);
          echo ".";
        }
      }

      //imagepng($mapfg, $mapid . "_fg.png");
      //imagejpeg($map, $mapid . ".jpg");
      //imagepng($map, $mapid . ".png");
      imagecolortransparent($mapfg, imagecolorat($mapfg, imagesx($mapfg)-1, imagesy($mapfg)-1));
      imagecopymerge($map, $mapfg, 0, 0, 0, 0, imagesx($mapfg), imagesy($mapfg), 100);
      imagedestroy($mapfg);

      saveimage($map, $mapid . ".jpg", true);

      if (isset($wmo[$zid]))
      {
        foreach ($wmo[$zid] as &$row)
        {
          $zonemap = imagecreatetruecolor(1024, 768);
          imagecopy($zonemap, $map, 0, 0, 0, 0, imagesx($map), imagesy($map));
          imagecopy($zonemap, $row["maskimage"], $row["left"], $row["top"], 0, 0, imagesx($row["maskimage"]), imagesy($row["maskimage"]));
          saveimage($zonemap, $row["areaid"] . ".jpg", false);
          imagedestroy($zonemap);
        }
      }

      imagedestroy($map);

      status("done (" . intval($count*100/count($dbc)) . "%)\n");
    }
  }

?>
</pre>
