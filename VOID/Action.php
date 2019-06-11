<?php
/**
 * Action for VOID Plugin
 * 
 * @author AlanDecode | 熊猫小A
 */

class VOID_Action extends Typecho_Widget implements Widget_Interface_Do
{
    /**
     * 点赞自增
     */
    public function up(){
        $db = Typecho_Db::get();
        $cid=$this->request->filter('int')->cid;
        $views = Typecho_Cookie::get('extend_contents_views'); 
       
        if (!in_array($cid, $views)) {
            if($cid){
                try {
                    $row = $db->fetchRow($db->select('likes')
                        ->from('table.contents')
                        ->where('cid = ?', $cid));
                    $db->query($db->update('table.contents')
                        ->rows(array('likes' => (int)$row['likes']+1))
                        ->where('cid = ?', $cid));
                    $this->response->throwJson("success");
                } catch (Exception $ex) {
                 echo $ex->getCode(); 
             }
         }  else {
            echo "error";
        }

        array_push($views, $cid);
        $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }

    public function action(){
        $this->on($this->request->is('up'))->up();
        $this->response->goBack();
    }
}