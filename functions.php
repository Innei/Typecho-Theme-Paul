<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
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
    $note_nums = new Typecho_Widget_Helper_Form_Element_Text('note_nums', NULL, NULL, _t('日记输出数量'), _t('在这里填入你需要在日记页面输出的日记数量'));
    $form->addInput($note_nums);
    // 自定义追番输出数量
    $display_bgm_num = new Typecho_Widget_Helper_Form_Element_Text('display_bgm_num', NULL, NULL, _t('追番输出数量'), _t('在这里填入你需要在追番页面输出的追番数量'));
    $form->addInput($display_bgm_num);
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


function parse_RSS($url, $site)
{
    $rss = simplexml_load_file($url);
    $file = $rss->channel->item;
    $link = $rss->channel->link;
    global $body;
    if (isset($file)) {
        for ($i = 0; $i < 4; $i++) {

            if ($file[$i]) {
                $body .= '<div class="col-6 col-m-3">' . '<a href="' . $file[$i]->link . '" class="news-article" target="_blank">' . '<img src="' . $site . '/src/img/' . rand(0, 14) . '.jpg">' . '<h4>' . $file[$i]->title . '</h4></a></div>';
            } else {
                break;
            }
        }
    } else {
        echo "博客连接失败,请检查";
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
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `likes` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
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
