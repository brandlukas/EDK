<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="description" content="EDK Killboard - {$config->get('cfg_kbtitle')}" />
	<meta name="keywords" content="EDK, killboard, {$config->get('cfg_kbtitle')}, {if $kb_owner}{$kb_owner}, {/if}Eve-Online, killmail" />
	<meta name="google-site-verification" content="Tqx3RuM4VgThRdsVU7WoDgf1napIYerFcY707XqMivg" />
	<meta name="keywords" content="Snuff Box, snuffbox, eve online, snuff box corp, eve killboard, killboard, Tyranero" />
	<title>{$kb_title}</title>
	<link rel="stylesheet" type="text/css" href="{$kb_host}/themes/default/default.css" />
	{if isset($style)}<link rel="stylesheet" type="text/css" href="{$theme_url}/{$style}.css" />{/if}
{$page_headerlines}
	<script type="text/javascript" src="{$kb_host}/themes/generic.js"></script>
</head>
<body {if isset($on_load)}{$on_load}{/if}>
{$page_bodylines}
	<div id="popup"></div>

	{if $banner}
		<div id="header" class=" im_first mw-harlem_shake_me im_blown">
			{if $bannerswf=='true'}
				<object type="application/x-shockwave-flash" data="{$kb_host}/banner/{$banner}" height="200" width="1000">
					<param name="movie" value="myFlashMovie.swf" />
				</object>
			{else}
				<a href="http://snuffboxcorp.com/">Snuff Box</a>
				<!--<a href="http://www.snuffboxcorp.com/">
					<img src="{$kb_host}/banner/{$banner}" style="border:0px" alt="Banner" {if $banner_x && $banner_y}width = "{$banner_x}" height="{$banner_y}"{/if} />
				</a>-->
			{/if}
		</div>
	{/if}

	<div class="infoheader">
	  <div class="infoheader_in">
		<div class="text">We didn't start the fire</div>
	  </div>
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

	<div id="main">
{if $banner}
		<div id="header">
{if $bannerswf=='true'}
			<object type="application/x-shockwave-flash" data="{$kb_host}/banner/{$banner}" height="200" width="1000">
				<param name="movie" value="myFlashMovie.swf" />
			</object>
{else}
		<a href="{if $banner_link}{$banner_link}{else}?a=home{/if}">
			<img src="{$kb_host}/banner/{$banner}" alt="Banner" {if $banner_x && $banner_y}width = "{$banner_x}" height="{$banner_y}"{/if} />
		</a>
{/if}
		</div>
{/if}
{if isset($message)}
		<div id="boardmessage">{$message}</div>
{/if}
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

	<div id="footer">
		<div id="footer_in">
			<div class="impressum">
				<a href="http://www.snuffboxcorp.com/imprint.html">Impressum</a>
			</div>
			{if $profile}
				<div id="profile"><!-- profile -->{$profile_sql} queries{if $profile_sql_cached} (+{$profile_sql_cached} cached) {/if} SQL time {$sql_time}s, Total time {$profile_time}s<!-- /profile --></div>
			{/if}
		</div>
	</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  var pluginUrl = (('https:' == document.location.protocol) ?
   'https://ssl.' : 'http://www.') +
   'google-analytics.com/plugins/ga/inpage_linkid.js';
  _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
  _gaq.push(['_setAccount', 'UA-36502614-1']);
  _gaq.push(['_gat._anonymizeIp']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
