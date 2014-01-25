<?php
require_once ('common/includes/class.logger.php');
/*
* $Date: 2011-04-10 12:59:52 +1000 (Sun, 10 Apr 2011) $
* $Revision: 1270 $
* $HeadURL: https://evedev-kb.googlecode.com/svn/branches/3.2/common/includes/class.comments.php $
*/
//! Store and retrieve comments for each killmail.
//! This class is used when the details of a kill are viewed.
class Comments {
    //! Create a Comments object for a particular kill.
    /*
    * \param $kll_id The kill id to attach comments to or retrieve for.
    */
    function Comments($kll_id) {
        $this->id_ = $kll_id;
        $this->raw_ = false;
        $this->comments_ = array();
    }
    //! Retrieve comments for a kill.
    //! The kill id is set when the Comments object is constructed.
    function getComments() {
        global $smarty;
        $qry = DBFactory::getDBQuery();
        // NULL site id is shown on all boards
        $qry->execute("SELECT *,id FROM kb3_comments WHERE `kll_id` = '" . $this->id_ . "' AND (site = '" . KB_SITE . "' OR site IS NULL) order by posttime asc");
        while ($row = $qry->getRow()) {
            //Update some formatting from old boards.
            $row['comment'] = str_replace("&amp;", "&", $row['comment']);
            $row['comment'] = str_replace("&", "&amp;", $row['comment']);
            $row['comment'] = preg_replace('/<font color="([^\"]*)">(.*)<\/font>/', '<span style="color:\1">\2</span>', $row['comment']);
            $this->comments_[] = array('time' => $row['posttime'], 'name' => trim($row['name']), 'encoded_name' => urlencode(trim($row['name'])), 'comment' => stripslashes($row['comment']), 'id' => $row['id'], 'ip' => $row['ip']);
        }
        require ('mods/tsm/comments.php');
        $smarty->assignByRef('comments', $this->comments_);
        $smarty->assignByRef('name', $who);
        $smarty->assignByRef('is_guest', $object->user_info['is_guest']);
        $smarty->assignByRef('canpost', $canpost);
        $smarty->assign('norep', time() % 3700);
        return $smarty->fetch(getcwd() . '/mods/tsm/block_comments.tpl');
    }
    //! Add a comment to a kill.
    /*!
    * The kill id is set when the Comments object is constructed.
    * \param $name The name of the comment poster.
    * \param $text The text of the comment to post.
    */
    function addComment($name, $text) {
        $comment = $this->bbencode($text);
        $qryP = new DBPreparedQuery();
        $sql = "INSERT INTO kb3_comments (`kll_id`,`site`, `comment`,`name`,`posttime`, `ip`)
                       VALUES (?, ?, ?, ?, ?, ?)";
        $qryP->prepare($sql);
        $site = KB_SITE;
        $date = kbdate('Y-m-d H:i:s');
        $ip = logger::getip();
		$params = array('isssss', &$this->id_, &$site, &$comment, &$name, &$date, &$ip);
        $qryP->bind_params($params);
        $qryP->execute();
        $id = $qryP->getInsertID();
		echo $id;
        $this->comments_[] = array('time' => kbdate('Y-m-d H:i:s'), 'name' => $name, 'comment' => stripslashes($comment), 'id' => $id);
        // create comment_added event
        event::call('comment_added', $this);
    }
    //! Delete a comment.
    /*
    * \param $c_id The id of the comment to delete.
    */
    function delComment($c_id) {
        $qry = DBFactory::getDBQuery();
        $qry->execute("DELETE FROM kb3_comments WHERE id='" . $c_id);
    }
    //! Set whether to post the raw comment text or bbencode it.
    function postRaw($bool) {
        $this->raw_ = $bool;
    }
    //! bbencode a string.
    //! Used before posting a comment.
    function bbencode($string) {
        if (!$this->raw_) {
            $string = htmlspecialchars(strip_tags(stripslashes($string)));
        }
        $string = str_replace("&gt;", ">", $string);
        $string = str_replace(array('[b]', '[/b]', '[i]', '[/i]', '[u]', '[/u]'), array('<b>', '</b>', '<i>', '</i>', '<u>', '</u>'), $string);
        $string = preg_replace('^\[color=(.*?)](.*?)\[/color]^', '<span style="color:\1">\2</span>', $string);
        $string = preg_replace('^\[kill=(.*?)](.*?)\[/kill]^', '<a href="?a=kill_detail&amp;kll_id=\1">\2</a>', $string);
        $string = preg_replace('^\[pilot=(.*?)](.*?)\[/pilot]^', '<a href="?a=pilot_detail&amp;plt_id=\1">\2</a>', $string);
        return nl2br(addslashes($string));
    }
}
