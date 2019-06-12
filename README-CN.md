# Paul Theme Typecho

设计原型 <https://paul.ren>

`进度 5/10`

## 预览

![Xnip2019-06-11_19-01-55.png](https://i.loli.net/2019/06/11/5cff8a35163e519776.png)

你也可以前往 https://paul.ren ，光临保罗的小窝。他是设计原型。

## 故事

前往 [Pual Typecho主题发布](https://shizuri.net/archives/131/).

## 功能实现

- [x] 日记
- [x] 语录
- [x] 主页
- [x] 文章页
- [x] 作品页
- [x] 输出评论
- [x] 输入评论
- [x] 点赞 (接入VOID插件)
- [ ] 播放器
- [ ] 其他

## 开始之前

这是一款适合写日记，也适合用于个人主页展示的主题。

他的原出处来源于 <https://paul.ren> ，此移植主题现在仍有不完善的地方，一是因为 Typecho 的限制，二是因为时间比较匆忙。已实现的功能见上。

## 快速开始

Clone 此项目，在 设置 中使用此主题。在设置主题中填写相关字段。

## 使用方法

### 首页

首页顶部导航将会有4个选项，分别是 首页，关于，捐赠，心愿，除了首页默认显示，其余的根据以下设置，否则不显示。

关于页： 你需要建立独立页面，模版选择 `首页模版` ，slug 填写 `about` 必须填写这个，内容自定。

心愿页： 你需要建立独立页面，模版选择 `首页模版` ，slug 填写 `dream` 必须填写这个，内容自定。

捐赠页： 你需要建立独立页面，模版选择 首页模版 ，slug 填写 `donate` 必须填写这个，内容自定。

主页有4个栏，分别是个人信息，最新博文，最近日记，作品。

个人信息在设置中填写。最新博文根据 RSS 获取。可以链接另一个 Typecho 博客。

最近日记将显示最近4篇日记的简略形式。

作品根据是否存在判断是否显示。

### 日记页

日记页是本主题的重中之重，请务必正确设置。

日记页： 你需要建立独立页面，模版选择 `日记页面` ，slug 填写 `note` 必须填写这个，内容无需填写。日记显示的数量在主题设置中设置，默认为最近10篇，其余不显示。但是由于 Typecho 限制用户认可进入永久链接查看。

### 其他页

作品页可选，解析成功后将会在一级导航显示作品页，首页显示作品栏。

作品页： 你需要建立独立页面，模版选择 `作品页面` ，slug 填写 `project` 必须填写这个，内容采用以下 JSON 格式。

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

语录页: 你需要建立独立页面，模版选择 `语录页面` ，slug 填写 `saying` 必须填写这个，内容采用以下格式。 (内容 -- 名字, 每句之间都空行, 支持 CSS 样式)

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

## 附加

- [ ] 根据分类制定独立页面, 不同输出

## 版权 & 开源

@Dreamer-Paul 所有, 开源遵循 MIT.

### 使用的开源项目

- fontawesome 4
- Kico Style
- Kico Player
- VOID_Plugin

## 鸣谢

- [@Dreamer-Paul](https://github.com/Dreamer-Paul)
- [@moesoha](https://github.com/moesoha)


