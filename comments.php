<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if ($this->user->hasLogin()): ?>
    <p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.
        <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
<?php else: ?>
    <input type="text" name="author" id="author" placeholder="你叫什么~" value="<?php $this->remember('author'); ?>"
           required/>
    <input type="text" name="mail" id="mail" placeholder="邮箱~" value="<?php $this->remember('mail'); ?>" required/>
    <input type="text" name="url" id="url" placeholder="网站~" value="<?php $this->remember('url'); ?>" required/>
<?php endif; ?>
    <textarea id="text" rows="8" name="text" placeholder="内容：" required><?php $this->remember('text'); ?></textarea>
    <div class="submit">
        <button class="btn yellow" id="submit"><i class="fa fa-paper-plane"></i> 提交</button>
    </div>
