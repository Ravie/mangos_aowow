{include file='header.tpl'}

    <div id="main">

        <div id="main-precontents"></div>
        <div id="main-contents" class="main-contents">

            <script type="text/javascript">
                {include file='bricks/allcomments.tpl'}
                var g_pageInfo = {ldelim}type: {$page.type}, typeId: {$page.typeid}, name: '{$zone.name|escape:"quotes"}'{rdelim};
                g_initPath({$page.path});
            </script>
            
            
            {if $zone.explevel}
                <table class="infobox">
                    <tr><th>{#Quick_Facts#}</th></tr>
                    <tr><td><div class="infobox-spacer"></div>
                        <ul>
                            <li><div>{#Level#}: {$zone.explevel|escape:"quotes"}</div></li>
                        </ul>
                    </td></tr>
                </table>
            {/if}
            
            <div class="text">

                <a href="http://{$lang}.wowhead.com/?{$query}" class="button-red"><em><b><i>Wowhead</i></b><span>Wowhead</span></em></a>
                <h1>{$zone.name}</h1>

{if $zone.position}
                <div>
{strip}
                <span id="locations">
                    {foreach from=$zone.position item=zoneitem name=zoneitem}
                        <a href="javascript:;" onclick="
                            myMapper.update(
                                {ldelim}
                                {if $zoneitem.atid}
                                    zone:{$zoneitem.atid}
                                    {if isset($zoneitem.points)}
                                        ,
                                    {/if}
                                {else}
                                    show:false
                                {/if}
                                {if isset($zoneitem.points)}
                                    coords:[
                                        {foreach from=$zoneitem.points item=point name=point}
                                                [{$point.x},{$point.y},
                                                {ldelim}
                                                    label:'{if isset($point.name)}{$point.name|escape:"html"|escape:"html"}{else}${/if}<br>
                                                    {if isset($point.r) or isset($point.events)}
                                                    <div class=q0>
                                                        <small>
                                                            {#Respawn#}: {$point.r}
                                                            {if isset($point.events)}<br>{$point.events|escape:"quotes"}{/if}
                                                        </small>
                                                    </div>
                                                    {/if}',
                                                    {if isset($point.url)}url:'{$point.url|escape:"quotes"}',{/if}
                                                    type:'{$point.type}'
                                                {rdelim}]
                                                {if !$smarty.foreach.point.last},{/if}
                                        {/foreach}
                                    ]
                                {/if}
                                {rdelim});
                            g_setSelectedLink(this, 'mapper'); return false" onmousedown="return false">
                            {$zoneitem.name}</a>{if $zoneitem.population > 1}&nbsp;({$zoneitem.population}){/if}{if $smarty.foreach.zoneitem.last}{else}, {/if}
                    {/foreach}
                </span></div>
{/strip}
                <div id="mapper-generic"></div>
                <div class="clear"></div>

                <script type="text/javascript">
                    var myMapper = new Mapper({ldelim}parent: 'mapper-generic', zone: '{$zone.position[0].atid}'{rdelim});
                    gE(ge('locations'), 'a')[0].onclick();
                </script>
{/if}
{if isset($zone.parentname) and isset($zone.parent)}
                <div class="pad"></div>
                <div>{#This_zone_is_part_of#} <a href="?zone={$zone.parent}">{$zone.parentname}</a>.</div>
{/if}
                <h2></h2>
            </div>

            <div id="tabs-generic"></div>
            <div id="listview-generic" class="listview"></div>
<script type="text/javascript">
var tabsRelated = new Tabs({ldelim}parent: ge('tabs-generic'){rdelim});
{if isset($zone.fishing)}{include file='bricks/item_table.tpl' id='fishing' name='fishing' tabsid='tabsRelated' data=$zone.fishing}{/if}
{if isset($zone.subzones)}{include file='bricks/zone_table.tpl' id='zones' name='zones' tabsid='tabsRelated' data=$zone.subzones}{/if}

{if $page.comment}new Listview({ldelim}template: 'comment', id: 'comments', name: LANG.tab_comments, tabs: tabsRelated, parent: 'listview-generic', data: lv_comments{rdelim});{/if}
tabsRelated.flush();
</script>

{if $page.comment}{include file='bricks/contribute.tpl'}{/if}

        </div>
    </div>

{include file='footer.tpl'}
