<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('until/until.php') ?>
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
                <span class="views" title="阅读次数 <?php echo get_views_num($this) ?>"><i class="fa fa-leaf" aria-hidden="true"></i> <?php echo get_views_num($this) ?></span>
<!--                <span class="words" title="字数 --><?php //echo get_words($this) ?><!--"><i class="fa fa-file-word-o" aria-hidden="true"></i> --><?php //echo get_words($this) ?><!--</span>-->
                <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/cn/" style="color: currentColor;" target="_blank"><span class="CC BY-NC-SA 3.0 CN" title="署名-非商业性使用-相同方式共享 3.0 中国大陆 (CC BY-NC-SA 3.0 CN)"><i class="fa fa-creative-commons" aria-hidden="true"></i></span></a>
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
    <?php $this->need('until.php') ?>
    <script src="<?php $this->options->themeUrl('src/prism.js') ?>"></script>
  <script>
    (() => {// 为小标题加上锚点
      const postContent = ks.select('.post-content');
      const titleArr = [];
      for (let i = 1; i < 5; i++) {
        [...postContent.querySelectorAll('h' + i)].forEach((item, index) => {

          titleArr.push({tier: i, name: item.innerText, top: window.getElementTop(item)})
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