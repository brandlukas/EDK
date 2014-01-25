<?php
set_error_handler(array('EDKError', 'handler'), E_ALL & ~(E_STRICT | E_NOTICE | E_DEPRECATED | E_USER_NOTICE) );

if (is_file('common/includes/class.pageassembly.php')) {
    require_once ('common/includes/class.pageassembly.php');
} else {
    require_once ('common/includes/class.pageAssembly.php');
}
require_once ('mods/tsm/tsm.php');
class TSM extends pageassembly {
    function replace(&$object) {
        if (config::get('tsm_comment') && is_file(config::get('tsm_smfrelative') . "/index.php") && is_file(config::get('tsm_smfrelative') . "/SSI.php")) {
            $object->replace("comments", "TSM::comments");
            if (isset($_POST['tsm_comment']) && config::get('comments')) TSM::post($object);
        }
        //    $object->replace("victim", "TSM::victim");
        //    $object->delete("victimShip");
        
    }
    function victim($object) {
        global $smarty;
        $smarty->assign('killID', $object->kill->getID());
        $plt = new Pilot($object->kill->getVictimID());
        $smarty->assign('victimPortrait', $plt->getPortraitURL(64));
        $smarty->assign('victimURL', "?a=pilot_detail&amp;plt_id=" . $object->kill->getVictimID());
        $smarty->assign('victimExtID', $plt->getExternalID());
        $smarty->assign('victimName', $object->kill->getVictimName());
        $smarty->assign('victimCorpURL', "?a=corp_detail&amp;crp_id=" . $object->kill->getVictimCorpID());
        $smarty->assign('victimCorpName', $object->kill->getVictimCorpName());
        $smarty->assign('victimAllianceURL', "?a=alliance_detail&amp;all_id=" . $object->kill->getVictimAllianceID());
        $smarty->assign('victimAllianceName', $object->kill->getVictimAllianceName());
        $smarty->assign('victimDamageTaken', $object->kill->VictimDamageTaken);
        // Ship details
        $ship = $object->kill->getVictimShip();
        $shipclass = $ship->getClass();
        $smarty->assign('victimShip', $object->kill->getVictimShip());
        $smarty->assign('victimShipClass', $ship->getClass());
        $smarty->assign('victimShipImage', $ship->getImage(64));
        $smarty->assign('victimShipName', $ship->getName());
        $smarty->assign('victimShipID', $ship->externalid_);
        $smarty->assign('victimShipClassName', $shipclass->getName());
        if ($object->page->isAdmin()) $smarty->assign('ship', $ship);
        include_once ('common/includes/class.dogma.php');
        $ssc = new dogma($ship->externalid_);
        $smarty->assignByRef('ssc', $ssc);
        if ($object->kill->isClassified()) {
            //Admin is able to see classified Systems
            if ($object->page->isAdmin()) {
                if (config::get('apocfitting_mapmod')) {
                    $smarty->assign('systemID', $object->system->getID());
                }
                $smarty->assign('system', $object->system->getName() . ' (Classified)');
                $smarty->assign('systemURL', "?a=system_detail&amp;sys_id=" . $object->system->getID());
                $smarty->assign('systemSecurity', $object->system->getSecurity(true));
            } else {
                $smarty->assign('system', 'Classified');
                $smarty->assign('systemURL', "");
                $smarty->assign('systemSecurity', '0.0');
            }
        } else {
            if (config::get('apocfitting_mapmod')) {
                $smarty->assign('systemID', $object->system->getID());
            }
            $smarty->assign('system', $object->system->getName());
            $smarty->assign('systemURL', "?a=system_detail&amp;sys_id=" . $object->system->getID());
            $smarty->assign('systemSecurity', $object->system->getSecurity(true));
        }
        $smarty->assign('timeStamp', $object->kill->getTimeStamp());
        $smarty->assign('victimShipImg', $ship->getImage(64));
        $smarty->assign('victimShipImgBig', $ship->getImage(256));
        $smarty->assign('totalLoss', number_format($object->kill->getISKLoss()));
        if ($object->page->igb()) return $smarty->fetch(getcwd() . '/mods/tech_III_killdetails/igb_kill_detail_victim.tpl');
        return $smarty->fetch(getcwd() . '/mods/tech_III_killdetails/kill_detail_victim.tpl');
    }
    function comments($object) {
        if (config::get('comments')) {
            global $smarty, $commenthtml;
            if (isset($_GET['kll_id'])) $object->kll_id = intval($_GET['kll_id']);
            else $object->kll_id = 0;
            if (isset($_GET['kll_external_id'])) $object->kll_external_id = intval($_GET['kll_external_id']);
            elseif (isset($_GET['kll_ext_id'])) $object->kll_external_id = intval($_GET['kll_ext_id']);
            else $object->kll_external_id = 0;
            //if (isset($_GET['nolimit'])) $object->nolimit = true;
            //else $object->nolimit = false;
            //require_once('common/includes/class.comments.php');
            require_once ('mods/tsm/class.comments.php');
            $comments = new Comments($object->kll_id);
            $smarty->assignByRef('page', $object->page);
            $smarty->assignByRef('commenthtml', $commenthtml);
            return $comments->getComments();
        } else return '';
        require_once ('./mods/tsm/class.comments.php');
        //return $smarty->fetch(getcwd().'/mods/tsm/block_comments.tpl');
        
    }
    function post($object) {
        Global $commenthtml;
        require_once ('mods/tsm/class.comments.php');
        if (isset($_GET['kll_id'])) $object->kll_id = intval($_GET['kll_id']);
        else $object->kll_id = 0;
        $comments = new Comments($object->kll_id);
        require ('mods/tsm/comments.php');
        if ($canpost || ($page && $page->isAdmin())) {
            if ($_POST['tsm_comment'] == '') {
                $commenthtml = 'Error: The silent type, hey? Good for you, bad for a comment.';
            } else {
                $comment = $_POST['tsm_comment'];
                $name = $who;
                if ($name == null) {
                    $name = 'Anonymous';
                }
                $comments->addComment($name, $comment);
                //Remove cached file.
                if (config::get('cache_enabled')) cache::deleteCache();
                //Redirect to avoid refresh reposting comments.
                header('Location: ' . $_SERVER['REQUEST_URI'], TRUE, 303);
                die();
            }
        } elseif ($user_info['is_guest']) {
            $commenthtml = 'You need to be Logged in on the Forum to Post Comments.';
        } else {
            $commenthtml = 'You do not have Access to post Comments.';
        }
    }
}
?>
