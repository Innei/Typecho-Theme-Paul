<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 归档页面
 * @author Innei
 * @package custom
 */
$this->need('header.php');
require_once 'pages.php';

?>


  <main class="is-article">
    <nav class="navigation">
      <a href="<?php $this->options->siteUrl(); ?>">首页</a>
      <a href="<?php echo $GLOBALS['note']; ?>">日记</a>
      <a href="<?php echo $GLOBALS['archive']; ?>" class="active">归档</a>
    </nav>
    <article class="note-content post-content">
      <h1>归档</h1>
      <h2>Category</h2>
      <div class="post-category">
        <!-- 分类 -->
        <?php $this->widget('Widget_Metas_Category_List', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($category); ?>
        <ul>
          <?php while ($category->next()): ?>
            <li>
              <a href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a>
              <div class="category-wrap">
                <div class="more-category">
                  <?php $this->widget('Widget_Archive@' . $category->name, 'pageSize=6&type=category', 'mid=' . $category->mid)->parse('<a href="{permalink}">{title}</a>'); ?>
                </div>
              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>

      <h2>Tag</h2>
      <div class="post-category">
        <!-- 标签 -->
        <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($tags); ?>
        <ul>
          <?php while ($tags->next()): ?>
            <li><a href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a></li>
          <?php endwhile; ?>
        </ul>
      </div>

      <h2>Post</h2>
      <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);
      $year = 0;
      $mon = 0;
      $i = 0;
      $j = 0;
      $output = '<div id="archives">';
      while ($archives->next()):
        $year_tmp = date('Y', $archives->created);
        $mon_tmp = date('m', $archives->created);
        $y = $year;
        $m = $mon;
        if ($year != $year_tmp && $year > 0) $output .= '</ul>';
        if ($year != $year_tmp) {
          $year = $year_tmp;
          $output .= '<h4>' . $year . ' 年</h4><ul>'; //输出年份
        }
        $output .= '<li>' . date('m月d日：', $archives->created) . '<a href="' . $archives->permalink . '">' . $archives->title . '</a></li>'; //输出文章日期和标题
      endwhile;
      echo $output;
      ?>

    </article>
  </main>

<?php $this->need('footer.php') ?>