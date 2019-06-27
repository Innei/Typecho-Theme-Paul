<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->widget('Widget_Contents_Page_List')->to($pages);
$works = $index_pages = $collection = array();
while ($pages->next()):
    switch ($pages->template): case 'page-note.php':
            $GLOBALS['note'] = $pages->permalink;
            break;
        case 'page-works.php':
            $GLOBALS['project'] = $pages->permalink;
            break;
        case 'page-bangumi.php':
            $GLOBALS['bangumi'] = $pages->permalink;
            break;
        case 'page-works_info.php':
            $works[] = $pages->permalink;
            break;
        case 'page-music.php':
            $GLOBALS['music'] = $pages->permalink;
            break;
        case 'page-say.php':
            $GLOBALS['say'] = $pages->permalink;
            $GLOBALS['say_text'] = $pages->content;
            break;
        case 'page-index.php':
            $index_pages[] = $pages->permalink;
            break;
        case 'page-link.php':
            $GLOBALS['link'] = $pages->permalink;
            break;
        case 'page-archive.php':
            $GLOBALS['archive'] = $pages->permalink;
            break;
        case 'page-opensource.php':
            $GLOBALS['opensource'] = $pages->permalink;
            break;
    endswitch;
endwhile;
$GLOBALS['works'] = $works;
$GLOBALS['index'] = $index_pages;
$GLOBALS['stack'] = $pages->stack;
?>