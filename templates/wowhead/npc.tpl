{include file='header.tpl'}

    <div id="main">

        <div id="main-precontents"></div>
        <div id="main-contents" class="main-contents">

            <script type="text/javascript">
                {include file='bricks/allcomments.tpl'}
                var g_pageInfo = {ldelim}type: 1, typeId: {$npc.entry}, name: '{$npc.name|escape:"quotes"}'{rdelim};
                g_initPath([0,4,{$npc.type}]);
            </script>

            <table class="infobox">
                <tr><th>{#Quick_Facts#}</th></tr>
                <tr><td><div class="infobox-spacer"></div>
                    <ul>
                        <li><div>{#Level#}: {if $npc.minlevel != $npc.maxlevel}{$npc.minlevel} - {/if}{$npc.maxlevel}</div></li>
                        <li><div>{#Class#}: {$npc.class_name}</div></li>
                        <li><div>{#Difficulty#}: {$npc.rank_name}</div></li>
                        <li><div>{#CreatureType#}: {$npc.type_name}</div></li>
                        <li><div>{#React#}: <span class="q{if $npc.A==-1}10{elseif $npc.A==1}2{else}{/if}">{#A#}</span> <span class="q{if $npc.H==-1}10{elseif $npc.H==1}2{else}{/if}">{#H#}</span></div></li>
                        <li><div>{#Faction#}: <a href="?faction={$npc.faction_num}">{$npc.faction}</a></div></li>
                        <li><div>{#Health#}: {$npc.min_health_st}{if $npc.max_health_st} - {$npc.max_health_st}{/if}</div></li>
                        {if ($npc.min_mana_st or $npc.max_mana_st)}
                            <li><div>{#Mana#}: {$npc.min_mana_st}{if $npc.max_mana_st} - {$npc.max_mana_st}{/if}</div></li>
                        {/if}
                        {if ($npc.moneysilver>0) or ($npc.moneygold>0) or ($npc.moneycopper>0)}
                            <li><div>{#Loot#}:
                            {if ($npc.moneygold>0)}<span class="moneygold">{$npc.moneygold}</span>{/if}
                            {if ($npc.moneysilver>0)}<span class="moneysilver">{$npc.moneysilver}</span>{/if}
                            {if ($npc.moneycopper>0)}<span class="moneycopper">{$npc.moneycopper}</span>{/if}
                        </div></li>{/if}
                        {if $npc.mindmg > 0 and $npc.maxdmg > 0}
                            <li><div>{#Damage#}: {$npc.mindmg} - {$npc.maxdmg}</div></li>
                        {/if} 
                        <li><div>{#Damage#} ({#Alt_calc#}): 
                            <ul>{#Melee#}: {$npc.min_melee_damage_st}{if $npc.max_melee_damage_st} - {$npc.max_melee_damage_st}{/if}</ul>
                            <ul>{#Ranged#}: {$npc.min_ranged_damage_st}{if $npc.max_ranged_damage_st} - {$npc.max_ranged_damage_st}{/if}</ul>
                        </div></li>
                        {if $npc.armor > 0}
                            <li><div>{#Armor#}: {$npc.armor}</div></li>
                        {/if} 
                        {if ($npc.kill_rep_value1 or $npc.kill_rep_value2)}
                        <li><div>{#Onkill#}: {strip}
                            {if $npc.kill_rep_value1}{$npc.kill_rep_value1|string_format:"%+d"} {#reputationwith#} {$npc.kill_rep_faction1} {#until#} {$npc.kill_rep_until1}{/if}
                            {if ($npc.kill_rep_value1 and $npc.kill_rep_value2)}<br><span style="visibility: hidden;">{#Onkill#}: </span>{/if} 
                            {if $npc.kill_rep_value2}{$npc.kill_rep_value2|string_format:"%+d"} {#reputationwith#} {$npc.kill_rep_faction2} {#until#} {$npc.kill_rep_until2}{/if}
                        {/strip}</div></li>
                        {/if} 
                    </ul>
                </td></tr>
            </table>

        <div class="text">
            <a href="http://{$lang}.wowhead.com/?{$query}" class="button-red"><em><b><i>Wowhead</i></b><span>Wowhead</span></em></a>
            <h1>{$npc.exp_icon}{$npc.name}{if $npc.subname} &lt;{$npc.subname}&gt;{/if}</h1>

        {if $npc.normal}
            {if $npc.normal.de1}
                <div>
                    {if $npc.normal.de2}
                        {#This_is_25normal_NPC#}
                    {else}
                        {#This_is_5heroic_NPC#}
                    {/if} 
                    <a href="?npc={$npc.normal.de1.entry}">{$npc.normal.de1.name}</a>.
                </div>
                <div class="pad"></div>
            {/if}
            {if $npc.normal.de2}
                <div>
                    {#This_is_10heroic_NPC#}
                    <a href="?npc={$npc.normal.de2.entry}">{$npc.normal.de2.name}</a>.
                </div>
                <div class="pad"></div>
            {/if}
            {if $npc.normal.de3}
                <div>
                    {#This_is_25heroic_NPC#}
                    <a href="?npc={$npc.normal.de3.entry}">{$npc.normal.de3.name}</a>.
                </div>
                <div class="pad"></div>
            {/if}
        {/if}

        {if $npc.de1}
            {if $npc.de1.de2}
                <div>
                    {#This_is_10normal_NPC#}
                    <a href="?npc={$npc.de1.normal.entry}">{$npc.de1.normal.name}</a>.
                </div>
                <div class="pad"></div>
                <div>
                    {#This_is_10heroic_NPC#}
                    <a href="?npc={$npc.de1.de2.entry}">{$npc.de1.de2.name}</a>.
                </div>
                <div class="pad"></div>
                {if $npc.de1.de3}
                    <div>
                        {#This_is_25heroic_NPC#}
                        <a href="?npc={$npc.de1.de3.entry}">{$npc.de1.de3.name}</a>.
                    </div>
                    <div class="pad"></div>
                {/if} 
            {else}
                <div>
                    {#This_is_5normal_NPC#}
                    <a href="?npc={$npc.de1.normal.entry}">{$npc.de1.normal.name}</a>.
                </div>
                <div class="pad"></div>
            {/if}
        {/if}

        {if $npc.de2}
            <div>
                {#This_is_10normal_NPC#}
                <a href="?npc={$npc.de2.normal.entry}">{$npc.de2.normal.name}</a>.
            </div>
            <div class="pad"></div>
            <div>
                {#This_is_25normal_NPC#}
                <a href="?npc={$npc.de2.de1.entry}">{$npc.de2.de1.name}</a>.
            </div>
            <div class="pad"></div>
            {if $npc.de2.de3}
                <div>
                    {#This_is_25heroic_NPC#}
                    <a href="?npc={$npc.de2.de3.entry}">{$npc.de2.de3.name}</a>.
                </div>
                <div class="pad"></div>
            {/if} 
        {/if}

        {if $npc.de3}
            <div>
                {#This_is_10normal_NPC#}
                <a href="?npc={$npc.de3.normal.entry}">{$npc.de3.normal.name}</a>.
            </div>
            <div class="pad"></div>
            <div>
                {#This_is_25normal_NPC#}
                <a href="?npc={$npc.de3.de1.entry}">{$npc.de3.de1.name}</a>.
            </div>
            <div class="pad"></div>
            <div>
                {#This_is_10heroic_NPC#}
                <a href="?npc={$npc.de3.de2.entry}">{$npc.de3.de2.name}</a>.
            </div>
            <div class="pad"></div>
        {/if}

        {if $npc.position}
            <div>{#This_NPC_can_be_found_in#} {strip}<span id="locations">
                {foreach from=$npc.position item=zone name=zone}
                    <a href="javascript:;" onclick="
                    {if $zone.atid}
                        myMapper.update(
                            {ldelim}
                                zone:{$zone.atid}
                                {if $zone.points}
                                    ,
                                {/if}
                            {if $zone.points}
                                coords:[
                                    {foreach from=$zone.points item=point name=point}
                                        [{$point.x},{$point.y},
                                        {ldelim}
                                            label:'$<br>
                                            <div class=q0>
                                                <small>
                                                    {if isset($point.r)}
                                                        {#Respawn#}: {$point.r}
                                                    {else}
                                                        {#Waypoint#}
                                                    {/if}
                                                    {if isset($point.events)}<br>{$point.events|escape:"quotes"}{/if}
                                                </small>
                                            </div>',type:'{$point.type}'
                                        {rdelim}]
                                        {if !$smarty.foreach.point.last},{/if}
                                    {/foreach}
                                ]
                            {/if}
                            {rdelim});
                        ge('mapper-generic').style.display='block';
                    {else}
                        ge('mapper-generic').style.display='none';
                    {/if}
                            g_setSelectedLink(this, 'mapper'); return false" onmousedown="return false">
                        {$zone.name}</a>{if $zone.population > 1}&nbsp;({$zone.population}){/if}{if $smarty.foreach.zone.last}.{else}, {/if}
                {/foreach}
            </span></div>{/strip}
            <div id="mapper-generic"></div>
            <div class="clear"></div>

            <script type="text/javascript">
                var myMapper = new Mapper({ldelim}parent: 'mapper-generic', zone: '{$npc.position[0].atid}'{rdelim});
                gE(ge('locations'), 'a')[0].onclick();
            </script>
        {else}
            {#This_NPC_cant_be_found#}
        {/if}

        <h2></h2>

        </div>

        <div id="tabs-generic"></div>

        <div id="listview-generic" class="listview"></div>
<script type="text/javascript">
var tabsRelated = new Tabs({ldelim}parent: ge('tabs-generic'){rdelim});
{if isset($npc.sells)}{include             file='bricks/item_table.tpl'            id='sells'                name='sells'            tabsid='tabsRelated' data=$npc.sells            }{/if}
{if isset($npc.drop)}{include             file='bricks/item_table.tpl'            id='drop'                name='drops'            tabsid='tabsRelated' data=$npc.drop                }{/if}
{if isset($npc.pickpocketing)}{include    file='bricks/item_table.tpl'            id='pick-pocketing'        name='pickpocketing'    tabsid='tabsRelated' data=$npc.pickpocketing    }{/if}
{if isset($npc.skinning)}{include        file='bricks/item_table.tpl'            id='skinning'            name='skinning'            tabsid='tabsRelated' data=$npc.skinning            }{/if}
{if isset($npc.starts)}{include            file='bricks/quest_table.tpl'            id='starts'                name='starts'            tabsid='tabsRelated' data=$npc.starts            }{/if}
{if isset($npc.ends)}{include            file='bricks/quest_table.tpl'            id='ends'                name='ends'                tabsid='tabsRelated' data=$npc.ends                }{/if}
{if isset($npc.abilities)}{include        file='bricks/spell_table.tpl'            id='abilities'            name='abilities'        tabsid='tabsRelated' data=$npc.abilities        }{/if}
{if isset($npc.objectiveof)}{include    file='bricks/quest_table.tpl'            id='objective-of'        name='objectiveof'        tabsid='tabsRelated' data=$npc.objectiveof        }{/if}
{if isset($npc.teaches)}{include        file='bricks/spell_table.tpl'            id='teaches-ability'    name='teaches'            tabsid='tabsRelated' data=$npc.teaches            }{/if}
{if isset($npc.criteria_of)}{include     file='bricks/achievement_table.tpl'     id='criteria-of'        name='criteriaof'        tabsid='tabsRelated' data=$npc.criteria_of        }{/if}
{if $page.comment}new Listview({ldelim}template: 'comment', id: 'comments', name: LANG.tab_comments, tabs: tabsRelated, parent: 'listview-generic', data: lv_comments{rdelim});{/if}
tabsRelated.flush();
</script>

            {if $page.comment}{include file='bricks/contribute.tpl'}{/if}

            <div class="clear"></div>
        </div>
    </div>

{include file='footer.tpl'}
