<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 语录页面
 *
 * @package custom
 */
$this->need('header.php');
require_once 'pages.php';

?>


<main id="say">
    <nav class="navigation">
        <a href="<?php echo $GLOBALS['note']; ?>">日记</a>
        <?php if ($this->options->blog_url): ?> <a href="<?php $this->options->blog_url(); ?>" target="_blank">
                博文</a><?php endif; ?>
        <a href="<?php echo $GLOBALS['say']; ?>" class="active">语录</a>
    </nav>
    <article class="paul-say">
        <?php
        $says = Paul::parse_says($this->content);
        foreach ($says as $say => $avatar){
           echo '<blockquote><p>' . $avatar . '</p><p class="author"> ' . $say . '</p></blockquote>';
        }
        ?>
    </article>
</main>

<?php $this->need('footer.php'); ?>
