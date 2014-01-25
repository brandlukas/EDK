<?php
require_once("common/admin/admin_menu.php");

$settings_updated = false;

if(isset($_POST["cyno"])) {
	if($_POST["cyno"] == 'Yes') {
		config::set('cc_cyno', true);
		$cyno = true;
	} else {
		config::set('cc_cyno', false);
		$cyno = false;
	}
	$settings_updated = true;
} else {
	$cyno = config::get('cc_cyno');
}

if(isset($_POST["cloak"])) {
	if($_POST["cloak"] == 'Yes') {
		config::set('cc_cloak', true);
		$cloak = true;
	} else {
		config::set('cc_cloak', false);
		$cloak = false;
	}
	$settings_updated = true;
} else {
	$cloak = config::get('cc_cloak');
}

if($settings_updated) {
	$html .= "<span style=\"color: orange;\">Settings Updated!</span>";
}

$html .= "
	<form name='config' method='post' class='cynoCloakModSettings'>
		<span style='display:inline-block; line-height:32px; position:relative; width:140px;'>Show fitted Cynos?</span>
		<select name='cyno'>
			<option ".($cyno ? "selected=true" : "")." value='Yes'>Yes</option>
			<option ".(!$cyno ? "selected=true" : "")." value='No'>No</option>
		</select>
		<br/>
		<span style='display:inline-block; line-height:32px; position:relative; width:140px;'>Show fitted Cloaks?</span>
		<select name='cloak'>
			<option ".($cloak ? "selected=true" : "")." value='Yes'>Yes</option>
			<option ".(!$cloak ? "selected=true" : "")." value='No'>No</option>
		</select>
		<br/>
		<input type='submit' value='Save' style='margin-top:8px;'/>
   </form>
";


$page = new Page('Cyno/Cloak Mod');
$page->setContent($html);
$page->addContext($menubox->generate());
$page->generate();

?>