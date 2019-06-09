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
            <?php $avatar = 'https://secure.gravatar.com/avatar/' . md5(strtolower($comments->mail)) . '?s=80&r=X&d='; ?>
            <img class="avatar" src="<?php echo $avatar ?>" alt="<?php echo $comments->author; ?>"/>
            <div class="comment_main">
                <?php $comments->content(); ?>
                <div class="comment_meta">
                    <span class="comment_author"><?php echo $author ?></span> <span
                            class="comment_time"><?php $comments->date(); ?></span><span
                            class="comment_reply"><?php $comments->reply(); ?></span>
                </div>
            </div>
        </div>
        <?php if ($comments->children) { ?>
            <div class="comment-children"><?php $comments->threadedComments($options); ?></div><?php } ?>
    </li>
<?php } ?>


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
                    <input type="text" name="url" id="url" placeholder="网站~" value="<?php $this->remember('url'); ?>"
                           required/>
                <?php endif; ?>
                <textarea id="text" rows="8" name="text" placeholder="内容："
                          required><?php $this->remember('text'); ?></textarea>
                <div class="submit">
                    <button class="btn yellow" id="submit"><i class="fa fa-paper-plane"></i> 提交</button>
                </div>

            <?php else: ?>
                <p>评论功能暂时关闭</p>
            <?php endif; ?>
        </div>
    </section>
</form>
<article class="comment-list">
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
        <h1><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h1>
        <?php $comments->listComments(); ?>
    <?php endif; ?>
</article>
