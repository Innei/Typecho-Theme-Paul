<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<player>
    <div class="player-left">
        <div class="player-cover">
            <div class="cover-img"
                 style="background-image: url()"></div>
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
</footer>

<script src="https://cdn.jsdelivr.net/npm/pjax/pjax.min.js"></script>
<script src="<?php $this->options->themeUrl('src/kico.js')?>"></script>
<script src="<?php $this->options->themeUrl('src/paul.js')?>"></script>
<script>
<?php $this->options->custom_script();?>
</script>

</body>
</html>