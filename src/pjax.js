window.onload = () => {
    const head = {wrap: ks.select("header")}
    this.pjax = new Pjax({
        elements: "a[href]:not([target=_blank]):not([onclick])",
        selectors: ["title", "meta[property]", "main", "action", "meta[name=referrer]"],
        timeout: 10000,
        cacheBust: false
    })
    document.addEventListener('pjax:send', function () {
        document.body.classList.add("loading")
        head.wrap.classList.remove("active")
    })
    document.addEventListener('pjax:complete', function () {
        document.body.classList.remove("loading")
        paul.init()
    })
    document.addEventListener('pjax:error', function () {
        ks.notice("网络连接异常！", {
            color: "red"
        })
    })
    document.addEventListener('pjax:complete', () => {
        const form = document.getElementById('want-login')
        ks.ajax({
            url: location.href,
            method: "POST",
            data: {
                action: 1
            },
            success(res) {
                form.setAttribute('action', res.responseText)
            },
            failed() {
                ks.notice("刷新登陆链接出错了，前台将无法登陆，请刷新", {
                    color: "red"
                })
            }
        })
    })
}