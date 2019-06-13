<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 追番页面
 *
 * @author innei
 * @package custom
 */

$this->need('header.php');
require_once 'Pual.php';
require_once 'pages.php';
?>

<main>
    <nav class="navigation">
        <a href="<?php $this->options->siteUrl(); ?>">首页</a>
        <a href="<?php $GLOBALS['bangumi'] ?>" class="active">追番</a>
    </nav>
    <section class="paul-bangumi">
        <div class="row">
           <?php Paul::bangumi() ?>
        </div>
    </section>
</main>

<?php $this->need('footer.php') ?>
