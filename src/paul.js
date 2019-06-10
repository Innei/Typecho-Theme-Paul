var paul = new function () {
    var that = this;
    var ajax = {note: {}, gallery: {}};
    this.getByName = function (name) {
        return document.getElementsByName(name)[0];
    };
    this.add_zero = function (num) {
        return num < 10 ? "0" + num : num;
    };
    var head = {wrap: ks.select("header")}
    ks.select("toggle").onclick = function () {
        head.wrap.classList.toggle("active");
    }
    ks("header nav a").each(function (t) {
        t.onclick = head.wrap.classList.remove("active");
    });
    this.side = function () {
        var el = {top: ks.select("action .top"), player: ks.select("action .player")};
        el.top.onclick = function () {
            if ('scrollBehavior' in document.documentElement.style) {
                window.scrollTo({top: 0, behavior: "smooth"})
            } else {
                window.scrollTo(0, 0);
            }
        };
        window.onscroll = function () {
            var scroll = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
            scroll >= window.innerHeight / 1.5 ? el.top.classList.add("active") : el.top.classList.remove("active");
        };
        el.player.onclick = function () {
            document.body.classList.toggle("has-player");
        }
    };
    this.getGallery = function (event) {
        var cat = event.target.dataset.cat;
        var offset = ajax.gallery.page * 20;
        ajax.gallery.page++;
        event.target.innerHTML = '<i class="fa fa-spinner"></i>';
        ks.ajax({
            method: "GET",
            data: {cat: cat, mod: "listImage", offset: offset},
            header: [["X-Requested-With", "XMLHttpRequest"]],
            url: "https://paul.ren/get",
            success: function (req) {
                var result = JSON.parse(req.response);
                var row = ks.select(".paul-gallery .row");
                result.result.forEach(function (t) {
                    row.appendChild(ks.create("div", {
                        class: "col-6 col-s-4 col-m-3",
                        html: "<div class=\"gallery-item\" ks-thumb=\"//paul.ren/upload/gallery/" + cat + "/" + t.name + "-resized.jpg\" ks-original=\"//paul.ren/upload/gallery/" + cat + "/" + t.name + ".jpg\">\n" +
                            "<p class=\"gallery-story\">" + t.content + "</p>\n" +
                            "<h4 class=\"gallery-title\">" + t.title + "</h4>\n" +
                            "</div>"
                    }));
                });
                if (result.result.length < 20) {
                    ajax.gallery.end = true;
                    event.target.innerHTML = '没有了';
                    event.target.setAttribute("disabled", "");
                } else {
                    event.target.innerHTML = '继续加载...';
                }
                ks.image(".gallery-item");
                ks.lazy(".gallery-item", true);
            },
            failed: function (req) {
                ks.notice("请求图片故障", {color: "red"});
            }
        });
    };
    this.sendNote = function () {
        var container = ks.select(".is-note");
        var act = {
            tog: ks.select(".post-new"),
            code: ks.select(".add-code"),
            music: ks.select(".add-music"),
            hidden: ks.select(".add-hidden")
        }, post = {
            pwd: ks.select("#pwd"),
            cont: ks.select("#content"),
            music: ks.select("#music"),
            mood: this.getByName("mood"),
            photo: ks.select("#photo"),
            submit: ks.select("#submit")
        };
        /*act.tog.onclick = function () {
            container.classList.toggle("active");
        };*/

        /*act.music.onclick = function () {
            if (post.music.hasAttribute("hidden")) {
                post.music.removeAttribute("hidden");
            } else {
                post.music.setAttribute("hidden", true);
            }
        };
        post.music.onpaste = function (t) {
            var m = t.clipboardData.getData("text/plain").match(/\?id=[0-9]*!/);
            if (m !== null) {
                setTimeout(function () {
                    post.music.value = m[0].substr(4);
                    console.log("转换地址完成");
                }, 500);
            }
        };*/

        function insertStr(source, str1, str2) {
            if (source.selectionStart === source.selectionEnd) {
                return source.value.slice(0, source.selectionStart) + str1 + str2 + source.value.slice(source.selectionStart);
            } else {
                var length = source.selectionEnd - source.selectionStart;
                return source.value.slice(0, source.selectionStart) + str1 + source.value.slice(source.selectionStart, source.selectionEnd) + str2 + source.value.slice(source.selectionEnd);
            }
        }

        /*  act.code.onclick = function () {
              post.cont.value = insertStr(post.cont, "<code>", "</code>");
          };
          act.hidden.onclick = function () {
              post.cont.value = insertStr(post.cont, "<hidden>", "</hidden>");
          };
          post.submit.onclick = function () {
              if ((!post.pwd || post.pwd.value !== "") && post.cont.value !== "") {
                  ks.notice("正在提交内容...", {color: "blue", time: 1500});
                  if (!post.pwd === true) {
                      post.pwd = {};
                      post.pwd.value = "no-pwd";
                  }
                  ks.ajax({
                      method: "POST",
                      data: {
                          type: "note",
                          mod: "newNote",
                          pwd: post.pwd.value,
                          mood: post.mood.value,
                          content: post.cont.value,
                          music: post.music.value,
                          photo: post.photo.files[0]
                      },
                      header: [["X-Requested-With", "XMLHttpRequest"]],
                      url: "https://paul.ren/post",
                      success: function (req) {
                          var result = JSON.parse(req.response);
                          if (result.status === true) {
                              ks.notice("提交新日记成功~", {color: "green", time: 1500});
                              pjax.loadUrl("/note");
                          } else if (result.info === "Password Check Failed!") {
                              ks.notice("暗号不对呀！", {color: "red"});
                          }
                          container.classList.remove("active");
                          console.log(result);
                      },
                      failed: function (req) {
                          ks.notice("提交出错了！", {color: "red"});
                      }
                  });
              } else {
                  ks.notice("嘿，你还没有填完内容呢", {color: "yellow"});
              }
          }
      };
      this.comments = function () {
          var cid, year;
          var a = ks.select(".post-form.is-comment");
          ks(".paul-note .comment").each(function (e) {
              e.onclick = function (ev) {
                  cid = ev.target.dataset.cid;
                  year = ev.target.dataset.year;
                  if (a.dataset.cid === cid) {
                      a.classList.toggle("active");
                  } else {
                      a.dataset.cid = cid;
                      a.classList.add("active");
                      ks.select("#note-m").innerHTML = "";
                      ajax.note.comment = new Gitalk({
                          clientID: 'e3998ba0f995d10924e4',
                          clientSecret: '2cbfa1f505728073122e3371b527be9e88da1b8b',
                          repo: 'Comments',
                          owner: 'Dreamer-Paul',
                          admin: ['Dreamer-Paul'],
                          labels: ["Note", year],
                          createIssueManually: true,
                          distractionFreeMode: false,
                          id: "/note/" + year + "-" + cid + "/",
                          title: year + " 年第 " + cid + " 篇日记"
                      });
                      ajax.note.comment.render('note-m');
                  }
              }
          });*/
    };
    /*this.likes = function () {
        function check(id) {
            var a = localStorage.getItem("liked");
        }

        ks(".paul-note .like").each(function (e) {
            var num = parseInt(e.innerText);
            e.onclick = function () {
                if (e.classList.contains("active") === false) {
                    num++;
                    e.innerHTML = num;
                    e.classList.add("active");
                    ks.ajax({
                        method: "POST",
                        data: {type: "note", mod: "likeNote", cid: e.dataset["cid"]},
                        url: "https://paul.ren/post",
                        success: function (req) {
                            var result = JSON.parse(req.response);
                            if (result.status === true) {
                                ks.notice("感谢你的点赞~", {color: "green", time: 1500});
                            } else {
                                num--;
                                e.innerHTML = num;
                                ks.notice("你的爱我已经感受到了~", {color: "red", time: 1500});
                            }
                        },
                        failed: function (req) {
                            num--;
                            e.innerHTML = num;
                            ks.notice("FXXK！提交出错了！", {color: "red"});
                        }
                    });
                } else {
                    ks.notice("你的爱我已经感受到了！", {color: "yellow", time: 1500});
                }
            };
        });
    };*/
    /*this.indexPage = function () {
        var btn = ks.select(".do-you-like-me .heart");
        var num = ks.select(".do-you-like-me .likes");
        var e = parseInt(num.innerText);
        btn.onclick = function () {
            if (document.cookie.indexOf("like-paul=true") === -1) {
                e++;
                num.innerHTML = e;
                ks.ajax({
                    method: "POST",
                    data: {type: "index", mod: "likeMe"},
                    header: [["X-Requested-With", "XMLHttpRequest"]],
                    url: "https://paul.ren/post",
                    success: function (req) {
                        var result = JSON.parse(req.response);
                        if (result.status === true) {
                            ks.notice("感谢你的支持~", {color: "green", time: 1500});
                        } else if (result.info === "You had liked me before") {
                            ks.notice("一天一次就够啦！", {color: "red"});
                            e--;
                            num.innerHTML = e;
                        }
                        document.cookie = "like-paul=true;" + "path=/;" + "max-age=21600";
                    },
                    failed: function (req) {
                        ks.notice("提交出错了！", {color: "red"});
                    }
                });
            } else {
                ks.notice("一天一次就够啦！", {color: "red"});
            }
        }
    }*/
    /* this.notePage = function () {
         this.likes();
         this.comments();
         this.sendNote();
         paul_music.setList();
     };*/
    this.galleryPage = function () {
        ajax.gallery.page = 1;
        ajax.gallery.end = false;
        ks.lazy(".gallery-item", true);
        var container = ks.select(".is-gallery");
        ks.select(".paul-more button").onclick = function (t) {
            if (!ajax.gallery.end) that.getGallery(t);
        };
        var act = {tog: ks.select(".post-new")}, post = {
            pwd: ks.select("#pwd"),
            title: ks.select("#title"),
            content: ks.select("#content"),
            photo: ks.select("#photo"),
            category: this.getByName("category"),
            submit: ks.select("#submit"),
            test: ks.select("#title").value
        };
        act.tog.onclick = function () {
            container.classList.toggle("active");
        };
        post.submit.onclick = function () {
            if (!post.pwd === true) {
                post.pwd = {value: "no-pwd"};
            }
            if (post.title.value !== "" && post.pwd.value !== "" && post.photo.files[0]) {
                ks.notice("正在提交内容...", {color: "blue", time: 1500});
                ks.ajax({
                    method: "POST",
                    data: {
                        type: 2,
                        pwd: post.pwd.value,
                        title: post.title.value,
                        content: post.content.value,
                        photo: post.photo.files[0],
                        category: post.category.value
                    },
                    header: [["X-Requested-With", "XMLHttpRequest"]],
                    url: "https://paul.ren/post",
                    success: function (req) {
                        var result = JSON.parse(req.response);
                        if (result.status === true) {
                            ks.notice("提交新图片成功~", {color: "green", time: 1500});
                        } else if (result.error === "Password Check Failed!") {
                            ks.notice("暗号不对呀！", {color: "red"});
                        } else if (result.error === "FileType Error!") {
                            ks.notice("文件格式错误！", {color: "red"});
                        }
                        container.classList.remove("active");
                    },
                    failed: function (req) {
                        ks.notice("提交出错了！", {color: "red"});
                    }
                });
            } else {
                ks.notice("嘿，你还没有填完内容呢", {color: "yellow"});
            }
        };
    };
    this.staticPage = function () {
        var gitalk = new Gitalk({
            clientID: 'e3998ba0f995d10924e4',
            clientSecret: '2cbfa1f505728073122e3371b527be9e88da1b8b',
            repo: 'Comments',
            owner: 'Dreamer-Paul',
            admin: ['Dreamer-Paul'],
            labels: ["Page"],
            id: location.pathname,
            distractionFreeMode: false
        });
        gitalk.render('comment');
    };
    this.musicPage = function () {
        paul_music.setList();
        var lists = ks.selectAll(".paul-music");
        ks(".music-cover img").each(function (item, num) {
            item.onclick = function () {
                lists[num].classList.toggle("active");
            }
        });
        var fi = ks.selectAll(".fixed-cover"), co = ks.selectAll(".music-cover"), li = ks.selectAll(".music-list"),
            offset = 7 * 16;

        function scroll_fixed() {
            fi.forEach(function (t, index) {
                if (li[index].getBoundingClientRect().top > offset) {
                    t.className = "fixed-cover";
                } else if ((li[index].getBoundingClientRect().top + li[index].offsetHeight) > t.offsetHeight + offset) {
                    t.className = "fixed-cover fixed";
                } else if (co[index].getBoundingClientRect().top < 0) {
                    t.className = "fixed-cover bottom";
                } else {
                    document.removeEventListener("scroll", scroll_fixed);
                }
            })
        }

        if (!paul_music.isMobile()) document.addEventListener("scroll", scroll_fixed);
    };
    this.init = function () {
        /*// if (ks.select(".paul-news")) this.indexPage();
      /!*  if (ks.select(".paul-note")) this.notePage();*!/
     /!*   if (ks.select(".paul-gallery")) this.galleryPage();*!/
        if (ks.select(".paul-music")) this.musicPage();*/
        if (ks.select("#comment")) this.staticPage();
        this.side();
        if (typeof _hmt !== 'undefined') _hmt.push(['_trackPageview', location.pathname + location.search]);
        ks.image("article img, .paul-say img, .project-screenshot img, .gallery-item");
    };
    var pjax = new Pjax({
        elements: "a[href]:not([target=_blank]):not([onclick])",
        selectors: ["title", "meta[name=description]", "meta[property]", "main", "action"],
        timeout: 10000,
        cacheBust: false
    });
    document.addEventListener('pjax:send', function () {
        document.body.classList.add("loading");
        head.wrap.classList.remove("active");
    });
    document.addEventListener('pjax:complete', function () {
        document.body.classList.remove("loading");
        paul.init();
    });
    document.addEventListener('pjax:error', function () {
        ks.notice("网络连接异常！", {color: "red"});
    });
};
var paul_music = new function () {
    var that = this;
    this.list = ["520570570", "541432715"];
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
    this.isMobile = function () {
        var ua = window.navigator.userAgent.toLowerCase();
        ua = ua.indexOf("mobile") || ua.indexOf("android");
        return window.innerWidth < 600 && ua !== -1;
    };
    var elements = {
        wrap: ks.select("player"),
        title: ks.select(".player-info .title"),
        artist: ks.select(".player-info .artist"),
        cover: {wrap: ks.select(".player-cover"), image: ks.select(".cover-img")},
        lyric: ks.select(".player-lyric span"),
        bar: {
            wrap: ks.select(".player-bar"),
            loaded: ks.select(".player-bar .loaded"),
            played: ks.select(".player-bar .played")
        },
        toggle: ks.select(".player-right .toggle"),
        prev: ks.select(".player-right .prev"),
        next: ks.select(".player-right .next"),
        player: document.createElement("audio")
    };
    var actions = {
        prev: function () {
            status.playing > 0 ? status.playing-- : status.playing = that.list.length - 1;
            that.play();
        }, next: function () {
            status.playing < that.list.length - 1 ? status.playing++ : status.playing = 0;
            that.play();
        }, reload: function () {
            that.clear_int();
            that.clear_lyric();
            status.lyric_index = 0;
            if (status.lyric) {
                elements.lyric.innerText = elements.title.innerText + " - " + elements.artist.innerText;
            } else {
                elements.lyric.innerText = "没有歌词呢！";
            }
            elements.bar.played.style.width = "0%";
        }
    };
    var intv, intv_lyric;
    this.sel_int = function () {
        if (intv !== null || intv !== undefined) {
            intv = setInterval(function () {
                elements.bar.played.style.width = (elements.player.currentTime / elements.player.duration) * 100 + "%";
            }, 1000);
        }
    };
    this.clear_int = function () {
        clearInterval(intv);
        intv = undefined;
    };
    this.sel_lyric = function () {
        if (!intv_lyric) {
            intv_lyric = setInterval(function () {
                if (status.lyric[status.lyric_index] && elements.player.currentTime > status.lyric[status.lyric_index].time) {
                    if (status.lyric[status.lyric_index].tlyric) {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric + " " + status.lyric[status.lyric_index].tlyric;
                    } else {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric;
                    }
                    status.lyric_index++;
                }
            }, 500);
        } else {
            console.log("这首歌没有歌词");
        }
    };
    this.clear_lyric = function () {
        clearInterval(intv_lyric);
        intv_lyric = undefined;
    };
    this.init = function () {
        elements.toggle.onclick = function () {
            elements.player.paused ? elements.player.play() : elements.player.pause();
        };
        elements.prev.onclick = actions.prev;
        elements.next.onclick = actions.next;
        elements.player.addEventListener("play", function () {
            if (!elements.player.src) {
                actions.next();
            }
            that.sel_int();
            if (status.lyric) that.sel_lyric();
            elements.cover.wrap.classList.add("active");
            elements.toggle.classList.add("pause");
        });
        elements.player.addEventListener("error", function () {
            elements.title.innerText = "歌曲连接错误了 😭";
        });
        elements.player.addEventListener("pause", function () {
            that.clear_int();
            if (status.lyric) that.clear_lyric();
            elements.cover.wrap.classList.remove("active");
            elements.toggle.classList.remove("pause");
        });
        elements.player.addEventListener("progress", function () {
            var percentage = elements.player.buffered.length ? elements.player.buffered.end(elements.player.buffered.length - 1) / elements.player.duration : 0;
            elements.bar.loaded.style.width = percentage * 100 + "%";
        });
        elements.player.addEventListener("ended", function () {
            actions.next();
        });

        function test(e) {
            if (that.isMobile()) {
                elements.bar.played.style.width = (e.touches[0].clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * 100 + "%";
            } else {
                elements.bar.played.style.width = (event.clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * 100 + "%";
            }
        }

        var evname = this.isMobile() ? ["touchstart", "touchmove", "touchend"] : ["mousedown", "mousemove", "mouseup"];

        function mouseup(e) {
            that.sel_int();
            document.removeEventListener(evname[1], test);
            document.removeEventListener(evname[2], mouseup);
            if (elements.player.currentTime) {
                if (that.isMobile()) {
                    elements.player.currentTime = (e.changedTouches[0].clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * elements.player.duration;
                } else {
                    elements.player.currentTime = (event.clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * elements.player.duration;
                }
            }
            if (status.lyric) {
                var i = 0;

                function set_lyric() {
                    if (status.lyric[status.lyric_index].tlyric) {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric + " " + status.lyric[status.lyric_index].tlyric;
                    } else {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric;
                    }
                }

                while (i < status.lyric.length) {
                    if (elements.player.currentTime < status.lyric[i].time) {
                        status.lyric_index = i > 0 ? i - 1 : i;
                        set_lyric();
                        break;
                    } else if (i === status.lyric.length - 1) {
                        status.lyric_index = status.lyric.length - 1;
                        set_lyric();
                        break;
                    } else {
                        i++;
                    }
                }
            }
        }

        elements.bar.wrap.addEventListener(evname[0], function (e) {
            that.clear_int();
            document.addEventListener(evname[1], test);
            document.addEventListener(evname[2], mouseup)
        });
        elements.cover.wrap.onclick = function () {
            if (that.isMobile()) elements.wrap.classList.toggle("full");
        }
    };
    if ("mediaSession" in navigator) {
        navigator.mediaSession.setActionHandler("play", function () {
            elements.player.play()
        });
        navigator.mediaSession.setActionHandler("pause", function () {
            elements.player.pause()
        });
        navigator.mediaSession.setActionHandler("previoustrack", actions.prev);
        navigator.mediaSession.setActionHandler("nexttrack", actions.next);
    }
    this.setInfo = function (title, artist, cover) {
        elements.title.innerText = title;
        elements.artist.innerText = artist;
        elements.cover.image.style.backgroundImage = "url('" + cover + "')";
    };
    this.parseLyric = function (text, tran) {
        function to_obj(text, type) {
            text = text.split("\n");
            if (!text) return false;
            var list = type === 1 ? {} : [], cache, content;
            text.forEach(function (item, y) {
                cache = item.match(/\d{2,}/g);
                content = item.replace(/\[\S+\]\s?/, "");
                if (cache && content) {
                    cache = parseInt(cache[0]) * 60 + parseInt(cache[1]) + parseFloat(cache[2]) / 1000;
                    if (type === 1) {
                        list[cache] = {lyric: content};
                    } else {
                        list.push({time: cache, lyric: content});
                    }
                }
            });
            return list;
        }

        text = to_obj(text);
        if (tran) {
            tran = to_obj(tran, 1);
            text.forEach(function (t, key) {
                if (tran[t.time]) t.tlyric = tran[t.time].lyric;
            });
        }
        return text;
    };
    this.play = function () {
        console.log("Now Playing: " + that.list[status.playing] + " (" + status.playing + ")");
        ks.ajax({
            method: "GET",
            url: "https://api.paugram.com/netease/" + "?id=" + that.list[status.playing],
            success: function (req) {
                var t = JSON.parse(req.response);
                that.setInfo(t.title, t.artist, t.cover);
                elements.player.src = "https://music.163.com/song/media/outer/url?id=" + that.list[status.playing];
                if (t.lyric && t.sub_lyric) {
                    status.lyric = that.parseLyric(t.lyric, t.sub_lyric);
                } else if (t.lyric) {
                    status.lyric = that.parseLyric(t.lyric);
                } else {
                    status.lyric = null;
                }
                actions.reload();
                if ("mediaSession" in navigator) {
                    navigator.mediaSession.metadata = new MediaMetadata({
                        title: t.title,
                        artist: t.artist,
                        album: t.album,
                        artwork: [{src: t.cover}]
                    });
                }
                elements.player.play();
                elements.wrap.classList.add("active");
            },
            failed: function (req) {
                ks.notice("获取音乐信息错误了！", {color: "red"});
            }
        });
    };
    this.init();
};
if (window.console && window.console.log) {
    console.log("%c Paul %c https://paul.ren ", "color: #fff; margin: 1em 0; padding: 5px 0; background: #1abc9c;", "margin: 1em 0; padding: 5px 0; background: #efefef;");
}
paul.init();