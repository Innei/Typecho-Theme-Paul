var paul = new function () {
    var that = this
    var ajax = {note: {}, gallery: {}}
    this.getByName = function (name) {
        return document.getElementsByName(name)[0]
    }
    this.add_zero = function (num) {
        return num < 10 ? "0" + num : num
    }
    var head = {wrap: ks.select("header")}
    ks.select("toggle").onclick = function () {
        head.wrap.classList.toggle("active")
    }
    ks("header nav a").each(function (t) {
        t.onclick = head.wrap.classList.remove("active")
    })
    this.side = function () {
        var el = {top: ks.select("action .top"), player: ks.select("action .player")}
        el.top.onclick = function () {
            if ('scrollBehavior' in document.documentElement.style) {
                window.scrollTo({top: 0, behavior: "smooth"})
            } else {
                window.scrollSmoothTo(0)
            }
        }
        window.onscroll = function () {
            var scroll = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
            scroll >= window.innerHeight / 1.5 ? el.top.classList.add("active") : el.top.classList.remove("active")
        }
        el.player.onclick = function () {
            document.body.classList.toggle("has-player")
        }
    }


    this.musicPage = function () {
        paul_music.setList()
        var lists = ks.selectAll(".paul-music")
        ks(".music-cover img").each(function (item, num) {
            item.onclick = function () {
                lists[num].classList.toggle("active")
            }
        })
        var fi = ks.selectAll(".fixed-cover"), co = ks.selectAll(".music-cover"), li = ks.selectAll(".music-list"),
            offset = 7 * 16

        function scroll_fixed() {
            fi.forEach(function (t, index) {
                if (li[index].getBoundingClientRect().top > offset) {
                    t.className = "fixed-cover"
                } else if ((li[index].getBoundingClientRect().top + li[index].offsetHeight) > t.offsetHeight + offset) {
                    t.className = "fixed-cover fixed"
                } else if (co[index].getBoundingClientRect().top < 0) {
                    t.className = "fixed-cover bottom"
                } else {
                    document.removeEventListener("scroll", scroll_fixed)
                }
            })
        }

        if (!paul_music.isMobile()) document.addEventListener("scroll", scroll_fixed)
    }
    this.init = function () {
        const imgs = [...ks.selectAll("article img:not(.comment-list)")]
        imgs.forEach((item, index) => {
            item.setAttribute('ks-original', item.getAttribute('src'))
            item.setAttribute('src', 'https://i.loli.net/2019/06/22/5d0da0324990294723.gif')
        })
        ks.lazy('article img')
        if (ks.select("#comment")) this.staticPage()
        if (ks.select(".paul-music"))
            this.musicPage()
        this.side()
        if (typeof _hmt !== 'undefined') _hmt.push(['_trackPageview', location.pathname + location.search])
        ks.image("article img, .paul-say img, .project-screenshot img, .gallery-item")
    }
};
var paul_music = new function () {
    var that = this
    this.list = ["520570570", "541432715"]
    this.action = {}
    var status = {playing: 0, lyric: [], lyric_index: 0}
    this.setList = function () {
        var newList = []
        ks("[data-sid]").each(function (item, key) {
            newList.push(item.dataset["sid"])
            item.onclick = function (t) {
                if (that.list !== newList) that.list = newList
                document.body.classList.add("has-player")
                status.playing = key
                that.play()
            }
        })
    }
    this.isMobile = function () {
        var ua = window.navigator.userAgent.toLowerCase()
        ua = ua.indexOf("mobile") || ua.indexOf("android")
        return window.innerWidth < 600 && ua !== -1
    }
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
    }
    var actions = {
        prev: function () {
            status.playing > 0 ? status.playing-- : status.playing = that.list.length - 1
            that.play()
        }, next: function () {
            status.playing < that.list.length - 1 ? status.playing++ : status.playing = 0
            that.play()
        }, reload: function () {
            that.clear_int()
            that.clear_lyric()
            status.lyric_index = 0
            if (status.lyric) {
                elements.lyric.innerText = elements.title.innerText + " - " + elements.artist.innerText
            } else {
                elements.lyric.innerText = "没有歌词呢！"
            }
            elements.bar.played.style.width = "0%"
        }
    }
    var intv, intv_lyric
    this.sel_int = function () {
        if (intv !== null || intv !== undefined) {
            intv = setInterval(function () {
                elements.bar.played.style.width = (elements.player.currentTime / elements.player.duration) * 100 + "%"
            }, 1000)
        }
    }
    this.clear_int = function () {
        clearInterval(intv)
        intv = undefined
    }
    this.sel_lyric = function () {
        if (!intv_lyric) {
            intv_lyric = setInterval(function () {
                if (status.lyric[status.lyric_index] && elements.player.currentTime > status.lyric[status.lyric_index].time) {
                    if (status.lyric[status.lyric_index].tlyric) {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric + " " + status.lyric[status.lyric_index].tlyric
                    } else {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric
                    }
                    status.lyric_index++
                }
            }, 500)
        } else {
            console.log("这首歌没有歌词")
        }
    }
    this.clear_lyric = function () {
        clearInterval(intv_lyric)
        intv_lyric = undefined
    }
    this.init = function () {
        elements.toggle.onclick = function () {
            elements.player.paused ? elements.player.play() : elements.player.pause()
        }
        elements.prev.onclick = actions.prev
        elements.next.onclick = actions.next
        elements.player.addEventListener("play", function () {
            if (!elements.player.src) {
                actions.next()
            }
            that.sel_int()
            if (status.lyric) that.sel_lyric()
            elements.cover.wrap.classList.add("active")
            elements.toggle.classList.add("pause")
        })
        elements.player.addEventListener("error", function () {
            elements.title.innerText = "歌曲连接错误了 😭"
        })
        elements.player.addEventListener("pause", function () {
            that.clear_int()
            if (status.lyric) that.clear_lyric()
            elements.cover.wrap.classList.remove("active")
            elements.toggle.classList.remove("pause")
        })
        elements.player.addEventListener("progress", function () {
            var percentage = elements.player.buffered.length ? elements.player.buffered.end(elements.player.buffered.length - 1) / elements.player.duration : 0
            elements.bar.loaded.style.width = percentage * 100 + "%"
        })
        elements.player.addEventListener("ended", function () {
            actions.next()
        })

        function test(e) {
            if (that.isMobile()) {
                elements.bar.played.style.width = (e.touches[0].clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * 100 + "%"
            } else {
                elements.bar.played.style.width = (event.clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * 100 + "%"
            }
        }

        var evname = this.isMobile() ? ["touchstart", "touchmove", "touchend"] : ["mousedown", "mousemove", "mouseup"]

        function mouseup(e) {
            that.sel_int()
            document.removeEventListener(evname[1], test)
            document.removeEventListener(evname[2], mouseup)
            if (elements.player.currentTime) {
                if (that.isMobile()) {
                    elements.player.currentTime = (e.changedTouches[0].clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * elements.player.duration
                } else {
                    elements.player.currentTime = (event.clientX - elements.bar.wrap.getBoundingClientRect().left) / elements.bar.wrap.offsetWidth * elements.player.duration
                }
            }
            if (status.lyric) {
                var i = 0

                function set_lyric() {
                    if (status.lyric[status.lyric_index].tlyric) {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric + " " + status.lyric[status.lyric_index].tlyric
                    } else {
                        elements.lyric.innerText = status.lyric[status.lyric_index].lyric
                    }
                }

                while (i < status.lyric.length) {
                    if (elements.player.currentTime < status.lyric[i].time) {
                        status.lyric_index = i > 0 ? i - 1 : i
                        set_lyric()
                        break
                    } else if (i === status.lyric.length - 1) {
                        status.lyric_index = status.lyric.length - 1
                        set_lyric()
                        break
                    } else {
                        i++
                    }
                }
            }
        }

        elements.bar.wrap.addEventListener(evname[0], function (e) {
            that.clear_int()
            document.addEventListener(evname[1], test)
            document.addEventListener(evname[2], mouseup)
        })
        elements.cover.wrap.onclick = function () {
            if (that.isMobile()) elements.wrap.classList.toggle("full")
        }
    }
    if ("mediaSession" in navigator) {
        navigator.mediaSession.setActionHandler("play", function () {
            elements.player.play()
        })
        navigator.mediaSession.setActionHandler("pause", function () {
            elements.player.pause()
        })
        navigator.mediaSession.setActionHandler("previoustrack", actions.prev)
        navigator.mediaSession.setActionHandler("nexttrack", actions.next)
    }
    this.setInfo = function (title, artist, cover) {
        elements.title.innerText = title
        elements.artist.innerText = artist
        elements.cover.image.style.backgroundImage = "url('" + cover + "')"
    }
    this.parseLyric = function (text, tran) {
        function to_obj(text, type) {
            text = text.split("\n")
            if (!text) return false
            var list = type === 1 ? {} : [], cache, content
            text.forEach(function (item, y) {
                cache = item.match(/\d{2,}/g)
                content = item.replace(/\[\S+\]\s?/, "")
                if (cache && content) {
                    cache = parseInt(cache[0]) * 60 + parseInt(cache[1]) + parseFloat(cache[2]) / 1000
                    if (type === 1) {
                        list[cache] = {lyric: content}
                    } else {
                        list.push({time: cache, lyric: content})
                    }
                }
            })
            return list
        }

        text = to_obj(text)
        if (tran) {
            tran = to_obj(tran, 1)
            text.forEach(function (t, key) {
                if (tran[t.time]) t.tlyric = tran[t.time].lyric
            })
        }
        return text
    }
    this.play = function () {
        console.log("Now Playing: " + that.list[status.playing] + " (" + status.playing + ")")
        ks.ajax({
            method: "GET",
            url: "https://api.paugram.com/netease/" + "?id=" + that.list[status.playing],
            success: function (req) {
                var t = JSON.parse(req.response)
                that.setInfo(t.title, t.artist, t.cover)
                elements.player.src = "https://music.163.com/song/media/outer/url?id=" + that.list[status.playing]
                if (t.lyric && t.sub_lyric) {
                    status.lyric = that.parseLyric(t.lyric, t.sub_lyric)
                } else if (t.lyric) {
                    status.lyric = that.parseLyric(t.lyric)
                } else {
                    status.lyric = null
                }
                actions.reload()
                if ("mediaSession" in navigator) {
                    navigator.mediaSession.metadata = new MediaMetadata({
                        title: t.title,
                        artist: t.artist,
                        album: t.album,
                        artwork: [{src: t.cover}]
                    })
                }
                elements.player.play()
                elements.wrap.classList.add("active")
            },
            failed: function (req) {
                ks.notice("获取音乐信息错误了！", {color: "red"})
            }
        })
    }
    this.init()
};
if (window.console && window.console.log) {
    console.log("%c Paul %c https://paul.ren ", "color: #fff; margin: 1em 0; padding: 5px 0; background: #1abc9c;", "margin: 1em 0; padding: 5px 0; background: #efefef;")
}
paul.init()