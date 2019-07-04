<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function threadedComments($comments, $options)
{
  $commentClass = '';
  if ($comments->authorId) {
    if ($comments->authorId == $comments->ownerId) {
      $commentClass .= ' comment-by-author';
    } else {
      $commentClass .= ' comment-by-user';
    }
  }
  $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
  if ($comments->url) {
    $author = '<a href="' . $comments->url . '"' . '" target="_blank"' . ' rel="external nofollow">' . $comments->author . '</a>';
  } else {
    $author = $comments->author;
  }
  ?>
  <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
  if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
  } else {
    echo ' comment-parent';
  }
  $comments->alt(' comment-odd', ' comment-even');
  echo $commentClass;
  ?>">
    <div id="<?php $comments->theId(); ?>">
      <div class="comments-body">
        <?php $avatar = 'https://secure.gravatar.com/avatar/' . md5(strtolower($comments->mail)) . '?s=80&r=X&d='; ?>
        <img class="avatar" src="<?php echo $avatar ?>" alt="<?php echo $comments->author; ?>"/>
        <div class="line"></div>
        <div class="comment_main">
          <div class="comment_meta">
            <span class="comment_author"><?php echo $author ?></span> <span
              class="comment_time"><?php $comments->date('y-m-d'); ?></span><span
              class="comment_reply"><i class="fa fa-reply" aria-hidden="true" name="回复"><?php $comments->reply() ?></i></span>
          </div>
          <?php $comments->content(); ?>
        </div>
      </div>
    </div>
    <?php if ($comments->children) { ?>
      <div class="comment-children"><?php $comments->threadedComments($options); ?></div><?php } ?>
  </li>
<?php } ?>



<?php $this->comments()->to($comments); ?>
<article class="comment-list">
  <h1><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h1>
  <!--    回复评论框-->

  <div class="reply" id="<?php $this->respondId(); ?>" style="display: none">
    <form method="post" action="<?php $this->commentUrl() ?>" role="form"
          class="reply_form">
      <?php if ($this->allow('comment')): ?>
        <?php if ($this->user->hasLogin()): ?>
          <p><?php _e('登录身份: '); ?><a
              href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
            <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?>
              &raquo;</a>
          </p>
        <?php else: ?>
          <div class="col-3">
            <input type="text" name="author" id="author" placeholder="你叫什么~"
                   value="<?php $this->remember('author'); ?>"
                   required/>
            <input type="text" name="mail" id="mail" placeholder="邮箱~"
                   value="<?php $this->remember('mail'); ?>"
                   required/>
            <input type="text" name="url" id="url" placeholder="网站~"
                   value="<?php $this->remember('url'); ?>"/>
          </div>
        <?php endif; ?>
        <textarea id="text" rows="8" cols="100" name="text" placeholder="回复内容 ☆´∀｀☆"
                  required><?php $this->remember('text'); ?></textarea>

        <div class="submit">
          <button class="btn yellow" id="submit"><i class="fa fa-paper-plane"></i> 提交</button>
          <span class="cancel-comment-reply">
            <?php $comments->cancelReply(); ?>
        </span>
        </div>
      <?php else: ?>
        <p>评论功能暂时关闭</p>
      <?php endif; ?>

    </form>
  </div>

  <?php if ($comments->have()): ?>
    <?php $comments->listComments(); ?>
    <?php $comments->pageNav('&laquo;', '&raquo;'); ?>
  <?php endif; ?>
</article>

<!-- 评论框 -->
<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
  <section class="post-form is-comment">
    <h3><i class="fa fa-comments"></i>评论</h3>
    <div class="note-comments">
      <div id="note-m"></div>
      <?php if ($this->allow('comment')): ?>

        <?php if ($this->user->hasLogin()): ?>
          <p><?php _e('登录身份: '); ?><a
              href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.
            <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
          </p>
        <?php else: ?>
          <input type="text" name="author" id="author" placeholder="你叫什么~"
                 value="<?php $this->remember('author'); ?>"
                 required/>
          <input type="text" name="mail" id="mail" placeholder="邮箱~" value="<?php $this->remember('mail'); ?>"
                 required/>
          <input type="text" name="url" id="url" placeholder="网站~" value="<?php $this->remember('url'); ?>"/>
        <?php endif; ?>
        <textarea id="text" rows="8" name="text" placeholder="谢谢评论 ☆´∀｀☆"
                  required><?php $this->remember('text'); ?></textarea>
        <div class="submit">
          <button class="btn yellow" id="submit"><i class="fa fa-paper-plane"></i> 提交</button>
          <button class="btn red" id="cancel-commit" type="reset"><i class="fa fa-times-circle"></i> 取消
          </button>
        </div>

      <?php else: ?>
        <p>评论功能暂时关闭</p>
      <?php endif; ?>
    </div>
  </section>
</form>
<script>

  (function () {
    // ajax 提交评论实现方法

    // 阻止默认事件
    const ajax_init = () => {
      const form = document.getElementById('comment-form')
      form.onsubmit = e => {
        e.preventDefault()
        post_by_ajax(e, '#comment-form')
      }
      const reply_form = document.querySelector('.reply_form')
      reply_form.onsubmit = e => {
        e.preventDefault()
        post_by_ajax(e, '.reply_form', true)
      }
    }

    comment_init()
    ajax_init()

    // ajax 提交
    function post_by_ajax(e, sel, reply = false) {
      const isComment = document.querySelector('.post-form.is-comment')
      const commentForm = document.querySelector(sel)
      const post_url = e.target.getAttribute('action')

      // 如果是管理员登陆
      if (!document.querySelector('#comment-form #author')) {
        const text = commentForm.querySelector('#text').value
        let data = null

        if (reply) {
          data = {
            text, parent: window.parentId
          }
        } else {
          data = {
            text
          }
        }
        ks.notice('正在提交，请稍等哈', {
          color: 'yellow',
          time: 1000
        })
        ks.ajax({
          url: post_url,
          method: 'POST',
          data,
          success(res) {
            const responseDOM = parser(res.responseText)

            try {
              isComment.classList.contains('active') ? isComment.classList.remove('active') : false
              const needPartten = responseDOM.querySelector('.comment-list').innerHTML
              needPartten === document.querySelector('.comment-list').innerHTML ? ks.notice('请等待审核哦 φ(>ω<*) ', {
                color: 'green',
                time: 1000
              }) : (document.querySelector('.comment-list').innerHTML = needPartten, ks.notice('评论成功了 (〃\'▽\'〃)', {
                color: 'green',
                time: 1000
              }), (reply ? false : window.scrollSmoothTo(document.body.scrollHeight || document.documentElement.scrollHeight)))
              comment_init()
              ajax_init()
            } catch (e) {
              ks.notice(responseDOM.querySelector('.container').innerText, {
                color: 'red',
                time: 1500
              })
            }
          },
          failed(res) {
            console.log(res)
            ks.notice('(；´д｀)ゞ 失败了', {
              color: 'red',
              time: 1500
            })
          }
        })
      } else {
        const author = commentForm.querySelector('#author').value
        const mail = commentForm.querySelector('#mail').value
        const url = commentForm.querySelector('#url').value
        const text = commentForm.querySelector('#text').value

        if (reply) {
          data = {
            author, mail, url, text, parent: window.parentId
          }
        } else {
          data = {
            author, mail, url, text,
          }
        }
        ks.notice('正在提交，请稍等哈', {
          color: 'yellow',
          time: 1000
        })
        ks.ajax({
          method: 'POST',
          url: post_url,
          data,
          success(res) {
            const responseDOM = parser(res.responseText)
            isComment.classList.contains('active') ? isComment.classList.remove('active') : false
            try {
              const needPartten = responseDOM.querySelector('.comment-list').innerHTML
              needPartten === document.querySelector('.comment-list').innerHTML ? ks.notice('请等待审核哦 φ(>ω<*) ', {
                color: 'green',
                time: 1000
              }) : (document.querySelector('.comment-list').innerHTML = needPartten, ks.notice('评论成功了 (〃\'▽\'〃)', {
                color: 'green',
                time: 1000
              }), (reply ? false : window.scrollSmoothTo(document.body.scrollHeight || document.documentElement.scrollHeight)))
              comment_init()
              ajax_init()
            } catch (e) {
              ks.notice(responseDOM.querySelector('.container').innerText, {
                color: 'red',
                time: 1500
              })
            }

          },
          failed(res) {
            console.log(res)
            ks.notice('(；´д｀)ゞ 失败了', {
              color: 'red',
              time: 1500
            })
          }
        })
      }
    }
  })();

  (function () {
    const commentFunction = document.head.querySelector('script[type]')
    const innerHTML = commentFunction.innerHTML
    if (innerHTML.match(/this.dom\('respond-.*?'\)/ig)) {
      const after = innerHTML.replace(/this.dom\('respond-.*?'\)/ig, "this.dom('respond-<?php $this->is('post') ? print_r('post') : print_r('page') ?>-<?php $this->cid() ?>')")
      setTimeout(() => {
        eval(after)
      })
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
                response = this.dom('respond-<?php $this->is('post') ? print_r('post') : print_r('page') ?>-<?php $this->cid() ?>'), input = this.dom('comment-parent'),
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
            var response = this.dom('respond-<?php $this->is('post') ? print_r('post') : print_r('page') ?>-<?php $this->cid() ?>'),
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
      setTimeout(() => {
        eval(script.innerHTML)
      })
    }
  })()
</script>