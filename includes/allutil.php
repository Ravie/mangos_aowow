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
// Классы персонажей
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
$classes_icon = array(
    1 => 'warrior-icon',
    2 => 'paladin-icon',
    3 => 'hunter-icon',
    4 => 'rogue-icon',
    5 => 'priest-icon',
    6 => 'deathknight-icon',
    7 => 'shaman-icon',
    8 => 'mage-icon',
    9 => 'warlock-icon',
    11=> 'druid-icon'
);
$alliance_races = array(
    1    => LOCALE_HUMAN,
    4    => LOCALE_DWARF,
    8    => LOCALE_NIGHTELF,
    64   => LOCALE_GNOME,
    1024 => LOCALE_DRAENEI,
);
$horde_races = array(
    2    => LOCALE_ORC,
    16   => LOCALE_UNDEAD,
    32   => LOCALE_TAUREN,
    128  => LOCALE_TROLL,
    512  => LOCALE_BLOODELF,
);
$races_icon = array(
    1    => 'human-icon',
    2    => 'orc-icon',
    4    => 'dwarf-icon',
    8    => 'nightelf-icon',
    16   => 'undead-icon',
    32   => 'tauren-icon',
    64   => 'gnome-icon',
    128  => 'troll-icon',
    512  => 'bloodelf-icon',
    1024 => 'draenei-icon'
);
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
    global $classes_icon, $classes;
    $reqclass = array();
    foreach($classes_icon as $i => $icon_name)
        if ($class & (1<<($i-1)))
            $reqclass[] = '<a class="c'.$i.'"><span class="'.$icon_name.'">'.$classes[$i].'</span></a>';
    if(!count($reqclass) || count($reqclass) == 10)
        return NULL;
    else
        return implode(", ", $reqclass);
}
function races($race)
{
    if($race == -1 || !$race)
        return NULL;
    global $alliance_races, $horde_races, $races_icon;
    $alliance = array();
    $horde = array();
    foreach($alliance_races as $bitmask => $race_name)
        if ($race & $bitmask)
            $alliance[] = '<span class="'.$races_icon[$bitmask].'">'.$race_name.'</span></a>';
    foreach($horde_races as $bitmask => $race_name)
        if ($race & $bitmask)
            $horde[] = '<span class="'.$races_icon[$bitmask].'">'.$race_name.'</span></a>';
    if(count($alliance) == 5 || count($horde) == 5)
        $temp = NULL;
    else
        return implode(", ", array_merge($alliance, $horde));
}
function factions($race)
{
    if($race == -1 || !$race)
        return 3;
    global $alliance_races, $horde_races;
    $alliance_count = 0;
    $horde_count = 0;
    foreach($alliance_races as $bitmask => $race_name)
        if ($race & $bitmask)
            $alliance_count++;
    foreach($horde_races as $bitmask => $race_name)
        if ($race & $bitmask)
            $horde_count++;
    if($alliance_count > 0 && $horde_count > 0)
        return 3;
    elseif(!$alliance_count && $horde_count > 0)
        return 2;
    elseif($alliance_count > 0 && !$horde_count)
        return 1;
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
    global $classes_icon, $classes;
    if (isset($classes[$class]))
        return '<a class="c'.$class.'"><span class="'.$classes_icon[$class].'">'.$classes[$class].'</span></a>';
    return ERR_UNK_CLASS;
}
function npc_expansion($exp)
{
    switch($exp)
    {
        case 0:
            return;
        case 1:
            return '<span class="tbc-icon">';
        case 2:
            return '<span class="wotlk-icon">';
        default:
            return ERR_UNK_EXP;
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