<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 作品介绍页
 *
 * @author innei
 * @package custom
 */
?>
<?php $this->need('header.php') ?>
<?php $parse = json_decode($this->text, true) ?>
    <main>
        <nav class="navigation">
            <a href="javascript:window.history.back()" class="active">返回</a>
        </nav>
        <section class="page">
            <section class="project-head">
                <?php $parse['project_img']? print_r('<img src="' . $parse['project_img'] . '" />') : print_r('<img src="' . $this->options->themeUrl . '/src/img/Kico.jpg"/>') ?>
                <h1><?php $this->title() ?></h1>
                <p><?php print_r($parse['info']) ?></p>
                <p>
                    <?php echo $parse['url'] ? '<a href="' . $parse['url'] . '" class="btn blue" target="_blank">预览站点</a>' : '<button class="btn blue" disabled>此项目不提供预览</button>' ?>
                    <?php echo $parse['doc_url'] ? '<a href="' . $parse['doc_url'] . '" class="btn blue" target="_blank">文档站点</a>' : '' ?>
                </p>
            </section>
            <section class="project-screenshot">
                <?php foreach ($parse['imgs'] as $key => $url):
                    print_r('<img src="' . $url . '"/>');
                endforeach;
                ?>
            </section>
            <article>
                <?php print_r($parse['body']) ?>
        </section>
    </main>
<?php $this->need('footer.php') ?>