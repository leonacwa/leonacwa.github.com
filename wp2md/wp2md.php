<?php
$cfg_post_dir = "posts/";
$cfg_cat_dir = "category/";
$cfg_db_host_from = 'localhost';
$cfg_db_port_from = '3306';
$cfg_db_user_from = 'root';
$cfg_db_pwd_from = 'nsdhr64326136';
$cfg_db_name_from = 'wp';

$wp = 'wp_'; // wordpress db prefix

$_mysqli_from = mysqli_connect($cfg_db_host_from, $cfg_db_user_from, $cfg_db_pwd_from, $cfg_db_name_from, $cfg_db_port_from) or die('Connect Old Database Error!');
mysqli_query($_mysqli_from, "set names utf8") or die('Set Old Database Charset Error!');
ini_set('date.timezone','Asia/Shanghai');

$strSql = "SELECT object_id, term_taxonomy_id FROM {$wp}term_relationships ORDER BY object_id";
$dtRels = mysqli_query($_mysqli_from, $strSql) or die($strSql);
$pRel = array();
while ($row = mysqli_fetch_row($dtRels)) {
	if (!isset($pRel[ $row[0] ])) $pRel[ $row[0] ] = array();
	$pRel[ $row[0] ][] = $row[1];
}
$strSql = "SELECT term_taxonomy_id, term_id, taxonomy FROM {$wp}term_taxonomy";
$dtRels = mysqli_query($_mysqli_from, $strSql) or die($strSql);
$tRel = array();
while ($row = mysqli_fetch_row($dtRels)) {
	if (!isset($tRel[ $row[0] ])) $tRel[ $row[0] ] = array();
	$tRel[ $row[0] ] = array($row[1], $row[2]);
}
$strSql = "SELECT term_id, name, slug FROM {$wp}terms";
$dtTerms = mysqli_query($_mysqli_from, $strSql) or die($strSql);
$terms = array();
while ($row = mysqli_fetch_row($dtTerms)) {
	if (!isset($terms[ $row[0] ])) $terms[ $row[0] ] = array();
	$terms[ $row[0] ] = array($row[1], $row[2]);
}

$cats_list = array();

$strSql = "SELECT ID, post_date, post_name, post_type, post_title, post_content FROM {$wp}posts";
$dtPosts = mysqli_query($_mysqli_from, $strSql) or die($strSql);
while ($row = mysqli_fetch_row($dtPosts)) {
	$id = $row[0];
	$date = $row[1];
	$name = $row[2];
	$type = $row[3];
	$title = $row[4];
	$content = $row[5];
	$cats = array();
	$tags = array();
	if (isset($pRel[ $id ])) foreach ($pRel[ $id ] as $oid => $ttid) {
		$tid = $tRel[ $ttid ][0];
		if ($tRel[ $ttid ][1] == 'category')  {
			$cats[] = $terms[ $tid ] [1];
			$cats_list[ $terms[ $tid ][1] ] = $terms[ $tid ][0];
			//var_dump($terms[ $tid ] [1]);
			//var_dump($tRel[ $ttid ]);
		} else if ($tRel[ $ttid ][1] == 'post_tag')  {
			if (!isset($terms[ $tid ] )) printf("no tag %d => %d\n", $ttid, $tid);
				$tags[] = $terms[ $tid ] [1];
		}
	}
	if (empty($cats)) {
	/*
	echo $id, "\n";
	var_dump($cats);
	 */
		$cats[] = "uncategorized";
	}

	$file_name = $cfg_post_dir . substr($date, 0, 10) . "_" . $name . ".md";
	$md_file = fopen($file_name, "w") or die("Open failed ".$file_name);
	fprintf($md_file, "---\n");
	fprintf($md_file, "layout: %s\n", $type);
	fprintf($md_file, "title: %s\n", $title);
	fprintf($md_file, "category: %s\n", $cats[0]);
	fprintf($md_file, "categories: [%s]\n", implode(', ', $cats));
	fprintf($md_file, "tags: [%s]\n", implode(', ', $tags));
	fprintf($md_file, "by: %s\n", "wp2md(php)");
	fprintf($md_file, "---\n\n");
	fprintf($md_file, "%s\n", $content);
	fclose($md_file);
}

foreach ($cats_list as $cat_name => $cat_title) {
	$cat_file = fopen($cfg_cat_dir . $cat_name.".html", "w") or die($cat_name);
	fprintf($cat_file, "---\n");
	fprintf($cat_file, "layout: %s\n", "category");
	fprintf($cat_file, "title: %s\n", $cat_title);
	fprintf($cat_file, "---\n\n");
	fprintf($cat_file, "{%% assign category_posts = site.categories.%s %%}\n", $cat_name);
	fprintf($cat_file, "{%% include category_page.textile %%}");
}

?>
