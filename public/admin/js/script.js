
window.addEventListener("load", function (event) {
    const toggleClass = function (element, className) {
        if (element.classList.contains(className)) {
            element.classList.remove(className);
            return true;
        } else {
            element.classList.add(className);
            return false;
        }
    };

    document.getElementById("app_top_right_menu").addEventListener("click", function (event) {
        const classes = event.target.parentNode.classList;
        if (classes.contains("peer") || classes.contains("peers")) {
            event.stopPropagation();
            event.preventDefault();
        }

        toggleClass(event.currentTarget, "show");
    });

    document.body.addEventListener("click", function (event) {
        document.getElementById("app_top_right_menu").classList.remove("show");
    });
});

const cookie = new function () {
    this.set = function (name, value, expires) {
        var cookie = name + "=" + escape(value) + ";";
        if (expires) {
            if (expires instanceof Date) {
                if (isNaN(expires.getTime())) {
                    expires = new Date();
                }
            } else {
                let date = new Date().getTime();
                date += parseInt(expires) * 1000 * 60 * 60 * 24;

                expires = new Date(date);
            }

            cookie += "expires=" + expires.toGMTString() + ";";
        }

        cookie += "path=/;";
        document.cookie = cookie;
    };

    this.get = function (name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");

        if (parts.length == 2) {
            return parts.pop().split(";").shift();
        }
    };
};

$(window).on({
    load: function (event) {
        const toggleClass = function (element, className) {
            if (element.classList.contains(className)) {
                element.classList.remove(className);
                return true;
            } else {
                element.classList.add(className);
                return false;
            }
        };

        const cookieName = "app_tab_opened";

        $("#sidebar-toggle").on("click", function (event) {
            if (toggleClass(document.body, "is-collapsed")) {
                cookie.set(cookieName, "open", 100);
            } else {
                cookie.set(cookieName, "close", 100);
            }
        });

        const changeTabOption = function (event) {
            if (window.innerWidth < 992) {
                document.body.classList.remove("is-collapsed");
            } else {
                if (cookie.get(cookieName) == "open") {
                    document.body.classList.remove("is-collapsed");
                } else {
                    document.body.classList.add("is-collapsed");
                }
            }

            if (!event || event.type != "resize") {
                $(window).trigger("resize");
            }
        };

        $(window).on("resize", changeTabOption);
        changeTabOption(null);

        $("a.dropdown-toggle").on("click", function (e) {
            const $this = $(this).parent();
            $this.toggleClass("open");

            let el = $this.find(".dropdown-menu");
            if ($this.hasClass("open")) {
                el.css("display", "block");
                let height = el.height();
                el.css("height", "0");

                el.animate({
                    display: "block",
                    overflow: "hidden",
                    height: height + "px"
                }, 100, function () {
                    el.removeAttr("style").css("display", "block");
                });
            } else {
                el.animate({
                    display: "block",
                    overflow: "hidden",
                    height: "0px"
                }, 100, function () {
                    el.removeAttr("style").css("display", "none");
                });
            }
        });
    },
    resize: function (event) {
        const el = $("#sidebar-toggle");
        if (window.innerWidth > 1439) {
            el.show();
        } else {
            el.hide();
        }
    }

}).trigger("resize");

$(function () {
    $("input[type='file'].file-upload").on("change", function (event) {
        $(this).prev().removeClass("question-icons");
    });

    $("#browse-file").on("change", function (event) {
        $("#multiple-answers").hide();
        $("[name='answer_type']").val("single_file_answer");
    });

    $("input[type='file'].hidden").on("change", function (event) {
        $(this).prev().removeClass("answer-icons");
    });
})