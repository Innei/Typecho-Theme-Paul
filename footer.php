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
        <div class="prev"></div>
        <div class="toggle"></div>
        <div class="next"></div>
    </div>
</player>
<action>
    <button class="top"><i class="fa fa-arrow-up"></i></button>
    <button class="player"><i class="fa fa-headphones"></i></button>
    <button class="post-new"><i class="fa fa-plus"></i></button>
</action>
<footer>
    <p>© <?php $this->date('Y') ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->author() ?></a>.</p>
  Design By <a href="https://paul.ren" target="_blank">Paul</a>. Dev By <a href="https://shizuri.net" target="_blank">yiny</a>.
  Theme <a href="https://github.com/Innei/Typecho-Theme-Paul" target="_blank">Paul</a>.
</footer>

<script src="https://cdn.jsdelivr.net/npm/pjax/pjax.min.js"></script>
<script src="<?php $this->options->themeUrl('src/pjax.js') ?>"></script>
<script src="<?php $this->options->themeUrl('src/paul.js') ?>"></script>
<script>
    <?php if($this->user->hasLogin()): ?>
    window.writeNew = () => {
      // TODO ajax 提交文章
      ks.select('.post-new').onclick = () => {
        window.open('<?php $this->options->adminUrl() ?>write-post.php')
      }
    }
    <?php else: ?>
    window.writeNew = () => {
      ks.select('.post-new').onclick = () => {
        ks.notice("请先登录 ❥(ゝω・✿ฺ)", {
          color: "green",
          time: 1000
        })
      }
    }
    <?php endif; ?>
    window.writeNew()
    document.addEventListener('pjax:complete', window.writeNew)
    console.log("%c Innei %c https://shizuri.net ", "color: #34495e; margin: 1em 0; padding: 5px 0; background: #ecf0f1;", "margin: 1em 0; padding: 5px 0; background: #efefef;")
    <?php $this->options->custom_script();?>
</script>
<?php $this->footer(); ?>
</body>
</html>