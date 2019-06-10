<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<player>
    <div class="player-left">
        <div class="player-cover">
            <div class="cover-img"
                 style="background-image: url(https://p3.music.126.net/081FaIfm2HSZEyfcLuUixg==/109951163322839040.jpg?param=250y250)"></div>
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
    <p>© 2019 <a href="https://paugram.com" target="_blank">Dreamer-Paul</a>.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/pjax/pjax.min.js"></script>
<script src="<?php $this->options->themeUrl('src/kico.js')?>"></script>
<script src="<?php $this->options->themeUrl('src/paul.js')?>"></script>
<script>

</script>

</body>
</html>