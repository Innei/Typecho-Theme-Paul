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
</action>
<footer>
    <p>© <?php $this->date('Y') ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->author() ?></a>.</p>
    Design By Paul. Dev By yiny. Theme Paul.
</footer>

<script src="https://cdn.jsdelivr.net/npm/pjax/pjax.min.js"></script>
<script src="<?php $this->options->themeUrl('src/paul.js') ?>"></script>
<script>
    console.log("%c Innei %c https://shizuri.net ","color: #34495e; margin: 1em 0; padding: 5px 0; background: #ecf0f1;", "margin: 1em 0; padding: 5px 0; background: #efefef;");
    <?php $this->options->custom_script();?>
</script>
<?php $this->footer(); ?>
</body>
</html>