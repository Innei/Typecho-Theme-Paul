<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 日记页面
 *
 * @author innei
 * @package custom
 */
$this->need('header.php');
require_once 'functions.php';
$this->widget('Widget_Contents_Page_List')->to($pages);
global $pages_note, $pages_say;
while ($pages->next()):
    switch ($pages->slug) {
        case 'note':
            $pages_note = $pages->permalink;
            break;
        case 'saying':
            $pages_say = $pages->permalink;
            break;
        default:
            break;
    }
endwhile;
?>

    <main class="is-article">
        <nav class="navigation">
            <a href="<?php echo $pages_note; ?>" class="active">日记</a>
            <?php if ($this->options->blog_url): ?> <a href="<?php $this->options->blog_url(); ?>" target="_blank">
                    博文</a><?php endif; ?>
            <a href="<?php echo $pages_say; ?>">语录</a>
        </nav>
        <article>
            <?php
            $this->options->note_nums ? $this->widget('Widget_Contents_Post_Recent', 'pageSize=' . $this->options->note_nums)->to($posts) : $this->widget('Widget_Contents_Post_Recent')->to($posts);
            while ($posts->next()):
                ?>
                <h1 style="position: relative;"><a href="<?php $posts->permalink() ?>"
                                                   style="color: #000"><?php echo date('Y-m-d', $posts->created); ?></a>
                    <small>(<?php echo date('l', $posts->created); ?>)</small>
                    <div style="z-index: -1;font-weight: 400;position: absolute;top: 0;left: 0;right: 0;bottom: 0;text-align: center"><?php $posts->title() ?></div>
                </h1>
                <div class="paul-note" id="cid-<?php $posts->cid(); ?>">
                    <div class="note-content">
                        <?php $posts->content(); ?>
                    </div>
                    <div class="note-inform">
                        <span class="user"><?php $this->user->name(); ?></span>
                        <span class="views" title="阅读次数"><i class="fa fa-leaf"
                                                            aria-hidden="true"></i> <?php echo get_views_num($posts) ?></span>
                    </div>
                    <div class="note-action">
                    <span class="comment" data-cid="<?php $posts->cid(); ?>" data-year="<?php $posts->year(); ?>"
                          title="参与评论">评论 <?php $posts->commentsNum('%d '); ?></span>
                        <!--                    TODO 点赞实现 line 191 263 86 -->
                        <span class="like" data-cid="<?php $posts->cid();
                        ?>" title="已有 <?php get_like_num($posts) ?> 人点赞"><?php get_like_num($posts) ?></span>
                    </div>
                </div>
            <?php if (!$posts->allow('comment')): ?>
                <section class="post-form is-comment" id="com-<?php $posts->cid(); ?>">
                    <h3><i class="fa fa-comments"></i>评论</h3>
                    <div class="note-comments">
                        <div id="note-m"></div>
                        <p>评论功能暂时关闭</p>
                    </div>
                </section>
            <?php else: ?>
                <script>
                    var willComment = document.querySelector('#cid-<?php $posts->cid();?> > div.note-action > span');
                    willComment.outerHTML = '<a href="<?php $posts->permalink();?>#want-comment">' + willComment.outerHTML + '</a>'
                </script>
            <?php endif ?>
            <?php endwhile; ?>
            <section class="note-navigator"><h1>下面是我的小秘密啦～</h1></section>
        </article>
        <!--        <section class="note-navigator"><a class="btn black next" href="//paul.ren/note/2">下一页</a></section>-->
        <script>
            (function () {
                const comment_btns = document.querySelectorAll('.comment');
                for (let comment_btn of comment_btns) {
                    if (document.querySelector('#com-' + comment_btn.getAttribute('data-cid'))) {
                        comment_btn.onclick = function () {
                            const isComment = document.querySelector('#com-' + this.getAttribute('data-cid'));
                            isComment.classList.contains('active') ? isComment.classList.remove('active') : isComment.classList.add('active');
                        }
                    }
                }

                // 点赞实现 ajax

                const Like_btn = document.querySelectorAll('.like')
                for (let el of Like_btn) {
                    el.onclick = function (e) {
                        const that = this
                        ks.ajax({
                            method: "POST",
                            data: {
                                type: "up",
                                cid: this.getAttribute('data-cid'),
                                cookie: document.cookie,

                            },
                            url: "<?php $this->options->siteUrl(); ?>index.php/action/void_like?up",
                            success: function (res) {
                                if (JSON.parse(res.responseText) === "success") {
                                    that.innerHTML = parseInt(that.innerHTML) + 1
                                    ks.notice("感谢你的点赞~", {color: "green", time: 1500});
                                    that.onclick = function () {
                                        ks.notice("你的爱我已经感受到了！", {color: "yellow", time: 1500});
                                    }
                                }
                            },
                            failed: function (res) {
                                ks.notice("FXXK！提交出错了！", {color: "red"});
                            }
                        })
                    }
                }
            })();

        </script>
    </main>

<?php $this->need('footer.php'); ?>