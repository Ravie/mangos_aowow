<?php
require_once('includes/alllocales.php');

// Для списка creatureinfo()
$npc_cols[0] = array('name', 'subname', 'minlevel', 'maxlevel', 'type', 'rank', 'A','H', 'difficulty_entry_1', 'difficulty_entry_2');
$npc_cols[1] = array('name', 'subname', 'minlevel', 'maxlevel', 'type', 'rank', 'minhealth', 'maxhealth', 'minmana', 'maxmana', 'mingold', 'maxgold', 'lootid', 'skinloot', 'pickpocketloot', 'A', 'H', 'mindmg', 'maxdmg', 'attackpower', 'dmg_multiplier', 'armor', 'difficulty_entry_1', 'difficulty_entry_2');
$npc_type = array('',LOCALE_TYPENPC_BEAST,LOCALE_TYPENPC_DRAGON,LOCALE_TYPENPC_DEMON,LOCALE_TYPENPC_ELEM,LOCALE_TYPENPC_GIANT,LOCALE_TYPENPC_UNDEAD,LOCALE_TYPENPC_HUMAN,LOCALE_TYPENPC_CRITTER,LOCALE_TYPENPC_MECHANIC,LOCALE_TYPENPC_UNCATEGORY);
$npc_rank = array(LOCALE_NORMAL,LOCALE_ELITE,LOCALE_RARE_ELITE,LOCALE_BOSS,LOCALE_RARE);

// Функция информации о создании
function creatureinfo2($Row, $level = 0)
{
	//global $DB;
	global $npc_type, $npc_rank;
	$creature = array(
		'entry'				=> $Row['entry'],
		'name'				=> localizedName($Row),
		'subname'			=> localizedName($Row, 'subname'),
		'minlevel'			=> $Row['minlevel'],
		'maxlevel'			=> $Row['maxlevel'],
		'react'				=> $Row['A'].','.$Row['H'],
		'type'				=> $Row['type'],
		'classification'	=> $Row['rank'],
		'diffentry1'		=> $Row['difficulty_entry_1'],
		'diffentry2'		=> $Row['difficulty_entry_2']
	);
	if($creature['diffentry2'] != 0)
		$creature['name'] .= LOCALE_10NORMAL;
	elseif($creature['diffentry1'] != 0)
		$creature['name'] .= LOCALE_5NORMAL;
	/*if(strpos($creature['name'],'(1)'))
	{
		$creature['name'] = str_replace(' (1)', '', $creature['name']);
		$tmp = $DB->selectRow('SELECT difficulty_entry_2		  		// FIX ME - query is too slow
							   FROM creature_template 
							   WHERE difficulty_entry_1 = ?d LIMIT 1
							  ', $creature['entry']);
		if($tmp)
		{
			if($tmp['difficulty_entry_2'] != 0)
				$creature['name'] .= LOCALE_25NORMAL;
			else
				$creature['name'] .= LOCALE_5HEROIC;
			unset($tmp);
		}
	}*/
	if(strpos($creature['name'],'(2)'))
		$creature['name'] = str_replace(' (2)', LOCALE_10HEROIC, $creature['name']);
	if(strpos($creature['name'],'(3)'))
		$creature['name'] = str_replace(' (3)', LOCALE_25HEROIC, $creature['name']);
	
	$x = '';
	$x .= '<table><tr><td><b class="q">';
	$x .= htmlspecialchars($creature['name']);
	$x .= '</b></td></tr><tr><td>';
	if($creature['subname'])
		$x .= htmlspecialchars($creature['subname']);
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
	if($creature['type'] != 10)
		$x .= $npc_type[$creature['type']].' ';
	if(isset($creature['classification']))
		$x .= $npc_rank[$creature['classification']];
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