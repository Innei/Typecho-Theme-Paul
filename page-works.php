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
require_once 'pages.php';
$projects_text = $this->text;
$projects_json = json_decode($projects_text, true);
?>
<main>
    <nav class="navigation">
        <a href="<?php echo $GLOBALS['project'] ?>" class="active">精选</a>
        <a href="<?php echo $GLOBALS['opensource'] ?>">开源</a>
    </nav>
    <section class="page">
        <section class="project-list">
            <div class="row multi">
                <?php foreach ($GLOBALS['stack'] as $work) {
                    if ($work['template'] == 'page-works_info.php') :
                        // 解析介绍页 JSON 格式
                        $JSON = json_decode($work['text'], true);
                        $img = $JSON['project_img'] ? $JSON['project_img'] : $this->options->themeUrl . '/src/img/Kico.jpg';
                        echo '<div class="col-4 col-s-3 col-m-2">
                        <a href="' . $work['permalink'] . '">
                            <img src="' . $img . '">
                            <h4>' . $work['title'] . '</h4>
                        </a>
                    </div>';
                    endif;
                } ?>

                <?php foreach ($projects_json as $key => $value) : ?>
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