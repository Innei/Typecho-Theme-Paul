<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>404 - 找不到页面</title>
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1"/>
    <style>
        html, body {
            height: 100%;
        }

        body {
            color: #333;
            margin: auto;
            padding: 1em;
            display: table;
            user-select: none;
            box-sizing: border-box;
            font:  20px "微软雅黑";
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        h1 {
            margin-top: 0;
            font-size: 3.5em;
        }

        main {
            margin: 0 auto;
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .btn {
            color: #fff;
            padding: .75em 1em;
            background: #3498db;
            border-radius: 1.5em;
            display: inline-block;
            transition: opacity .3s, transform .3s;
        }

        .btn:hover {
            transform: scale(1.2);
        }

        .btn:active {
            opacity: .7;
        }
    </style>
</head>
<body>
<main>
    <h1>:(</h1>
    <p>嗨，朋友！看上去你输入的地址不存在哦~</p>
    <p>你可以去浏览我的 <a href="<?php $this->options->siteUrl(); ?>">首页</a> 或 <a href="<?php $this->options->blog_url() ?>">博客</a> ~</p>
    <a class="btn" href="<?php $this->options->siteUrl(); ?>">返回首页</a>
</main>
</body>
</html>