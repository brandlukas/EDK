<?php

function getCynoList() {
	$cynoq = new DBQuery();
	$cynosql = "select itd_kll_id from kb3_items_dropped where (itd_itm_id = 21096 or itd_itm_id = 28646) and (itd_itl_id = 0 or itd_itl_id = 1) union select itd_kll_id from kb3_items_destroyed where (itd_itm_id = 21096 or itd_itm_id = 28646) and (itd_itl_id = 0 or itd_itl_id = 1)";
	$cynoq->execute($cynosql);
	
	
	while ($kill = $cynoq->getRow()) {
		$cynos[] = $kill[itd_kll_id];
	}
	return $cynos;
}

function getCloakList() {
	$covertq = new DBQuery();
	$covertsql = "select itd_kll_id from kb3_items_dropped where (itd_itm_id = 11370 or itd_itm_id = 11577 or itd_itm_id = 11578 or itd_itm_id = 14234) and (itd_itl_id = 0 or itd_itl_id = 1) union select itd_kll_id from kb3_items_destroyed where (itd_itm_id = 11370 or itd_itm_id = 11577 or itd_itm_id = 11578 or itd_itm_id = 14234) and (itd_itl_id = 0 or itd_itl_id = 1)";
	$covertq->execute($covertsql);
	
	while ($kill = $covertq->getRow()) {
		$coverts[] = $kill[itd_kll_id];
	}
	return $coverts;
}

?>