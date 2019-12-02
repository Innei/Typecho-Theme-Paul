<?php
/**
 * @package 点赞
 * @author Innei 
 */
if (isset($_POST['id']) and $_POST['type'] == 'up'):
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $options = Typecho_Widget::widget('Widget_Options');
    $cid = $_POST['id'];
    $likes = Typecho_Cookie::get('__post_likes');
    header('Content-type:application/json');
    if (empty($likes)) {
        $likes = array();
    } else {
        $likes = explode(',', $likes);
    }
    if (!in_array($cid, $likes)) {
        $row = $db->fetchRow($db->select('likes')->from('table.contents')->where('cid = ?', $cid)->limit(1));
        $db->query($db->update('table.contents')->rows(array('likes' => (int)$row['likes'] + 1))->where('cid = ?', $cid));
        array_push($likes, $cid);
        $likes = implode(',', $likes);
        Typecho_Cookie::set('__post_likes', $likes); // 记录查看cookie

        echo json_encode(array('status' => 1, 'msg' => '成功点赞!'));
        exit;
    }
    echo json_encode(array('status' => 0, 'msg' => '你已经点赞过了!'));
    exit;
endif;
?>