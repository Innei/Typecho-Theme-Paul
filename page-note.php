<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('utils/like.php') ?>
<?php
/**
 * 日记页面
 *
 * @author innei
 * @package custom
 */
$this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($posts);
// ajax 加载
if (isset($_GET['load_type']) and $_GET['load_type'] == 'ajax'):

    if ($this->options->is_hidden_note and !$this->user->hasLogin()){

        if (isset($_GET['secret']) and ($_GET['secret'] == $this->options->secret)) {
            Typecho_Cookie::set('__post_'.$this->options->secret, $this->options->secret);
        } else if (!empty(Typecho_Cookie::get('__post_'.$this->options->secret))) {

        }
        else{
            header('Content-type: application/json');
            print_r(json_encode(["msg" => "暗号错误"]));
            http_response_code(403);
            exit;
        }
    }

    // 判断是否溢出
    function allpostnum($id)
    {
        $db = Typecho_Db::get();
        $postnum = $db->fetchRow($db->select(array('COUNT(authorId)' => 'allpostnum'))->from('table.contents')->where('table.contents.authorId=?', $id)->where('table.contents.type=?', 'post'));
        $postnum = $postnum['allpostnum'];
        return (int)$postnum;
    }

    if (allpostnum($this->author->uid) < $_GET['index']):http_response_code(422);
        return;endif;
    for ($i = 0; $i < $_GET['index']; $i++) {
        // 跳过代码
        if (!$posts->next()): http_response_code(422);
            exit; endif;
    }
    ?>
    <article style="margin-top: 3rem">
    <?php
    for ($i = 0; $i < 5 && $posts->next(); $i++):
        ?>
        <h1 style="position: relative;"><a href="<?php $posts->permalink() ?>"
                                           style="color: #000"><?php echo date('Y-m-d', $posts->created); ?></a>
            <small>(<?php echo date('l', $posts->created); ?>)</small>
            <div class="note-title"><?php $posts->title() ?></div>
        </h1>
        <div class="paul-note" id="cid-<?php $posts->cid(); ?>">
            <div class="note-content post-content">
                <?php if ($this->options->is_display_all_content) {
                    $content = $posts->content;
                    $out = preg_split("/<p>|<\/p>|<h\d>|<\/h\d>/", $content);
                    $num = 0;
                    $content = '';
                    foreach ($out as $value) {
                        if ($num++ < 8 && $value) {
                            $content .= '<p>'.$value.'</p>';
                        }
                    }
                    echo '<div>' . $content . '</div>';
                    if ($num > 8) {
                      print_r('<section class="note-navigator"><a class="btn yellow" href="' . $posts->permalink . '">继续阅读</a></section>');
                    }

                } else {
                    $posts->content();
                }
                ?>
            </div>
            <div class="note-inform">
                <span class="user"><?php $posts->author(); ?></span>
                <span class="views" title="阅读次数 <?php echo get_views_num($posts) ?>"><i class="fa fa-leaf"
                                                                                        aria-hidden="true"></i> <?php echo get_views_num($posts) ?></span>
                <?php if($posts->fields->mood): ?><span class="mood" title="心情"><?php echo $posts->fields->mood;endif; ?></span>
            </div>
            <div class="note-action">
                <a href="<?php $posts->permalink(); ?>#want-comment">
                        <span class="comment" data-cid="<?php $posts->cid(); ?>" data-year="<?php $posts->year(); ?>"
                              title="参与评论">评论 <?php $posts->commentsNum('%d '); ?></span>
                </a>
                <span class="like" data-cid="<?php $posts->cid();
                ?>" title="已有 <?php get_like_num($posts) ?> 人点赞" <?php if (isLiked($posts->cid)) print_r("style='color: var(--red)'") ?>><?php get_like_num($posts) ?></span>
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
    <?php endif ?>
    <?php endfor;
    print_r('</article>');
    exit; //完成ajax方式返回，退出此页面
endif;
?>
<?php

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
                    <div class="note-content post-content">
                        <?php if ($this->options->is_display_all_content) {
                            $content = $posts->content;
                            $out = preg_split("/<p>|<\/p>|<h\d>|<\/h\d>/", $content);
                            $num = 0;
                            $content = '';
                            foreach ($out as $value) {
                                if ($num++ < 8 && !empty($value)) {
                                    $content .= '<p>'.$value.'</p>';
                                }
                            }
                           echo '<div>' . $content . '</div>';
                            if ($num > 8) {
                                 print_r('<section class="note-navigator"><a class="btn yellow" href="' . $posts->permalink . '">继续阅读</a></section>');
                            }

                        } else {
                            $posts->content();
                        }
                        ?>
                    </div>
                    <div class="note-inform">
                        <span class="user"><?php $posts->author(); ?></span>
                        <span class="views" title="阅读次数 <?php echo get_views_num($posts) ?>"><i class="fa fa-leaf"
                                                                                                aria-hidden="true"></i> <?php echo get_views_num($posts) ?></span>
                        <?php if($posts->fields->mood): ?><span class="mood" title="心情"><?php echo $posts->fields->mood;endif; ?></span>
                    </div>
                    <div class="note-action">
                        <span class="comment" data-cid="<?php $posts->cid(); ?>" data-year="<?php $posts->year(); ?>"
                              title="参与评论">评论 <?php $posts->commentsNum('%d '); ?></span>
                        <span class="like" data-cid="<?php $posts->cid();
                        ?>" title="已有 <?php get_like_num($posts) ?> 人点赞" <?php if (isLiked($posts->cid)) print_r("style='color: red'") ?>><?php get_like_num($posts) ?></span>
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
                    (() => {
                        const willComment = document.querySelector('span.comment[data-cid="<?php $posts->cid() ?>"]');
                        willComment.outerHTML = '<a href="<?php $posts->permalink(); ?>#want-comment">' + willComment.outerHTML + '</a>'
                    })()
                </script>
            <?php endif ?>
            <?php endfor; ?>
            <section id="note-navigator" class="note-navigator">
                <?php if ($this->options->is_hidden_note and empty(Typecho_Cookie::get('__post_'.$this->options->secret)) and !$this->user->hasLogin()): ?>
                <input type="text" id="secret" style="margin-right: 1rem" placeholder="主人设置了暗号" title="主人设置了暗号, 需要暗号才能查看哦" />
                <?php endif; ?>
                <button id="load-more-btn">加载更多</button>
            </section>
        </article>
        <script src="<?php $this->options->themeUrl('src/like.js') ?>"></script>
        <script>
          // 因为某个插件引起的 bug
          function removeEmptyNode(el=document) {
            [...el.querySelectorAll('.note-content.post-content p')].forEach(item => {
              if (!item.innerText || item.innerText === '\n') item.remove()
            })
          }
          removeEmptyNode()
        </script>
        <script>
            (function () {

                // 加载更多 ajax 实现
                let current_index = <?php echo $index ?>;
                const noteNavigator = document.getElementById('note-navigator')
                document.getElementById('load-more-btn').onclick = load_more
                const article_body = document.querySelector('body > main > article')

                function load_more() {
                    ks.notice("稍等哈 φ(>ω<*) ", {
                        time: 1000,
                        color: "green"
                    })
                    ks.ajax({
                        method: 'GET',
                        <?php if ($this->options->is_hidden_note and empty(Typecho_Cookie::get('__post_'.$this->options->secret)) and !$this->user->hasLogin()):
                        echo "url: window.location.href + '?load_type=ajax&index=' + current_index + '&secret=' + document.getElementById('secret').value,";
                        else: ?>
                        url: window.location.href + '?load_type=ajax&index=' + current_index,
                        <?php endif; ?>
                        success: res => {
                            noteNavigator.remove()
                            const strToDOM = parser(res.responseText)
                            like_init(strToDOM)
                            window.pjax.refresh(strToDOM)
                            const article = strToDOM.querySelector('article')
                            article.style.animation = 'fade-in-top 1s forwards'
                            article_body.appendChild(article)
                            removeEmptyNode(article)
                            article_body.appendChild(noteNavigator)
                            current_index += 5
                        },
                        failed: res => {
                            if (res.status === 403) {
                                ks.notice (JSON.parse(res.responseText)['msg'], {
                                    color: "red",
                                    time: 1500
                                })
                            }
                            if (res.status === 422) {
                                noteNavigator.remove()
                                ks.notice("没了哦!~(｀・ω・´)", {
                                    color: 'red',
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