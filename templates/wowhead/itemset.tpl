{include file='header.tpl'}

        <div id="main">

            <div id="main-precontents"></div>

            <div id="main-contents" class="main-contents">
                <script type="text/javascript">
                    {include file='bricks/allcomments.tpl'}
                    var g_pageInfo = {ldelim}type: {$page.type}, typeId: {$page.typeid}, name: '{$itemset.name|escape:"quotes"}'{rdelim};
                    g_initPath({$page.path});
                </script>

                <table class="infobox">
                    <tr><th>{#Quick_Facts#}</th></tr>
                    <tr><td><div class="infobox-spacer"></div>
                        <ul>
                            <li><div>{#Level#} {#Set_items2#}: {$itemset.minlevel}{if $itemset.minlevel!=$itemset.maxlevel} - {$itemset.maxlevel}{/if}</div></li>
                            {if $itemset.reqlvl}<li><div>{#Requires_level#}: {$itemset.reqlvl}</div></li>{/if}
                            {if $itemset.classes}<li><div>{#Class#}: {$itemset.classes}</div></li>{/if}
                            {if $itemset.type}<li><div>{#Type_of_armor#}: {$itemset.type}</div></li>{/if}
                        </ul>
                    </td></tr>
                </table>

                <div class="text">
                    <a href="http://{$lang}.wowhead.com/?{$query}" class="button-red"><em><b><i>Wowhead</i></b><span>Wowhead</span></em></a>
                    <h1>{$itemset.name}</h1>
                    {$itemset.article}
                    {#Set_include#} {$itemset.count} {if $itemset.count < 5}{#Set_items1#}{else}{#Set_items2#}{/if}:
                    <table class="iconlist">
                        {section name=i loop=$itemset.pieces}<tr><th align="right" id="iconlist-icon{$smarty.section.i.index+1}"></th><td><span class="q{$itemset.pieces[i].quality}"><a href="?item={$itemset.pieces[i].entry}">{$itemset.pieces[i].name}</a></span></td></tr>{/section} 
                    </table>
                    <script type="text/javascript">
                        {section name=i loop=$itemset.pieces}ge('iconlist-icon{$smarty.section.i.index+1}').appendChild(g_items.createIcon({$itemset.pieces[i].entry}, 0, 0));{/section}
                    </script>
                    <h3>{#Set_bonuses#}</h3>
                    {#Bonuses_info#}
                    <ul>
                        {section name=i loop=$itemset.spells}<li><div>{$itemset.spells[i].bonus} {if $itemset.spells[i].bonus < 5}{#Set_pieces1#}{else}{#Set_pieces2#}{/if}: <a href="?spell={$itemset.spells[i].entry}">{$itemset.spells[i].tooltip}</a></div></li>{/section}
                    </ul>

                <h2></h2>

            </div>

            <div id="tabs-generic"></div>
            <div id="listview-generic" class="listview"></div>
<script type="text/javascript">
var tabsRelated = new Tabs({ldelim}parent: ge('tabs-generic'){rdelim});
{if $page.comment}new Listview({ldelim}template: 'comment', id: 'comments', name: LANG.tab_comments, tabs: tabsRelated, parent: 'listview-generic', data: lv_comments{rdelim});{/if}
tabsRelated.flush();
</script>

            {if $page.comment}{include file='bricks/contribute.tpl'}{/if}

            </div>
        </div>
    </div>
{include file='footer.tpl'}
