{strip}
{assign var="percent" value=false}
{assign var="explevel" value=false}
{foreach from=$data item=curr}
        {if isset($curr.percent)}{assign var="percent" value=true}{/if}
		{if isset($curr.explevel)}{assign var="explevel" value=true}{/if}
{/foreach}
	new Listview({ldelim}
		template:'zone',
		id:'{$id}',
		{if $name}name:LANG.tab_{$name}{/if},
		tabs:tabsRelated,
		parent:'listview-generic',
		hiddenCols:['instancetype', 'level', 'territory', 'category'],
		extraCols:[
			{if $percent}Listview.extraCols.percent,{/if}
			{if $explevel}Listview.funcBox.createSimpleCol('explevel', 'explevel', '15%', 'explevel'),{/if}
		],
		sort:[{if $percent}'-percent',{/if}{if $explevel}'explevel',{/if}'name'],
		data:[
			{section name=i loop=$data}
				{ldelim}
					id:'{$data[i].id}',
					name:'{$data[i].name|escape:"quotes"}'
					{if $data[i].percent},percent:{$data[i].percent}{/if}
					{if $data[i].explevel},explevel:{$data[i].explevel}{/if}
				{rdelim}
				{if $smarty.section.i.last}{else},{/if}
			{/section}
		]
	{rdelim});
{/strip}

