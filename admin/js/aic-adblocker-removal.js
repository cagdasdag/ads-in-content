! function(e) {
    function t(o) {
        if (n[o]) return n[o].exports;
        var r = n[o] = {
            exports: {},
            id: o,
            loaded: !1
        };
        return e[o].call(r.exports, r, r.exports, t), r.loaded = !0, r.exports
    }
    var n = {};
    return t.m = e, t.c = n, t.p = "", t(0)
}([function(e, t) {
    "use strict";
    document.addEventListener("DOMContentLoaded", function() {
        var e = document.getElementById("aic-adblock-notice");
        null != e && e.remove()
    })
}]);