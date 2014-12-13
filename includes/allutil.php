<?php
define('AOWOW_REVISION', 12);

/* ================ LOADING ================ */
require_once('configs/config.php');
error_reporting(2039);
ini_set('serialize_precision', 4);
session_start();

// Префикс
$tableprefix = $AoWoWconf['mangos']['aowow'];

$locales = array(
    0 => 'enus',
    2 => 'frfr',
    3 => 'dede',
    8 => 'ruru',
);
$lang = array(
    0 => 'www',
    2 => 'fr',
    3 => 'de',
    8 => 'ru',
);
function checklocale()
{
    global $AoWoWconf, $locales;
    if(!isset($_SESSION['locale']) || !isset($locales[$_SESSION['locale']]))
        $_SESSION['locale'] = $AoWoWconf['locale'];
}
checklocale();
// Это должно быть ПОСЛЕ checklocale()
require_once('includes/alllocales.php');


/* ================ MISC FUNCTIONS ================ */
function str_normalize($str)
{
    return str_replace("'", "\'", $str);
}

function d($d,$v)
{
    define($d,$v);
}
function mass_define($arr)
{
    foreach($arr as $name => $value)
        define($name, $value);
}
function sign($val)
{
    if($val > 0) return 1;
    if($val < 0) return -1;
    if($val == 0) return 0;
}
// Классы персонажей (used in TalentCalc)
$classes = array(
    1 => LOCALE_WARRIOR,
    2 => LOCALE_PALADIN,
    3 => LOCALE_HUNTER,
    4 => LOCALE_ROGUE,
    5 => LOCALE_PRIEST,
    6 => LOCALE_DEATH_KNIGHT,
    7 => LOCALE_SHAMAN,
    8 => LOCALE_MAGE,
    9 => LOCALE_WARLOCK,
    11=> LOCALE_DRUID
);
// Классы персонажей (битовые маски)
define('CLASS_WARRIOR',       1);
define('CLASS_PALADIN',       2);
define('CLASS_HUNTER',        4);
define('CLASS_ROGUE',         8);
define('CLASS_PRIEST',       16);
define('CLASS_DEATH_KNIGHT', 32);
define('CLASS_SHAMAN',       64);
define('CLASS_MAGE',        128);
define('CLASS_WARLOCK',     256);
define('CLASS_DRUID',      1024);
// Расы персонажей (битовые маски)
define('RACE_HUMAN',          1);
define('RACE_ORC',            2);
define('RACE_DWARF',          4);
define('RACE_NIGHTELF',       8);
define('RACE_UNDEAD',        16);
define('RACE_TAUREN',        32);
define('RACE_GNOME',         64);
define('RACE_TROLL',        128);
define('RACE_BLOODELF',     512);
define('RACE_DRAENEI',     1024);

// Типы разделов
$types = array(
    1 => array('npc',       'creature_template',        'entry'      ),
    2 => array('object',    'gameobject_template',      'entry'      ),
    3 => array('item',      'item_template',            'entry'      ),
    4 => array('itemset',   $tableprefix.'itemset',     'itemsetID'  ),
    5 => array('quest',     'quest_template',           'entry'      ),
    6 => array('spell',     $tableprefix.'spell',       'spellID'    ),
    7 => array('zone',      $tableprefix.'zones',       'areatableID'),
    8 => array('faction',   $tableprefix.'factions',    'factionID'  ),
);

// Отношения со фракциями
function reputations($value)
{
    if ($value < 0)
        return $value;
    elseif ($value <= 1)
        return LOCALE_NEUTRAL;
    elseif ($value < 2999)
        return LOCALE_NEUTRAL . "+" . $value;
    elseif ($value <= 3000)
        return LOCALE_FRIENDLY;
    elseif ($value < 8999)
        return LOCALE_FRIENDLY . "+" . ($value-3000);
    elseif ($value <= 9000)
        return LOCALE_HONORED;
    elseif ($value < 20999)
        return LOCALE_HONORED . "+" . ($value-9000);
    elseif ($value <= 21000)
        return LOCALE_REVERED;
    elseif ($value < 41999)
        return LOCALE_REVERED . "+" . ($value-21000);
    elseif ($value <= 42000)
        return LOCALE_EXALTED;
    else
        return LOCALE_EXALTED . "+" . ($value-42000);
}

$sides = array(
    1 => LOCALE_ALLIANCE,
    2 => LOCALE_HORDE,
    3 => LOCALE_BOTH_FACTIONS
);

function sec_to_time($secs)
{
    $time = array();
    if($secs>0)
    {
        if($secs>=3600*24)
        {
            $time['d'] = floor($secs/3600/24);
            $secs = $secs - $time['d']*3600*24;
            $time['d'] .= ' '.LOCALE_DAYS;
        }
        if($secs>=3600)
        {
            $time['h'] = floor($secs/3600);
            $secs = $secs - $time['h']*3600;
            $time['h'] .= ' '.LOCALE_HOURS;
        }
        if($secs>=60)
        {
            $time['m'] = floor($secs/60);
            $secs = $secs - $time['m']*60;
            $time['m'] .= ' '.LOCALE_MINUTES;
        }
        if($secs>0)
            $time['s'] = $secs.' '.LOCALE_SECONDS;
        $string = implode(", ", $time);
    }
    else
        $string = LOCALE_UNLIMITED;
    return $string;
}
function money2coins($money)
{
    $coins = array();

    if($money >= 10000)
    {
        $coins['moneygold'] = floor($money / 10000);
        $money = $money - $coins['moneygold']*10000;
    }

    if($money >= 100)
    {
        $coins['moneysilver'] = floor($money / 100);
        $money = $money - $coins['moneysilver']*100;
    }

    if($money > 0)
        $coins['moneycopper'] = $money;

    return $coins;
}
// Классы, для которых предназначена вещь
function classes($class)
{
    if($class == -1)
        return NULL;
    $tmp = '';
    $classes_count = 0;
    if($class & CLASS_WARRIOR)
    {
        $tmp = '<a class="c1"><span class="warrior-icon">'.LOCALE_WARRIOR.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_PALADIN)
    {
        if($tmp)
            $tmp .= ', ';
        $tmp .= '<a class="c2"><span class="paladin-icon">'.LOCALE_PALADIN.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_HUNTER)
    {
        if($tmp)
            $tmp .= ', ';
        $tmp .= '<a class="c3"><span class="hunter-icon">'.LOCALE_HUNTER.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_ROGUE)
    {
        if($tmp)
            $tmp .= ', '; 
        $tmp .= '<a class="c4"><span class="rogue-icon">'.LOCALE_ROGUE.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_PRIEST)
    {
        if($tmp)
            $tmp .= ', ';
        $tmp .= '<a class="c5"><span class="priest-icon">'.LOCALE_PRIEST.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_DEATH_KNIGHT)
    {
        if($tmp)
            $tmp .= ', '; 
        $tmp .= '<a class="c6"><span class="deathknight-icon">'.LOCALE_DEATH_KNIGHT.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_SHAMAN)
    {
        if($tmp)
            $tmp .= ', ';
        $tmp .= '<a class="c7"><span class="shaman-icon">'.LOCALE_SHAMAN.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_MAGE)
    {
        if($tmp)
            $tmp .= ', ';
        $tmp .= '<a class="c8"><span class="mage-icon">'.LOCALE_MAGE.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_WARLOCK)
    {
        if($tmp)
            $tmp .= ', ';
        $tmp .= '<a class="c9"><span class="warlock-icon">'.LOCALE_WARLOCK.'</span></a>';
        $classes_count += 1;
    }
    if($class & CLASS_DRUID)
    {
        if($tmp)
            $tmp .= ', ';
        $tmp .= '<a class="c11"><span class="druid-icon">'.LOCALE_DRUID.'</span></a>';
        $classes_count += 1;
    }
    if(!$classes_count || $classes_count == 10)
        $tmp = NULL;
    return $tmp;
}
function races($race)
{
    if($race == -1 || !$race)
        return NULL;
    $temp = '';
    $alliance_count = 0;
    $horde_count = 0;
    if($race & RACE_HUMAN)
    {
        $temp = '<span class="human-icon">'.LOCALE_HUMAN.'</span>';
        $alliance_count += 1;
    }
    if($race & RACE_ORC)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="orc-icon">'.LOCALE_ORC.'</span>';
        $horde_count += 1;
    }
    if($race & RACE_DWARF)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="dwarf-icon">'.LOCALE_DWARF.'</span>';
        $alliance_count += 1;
    }
    if($race & RACE_NIGHTELF)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="nightelf-icon">'.LOCALE_NIGHTELF.'</span>';
        $alliance_count += 1;
    }
    if($race & RACE_UNDEAD)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="undead-icon">'.LOCALE_UNDEAD.'</span>';
        $horde_count += 1;
    }
    if($race & RACE_TAUREN)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="tauren-icon">'.LOCALE_TAUREN.'</span>';
        $horde_count += 1;
    }
    if($race & RACE_GNOME)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="gnome-icon">'.LOCALE_GNOME.'</span>';
        $alliance_count += 1;
    }
    if($race & RACE_TROLL)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="troll-icon">'.LOCALE_TROLL.'</span>';
        $horde_count += 1;
    }
    if($race & RACE_BLOODELF)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="bloodelf-icon">'.LOCALE_BLOODELF.'</span>';
        $horde_count += 1;
    }
    if($race & RACE_DRAENEI)
    {
        if($temp)
            $temp .= ', ';
        $temp .= '<span class="draenei-icon">'.LOCALE_DRAENEI.'</span>';
        $alliance_count += 1;
    }
    if($alliance_count == 5 || $horde_count == 5)
        $temp = NULL;
    return $temp;
}
function factions($race)
{
    if($race == -1 || !$race)
        return array('side' => 3, 'name' => LOCALE_BOTH_FACTIONS);
    $alliance_count = 0;
    $horde_count = 0;
    if($race & RACE_HUMAN)
        $alliance_count += 1;
    if($race & RACE_ORC)
        $horde_count += 1;
    if($race & RACE_DWARF)
        $alliance_count += 1;
    if($race & RACE_NIGHTELF)
        $alliance_count += 1;
    if($race & RACE_UNDEAD)
        $horde_count += 1;
    if($race & RACE_TAUREN)
        $horde_count += 1;
    if($race & RACE_GNOME)
        $alliance_count += 1;
    if($race & RACE_TROLL)
        $horde_count += 1;
    if($race & RACE_BLOODELF)
        $horde_count += 1;
    if($race & RACE_DRAENEI)
        $alliance_count += 1;
    if($alliance_count > 0 && $horde_count > 0)
        return array('side' => 3, 'name' => LOCALE_BOTH_FACTIONS);
    elseif(!$alliance_count && $horde_count > 0)
        return array('side' => 2, 'name' => LOCALE_HORDE);
    elseif($alliance_count > 0 && !$horde_count)
        return array('side' => 1, 'name' => LOCALE_ALLIANCE);
}
function armor($type)
{
    switch($type)
    {
        case 1:
            return LOCALE_ARMOR_CLOTH;
        case 2:
            return LOCALE_ARMOR_LEATHER;
        case 3:
            return LOCALE_ARMOR_MAIL;
        case 4:
            return LOCALE_ARMOR_PLATE;
        default:
            return NULL;
    }
}
function npc_classes($class)
{
    switch($class)
    {
        case 1:
            return '<a class="c1"><span class="warrior-icon">'.LOCALE_WARRIOR.'</span></a>';
        case 2:
            return '<a class="c2"><span class="paladin-icon">'.LOCALE_PALADIN.'</span></a>';
        case 4:
            return '<a class="c4"><span class="rogue-icon">'.LOCALE_ROGUE.'</span></a>';
        case 8:
            return '<a class="c8"><span class="mage-icon">'.LOCALE_MAGE.'</span></a>';
    }
}
function sum_subarrays_by_key( $tab, $key ) {
    $sum = 0;
    foreach($tab as $sub_array) {
        $sum += $sub_array[$key];
    }
    return $sum;
}
function ajax_str_normalize($string)
{
    return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));
}

function is_single_array($arr)
{
    if(!is_array($arr))
        return false;

    $i = 0;
    foreach($arr as $key => $value)
    {
        if($key != $i)
            return false;

        ++$i;
    }

    return true;
}

function php2js($data)
{
    if(is_array($data))
    {
        // Массив
        if(is_single_array($data))
        {
            // Простой массив []
            $ret = "[";
            $first = true;
            foreach ($data as $key => $obj)
            {
                if(!$first) $ret .= ',';
                $ret .= php2js($obj);
                $first = false;
            }
            $ret .= "]";
        }
        else
        {
            // Ассоциативный массив {}
            $ret = '{';
            $first = true;
            foreach($data as $key => $obj)
            {
                if(!$first) $ret .= ',';
                $ret .= $key.':'.php2js($obj);
                $first = false;
            }
            $ret .= '}';
        }
    }
    else
        // Просто значение
        $ret = is_string($data) ? ("'".nl2br(str_normalize($data))."'") : $data;

    return $ret;
}
// from php.net
function imagetograyscale($img)
{
    if(imageistruecolor($img))
        imagetruecolortopalette($img, false, 256);

    for($i = 0; $i < imagecolorstotal($img); $i++)
    {
        $color = imagecolorsforindex($img, $i);
        $gray = round(0.299 * $color['red'] + 0.587 * $color['green'] + 0.114 * $color['blue']);
        imagecolorset($img, $i, $gray, $gray, $gray);
    }
}
function path()
{
    $args = func_get_args();
    foreach ($args as $i => $arg)
        if (!isset($arg))
            unset($args[$i]);
    return '[' . implode(', ', $args) . ']';
}
function cache_key()
{
    $args = func_get_args();
    $x = '';
    foreach($args as $i => $arg)
    {
        if($i <> 0)
            $x .= '_';

        if(isset($arg))
            $x .= $arg;
        else
            $x .= 'x';
    }

    if(!$x)
        $x .= 'x';

    return $x;
}
function extract_values($str)
{
    $arr = explode('.', $str);

    foreach($arr as $i => $a)
    {
        if(!is_numeric($arr[$i]))
            $arr[$i] = null;
    }

    return $arr;
}
function array_select_key($array, $key)
{
    $result = array();
    foreach($array as $i => $value)
        if (isset($value[$key]))
            $result[] = $value[$key];
    return $result;
}
function redirect($url)
{
    echo "<html><head>\n";
    echo "<meta http-equiv=\"Refresh\" content=\"0; URL=?".htmlspecialchars($url)."\">\n";
    echo "<style type=\"text/css\">\n";
    echo "body {background-color: black;}\n";
    echo "</style>\n";
    echo "</head></html>";
    exit;
}
function localizedName($arr, $key = 'name')
{
    $result = '';

    if(!empty($arr[$key]))
        $result = $arr[$key];

    if(!empty($arr[$key.'_loc0']))
        $result = $arr[$key.'_loc0'];

    if($_SESSION['locale'] && !empty($arr[$key.'_loc']))
        $result = $arr[$key.'_loc'];

    if($_SESSION['locale'] && !empty($arr[$key.'_loc'.$_SESSION['locale']]))
        $result = $arr[$key.'_loc'.$_SESSION['locale']];

    return $result;
}
/* ================ CACHE ================ */
$cache_types = array(
    //    name                  multilocale
    array('npc_page',           false),
    array('npc_tooltip',        false),
    array('npc_listing',        false),

    array('object_page',        false),
    array('object_tooltip',     false),
    array('object_listing',     false),

    array('item_page',          false),
    array('item_tooltip',       false),
    array('item_listing',       false),

    array('itemset_page',       false),
    array('itemset_listing',    false),

    array('quest_page',         false),
    array('quest_tooltip',      false),
    array('quest_listing',      false),

    array('spell_page',         false),
    array('spell_tooltip',      false),
    array('spell_listing',      false),

    array('zone_page',          false),
    array('zone_listing',       false),

    array('faction_page',       false),
    array('faction_listing',    false),

    array('talent_data',        false),
    array('talent_icon',        true ),

    array('achievement_page',   false),
    array('achievement_tooltip',false),
    array('achievement_listing',false),

    array('glyphs',             false),
);
foreach($cache_types as $id => $cType)
{
    define(strtoupper($cType[0]), $id);
}
function save_cache($type, $type_id, $data, $prefix = '')
{
    global $cache_types, $allitems, $allspells, $allachievements, $npc, $object, $AoWoWconf;

    if($AoWoWconf['debug'])
        return;

    $type_str = $cache_types[$type][0];

    $cache_data = '';

    if(empty($type_str))
        return;

    $file = $prefix.'cache/mangos/'.$type_str.'_'.$type_id.($cache_types[$type][1] ? '' : '_'.$_SESSION['locale']).'.aww';

    if(!$file)
        return;

    // записываем дату и ревизию в файл
    $cache_data .= time().' '.AOWOW_REVISION;
    $cache_data .= "\n".serialize($data)."\n";

    $cache_data .= serialize($allitems);
    $cache_data .= "\n";
    $cache_data .= serialize($allspells);
    $cache_data .= "\n";
    $cache_data .= serialize($allachievements);
    $cache_data .= "\n";
    $cache_data .= serialize($npc);
    $cache_data .= "\n";
    $cache_data .= serialize($object);

    file_put_contents($file, $cache_data);
}
function load_cache($type, $type_id, $prefix = '')
{
    global $cache_types, $smarty, $allitems, $allspells, $allachievements, $npc, $object, $AoWoWconf;

    if($AoWoWconf['debug'] || $AoWoWconf['disable_cache'])
        return false;

    $type_str = $cache_types[$type][0];

    if(empty($type_str))
        return false;

    $data = @file_get_contents($prefix.'cache/mangos/'.$type_str.'_'.$type_id.($cache_types[$type][1] ? '' : '_'.$_SESSION['locale']).'.aww');
    if(!$data)
        return false;

    $data = explode("\n", $data);

    @list($time, $rev) = explode(' ', $data[0]);
    $expire_time = $time + $AoWoWconf['aowow']['cache_time'];
    if($expire_time <= time() || $rev < AOWOW_REVISION)
        return false;

    if($data[2])
        $allitems = unserialize($data[2]);
    if($data[3])
        $allspells = unserialize($data[3]);
    if($data[4])
        $allachievements = unserialize($data[4]);
    if($data[5])
        $npc = unserialize($data[5]);
    if($data[6])
        $object = unserialize($data[6]);

    return unserialize($data[1]);
}

// another placeholder
function ParseTextLinks($text)
{
    if(!preg_match_all('/(\[(achievement|item|quest|spell|npc|object)=(\d+)\])/', $text, $matches))
        return;

    $types = $matches[2];
    $ids = $matches[3];

    foreach($types as $i => $type)
    {
        $id = $ids[$i];
        switch($type)
        {
            case 'achievement':
                require_once('includes/allachievements.php');
                allachievementsinfo($id);
                break;
            case 'item':
                require_once('includes/allitems.php');
                allitemsinfo($id);
                break;
            case 'quest':
                require_once('includes/allquests.php');
                allquestinfo($id);
                break;
            case 'spell':
                require_once('includes/allspells.php');
                allspellsinfo($id);
                break;
            case 'npc':
                require_once('includes/allnpcs.php');
                creatureinfo($id);
                break;
            case 'object':
                require_once('includes/allobjects.php');
                objectinfo($id);
                break;
        }
    }
}

?>