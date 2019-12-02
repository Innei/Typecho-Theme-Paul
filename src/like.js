function like_init(dom) { // 点赞实现 ajax
    const Like_btn = dom.querySelectorAll('.like');
    for (let el of Like_btn) {
        el.onclick = function (e) {
            const that = this;
            ks.ajax({
                method: "POST",
                data: {
                    type: "up",
                    id: this.getAttribute('data-cid'),
                },
                url: window.location.href,
                success: function (res) {
                    if (JSON.parse(res.responseText)['status'] === 1) {
                        that.innerHTML = parseInt(that.innerHTML) + 1;
                        ks.notice("感谢你的点赞~", {
                            color: "green",
                            time: 1500
                        });
                        that.classList.add('active');
                        that.style.color = 'red';
                        that.onclick = function () {
                            ks.notice("你的爱我已经感受到了！", {
                                color: "yellow",
                                time: 1500
                            });
                        }
                    } else if (JSON.parse(res.responseText)['status'] === 0) {
                        ks.notice("你的爱我已经感受到了！", {
                            color: "yellow",
                            time: 1500
                        });
                    }
                },
                failed: function (res) {
                    ks.notice("FXXK！提交出错了！", {
                        color: "red"
                    });
                }
            })
        }
    }
}

like_init(document);
