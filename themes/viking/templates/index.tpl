<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="description" content="EDK Killboard - {$config->get('cfg_kbtitle')}" />
	<meta name="keywords" content="EDK, killboard, {$config->get('cfg_kbtitle')}, {if $kb_owner}{$kb_owner}, {/if}Eve-Online, killmail" />
	<title>{$kb_title}</title>
	<link rel="stylesheet" type="text/css" href="{$kb_host}/themes/default/default.css" />
	{if isset($style)}<link rel="stylesheet" type="text/css" href="{$theme_url}/{$style}.css" />{/if}
{$page_headerlines}
	<script type="text/javascript" src="{$kb_host}/themes/generic.js"></script>
</head>
<body {if isset($on_load)}{$on_load}{/if}>
{$page_bodylines}
	<div id="popup"></div>

	<div class="infoheader">
		<div class="banner"></div>
	</div>
	
	<div class="navigation">
		<div class="navigation_in">
			<ul width="100%">
				{section name=item loop=$menu}
					<li style="width:{$menu_w}; text-align:center">
						<a class="link" style="display: block;" href="{$menu[item].link}">{$menu[item].text}</a>
					</li>
				{/section}
			</ul>
		</div>
	</div>
	<div id="wrapper">
		<div id="main_top_left">
			<div id="main_top_right">
				<div id="main_top">
				
				</div>
			</div>
		</div>

		<div id="main_left">
			<div id="main_right">
				<div id="main">
					<div id="page-title">{$page_title}</div>
					<div id="content">
						{$content_html}
					</div>
					{if $context_html}
						<div id="context">
							{section name=item loop=$context_divs}
								<div class="context_element" id="context_{$smarty.section.item.index}">{$context_divs[item]}</div>
							{/section}
						</div>
					{/if}
					<div class="counter"></div>
				</div>
			</div>
		</div>
		
		<div id="footer">
			<div id="footer_left">
				<div id="footer_right">
					<div id="footer_float_left">
						{if $profile}
							<span class="smalltext" style="font-size:11px;">
								<!-- profile -->{$profile_sql} queries{if $profile_sql_cached} (+{$profile_sql_cached} cached) {/if} SQL time {$sql_time}s, Total time {$profile_time}s<!-- /profile -->
							</span>
						{/if}			
					</div>
					<div id="footer_float_right">
						<span class="smalltext" style="font-size:11px;">
							Design by Tyranero on 
							<a target="_blank" href="http://www.dzinerstudio.com" style="color: #666666;font-family: "Segoe UI",Arial,Helvetica,sans-serif;">
								<strong>DSv4 (DzinerStudio)</strong>
							</a>
						</span><br/>
						<a href="#" id="footer_float_right_icon"></a>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
