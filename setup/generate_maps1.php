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
  
  $start = microtime(true);

  if (!isset($config["mpq"]))
    die("Path to extracted MPQ files is not configured");
  if (!isset($config["english_dbc"]))
    die("Path to extracted client DBC is not configured");
  if (!isset($config["maps"]))
    die("Path where to extract maps is not configured");

  $mpqdir = $config["mpq"];
  $dbcdir = $config["english_dbc"];
  $outmapdir = $config["maps"];
  if (isset($config["tmp"]))
  {
    $outtmpdir = $config["tmp"];
    @mkdir($outtmpdir);
  }

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
  $dbc_at = dbc2array_("AreaTable.dbc", "ixixxxxxxxxsxxxxxxxxxxxxxxxxxxxxxxxx");
  $dbc_wmo = dbc2array_("WorldMapOverlay.dbc", "niiiiixxsiiiixxxx");
  $wmo = array();
  foreach ($dbc_wmo as $row_wmo)
  {
    if ($row_wmo[6])
    {
      $wmo[$row_wmo[1]][] = array
      (
        "areaid0" => $row_wmo[2],
        "areaid1" => $row_wmo[3],
        "areaid2" => $row_wmo[4],
        "areaid3" => $row_wmo[5],
        "name"   => strtolower($row_wmo[6]),
        "width"  => $row_wmo[7],
        "height" => $row_wmo[8],
        "left"   => $row_wmo[9],
        "top"    => $row_wmo[10]
      );
    }
  }
  status(count($dbc_wmo) . "\n");

  status("Reading zones list...");
  $dbc_wma = dbc2array_("WorldMapArea.dbc", "niisxxxxxxx");
  status(count($dbc_wma) . "\n");

  $dbc_dm = dbc2array_("DungeonMap.dbc", "niixxxxx");
  $dbc_dmc = dbc2array_("DungeonMapChunk.dbc", "xxiix");
  $dbc_wmoat = dbc2array_("WMOAreaTable.dbc", "xxxixxxxxxixxxxxxxxxxxxxxxxx");

  $count = 0;
  foreach ($dbc_wma as $row_wma)
  {
    $count++;
    if ($row_wma[2])
    {
      $zid = $row_wma[0];
      $mapid = $row_wma[1];
      $areaid = $row_wma[2];
      $areaname = $row_wma[3];
      status($areaname . "[" . $areaid . "]");
      $areaname = strtolower($areaname);

      $map = imagecreatetruecolor(1024, 768);

      $mapfg = imagecreatetruecolor(1024, 768);
      imagesavealpha($mapfg, true);
      imagealphablending($mapfg, false);
      $bgcolor = imagecolorallocatealpha($mapfg, 0, 0, 0, 127);
      imagefilledrectangle($mapfg, 0, 0, 1023, 767, $bgcolor);
      imagecolordeallocate($mapfg, $bgcolor);
      imagealphablending($mapfg, true);
      echo ".";

      $prefix = $worldmapdir . $areaname . "/" . $areaname;
      if (@stat($prefix . "1.blp") != NULL)
      {
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
                $img = imagecreatefromblp($worldmapdir . $areaname . "/" . $row["name"] . $i . ".blp");
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
            imagepng($tmp, $outtmpdir . $areaid . ".png");
            imagecolordeallocate($tmp, $cbg);
            imagecolordeallocate($tmp, $cfg);
            imagedestroy($tmp);
            echo ".";
          }
        }
        
        //imagepng($mapfg, $areaid . "_fg.png");
        //imagejpeg($map, $areaid . ".jpg");
        //imagepng($map, $areaid . ".png");
        imagecolortransparent($mapfg, imagecolorat($mapfg, imagesx($mapfg)-1, imagesy($mapfg)-1));
        imagecopymerge($map, $mapfg, 0, 0, 0, 0, imagesx($mapfg), imagesy($mapfg), 100);
        imagedestroy($mapfg);
        
        saveimage($map, $areaid . ".jpg", true);
        
        if (isset($wmo[$zid]))
        {
          foreach ($wmo[$zid] as &$row)
          {
            $zonemap = imagecreatetruecolor(1024, 768);
            imagecopy($zonemap, $map, 0, 0, 0, 0, imagesx($map), imagesy($map));
            imagecopy($zonemap, $row["maskimage"], $row["left"], $row["top"], 0, 0, imagesx($row["maskimage"]), imagesy($row["maskimage"]));
            saveimage($zonemap, $row["areaid0"] . ".jpg", true);
            if($row["areaid1"])
              saveimage($zonemap, $row["areaid1"] . ".jpg", false);
            if($row["areaid2"])
              saveimage($zonemap, $row["areaid2"] . ".jpg", false);
            if($row["areaid3"])
              saveimage($zonemap, $row["areaid3"] . ".jpg", false);
            imagedestroy($zonemap);
          }
          echo ".";
        }
        
        foreach ($dbc_at as $row_at)
          if ($row_wma[2] == $row_at[1])
            saveimage($map, $row_at[0] . ".jpg", false);
      }
      if (@stat($prefix . "1_1.blp") != NULL)
      {
        echo "\n  Floor for dungeon: ";
        for ($floor = 1; $floor < 12; $floor++)
        {
          if (@stat($prefix . $floor . "_1.blp") == NULL)
            break;
          echo $floor;
          
          for ($chunk = 0; $chunk < 12; $chunk++)
          {
            $img = imagecreatefromblp($prefix . $floor . "_" . ($chunk+1) . ".blp");
            imagecopyresampled($map, $img, 256*($chunk%4), 256*intval($chunk/4), 0, 0, 256, 256, imagesx($img), imagesy($img));
            imagedestroy($img);
          }
        
          saveimage($map, $areaid . "_" . $floor . ".jpg", true);
          echo ".";
          
          foreach ($dbc_dm as $row_dm)
            if ($mapid == $row_dm[1] && $floor == $row_dm[2])
              foreach ($dbc_dmc as $row_dmc)
                if ($row_dm[0] == $row_dmc[1])
                  foreach ($dbc_wmoat as $row_wmoat)
                    if ($row_dmc[0] == $row_wmoat[0] && $row_wmoat[1] && $row_wmoat[1] != $areaid)
                      saveimage($map, $row_wmoat[1] . ".jpg", true);
          echo ".";
          
          foreach ($dbc_at as $row_at)
            if ($row_wma[2] == $row_at[1])
              saveimage($map, $row_at[0] . ".jpg", false);
          echo ". ";
        }
      }   
      imagedestroy($map);

      status("done (" . intval($count*100/count($dbc_wma)) . "%)\n");
    }
  }
  
  echo 'Extracting time: '.(microtime(true) - $start).' sec';

?>
</pre>
