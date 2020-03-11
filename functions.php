<?php

if(!defined('__TYPECHO_ROOT_DIR__')) exit;

require_once("paul.php");

function themeConfig($form)
{
    // 自定义站点图标
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('站点图标'), _t('在这里填入一张 png 图片地址（<a>192x192px</a>），不填则使用默认图标'));
    $form->addInput($favicon->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    // 自定义背景图
    $background = new Typecho_Widget_Helper_Form_Element_Text('background', NULL, NULL, _t('站点背景'), _t('在这里填入一张图片地址，不填则显示纯色背景'));
    $form->addInput($background->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    // 自定义头像
    $avatar = new Typecho_Widget_Helper_Form_Element_Text('avatar', NULL, NULL, _t('头像'), _t('在这里填入一张 png 图片地址（<a>192x192px</a>），不填则使用默认图标'));
    $form->addInput($avatar->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    // Github Username
    $github_username = new Typecho_Widget_Helper_Form_Element_Text('github_username', NULL, NULL, _t('GitHub'), _t(''));
    $form->addInput($github_username);
    // Weibo ID
    $weibo_id = new Typecho_Widget_Helper_Form_Element_Text('weibo_id', NULL, NULL, _t('Weibo ID'), _t(''));
    $form->addInput($weibo_id);
    // Netease ID
    $netease_id = new Typecho_Widget_Helper_Form_Element_Text('netease_id', NULL, NULL, _t('Netease ID'), _t(''));
    $form->addInput($netease_id);
    // BiliBili ID
    $bili_id = new Typecho_Widget_Helper_Form_Element_Text('bili_id', NULL, NULL, _t('BiliBili ID'), _t(''));
    $form->addInput($bili_id);
    //RSS
    $RSS = new Typecho_Widget_Helper_Form_Element_Text('RSS', NULL, NULL, _t('RSS地址'), _t('填写你的RSS地址  https:// 开头'));
    $form->addInput($RSS);
    // Blog URL
    $blog_url = new Typecho_Widget_Helper_Form_Element_Text('blog_url', NULL, NULL, _t('博客地址'), _t('填写你的博客地址  https:// 开头'));
    $form->addInput($blog_url);
    // 自定义日记输出数量
    $note_nums = new Typecho_Widget_Helper_Form_Element_Text('note_nums', NULL, NULL, _t('日记输出数量'), _t('在这里填入你需要在日记页面输出的日记数量，后续文章可以设置隐藏也可以通过 Ajax 加载。隐藏的文章也将无法通过直链访问'));
    $form->addInput($note_nums);
    // 是否隐藏后续的日记内容
    $is_hidden_note = new Typecho_Widget_Helper_Form_Element_Radio('is_hidden_note', array('0' => _t('不隐藏'), '1' => _t('需要隐藏, 这是人家的小秘密啦')), _t('是否隐藏后续的日记内容'), _t('是否隐藏后续的日记内容'));
    $form->addInput($is_hidden_note);
    // 设置暗号, 需要开启隐藏日记开关
    $secret = new Typecho_Widget_Helper_Form_Element_Text('secret', NULL, 'secret', _t('设置暗号'), _t('隐藏的文章通过直链访问, 需要暗号才可以查看'));
    $form->addInput($secret);
    // 自定义追番输出数量
    $display_bgm_num = new Typecho_Widget_Helper_Form_Element_Text('display_bgm_num', NULL, NULL, _t('追番输出数量'), _t('在这里填入你需要在追番页面输出的追番数量'));
    $form->addInput($display_bgm_num);
    // 日记预览页是否全文输出
    $is_display_all_content = new Typecho_Widget_Helper_Form_Element_Radio('is_display_all_content', array('0' => _t('全文输出'), '1' => _t('部分输出')), _t('日记预览页输出设置'), _t('日记预览页是否全文输出'));
    $form->addInput($is_display_all_content);
    // 自定义样式表
    $custom_css = new Typecho_Widget_Helper_Form_Element_Textarea('custom_css', NULL, NULL, _t('自定义样式表'), _t('在这里填入你的自定义样式表，不填则不输出。'));
    $form->addInput($custom_css);
    // 自定义统计代码
    $custom_script = new Typecho_Widget_Helper_Form_Element_Textarea('custom_script', NULL, NULL, _t('统计代码'), _t('在这里填入你的统计代码，不填则不输出。需要 <a>&lt;script&gt;</a> 标签'));
    $form->addInput($custom_script);
    // 自定义社交链接
    $home_social = new Typecho_Widget_Helper_Form_Element_Textarea('home_social', NULL, NULL, _t('自定义社交链接'), _t('在这里填入你的自定义社交链接，不填则不输出。（格式请看<a href="https://github.com/Dreamer-Paul/Single/releases/tag/1.1" target="_blank">帮助信息</a>）'));
    $form->addInput($home_social);
    // 自定义作者信息
    $author_text = new Typecho_Widget_Helper_Form_Element_Textarea('author_text', NULL, NULL, _t('作者信息'), _t('显示在文章底部的作者信息，不填则不输出。'));
    $form->addInput($author_text);
    // SVG 路径
    $svg_path = new Typecho_Widget_Helper_Form_Element_Textarea('svg_path', NULL, NULL, _t('SVG 路径'), _t('用于绘制导航栏头像, 不填则默认, 需要' . htmlspecialchars('<svg></svg>')));
    $form->addInput($svg_path);
}

function get_randoms($min, $max, $num)
{
    $count = 0;
    $res = array();
    while ($count < $num) {
        $res[] = rand($min, $max);
        $res = array_flip(array_flip($res));
        $count = count($res);
    }
    return $res;
}

function parse_RSS($url, $site)
{
    $rss = simplexml_load_file($url);
    $file = $rss->channel->item;
    $link = $rss->channel->link;
    global $body;

    if (isset($file)) {
        $rand_arr = get_randoms(0, 14, 5);
        for ($i = 0; $i < 4; $i++) {
            if ($file[$i]) {
                $body .= '<div class="col-6 col-m-3">' . '<a href="' . $file[$i]->link . '" class="news-article" target="_blank">' . '<img src="' . $site . '/src/img/' . array_pop($rand_arr) . '.jpg">' . '<h4>' . $file[$i]->title . '</h4></a></div>';
            } else {
                break;
            }
        }
    } else {
        echo "博客连接失败啦，一请检查是否开启 OpenSSL 支持，二请检查地址是否正确。";
        echo "使用 AppNode 或者 其他面板 的小伙伴请注意，请把网站的PHP设置 `allow_url_fopen = On`";
    }
    return $body;
}

function get_like_num($archive)
{
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `likes` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('likes')->from('table.contents')->where('cid = ?', $cid));
    echo $row['likes'];
}

function get_views_num($archive)
{
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    return $row['views'];
}

function get_words($archive)
{
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('wordCount')
        ->from('table.contents')
        ->where('cid = ?', $archive->cid));
    return $row['wordCount'];
}

function themeInit($archive)
{
    if ($archive->is('archive')) {
        $archive->parameter->pageSize = 20; // 自定义条数
    }

    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD COLUMN `likes` INT(10) DEFAULT 0;');
    }
    Helper::options()->commentsAntiSpam = false;
}

function themeFields($layout)
{
    if (preg_match("/write-page.php/", $_SERVER['REQUEST_URI'])) {
        $title = new Typecho_Widget_Helper_Form_Element_Text('title', NULL, NULL, _t('标题'), _t('首页模板功能'));
        $layout->addItem($title);
        $intro = new Typecho_Widget_Helper_Form_Element_Text('intro', NULL, NULL, _t('介绍'), _t('首页模板功能'));
        $layout->addItem($intro);
    }
    if (preg_match("/write-post.php/", $_SERVER['REQUEST_URI'])) {
        $mood = new Typecho_Widget_Helper_Form_Element_Select('mood', array('一般' => '一般', '开心' => '开心', '伤心' => '伤心', '沉闷' => '沉闷', '无聊' => '无聊', '紧张' => '紧张', '愤怒' => '愤怒', '迷茫' => '迷茫', '心酸' => '心酸', '绝望' => '绝望'), '一般', '心情如何');
        $layout->addItem($mood);
    }
    // 删除多余字段
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $db->query($db->delete($prefix . 'fields')->where('str_value = ? AND name = ?', '', 'title')->orWhere('str_value = ? AND name = ?', '', 'intro'));
}

function isLiked($cid)
{
    $likes = Typecho_Cookie::get('__post_likes');
    if (empty($likes)) {
        return false;
    } else {
        $likes = explode(',', $likes);
    }
    if (in_array($cid, $likes)) {
        return true;
    }
}