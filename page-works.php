<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 作品页面
 *
 * @author innei
 * @package custom
 */
$this->need('header.php');
require_once 'functions.php';
$projects_text = $this->text;
$projects_json = json_decode($projects_text, true);
?>


<main>
    <nav class="navigation">
        <a href="#" class="active">精选</a>
        <!-- <a href="/project/web">网站</a>
         <a href="/project/music">音乐</a>-->
    </nav>
    <section class="page">
        <section class="project-list">
            <div class="row multi">
                <?php foreach ($projects_json as $key => $value): ?>
                    <div class="col-4 col-s-3 col-m-2">
                        <a href="<?php echo $value['url'] ?>">
                            <img src="<?php $value['img'] ? print_r($value['img']) : $this->options->themeUrl('src/img/Kico.jpg') ?>?>">
                            <h4><?php echo $value['name'] ?></h4>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </section>
</main>

<?php $this->need('footer.php') ?>