{strip}
{assign var="percent" value=false}
{foreach from=$data item=curr}
        {if isset($curr.percent)}{assign var="percent" value=true}{/if}
{/foreach}
	new Listview({ldelim}
		template:'zone',
		id:'fished-in',
		{if $name}name:LANG.tab_{$name}{/if},
		tabs:tabsRelated,
		parent:'listview-generic',
		hiddenCols:['instancetype', 'level', 'territory', 'category'],
		extraCols:[{if $percent}Listview.extraCols.percent{/if}],
		sort:['-percent', 'name'],
		data:[
			{section name=i loop=$data}
				{ldelim}
					id:'{$data[i].id}',
					name:'{$data[i].name|escape:"quotes"}'
					{if isset($data[i].percent)},percent:{$data[i].percent}{/if}
				{rdelim}
				{if $smarty.section.i.last}{else},{/if}
			{/section}
		]
	{rdelim});
{/strip}

