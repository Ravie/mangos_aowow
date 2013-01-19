<?php
/*
    dbc2text - Console PHP tool for converting DBC file without known
    format string into human-readable text.
    This file is a part of AoWoW project.
    Copyright (C) 2009-2010  Mix <ru-mangos.ru>

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

  // Note:
  //   Strings are recognized automatically, but float numbers are
  //   incorrectly decoded as integers. Feel free to fix that.

  if ($_SERVER["argc"] != 2)
  {
    print "Convert DBC file into human-readable text.\n";
    print "USAGE:\n";
    print "  dbc2text.php <file.dbc>\n";
    print "EXAMPLE:\n";
    print "  php.exe dbc2text.php ItemSubClass.dbc\n";
    exit;
  }

  // Usage example:
  //   php.exe dbc2text.php ItemSubClass.dbc > ItemSubClass.txt

  $filename = $_SERVER["argv"][1];
  {
    $f = fopen($filename, "rb") or die("Cannot open file " . $filename . "\n");

    $filesize = filesize($filename);
    if ($filesize < 20)
      die("File " . $filename . " is too small for a DBC file\n");

    if (fread($f, 4) != "WDBC")
      die("File " . $filename . " has incorrect magic bytes\n");

    $header = unpack("VrecordCount/VfieldCount/VrecordSize/VstringSize", fread($f, 16));

    // Different debug checks to be sure, that file was opened correctly
    $debugstr = "\n(recordCount=" . $header["recordCount"] . " " .
                "fieldCount=" . $header["fieldCount"] . " " .
                "recordSize=" . $header["recordSize"] . " " .
                "stringSize=" . $header["stringSize"] . ")\n";

    if ($header["recordCount"] * $header["recordSize"] + $header["stringSize"] + 20 != $filesize)
      die("File " . $filename . " has incorrect size" . $debugstr);

    if ($header["fieldCount"] * 4 != $header["recordSize"])
      die("Non-even number of fields in file " . $filename . $debugstr);

    $unpackstr = "";
    for ($i=0; $i<$header["fieldCount"]; $i++)
      $unpackstr = $unpackstr . "/Vf".$i;
    $unpackstr = substr($unpackstr, 1);
    //echo "Unpack string for " . $filename . ": " . $unpackstr . "\n";

    // Cache the data to make it faster
    $data = fread($f, $header["recordCount"] * $header["recordSize"]);
    $strings = fread($f, $header["stringSize"]);
    fclose($f);

    // Decode strings
    if ($strings)
    {
      $str = explode("\000", $strings);
      $offset = 0;
      $strings = array();
      foreach ($str as $s)
      {
        $strings[$offset] = $s;
        $offset += strlen($s)+1;
      }
      unset($str);
    }

    // Now check, which fields are strings
    $isstring = array();
    $isnotstring = array();
    for ($i=0; $i<$header["recordCount"]; $i++)
    {
      $record = unpack($unpackstr, substr($data, $i*$header["recordSize"], $header["recordSize"]));
      foreach ($record as $f => $value)
      {
        if ($value && isset($strings[$value])) $isstring[$f] = 1;
        if ($value && !isset($strings[$value])) $isnotstring[$f] = 1;
      }
    }

    // And, finally, extract the records
    for ($i=0; $i<$header["recordCount"]; $i++)
    {
      $record = unpack($unpackstr, substr($data, $i*$header["recordSize"], $header["recordSize"]));
      foreach ($record as $f => $value)
        if (isset($isstring[$f]) && !isset($isnotstring[$f]))
          echo "[", $strings[$value], "]";
        else
          echo "[", $value, "]";
      echo "\n";
    }
  }
?>