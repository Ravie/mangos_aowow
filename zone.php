<?php

require_once('includes/allutil.php');
require_once('includes/allitems.php');
if(!$AoWoWconf['disable_comments'])
    require_once('includes/allcomments.php');

$smarty->config_load($conf_file, 'zone');

// номер объекта;
$id = intval($podrazdel);

$file = dirname(__FILE__).'/images/maps/enus/normal/'.$id;
if (!file_exists($file.'.jpg') && file_exists($file.'_1.jpg'))
    $level = 1;

$pos = strpos($podrazdel, "_");
if ($pos)
    $level = substr($podrazdel, $pos+1);

$cache_key = cache_key($id);

if(!$zone = load_cache(ZONE_PAGE, $cache_key))
{
    unset($zone);

    // Данные об объекте:
    $zone = $DB->selectRow('SELECT * FROM ?_zones WHERE areatableID = ?d', $id);
    $zone['name'] = localizedName($zone);

    if(!($zone['fishing'] = loot('fishing_loot_template', $id)))
        unset($zone['fishing']);

    if($zone['parent'])
    {
        $row = $DB->selectRow('SELECT * FROM ?_zones WHERE areatableID = ?d', $zone['parent']);
        if ($row)
            $parentname = localizedName($row);
        unset($row);
        if (!empty($parentname))
            $zone['parentname'] = $parentname;
    }

    $rows = $DB->select('SELECT * FROM ?_zones WHERE parent = ?d', $id);
    if ($rows)
    {
        $zone['subzones'] = array();
        foreach($rows as $row)
        {
            $zone['subzones'][] = array(
                'id' => $row['areatableID'],
                'name' => localizedName($row),
                'explevel' => $row['explevel']
            );
        }
    }
    unset($rows);

    $rows = $DB->select('SELECT * FROM ?_dungeon_floor WHERE MapID = ?d', $zone['mapID']);
    if ($rows)
    {
        $zone['floors'] = array();
        foreach($rows as $row)
        {
            $zone['floors'][$row['DungeonFloor']][] = array(
                'name'  => localizedName($row),
                'floor' => $row['DungeonFloor']
            );
        }
    }
    unset($rows);

    $zone['position'] = array();

    // Optimized version of position() + transform_coords() without map mask check
    if ($zone['x_min'] && $zone['y_min'] && $zone['x_max'] && $zone['y_max'])
    {
        // Flight masters
        $rows = $DB->select('
            SELECT ct.entry, ct.name, ct.SubName, lc.name_loc?d, lc.subname_loc?d, ct.NpcFlags, position_x, position_y
            FROM creature c, creature_template ct
            LEFT JOIN locales_creature lc ON ct.entry = lc.entry
            WHERE c.id = ct.entry
              AND ct.NpcFlags & 126976
              AND c.map = ?d
              AND c.position_x > ?f
              AND c.position_x < ?f
              AND c.position_y > ?f
              AND c.position_y < ?f
            ',
            $_SESSION['locale'] > 0 ? $_SESSION['locale'] : 1,
            $_SESSION['locale'] > 0 ? $_SESSION['locale'] : 1,
            $zone['mapID'],
            $zone['x_min'],
            $zone['x_max'],
            $zone['y_min'],
            $zone['y_max']);
        if ($rows)
        {
            $taxies = array(
                'population' => 0,
                'name' => LOCALE_ZONE_FLIGHT_MASTERS,
                'atid' => $id.($level ? "_".$level : ""),
                'points' => array()
            );
            $inns = array(
                'population' => 0,
                'name' => LOCALE_ZONE_INNKEEPERS,
                'atid' => $id.($level ? "_".$level : ""),
                'points' => array()
            );
            $repairers = array(
                'population' => 0,
                'name' => LOCALE_ZONE_REPAIRERS,
                'atid' => $id.($level ? "_".$level : ""),
                'points' => array()
            );
            $spirithealers = array(
                'population' => 0,
                'name' => LOCALE_ZONE_SPIRIT_HEALERS,
                'atid' => $id.($level ? "_".$level : ""),
                'points' => array()
            );
            foreach($rows as $row)
            {
                $name = localizedName($row);
                $subname = localizedName($row, "subname");
                if ($subname)
                    $name = $name . " <" . $subname . ">";

                $point = array(
                    'name' => $name,
                    'type' => 0, // affects pin color (style=pin-$type)
                    'url' => '?npc='.$row['entry'],
                    'x' => round(100 - ($row['position_y']-$zone['y_min']) / (($zone['y_max']-$zone['y_min']) / 100), 2),
                    'y' => round(100 - ($row['position_x']-$zone['x_min']) / (($zone['x_max']-$zone['x_min']) / 100), 2)
                );

                if ($row['NpcFlags']&8192)
                {
                    $taxies['population']++;
                    $taxies['points'][] = $point;
                }
                if ($row['NpcFlags']&65536)
                {
                    $inns['population']++;
                    $inns['points'][] = $point;
                }
                if ($row['NpcFlags']&4096)
                {
                    $repairers['population']++;
                    $repairers['points'][] = $point;
                }
                if ($row['NpcFlags']&16384 || $row['NpcFlags']&32768)
                {
                    $spirithealers['population']++;
                    $spirithealers['points'][] = $point;
                }
            }
            if ($taxies['population'])
                $zone['position'][] = $taxies;
            if ($inns['population'])
                $zone['position'][] = $inns;
            if ($repairers['population'])
                $zone['position'][] = $repairers;
            if ($spirithealers['population'])
                $zone['position'][] = $spirithealers;
        }

    }

    if (!$zone['position'])
    {
        $zone['position'] = array(
            array(
                'population' => 0,
                'name' => ""/*$zone['name']*/,
                'atid' => $id.($level ? "_".$level : ""),
                'points' => array()
            )
        );
    }

/*    // Положения объектофф:
    $zone['position'] = position($object['entry'], 'gameobject');

    // Исправить type, чтобы подсвечивались event-овые объекты
    if ($object['position'])
        foreach ($object['position'] as $z => $zone)
            foreach ($zone['points'] as $p => $pos)
                if ($pos['type'] == 0 && ($events = event_find(array('object_guid' => $pos['guid']))))
                {
                    $names = array_select_key(event_name($events), 'name');
                    $object['position'][$z]['points'][$p]['type'] = 4;
                    $object['position'][$z]['points'][$p]['events'] = implode(", ", $names);
                }
*/
    save_cache(ZONE_PAGE, $cache_key, $zone);
}

global $page;
$page = array(
    'Mapper' => true,
    'Book' => false,
    'Title' => $zone['name'].' - '.$smarty->get_config_vars('Zone'),
    'tab' => 1,
    'type' => 0,
    'typeid' => 0,
    'path' => path(1, 1), //path(0, 6, $zone['map'])
    'comment' => true
);

// Комментарии
if($AoWoWconf['disable_comments'])
    $page['comment'] = false;
else
    $smarty->assign('comments', getcomments($page['type'], $page['typeid']));
$smarty->assign('page', $page);

// Количество MySQL запросов
$smarty->assign('mysql', $DB->getStatistics());

$smarty->assign('zone', $zone);
$smarty->display('zone.tpl');

?>