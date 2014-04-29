<?php
require_once('includes/alllocales.php');

// Для списка creatureinfo()
$npc_cols[0] = array('name', 'subname', 'minlevel', 'maxlevel', 'type', 'rank', 'A','H');
$npc_cols[1] = array('name', 'subname', 'minlevel', 'maxlevel', 'type', 'rank', 'minhealth', 'maxhealth', 'minmana', 'maxmana', 'mingold', 'maxgold', 'lootid', 'skinloot', 'pickpocketloot', 'A', 'H', 'mindmg', 'maxdmg', 'attackpower', 'dmg_multiplier', 'armor', 'difficulty_entry_1');
$npc_type = array('',LOCALE_TYPENPC_BEAST,LOCALE_TYPENPC_DRAGON,LOCALE_TYPENPC_DEMON,LOCALE_TYPENPC_ELEM,LOCALE_TYPENPC_GIANT,LOCALE_TYPENPC_UNDEAD,LOCALE_TYPENPC_HUMAN,LOCALE_TYPENPC_CRITTER,LOCALE_TYPENPC_MECHANIC,LOCALE_TYPENPC_UNCATEGORY);
$npc_rank = array(LOCALE_NORMAL,LOCALE_ELITE,LOCALE_RARE_ELITE,LOCALE_BOSS,LOCALE_RARE);

// Функция информации о создании
function creatureinfo2($Row, $level = 0)
{
    global $npc_type, $npc_rank;
	$creature = array(
		'entry'				=> $Row['entry'],
		'name'				=> localizedName($Row), // TODO: DifficultyEntry
		'subname'			=> localizedName($Row, 'subname'),
		'minlevel'			=> $Row['minlevel'],
		'maxlevel'			=> $Row['maxlevel'],
		'react'				=> $Row['A'].','.$Row['H'],
		'type'				=> $Row['type'],
		'classification'	=> $Row['rank']
	);
    
    $x = '';
	$x .= '<table><tr><td><b class="q">';
    $x .= htmlspecialchars(localizedName($Row));
	$x .= '</b></td></tr><tr><td>';
    if(localizedName($Row, 'subname'))
        $x .= htmlspecialchars(localizedName($Row, 'subname'));
    $x .= '</td></tr><tr><td>';
    if (isset($Row['minlevel']))
    {
        if($Row['rank'] == 3)
            $x .= LOCALE_LEVEL.' ?? ';
        elseif($Row['minlevel'] == $Row['maxlevel'])
            $x .= LOCALE_LEVEL.' '.$Row['minlevel'].' ';
        else
            $x .= LOCALE_LEVEL.' '.$Row['minlevel'].'-'.$Row['maxlevel'].' ';
    }
    if($Row['type'] != 10)
        $x .= $npc_type[$Row['type']].' ';
    if(isset($Row['rank']))
        $x .= $npc_rank[$Row['rank']];
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
			SELECT ?#, c.entry
			{
				, l.name_loc'.$_SESSION['locale'].' as `name_loc`
				, l.subname_loc'.$_SESSION['locale'].' as `subname_loc`
				, ?
			}
			FROM ?_factiontemplate, creature_template c
			{
				LEFT JOIN (locales_creature l)
				ON l.entry=c.entry AND ?
			}
			WHERE
				c.entry = ?d
				AND factiontemplateID = faction_A
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