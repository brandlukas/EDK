Since the mods get not initialized when executing a cronjob, a hook for this mod has to be added manually to.

Find the file cron/cron_api.php and find the following line of code (around line 70):
--------------------------------------------
$myEveAPI = new API_KillLog();
$myEveAPI->iscronjob_ = true;
--------------------------------------------

BEFORE that, add this code:
--------------------------------------------
// hook the api_kill_mails mod
require_once('mods/api_kill_mails/init.php');
--------------------------------------------

To deactivate the mod when importing with the cronjob simply delete these lines again.


About the settings page:
The setting "Max. number of API calls (per key)" defines how many times the API is queried to get killmails from the past. 
With a single call a maximum of 1000 killmails are returned. The more calls are done, the more memory the procdure takes (with enough mails or API keys up to 1GB and more!).
If you want to import mails from the further in the past or run into memory issues you may change this value.
The default value is 1.




Version History:
_______________________________________

Version 1.1 (2013-07-24)
- added settings page for setting a maximum number of API calls per key in order to save memory

Version 1.0 (2013-06-26)
Initial Release
