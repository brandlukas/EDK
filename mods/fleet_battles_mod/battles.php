<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'class.battles.php');

$page = new Page('Battles');

switch ($_GET['view'])
{
    case '':
	echo "<!-- MOD VERSION -->\n";
        $battlelist = new BattleList();
        $page->setTitle('Fleet Battles');
	
        $table = new BattleListTable($battlelist);
        $html .= $table->generate();
        break;
}

$menubox = new box('Menu');
$menubox->setIcon('menu-item.gif');
$menubox->addOption('link', 'Fleet Battles', edkURI::page('battles'));

$page->addContext($menubox->generate());

$page->setContent($html);
$page->generate();
?>
