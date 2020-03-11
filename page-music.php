<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 音乐页面
 *
 * @author innei
 * @package custom
 */
require_once 'pages.php';
require_once 'functions.php';
$this->need('header.php');

$json = json_decode($this->text,true);
$par = $json['par'];
$cookie = $json['cookie'];
$token = $json['token'];
$key = $json['key'];

$data = Paul::get_163_music($par, $key, $token, $cookie);
$week_data = $data['0'];
$all_data = $data['1'];

?>
<main>
    <nav class="navigation">
        <a href="<?php $this->options->siteUrl(); ?>">首页</a>
        <a href="<?php echo $GLOBALS['music'] ?>" class="active">歌单</a>
        <a href="<?php echo $GLOBALS['bangumi'] ?>">追番</a>
    </nav>
    <section class="paul-music">
        <div class="music-cover">
            <div class="fixed-cover">
                <img src="https://p3.music.126.net/4HGEnXVexEfBACKi7wbq8A==/3390893860854924.jpg"/>
                <h3>周排行</h3>
            </div>
        </div>
        <div class="music-list">
            <ul class="clear">
                <?php $i = 0;
                foreach ($week_data as $key => $item): if ($i++ < 10): ?>
                    <li data-sid="<?php echo $item['id'] ?>">
                        <span class="num"><?php echo ($key + 1) ?></span><?php echo $item['name']; ?>
                        <time><?php echo $item['time'] ?></time>
                    </li>
                <?php endif;endforeach; unset($key, $item); ?>
            </ul>
        </div>
    </section>
    <section class="paul-music">
        <div class="music-cover">
            <div class="fixed-cover">
                <img src="https://p1.music.126.net/xTCCKfCJuEh2ohPZDNMDLw==/19193074975054252.jpg"/>
                <h3>总排行</h3>
            </div>
        </div>
        <div class="music-list">
            <ul class="clear">
                <?php
                foreach ($all_data as $key => $item): ?>
                    <li data-sid="<?php echo $item['id'] ?>">
                        <span class="num"><?php echo ($key + 1) ?></span><?php echo $item['name']; ?>
                        <time><?php echo $item['time'] ?></time>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <script>
        (function () {
            try {
                paul_music.setList();
            } catch (e) {
                document.addEventListener('load', () => paul_music.setList())
            }
        })();
    </script>
</main>
<?php $this->need('footer.php') ?>
