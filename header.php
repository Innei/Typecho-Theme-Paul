<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (isset($_POST['action']) and $_POST['action']){
  echo $this->options->loginAction;
  exit;
}
require_once 'pages.php';
?>
<html lang="zh-cn">
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
    <link href="<?php $this->options->themeUrl('src/main.css') ?>" rel="stylesheet" type="text/css">
    <?php if ($this->is('page') && ($this->template == "page-bangumi.php" || $this->template == "page-music.php")): ?>
        <meta name="referrer" content="no-referrer"/>
    <?php else: ?>
        <meta name="referrer" content="origin-when-cross-origin"/>
    <?php endif; ?>
    <script src="<?php $this->options->themeUrl('src/kico.js') ?>"></script>
  <script src="<?php $this->options->themeUrl('src/pre.js') ?>"></script>
    <?php if ($this->options->favicon): ?>
        <link rel="icon" href="<?php $this->options->favicon(); ?>" sizes="192x192"/>
    <?php else: ?>
        <link rel="icon" href="<?php $this->options->themeUrl('src/img/avatar.png'); ?>" sizes="192x192"/>
    <?php endif; ?>
    <?php if ($this->options->background): ?>
        <style>body:before {
                content: '';
                background-image: url(<?php $this -> options -> background(); ?>)
            }</style>
    <?php endif; ?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
    <style>
        <?php $this->options->custom_css();?>
    </style>
</head>

<body>
<header>
    <toggle></toggle>
    <div id="loading">
<!--      <div class="loading-circle"></div>-->
<!--      <img src="--><?php //$this->options->themeUrl('src/img/loading.gif') ?><!--" id="loading-img"/>-->
      <div class="box"></div>
    </div>
    <nav>
        <a href="<?php $this->options->siteUrl(); ?>">
            <?php if ($this->options->svg_path): $this->options->svg_path(); else: ?>
                <i class="fa fa-user" aria-hidden="true"></i>
            <?php endif; ?>
            <span><?php $this->author() ?></span></a>
        <?php

        $GLOBALS['note'] ? print_r('<a href="' . $GLOBALS['note'] . '"><i class="fa fa-book"></i><span>日记</span></a>') : print_r('');
        $GLOBALS['project'] ? print_r('<a href="' . $GLOBALS['project'] . '"><i class="fa fa-flask"></i><span>项目</span></a>') : print_r('');
        $GLOBALS['archive'] ? print_r('<a href="' . $GLOBALS['archive'] . '"><i class="fa fa-archive"></i><span>归档</span></a>') : print_r('');
        $GLOBALS['music'] ? print_r('<a href="' . $GLOBALS['music'] . '"><i class="fa fa-star"></i><span>爱好</span></a>') : ($GLOBALS['bangumi'] ? print_r('<a href="' . $GLOBALS['bangumi'] . '"><i class="fa fa-star"></i><span>爱好</span></a>') : print_r(''));
        $GLOBALS['link'] ? print_r('<a href="' . $GLOBALS['link'] . '"><i class="fa fa-link"></i><span>朋友们</span></a>') : print_r('');
        ?>
        <?php if ($this->user->hasLogin()): ?>
            <a href="<?php $this->options->adminUrl() ?>" target="_blank"><i class="fa fa-unlock-alt"
                                                                             aria-hidden="true"></i><span>后台</span></a>
        <?php endif; ?>
    </nav>
</header>
