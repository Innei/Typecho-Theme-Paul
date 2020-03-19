<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<player>
    <div class="player-left">
        <div class="player-cover">
            <div class="cover-img"
                 style="background-image: url(<?php $this->options->themeUrl('src/img/9.jpg') ?>)"></div>
        </div>
        <div class="player-info">
            <span class="title">奇趣音乐盒</span>
            <span class="artist">技术源于 Kico Player</span>
        </div>
    </div>
    <div class="player-center">
        <div class="player-lyric">
            <span>Emmm，这里是歌词君</span>
        </div>
        <div class="player-bar">
            <div class="loaded"></div>
            <div class="played"></div>
        </div>
    </div>
    <div class="player-right">
        <div class="prev"></div><div class="toggle"></div><div class="next"></div>
    </div>
</player>
<div class="login login-action" id="login">
    <form action="<?php $this->options->loginAction() ?>" method="post" id="want-login">
        <input type="text" name="name" id="login-name" placeholder="名字"/>
        <input type="password" name="password" id="login-password" placeholder="密码"/>
        <button class="btn yellow" id="login-submit">biubiu</button>
    </form>
</div>
<section class="post-form is-note">
    <form action="<?php $security = Typecho_Widget::widget('Widget_Security');
    $security->index('/action/contents-post-edit'); ?>" method="post" id="edit-form">
        <h3><i class="fa fa-edit"></i>编写新日记</h3>
        <input type="text" id="edit-title" placeholder="标题："/>
        <textarea id="content" rows="8" placeholder="内容："
                  style="margin-top: 0; margin-bottom: 16px; height: 60vh;"></textarea>
        <select name="cate" id="edit-cate">
            <?php
            Typecho_Widget::widget('Widget_Metas_Category_List')->to($category);
            while ($category->next()): // 需要 mid name
                ?>
                <option value="<?php $category->mid() ?>"><?php $category->name() ?></option>
            <?php endwhile; ?>
        </select>
        <div class="submit">
            <button class="btn yellow" id="edit-submit"><i class="fa fa-paper-plane"></i> 提交</button>
            <button class="btn red" id="edit-cancel" type="reset"><i class="fa fa-times-circle"></i> 取消
            </button>
        </div>
    </form>
</section>

<action>
    <button class="top"><i class="fa fa-arrow-up"></i></button>
    <button class="player"><i class="fa fa-headphones"></i></button>
    <button class="post-new"><i class="fa fa-plus"></i></button>
</action>
<footer>
    <p>© <?php $this->date('Y') ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->author() ?></a>.</p>
    Design By <a href="https://paul.ren" target="_blank">Paul</a>. Dev By <a href="https://Innei.ren" target="_blank">Innei</a>.
    Theme <a href="https://github.com/Innei/Typecho-Theme-Paul" target="_blank">Paul</a>.
</footer>

<script src="https://cdn.jsdelivr.net/npm/pjax/pjax.min.js"></script>
<script src="<?php $this->options->themeUrl('src/paul.js') ?>"></script>
<script>
    const postNew = document.querySelector('.post-new')
    window.writeNew = () => {
        const editFrom = document.getElementById('edit-form')
        editFrom.parentNode.classList.contains("active") ? editFrom.parentNode.classList.remove("active") : editFrom.parentNode.classList.add("active")
        //  ajax 提交文章
        const submit = document.getElementById('edit-submit')
        const url = editFrom.getAttribute('action')
        editFrom.addEventListener('submit', e => e.preventDefault())
        document.getElementById('edit-cancel').onclick = () => editFrom.parentNode.classList.remove("active")
        submit.onclick = e => {
            const title = document.getElementById('edit-title').value
            const text = document.getElementById("content").value
            const cate = document.getElementById('edit-cate').value
            const data = {
                title, text, markdown: 1, "category[]": cate, visibility: "publish", allowComment: 1,
                allowPing: 1,
                allowFeed: 1,
                do: "publish",
                timezone: 28800
            }
            ks.ajax({
                url,
                data,
                method: "POST",
                success(res) {
                    if (res.responseText.match(/manage-posts/)) {
                        ks.notice("提交成功啦", {
                            color: "green",
                            time: 2000
                        })
                        editFrom.parentNode.classList.remove('active')
                        document.body.classList.add("loading")
                        ks.ajax({
                            url: "<?php echo $GLOBALS['note'] ?>",
                            method: "GET",
                            success(res) {
                                setTimeout(() => {
                                    const html = window.parser(res.responseText)
                                    const mainTag = document.querySelector('main')
                                    mainTag.innerHTML = html.querySelector('main').innerHTML
                                    mainTag.classList.add("is-article")
                                    pjax.refresh(mainTag)
                                    document.body.classList.remove("loading")
                                    window.history.pushState({}, html.querySelector('title').innerText, "<?php echo $GLOBALS['note'] ?>")
                                    window.scrollSmoothTo(0)
                                    paul.init()
                                }, 2000)
                            },
                            failed(res) {
                                ks.notice("网络连接异常！", {
                                    color: "red"
                                })
                                document.body.classList.remove("loading")
                            }
                        })
                    }
                },
                failed(res) {
                    ks.notice("提交失败了, T_T ", {
                        color: "red",
                    })
                }
            })
        }
    }
    window.login = () => {
        const login = document.getElementById('login')
        ks.notice("我无法确定你的是我的主人呐 ❥(ゝω・✿ฺ)", {
            color: "green",
            time: 2000
        })
        login.classList.contains('active') ? login.classList.remove('active') : login.classList.add('active')
        // 监听登陆
        loginFn()
    }
    const loginFn = () => {
        const form = document.getElementById('want-login')
        form.addEventListener('submit', e => e.preventDefault())
        const submit = document.getElementById('login-submit')
        submit.onclick = () => ks.ajax({
            url: form.getAttribute('action'),
            data: {
                name: document.getElementById('login-name').value,
                password: document.getElementById('login-password').value
            },
            method: "POST",
            success(res) {
                if (res.responseURL === "<?php $this->options->adminUrl() ?>") {
                    ks.notice("欢迎回来，主人", {
                        color: "yellow",
                        time: 2000
                    })
                    form.parentNode.classList.remove('active')
                    postNew.onclick = window.writeNew
                    // 重载组件
                    ks.ajax({
                        url: window.location.href,
                        method: "GET",
                        success(res) {
                            const domTree = parser(res.responseText)

                            // 重载导航栏
                            const nav = document.querySelector('header nav')
                            nav.innerHTML = domTree.querySelector('header nav').innerHTML
                            pjax.refresh(nav)

                            // TODO 其他重载写这里
                        }
                    })
                } else {
                    ks.notice("你不是我的主人，哼", {
                        color: "red"
                    })
                }
            },
            failed(res) {
                console.log(res.status)
                ks.notice("出错了 (|||ﾟдﾟ)", {
                    color: "red",
                    time: 2000
                })
            }
        })
    }
    <?php if($this->user->hasLogin()): ?>
    postNew.onclick = window.writeNew
    <?php else: ?>
    postNew.onclick = window.login
    <?php endif; ?>
    document.addEventListener('pjax:complete', function () {
        <?php if ($this->user->hasLogin()): ?>
        document.querySelector('.post-new').onclick = postNew.onclick
        <?php else: ?>
        document.querySelector('.post-new').onclick = postNew.onclick = window.login
        <?php endif; ?>
    })

    console.log("%c Innei %c https://innei.ren ", "color: #34495e; margin: 1em 0; padding: 5px 0; background: #ecf0f1;", "margin: 1em 0; padding: 5px 0; background: #efefef;")
</script>
<script src="https://cdn.jsdelivr.net/gh/rikumi/imouse@master/dist/index.js"></script>
<script>
  window.addEventListener('DOMContentLoaded', () => IMouse.default.init({
      defaultBackgroundColor: 'rgba(1, 80, 111, .1)',
      activeBackgroundColor: 'rgba(1, 80, 111, .15)',
    }))
</script>
<?php $this->options->custom_script(); ?>
<?php $this->footer(); ?>
</body>
</html>
