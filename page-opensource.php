<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 开源页面
 *
 * @author innei
 * @package custom
 */
$this->need('header.php');
require_once 'pages.php';
?>
<main style="overflow:hidden">
    <nav class="navigation">
        <a href="<?php echo $GLOBALS['project'] ?>">精选</a>
        <a href="<?php echo $GLOBALS['opensource'] ?>" class="active">开源</a>
    </nav>
    <div id="loading" class="jsonp-loading">
        <div class="box"></div>
    </div>
    <div id="opensource-wrap" style="opacity: 0">
        <section class="me github">
            <div class="my-avatar">
                <img src="">
            </div>
            <div class="my-info">
                <h1><span></span>
                    <svg width="100%" height="3.5rem">
                        <text text-anchor="start" x="0" y="2.2rem" class="text text-1">
                        </text>
                        <text text-anchor="start" x="0" y="2.2rem" class="text text-2">
                        </text>
                        <text text-anchor="start" x="0" y="2.2rem" class="text text-3">
                        </text>
                        <text text-anchor="start" x="0" y="2.2rem" class="text text-4">
                        </text>
                    </svg>
                </h1>
                <p></p>
                <div class="social-icons">
                </div>
        </section>
        <section class="repos" style="overflow:hidden">
            <div class="repo-wrap">
                <ul id="repo-list">
                    <li></li>
                </ul>
            </div>
        </section>
    </div>
    <?php if ($this->options->github_username): ?>
    <script>
        window.githubID = "<?php $this->options->github_username(); ?>"
    </script>
    <script src="<?php $this->options->themeUrl("src/github.js") ?>"></script>
    <?php endif;?>
</main>

<?php $this->need('footer.php') ?>