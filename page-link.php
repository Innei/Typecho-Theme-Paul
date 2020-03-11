<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 友链页面
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
      <a href="<?php echo $GLOBALS['link']; ?>" class="active">朋友们</a>
    </nav>
    <article class="link-wrap">
      <?php
      Paul::parse_Flink($this->text)
      ?>
    </article>
  </main>

<?php $this->need('footer.php') ?>