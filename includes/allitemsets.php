<?php

require_once('includes/allitems.php');

$itemset_col[0] = array('itemsetID', 'name_loc'.$_SESSION['locale'], 'item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7', 'item8', 'item9', 'item10',);
$itemset_col[1] = array('itemsetID', 'name_loc'.$_SESSION['locale'], 'item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7', 'item8', 'item9', 'item10', 'spell1', 'spell2', 'spell3', 'spell4', 'spell5', 'spell6', 'spell7', 'spell8', 'skillID', 'bonus1', 'bonus2', 'bonus3', 'bonus4', 'bonus5', 'bonus6', 'bonus7', 'bonus8', 'skilllevel');

function itemsetinfo2(&$row)
{
    global $classes;
    $classmask = 262144;
    $itemset = array();
    $itemset['entry'] = $row['itemsetID'];
    $itemset['name'] = $row['name_loc'.$_SESSION['locale']];
    $itemset['minlevel'] = 255;
    $itemset['maxlevel'] = 0;
    $itemset['pieces'] = array();
    for($j=1;$j<=10;$j++)
        if ($row['item'.$j])
        {
            $itemset['pieces'][] = $row['item'.$j];
            $item = iteminfo($row['item'.$j], 0);
            if($item['classes'] < $classmask)
                $classmask = $item['classes'];
            if($item['level'] < $itemset['minlevel'])
                $itemset['minlevel'] = $item['level'];
            if($item['level'] > $itemset['maxlevel'])
                $itemset['maxlevel'] = $item['level'];
            if($item['classs'] == 4 && $item['subclass'])
                $itemset['type'] = $item['subclass'];
        }
    if(isset($item))
    {
        $itemset['quality2'] = 7 - $item['quality'];
        $item['classes'] = $classmask;
        if($item['classes'] == -1)
            $itemset['classes'] = NULL;
        else
            foreach($classes as $i => $class)
                if ($item['classes'] & (1<<($i-1)))
                    $itemset['classes'][] = $i;
    } else {
        $itemset['quality2'] = 7;
    }
    return $itemset;
}

?>