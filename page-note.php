<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
$this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($posts);
// ajax 加载
if (isset($_GET['load_type']) and $_GET['load_type'] == 'ajax'):
    // 判断是否溢出
    function allpostnum($id)
    {
        $db = Typecho_Db::get();
        $postnum = $db->fetchRow($db->select(array('COUNT(authorId)' => 'allpostnum'))->from('table.contents')->where('table.contents.authorId=?', $id)->where('table.contents.type=?', 'post'));
        $postnum = $postnum['allpostnum'];
        return (int)$postnum;
    }

    var_dump(allpostnum($this->author->uid));
    if (allpostnum($this->author->uid) < $_GET['index']):http_response_code(422);
        return;endif;
    for ($i = 0; $i < $_GET['index'] && $posts->next(); $i++) {
        // 跳过代码
    }
    for ($i = 0; $i < 5 && $posts->next(); $i++):
        ?>
        <article>
            <h1 style="position: relative;"><a href="<?php $posts->permalink() ?>"
                                               style="color: #000"><?php echo date('Y-m-d', $posts->created); ?></a>
                <small>(<?php echo date('l', $posts->created); ?>)</small>
                <div class="note-title"><?php $posts->title() ?></div>
            </h1>
            <div class="paul-note" id="cid-<?php $posts->cid(); ?>">
                <div class="note-content">
                    <?php if ($this->options->is_display_all_content) {
                        $content = $posts->content;
                        $out = preg_split("/<p>|<\/p>|<h\d>|<\/h\d>/", $content);
                        $num = 0;
                        $content = '';
                        foreach ($out as $value) {
                            if ($num++ < 8) {
                                $content .= $value;
                            }
                        }
                        echo '<div>' . $content . '</div>';
                        print_r('<section class="note-navigator"><a class="btn yellow" href="' . $posts->permalink . '">继续阅读</a></section>');
                    } else {
                        $posts->content();
                    }
                    ?>
                </div>
                <div class="note-inform">
                    <span class="user"><?php $posts->author(); ?></span>
                    <span class="views" title="阅读次数 <?php echo get_views_num($posts) ?>"><i class="fa fa-leaf"
                                                                                            aria-hidden="true"></i> <?php echo get_views_num($posts) ?></span>
                    <span class="words" title="字数 <?php echo get_words($posts) ?>"><i class="fa fa-file-word-o"
                                                                                      aria-hidden="true"></i> <?php echo get_words($posts) ?></span>

                </div>
                <div class="note-action">
                        <span class="comment" data-cid="<?php $posts->cid(); ?>" data-year="<?php $posts->year(); ?>"
                              title="参与评论">评论 <?php $posts->commentsNum('%d '); ?></span>
                    <span class="like" data-cid="<?php $posts->cid();
                    ?>" title="已有 <?php get_like_num($posts) ?> 人点赞"><?php get_like_num($posts) ?></span>
                </div>
            </div>
            <?php if (!$posts->allow('comment')) : ?>
            <section class="post-form is-comment" id="com-<?php $posts->cid(); ?>">
                <h3><i class="fa fa-comments"></i>评论</h3>
                <div class="note-comments">
                    <div id="note-m"></div>
                    <p>评论功能暂时关闭</p>
                </div>
            </section>
        </article>
    <?php else : ?>
        <script>
            var willComment = document.querySelector('#cid-<?php $posts->cid(); ?> > div.note-action > span');
            willComment.outerHTML = '<a href="<?php $posts->permalink(); ?>#want-comment">' + willComment.outerHTML + '</a>'
        </script>
    <?php endif ?>
    <?php endfor;
    return; //完成ajax方式返回，退出此页面
endif;
?>


<?php
/**
 * 日记页面
 *
 * @author innei
 * @package custom
 */
$this->need('header.php');
require_once 'functions.php';
require_once 'pages.php';
?>

    <main class="is-article">
        <nav class="navigation">
            <a href="<?php echo $GLOBALS['note']; ?>" class="active">日记</a>
            <?php if ($this->options->blog_url) : ?> <a href="<?php $this->options->blog_url(); ?>" target="_blank">
                    博文</a><?php endif; ?>
            <?php if ($GLOBALS['say']) : ?><a href="<?php echo $GLOBALS['say']; ?>">语录</a><?php endif; ?>
        </nav>
        <article>
            <?php
            $index = $this->options->note_nums ? $this->options->note_nums : 5;
            for ($i = 0; $i < $index && $posts->next(); $i++):
                ?>
                <h1 style="position: relative;"><a href="<?php $posts->permalink() ?>"
                                                   style="color: #000"><?php echo date('Y-m-d', $posts->created); ?></a>
                    <small>(<?php echo date('l', $posts->created); ?>)</small>
                    <div class="note-title"><?php $posts->title() ?></div>
                </h1>
                <div class="paul-note" id="cid-<?php $posts->cid(); ?>">
                    <div class="note-content">
                        <?php if ($this->options->is_display_all_content) {
                            $content = $posts->content;
                            $out = preg_split("/<p>|<\/p>|<h\d>|<\/h\d>/", $content);
                            $num = 0;
                            $content = '';
                            foreach ($out as $value) {
                                if ($num++ < 8) {
                                    $content .= $value;
                                }
                            }
                            echo '<div>' . $content . '</div>';
                            print_r('<section class="note-navigator"><a class="btn yellow" href="' . $posts->permalink . '">继续阅读</a></section>');
                        } else {
                            $posts->content();
                        }
                        ?>
                    </div>
                    <div class="note-inform">
                        <span class="user"><?php $posts->author(); ?></span>
                        <span class="views" title="阅读次数 <?php echo get_views_num($posts) ?>"><i class="fa fa-leaf"
                                                                                                aria-hidden="true"></i> <?php echo get_views_num($posts) ?></span>
                        <span class="words" title="字数 <?php echo get_words($posts) ?>"><i class="fa fa-file-word-o"
                                                                                          aria-hidden="true"></i> <?php echo get_words($posts) ?></span>

                    </div>
                    <div class="note-action">
                        <span class="comment" data-cid="<?php $posts->cid(); ?>" data-year="<?php $posts->year(); ?>"
                              title="参与评论">评论 <?php $posts->commentsNum('%d '); ?></span>
                        <span class="like" data-cid="<?php $posts->cid();
                        ?>" title="已有 <?php get_like_num($posts) ?> 人点赞"><?php get_like_num($posts) ?></span>
                    </div>
                </div>
            <?php if (!$posts->allow('comment')) : ?>
                <section class="post-form is-comment" id="com-<?php $posts->cid(); ?>">
                    <h3><i class="fa fa-comments"></i>评论</h3>
                    <div class="note-comments">
                        <div id="note-m"></div>
                        <p>评论功能暂时关闭</p>
                    </div>
                </section>
            <?php else : ?>
                <script>
                    var willComment = document.querySelector('#cid-<?php $posts->cid(); ?> > div.note-action > span');
                    willComment.outerHTML = '<a href="<?php $posts->permalink(); ?>#want-comment">' + willComment.outerHTML + '</a>'
                </script>
            <?php endif ?>
            <?php endfor; ?>
            <section id="note-navigator" class="note-navigator">
                <button id="load-more-btn">加载更多</button>
            </section>
        </article>
        <script>
            (function () {
                ks.lazy("img");

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
                                if (JSON.parse(res.responseText)['status'] === 1) {
                                    that.innerHTML = parseInt(that.innerHTML) + 1
                                    ks.notice("感谢你的点赞~", {
                                        color: "green",
                                        time: 1500
                                    });
                                    that.onclick = function () {
                                        ks.notice("你的爱我已经感受到了！", {
                                            color: "yellow",
                                            time: 1500
                                        });
                                    }
                                } else if (JSON.parse(res.responseText)['status'] === 0) {
                                    ks.notice("你的爱我已经感受到了！", {
                                        color: "yellow",
                                        time: 1500
                                    });
                                }
                            },
                            failed: function (res) {
                                ks.notice("FXXK！提交出错了！", {
                                    color: "red"
                                });
                            }
                        })
                    }
                }

                // 加载更多 ajax 实现
                let current_index = <?php echo $index ?>;
                const noteNavigator = document.getElementById('note-navigator')
                document.getElementById('load-more-btn').onclick = load_more
                const article_body = document.querySelector('body > main > article')
                const parser = new DOMParser()  // DOM 解析器
                const doc = function (str) {
                    return parser.parseFromString(str, 'text/html')
                }

                function load_more() {
                    ks.notice("稍等哈 φ(>ω<*) ", {
                        time: 1000,
                        color: "green"
                    })
                    ks.ajax({
                        method: 'GET',
                        url: window.location.href + '?load_type=ajax&index=' + current_index,
                        success: res => {
                            noteNavigator.remove()
                            const strToDOM = doc(res.responseText)
                            article_body.appendChild(strToDOM.querySelector('article'))
                            article_body.appendChild(noteNavigator)
                            current_index += 5
                        },
                        failed: res => {
                            if (res.status === 422) {
                                noteNavigator.remove()
                                ks.notice("没了哦!~(｀・ω・´)", {
                                    color: 'yellow',
                                    time: 1500
                                })
                            }
                        }
                    })
                }
            })();
        </script>
    </main>

<?php $this->need('footer.php'); ?>