<?php
/**
 * 移植主题
 * 设计: Paul
 * 来源: paul.ren
 *
 * @package Paul Theme
 * @author Dreamer-Paul
 * @version 0.1 insider
 * @link https://paul.ren
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
require_once 'functions.php';
?>


<main>
    <nav class="navigation">
        <a href="<?php $this->options->siteUrl(); ?>" class="active">首页</a>
        <a href="https://paul.ren/about">关于</a>
        <a href="https://paul.ren/donate">赞助</a>
        <a href="https://paul.ren/dream">心愿</a>
    </nav>
    <section class="me">
        <div class="my-avatar">
            <img src="https://paul.ren/static/img/avatar.jpg">
        </div>
        <div class="my-info">
            <h1><?php $this->user->name() ?></h1>
            <p><?php $this->options->description() ?></p>
            <div class="social-icons">
                <a href="https://github.com/<?php $this->options->github_username(); ?>" target="_blank" ks-tag="bottom"
                   ks-text="GitHub"><i
                            class="fa fa-github" style="color: #44006f"></i></a>
            </div>
        </div>
    </section>
    <section class="paul-news">
        <!--        TODO 是否显示-->
        <div class="news-item">
            <div class="news-head">
                <h3 class="title"><i class="fa fa-book"></i>最新博文</h3>
                <h3 class="more"><a href="<?php $this->options->blog_url(); ?>" target="_blank"><i
                                class="fa fa-chevron-right"></i></a>
                </h3>
            </div>
            <div class="news-body">
                <div class="row s">
                    <?php while ($this->next()): ?>
                        <div class="col-6 col-m-3">
                            <a href="<?php $this->permalink() ?>" class="news-article"
                               target="_blank">
                                <img src="<?php $this->options->themeUrl('src/img/' . random_int(1, 14) . '.jpg') ?>">
                                <h4><?php $this->title() ?></h4>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!--        TODO 代表作品移植-->
        <!--        <div class="news-item">
                    <div class="news-head grey">
                        <h3 class="title"><i class="fa fa-leaf"></i>代表作品</h3>
                        <h3 class="more"><a href="https://paul.ren/project" data-pjax-state=""><i
                                    class="fa fa-chevron-right"></i></a></h3>
                    </div>
                    <div class="news-body">
                        <div class="row s">
                            <div class="col-4 col-m-2">
                                <a href="/project/style" class="news-project" data-pjax-state="">
                                    <img src="https://paul.ren/static/img/works/Kico.jpg">
                                    <h4>奇趣框架</h4>
                                </a>
                            </div>
                            <div class="col-4 col-m-2">
                                <a href="/project/player" class="news-project" data-pjax-state="">
                                    <img src="https://paul.ren/static/img/works/Kico.jpg">
                                    <h4>奇趣播放器</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>-->
        <div class="news-item">
            <div class="news-head red">
                <h3 class="title"><i class="fa fa-comments"></i>日记</h3>
                <h3 class="more"><a href="https://paul.ren/note" data-pjax-state=""><i class="fa fa-chevron-right"></i></a>
                </h3>
            </div>
            <div class="news-body">
                <div class="row s">
                    <?php while ($this->next()): ?>
                        <div class="col-m-6">
                            <div class="boxed"><p>
                                    <?php $this->excerpt(80, '...'); ?></p>
                                <p><span class="date"><?php $this->date(); ?></span></p></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
    <!--        TODO 点赞移植  229行 367行-->
    <!--        <section class="do-you-like-me">-->
    <!--            <div class="heart" title="为我点赞！"></div>-->
    <!--            <h2 class="likes">1043</h2>-->
    <!--        </section>-->
</main>

<?php $this->need('footer.php') ?>
