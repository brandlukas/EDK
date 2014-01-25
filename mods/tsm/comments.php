<?php
if (config::get('tsm_comment') && is_file(config::get('tsm_smfrelative') . "/index.php") && is_file(config::get('tsm_smfrelative') . "/SSI.php")) {
    Global $user_info;
    if (empty($user_info)) {
        require_once (config::get('tsm_smfrelative') . "/SSI.php");
    }
    $cgroups = explode(',', config::get('tsm_cgroups'));
    $cgroups = array_flip($cgroups);
    foreach($user_info['groups'] as $g) {
        if (isset($cgroups[$g])) {
            $canpost = TRUE;
            Break;
        }
    }
    //    echo "<pre>";var_dump($user_info);die;
    $who = $user_info['name'];
}
?>
