<style>

/* <!-- -------<スタイルCSS>------- --> */
    body {
        font-family: 'Noto Serif JP', serif;
        margin:0px;
        padding-top:200px
        padding:0px;
        font-size:10.5px;
        background: -webkit-linear-gradient(130deg, rgb(22, 192, 237,5%), rgb(150, 131, 206,5%));
        background: linear-gradient(130deg, rgb(22, 192, 237,5%), rgb(150, 131, 206,5%));
        color: #333;
    }

    h3 {
      padding:0px;
      margin:0px;
    }

    .main {
        margin-top:90px
    }
    table {
        font-family: 'Noto Serif JP', serif;
        font-size: 14px;
        margin: 40px auto;
    }
    th,td {
        padding: 14px;
        font-weight: normal;
        text-align: left;
        border-bottom: 1px solid #ccc;
        /* border-bottom: 1px solid #646566; */
        /* word-break : break-all; */
    }
    td span {
        font-size: 90%;
    }
    a {
        position: relative;
        padding: 5px;
        display: inline-block;
        transition: .3s;
        color: #00ACC1;
        text-decoration: none;/*元々のアンダーラインを非表示にしておく*/
    }
    /*hover時の表示*/
    a::after {
        font-weight: bold;
        position: absolute;
        bottom: 0;
        left: 50%;
        content: '';
        width: 0;
        height: 1px;
        background-color: #00ACC1;
        transition: .3s;
        transform: translateX(-50%);
    }
    a:hover::after {
        width: 100%;
    }

    .jumbotron {
      text-align: center;
    }

    fieldset {
      /* display: block; */
      display: inline-block;
      margin: auto;
      border-radius:20px;
      border: 1px solid #ddd;
      padding: 20px 70px;
      margin: 0;
      width: fit-content;
      /* 内部のコンテンツに合わせて幅を調整 */
    }

    /* これはCSSかかってない。rcrd_index.phpのcss参照 */
    .item_field {
      border: solid 0.5 #ddd;
      border-radius: 10px;
      background: white;
      margin: 10px 0px;
      width: 600px;
    }

    select {
      font-family: 'Noto Serif JP', serif;
      font-size:17px;
      padding:4px 8px;
      margin: 5px 5px;
      border: solid 0.5px #ddd;
      border-radius: 20px;
    }

    .input_date {
      font-family: 'Noto Serif JP', serif;
      font-size:17px;
      padding:0.5px 8px;
      margin: 5px 5px;
      border: solid 0.5px #ddd;
      border-radius: 20px;
    }
    /* header */

header {
  position: fixed;
  z-index: 999;
  top: 0;
  left: 0;
  width: 100%;
  padding: 15px 0;
  background: #eee;
  /* height:64px; */
  background: -webkit-linear-gradient(130deg, rgb(22, 192, 237,70%), rgb(150, 131, 206,70%));
 background: linear-gradient(130deg, rgb(22, 192, 237,70%), rgb(150, 131, 206,70%));

 /* background: linear-gradient(
      to right,
      rgba(246, 79, 89, 0.6),
      rgba(196, 113, 237, 0.6),
      rgba(18, 194, 233, 0.6)
    ); */

  /* background: #fff; */
  /* background:cadetblue; */
  /* border-bottom: solid 0.5px #63d4db; */
  /* box-shadow: 0 0 0.5px #63d4db,0 0 3px #63d4db; */
  /* text-shadow: 0 0 1px #fff,0 0 7px #fff; */
}

.navbar-brand {
  color: #333;
}

header .inner {
  position: relative;
  padding: 0 20px;
  display: flex;
  align-items: center;
  height: 100%;
}
/* .logo */

header .logo {
  position: relative;
  width: 100px;
  margin: 0;
  padding: 0;
}
header .logo a {
  font-weight: bold;
  text-decoration: none;
  color: #333;
}

@media screen and (max-width: 767px) {
  header .logo {
    padding: 0;
  }
  header .logo a {
  }
}

/* scroll */

header {
  transition: height 0.4s cubic-bezier(0.34, 0.615, 0.4, 0.985);
  /* background:cadetblue; */
}
header.scroll {
  height: 60px;
  position: fixed;
  z-index: 9999;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
header .logo {
  transition: width 0.4s cubic-bezier(0.34, 0.615, 0.4, 0.985);
}
header.scroll .logo {
  width: 70px;
}

/* header-navi-box */

header .navi {
  margin: 0 0 0 auto;
  padding: 0;
  font-size: 14px;
  font-weight: bold;
  display: flex;
  align-items: center;
  list-style: none;
}
header .navi li {
  margin: 5px 0 5px 40px;
}
header .navi li:first-child {
  margin-left: 0;
}
header .navi li a {
  display: block;
  box-sizing: border-box;
  text-decoration: none;
}
header .navi li a:hover {
  text-decoration: underline;
}
.button{
  background: #007bff;
  color: #FFF;
  padding: 10px 20px;
  border-radius: 50px;
}

@media screen and (max-width: 767px) {
  header .navi {
    display: none;
  }
}

/* open-button */

.sp-navi-toggle {
  display: none;
  margin: auto 0;
  font-size: 10px;
  font-weight: bold;
  line-height: 1;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 40px;
  width: 16px;
  height: 25px;
  transition: all 0.4s;
  /* color: white; */
  color: #464646;
  border: none;
  outline: none;
  background: none;
  -webkit-appearance: unset;
}
.sp-navi-toggle .menu,
.sp-navi-toggle .close {
  position: absolute;
  bottom: 0;
  left: -50%;
  display: block;
  width: 34px;
  height: 11px;
}
.sp-navi-toggle .close {
  display: none;
}
.sp-navi-toggle .bar {
  position: absolute;
  left: 0;
  width: 100%;
  height: 2px;
  background-color: #464646;
}
.sp-navi-toggle .bar:nth-of-type(1) {
  top: 0;
}
.sp-navi-toggle .bar:nth-of-type(2) {
  top: 5px;
}
.sp-navi-toggle .bar:nth-of-type(3) {
  top: 10px;
}

/* close-button */

html.sidebar-is-open .sp-navi-toggle .bar:nth-of-type(1) {
  top: 5px;
  transform: rotate(45deg);
}
html.sidebar-is-open .sp-navi-toggle .bar:nth-of-type(2) {
  top: 5px;
  transform: rotate(-45deg);
}
html.sidebar-is-open .sp-navi-toggle .bar:nth-of-type(3) {
  display: none;
}
html.sidebar-is-open .sp-navi-toggle .menu {
  display: none;
}
html.sidebar-is-open .sp-navi-toggle .close {
  display: block;
}

@media screen and (max-width: 767px) {
  .sp-navi-toggle{
    display: block;
  }
}

/* sp-navi */

.sp-navi-box {
  display: none;
}
.sp-navi {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  list-style: none;
  width: 100%;
  height: 100vh;
  font-size: 14px;
  margin: 0;
  padding: 0;
}
.sp-navi li {
  padding: 20px 0;
}
.sp-navi li a {
  display: block;
  box-sizing: border-box;
  text-decoration: none;
  font-weight: bold;
}
.sp-navi li a:hover {
  text-decoration: underline;
}




@media screen and (max-width: 767px) {
  html.sidebar-is-open .sp-navi-box {
    display: block;
  }
  html.sidebar-is-open {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    width: 100%;
  }
}

body {
  margin: 0;
  padding: 0;
}
/* a{
  color: #333;
} */
.subBtn {
  display: block;
  margin: auto;

  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 50px;
  background-color: #007bff;
  color: white;
  cursor: pointer;
}

.subBtn:hover {
  background-color: #0056b3;
}

    /* <!-- -------<スタイルCSS>------- --> */
</style>
<script>
  //sp menu

  (function () {
  document.addEventListener('DOMContentLoaded', function () {
    // スマホメニュー
    const bodyElement = document.querySelector("body");
    if (!bodyElement) {
      console.error("Body element not found.");
      return;
    }

    // メニューのHTMLを挿入
    bodyElement.insertAdjacentHTML("afterbegin", '<div class="sp-navi-box"><div class="sp-navi"></div></div>');
    const naviElement = document.querySelector(".navi");
    if (!naviElement) {
      console.error("Navi element not found.");
      return;
    }
    document.querySelector(".sp-navi").innerHTML = naviElement.innerHTML;

    const documentElement = document.querySelector("html");
    const spNaviToggle = document.querySelector(".sp-navi-toggle");

    if (!spNaviToggle) {
      console.error("SP Navi Toggle element not found.");
      return;
    }

    const openSidebar = function () {
      const scl_point = window.pageYOffset;
      documentElement.classList.add("sidebar-is-open");
      bodyElement.style.top = `-${scl_point}px`;
    };

    const closeSidebar = function () {
      documentElement.classList.remove("sidebar-is-open");
      const top = parseInt(bodyElement.style.top || '0', 10);
      window.scrollTo(0, -top);
      bodyElement.style.top = '0';
    };

    spNaviToggle.addEventListener("click", function () {
      if (documentElement.classList.contains("sidebar-is-open")) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });
  });
})();

</script>
