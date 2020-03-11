<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 追番页面
 *
 * @author innei
 * @package custom
 */

$this->need('header.php');
require_once 'pages.php';

?>

<main>
    <nav class="navigation">
        <a href="<?php $this->options->siteUrl(); ?>">首页</a>
        <a href="<?php $GLOBALS['bangumi'] ?>" class="active">追番</a>
        <?php if ($GLOBALS['music']): ?><a href="<?php echo $GLOBALS['music'] ?>">音乐</a><?php endif; ?>
    </nav>
    <section class="paul-bangumi">
      <?php if (Typecho_Widget::widget('Widget_Options')->bili_id):?>
        <div class="row">
           <?php Paul::bangumi() ?>
        </div>
      <?php else: echo '请填写 Bilibili ID 后继续。'; endif; ?>
    </section>
</main>

<?php $this->need('footer.php') ?>
