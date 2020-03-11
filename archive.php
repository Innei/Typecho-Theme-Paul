<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 归档（预留）
 * @author Innei
 * @package custom
 */
$this->need('header.php');
require_once 'pages.php';

?>
  <main class="is-article">
    <nav class="navigation">
      <a href="<?php $this->options->siteUrl(); ?>">首页</a>
      <a href="<?php echo $GLOBALS['note']; ?>">日记</a>
      <a href="<?php echo $GLOBALS['archive']; ?>" class="active">归档</a>
    </nav>
    <article class="note-content post-content">
      <h1><?php $this->archiveTitle(array(
          'category'  =>  _t('%s'),
          'search'    =>  _t('%s'),
          'tag'       =>  _t('%s'),
          'author'    =>  _t('%s')
        ), '', ''); ?></h1>
      <div class="archive-wrap">
        <?php if ($this->have()): ?>
          <?php while ($this->next()): ?>
          <li>
            <div class="float-50"><?php $this->date('Y年m月d日 H:i:s'); ?></div>
            <div class="float-50"><a href="<?php $this->permalink() ?>">
                <?php $this->title() ?>
              </a></div>
          </li>
        <?php endwhile; ?>
        <?php else: ?>
          <script>
            ks.notice("(´°̥̥̥̥̥̥̥̥ω°̥̥̥̥̥̥̥̥｀) 什么都没有找到唉...", {
              color: red,
            })
          </script>
        <?php endif; ?>
      </div>
      <div class="text-center">
        <?php $this->pageNav('&laquo;', '&raquo;'); ?>
      </div>
    </article>
  </main>


<?php $this->need('footer.php') ?>