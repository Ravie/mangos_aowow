<?php
// Commented ones are statistics
mass_define(array(
    'ACHIEVEMENT_CRITERIA_TYPE_KILL_CREATURE' => 0,
    'ACHIEVEMENT_CRITERIA_TYPE_WIN_BG' => 1,
    'ACHIEVEMENT_CRITERIA_TYPE_REACH_LEVEL' => 5,
    'ACHIEVEMENT_CRITERIA_TYPE_REACH_SKILL_LEVEL' => 7,
    'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_ACHIEVEMENT' => 8,
    'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_QUEST_COUNT' => 9,
    'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_DAILY_QUEST_DAILY' => 10,
    'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_QUESTS_IN_ZONE' => 11,
    'ACHIEVEMENT_CRITERIA_TYPE_DAMAGE_DONE' => 13,
    'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_DAILY_QUEST' => 14,
    //'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_BATTLEGROUND' => 15,
    //'ACHIEVEMENT_CRITERIA_TYPE_DEATH_AT_MAP' => 16,
    //'ACHIEVEMENT_CRITERIA_TYPE_DEATH' => 17,
    //'ACHIEVEMENT_CRITERIA_TYPE_DEATH_IN_DUNGEON' => 18,
    //'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_RAID' => 19,
    //'ACHIEVEMENT_CRITERIA_TYPE_KILLED_BY_CREATURE' => 20,
    //'ACHIEVEMENT_CRITERIA_TYPE_KILLED_BY_PLAYER' => 23,
    'ACHIEVEMENT_CRITERIA_TYPE_FALL_WITHOUT_DYING' => 24,
    //'ACHIEVEMENT_CRITERIA_TYPE_DEATHS_FROM' => 26,
    'ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_QUEST' => 27,
    'ACHIEVEMENT_CRITERIA_TYPE_BE_SPELL_TARGET' => 28,
    'ACHIEVEMENT_CRITERIA_TYPE_CAST_SPELL' => 29,
    'ACHIEVEMENT_CRITERIA_TYPE_BG_OBJECTIVE_CAPTURE' => 30,
    'ACHIEVEMENT_CRITERIA_TYPE_HONORABLE_KILL_AT_AREA' => 31,
    'ACHIEVEMENT_CRITERIA_TYPE_WIN_ARENA' => 32,
    //'ACHIEVEMENT_CRITERIA_TYPE_PLAY_ARENA' => 33,
    'ACHIEVEMENT_CRITERIA_TYPE_LEARN_SPELL' => 34,
    'ACHIEVEMENT_CRITERIA_TYPE_HONORABLE_KILL' => 35,
    'ACHIEVEMENT_CRITERIA_TYPE_OWN_ITEM' => 36,
    'ACHIEVEMENT_CRITERIA_TYPE_WIN_RATED_ARENA' => 37,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_TEAM_RATING' => 38,
    'ACHIEVEMENT_CRITERIA_TYPE_REACH_TEAM_RATING' => 39,
    'ACHIEVEMENT_CRITERIA_TYPE_LEARN_SKILL_LEVEL' => 40,
    'ACHIEVEMENT_CRITERIA_TYPE_USE_ITEM' => 41,
    'ACHIEVEMENT_CRITERIA_TYPE_LOOT_ITEM' => 42,
    'ACHIEVEMENT_CRITERIA_TYPE_EXPLORE_AREA' => 43,
    'ACHIEVEMENT_CRITERIA_TYPE_OWN_RANK' => 44,
    'ACHIEVEMENT_CRITERIA_TYPE_BUY_BANK_SLOT' => 45,
    'ACHIEVEMENT_CRITERIA_TYPE_GAIN_REPUTATION' => 46,
    'ACHIEVEMENT_CRITERIA_TYPE_GAIN_EXALTED_REPUTATION' => 47,
    'ACHIEVEMENT_CRITERIA_TYPE_VISIT_BARBER_SHOP' => 48,
    'ACHIEVEMENT_CRITERIA_TYPE_EQUIP_EPIC_ITEM' => 49,
    'ACHIEVEMENT_CRITERIA_TYPE_ROLL_NEED_ON_LOOT' => 50,
    'ACHIEVEMENT_CRITERIA_TYPE_ROLL_GREED_ON_LOOT' => 51,
    'ACHIEVEMENT_CRITERIA_TYPE_HK_CLASS' => 52,
    'ACHIEVEMENT_CRITERIA_TYPE_HK_RACE' => 53,
    'ACHIEVEMENT_CRITERIA_TYPE_DO_EMOTE' => 54,
    'ACHIEVEMENT_CRITERIA_TYPE_HEALING_DONE' => 55,
    'ACHIEVEMENT_CRITERIA_TYPE_GET_KILLING_BLOWS' => 56,
    'ACHIEVEMENT_CRITERIA_TYPE_EQUIP_ITEM' => 57,
    //'ACHIEVEMENT_CRITERIA_TYPE_MONEY_FROM_VENDORS' => 59,
    //'ACHIEVEMENT_CRITERIA_TYPE_GOLD_SPENT_FOR_TALENTS' => 60,
    //'ACHIEVEMENT_CRITERIA_TYPE_NUMBER_OF_TALENT_RESETS' => 61,
    'ACHIEVEMENT_CRITERIA_TYPE_MONEY_FROM_QUEST_REWARD' => 62,
    //'ACHIEVEMENT_CRITERIA_TYPE_GOLD_SPENT_FOR_TRAVELLING' => 63,
    //'ACHIEVEMENT_CRITERIA_TYPE_GOLD_SPENT_AT_BARBER' => 65,
    //'ACHIEVEMENT_CRITERIA_TYPE_GOLD_SPENT_FOR_MAIL' => 66,
    'ACHIEVEMENT_CRITERIA_TYPE_LOOT_MONEY' => 67,
    'ACHIEVEMENT_CRITERIA_TYPE_USE_GAMEOBJECT' => 68,
    'ACHIEVEMENT_CRITERIA_TYPE_BE_SPELL_TARGET2' => 69,
    'ACHIEVEMENT_CRITERIA_TYPE_SPECIAL_PVP_KILL' => 70,
    'ACHIEVEMENT_CRITERIA_TYPE_FISH_IN_GAMEOBJECT' => 72,
    'ACHIEVEMENT_CRITERIA_TYPE_EARNED_PVP_TITLE' => 74,
    'ACHIEVEMENT_CRITERIA_TYPE_LEARN_SKILLLINE_SPELLS' => 75,
    'ACHIEVEMENT_CRITERIA_TYPE_WIN_DUEL' => 76,
    //'ACHIEVEMENT_CRITERIA_TYPE_LOSE_DUEL' => 77,
    //'ACHIEVEMENT_CRITERIA_TYPE_KILL_CREATURE_TYPE' => 78,
    //'ACHIEVEMENT_CRITERIA_TYPE_GOLD_EARNED_BY_AUCTIONS' => 80,
    //'ACHIEVEMENT_CRITERIA_TYPE_CREATE_AUCTION' => 82,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_AUCTION_BID' => 83,
    //'ACHIEVEMENT_CRITERIA_TYPE_WON_AUCTIONS' => 84,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_AUCTION_SOLD' => 85,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_GOLD_VALUE_OWNED' => 86,
    //'ACHIEVEMENT_CRITERIA_TYPE_GAIN_REVERED_REPUTATION' => 87,
    //'ACHIEVEMENT_CRITERIA_TYPE_GAIN_HONORED_REPUTATION' => 88,
    //'ACHIEVEMENT_CRITERIA_TYPE_KNOWN_FACTIONS' => 89,
    //'ACHIEVEMENT_CRITERIA_TYPE_LOOT_EPIC_ITEM' => 90,
    //'ACHIEVEMENT_CRITERIA_TYPE_RECEIVE_EPIC_ITEM' => 91,
    //'ACHIEVEMENT_CRITERIA_TYPE_ROLL_NEED' => 93,
    //'ACHIEVEMENT_CRITERIA_TYPE_ROLL_GREED' => 94,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_HEALTH' => 95,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_POWER' => 96,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_STAT' => 97,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_SPELLPOWER' => 98,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_ARMOR' => 99,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_RATING' => 100,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_HIT_DEALT' => 101,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_HIT_RECEIVED' => 102,
    //'ACHIEVEMENT_CRITERIA_TYPE_TOTAL_DAMAGE_RECEIVED' => 103,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_HEAL_CASTED' => 104,
    //'ACHIEVEMENT_CRITERIA_TYPE_TOTAL_HEALING_RECEIVED' => 105,
    //'ACHIEVEMENT_CRITERIA_TYPE_HIGHEST_HEALING_RECEIVED' => 106,
    //'ACHIEVEMENT_CRITERIA_TYPE_QUEST_ABANDONED' => 107,
    //'ACHIEVEMENT_CRITERIA_TYPE_FLIGHT_PATHS_TAKEN' => 108,
    'ACHIEVEMENT_CRITERIA_TYPE_LOOT_TYPE' => 109,
    'ACHIEVEMENT_CRITERIA_TYPE_CAST_SPELL2' => 110,
    'ACHIEVEMENT_CRITERIA_TYPE_LEARN_SKILL_LINE' => 112,
    'ACHIEVEMENT_CRITERIA_TYPE_EARN_HONORABLE_KILL' => 113,
    //'ACHIEVEMENT_CRITERIA_TYPE_ACCEPTED_SUMMONINGS' => 114,
));

$achievements_cols = array(
    0 => array('iconname', 'name_loc'.$_SESSION['locale']),
    1 => array('iconname', 'name_loc'.$_SESSION['locale'], 'description_loc'.$_SESSION['locale'], 'count'),
);


function allachievementsinfo($id, $level = 0)
{
    global $DB, $allachievements, $achievements_cols;

    if(isset($allachievements[$id]))
        return $allachievements[$id];

    $row = $DB->selectRow('
            SELECT ?#, a.id
            FROM ?_spellicons s, ?_achievement a
            WHERE
                a.icon = s.id
                AND a.id = ?
        ',
        $achievements_cols[$level],
        $id
    );
    if($row)
        return allachievementsinfo2($row, $level);
}
function allachievementsinfo2($row, $level = 0)
{
    global $allachievements;

    if(isset($row['id']))
        $id = $row['id'];

    if(isset($allachievements[$id]))
        return $allachievements[$id];

    if(isset($row['iconname']))
        $allachievements[$id] = array('icon' => $row['iconname']);

    if($level > 0)
    {
        global $DB;
        $allachievements[$id]['name'] = $row['name'] = $row['name_loc'.$_SESSION['locale']];
        $allachievements[$id]['description'] = $row['description'] = $row['description_loc'.$_SESSION['locale']];
        $criterias = $DB->selectCol('
                SELECT name_loc?d
                FROM ?_achievementcriteria
                WHERE refAchievement = ?
                ORDER BY `order` ASC
            ',
            $_SESSION['locale'],
            $id
        );
        $tmp = array();
        $rows = array();
        $i = 0;
        foreach($criterias as $_row)
        {
            if($i++ % 2)
                $tmp[] = $_row;
            else
                $rows[] = $_row;
        }
        if($tmp)
            $rows = array_merge($rows, $tmp);

        $x = '';
        $x .= '<table><tr><td><b class="q">';
        $x .= htmlspecialchars($row['name']);
        $x .= '</b></td></tr></table><table><tr><td><br />';
        $x .= htmlspecialchars($row['description']);
        $x .= '<br /><br /><span class="q">'.LOCALE_CRITERIA.':</span><table width="100%"><tr><td class="q0" style="white-space: nowrap"><small>';

        $i = 0;
        foreach($rows as $cr)
        {
            $x .= '- '.$cr.'<br />';
            if(++$i == round(count($rows)/2)) // FIXME
                $x .= '</small></td><th class="q0" style="white-space: nowrap; text-align: left"><small>';
        }
        $x .= '</small></th></tr></table></td></tr></table>';

        // Completed
        $allachievements[$id]['tooltip'] = $x;
    }

    return $allachievements[$id];
}

function achievementinfo2($row)
{
    if($row)
    {
        $achievement = $row;

        // Сторона
        $achievement['faction'] = 2 - $achievement['faction'];

        allachievementsinfo2($achievement);

        return $achievement;
    }
}

?>