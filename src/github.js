var githubInfo = document.createElement("script");
var githubRepos = document.createElement("script");
function select(dom) {
  return document.querySelectorAll(dom).length == 1
    ? document.querySelector(dom)
    : document.querySelectorAll(dom);
}

function userInfo(res) {
  select(".my-avatar > img").setAttribute("src", res.data.avatar_url);
  select(".my-info span").innerText = res.data.login;
  [...select(".my-info text")].forEach(
    item => (item.innerHTML = res.data.login)
  );
  select(".my-info p").innerText = res.data.bio;
  select(".social-icons").innerHTML = `<a href="https://github.com/${
    res.data.login
  }" target="_blank"
                       ks-tag="bottom"
                       ks-text="GitHub"><i
                                class="fa fa-github" style="color: #44006f"></i></a>`;
}

function userRepos(res) {
  let content = "";
  for (let item of res.data) {
    content += `<li> <a href="${item.html_url}" target
    ="_blank"><div class="repo-name">${
      item.full_name
    }</div> </a><div class="repo-des">${
      item.description ? item.description : ""
    }</div></li>`;
  }
  select("#repo-list").innerHTML = content;
  loadingComplete();
}
function loadingComplete() {
  select("#loading.jsonp-loading").remove();
  select("#opensource-wrap").removeAttribute("style");
}

githubInfo.src = `https://api.github.com/users/${
  window.githubID
}?callback=userInfo`;

document.head.appendChild(githubInfo);

githubRepos.src = `https://api.github.com/users/${
  window.githubID
}/repos?sort=updated&callback=userRepos`;
document.head.appendChild(githubRepos);
