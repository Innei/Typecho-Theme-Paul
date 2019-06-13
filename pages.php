<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->widget('Widget_Contents_Page_List')->to($pages);
//global $note, $collection, $project, $works, $say, $index_pages;
$works = $index_pages = array();
while ($pages->next()):
    switch ($pages->template):
        case 'page-note.php':
            $GLOBALS['note'] = $pages->permalink;
            break;
        case 'page-works.php':
            $GLOBALS['project'] = $pages->permalink;
            break;
        case 'page-bangumi.php':
            $GLOBALS['collection'] = $pages->permalink;
            break;
        case 'page-works_info.php':
            $works[] = $pages->permalink;
            break;
        case 'page-say.php':
            $GLOBALS['say'] = $pages->permalink;
            break;
        case 'page-index.php':
            $index_pages[] = $pages->permalink;
            break;
    endswitch;
endwhile;
$GLOBALS['works'] = $works;
$GLOBALS['index'] = $index_pages;
$GLOBALS['stack'] = $pages->stack;
?>