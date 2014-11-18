<?php

require_once('includes/allspells.php');
require_once('includes/allquests.php');
require_once('includes/allnpcs.php');
require_once('includes/allachievements.php');
require_once('includes/allevents.php');
if(!$AoWoWconf['disable_comments'])
	require_once('includes/allcomments.php');

// Настраиваем Smarty ;)
$smarty->config_load($conf_file, 'npc');

$id = intval($podrazdel);

$cache_key = cache_key($id);

if(!$npc = load_cache(NPC_PAGE, $cache_key))
{
	unset($npc);

	// Ищем NPC:
	$row = $DB->selectRow('
		SELECT
			?#, c.entry, ft.A, ft.H,
			{
				l.name_loc'.$_SESSION['locale'].' as `name_loc`,
				l.subname_loc'.$_SESSION['locale'].' as `subname_loc`,
				?,
			}
			f.name_loc'.$_SESSION['locale'].' as `faction-name`, ft.factionID as `factionID`
		FROM ?_factiontemplate ft, ?_factions f, creature_template c
		{
			LEFT JOIN (locales_creature l)
			ON l.entry = c.entry AND ?
		}
		WHERE
			c.entry = ?
			AND ft.factiontemplateID = c.FactionAlliance
			AND f.factionID = ft.factionID
		LIMIT 1
			',
		$npc_cols[1],
		($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
		($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
		$id
	);

	if($row)
	{
		$npc = array
		(
			'entry'				=> $row['entry'],
			'name'				=> localizedName($row),
			'subname'			=> localizedName($row, 'subname'),
			'name_loc'			=> $row['name_loc'],
			'subname_loc'		=> $row['subname_loc'],
			'minlevel'			=> $row['MinLevel'],
			'maxlevel'			=> $row['MaxLevel'],
			'A'					=> $row['A'],
			'H'					=> $row['H'],
			'type'				=> $row['CreatureType'],
			'rank'				=> $row['Rank'],
			'minhealth'			=> $row['MinLevelHealth'], 
			'maxhealth'			=> $row['MaxLevelHealth'], 
			'minmana'			=> $row['MinLevelMana'], 
			'maxmana'			=> $row['MaxLevelMana'],
			'attackpower'		=> $row['MeleeAttackPower'], 
			'dmg_multiplier'	=> $row['DamageMultiplier'], 
			'armor'				=> $row['Armor'],
			'difficulty_entry_1'=> $row['DifficultyEntry1'],
			'difficulty_entry_2'=> $row['DifficultyEntry2'],
			'difficulty_entry_3'=> $row['DifficultyEntry3'],
			'expansion'			=> $row['Expansion']
		);
		// Full localization of NPC's
		if($npc['name'] == $npc['name_loc'])
		{
			$source_npc = $DB->selectRow('
						SELECT c.entry, c.name
						{
							, l.name_loc?d as `name_loc`
						}
						FROM creature_template c
						{
							LEFT JOIN (locales_creature l)
							ON l.entry = c.entry AND ?
						}
						WHERE
							c.DifficultyEntry1 = ?d OR c.DifficultyEntry2 = ?d OR c.DifficultyEntry3 = ?d
						LIMIT 1
					',
					($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
					($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
					$npc['entry'], $npc['entry'], $npc['entry']
				);
			if($source_npc)
				$npc['name'] = $source_npc['name_loc'];
			unset($source_npc);
		}
		else
			$npc['name'] = localizedName($row);
		// Difficulty_entry
		if($npc['difficulty_entry_2'] != 0)
			$npc['name'] .= LOCALE_10NORMAL;
		elseif($npc['difficulty_entry_1'] != 0)
			$npc['name'] .= LOCALE_5NORMAL;
		if(strpos($row['name'],'(1)'))
		{
			$npc['name'] = str_replace(' (1)', '', $npc['name']);
			$tmp = $DB->selectRow('SELECT DifficultyEntry2
								   FROM creature_template 
								   WHERE DifficultyEntry1 = ?d LIMIT 1', $npc['entry']);
			if($tmp['DifficultyEntry2'] != 0)
				$npc['name'] .= LOCALE_25NORMAL;
			else
				$npc['name'] .= LOCALE_5HEROIC;
			unset($tmp);
		}
		if(strpos($row['name'],'(2)'))
		{
			$npc['name'] = str_replace(' (2)', '', $npc['name']);
			$npc['name'] .= LOCALE_10HEROIC;
		}
		if(strpos($row['name'],'(3)'))
		{
			$npc['name'] = str_replace(' (3)', '', $npc['name']);
			$npc['name'] .= LOCALE_25HEROIC;
		}
		if ($npc['expansion'] == 1)
			$npc['expansion'] = '<span class="tbc-icon"></span>';
		elseif ($npc['expansion'] == 2)
			$npc['expansion'] = '<span class="wotlk-icon"></span>';
		else
			$npc['expansion'] = '';
		$npc['subname'] = localizedName($row, 'subname');
		if($npc['rank'] == 3)
		{
			$npc['minlevel'] = '??';
			$npc['maxlevel'] = '??';
		}
		$npc['mindmg'] = round(($row['MinMeleeDmg'] + $row['MeleeAttackPower']) * $row['DamageMultiplier']);
		$npc['maxdmg'] = round(($row['MaxMeleeDmg'] + $row['MeleeAttackPower']) * $row['DamageMultiplier']);
		
		$toDiv = array('minhealth', 'maxmana', 'minmana', 'maxhealth', 'armor', 'mindmg', 'maxdmg');
		// Разделяем на тысячи (ххххххххх => ххх,ххх,ххх)
		foreach($toDiv as $e)
			$npc[$e] = number_format($npc[$e]);

		$npc['rank'] = $smarty->get_config_vars('rank'.$npc['rank']);
		// FactionAlliance = FactionHorde
		$npc['faction_num'] = $row['factionID'];
		$npc['faction'] = $row['faction-name'];
		// Деньги
		$money = ($row['MinLootGold']+$row['MaxLootGold']) / 2;
		$npc = array_merge($npc, money2coins($money));
		// Героик/нормал копия НПС
		if($npc['difficulty_entry_1'])
		{
			// это нормал НПС, ищем героика
			if($tmp = creatureinfo($npc['difficulty_entry_1']))
			{
				$tmp['name'] = str_replace(' (1)', '', $tmp['name']);
				$npc['normal']['de1'] = array(
					'entry'	=> $tmp['entry'],
					'name'	=> $tmp['name']
				);
				if($tmp['name'] == $row['name'])
					$npc['normal']['de1']['name'] = str_replace(LOCALE_10NORMAL, '', $npc['name']);
				unset($tmp);
			}
			if($npc['difficulty_entry_2'])
			{
				if($tmp = creatureinfo($npc['difficulty_entry_2']))
				{
					$tmp['name'] = str_replace(LOCALE_10HEROIC, '', $tmp['name']);
					$npc['normal']['de2'] = array(
						'entry'	=> $tmp['entry'],
						'name'	=> $tmp['name']
					);
					if($tmp['name'] == $row['name'])
						$npc['normal']['de2']['name'] = str_replace(LOCALE_10NORMAL, '', $npc['name']);
					unset($tmp);
				}
			}
			if($npc['difficulty_entry_3'])
			{
				if($tmp = creatureinfo($npc['difficulty_entry_3']))
				{
					$tmp['name'] = str_replace(LOCALE_25HEROIC, '', $tmp['name']);
					$npc['normal']['de3'] = array(
						'entry'	=> $tmp['entry'],
						'name'	=> $tmp['name']
					);
					if($tmp['name'] == $row['name'])
						$npc['normal']['de3']['name'] = str_replace(LOCALE_10NORMAL, '', $npc['name']);
					unset($tmp);
				}
			}
		}
		else
		{
			// А может быть героик НПС одним для нескольких нормалов?
			// считаем что нет
			$tmp = $DB->selectRow('
					SELECT c.entry, c.name, c.DifficultyEntry2, c.DifficultyEntry3
					{
						, l.name_loc?d as `name_loc`
					}
					FROM creature_template c
					{
						LEFT JOIN (locales_creature l)
						ON l.entry = c.entry AND ?
					}
					WHERE
						c.DifficultyEntry1 = ?d
					LIMIT 1
				',
				($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
				($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
				$npc['entry']
			);
			if($tmp)
			{
				$npc['de1']['normal'] = array(
					'entry'	=> $tmp['entry'],
					'name'	=> $tmp['name_loc']
				);
				if($tmp['DifficultyEntry2'] != 0)
				{
					$npc['de1']['de2'] = array(
						'entry'	=> $tmp['DifficultyEntry2'],
						'name'	=> $tmp['name_loc']
					);
					if($tmp['DifficultyEntry3'] != 0)
					{
						$npc['de1']['de3'] = array(
							'entry'	=> $tmp['DifficultyEntry3'],
							'name'	=> $tmp['name_loc']
						);
					}
				}
				$normal_entry = $tmp['entry'];
				unset($tmp);
			}
			$tmp = $DB->selectRow('
					SELECT c.entry, c.name, c.DifficultyEntry1, c.DifficultyEntry3
					{
						, l.name_loc?d as `name_loc`
					}
					FROM creature_template c
					{
						LEFT JOIN (locales_creature l)
						ON l.entry = c.entry AND ?
					}
					WHERE
						c.DifficultyEntry2 = ?d
					LIMIT 1
				',
				($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
				($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
				$npc['entry']
			);
			if($tmp)
			{
				$npc['de2']['normal'] = array(
					'entry'	=> $tmp['entry'],
					'name'	=> $tmp['name_loc']
				);
				$npc['de2']['de1'] = array(
					'entry'	=> $tmp['DifficultyEntry1'],
					'name'	=> $tmp['name_loc']
				);
				if($tmp['DifficultyEntry3'] != 0)
				{
					$npc['de2']['de3'] = array(
						'entry'	=> $tmp['DifficultyEntry3'],
						'name'	=> $tmp['name_loc']
					);
				}
				$normal_entry = $tmp['entry'];
				unset($tmp);
			}
			$tmp = $DB->selectRow('
					SELECT c.entry, c.name, c.DifficultyEntry1, c.DifficultyEntry2
					{
						, l.name_loc?d as `name_loc`
					}
					FROM creature_template c
					{
						LEFT JOIN (locales_creature l)
						ON l.entry = c.entry AND ?
					}
					WHERE
						c.DifficultyEntry3 = ?d
					LIMIT 1
				',
				($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
				($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
				$npc['entry']
			);
			if($tmp)
			{
				$npc['de3']['normal'] = array(
					'entry'	=> $tmp['entry'],
					'name'	=> $tmp['name_loc']
				);
				$npc['de3']['de1'] = array(
					'entry'	=> $tmp['DifficultyEntry1'],
					'name'	=> $tmp['name_loc']
				);
				$npc['de3']['de2'] = array(
					'entry'	=> $tmp['DifficultyEntry2'],
					'name'	=> $tmp['name_loc']
				);
				$normal_entry = $tmp['entry'];
				unset($tmp);
			}
		}
		// Дроп
		$lootid = $row['LootId'];
		$skinid = $row['SkinningLootId'];
		$pickpocketid = $row['PickpocketLootId'];
		// Используемые спеллы
		$npc['ablities'] = array();
		$tmp = array();
		$row_spells = $DB->select
		('SELECT spell1, spell2, spell3, spell4, spell5, spell6, spell7, spell8
		  FROM creature_template_spells
		  WHERE entry=?d', $npc['entry']);
		for($j=1;$j<8;$j++)
		{
			if($row_spells['spell'.$j] && !in_array($row_spells['spell'.$j], $tmp))
			{
				$tmp[] = $row_spells['spell'.$j];
				if($data = spellinfo($row_spells['spell'.$j], 0))
				{
					if($data['name'])
						$npc['abilities'][] = $data;
				}
			}
		}
		for($j=1;$j<4;$j++)
		{
			$tmp2 = $DB->select('
				SELECT action?d_param1
				FROM creature_ai_scripts
				WHERE
					creature_id=?d
					AND action?d_type=11
				',
				$j,
				$npc['entry'],
				$j
			);
			if($tmp2)
				foreach($tmp2 as $i=>$tmp3)
					if(!in_array($tmp2[$i]['action'.$j.'_param1'], $tmp))
					{
						$tmp[] = $tmp2[$i]['action'.$j.'_param1'];
						if($data = spellinfo($tmp2[$i]['action'.$j.'_param1'], 0))
						{
							if($data['name'])
								$npc['abilities'][] = $data;
						}
					}
		}
		if(!$npc['ablities'])
			unset($npc['ablities']);

		// Обучает:
		// Если это пет со способностью:
		/* // Временно закомментировано
		$row = $DB->selectRow('
			SELECT Spell1, Spell2, Spell3, Spell4
			FROM petcreateinfo_spell
			WHERE
				entry=?d
			',
			$npc['entry']
		);
		if($row)
		{
			$npc['teaches'] = array();
			for($j=1;$j<=4;$j++)
				if($row['Spell'.$j])
					for($k=1;$k<=3;$k++)
					{
						$spellrow = $DB->selectRow('
							SELECT ?#, spellID
							FROM ?_spell, ?_spellicons
							WHERE
								spellID=(SELECT effect'.$k.'triggerspell FROM ?_spell WHERE spellID=?d AND (effect'.$k.'id IN (36,57)))
								AND id=spellicon
							LIMIT 1
							',
							$spell_cols[2],
							$row['Spell'.$j]
						);
						if($spellrow)
						{
							$num = count($npc['teaches']);
							$npc['teaches'][$num] = array();
							$npc['teaches'][$num] = spellinfo2($spellrow);
						}
					}
		}
		unset ($row);*/

		// Если это просто тренер
		$teachspells = $DB->select('
			SELECT ?#, spellID
			FROM npc_trainer, ?_spell, ?_spellicons
			WHERE
				entry=?d
				AND spellID=Spell
				AND id=spellicon
			',
			$spell_cols[2],
			$npc['entry']
		);
		if($teachspells)
		{
			if(!(IsSet($npc['teaches'])))
				$npc['teaches'] = array();
			foreach($teachspells as $teachspell)
			{
						$num = count($npc['teaches']);
						$npc['teaches'][$num] = array();
						$npc['teaches'][$num] = spellinfo2($teachspell);
			}
		}
		unset ($teachspells);

		// Продает:
		$rows_s = $DB->select('
			SELECT ?#, i.entry, i.maxcount, n.`maxcount` as `drop-maxcount`, n.ExtendedCost
				{, l.name_loc?d AS `name_loc`}
			FROM npc_vendor n, ?_icons, item_template i
				{LEFT JOIN (locales_item l) ON l.entry=i.entry AND ?d}
			WHERE
				n.entry=?
				AND i.entry=n.item
				AND id=i.displayid
			',
			$item_cols[2],
			($_SESSION['locale'])? $_SESSION['locale']: DBSIMPLE_SKIP,
			($_SESSION['locale'])? 1: DBSIMPLE_SKIP,
			$id
		);
		if($rows_s)
		{
			$npc['sells'] = array();
			foreach($rows_s as $numRow=>$row)
			{
				$npc['sells'][$numRow] = array();
				$npc['sells'][$numRow] = iteminfo2($row);
				$npc['sells'][$numRow]['maxcount'] = $row['drop-maxcount'];
				$npc['sells'][$numRow]['cost'] = array();
				if($row['ExtendedCost'])
				{
					$extcost = $DB->selectRow('SELECT * FROM ?_item_extended_cost WHERE extendedcostID=?d LIMIT 1', abs($row['ExtendedCost']));
					if($extcost['reqhonorpoints']>0)
						$npc['sells'][$numRow]['cost']['honor'] = (($npc['A']==1)? 1: -1) * $extcost['reqhonorpoints'];
					if($extcost['reqarenapoints']>0)
						$npc['sells'][$numRow]['cost']['arena'] = $extcost['reqarenapoints'];
					$npc['sells'][$numRow]['cost']['items'] = array();
					for($j=1;$j<=5;$j++)
						if(($extcost['reqitem'.$j]>0) and ($extcost['reqitemcount'.$j]>0))
						{
							allitemsinfo($extcost['reqitem'.$j], 0);
							$npc['sells'][$numRow]['cost']['items'][] = array('item' => $extcost['reqitem'.$j], 'count' => $extcost['reqitemcount'.$j]);
						}
				}
				if($row['BuyPrice']>0)
					$npc['sells'][$numRow]['cost']['money'] = $row['BuyPrice'];
			}
			unset ($row);
			unset ($numRow);
			unset ($extcost);
		}
		unset ($rows_s);

		// Дроп
		if(!($npc['drop'] = loot('creature_loot_template', $lootid)))
			unset ($npc['drop']);

		// Кожа
		if(!($npc['skinning'] = loot('skinning_loot_template', $skinid)))
			unset ($npc['skinning']);

		// Воруеццо
		if(!($npc['pickpocketing'] = loot('pickpocketing_loot_template', $pickpocketid)))
			unset ($npc['pickpocketing']);

		// Начинают квесты...
		$rows_qs = $DB->select('
			SELECT ?#
			FROM creature_questrelation c, quest_template q
			WHERE
				c.id=?
				AND q.entry=c.quest
			',
			$quest_cols[2],
			$id
		);
		if($rows_qs)
		{
			$npc['starts'] = array();
			foreach($rows_qs as $numRow=>$row) {
				$npc['starts'][] = GetQuestInfo($row, 0xFFFFFF);
			}
		}
		unset ($rows_qs);

		// Начинают event-only квесты...
		$rows_qse = event_find(array('quest_creature_id' => $id));
		if($rows_qse)
		{
			if (!isset($npc['starts']))
				$npc['starts'] = array();
			foreach($rows_qse as $event)
				foreach($event['creatures_quests_id'] as $ids)
					$npc['starts'][] = GetDBQuestInfo($ids['quest'], 0xFFFFFF);
		}
		unset ($rows_qse);

		// Заканчивают квесты...
		$rows_qe = $DB->select('
			SELECT ?#
			FROM creature_involvedrelation c, quest_template q
			WHERE
				c.id=?
				AND q.entry=c.quest
			',
			$quest_cols[2],
			$id
		);
		if($rows_qe)
		{
			$npc['ends'] = array();
			foreach($rows_qe as $numRow=>$row) {
				$npc['ends'][] = GetQuestInfo($row, 0xFFFFFF);
			}
		}
		unset ($rows_qe);

		// Необходимы для квеста..
		$rows_qo = $DB->select('
			SELECT ?#
			FROM quest_template
			WHERE
				ReqCreatureOrGOId1=?
				OR ReqCreatureOrGOId2=?
				OR ReqCreatureOrGOId3=?
				OR ReqCreatureOrGOId4=?
			',
			$quest_cols[2],
			$id, $id, $id, $id
		);
		if($rows_qo)
		{
			$npc['objectiveof'] = array();
			foreach($rows_qo as $numRow=>$row)
				$npc['objectiveof'][] = GetQuestInfo($row, 0xFFFFFF);
		}
		unset ($rows_qo);

		// Цель критерии
		$rows = $DB->select('
				SELECT a.id, a.faction, a.name_loc?d AS name, a.description_loc?d AS description, a.category, a.points, s.iconname, z.areatableID
				FROM ?_spellicons s, ?_achievementcriteria c, ?_achievement a
				LEFT JOIN (?_zones z) ON a.map != -1 AND a.map = z.mapID
				WHERE
					a.icon = s.id
					AND a.id = c.refAchievement
					AND c.type IN (?a)
					AND c.value1 = ?d
				GROUP BY a.id
				ORDER BY a.name_loc?d
			',
			$_SESSION['locale'],
			$_SESSION['locale'],
			array(ACHIEVEMENT_CRITERIA_TYPE_KILL_CREATURE),
			$npc['entry'],
			$_SESSION['locale']
		);
		if($rows)
		{
			$npc['criteria_of'] = array();
			foreach($rows as $row)
			{
				allachievementsinfo2($row['id']);
				$npc['criteria_of'][] = achievementinfo2($row);
			}
		}

		// Репутация за убийство
		$row = $DB->selectRow('
			SELECT RewOnKillRepFaction1, RewOnKillRepValue1, MaxStanding1, RewOnKillRepFaction2, RewOnKillRepValue2, MaxStanding2
			FROM creature_onkill_reputation
			WHERE creature_id=?d',
			$npc['entry']
		);
		if ($row)
		{
			$replevel = array(LOCALE_HATED, LOCALE_HOSTILE, LOCALE_UNFRIENDLY, LOCALE_NEUTRAL,
							  LOCALE_FRIENDLY, LOCALE_HONORED, LOCALE_REVERED, LOCALE_EXALTED);
			for ($i=1; $i<=2; $i++)
				if ($row['RewOnKillRepValue'.$i])
				{
					$npc['kill_rep_value'.$i] = $row['RewOnKillRepValue'.$i];
					$npc['kill_rep_faction'.$i] = $DB->selectCell(
						'SELECT name_loc'.$_SESSION['locale'].' FROM ?_factions WHERE factionID=?d',
						$row['RewOnKillRepFaction'.$i]
					);
					$u = $row['MaxStanding'.$i];
					$npc['kill_rep_until'.$i] = isset($replevel[$u]) ? $replevel[$u] : $u;
				}
		}

		// Положения созданий божих (для героик НПС не задана карта, юзаем из нормала):
		if($normal_entry)
			// мы - героик НПС, определяем позицию по нормалу
			$npc['position'] = position($normal_entry, 'creature', 2);
		else
			// мы - нормал НПС или НПС без сложности
			$npc['position'] = position($npc['entry'], 'creature', 1);

		// Исправить type, чтобы подсвечивались event-овые NPC
		if ($npc['position'])
			foreach ($npc['position'] as $z => $zone)
				foreach ($zone['points'] as $p => $pos)
					if ($pos['type'] == 0 && ($events = event_find(array('creature_guid' => $pos['guid']))))
					{
						$names = array_select_key(event_name($events), 'name');
						$npc['position'][$z]['points'][$p]['type'] = 4;
						$npc['position'][$z]['points'][$p]['events'] = implode(", ", $names);
					}

		save_cache(NPC_PAGE, $cache_key, $npc);
	}
}

global $page;
$page = array(
	'Mapper' => true,
	'Book' => false,
	'Title' => $npc['name'].' - '.$smarty->get_config_vars('NPCs'),
	'tab' => 0,
	'type' => 1,
	'typeid' => $npc['entry'],
	'path' => path(0, 4, $npc['type']),
	'comment' => true
);

// Комментарии
if($AoWoWconf['disable_comments'])
	$page['comment'] = false;
else
	$smarty->assign('comments', getcomments($page['type'], $page['typeid']));
$smarty->assign('page', $page);

$smarty->assign('npc', $npc);

// Количество MySQL запросов
$smarty->assign('mysql', $DB->getStatistics());

// Запускаем шаблонизатор
$smarty->display('npc.tpl');

?>