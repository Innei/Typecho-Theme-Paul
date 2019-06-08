<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<head>
    <meta charset="UTF-8">
    <title><?php $this->archiveTitle(array(
            'category' => _t('%s'),
            'search' => _t('含关键词 %s 的文章'),
            'tag' => _t('标签 %s 下的文章'),
            'author' => _t('%s 发布的文章')
        ), '', ' - ');
        $this->options->title(); ?></title>
    <link href="<?php $this->options->themeUrl('src/kico.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?php $this->options->themeUrl('src/paul.css') ?>" rel="stylesheet" type="text/css">
    <?php if ($this->options->favicon): ?>
        <link rel="icon" href="<?php $this->options->favicon(); ?>" sizes="192x192"/>
    <?php else: ?>
        <link rel="icon" href="<?php $this->options->themeUrl('src/img/icon.jpg'); ?>" sizes="192x192"/>
    <?php endif; ?>
    <?php if ($this->options->background): ?>
        <style>body:before {
                content: '';
                background-image: url(<?php $this -> options -> background(); ?>)
            }</style>
    <?php endif; ?>
    <link rel="alternate" type="application/rss+xml" title="奇趣保罗的日记 RSS" href="https://paul.ren/feed">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1">
    <meta property="og:site_name" content="<?php $this->options->title(); ?>">
    <meta property="og:title" content="<?php $this->archiveTitle(array(
        'category' => _t('%s'),
        'search' => _t('含关键词 %s 的文章'),
        'tag' => _t('标签 %s 下的文章'),
        'author' => _t('%s 发布的文章')
    ), ""); ?>"/>
    <?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw='); ?>
    <link href="https://cdn.jsdelivr.net/gh/FortAwesome/Font-Awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
</head>

<body class="">
<header>
    <toggle></toggle>
    <nav>
        <a href="<?php $this->options->siteUrl(); ?>">
            <svg viewBox="0 0 200 200">
                <path fill="currentColor"
                      d="M22.8,42.4c0,0,14.4,2.4,20.8,2S60,39.6,60,39.6s0.8-13.6,44.4-14c58-0.4,71.6,61.6,71.6,61.6s4.4,19.2,12,27.6c5.2,3.6,11.6,2,11.6,2s-9.2,6-14.4,7.2c-5.2,0.8-12.8-1.6-12.8-1.6L166,148l-6-6.8l-2,0.8l-4.4,9.2V142l-2,0.8c0,0-1.6,8-2.8,12s-4.8,8.8-4.8,8.8l-3.6-4.8c0,0-0.4,2.4-1.6,3.6c-1.2,1.2-2.8,2.8-2.8,2.8l-2-3.6c0,0-12,10.8-37.2,10.8s-40-12-40-12l-2.8,2.8l-6-12.8c0,0-5.2-3.6-7.2-7.6s-0.8-7.2-0.8-7.2l-7.2-10l-4.4,5.6c0,0-3.2-6.4-2.8-9.2c0.4-2.8,0.8-7.2,0.8-7.2S19.2,114,12,112c-6.8-2-12-9.2-12-9.2s6,2,11.6-2s20.8-28.4,20.8-28.4l12.8-16.8c0,0-5.6-0.4-10.8-2.8C29.2,50.4,22.8,42.4,22.8,42.4z M55.2,90l-4.4,40.4c0,0,3.2,7.6,5.2,12c1.6,4.4,2,7.6,2,7.6s6,14,39.6,14.8c42-0.8,53.2-32,53.2-32s-6-14.8-10.4-18.8c-4-4-27.2-16.4-27.2-16.4s3.2,8,4.4,15.6c1.2,7.6,1.6,13.6,1.6,13.6s-11.6-3.2-15.2-6.4c-3.6-3.2-8.8-10-8.8-10s0,3.6,0.8,7.2s2.8,5.6,2.8,5.6s-10.4-5.2-15.6-14.8c-5.6-9.6-9.2-24-9.2-24l-6.4,36.8L55.2,90z"></path>
            </svg>
            <span><?php $this->user->name() ?></span></a>
        <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
        <?php while ($pages->next()): ?>
            <?php if ($pages->slug == 'note'): ?>
                <a href="<?php $pages->permalink(); ?>"><i class="fa fa-book"></i><span>日记</span></a>

            <?php elseif ($pages->slug == 'project'):?>
        <a href="<?php $pages->permalink();?>"><i class="fa fa-flask"></i><span>项目</span></a>

        <?php endif; endwhile; ?>

        <!--        <a href="/music"><i class="fa fa-star"></i><span>收藏</span></a>-->
    </nav>
</header>
