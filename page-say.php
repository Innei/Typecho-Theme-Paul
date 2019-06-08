<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 语录页面
 *
 * @package custom
 */
$this->need('header.php');
?>


<main id="say">
    <nav class="navigation">
        <a href="/index.php/note.html">日记</a>
        <a href="<?php $this->options->blog_url(); ?>" target="_blank">博文</a>
        <a href="/index.php/saying.html" class="active">语录</a>
    </nav>
    <article class="paul-say">
        <?php

        $content = $this->content;
        // 匹配每行 放入数组

        preg_match_all('/<p>(.*?)<\/p>/', $content, $says);

        $content = array();
        foreach ($says['1'] as $key => $say) {
            $content[] = preg_split('/(----|---|--|————|——)/', $say);  /*匹配提取----|---|--|————|——后的内容*/

        }
        $author_names = array();
        $say_bodys = array();
        foreach ($content as $key => $value) {
            if (count($value) != 1) {
                $author_names[] = '————' . array_pop($value);   // 分割后数量如果为1 说明作者提取失败
            } else {
                $author_names[] = '';  // 失败情况加入处理
            }

            $say_bodys[] = implode("——", $value);  // 合并多余的分割项
        }

        foreach ($say_bodys as $key => $say) {
            echo '<blockquote><p>' . $say . '</p><p class="author"> ' . $author_names[$key] . '</p></blockquote>';
        }
        ?>
    </article>
</main>

<?php $this->need('footer.php'); ?>
