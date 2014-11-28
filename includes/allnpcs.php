<?php
require_once('includes/alllocales.php');
// Для списка creatureinfo()
$npc_cols[0] = array('name', 'SubName', 'MinLevel', 'MaxLevel', 'CreatureType', 'Rank', 'DifficultyEntry1', 'DifficultyEntry2', 'DifficultyEntry3', 'Expansion');
$npc_cols[1] = array('name', 'SubName', 'MinLevel', 'MaxLevel', 'CreatureType', 'Rank', 'MinLevelHealth', 'MaxLevelHealth', 'MinLevelMana', 'MaxLevelMana', 'MinLootGold', 'MaxLootGold', 'LootId', 'SkinningLootId', 'PickpocketLootId', 'MinMeleeDmg', 'MaxMeleeDmg', 'MeleeAttackPower', 'DamageMultiplier', 'Armor', 'DifficultyEntry1', 'DifficultyEntry2', 'DifficultyEntry3', 'Expansion');
$npc_type = array(LOCALE_TYPENPC_UNDEFINED,LOCALE_TYPENPC_BEAST,LOCALE_TYPENPC_DRAGON,LOCALE_TYPENPC_DEMON,LOCALE_TYPENPC_ELEM,LOCALE_TYPENPC_GIANT,LOCALE_TYPENPC_UNDEAD,LOCALE_TYPENPC_HUMAN,LOCALE_TYPENPC_CRITTER,LOCALE_TYPENPC_MECHANIC,LOCALE_TYPENPC_UNCATEGORY,LOCALE_TYPENPC_TOTEM,LOCALE_TYPENPC_COMPANION,LOCALE_TYPENPC_GAS_CLOUD);
$npc_rank = array(LOCALE_NORMAL,LOCALE_ELITE,LOCALE_RARE_ELITE,LOCALE_BOSS,LOCALE_RARE,LOCALE_UNKNOWN);

// Функция информации о создании
function creatureinfo2($Row, $level = 0)
{
    global $npc_type, $npc_rank;
    $creature = array(
        'entry'          => $Row['entry'],
        'source_name'    => $Row['name'],
        'name'           => localizedName($Row),
        'subname'        => localizedName($Row, 'subname'),
        'minlevel'       => $Row['MinLevel'],
        'maxlevel'       => $Row['MaxLevel'],
        'react'          => $Row['A'].','.$Row['H'],
        'type'           => $Row['CreatureType'],
        'classification' => $Row['Rank'],
        'expansion'      => $Row['Expansion']
    );
    if ($creature['expansion'] == 1)
        $creature['expansion'] = '<span class="tbc-icon"></span>';
    elseif ($creature['expansion'] == 2)
        $creature['expansion'] = '<span class="wotlk-icon"></span>';
    else
        $creature['expansion'] = '';
    /*
    //entry
    if($creature['diffentry2'] != 0)
        $creature['name'] .= LOCALE_10NORMAL;
    elseif($creature['diffentry1'] != 0)
        $creature['name'] .= LOCALE_5NORMAL;
    //DifficultyEntry1
    //if(strpos($creature['name'],'(1)'))
    //DifficultyEntry2
    if(strpos($creature['name'],'(2)'))
        $creature['name'] = str_replace(' (2)', LOCALE_10HEROIC, $creature['name']);
    //DifficultyEntry3
    if(strpos($creature['name'],'(3)'))
        $creature['name'] = str_replace(' (3)', LOCALE_25HEROIC, $creature['name']);
    */
    $x = '';
    $x .= '<table><tr><td>'.$creature['expansion'].'<b class="q">';
    $x .= htmlspecialchars($creature['name']);
    $x .= '</b></td></tr><tr><td>';
    if($creature['subname'])
        $x .= '<'.htmlspecialchars($creature['subname']).'>';
    $x .= '</td></tr><tr><td>';
    if (isset($creature['minlevel']))
    {
        if($creature['classification'] == 3)
            $x .= LOCALE_LEVEL.' ?? ';
        elseif($creature['minlevel'] == $creature['maxlevel'])
            $x .= LOCALE_LEVEL.' '.$creature['minlevel'].' ';
        else
            $x .= LOCALE_LEVEL.' '.$creature['minlevel'].'-'.$creature['maxlevel'].' ';
    }
    if($creature['type'] && $creature['type'] != 10)
        $x .= $npc_type[$creature['type']].' ';
    if(isset($creature['classification']))
        $x .= '('.$npc_rank[$creature['classification']].')';
    $x .= '</tr></td></tr></table>';
    $creature['tooltip'] = $x;
    
    return $creature;
}

// Функция информации о создании
function creatureinfo($id, $level = 0)
{
    global $DB;
    global $npc_cols;
    $Row = $DB->selectRow('
            SELECT ?#, c.entry, ft.A, ft.H
            {
                , l.name_loc'.$_SESSION['locale'].' as `name_loc`
                , l.subname_loc'.$_SESSION['locale'].' as `subname_loc`
                , ?
            }
            FROM ?_factiontemplate ft, creature_template c
            {
                LEFT JOIN (locales_creature l)
                ON l.entry=c.entry AND ?
            }
            WHERE
                c.entry = ?d
                AND factiontemplateID = FactionAlliance
            LIMIT 1
        ',
        $npc_cols[$level],
        ($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
        ($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
        $id
    );
    return creatureinfo2($Row, $level);
}

?>