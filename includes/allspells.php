<?php

require_once('includes/allitems.php');

define('SPELL_MAX_DISTANCE', 50000);

// Названия аур
$spell_aura_names = array(
	0 => 'None',
	1 => 'Bind Sight',
	2 => 'Mod Possess',
	3 => 'Periodic Damage',
	4 => 'Dummy',
	5 => 'Mod Confuse',
	6 => 'Mod Charm',
	7 => 'Mod Fear',
	8 => 'Periodic Heal',
	9 => 'Mod Attack Speed',
	10 => 'Mod Threat',
	11 => 'Mod Taunt',
	12 => 'Mod Stun',
	13 => 'Mod Damage Done',
	14 => 'Mod Damage Taken',
	15 => 'Damage Shield',
	16 => 'Mod Stealth',
	17 => 'Mod Stealth Detect',
	18 => 'Mod Invisibility',
	19 => 'Mod Invisibility Detect',
	20 => 'OBS Mod Health',
	21 => 'OBS Mod Power',
	22 => 'Mod Resistance',
	23 => 'Periodic Trigger Spell',
	24 => 'Periodic Energize',
	25 => 'Mod Pacify',
	26 => 'Mod Root',
	27 => 'Mod Silence',
	28 => 'Reflect Spells %',
	29 => 'Mod Stat',
	30 => 'Mod Skill',
	31 => 'Mod Increase Speed',
	32 => 'Mod Increase Mounted Speed',
	33 => 'Mod Decrease Speed',
	34 => 'Mod Increase Health',
	35 => 'Mod Increase Energy',
	36 => 'Mod Shapeshift',
	37 => 'Effect Immunity',
	38 => 'State Immunity',
	39 => 'School Immunity',
	40 => 'Damage Immunity',
	41 => 'Dispel Immunity',
	42 => 'Proc Trigger Spell',
	43 => 'Proc Trigger Damage',
	44 => 'Track Creatures',
	45 => 'Track Resources',
	46 => 'Mod Parry Skill',
	47 => 'Mod Parry %',
	48 => 'Mod Dodge Skill',
	49 => 'Mod Dodge %',
	50 => 'Mod Critical Healing Amount',
	51 => 'Mod Block %',
	52 => 'Mod Weapon Crit %',
	53 => 'Periodic Leech',
	54 => 'Mod Hit Chance',
	55 => 'Mod Spell Hit Chance',
	56 => 'Transform',
	57 => 'Mod Spell Crit Chance',
	58 => 'Mod Increase Swim Speed',
	59 => 'Mod Creature Damage Done',
	60 => 'Mod Pacify & Silence',
	61 => 'Mod Scale',
	62 => 'Periodic Health Funnel',
	63 => 'Periodic Mana Funnel',
	64 => 'Periodic Mana Leech',
	65 => 'Mod Casting Speed Not Stack',
	66 => 'Feign Death',
	67 => 'Mod Disarm',
	68 => 'Mod Stalked',
	69 => 'School Absorb',
	70 => 'Extra Attacks',
	71 => 'Mod School Spell Crit Chance',
	72 => 'Mod School Power Cost %',
	73 => 'Mod School Power Cost',
	74 => 'Reflect School Spells',
	75 => 'Mod Language',
	76 => 'Far Sight',
	77 => 'Mechanic Immunity',
	78 => 'Mounted',
	79 => 'Mod Damage %',
	80 => 'Mod Stat %',
	81 => 'Split Damage %',
	82 => 'Water Breathing',
	83 => 'Mod Base Resistance',
	84 => 'Mod Health Regen',
	85 => 'Mod Power Regen',
	86 => 'Channel Death Item',
	87 => 'Mod Damage % Taken',
	88 => 'Mod Health Regen %',
	89 => 'Periodic Damage %',
	90 => 'Mod Resist Chance',
	91 => 'Mod Detect Range',
	92 => 'Prevents Fleeing',
	93 => 'Mod Unattackable',
	94 => 'Interrupt Regen',
	95 => 'Ghost',
	96 => 'Spell Magnet',
	97 => 'Mana Shield',
	98 => 'Mod Skill Talent',
	99 => 'Mod Attack Power',
	100 => 'Auras Visible',
	101 => 'Mod Resistance %',
	102 => 'Mod Creature Attack Power',
	103 => 'Mod Total Threat (Fade)',
	104 => 'Water Walk',
	105 => 'Feather Fall',
	106 => 'Hover',
	107 => 'Add Flat Modifier',
	108 => 'Add % Modifier',
	109 => 'Add Class Target Trigger',
	110 => 'Mod Power Regen %',
	111 => 'Add Class Caster Hit Trigger',
	112 => 'Override Class Scripts',
	113 => 'Mod Ranged Damage Taken',
	114 => 'Mod Ranged % Damage Taken',
	115 => 'Mod Healing',
	116 => 'Mod Regen During Combat',
	117 => 'Mod Mechanic Resistance',
	118 => 'Mod Healing %',
	119 => 'Share Pet Tracking',
	120 => 'Untrackable',
	121 => 'Empathy (Lore, whatever)',
	122 => 'Mod Offhand Damage %',
	123 => 'Mod Target Resistance',
	124 => 'Mod Ranged Attack Power',
	125 => 'Mod Melee Damage Taken',
	126 => 'Mod Melee % Damage Taken',
	127 => 'Ranged Attack Power Attacker Bonus',
	128 => 'Mod Possess Pet',
	129 => 'Mod Speed Always',
	130 => 'Mod Mounted Speed Always',
	131 => 'Mod Creature Ranged Attack Power',
	132 => 'Mod Increase Energy %',
	133 => 'Mod Increase Health %',
	134 => 'Mod Mana Regen Interrupt',
	135 => 'Mod Healing Done',
	136 => 'Mod Healing Done %',
	137 => 'Mod Total Stat %',
	138 => 'Mod Melee Haste',
	139 => 'Force Reaction',
	140 => 'Mod Ranged Haste',
	141 => 'Mod Ranged Ammo Haste',
	142 => 'Mod Base Resistance %',
	143 => 'Mod Resistance Exclusive',
	144 => 'Safe Fall',
	145 => 'Mod Pet Talent Points',
	146 => 'Allow Tame Pet Type',
	147 => 'Mechanic Immunity Mask',
	148 => 'Retain Combo Points',
	149 => 'Reduce Pushback',
	150 => 'Mod Shield Blockvalue %',
	151 => 'Track Stealthed',
	152 => 'Mod Detected Range',
	153 => 'Split Damage Flat',
	154 => 'Mod Stealth Level',
	155 => 'Mod Water Breathing',
	156 => 'Mod Reputation Gain',
	157 => 'Pet Damage Multi',
	158 => 'Mod Shield Blockvalue',
	159 => 'No Pvp Credit',
	160 => 'Mod Aoe Avoidance',
	161 => 'Mod Health Regen In Combat',
	162 => 'Power Burn',
	163 => 'Mod Crit Damage Bonus',
	165 => 'Melee Attack Power Attacker Bonus',
	166 => 'Mod Attack Power %',
	167 => 'Mod Ranged Attack Power %',
	168 => 'Mod Creature Damage Done',
	169 => 'Mod Creature Crit %',
	170 => 'Detect Amore',
	171 => 'Mod Speed Not Stack',
	172 => 'Mod Mounted Speed Not Stack',
	174 => 'Mod Spell Damage Of Stat %',
	175 => 'Mod Spell Healing Of Stat %',
	176 => 'Spirit Of Redemption',
	177 => 'Aoe Charm',
	178 => 'Mod Debuff Resistance',
	179 => 'Mod Attacker Spell Crit Chance',
	180 => 'Mod Creature Flat Spell Damage',
	182 => 'Mod Resistance Of Stat %',
	183 => 'Mod Critical Threat',
	184 => 'Mod Attacker Melee Hit Chance',
	185 => 'Mod Attacker Ranged Hit Chance',
	186 => 'Mod Attacker Spell Hit Chance',
	187 => 'Mod Attacker Melee Crit Chance',
	188 => 'Mod Attacker Ranged Crit Chance',
	189 => 'Mod Rating',
	190 => 'Mod Faction Reputation Gain',
	191 => 'Use Normal Movement Speed',
	192 => 'Mod Melee Ranged Haste',
	193 => 'Melee Slow',
	194 => 'Mod Target Absorb School',
	195 => 'Mod Target Ability Absorb School',
	196 => 'Mod Cooldown',
	197 => 'Mod Attacker Spell And Weapon Crit Chance',
	199 => 'Mod Increases Spell Hit %',
	200 => 'Mod Xp %',
	201 => 'Fly',
	202 => 'Ignore Combat Result',
	203 => 'Mod Attacker Melee Crit Damage',
	204 => 'Mod Attacker Ranged Crit Damage',
	205 => 'Mod School Crit Damage Taken',
	206 => 'Mod Increase Vehicle Flight Speed',
	207 => 'Mod Increase Mounted Flight Speed',
	208 => 'Mod Increase Flight Speed',
	209 => 'Mod Mounted Flight Speed Always',
	210 => 'Mod Vehicle Speed Always',
	211 => 'Mod Flight Speed Not Stack',
	212 => 'Mod Ranged Attack Power Of Stat %',
	213 => 'Mod Rage From Damage Dealt',
	215 => 'Arena Preparation',
	216 => 'Haste Spells',
	217 => 'Mod Melee Haste 2',
	218 => 'Haste Ranged',
	219 => 'Mod Mana Regen From Stat',
	220 => 'Mod Rating From Stat',
	221 => 'Mod Detaunt',
	223 => 'Raid Proc From Charge',
	225 => 'Raid Proc From Charge With Value',
	226 => 'Periodic Dummy',
	227 => 'Periodic Trigger Spell With Value',
	228 => 'Detect Stealth',
	229 => 'Mod Aoe Damage Avoidance',
	231 => 'Proc Trigger Spell With Value',
	232 => 'Mechanic Duration Mod',
	233 => 'Change Model For All Humanoids',
	234 => 'Mechanic Duration Mod Not Stack',
	235 => 'Mod Dispel Resist',
	236 => 'Control Vehicle',
	237 => 'Mod Spell Damage Of Attack Power',
	238 => 'Mod Spell Healing Of Attack Power',
	239 => 'Mod Scale 2',
	240 => 'Mod Expertise',
	241 => 'Force Move Forward',
	242 => 'Mod Spell Damage From Healing',
	243 => 'Mod Faction',
	244 => 'Comprehend Language',
	245 => 'Mod Aura Duration By Dispel',
	246 => 'Mod Aura Duration By Dispel Not Stack',
	247 => 'Clone Caster',
	248 => 'Mod Combat Result Chance',
	249 => 'Convert Rune',
	250 => 'Mod Increase Health 2',
	251 => 'Mod Enemy Dodge',
	252 => 'Mod Speed Slow All',
	253 => 'Mod Block Crit Chance',
	254 => 'Mod Disarm Offhand',
	255 => 'Mod Mechanic Damage Taken %',
	256 => 'No Reagent Use',
	257 => 'Mod Target Resist By Spell Class',
	259 => 'Mod Hot %',
	260 => 'Screen Effect',
	261 => 'Phase',
	262 => 'Ability Ignore Aurastate',
	263 => 'Allow Only Ability',
	267 => 'Mod Immune Aura Apply School',
	268 => 'Mod Attack Power Of Stat %',
	269 => 'Mod Ignore Target Resist',
	270 => 'Mod Ability Ignore Target Resist',
	271 => 'Mod Damage From Caster',
	272 => 'Ignore Melee Reset',
	273 => 'X Ray',
	274 => 'Ability Consume No Ammo',
	275 => 'Mod Ignore Shapeshift',
	276 => 'Mod Damage Done For Mechanic',
	277 => 'Mod Max Affected Targets',
	278 => 'Mod Disarm Ranged',
	279 => 'Initialize Images',
	280 => 'Mod Armor Penetration %',
	281 => 'Mod Honor Gain %',
	282 => 'Mod Base Health %',
	283 => 'Mod Healing Received',
	284 => 'Linked',
	285 => 'Mod Attack Power Of Armor',
	286 => 'Ability Periodic Crit',
	287 => 'Deflect Spells',
	288 => 'Ignore Hit Direction',
	290 => 'Mod Crit %',
	291 => 'Mod Xp Quest %',
	292 => 'Open Stable',
	293 => 'Override Spells',
	294 => 'Prevent Regenerate Power',
	296 => 'Set Vehicle Id',
	297 => 'Block Spell Family',
	298 => 'Strangulate',
	300 => 'Share Damage %',
	301 => 'School Heal Absorb',
	303 => 'Mod Creature Damage Done Aurastate',
	304 => 'Mod Fake Inebriate',
	305 => 'Mod Minimum Speed',
	307 => 'Heal Absorb Test',
	308 => 'Mod Crit Chance For Caster',
	310 => 'Mod Creature Aoe Damage Avoidance',
	314 => 'Prevent Resurrection',
	315 => 'Underwater Walking',
	316 => 'Periodic Haste'
);

// Названия эффектов спеллов
$spell_effect_names = array(
	0 => 'None',
	1 => 'Instakill',
	2 => 'School Damage',
	3 => 'Dummy',
	4 => 'Portal Teleport',
	5 => 'Teleport Units',
	6 => 'Apply Aura',
	7 => 'Environmental Damage',
	8 => 'Power Drain',
	9 => 'Health Leech',
	10 => 'Heal',
	11 => 'Bind',
	12 => 'Portal',
	13 => 'Ritual Base',
	14 => 'Ritual Specialize',
	15 => 'Ritual Activate Portal',
	16 => 'Quest Complete',
	17 => 'Weapon Damage + Noschool',
	18 => 'Resurrect',
	19 => 'Add Extra Attacks',
	20 => 'Dodge',
	21 => 'Evade',
	22 => 'Parry',
	23 => 'Block',
	24 => 'Create Item',
	25 => 'Weapon',
	26 => 'Defense',
	27 => 'Persistent Area Aura',
	28 => 'Summon',
	29 => 'Leap',
	30 => 'Energize',
	31 => 'Weapon % Damage',
	32 => 'Trigger Missile',
	33 => 'Open Lock',
	34 => 'Summon Change Item',
	35 => 'Apply Area Aura Party',
	36 => 'Learn Spell',
	37 => 'Spell Defense',
	38 => 'Dispel',
	39 => 'Language',
	40 => 'Dual Wield',
	41 => 'Jump',
	42 => 'Jump Dest',
	43 => 'Teleport Units Face Caster',
	44 => 'Skill Step',
	45 => 'Add Honor',
	46 => 'Spawn',
	47 => 'Trade Skill',
	48 => 'Stealth',
	49 => 'Detect',
	50 => 'Summon Object',
	51 => 'Force Critical Hit',
	52 => 'Guarantee Hit',
	53 => 'Enchant Item Permanent',
	54 => 'Enchant Item Temporary',
	55 => 'Tame Creature',
	56 => 'Summon Pet',
	57 => 'Learn Pet Spell',
	58 => 'Weapon Damage',
	59 => 'Create Random Item',
	60 => 'Proficiency',
	61 => 'Send Event',
	62 => 'Power Burn',
	63 => 'Threat',
	64 => 'Trigger Spell',
	65 => 'Apply Area Aura Raid',
	66 => 'Create Mana Gem',
	67 => 'Heal Max Health',
	68 => 'Interrupt Cast',
	69 => 'Distract',
	70 => 'Pull',
	71 => 'Pickpocket',
	72 => 'Add Farsight',
	73 => 'Untrain Talents',
	74 => 'Apply Glyph',
	75 => 'Heal Mechanical',
	76 => 'Summon Object Wild',
	77 => 'Script Effect',
	78 => 'Attack',
	79 => 'Sanctuary',
	80 => 'Add Combo Points',
	81 => 'Create House',
	82 => 'Bind Sight',
	83 => 'Duel',
	84 => 'Stuck',
	85 => 'Summon Player',
	86 => 'Activate Object',
	87 => 'Gameobject Damage',
	88 => 'Gameobject Repair',
	89 => 'Gameobject Set Destruction State',
	90 => 'Kill Credit',
	91 => 'Threat All',
	92 => 'Enchant Held Item',
	93 => 'Force Deselect',
	94 => 'Self Resurrect',
	95 => 'Skinning',
	96 => 'Charge',
	97 => 'Cast Button',
	98 => 'Knock Back',
	99 => 'Disenchant',
	100 => 'Inebriate',
	101 => 'Feed Pet',
	102 => 'Dismiss Pet',
	103 => 'Reputation',
	104 => 'Summon Object Slot1',
	105 => 'Summon Object Slot2',
	106 => 'Summon Object Slot3',
	107 => 'Summon Object Slot4',
	108 => 'Dispel Mechanic',
	109 => 'Summon Dead Pet',
	110 => 'Destroy All Totems',
	111 => 'Durability Damage',
	112 => 'Summon Demon',
	113 => 'Resurrect New',
	114 => 'Taunt',
	115 => 'Durability Damage %',
	116 => 'Remove Insignia',
	117 => 'Spirit Heal',
	118 => 'Skill',
	119 => 'Apply Area Aura Pet',
	120 => 'Teleport Graveyard',
	121 => 'Normalized Weapon Damage',
	123 => 'Send Taxi',
	124 => 'Pull Towards',
	125 => 'Modify Threat %',
	126 => 'Steal Beneficial Buff',
	127 => 'Prospecting',
	128 => 'Apply Area Aura Friend',
	129 => 'Apply Area Aura Enemy',
	130 => 'Redirect Threat',
	132 => 'Play Music',
	133 => 'Unlearn Specialization',
	134 => 'Kill Credit2',
	135 => 'Call Pet',
	136 => 'Heal %',
	137 => 'Energize %',
	138 => 'Leap Back',
	139 => 'Clear Quest',
	140 => 'Force Cast',
	141 => 'Force Cast With Value',
	142 => 'Trigger Spell With Value',
	143 => 'Apply Area Aura Owner',
	144 => 'Knock Back Dest',
	145 => 'Pull Towards Dest',
	146 => 'Activate Rune',
	147 => 'Quest Fail',
	148 => 'Trigger Missile Spell With Value',
	149 => 'Charge Dest',
	150 => 'Quest Start',
	151 => 'Trigger Spell 2',
	152 => 'Summon Raf Friend',
	153 => 'Create Tamed Pet',
	154 => 'Discover Taxi',
	155 => 'Titan Grip',
	156 => 'Enchant Item Prismatic',
	157 => 'Create Item 2',
	158 => 'Milling',
	159 => 'Allow Rename Pet',
	161 => 'Talent Spec Count',
	162 => 'Talent Spec Select',
	164 => 'Remove Aura'
);

$pet_skill_categories = array(
270, 653, 210, 655, 211, 213, 209, 780, 787, 214, 212, 781, 763, 215, 654, 775, 764, 217, 767, 786, 236, 768, 783, 203, 788, 765, 218, 251, 766, 785, 656, 208, 784, 761, 189, 188, 205, 204, 782
);

$spell_cols[0] = array('spellID', 'iconname', 'effect1itemtype', 'effect1Aura', 'spellname_loc'.$_SESSION['locale']);
$spell_cols[1] = array('spellID', 'iconname', 'tooltip_loc'.$_SESSION['locale'], 'spellname_loc'.$_SESSION['locale'], 'rank_loc'.$_SESSION['locale'],  'rangeID', 'manacost', 'manacostpercent', 'spellcasttimesID', 'cooldown', 'categoryCooldown', 'tool1', 'tool2', 'reagent1', 'reagent2', 'reagent3', 'reagent4', 'reagent5', 'reagent6', 'reagent7', 'reagent8', 'effect1BasePoints', 'effect2BasePoints', 'effect3BasePoints', 'effect1Amplitude', 'effect2Amplitude', 'effect3Amplitude', 'effect1DieSides', 'effect2DieSides', 'effect3DieSides', 'effect1ChainTarget', 'effect2ChainTarget', 'effect3ChainTarget', 'reagentcount1', 'reagentcount2', 'reagentcount3', 'reagentcount4', 'reagentcount5', 'reagentcount6', 'reagentcount7', 'reagentcount8', 'effect1radius', 'effect2radius', 'effect3radius', 'effect1MiscValue', 'effect2MiscValue', 'effect3MiscValue', 'ChannelInterruptFlags', 'procChance', 'procCharges', 'effect_1_proc_chance', 'effect_2_proc_chance', 'effect_3_proc_chance', 'effect1itemtype', 'effect1Aura', 'spellTargets', 'dmg_multiplier1', 'durationID');
$spell_cols[2] = array('spellname_loc'.$_SESSION['locale'], 'rank_loc'.$_SESSION['locale'], 'levelspell', 'schoolMask', 'effect1itemtype', 'effect2itemtype', 'effect3itemtype', 'effect1BasePoints', 'effect2BasePoints', 'effect3BasePoints', 'reagent1', 'reagent2', 'reagent3', 'reagent4', 'reagent5', 'reagent6', 'reagent7', 'reagent8', 'reagentcount1', 'reagentcount2', 'reagentcount3', 'reagentcount4', 'reagentcount5', 'reagentcount6', 'reagentcount7', 'reagentcount8', 'iconname', 'effect1Aura', 'effect2Aura', 'effect3Aura');

function spell_schoolmask($schoolMask)
{
	$result = array();
	if ($schoolMask & 1) $result[] = LOCALE_SCHOOL_MASK_PHYSICAL;
	if ($schoolMask & 2) $result[] = LOCALE_SCHOOL_MASK_HOLY;
	if ($schoolMask & 4) $result[] = LOCALE_SCHOOL_MASK_FIRE;
	if ($schoolMask & 8) $result[] = LOCALE_SCHOOL_MASK_NATURE;
	if ($schoolMask & 16) $result[] = LOCALE_SCHOOL_MASK_FROST;
	if ($schoolMask & 32) $result[] = LOCALE_SCHOOL_MASK_SHADOW;
	if ($schoolMask & 64) $result[] = LOCALE_SCHOOL_MASK_ARCANE;
	return implode(", ", $result);
}

function spell_desc($spellid, $type='tooltip')
{
	global $DB;
	global $spell_cols;
	// Не включать spellduration сюда!!! Не у всех спеллов он установлен корректно.
	$spellRow = $DB->selectRow('
			SELECT ?#
			FROM ?_spell s, ?_spellicons
			WHERE
				spellID = ?
				AND id = spellicon
			LIMIT 1
		',
		$spell_cols[1],
		$spellid
	);
	return spell_desc2($spellRow, $type);
}

function spell_desc2($spellRow, $type='tooltip')
{
	global $DB;

	allspellsinfo2($spellRow);

	if(isset($spellRow['durationBase']))
		$lastduration = array('durationBase' => $spellRow['durationBase']);
	else
		$lastduration = $DB->selectRow('SELECT * FROM ?_spellduration WHERE durationID = ? LIMIT 1', $spellRow['durationID']);

	$signs = array('+', '-', '/', '*', '%', '^');

	$data = $spellRow[$type.'_loc'.$_SESSION['locale']];

	// Конец строк
	$data = strtr($data, array("\r" => '', "\n" => '<br />'));
	// Цвета
	$data = preg_replace('/\|cff([a-f0-9]{6})(.+?)\|r/i', '<span style="color: #$1;">$2</span>', $data);

	$pos = 0;
	$str = '';
	$replace = true;
	while(false!==($npos=strpos($data, '$', $pos)))
	{
		if($npos!=$pos)
			$str .= substr($data, $pos, $npos-$pos);
		$pos = $npos+1;

		if('$' == substr($data, $pos, 1))
		{
			$str .= '$';
			$pos++;
			continue;
		}

		if(!preg_match('/^(((([+\-\/*])(\d+);)?(\d*)(?:([lgLG].*?:.*?);|(\w\d*)))|(\<([^\>]+)\>)|(\w{2,}))/', substr($data, $pos), $result))
			continue;

		$op = $result[4];
		$oparg = $result[5];
		$lookup = $result[6];
		$var = $result[7] ? $result[7] : $result[8];
		if($result[9])
		{
			$str .= $result[10];
			$replace = false;
		}
		elseif($result[11])
		{
			$str .= $result[11];
			$replace = false;
		}
		$pos += strlen($result[0]);

		if(!$var)
			continue;

		if(ctype_upper(substr($var, 0, 1))) // only case 'M' from uppercase is implemented
			$exprUpperCase = true;
		else
			$exprUpperCase = false;
		$exprType = strtolower(substr($var, 0, 1));
		$exprData = explode(':', substr($var, 1));
		if(empty($exprData[0]))
			$exprData[0] = 1;
		switch($exprType)
		{
			case 'r':
				if(!IsSet($spellRow['rangeMax']))
					$spellRow = array_merge($spellRow, $DB->selectRow('SELECT * FROM ?_spellrange WHERE rangeID=? LIMIT 1', $spellRow['rangeID']));

				$base = $spellRow['rangeMax'];

				if($op && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= $base;
				$lastvalue = $base;
				break;
			case 'z':
				$str .= htmlspecialchars('<Home>');
				break;
			case 'c':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT effect'.$exprData[0].'BasePoints FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['effect'.$exprData[0].'BasePoints']+1;

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}

				$str .= $base;
				$lastvalue = $base;
				break;
			case 's':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT effect'.$exprData[0].'BasePoints, effect'.$exprData[0].'DieSides FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['effect'.$exprData[0].'BasePoints']+1;

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				
				if($base == $base-1+$spell['effect'.$exprData[0].'DieSides'])
				{
					$str .= abs($base);
					$lastvalue = abs($base);
				}
				else
				{
					$str .= '<NOBR>'.abs($base).LOCALE_VALUE_DELIM.abs($base-1+$spell['effect'.$exprData[0].'DieSides']).'</NOBR>';
					$lastvalue = abs($base-1+$spell['effect'.$exprData[0].'DieSides']);
				}
				break;
			case 'o':
				if($lookup > 0 && $exprData[0])
				{
					$spell = $DB->selectRow('SELECT durationID, effect'.$exprData[0].'BasePoints, effect'.$exprData[0].'Amplitude, effect'.$exprData[0].'DieSides FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
					$lastduration = $DB->selectRow('SELECT * FROM ?_spellduration WHERE durationID=? LIMIT 1', $spell['durationID']);
				}
				else
					$spell = $spellRow;

				$base = $spell['effect'.$exprData[0].'BasePoints']+1;
				if($spell['effect'.$exprData[0].'Amplitude'] <= 0)
					$spell['effect'.$exprData[0].'Amplitude'] = 5000;
				$factor = $lastduration['durationBase'] / $spell['effect'.$exprData[0].'Amplitude'];
				
				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				
				if($base == $base-1+$spell['effect'.$exprData[0].'DieSides'])
				{
					$str .= $factor * abs($base);
					$lastvalue = $factor * abs($base);
				}
				else
				{
					$str .= '<NOBR>'.$factor * abs($base).' - '.$factor * abs($base-1+$spell['effect'.$exprData[0].'DieSides']).'</NOBR>';
					$lastvalue = $factor * abs($base-1+$spell['effect'.$exprData[0].'DieSides']);
				}
				break;
			case 't':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT * FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['effect'.$exprData[0].'Amplitude']/1000;

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				$lastvalue = $base;
				break;
			case 'm':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT effect'.$exprData[0].'BasePoints, effect'.$exprData[0].'DieSides FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;
					
				if($exprUpperCase)
					$base = $spell['effect'.$exprData[0].'BasePoints']+($spell['effect'.$exprData[0].'DieSides']>0 ? $spell['effect'.$exprData[0].'DieSides'] : 1);
				else
					$base = $spell['effect'.$exprData[0].'BasePoints']+1;

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = round($equation, 1);");
				}
				$str .= abs($base);
				$lastvalue = $base;
				break;
			case 'x':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT effect'.$exprData[0].'ChainTarget FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['effect'.$exprData[0].'ChainTarget'];

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				$lastvalue = $base;
				break;
			case 'q':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT effect'.$exprData[0].'MiscValue FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['effect'.$exprData[0].'MiscValue'];

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				$lastvalue = $base;
				break;
			case 'a':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT effect1radius, effect2radius, effect3radius FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$radius = $DB->selectCell('SELECT radiusBase FROM ?_spellradius WHERE radiusID=? LIMIT 1', $spell['effect'.$exprData[0].'radius']);
				$base = $radius;

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				break;
			case 'h':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT procChance FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['procChance'];

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				break;
			case 'f':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT dmg_multiplier'.$exprData[0].' FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['dmg_multiplier'.$exprData[0]];

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				break;
			case 'n':
				if($lookup > 0)
					$spell = $DB->selectRow('SELECT procCharges FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;

				$base = $spell['procCharges'];

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				break;
			case 'd':
				if($lookup > 0)
				{
					$spell = $DB->selectRow('SELECT durationBase FROM ?_spell a, ?_spellduration b WHERE a.durationID = b.durationID AND a.spellID=? LIMIT 1', $lookup);
					if(isset($spell['durationBase']))
						$base = ($spell['durationBase'] > 0) ? $spell['durationBase']+1 : 0;
					else
						unset($base);
				}
				elseif(isset($lastduration['durationBase']))
					$base = ($lastduration['durationBase'] > 0) ? $lastduration['durationBase']+1 : 0;
				else
					unset($base);

				if($op && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				if(!isset($base))
					$str .= '<span class="err">broken spell</span>';
				if('.' == substr($data, $pos, 1))
					$str .= sec_to_time(round($base/1000));
				elseif(($base > 0) and ($base < 60000))
				{
					$str .= round($base/1000);
					$lastvalue = round($base/1000);
				}
				elseif(($base >= 60000) and ($base < 3600000))
				{
					$str .= round($base/60000);
					$lastvalue = round($base/60000);
				}
				break;
			case 'i':
				$base = $spellRow['spellTargets'];

				if($op && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= $base;
				break;
			case 'e':
				if($lookup > 0 && $exprData[0])
					$spell = $DB->selectRow('SELECT effect_'.$exprData[0].'_proc_value FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;
				
				$base = $spell['effect_'.$exprData[0].'_proc_value'];

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= $base;
				$lastvalue = $base;
				break;
			case 'v':
				$base = $spell['affected_target_level'];

				if($op && $oparg > 0 && $base > 0)
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= $base;
				break; 
			case 'u':
				if($lookup > 0)
					$spell = $DB->selectRow('SELECT stack FROM ?_spell WHERE spellID=?d LIMIT 1', $lookup);
				else
					$spell = $spellRow;
					
				$base = $spell['stack'];

				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				$lastvalue = $base;
				break;
			case 'b': // only used at one spell (14179) should be 20, column 110/111/112?)
				if($lookup > 0)
					$spell = $DB->selectRow('SELECT effect_'.$exprData[0].'_proc_chance FROM ?_spell WHERE spellID=? LIMIT 1', $lookup);
				else
					$spell = $spellRow;
				
				$base = $spell['effect_'.$exprData[0].'_proc_chance'];
				 
				if(in_array($op, $signs) && is_numeric($oparg) && is_numeric($base))
				{
					$equation = $base.$op.$oparg;
					eval("\$base = $equation;");
				}
				$str .= abs($base);
				$lastvalue = $base;
				break;
			case 'l':
				if(isset($exprData[2]))
				{
					$tmp = $lastvalue;
					while($tmp >= 10)
						$tmp = $tmp % 10;
					if($tmp == 1)
						$str .= $exprData[0];
					elseif($tmp > 1 && $tmp < 5)
						$str .= $exprData[1];
					else
						$str .= $exprData[2];
				}
				else
				{
					if($lastvalue > 1)
						$str .= $exprData[1];
					else
						$str .= $exprData[0];
				}
				break;
			case 'g':
				$str .= $exprData[0].'/'.$exprData[1];
				break;
			default:
				$str .= "[{$var} ($op::$oparg::$lookup::$exprData[0])]";
		}
	}
	$str .= substr($data, $pos);
	
	if($replace)
		$str = @preg_replace_callback("|\{([^\}]+)\}(\.([1-2]{1}))*|", "spellregexp", $str);
	else
		$str = preg_replace("|\{([^\}]+)\}(\.([1-2]{1}))*|", "$1", $str);
	
	return $str;
}

function spellregexp($matches)
{
	if(isset($matches[2]))
		return eval("return abs(round(".$matches[1].", ".$matches[3]."));");
	else
		return eval("return abs(".$matches[1].");");
}

function render_spell_tooltip(&$row)
{
	// БД
	global $DB;

	// Время каста
	if(($row['spellcasttimesID'] > 1) && ($row['spellcasttimesID'] != 18))
		$casttime = ($DB->selectCell('SELECT base FROM ?_spellcasttimes WHERE id=? LIMIT 1', $row['spellcasttimesID']))/1000;
	// Дальность действия
	$range = $DB->selectCell('SELECT rangeMax FROM ?_spellrange WHERE rangeID=? LIMIT 1', $row['rangeID']);

	// Реагенты
	$reagents = array();
	$i=0;
	for($j=1;$j<=8;$j++)
	{
		if($row['reagent'.$j] > 0)
		{
			$reagents[$i] = array();
			// Имя реагента
			$names = $DB->selectRow('
				SELECT name{, l.name_loc?d as `name_loc`}
				FROM item_template i
				{ LEFT JOIN (locales_item l) ON l.entry = i.entry AND ? }
				WHERE i.entry = ?d',
				($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
				($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
				$row['reagent'.$j]
			);
			$reagents[$i]['name'] = localizedName($names);
			// Количество реагентов
			// В количестве может быть значение -1, что с ним делать?
			$reagents[$i]['count'] = abs($row['reagentcount'.$j]);
			$i++;
		}
	}

	// Инструменты
	$tools = array();
	$i=0;
	for($j=1;$j<=2;$j++)
	{
		if($row['tool'.$j])
		{
			$tools[$i] = array();
			// Имя инструмента
			$names = $DB->selectRow('
				SELECT name{, l.name_loc?d as `name_loc`}
				FROM item_template i
				{ LEFT JOIN (locales_item l) ON l.entry = i.entry AND ? }
				WHERE i.entry = ?d',
				($_SESSION['locale']>0)? $_SESSION['locale']: DBSIMPLE_SKIP,
				($_SESSION['locale']>0)? 1: DBSIMPLE_SKIP,
				$row['tool'.$j]
			);
			$tools[$i]['name'] = localizedName($names);
			$i++;
		}
	}

	// До подсказка о спелле
	$desc = spell_desc2($row);

	$x = '';
	$x .= '<table><tr><td>';

	if($row['rank_loc'.$_SESSION['locale']])
		$x .= '<table width="100%"><tr><td>';

	$x .= '<b>'.$row['spellname_loc'.$_SESSION['locale']].'</b><br />';

	if($row['rank_loc'.$_SESSION['locale']])
		$x .= '</td><th><b class="q0">'.$row['rank_loc'.$_SESSION['locale']].'</b></th></tr></table>';

	if($range && ($row['manacost'] > 0 || $row['manacostpercent'] > 0))
		$x .= '<table width="100%"><tr><td>';

	if($row['manacost'] >0)
		$x .= LOCALE_MANA.': '.$row['manacost'].' <br />';

	if($row['manacostpercent']>0)
		$x .= $row['manacostpercent']."% ".LOCALE_BASE_MANA."<br />";

	if($range && (($row['manacost'] >0) || ($row['manacostpercent']>0)))
		$x .= '</td><th>';

	if($range == SPELL_MAX_DISTANCE)
		$x .= LOCALE_UNLIMITED_DISTANCE.'<br />';
	elseif($range)
		$x .= LOCALE_RANGE.': '.$range.' '.LOCALE_YARDS.'<br />';

	if($range && ($row['manacost'] > 0 || $row['manacostpercent'] > 0))
		$x .= '</th></tr></table>';

	if ($row['cooldown'] < $row['categoryCooldown'])
		$row['cooldown'] = $row['categoryCooldown'];

	if(($row['ChannelInterruptFlags'] || isset($casttime) || $row['spellcasttimesID']==1) && $row['cooldown'])
		$x .= '<table width="100%"><tr><td>';

	if($row['ChannelInterruptFlags'])
		$x .= LOCALE_CHANNELED.'<br />';
	if(isset($casttime))
	{
		if(($casttime > 0) and ($casttime < 60))
			$x.= LOCALE_CASTTIME.': '.($casttime).' '.LOCALE_SECONDS.'<br />';
		elseif(($casttime >= 60) and ($casttime < 3600))
			$x.= LOCALE_CASTTIME.': '.($casttime/60).' '.LOCALE_MINUTES.'<br />';
	}
	if(($row['spellcasttimesID'] == 1) || ($row['spellcasttimesID'] == 18))
		$x .= LOCALE_INSTANT_CAST.'<br />';

	if($row['procChance'] < 100.0)
		$x .= LOCALE_PROC_CHANCE.': '.$row['procChance'].'%<br />';

	if(($row['ChannelInterruptFlags'] || isset($casttime) || $row['spellcasttimesID'] == 1 || $row['spellcasttimesID'] == 18) && $row['cooldown'])
		$x .= '</td><th>';

	if($row['cooldown']>0)
		$x .= LOCALE_COOLDOWN.': '.sec_to_time($row['cooldown']/1000).'<br />';
	
	if(($row['ChannelInterruptFlags'] || isset($casttime) || $row['spellcasttimesID'] == 1 || $row['spellcasttimesID'] == 18) && $row['cooldown'])
		$x .= '</th></tr></table>';
	
	$x .= '</td></tr></table>';

	if($reagents)
	{
		$x .= '<table><tr><td>';
		$x .= LOCALE_REAGENTS;
		foreach($reagents as $i => $reagent)
		{
			$x .= $reagent['name'];
			if($reagent['count']>1)
				$x .= ' ('.$reagents[$i]['count'].')';
			if(!($i>=(count($reagents)-1)))
				$x .= ', ';
			else
				$x .= '<br>';
		}
		$x .= '</td></tr></table>';
	}

	if($tools)
	{
		$x .= '<table><tr><td>';
		$x .= LOCALE_TOOLS;
		foreach($tools as $i => $tool)
		{
			$x .= $tool['name'];
			if(!($i>=(count($tools)-1)))
				$x .= ', ';
			else
				$x .= '<br>';
		}
		$x .= '</td></tr></table>';
	}

	if($desc && $desc <> '_empty_')
		$x .= '<table><tr><td><span class="q">'.$desc.'</span></td></tr></table>';

	return $x;
}

function allspellsinfo2(&$row, $level=0)
{

	global $DB;

	if(!($row['spellID']))
		return;
	global $allspells;
	$num = $row['spellID'];
	if(isset($allitems[$num]))
		return $allitems[$num];

	// Номер спелла
	$allspells[$num]['entry'] = $row['spellID'];

	// Имя иконки спелла
	if($row['effect1itemtype'] && !$row['effect1Aura'])
	{
		if(IsSet($allitems[$row['effect1itemtype']]['icon']))
			$allspells[$num]['icon'] = $allitems[$row['effect1itemtype']]['icon'];
		else
			$allspells[$num]['icon'] = $DB->selectCell('SELECT iconname FROM ?_icons, item_template WHERE id = displayid AND entry = ?d LIMIT 1', $row['effect1itemtype']);
	} else {
		$allspells[$num]['icon'] = $row['iconname'];
	}

	$allspells[$num]['name'] = $row['spellname_loc'.$_SESSION['locale']];

	// Тултип спелла
	if($level > 0)
		$allspells[$num]['info'] = render_spell_tooltip($row);

	if($level == 1)
		return $allspells[$num];
	elseif($level == 2)
		return $allspells[$num]['info'];

	return NULL;
}

function spell_buff_render($row)
{
	global $DB;

	$x = '<table><tr>';
	
	// Имя баффа
	$x .= '<td><b class="q">'.htmlspecialchars($row['spellname_loc'.$_SESSION['locale']]).'</b></td>';
	
	// Тип диспела
	if($row['dispeltypeID'])
	{
		$dispel = $DB->selectCell('SELECT name_loc'.$_SESSION['locale'].' FROM ?_spelldispeltype WHERE id=? LIMIT 1', $row['dispeltypeID']);
		$x .= '<th><b class="q">'.htmlspecialchars($dispel).'</b></th>';
	}
	
	$x .= '</tr></table>';
	
	// Подсказка для баффа
	$x .= '<table><tr><td>';
	
	$x .= spell_desc2($row, 'buff').'<br>';
	
	// Длительность баффа
	$duration = $DB->selectCell("SELECT durationBase FROM ?_spellduration WHERE durationID=? LIMIT 1", $row['durationID']);
	if($duration>0)
		$x .= '<span class="q">'.LOCALE_REMAINING_TIME.': '.sec_to_time($duration/1000).' </span>';
	
	$x .= '</td></tr></table>';
	
	return $x;
}

function allspellsinfo($id, $level=0)
{
	global $DB;
	global $allspells;
	global $spell_cols;
	if(isset($allspells[$id]))
		return $allspells[$id];
	$row = $DB->selectRow('
		SELECT ?#
		FROM ?_spell s, ?_spellicons i
		WHERE
			s.spellID=?
			AND i.id = s.spellicon
		LIMIT 1
		',
		$spell_cols[$level],
		$id
	);

	if($row)
		return allspellsinfo2($row, $level);
	else
		return;
}

// Подробная информация о спеле
function spellinfo($id)
{
	global $DB;
	$row = $DB->selectRow('
		SELECT s.*, i.iconname
		FROM ?_spell s, ?_spellicons i
		WHERE
			s.spellID=?
			AND i.id = s.spellicon
		LIMIT 1
		',
		$id
	);
	return spellinfo2($row);
}

function spellinfo2(&$row)
{
	global $DB;
	global $item_cols;

	if($row)
	{
		$spell = array();
		$spell['entry'] = $row['spellID'];
		$spell['quality'] = '@';
		$spell['name'] = $row['spellname_loc'.$_SESSION['locale']];
		$spell['rank'] = $row['rank_loc'.$_SESSION['locale']];
		$spell['level'] = $row['levelspell'];
		$spell['school'] = spell_schoolmask($row['schoolMask']);
		// TODO: Что за cat?
		$spell['cat'] = 0;
		// Скилл
//		if(!(isset($row['skillID'])))
//		$skillrow = list($row['skillID'], $row['req_skill_value'], $row['min_value'], $row['max_value']);//$DB->selectRow('SELECT skillID, req_skill_value, min_value, max_value  FROM ?_skill_line_ability WHERE spellID=?d LIMIT 1', $spell['entry']);
		if(isset($row['skillID']))
		{
//			if($skillrow['req_skill_value'] != 1)
//				$spell['learnedat'] = $skillrow['req_skill_value'];
			// TODO: На каком уровне скилла можно обучиться спеллу (поле learnedat)
			if($row['min_value'] && $row['max_value'])
			{
				$spell['colors'] = array();
				$spell['colors'][0] = '';
				$spell['colors'][1] = $row['min_value'];
				$spell['colors'][2] = floor(($row['max_value'] + $row['min_value']) / 2);
				$spell['colors'][3] = $row['max_value'];
			}
			$spell['skill'] = $row['skillID'];
			
		}

		// Реагенты
		$spell['reagents'] = array();
		$i=0;
		global $allitems;
		for($j=1;$j<=8;$j++)
		{
			if($row['reagent'.$j])
			{
				$spell['reagents'][$i] = array();
				// ID реагента
				$spell['reagents'][$i]['entry'] = $row['reagent'.$j];
				// Доп данные о реагенте
				// Если данных для этой вещи ещё нет:
				allitemsinfo($spell['reagents'][$i]['entry'], 0);
				// Количество реагентов
				$spell['reagents'][$i]['count'] = $row['reagentcount'.$j];
				$i++;
			}
		}

		// Создает вещь:
		$i=0;
		for($j=1;$j<=3;$j++)
			if(isset($row['effect'.$j.'id']) && $row['effect'.$j.'id'] == 24)
			{
				$spell['creates'][$i] = array();
				$spell['creates'][$i]['entry'] = $row['effect'.$j.'itemtype'];
				$spell['creates'][$i]['count'] = $row['effect'.$j.'BasePoints'] + 1;

				if(!isset($allitems[$spell['creates'][$i]['entry']]))
					allitemsinfo($spell['creates'][$i]['entry'], 0);

				if(!isset($allitems[$spell['creates'][$i]['entry']]))
					$spell['quality'] = 7;
				else
					$spell['quality'] = 7 - $allitems[$spell['creates'][$i]['entry']]['quality'];
				$i++;
			}

		allspellsinfo2($row, 0);

		return $spell;
	} else {
		return;
	}
}
?>