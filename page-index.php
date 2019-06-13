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
require_once 'pages.php';
?>

    <main class="is-article">
        <nav class="navigation">
            <a href="<?php $this->options->siteUrl(); ?>">首页</a>
            <?php foreach ($GLOBALS['stack'] as $key => $item):
                if ($item['template'] == 'page-index.php')
                    $item['permalink'] == $this->permalink ? print_r('<a href="' . $item['permalink'] . '" class="active">' . $item['title'] . '</a>') : print_r('<a href="' . $item['permalink'] . '">' . $item['title'] . '</a>');
                ?>
            <?php endforeach; ?>
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