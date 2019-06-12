# Paul Theme Typecho Introduction

Design Prototype: <https://paul.ren>

<a href="../master/README-CN.md">Chinese Document</a>

Progress: 5/10

## Preview

![Xnip2019-06-11_19-01-55.png](https://i.loli.net/2019/06/11/5cff8a35163e519776.png)

You can also go to this url <https://paul.ren>, called Paul's Home ,to visit its prototype.

## Feature

- [x] note
- [x] says
- [x] home index page
- [x] article page
- [x] works page
- [x] commit
- [x] like (need VOID_Plugin)
- [ ] player
- [ ] others

## Before Start

This is a theme for Typecho, which suit to write diary and display your home page.

This theme stems from <https://paul.ren>, this is not perfect now, probably had more bugs. Cause of them, on the one hand, because of the Typecho's limit.On the other hand, time is in a hurry. 

## Quickly Start

Clone this repo, and go to dashboard -- theme -- Paul, enable it. In the this theme's setting, you should fill out form.

## Index Page

On the index page, you will see four of nav button on the top of the window, Index, about, donate and dream. It will display according to your create the necessary pages. It will display `index` button , if your don't do anything, it is default. So you should do like following.

about page: you should create independent page, select the `首页模板` template, slug must to fill `about`, and you can write any content you like.

dream page: you should create independent page, select the `首页模板` template, slug must to fill `dream`, and you can write any content you like.

donate page: you should create independent page, select the `首页模板` template, slug must to fill `donate`, and you can write any content you like.

index page had four columns, personal information, recent articles, recent diaries, projects.

personal information should fill out form in the theme setting or Typecho setting.

recent blog articles parse according to RSS url which you fill out.

recent diaries will exhibit four items, every items output about 50 words.

works according to if it is exists, and display them.

## Diary Page

diary page is the most important page in this theme. It is the core. So you must be create it necessary and correctly.

diary page: you should create independent page, select the `日记页面` template, slug must to fill `note`, and you can write any content you like, because it will ingore you content which you worte. How many diary will display according to your setting in the theme config. But, because of the limit of the typecho, other articles also can access by enter the permanent link.

## Other Page [Option]

works page: you should create independent page, select the `作品页面` template, slug must to fill `project`, and the content format should write like following.

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

says page: you should create independent page, select the `语录页面` template, slug must to fill `saying`, and the content format should write like following. (says body --- say's avatar, every says should have a blank line)

```
可能，是命运的安排，让我们自愿走上了这条艰难的道路，然后，在这条布满荆棘的曲折小路上慢慢去寻找人生的乐趣。然而，此时，我才发现，真正美妙而有意义的人生，大概就从我坚定不移地追求自己梦想的时候，才正式开始。———— 《愿你历经千帆，归来仍是少年》

生命的本质是苦难的。我不追求天赐荣华富贵，那会让我诚惶诚恐，消受不起，只是觉得，每天睁开眼睛发现自己还活着，没有缺胳膊少腿，还可以通过自己的努力和命运的黑色幽默较量搏斗，还可以勇敢的有尊严地与困难较量，这种感觉很踏实。———— 《愿你历经千帆，归来仍是少年》
```

project information page: you can create a independent page which used `作品介绍页` template, this template will render page like <https://paul.ren/project/style>. And the format also used JSON.

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

## Copyright & Open Source

Belong to @Dreamer-Paul. MIT Licence.

## Used Open Source

- fontawesome 4
- Kico Style
- Kico Player
- VOID_Plugin

## Thanks

- [@Dreamer-Paul](https://github.com/Dreamer-Paul)
- [@moesoha](https://github.com/moesoha)