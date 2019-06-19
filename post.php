<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
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
  <article>
        <h1 style="position: relative"><?php echo $this->date('Y-m-d'); ?>
            <small>(<?php echo $this->date('l'); ?>)</small>
        </h1>
        <div class="paul-note" id="<?php $this->cid() ?>">
            <div class="note-content post-content">
                <h1 class="post-title"><?php $this->title() ?></h1>
                <?php $this->content(); ?>
            </div>
            <?php if ($this->options->author_text) : ?>
                <div class="note-content">
                    <?php $this->options->author_text(); ?>
                </div>
            <?php endif; ?>
            <div class="note-inform">
                <span class="user"><?php $this->author(); ?></span>
                <span class="views" title="阅读次数 <?php echo $this->views ?>"><i class="fa fa-leaf" aria-hidden="true"></i> <?php echo $this->views ?></span>
                <span class="words" title="字数 <?php echo get_words($this) ?>"><i class="fa fa-file-word-o" aria-hidden="true"></i> <?php echo get_words($this) ?></span>
                <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/cn/" style="color: currentColor;" target="_blank"><span class="CC BY-NC-SA 3.0 CN" title="署名-非商业性使用-相同方式共享 3.0 中国大陆 (CC BY-NC-SA 3.0 CN)"><i class="fa fa-cc" aria-hidden="true"></i></span></a>
            </div>
            <div class="note-action">
                <span class="comment" data-cid="<?php $this->cid(); ?>" data-year="<?php $this->year(); ?>" title="参与评论">评论</span>
                <span class="like" data-cid="<?php $this->cid();
                                                ?>" title="已有 <?php get_like_num($this) ?> 人点赞"><?php get_like_num($this) ?></span>
            </div>
        </div>
    </article>
    <?php $this->need('comments.php') ?>
    <script src="<?php $this->options->themeUrl('src/index.js') ?>"></script>
    <script>
        (function() {
            // 点赞实现 ajax
            const Like_btn = document.querySelectorAll('.like');
            for (let el of Like_btn) {
                el.onclick = function(e) {
                    const that = this;
                    ks.ajax({
                        method: "POST",
                        data: {
                            type: "up",
                            cid: this.getAttribute('data-cid'),
                            cookie: document.cookie,

                        },
                        url: "<?php $this->options->siteUrl(); ?>index.php/action/void_like?up",
                        success: function(res) {
                            if (JSON.parse(res.responseText)['status'] === 1) {
                                that.innerHTML = parseInt(that.innerHTML) + 1;
                                ks.notice("感谢你的点赞~", {
                                    color: "green",
                                    time: 1500
                                });
                                that.onclick = function() {
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
                        failed: function(res) {
                            ks.notice("FXXK！提交出错了！", {
                                color: "red"
                            });
                        }
                    })
                }
            }
        }())
    </script>
    <script src="<?php $this->options->themeUrl('src/prism.js') ?>"></script>
  <script>
    (() => {// 为小标题加上锚点
      const postContent = ks.select('.post-content')
      const titleArr = []
      for (let i = 1; i < 5; i++) {
        [...postContent.querySelectorAll('h' + i)].forEach((item, index) => {

          titleArr.push({tier: i, name: item.innerText, top: window.getElementTop(item)})
        })
      }
      const torTreeWrap = ks.select('#torTree-wrap')
      if (titleArr.length === 1) {
        return
      }
      let torTreeHTML = ` <div class="torTree-title"><a href="javascript:window.scrollSmoothTo(${titleArr[0].top})">${titleArr.shift().name}</a></div><ul>`
      for (let item of titleArr) {
        torTreeHTML = torTreeHTML + `<a href="javascript:window.scrollSmoothTo(${item.top})"><li class="tier-${item.tier}">${item.name}</li></a>`
      }
      torTreeHTML += `</ul>`
      torTreeWrap.innerHTML = torTreeHTML
      torTreeWrap.removeAttribute('style')
    })()
  </script>
    <script>
        (function () {
            const commentFunction = document.querySelector('head').querySelector('script[type]')
            const innerHTML = commentFunction.innerHTML
            if (innerHTML.match(/this.dom\('respond-.*?'\)/ig)) {
                const after = innerHTML.replace(/this.dom\('respond-.*?'\)/ig, "this.dom('respond-post-<?php $this->cid() ?>')")
                eval(after)
            } else {
              const script = document.createElement('script')
              script.innerHTML = `
(function () {
    window.TypechoComment = {
        dom : function (id) {
            return document.getElementById(id);
        },

        create : function (tag, attr) {
            var el = document.createElement(tag);

            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }

            return el;
        },

        reply : function (cid, coid) {
            var comment = this.dom(cid), parent = comment.parentNode,
                response = this.dom('respond-post-<?php $this->cid() ?>'), input = this.dom('comment-parent'),
                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];

            if (null == input) {
                input = this.create('input', {
                    'type' : 'hidden',
                    'name' : 'parent',
                    'id'   : 'comment-parent'
                });

                form.appendChild(input);
            }

            input.setAttribute('value', coid);

            if (null == this.dom('comment-form-place-holder')) {
                var holder = this.create('div', {
                    'id' : 'comment-form-place-holder'
                });

                response.parentNode.insertBefore(holder, response);
            }

            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';

            if (null != textarea && 'text' == textarea.name) {
                textarea.focus();
            }

            return false;
        },

        cancelReply : function () {
            var response = this.dom('respond-post-<?php $this->cid() ?>'),
            holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');

            if (null != input) {
                input.parentNode.removeChild(input);
            }

            if (null == holder) {
                return true;
            }

            this.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
            return false;
        }
    };
})();
`
              document.head.insertBefore(script, commentFunction)
              eval(script.innerHTML)
            }

        })()
    </script>
</main>

<?php $this->footer(); ?>
<?php $this->need('footer.php'); ?>