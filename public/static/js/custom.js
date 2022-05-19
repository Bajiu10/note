function htmlSpecialChars(str) {
    let s = "";
    if (str.length === 0) return "";
    for (var i = 0; i < str.length; i++) {
        switch (str.substr(i, 1)) {
            case "<":
                s += "&lt;";
                break;
            case ">":
                s += "&gt;";
                break;
            case "&":
                s += "&amp;";
                break;
            case " ":
                if (str.substr(i + 1, 1) === " ") {
                    s += " &nbsp;";
                    i++;
                } else s += " ";
                break;
            case "\"":
                s += "&quot;";
                break;
            case "\n":
                s += "<br>";
                break;
            default:
                s += str.substr(i, 1);
                break;
        }
    }
    return s;
}

function time_convert(time) {
    let now = parseInt((new Date()).getTime() / 1000);
    let diff = now - parseInt(time);
    if (diff < 60) {
        return "刚刚";
    }
    if (diff < 3600) {
        return parseInt(diff / 60) + "分钟前";
    }
    if (diff < 86400) {
        return parseInt(diff / 3600) + "小时前";
    }
    if (diff < 86400 * 5) {
        return parseInt(diff / 86400) + "天前";
    }
    let dest = new Date(parseInt(time * 1000));
    return dest.getFullYear() + "/" + (dest.getMonth() + 1) + "/" + dest.getDate();
}


$(document).click(function (e) {
    $(".post-pop-plane").removeClass("post-pop-plane-show");
    e.stopPropagation();
});
$(".post-info-switch-sidebar").click(function () {
    $(".sidebar").toggleClass("sidebar-display");
    $(".post-main").toggleClass("post-main-full");
    $(this).toggleClass("post-info-switch-sidebar-show");
})
$(".clickshow").click(function () {
    $("#share-plane").removeClass("share-plane-show");
    $("#qrcode-plane").removeClass("share-plane-show");
    $(this).toggleClass("clickshow-show");
});

function showplane(btn_name, plane_name, e) {
    $(".post-pop-plane").removeClass("post-pop-plane-show");
    $(plane_name).addClass("post-pop-plane-show");
    var btn_left = $(btn_name).position().left;
    var plane_width = $(plane_name).outerWidth();
    var btn_width = $(btn_name).outerWidth();
    var btn_hight = $(btn_name).outerHeight();
    $(plane_name).css("left", btn_left - plane_width / 2 + btn_width / 2 + "px");
    $(plane_name).css("bottom", btn_hight + 10 + "px");
    e.stopPropagation();
}

$(".post-qrcode-btn").click((e) => {
    $("#qrcode-plane").addClass("share-plane-show");
    e.stopPropagation();
});
$(document).ready(function () {
    if ($("#qrcode-img").length > 0) {
        new QRCode($("#qrcode-img")[0], window.location.href);
    }
});
$(this).next().animate({height: "100%"}, 500);
$(".zd-plane-title").click(function (e) {
    if (!$(this).hasClass("zd-plane-title-zk")) {
        $(this).addClass("zd-plane-title-zk");
        $(this).next().slideDown();
    } else {
        $(this).removeClass("zd-plane-title-zk")
        $(this).next().slideUp();
    }
})
if ($(".code-bar-btn-copy-fonticon").length > 0) {
    var clipboard = new ClipboardJS(".code-bar-btn-copy-fonticon", {
        text: function (trigger) {
            copynotmsg = 1;
            return $(trigger).parent().prev().text();
        }
    });
    clipboard.on("success", function (e) {
        $(e.trigger).toggleClass("fal fa-clone")
        $(e.trigger).toggleClass("fal fa-check")
        setTimeout(function () {
            $(e.trigger).toggleClass("fal fa-clone")
            $(e.trigger).toggleClass("fal fa-check")
        }, 2000);
    });
    clipboard.on("error", function (e) {
        $(e.trigger).toggleClass("fal fa-clone")
        $(e.trigger).toggleClass("fal times")
        setTimeout(function () {
            $(e.trigger).toggleClass("fal fa-clone")
            $(e.trigger).toggleClass("fal times")
        }, 2000);
    });
}
if ($(".btn-copy-pwd").length > 0) {
    var copy_pwd = new ClipboardJS(".btn-copy-pwd", {
        text: function (trigger) {
            copynotmsg = 1;
            return $(trigger).parent().find(".c-downbtn-pwd-key").text();
        }
    });
    copy_pwd.on("success", function (e) {
        $(e.trigger).toggleClass("fal fa-clone")
        $(e.trigger).toggleClass("fal fa-check")
        setTimeout(function () {
            $(e.trigger).toggleClass("fal fa-clone")
            $(e.trigger).toggleClass("fal fa-check")
        }, 2000);
    });
}


