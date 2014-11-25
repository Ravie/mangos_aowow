<?php

// Необходима функция creatureinfo
require_once('includes/allnpcs.php');

$smarty->config_load($conf_file, 'npc');

@list($type) = extract_values($podrazdel);

$cache_key = cache_key($type);

if(!$npcs = load_cache(NPC_LISTING, $cache_key))
{
    unset($npcs);

    $rows = $DB->select('
        SELECT c.?#, c.entry, A, H
        {
            , l.name_loc?d AS name_loc
            , l.subname_loc?d AS subname_loc
        }
        FROM ?_factiontemplate, creature_template c
        { LEFT JOIN (locales_creature l) ON l.entry=c.entry AND ? }
        WHERE
            factiontemplateID=FactionAlliance
            {AND CreatureType=?}
        ORDER BY MinLevel DESC, name
        {LIMIT ?d}
        ',
        $npc_cols[0],
        ($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
        ($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
        ($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
        isset($type) ? $type : DBSIMPLE_SKIP,
        ($AoWoWconf['limit']!=0)? $AoWoWconf['limit']: DBSIMPLE_SKIP
    );

    $npcs = array();
    foreach($rows as $row)
    {
        if(!$creature[$row['entry']])
        {
            if($row['DifficultyEntry2'])
            {
                $normal_raid10 = creatureinfo2($row);
                $normal_raid10['name'] .= LOCALE_10NORMAL;
                $npcs[] = $normal_raid10;
                $creature[$normal_raid10['entry']] = true;
                unset($normal_raid10);
                
                $normal_raid25 = creatureinfo($row['DifficultyEntry1']);
                if($normal_raid25['source_name'] == $normal_raid25['name'])
                    $normal_raid25['name'] = $row['name_loc'].LOCALE_25NORMAL;
                elseif(strpos($normal_raid25['name'],'(1)') === false)
                    $normal_raid25['name'] .= LOCALE_25NORMAL;
                else
                    $normal_raid25['name'] = str_replace(' (1)', LOCALE_25NORMAL, $normal_raid25['name']);
                $npcs[] = $normal_raid25;
                $creature[$normal_raid25['entry']] = true;
                unset($normal_raid25);
                
                $heroic_raid10 = creatureinfo($row['DifficultyEntry2']);
                if($heroic_raid10['source_name'] == $heroic_raid10['name'])
                    $heroic_raid10['name'] = $row['name_loc'].LOCALE_10HEROIC;
                elseif(strpos($heroic_raid10['name'],'(2)') === false)
                    $heroic_raid10['name'] .= LOCALE_10HEROIC;
                else
                    $heroic_raid10['name'] = str_replace(' (2)', LOCALE_10HEROIC, $heroic_raid10['name']);
                $npcs[] = $heroic_raid10;
                $creature[$heroic_raid10['entry']] = true;
                unset($heroic_raid10);
                
                if($row['DifficultyEntry3'])
                {
                    $heroic_raid25 = creatureinfo($row['DifficultyEntry3']);
                    if($heroic_raid25['source_name'] == $heroic_raid25['name'])
                        $heroic_raid25['name'] = $row['name_loc'].LOCALE_25HEROIC;
                    elseif(strpos($heroic_raid25['name'],'(3)') === false)
                        $heroic_raid25['name'] .= LOCALE_25HEROIC;
                    else
                        $heroic_raid25['name'] = str_replace(' (3)', LOCALE_25HEROIC, $heroic_raid25['name']);
                    $npcs[] = $heroic_raid25;
                    $creature[$heroic_raid25['entry']] = true;
                    unset($heroic_raid25);
                }
            }
            elseif($row['DifficultyEntry1'])
            {
                $normal_dungeon = creatureinfo2($row);
                $normal_dungeon['name'] .= LOCALE_5NORMAL;
                $npcs[] = $normal_dungeon;
                $creature[$normal_dungeon['entry']] = true;
                unset($normal_dungeon);
                
                $heroic_dungeon = creatureinfo($row['DifficultyEntry1']);
                if($heroic_dungeon['source_name'] == $heroic_dungeon['name'])
                    $heroic_dungeon['name'] = $row['name_loc'].LOCALE_5HEROIC;
                elseif(strpos($heroic_dungeon['name'],'(1)') === false)
                    $heroic_dungeon['name'] .= LOCALE_5HEROIC;
                else
                    $heroic_dungeon['name'] = str_replace(' (1)', LOCALE_5HEROIC, $heroic_dungeon['name']);
                $npcs[] = $heroic_dungeon;
                $creature[$heroic_dungeon['entry']] = true;
                unset($heroic_dungeon);
            }
            elseif((strpos($row['name'],'(1)') === false) && (strpos($row['name'],'(2)') === false) && (strpos($row['name'],'(3)') === false))
                $npcs[] = creatureinfo2($row);
        }
    }
    save_cache(NPC_LISTING, $cache_key, $npcs);
}

global $page;
$page = array(
    'Mapper' => false,
    'Book' => false,
    'Title' => $smarty->get_config_vars('NPCs'),
    'tab' => 0,
    'type' => 0,
    'typeid' => 0,
    'path' => path(0, 4, $type)
);
$smarty->assign('page', $page);

$smarty->assign('npcs', $npcs);
// Количество MySQL запросов
$smarty->assign('mysql', $DB->getStatistics());
// Загружаем страницу
$smarty->display('npcs.tpl');

?>