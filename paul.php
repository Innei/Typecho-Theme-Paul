<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Paul
{
    static function bangumi()
    {
        $uid = Typecho_Widget::widget('Widget_Options')->bili_id;
        $num = Typecho_Widget::widget('Widget_Options')->display_bgm_num;
        $bgm = file_get_contents('https://api.bilibili.com/x/space/bangumi/follow/list?type=1&pn=1&ps=' . ($num ? $num : '15') . '&vmid=' . $uid);
        $bgm = json_decode($bgm, true);

        if($bgm["code"] == 53013){
            echo "<p>无法获取数据，请在 B 站隐私设置中开启</p>";
        }
        else{
            $lists = $bgm['data']['list'];
            foreach ($lists as $key => $list) {
                preg_match('/^看到第(\d+)话/',$list['progress'], $res);
                echo '<div class="col-6 col-s-4 col-m-3">
                    <a class="bangumi-item" href="https://bangumi.bilibili.com/anime/' . $list['season_id'] . '/" target="_blank" rel="nofollow">
                        <img src="' . str_replace('http://', 'https://', $list['cover']) . '"/>
                        <h4>' . $list['title']
                    . '
                            <div class="bangumi-status">
                                <div class="bangumi-status-bar" style="width: '. $res[1] / $list['new_ep']['title'] .'%"></div>
                                <p>' . $list['new_ep']['index_show'] . '</p>         
                            </div>
                        </h4>
                    </a>
                </div>';
            }
        }
    }

    static function parse_says($content)
    {
        // 匹配每行 放入数组

        preg_match_all('/<p>(.*?)<\/p>/', $content, $says);

        $content = array();
        foreach ($says['1'] as $key => $saying) {
            $content[] = preg_split('/((-){2,}|————|——)/', $saying);  // 匹配提取----|---|--|————|——后的内容

        }
        $author_names = array();
        $say_bodys = array();
        foreach ($content as $key => $value) {
            if (count($value) != 1) {
                $author_names[] = '来源: ' . array_pop($value);   // 分割后数量如果为1 说明作者提取失败
            } else {
                $author_names[] = '';  // 失败情况加入处理
            }

            $say_bodys[] = implode("——", $value);  // 合并多余的分割项
        }

        foreach ($say_bodys as $key => $saying) {
            yield $author_names[$key] => $saying;
        }

    }

    static function get_163_music($par, $key, $token, $cookie)
    {
        $data = array(
            'params' => $par,
            'encSecKey' => $key
        );
        $query = http_build_query($data);
        $options['http'] = array(
            'method' => 'POST',
            'header' => "Content-type:application/x-www-form-urlencoded\r\nCookie:$cookie",
            'content' => $query
        );

        $url = 'https://music.163.com/weapi/v1/play/record?csrf_token=' . $token;
        $context = stream_context_create($options);

        $result = file_get_contents($url, false, $context);
        $json = json_decode($result, true);

        $num = 1;
        $week_data = array();

        foreach ($json['weekData'] as $key => $item) {
            if ($num <= 10):
                $playTime = date('i:s', $item['song']['dt'] / 1000);
                $week_data[] = ['name' => $item['song']['name'], 'id' => $item['song']['id'], 'time' => $playTime, 'num' => $num++];
            else:break;
            endif;
        }
        $num = 1;
        $all_data = array();
        foreach ($json['allData'] as $key => $item) {
            if ($num <= 10):
                $playTime = date('i:s', $item['song']['dt'] / 1000);
                $all_data[] = ['name' => $item['song']['name'], 'id' => $item['song']['id'], 'time' => $playTime, 'seq' => $num++, 'num' => $item['playCount']];
            else:break;
            endif;
        }
        return [$week_data, $all_data];
    }

    static function parse_Flink($link_string)
    {
        $arr = explode("\n", $link_string);
        $arr = array_filter($arr);
        $parse_link = function ($array) {
            $link = $name = array();
            for ($i = 0; $i < count($array); $i += 2) {
                $link[] = $array[$i];
                $name[] = $array[$i + 1];
            }
            $total = array_map(function ($i1, $i2) {
                return '<li><a href="' . $i1 . '" target="_blank">' . $i2 . '</a></li>';
            }, $name, $link);
            return $total;
        };
        $s = $parse_link($arr);
        foreach ($s as $item) {
            echo $item;
        }
    }
}