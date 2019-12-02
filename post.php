<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if (isset($_POST['key'])) {
    if ($_POST['key'] == $this->options->secret) {
        Typecho_Cookie::set('__post_' . $this->options->secret, $this->options->secret);
        header("Content-type: application/json");
        print_r(json_encode(["status" => "ok"]));
        exit;
    } else {
        header("Content-type: application/json");
        print_r(json_encode(["status" => "failed"]));
        http_response_code(403);
        exit;
    }
}
?>
<?php $this->need('utils/like.php') ?>
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
            <?php if ($GLOBALS['say']) : ?><a href="<?php echo $GLOBALS['say']; ?>" >语录</a> <?php endif; ?>
        </nav>
        <div class="torTree">
            <div class="torTree-wrap" id="torTree-wrap" style="opacity: 0">
            </div>
        </div>
        <?php
        if ($this->options->is_hidden_note and !$_POST['key']):
            $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($posts);
            $index = $this->options->note_nums ? $this->options->note_nums : 5;
            $cid_arr = array();
            for ($i = 0; $i < $index && $posts->next(); $i++):
                $cid_arr[] = $posts->cid;
            endfor;
            if (!in_array($this->cid, $cid_arr) and empty(Typecho_Cookie::get('__post_' . $this->options->secret)) and !$this->user->hasLogin()) {
                ?>
                <article>
                    <h1>人家也是有小秘密的啦</h1>
                    <form method="post" id="key-form">
                        <fieldset>
                            <label class="submit">
                                <input type="text" name="enable-note" placeholder="开启记忆的钥匙" id="key-passwd">
                                <button class="btn yellow" id="key-submit">提交</button>
                            </label>
                        </fieldset>
                    </form>
                </article>
                <script>
                    (() => {
                        const submit = document.getElementById('key-submit');
                        document.getElementById('key-form').addEventListener('submit', e => {
                            e.preventDefault()
                        });
                        submit.onclick = () => {
                            const key = document.getElementById('key-passwd').value;
                            ks.ajax({
                                method: "POST",
                                data: {
                                    key
                                },
                                url: window.location.href,
                                success(res) {
                                    if (JSON.parse(res.responseText)['status'] === "ok") {
                                        ks.notice("认证成功 d(･｀ω´･d*)", {
                                            color: "green",
                                            time: 1000
                                        });
                                        window.location.reload()
                                    }
                                },
                                failed(res) {
                                    if (res.status == 403) {
                                        ks.notice("暗号不对哦 T_T", {
                                            color: "red",
                                            time: 1000
                                        })
                                    }
                                }
                            })
                        }
                    })()
                </script>
                <?php print_r('</main>') ?>
                <?php
                $this->need('footer.php');
                exit;
            }
        endif;
        ?>
        <article>
            <h1 style="position: relative"><?php echo $this->date('Y-m-d'); ?>
                <small>(<?php echo $this->date('l'); ?>)</small>
            </h1>
            <div class="paul-note" id="<?php $this->cid() ?>">
                <div class="note-content post-content">
                    <h1 class="post-title">
                        <span><?php $this->title() ?></span><?php if ($this->authorId == $this->user->uid): ?>
                            <small class="post-edit"><a class="edit-link"
                                                        href="<?php $this->options->adminUrl(); ?>write-post.php?cid=<?php echo $this->cid; ?>"
                                                        target="_blank">编辑</a></small>
                        <?php endif; ?></h1>
                    <?php $this->content(); ?>
                </div>
                <?php if ($this->options->author_text) : ?>
                    <div class="note-content">
                        <?php $this->options->author_text(); ?>
                    </div>
                <?php endif; ?>
                <div class="note-inform">
                    <span class="user"><?php $this->author(); ?></span>
                    <span class="views" title="阅读次数 <?php echo get_views_num($this) ?>"><i class="fa fa-leaf"
                                                                                           aria-hidden="true"></i> <?php echo get_views_num($this) ?></span>
                    <?php if ($this->fields->mood): ?><span class="mood" title="心情"><?php echo $this->fields->mood;
                        endif; ?></span>
                    <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/cn/" style="color: currentColor;"
                       target="_blank"><span class="CC BY-NC-SA 3.0 CN"
                                             title="署名-非商业性使用-相同方式共享 3.0 中国大陆 (CC BY-NC-SA 3.0 CN)"><i
                                class="fa fa-creative-commons" aria-hidden="true"></i></span></a>
                </div>
                <div class="note-action">
                    <span class="comment" data-cid="<?php $this->cid(); ?>" data-year="<?php $this->year(); ?>"
                          title="参与评论">评论</span>
                    <span class="like" data-cid="<?php $this->cid();
                    ?>"
                          title="已有 <?php get_like_num($this) ?> 人点赞" <?php if (isLiked($this->cid)) print_r('class="color: red"') ?>><?php get_like_num($this) ?></span>
                </div>
            </div>
        </article>
        <?php $this->need('comments.php') ?>
        <script src="<?php $this->options->themeUrl('src/index.js') ?>"></script>
        <script src="<?php $this->options->themeUrl('src/like.js') ?>"></script>
        <script src="<?php $this->options->themeUrl('src/prism.js') ?>"></script>
        <script>
            (() => {// 为小标题加上锚点
                const postContent = ks.select('.post-content');
                const titleArr = [];
                for (let i = 1; i < 5; i++) {
                    [...postContent.querySelectorAll(`h${i}`)].forEach((item, index) => {

                        const name = item.innerText.slice(-2) === '编辑' ? item.innerText.slice(0, item.innerText.length - 2) : item.innerText;
                        titleArr.push({tier: i, name, top: window.getElementTop(item)})
                    })
                }
                const torTreeWrap = ks.select('#torTree-wrap');
                if (titleArr.length === 1) {
                    return
                }
                let torTreeHTML = ` <div class="torTree-title"><a href="javascript:window.scrollSmoothTo(${titleArr[0].top})">${titleArr.shift().name}</a></div><ul>`;
                for (let item of titleArr) {
                    torTreeHTML = torTreeHTML + `<a href="javascript:window.scrollSmoothTo(${item.top})"><li class="tier-${item.tier}">${item.name}</li></a>`
                }
                torTreeHTML += `</ul>`;
                torTreeWrap.innerHTML = torTreeHTML;
                torTreeWrap.removeAttribute('style')
            })()
        </script>
    </main>

<?php $this->footer(); ?>
<?php $this->need('footer.php'); ?>