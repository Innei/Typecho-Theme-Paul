<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 日记页面
 *
 * @package custom
 */
$this->need('header.php');
require_once 'functions.php';
define('__TYPECHO_DEBUG__', true);
?>

    <main class="is-article">
        <nav class="navigation">
            <a href="/index.php/note.html" class="active">日记</a>
            <?php if ($this->options->blog_url): ?><a href="<?php $this->options->blog_url(); ?>" target="_blank">博文</a><?php endif ?>
            <?php  ?><a href="/index.php/saying.html">语录</a>
        </nav>
        <article>
            <?php
            $this->widget('Widget_Contents_Post_Recent')->to($posts);
            while ($posts->next()):
                ?>
                <h1><?php echo date('Y-m-d', $posts->created); ?>
                    <small>(<?php echo date('l', $posts->created); ?>)</small>
                </h1>
            <div class="paul-note" id="<?php $posts->cid(); ?>">
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
<!--                    <span class="like" data-cid="--><?php //$posts->cid(); ?><!--" title="已有 0 人点赞">0</span>-->
                </div></div><?php endwhile; ?>


            <section class="note-navigator"><a class="btn black next" href="//paul.ren/note/2"
                                               data-pjax-state="">下一页</a></section>
        </article>
       <!-- <section class="post-form is-comment">
            <h3><i class="fa fa-comments"></i>评论</h3>
            <div class="note-comments">
                <div id="note-m"></div>
                <p>评论功能暂时关闭</p>
            </div>
        </section>-->
        <section class="post-form is-note">
            <h3><i class="fa fa-edit"></i>编写新日记</h3>
            <textarea id="content" rows="8" placeholder="内容："></textarea>
            <select name="mood">
                <option value="0">心情如何？</option>
                <option value="1">开心</option>
                <option value="2">兴奋</option>
                <option value="3">紧张</option>
                <option value="4">无聊</option>
                <option value="5">难过</option>
                <option value="6">愤怒</option>
                <option value="7">惊讶</option>
                <option value="8">郁闷</option>
            </select>
            <input type="text" id="music" placeholder="音乐：" hidden="">
            <input type="password" id="pwd" placeholder="暗号：">
            <input type="file" id="photo" hidden="">
            <div class="add clearfix">
                <label class="add-photo" ks-meta="添加图片" for="photo"><i class="fa fa-image"></i></label>
                <label class="add-music" ks-meta="添加音乐"><i class="fa fa-headphones"></i></label>
                <label class="add-code" ks-meta="添加代码"><i class="fa fa-code"></i></label>
                <label class="add-hidden" ks-meta="添加隐藏内容"><i class="fa fa-eye-slash"></i></label>
            </div>
            <div class="submit">
                <button class="btn yellow" id="submit"><i class="fa fa-paper-plane"></i> 提交</button>
            </div>
            -->
        </section>
    </main>

<?php $this->need('footer.php'); ?>