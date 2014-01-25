<?php
define('API_KILL_MAILS_MOD_VERSION', '1.1');
define('NUMBER_OF_CALLS_DEFAULT', 1);

$modInfo['api_kill_mails']['name'] = "API KillMails";
$modInfo['api_kill_mails']['abstract'] = "Utilizes the new KillMails API Call to prevent the \"one key per account\" caching problems";
$modInfo['api_kill_mails']['about'] = "Version ".API_KILL_MAILS_MOD_VERSION." by <a href=\"http://gate.eveonline.com/Profile/Salvoxia\">Salvoxia</a>";

edkloader::register('APIKillLog', dirname(__FILE__).'/class.killlog.php');



// initialize config
$numberOfCalls = config::get('apikillmails_numberofcalls');
if (!$numberOfCalls)
{ 
    config::set("apikillmails_numberofcalls", NUMBER_OF_CALLS_DEFAULT);
}