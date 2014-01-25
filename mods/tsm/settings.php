<?php
require_once ('common/admin/admin_menu.php');
//require_once('common/includes/class.ship.php');
//require_once('common/includes/class.corp.php');
//require_once('common/includes/class.alliance.php');
//require_once('common/includes/class.eveapi.php');
$page = new Page("Settings - TSM");
$page->setCachable(false);
$page->setAdmin();
$qry = new DBQuery();
if (isset($_POST['go'])) {
    //echo "<pre>";var_dump($_POST);die;
    config::set('tsm_smfrelative', $_POST['smfrelative']);
    if ($_POST['comment']) config::set('tsm_comment', '1');
    else config::set('tsm_comment', '0');
    if ($_POST['killmail']) config::set('tsm_killmail', '1');
    else config::set('tsm_killmail', '0');
    if ($_POST['admin']) config::set('tsm_admin', '1');
    else config::set('tsm_admin', '0');
    foreach(array('c', 'k', 'a') as $l) {
        if (!empty($_POST[$l . 'groups'])) {
            foreach($_POST[$l . 'groups'] as $id => $v) {
                $groups[$l][] = $id;
            }
        }
        if (!empty($groups[$l])) $groups[$l] = implode(',', $groups[$l]);
        config::set('tsm_' . $l . 'groups', $groups[$l]);
    }
    //   if ($_POST['showPoster'])
    //        config::set('tsm_showPoster', '1');
    //   else
    //        config::set('tsm_showPoster', '0');
    $html.= '<i>Setting saved.</i><br />';
}
//if (isset($_GET['check_config']))
//{
$html.= "<div class=block-header2>Configuration control</div>";
if (is_file(config::get('tsm_smfrelative') . "/index.php") && is_file(config::get('tsm_smfrelative') . "/SSI.php")) {
    $smfv = file_get_contents(config::get('tsm_smfrelative') . "/index.php");
    $smfv = explode('$forum_version = \'SMF ', $smfv, 2);
    $smfv = explode("';", $smfv[1], 2);
    $smfv = $smfv[0];
    if ($smfv[0] < 2) {
        $idgroup = 'ID_GROUP';
        $groupname = 'groupName';
        $minposts = 'minPosts';
        $html.= '&raquo; SMF Found, version ' . $smfv . ' <font color=green>Ok</font><br>';
    } else {
        $idgroup = 'id_group';
        $groupname = 'group_name';
        $minposts = 'min_posts';
        $html.= '&raquo; SMF Found, version ' . $smfv . ' <font color=green>Ok</font><br>';
    }
} else $html.= '&raquo; SMF not Found <font color=red>Error</font><br>';
//}
//else
//    $html.='<form id="options" name="options" method="post" action="?a=settings_tsm&check_config"><input type=submit value="Check Configuration" ></form>';
$html.= '<form id="options" name="options" method="post" action="?a=settings_tsm">';
$html.= "<div class=block-header2>General Settings</div>";
//$html .= "<input type=checkbox name=showposter id=showposter";
//if (config::get('tsm_showPoster'))
//   $html .= " checked=\"checked\"";
//$html .= "> Show the Username of the killmail poster<br>";
$html.= "<input type=checkbox name=killmail id=killmail";
if (config::get('tsm_killmail')) $html.= " checked=\"checked\"";
$html.= "> Use SMF to Manage Killmail Posting<br>";
$html.= "<input type=checkbox name=comment id=comment";
if (config::get('tsm_comment')) $html.= " checked=\"checked\"";
$html.= "> Use SMF to Manage Comment Posting<br>";
$html.= "<input type=checkbox name=admin id=admin";
if (config::get('tsm_admin')) $html.= " checked=\"checked\"";
$html.= "> Use SMF to Manage Admin Login<br>";
//$html .= "<input type=checkbox name=admin id=admin";
//if (config::get('tsm_admin'))
//    $html .= " checked=\"checked\"";
//$html .= "> Give Forum Admins Admin on killboard<br><br>";
$html.= '<br><input type=text name="smfrelative" size=15 value="' . config::get('tsm_smfrelative') . '"> Relative path of the SMF forum (ex : ../forum)<br>';
$html.= "<div class=block-header2>SMF Group Settings</div>";
if ($smfv) {
    require (config::get('tsm_smfrelative') . "/SSI.php");
    $link = mysql_connect($db_server, $db_user, $db_passwd);
    mysql_select_db($db_name, $link);
    $sql = 'SELECT ' . $idgroup . ', ' . $groupname . ' FROM ' . $db_prefix . 'membergroups WHERE ' . $minposts . ' = -1';
    $data = "";
    $result = mysql_query($sql, $link);
    if (!$result) {
        echo $sql;
        if ($error) {
            echo "<BR>" . mysql_error($link) . "<BR>";
        }
        return false;
    }
    if (!empty($result)) {
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $data[$row[0]] = $row[1];
        }
    }
    mysql_free_result($result);
    unset($data[3]);
    $data[0] = 'no membergroup';
    if (!empty($data)) {
        $cgroups = explode(',', config::get('tsm_cgroups'));
        $cgroups = array_flip($cgroups);
        $kgroups = explode(',', config::get('tsm_kgroups'));
        $kgroups = array_flip($kgroups);
        $agroups = explode(',', config::get('tsm_agroups'));
        $agroups = array_flip($agroups);
        $html.= '<table border="1"><tr><td>Group Name</td><td>Post Comments</td><td>Post Killmails</td><td>Admin</td></tr>';
        foreach($data as $id => $name) {
            $html.= '<tr><td>' . $name . '</td><td><input type=checkbox name=cgroups[' . $id . '] id=admin';
            if (isset($cgroups[$id])) $html.= ' checked="checked"';
            $html.= '></td><td><input type=checkbox name=kgroups[' . $id . '] id=admin';
            if (isset($kgroups[$id])) $html.= ' checked="checked"';
            $html.= '></td><td><input type=checkbox name=agroups[' . $id . '] id=admin';
            if (isset($agroups[$id])) $html.= ' checked="checked"';
            $html.= '></td></tr>';
        }
        $html.= '</table>';
    }
} else {
    $html.= 'Please Set SMF path<br>';
}
$html.= "<br><input type=submit id=submit name=go value=\"Save\"><br><br>";
$html.= "</form /><br><br>";
$html.= '<span class="killcount">TSM ' . TSM_VERSION . '</span>';
$page->setContent($html);
$page->addContext($menubox->generate());
$page->generate();
?>
