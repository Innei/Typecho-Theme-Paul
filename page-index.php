<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 首页模板, 关于, 赞助, 心愿
 *
 * @author innei
 * @package custom
 */
$this->need('header.php');
require_once 'functions.php';
$this->widget('Widget_Contents_Page_List')->to($pages);
global $index_about, $index_donate, $index_dream, $index_works;
while ($pages->next()):
    switch ($pages->slug) {
        case 'about':
            $index_about = $pages->permalink;
            break;
        case  'donate':
            $index_donate = $pages->permalink;
            break;
        case 'dream':
            $index_dream = $pages->permalink;
            break;
        case 'project':
            $index_works = $pages->text;
            break;
        case 'note':
            $index_note = $pages->permalink;
            break;
        default:
            break;
    }
endwhile;
?>

    <main class="is-article">
        <nav class="navigation">
            <a href="<?php $this->options->siteUrl(); ?>">首页</a>
            <?php if ($index_about): ?><a
                href="<?php echo $index_about ?>" <?php $this->slug == 'about' ? print_r('class="active"') : print_r(''); ?> >
                    关于</a><?php endif ?>
            <?php if ($index_donate): ?><a
                href="<?php echo $index_donate ?>" <?php $this->slug == 'donate' ? print_r('class="active"') : print_r(''); ?>>
                    赞助</a> <?php endif; ?>
            <?php if ($index_dream): ?><a
                href="<?php echo $index_dream ?>" <?php $this->slug == 'dream' ? print_r('class="active"') : print_r(''); ?>>
                    心愿</a> <?php endif; ?>
        </nav>
        <article>
            <h1><?php $this->title(); ?></h1>
            <?php $this->content() ?>
            <div class="paul-note">
                <div class="note-action">
                    <span class="comment" data-cid="<?php $this->cid(); ?>" data-year="<?php $this->year(); ?>"
                          title="参与评论">评论</span>
                </div>
            </div>
        </article>
        <?php $this->need('comments.php') ?>
        <script src="<?php $this->options->themeUrl('src/index.js') ?>"></script>
    </main>

<?php $this->footer(); ?>
<?php $this->need('footer.php'); ?>