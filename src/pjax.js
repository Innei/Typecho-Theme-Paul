window.onload = () => {
    const head = {wrap: ks.select("header")}
    this.pjax = new Pjax({
        elements: "a[href]:not([target=_blank]):not([onclick])",
        selectors: ["title", "meta[name=description]", "meta[property]", "main", "action", "meta[name=referrer]"],
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
}
