# Typecho Theme Paul Introduction

Design Prototype: <https://paul.ren>

Demo: <https://shizuri.net>

<a href="../master/README-EN.md">Chinese Document</a>

More Star, More Demands, More Upgrade.

## Preview

![image](https://user-images.githubusercontent.com/41265413/59440844-2ca08a00-8e2a-11e9-95bf-3acc5a2acc6d.png)

![image](https://user-images.githubusercontent.com/41265413/59444149-e9e1b080-8e2f-11e9-94b8-2e45c59fcf8b.png)

![image](https://user-images.githubusercontent.com/41265413/59440870-39bd7900-8e2a-11e9-879b-04e7a792235c.png)

![image](https://user-images.githubusercontent.com/41265413/59440890-40e48700-8e2a-11e9-8b71-3d1b4c5479b9.png)

![image](https://user-images.githubusercontent.com/41265413/59440935-55288400-8e2a-11e9-8dc2-84a42e61343a.png)

![image](https://user-images.githubusercontent.com/41265413/59440958-5eb1ec00-8e2a-11e9-8176-42e60bff4164.png)

![image](https://user-images.githubusercontent.com/41265413/59441089-99b41f80-8e2a-11e9-9a97-bd0c19946756.png)

![image](https://user-images.githubusercontent.com/41265413/59441120-a9cbff00-8e2a-11e9-87ef-241ff0edccdc.png)

You can also go to this url <https://paul.ren>, called Paul's Home ,to visit its prototype.

## information

See [Pual Typecho主题发布](https://shizuri.net/archives/131/).

## Feature

- [x] Write diary
- [x] Exhibit says
- [x] Nice home index page
- [x] Awesome article page
- [x] Beautiful Works page
- [x] Commit
- [x] Like, Views
- [x] Player
- [x] Others
- [x] No-refresh Full Website
- [x] Load more with ajax

## Before Start

This is a theme for Typecho, which suit to write diary and display your home page.

This theme stems from <https://paul.ren>, this is not perfect now, probably had more bugs. Cause of them, on the one hand, because of the Typecho's limit.On the other hand, time is in a hurry. 

## Quickly Start

Clone this repo, and go to dashboard -- theme -- Paul, enable it. In the this theme's setting, you should fill out form.

## Index Page

On the index page, you will see four of nav button on the top of the window, Index, about, donate and dream. It will display according to your create the necessary pages. It will display `index` button , if you don't do anything, it will be default. So you should do like following.

about page: you should create independent page, select the `首页模板` template, and you can write any content you like.

dream page: you should create independent page, select the `首页模板` template, and you can write any content you like.

donate page: you should create independent page, select the `首页模板` template, and you can write any content you like.

index page had four columns, personal information, recent articles, recent diaries, projects.

personal information should fill out form in the theme setting or Typecho setting.

recent blog articles parse according to RSS url which you fill out.

recent diaries will exhibit four items, every items output about 50 words.

works according to if it is exists, and display them.

## Diary Page

diary page is the most important page in this theme. It is the core. So you must be create it necessarily and correctly.

diary page: you should create independent page, select the `日记页面` template, and you can write any content you like, because it will ingore you content which you wrote. How many diary will display according to your setting in the theme config. The others will load by using ajax. And you also can set a secret key to prohibit user to access.

## Other Page [Option]

**works page**: you should create independent page, select the `作品页面` template, and the content format should write like following.

```json5
[{
"name": "project one",  // name
"img": "",       // img url, if none, will display default img
"url": "https://i.shizuri.net/" // Url
},
{"name": "project two",
"img": "",
"url": "https://i.yiny.me/"
}]
```

**works info page**: use `作品介绍页模板`, will output works on the works page, and also will output on the index page. The format should follow this.

```json5
{
"project_img": "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1560445631540&di=73e3469b88d6fae728aae976e3bf0a53&imgtype=0&src=http%3A%2F%2Fpic.51yuansu.com%2Fpic3%2Fcover%2F02%2F39%2F53%2F59c2b016635b3_610.jpg",  // icon, if none, will used default icon
"body": "一个简单的主题", // info body
"imgs": ["https://user-images.githubusercontent.com/41265413/59440870-39bd7900-8e2a-11e9-879b-04e7a792235c.png","https://user-images.githubusercontent.com/41265413/59440890-40e48700-8e2a-11e9-8b71-3d1b4c5479b9.png"] // project's introduction images.
}
```

**says page**: you should create independent page, select the `语录页面` template, and the content format should write like following. (says body --- say's avatar, every says should have a blank line)

```
可能，是命运的安排，让我们自愿走上了这条艰难的道路，然后，在这条布满荆棘的曲折小路上慢慢去寻找人生的乐趣。然而，此时，我才发现，真正美妙而有意义的人生，大概就从我坚定不移地追求自己梦想的时候，才正式开始。———— 《愿你历经千帆，归来仍是少年》

生命的本质是苦难的。我不追求天赐荣华富贵，那会让我诚惶诚恐，消受不起，只是觉得，每天睁开眼睛发现自己还活着，没有缺胳膊少腿，还可以通过自己的努力和命运的黑色幽默较量搏斗，还可以勇敢的有尊严地与困难较量，这种感觉很踏实。———— 《愿你历经千帆，归来仍是少年》
```

**project information page**: you can create a independent page which used `作品介绍页` template, this template will render page like <https://paul.ren/project/style>. And the format also used JSON.

```json5
{
"info": "示例介绍", // information
"project_img": "", // project image, if none, will used default image.
"url": "https://works.paugram.com/style", // url
"doc_url": "", // document url, if none, will not display it.
"imgs": ["https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=3344978418,213176529&fm=27&gp=0.jpg","https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=3689685426,1442582010&fm=27&gp=0.jpg"],  // images
"body": "<p>Kico Style 是一个简洁的前端样式框架，只提供页面布局等基础功能。代码轻量、不冗余，适合前端初学者和探索者。</p>" // content body.
}
```

To turn other music in the bottom of the player, you need open the file named `paul.js` in `src` directory. Find follow this.

```js
var paul_music = new function () {
    var that = this;
    this.list = ["520570570", "541432715"];  // replace your music id, the source of music id come from Netease Music
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

**Music page**: 

Notice: Due to Netease Music Api's limitation, you will get `token` `key` `cookie` `par`  manually. 

```json5
{
"par": "KQlmV7JqpyE+v/SyvueeMNxe3+D8kLxcHulXTM5hpb9v5W4pApGbt+scMt22anE+RkQRUo6BqSPjrHBOGLeupj37azQooH837IgyFEl53mVcN3+GMZd9NRnQia0KJfgORbKbxAtercSGMmU0=",
"key": "73d262099e16a6a929b877c2306de2052ce8672c22a767d9807b5a7b0ef8a727f7b58b728e5041fdd180402c9c844ced49e7bf413ac31de4bb3ebfa15031b38d31fcc992314056516bebbb3b700da572f45c959e62b",
"token": "0ffcae938ce56b5ccf3833452b",
"cookie": "_iuqxldmzr_=32; _ntBcfAzNCT4p1hxpzkwEv; __utma=187553192.2048158810.1535955082.1535955082.1535959925.2; usertrack=ezq0pFvQf8mQPpjRDbkvAg==; _ga=GA1.2.2048158810.1535955082; __utma=94650624.892957808.1535686861.1542513934.1542787057.58; mail_psc_fingerprint=d0ea7e74138959611e1b07e5c0eb01ec; P_INFO=sisi062840628cm@163.com|1543396067|0|urs|00&99|zhj&1543396040&163#zhj&330300#10#0#0|&0|163|sisi062840628cm@163.com; vinfo_n_f_l_n3=bba4c658daa3f963.1.0.1549370539457.0.1549370906136; __remember_me=true; JSESSIONID-WYYY=AyCuuq9H%2FgYMBTTmkOh2s%5CQFWWA1jBqmXDqeBJab86NoIAFS3FIfAQJ8xsc8JWpC38Fhz1ugvyg1Wc0jAgfhgfW%5CY98ey22tG6hqSxC46kr6yueHQOyS9Fi0RXdgdwa5hqlFNAznV%2BUhEHqhrQP0fidc7Jc60SNtX16Z2Q%2FWAwv1nT2K%3A1560508623731; WM_NI=bg9lWN%2Bc6Rrg2JRPhHy3YXKMlF%2BWMv9xpjo988Pb97ArgTkR5DESzW0LMIjaHb1IL5uPh8Gzbv1tHRZOKAJ2RvHfRL4FYkuTa%2B2Ve6eZj7R5RXDn8glk23SWHdFDJzm4STI%3D; WM_NIKE=9ca17ae2e6ffcda170e2e6ee97d85e8d8e9d9bd93b939a8bb7c55b968a8bbabb73f2bca2b0f95fb794aba2aa2af0fea7c3b92aa2b9f78dd646e9bdfab3f16df2969eb1eb44bbed97b9ca47b09ae5b8d07efba8c08bee33fce8a083bc3d83aea9b5ea5af79c8bb4f95df49483aae96b8cbeffaacf3fb790a8d9c672a2aaff95cb5a9a9185a2c93a92aa8887d148f89a978cf860a3f5feb7e83ea786a6d8d13f92888c8fbb6db0b5fed4d25d8cbc8aa5c972afec9db5cc37e2a3; MUSIC_U=408c20031ba79321895033c45da31203091430c9e20ac9aa21aafd3328975a88ce3af6f259a118934c02c7efe60b561d114f327788dd6fe3; __csrf=0ffcae938ce56b5ccf3833452bb8045a"
}
```

Enjoy.

## Copyright & Open Source

Belong to @Dreamer-Paul & @Innei. MIT Licence.

## Used Open Source

- fontawesome 4
- Kico Style
- Kico Player
- VOID_Plugin

## Thanks

- [@Dreamer-Paul](https://github.com/Dreamer-Paul)
- [@moesoha](https://github.com/moesoha)
