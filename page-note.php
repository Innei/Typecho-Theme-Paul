<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 日记页面
 *
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
            $this->widget('Widget_Contents_Post_Recent')->to($posts);
            while ($posts->next()):
            ?>
            <h1><?php echo date('Y-m-d', $posts->created); ?>
                <small>(<?php echo date('l', $posts->created); ?>)</small>
            </h1>
            <div class="paul-note" id="cid-<?php $posts->cid(); ?>">
                <div class="note-content">
                    <?php $posts->content(); ?>
                </div>
                <div class="note-inform">
                    <span class="user"><?php $this->user->name(); ?></span>
                    <span class="mood" title="好心情可以带来美好的一天">一般</span>
                </div>
                <div class="note-action">
                    <span class="comment" data-cid="<?php $posts->cid(); ?>" data-year="<?php $posts->year(); ?>"
                          title="参与评论">评论</span>
                    <!--                    TODO 点赞实现 line 191 263 86 -->
                    <!--                    <span class="like" data-cid="--><?php //$posts->cid();
                    ?><!--" title="已有 0 人点赞">0</span>-->
                </div>
            </div>

        </article>
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
            willComment.outerHTML = '<a href="<?php $posts->permalink();?>">' + willComment.outerHTML + '</a>'
        </script>
        <?php endif ?>
        <?php endwhile; ?>
        <section class="note-navigator"><a class="btn black next" href="//paul.ren/note/2"
                                           data-pjax-state="">下一页</a></section>
        <script>
            var comment_btns = document.querySelectorAll('.comment');
            for (let comment_btn of comment_btns) {
                if (document.querySelector('#com-' + comment_btn.getAttribute('data-cid'))) {
                    comment_btn.onclick = function () {
                        const isComment = document.querySelector('#com-' + this.getAttribute('data-cid'));
                        isComment.classList.contains('active') ? isComment.classList.remove('active') : isComment.classList.add('active');
                    }
                }
            }
        </script>

    </main>

<?php $this->need('footer.php'); ?>