<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
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


        <h1><?php echo date('Y-m-d'); ?>
            <small>(<?php echo $this->date('l'); ?>)</small>
        </h1>
        <div class="paul-note" id="<?php $this->cid() ?>">
            <div class="note-content">
                <span style="text-align: center"><h1><?php $this->title() ?></h1></span>
                <?php $this->content(); ?>

            </div>
            <div class="note-inform">
                <span class="user"><?php $this->author(); ?></span>
                <span class="mood" title="好心情可以带来美好的一天">一般</span>
            </div>
            <div class="note-action">
                    <span class="comment" data-cid="<?php $this->cid(); ?>" data-year="<?php $this->year(); ?>"
                          title="参与评论">评论</span>
                <!--                    TODO 点赞实现 line 191 263 86 -->
                <!--                    <span class="like" data-cid="-->
                <?php //$this->cid(); ?><!--" title="已有 0 人点赞">0</span>-->
            </div>
        </div>
    </article>
    <?php $this->need('comments.php') ?>
    <script>
        (function () {
            const needComment = document.querySelector('.comment')
            const isComment = document.querySelector('.post-form.is-comment')
            needComment.onclick = () => {
                isComment.classList.contains('active') ? isComment.classList.remove('active') : isComment.classList.add('active');
            };
            (function () {
                document.getElementById('cancel-commit').onclick = e => {
                    isComment.classList.remove('active')
                }
            })();
            (function () {
                // 设定延迟 因为 Pjax 导致无法及时获取到 hash 值
                setTimeout(()=>{
                    if (window.location.hash) {
                        const comment = window.location.hash.indexOf('#comment');
                        const respond_post = window.location.hash.indexOf('#respond-post');
                        const want_comment = window.location.hash.indexOf('#want-comment');
                        if (respond_post !== -1) {
                            document.querySelector('#comment-form > section > h3').innerHTML = '<i class="fa fa-comments"></i>回复';
                            document.querySelector('#comment-form > section > div > p').innerHTML = document.querySelector('#comment-form > section > div > p').innerHTML + '<a href="#" onclick="window.history.back();">  取消回复</a>'
                            const isComment = document.querySelector('.post-form.is-comment');
                            isComment.classList.contains('active') ? isComment.classList.remove('active') : isComment.classList.add('active');
                        } else if (comment !== -1) {
                            let commentLocation = document.querySelector(window.location.hash)
                            commentLocation.querySelector('.comment_main').style.backgroundColor = '#bdc3c7'
                            commentLocation = getElementTop(commentLocation)
                            scrollSmoothTo(commentLocation)
                        } else if (want_comment !== -1) {
                            document.querySelector('#comment-form > section').classList.add('active')
                        }
                    }
                },100)
            })();

            function getElementTop(element) {
                let actualTop = element.offsetTop;
                let current = element.offsetParent;
                while (current !== null) {
                    actualTop += current.offsetTop;
                    current = current.offsetParent;
                }
                return actualTop;
            }

            function scrollSmoothTo(position) {
                if (!window.requestAnimationFrame) {
                    window.requestAnimationFrame = function (callback, element) {
                        return setTimeout(callback, 17);
                    };
                }
                // 当前滚动高度
                let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                // 滚动step方法
                const step = function () {
                    // 距离目标滚动距离
                    let distance = position - scrollTop;
                    // 目标滚动位置
                    scrollTop = scrollTop + distance / 5;
                    if (Math.abs(distance) < 1) {
                        window.scrollTo(0, position);
                    } else {
                        window.scrollTo(0, scrollTop);
                        requestAnimationFrame(step);
                    }
                };
                step();
            }
        }())

    </script>
</main>

<?php $this->footer(); ?>
<?php $this->need('footer.php'); ?>

