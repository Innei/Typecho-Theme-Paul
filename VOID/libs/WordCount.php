<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 字数统计相关
 * 
 * @author AlanDecode | 熊猫小A
 */

class VOID_WordCount
{
    /**
     * 更新所有的字数统计
     */
    public static function updateAllWordCount()
    {
        $db = Typecho_Db::get();
        $dbname = $db->getPrefix() . 'contents';
        $rows = $db->fetchAll($db->select('cid')
            ->from('table.contents')
            ->where('type = ?', 'post'));

        foreach ($rows as $row) {
            self::wordCountByCid($row['cid']);
        }
    }

    /**
     * 根据 cid 更新字数
     */
    public static function wordCountByCid($cid){
        $db = Typecho_Db::get();
        $dbname = $db->getPrefix() . 'contents';
        $row = $db->fetchRow($db->select()->from('table.contents')->where('cid = ?', $cid));

        // 中文字数
        $count = mb_strlen(preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $row['text']), 'UTF-8');
        // 英文词数
        $count += str_word_count($row['text'], 0);

        $db->query($db->update('table.contents')->rows(array('wordCount' => (int)$count))->where('cid = ?', $cid));
    }
}