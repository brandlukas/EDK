<?php
	if(!defined('KB_SITE')) die ("Go Away!");        
        
	require_once("common/admin/admin_menu.php");
        require_once("mods/api_kill_mails/init.php");
	$module = "API KillMails";
	$page = new Page("$module");

        // update values
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
            $numberOfCalls = $_POST["numberOfCalls"];
            if(is_null($numberOfCalls) || !is_numeric($numberOfCalls))
            {
                $html .= "<div><strong>Error: The value must be a number!</strong></div>";
                $numberOfCalls = config::get('apikillmails_numberofcalls');
            }
            
            else
            {
                config::set("apikillmails_numberofcalls", $numberOfCalls);
                $html .= "<div><strong>Settings Updated.</strong></div>";
            }
	}
        
        $numberOfCalls = config::get('apikillmails_numberofcalls');
	$html .=<<<HTML
	<div class="block-header2">Settings</div>
        This setting defines how many times the API is queried to get killmails from the past. With a single call a maximum of 1000 killmails are returned. The more calls are done, the more memory the procdure takes (with enough mails or API keys up to 1GB and more!).<br/>
        If you want to import mails from the further in the past or run into memory issues you may change this value.<br/>        
	<form name="update" id="update" method="post">
	<table class="kb-subtable">
		<tr>
			<td width="220"><strong>Max. number of API calls (per key)</strong></td>
			<td><input type="text" name="numberOfCalls" value="
HTML;
	$html .= $numberOfCalls."\" />" ;
	$html .=<<<HTML
	</td>
		</tr>
	</table>
HTML;

	$html .=<<<HTML
	<div class="block-header2">Save changes</div>
	<table class="kb-subtable">
		<tr>
			<td width="160"></td>
			<td><input type="submit" name="submit" value="Save" /></td>
		</tr>
	</table>
	</form>
HTML;
	$html .= "<div style=\"padding: 5px; margin: 20px 10px 10px; text-align: right; border-top: 1px solid #ccc\">$module ".API_KILL_MAILS_MOD_VERSION." by <a href=\"https://gate.eveonline.com/Profile/Salvoxia/\">Salvoxia</a>.</div>";
	$page->setContent($html);
	$page->addContext($menubox->generate());
	$page->generate();
?>
