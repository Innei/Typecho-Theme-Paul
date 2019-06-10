<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 音乐页面
 *
 * @author innei
 * @package custom
 */

$this->need('header.php');
require_once 'functions.php';
?>

<main>
    <nav class="navigation">
        <a href="/music" class="active">歌单</a>
    </nav>
    <section class="paul-music">
        <div class="music-cover">
            <div class="fixed-cover fixed">
                <img src="https://p3.music.126.net/4HGEnXVexEfBACKi7wbq8A==/3390893860854924.jpg">
                <h3>周排行</h3>
            </div>
        </div>
        <div class="music-list">
            <ul class="clear">

            </ul>
        </div>
    </section>
    <section class="paul-music">
        <div class="music-cover">
            <div class="fixed-cover">
                <img src="https://p1.music.126.net/xTCCKfCJuEh2ohPZDNMDLw==/19193074975054252.jpg">
                <h3>总排行</h3>
            </div>
        </div>
        <div class="music-list">
            <ul>
            </ul>
        </div>
    </section>
    <section class="paul-music">
        <div class="music-cover">
            <div class="fixed-cover">
                <img src="https://p1.music.126.net/9XFiHHJDd4gxR9lyo7wwlA==/3404088000557356.jpg?param=300y300">
                <h3>宅博士喜欢的音乐</h3>
            </div>
        </div>
        <div class="music-list">
            <ul class="clear">

            </ul>
        </div>
    </section>
    <section class="paul-music">
        <div class="music-cover">
            <div class="fixed-cover">
                <img src="https://p1.music.126.net/z5doSag_geBVx8antbb3sg==/3254554421600561.jpg?param=300y300">
                <h3>纯音乐</h3>
            </div>
        </div>
        <div class="music-list">
            <ul class="clear">

            </ul>
        </div>
    </section>


    <section class="comments" id="comment">

    </section>
</main>

<?php $this->needer('footer.php') ?>
