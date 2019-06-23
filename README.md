# Paul Theme Typecho

设计原型 <https://paul.ren>

Demo 地址: <https://shizuri.net>

<a href="../master/README-EN.md">English Document</a>

如果你喜欢，请我一个 Star, 谢谢～

开发不易，让我们向所有开发者致敬！

## 浏览器兼容性

至少需要支持 ES6 的现代浏览器, 推荐使用 Chrome

## 特点和实现

- [x] 日记
- [x] 语录
- [x] 主页
- [x] 文章页
- [x] 作品页
- [x] 输出评论
- [x] 输入评论
- [x] 点赞, 浏览量
- [x] 播放器
- [x] 音乐页
- [x] 其他
- [x] ajax 加载更多文章
- [x] 全站无刷新体验 (可能只有 Chrome 支持)
- [x] 评论 ajax 提交
- [x] 文章内图片懒加载 (Safari 未通过测试)

## 预览

![image](../master/screenshot.png)

![image](https://user-images.githubusercontent.com/41265413/59444149-e9e1b080-8e2f-11e9-94b8-2e45c59fcf8b.png)

![image](https://user-images.githubusercontent.com/41265413/59440870-39bd7900-8e2a-11e9-879b-04e7a792235c.png)

![image](https://user-images.githubusercontent.com/41265413/59440890-40e48700-8e2a-11e9-8b71-3d1b4c5479b9.png)

![image](https://user-images.githubusercontent.com/41265413/59440935-55288400-8e2a-11e9-8dc2-84a42e61343a.png)

![image](https://user-images.githubusercontent.com/41265413/59440958-5eb1ec00-8e2a-11e9-8176-42e60bff4164.png)

![image](https://user-images.githubusercontent.com/41265413/59441089-99b41f80-8e2a-11e9-9a97-bd0c19946756.png)

![image](https://user-images.githubusercontent.com/41265413/59441120-a9cbff00-8e2a-11e9-87ef-241ff0edccdc.png)

你也可以前往 https://paul.ren ，光临保罗的小窝。他是设计原型。

## 故事

前往 [Pual Typecho主题发布](https://shizuri.net/archives/131/).

## 开始之前

这是一款适合写日记，也适合用于个人主页展示的主题。

他的原出处来源于 <https://paul.ren> ，此移植主题现在仍有不完善的地方，一是因为 Typecho 的限制，二是因为时间比较匆忙。已实现的功能见上。

## 快速开始

Clone 此项目，在 设置 中使用此主题。在设置主题中填写相关字段。

## 使用方法

### 首页

首页顶部导航将会有4个选项，分别是 首页，关于，捐赠，心愿，除了首页默认显示，其余的根据以下设置，否则不显示。

关于页： 你需要建立独立页面，模版选择 `首页模版` ，内容自定。

心愿页： 你需要建立独立页面，模版选择 `首页模版` ，内容自定。

捐赠页： 你需要建立独立页面，模版选择 首页模版 ，内容自定。

主页有4个栏，分别是个人信息，最新博文，最近日记，作品。

个人信息在设置中填写。最新博文根据 RSS 获取。可以链接另一个 Typecho 博客。

最近日记将显示最近4篇日记的简略形式。

作品根据是否存在判断是否显示。

### 日记页

日记页是本主题的重中之重，请务必正确设置。

日记页： 你需要建立独立页面，模版选择 `日记页面` ，内容无需填写。日记显示的数量在主题设置中设置，默认为最近10篇，其余不显示。但是由于 Typecho 限制用户认可进入永久链接查看。

### 其他页

作品页可选，解析成功后将会在一级导航显示作品页，首页显示作品栏。

#### 作品页
 
你需要建立独立页面，模版选择 `作品页面` ，内容采用以下 JSON 格式。

```json5
[{
"name": "项目一",  // 名称
"img": "",       // 图片地址, 不填为空则为默认图片
"url": "https://i.shizuri.net/" // 跳转地址
},
{"name": "项目二",
"img": "",
"url": "https://i.yiny.me/"
}]
```

注意: 如果不指定 JSON, 如果有独立页面使用了`作品介绍页模板`, 也会解析输出.

#### 作品介绍页

使用`作品介绍页模板`, 将会在作品页输出, 并且在首页输出作品, 格式如下

```json5
{
"project_img": "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1560445631540&di=73e3469b88d6fae728aae976e3bf0a53&imgtype=0&src=http%3A%2F%2Fpic.51yuansu.com%2Fpic3%2Fcover%2F02%2F39%2F53%2F59c2b016635b3_610.jpg",  // 作品图标
"body": "一个简单的主题", // 介绍正文
"imgs": ["https://user-images.githubusercontent.com/41265413/59440870-39bd7900-8e2a-11e9-879b-04e7a792235c.png","https://user-images.githubusercontent.com/41265413/59440890-40e48700-8e2a-11e9-8b71-3d1b4c5479b9.png"], // 作品图片, 可多个
"info": "this is a simple theme",
"url": "//shizuri.net", // preview website
"doc_url": "//github.com/Innei/typecho-theme-paul" // document url
}
```

注意: 作品名字为文章标题

#### 语录页

你需要建立独立页面，模版选择 `语录页面` ，内容采用以下格式。 (内容 -- 名字, 每句之间都空行, 支持 CSS 样式)

```
可能，是命运的安排，让我们自愿走上了这条艰难的道路，然后，在这条布满荆棘的曲折小路上慢慢去寻找人生的乐趣。然而，此时，我才发现，真正美妙而有意义的人生，大概就从我坚定不移地追求自己梦想的时候，才正式开始。———— 《愿你历经千帆，归来仍是少年》

生命的本质是苦难的。我不追求天赐荣华富贵，那会让我诚惶诚恐，消受不起，只是觉得，每天睁开眼睛发现自己还活着，没有缺胳膊少腿，还可以通过自己的努力和命运的黑色幽默较量搏斗，还可以勇敢的有尊严地与困难较量，这种感觉很踏实。———— 《愿你历经千帆，归来仍是少年》
```

底部播放器列表: 编辑 `/src/Paul.js` , 

```js
var paul_music = new function () {
    var that = this;
    this.list = ["520570570", "541432715"];  // 更换为你的歌曲 ID, 网易云
    this.action = {};
    var status = {playing: 0, lyric: [], lyric_index: 0};
    this.setList = function () {
        var newList = [];
        ks("[data-sid]").each(function (item, key) {
            newList.push(item.dataset["sid"]);
            item.onclick = function (t) {
                if (that.list !== newList) that.list = newList;
                document.body.classList.add("has-player");
                status.playing = key;
                that.play();
            }
        });
    };
}
```

点赞使用方法: 基于 [VOID_Plugin](https://github.com/AlanDecode/VOID-Plugin) 进行了修改, 请将主题目录下的 `VOID` 移动到 `../plugins` 中, 开启此插件. 正在寻找更好的方式.

#### 音乐页

注意: 由于网易云限制, 解密过程较为繁琐, 所以采用自行获取`token` `key` `cookie` `par` 

格式如下: 

```json5
{
"par": "KQlmV7JqpyE+v/SyvueeMNxe3+D8kLxcHulXTM5hpb9v5W4pApGbt+scMt22anE+RkQRUo6BqSPjrHBOGLeupj37azQooH837IgyFEl53mVcN3+GMZd9NRnQia0KJfgORbKbxAtercSGMmU0=",
"key": "73d262099e16a6a929b877c2306de2052ce8672c22a767d9807b5a7b0ef8a727f7b58b728e5041fdd180402c9c844ced49e7bf413ac31de4bb3ebfa15031b38d31fcc992314056516bebbb3b700da572f45c959e62b",
"token": "0ffcae938ce56b5ccf3833452b",
"cookie": "_iuqxldmzr_=32; _ntBcfAzNCT4p1hxpzkwEv; __utma=187553192.2048158810.1535955082.1535955082.1535959925.2; usertrack=ezq0pFvQf8mQPpjRDbkvAg==; _ga=GA1.2.2048158810.1535955082; __utma=94650624.892957808.1535686861.1542513934.1542787057.58; mail_psc_fingerprint=d0ea7e74138959611e1b07e5c0eb01ec; P_INFO=sisi062840628cm@163.com|1543396067|0|urs|00&99|zhj&1543396040&163#zhj&330300#10#0#0|&0|163|sisi062840628cm@163.com; vinfo_n_f_l_n3=bba4c658daa3f963.1.0.1549370539457.0.1549370906136; __remember_me=true; JSESSIONID-WYYY=AyCuuq9H%2FgYMBTTmkOh2s%5CQFWWA1jBqmXDqeBJab86NoIAFS3FIfAQJ8xsc8JWpC38Fhz1ugvyg1Wc0jAgfhgfW%5CY98ey22tG6hqSxC46kr6yueHQOyS9Fi0RXdgdwa5hqlFNAznV%2BUhEHqhrQP0fidc7Jc60SNtX16Z2Q%2FWAwv1nT2K%3A1560508623731; WM_NI=bg9lWN%2Bc6Rrg2JRPhHy3YXKMlF%2BWMv9xpjo988Pb97ArgTkR5DESzW0LMIjaHb1IL5uPh8Gzbv1tHRZOKAJ2RvHfRL4FYkuTa%2B2Ve6eZj7R5RXDn8glk23SWHdFDJzm4STI%3D; WM_NIKE=9ca17ae2e6ffcda170e2e6ee97d85e8d8e9d9bd93b939a8bb7c55b968a8bbabb73f2bca2b0f95fb794aba2aa2af0fea7c3b92aa2b9f78dd646e9bdfab3f16df2969eb1eb44bbed97b9ca47b09ae5b8d07efba8c08bee33fce8a083bc3d83aea9b5ea5af79c8bb4f95df49483aae96b8cbeffaacf3fb790a8d9c672a2aaff95cb5a9a9185a2c93a92aa8887d148f89a978cf860a3f5feb7e83ea786a6d8d13f92888c8fbb6db0b5fed4d25d8cbc8aa5c972afec9db5cc37e2a3; MUSIC_U=408c20031ba79321895033c45da31203091430c9e20ac9aa21aafd3328975a88ce3af6f259a118934c02c7efe60b561d114f327788dd6fe3; __csrf=0ffcae938ce56b5ccf3833452bb8045a"
}
```

## 附加

- [x] 根据分类制定独立页面, 不同输出

## 注意事项

除了在 post 页面, 其他页面中都是不带 referrer 信息的, 可能会影响到你的统计代码.

## 版权 & 开源

@Dreamer-Paul & @Innei 所有, 开源遵循 MIT.

### 使用的开源项目

- fontawesome 4
- Kico Style
- Kico Player
- VOID_Plugin

## 鸣谢

- [@Dreamer-Paul](https://github.com/Dreamer-Paul)
- [@moesoha](https://github.com/moesoha)


