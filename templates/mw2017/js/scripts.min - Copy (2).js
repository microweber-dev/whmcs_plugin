function checkAll(e, t) {
    "." != e[0] && (e = "." + e), jQuery(e).removeAttr("checked"), jQuery(t).is(":checked") && jQuery(e).click()
}

function clickableSafeRedirect(e, t, n) {
    var i = e.target.tagName.toLowerCase(),
        r = e.target.parentNode.tagName.toLowerCase(),
        o = e.target.parentNode.parentNode.parentNode;
    return !jQuery(o).hasClass("collapsed") && void("button" != i && "a" != i && "button" != r && "a" != r && (n ? window.open(t) : window.location.href = t))
}

function popupWindow(e, t, n, i, r) {
    var o = (screen.width - n) / 2,
        a = (screen.height - i) / 2;
    o < 0 && (o = 0), a < 0 && (a = 0);
    var s = "height=" + i + ",";
    s += "width=" + n + ",", s += "top=" + a + ",", s += "left=" + o + ",", s += r, win = window.open(e, t, s), win.window.focus()
}

function addRenewalToCart(e, t) {
    jQuery("#domainRow" + e).attr("disabled", "disabled"), jQuery("#domainRow" + e).find("select,button").attr("disabled", "disabled"), jQuery(t).html('<span class="glyphicon glyphicon-shopping-cart"></span> Adding...');
    var n = jQuery("#renewalPeriod" + e).val();
    jQuery.post("clientarea.php", "addRenewalToCart=1&token=" + csrfToken + "&renewID=" + e + "&period=" + n, function(e) {
        jQuery("#cartItemCount").html(1 * jQuery("#cartItemCount").html() + 1), jQuery(t).html('<span class="glyphicon glyphicon-shopping-cart"></span> Added'), jQuery("#btnCheckout").fadeIn()
    })
}

function selectChangeNavigate(e) {
    window.location.href = $(e).val()
}

function extraTicketAttachment() {
    jQuery("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control" />')
}

function getStats(e) {
    jQuery.post("serverstatus.php", "getstats=1&num=" + e, function(t) {
        jQuery("#load" + e).html(t.load), jQuery("#uptime" + e).html(t.uptime)
    }, "json")
}

function checkPort(e, t) {
    jQuery.post("serverstatus.php", "ping=1&num=" + e + "&port=" + t, function(n) {
        jQuery("#port" + t + "_" + e).html(n)
    })
}

function getticketsuggestions() {
    currentcheckcontent = jQuery("#message").val(), currentcheckcontent != lastcheckcontent && "" != currentcheckcontent && (jQuery.post("submitticket.php", {
        action: "getkbarticles",
        text: currentcheckcontent
    }, function(e) {
        e && (jQuery("#searchresults").html(e), jQuery("#searchresults").hide().removeClass("hidden").slideDown())
    }), lastcheckcontent = currentcheckcontent), setTimeout("getticketsuggestions();", 3e3)
}

function refreshCustomFields(e) {
    jQuery("#customFieldsContainer").load("submitticket.php", {
        action: "getcustomfields",
        deptid: $(e).val()
    })
}

function autoSubmitFormByContainer(e) {
    jQuery("#" + e).find("form:first").submit()
}

function useDefaultWhois(e) {
    jQuery("." + e.substr(0, e.length - 1) + "customwhois").attr("disabled", !0), jQuery("." + e.substr(0, e.length - 1) + "defaultwhois").attr("disabled", !1), jQuery("#" + e.substr(0, e.length - 1) + "1").attr("checked", "checked")
}

function useCustomWhois(e) {
    jQuery("." + e.substr(0, e.length - 1) + "customwhois").attr("disabled", !1), jQuery("." + e.substr(0, e.length - 1) + "defaultwhois").attr("disabled", !0), jQuery("#" + e.substr(0, e.length - 1) + "2").attr("checked", "checked")
}

function editBillingAddress() {
    jQuery("#billingAddressSummary").hide(), jQuery(".cc-billing-address").hide().removeClass("hidden").fadeIn()
}

function showNewCardInputFields() {
    jQuery(".cc-details").hasClass("hidden") && jQuery(".cc-details").hide().removeClass("hidden"), jQuery(".cc-details").slideDown(), jQuery("#btnEditBillingAddress").removeAttr("disabled")
}

function hideNewCardInputFields() {
    jQuery(".cc-billing-address").slideUp(), jQuery(".cc-details").slideUp(), jQuery("#btnEditBillingAddress").attr("disabled", "disabled"), jQuery("#billingAddressSummary").hasClass("hidden") ? jQuery("#billingAddressSummary").hide().removeClass("hidden").slideDown() : jQuery("#billingAddressSummary").slideDown()
}

function getTicketSuggestions() {
    var e = jQuery("#inputMessage").val();
    e != lastTicketMsg && "" != e && (jQuery.post("submitticket.php", {
        action: "getkbarticles",
        text: e
    }, function(e) {
        e && (jQuery("#autoAnswerSuggestions").html(e), jQuery("#autoAnswerSuggestions").is(":visible") || jQuery("#autoAnswerSuggestions").hide().removeClass("hidden").slideDown())
    }), lastTicketMsg = e), setTimeout("getTicketSuggestions()", 3e3)
}

function deleteContact(e, t) {
    confirm(e) && (window.location = "clientarea.php?action=contacts&delete=true&id=" + t + "&token=" + csrfToken)
}

function openModal(e, t, n, i, r, o, a, s) {
    if (jQuery("#modalAjax .modal-title").html(n), i && jQuery("#modalAjax").children('div[class="modal-dialog"]').addClass(i), r && jQuery("#modalAjax").addClass(r), r && jQuery("#modalAjax").addClass(r), o ? (jQuery("#modalAjax .modal-submit").show().html(o), a && jQuery("#modalAjax .modal-submit").attr("id", a)) : jQuery("#modalAjax .modal-submit").hide(), s && jQuery("#modalAjaxClose").hide(), jQuery("#modalAjax .modal-body").html(""), jQuery("#modalSkip").hide(), jQuery("#modalAjax .modal-submit").prop("disabled", !0), jQuery("#modalAjax").modal("show"), jQuery.post(e, t, function(e) {
            updateAjaxModal(e)
        }, "json").fail(function() {
            jQuery("#modalAjax .modal-body").html("An error occurred while communicating with the server. Please try again."), jQuery("#modalAjax .loader").fadeOut()
        }), a) {
        var l = jQuery("#" + a);
        l.off("click"), l.on("click", function() {
            var e = jQuery("#modalAjax").find("form");
            jQuery("#modalAjax .loader").show();
            jQuery.post(e.attr("action"), e.serialize(), function(e) {
                updateAjaxModal(e)
            }, "json").fail(function() {
                jQuery("#modalAjax .modal-body").html("An error occurred while communicating with the server. Please try again."), jQuery("#modalAjax .loader").fadeOut()
            })
        })
    }
}

function updateAjaxModal(e) {
    if (e.dismiss && dialogClose(), e.successMsg && jQuery.growl.notice({
            title: e.successMsgTitle,
            message: e.successMsg
        }), e.errorMsg && jQuery.growl.warning({
            title: e.errorMsgTitle,
            message: e.errorMsg
        }), e.title && jQuery("#modalAjax .modal-title").html(e.title), e.body ? jQuery("#modalAjax .modal-body").html(e.body) : e.url && jQuery.post(e.url, "", function(e) {
            jQuery("#modalAjax").find(".modal-body").html(e.body)
        }, "json").fail(function() {
            jQuery("#modalAjax").find(".modal-body").html("An error occurred while communicating with the server. Please try again."), jQuery("#modalAjax").find(".loader").fadeOut()
        }), e.submitlabel && (jQuery("#modalAjax .modal-submit").html(e.submitlabel).show(), e.submitId && jQuery("#modalAjax").find(".modal-submit").attr("id", e.submitId)), e.submitId) {
        var t = jQuery("#" + e.submitId);
        t.off("click"), t.on("click", function() {
            var e = jQuery("#modalAjax").find("form");
            jQuery("#modalAjax .loader").show();
            jQuery.post(e.attr("action"), e.serialize(), function(e) {
                updateAjaxModal(e)
            }, "json").fail(function() {
                jQuery("#modalAjax .modal-body").html("An error occurred while communicating with the server. Please try again."), jQuery("#modalAjax .loader").fadeOut()
            })
        })
    }
    jQuery("#modalAjax .loader").fadeOut(), jQuery("#modalAjax .modal-submit").removeProp("disabled")
}

function dialogSubmit() {
    jQuery("#modalAjax .modal-submit").prop("disabled", !0), jQuery("#modalAjax .loader").show(), jQuery.post("", jQuery("#modalAjax").find("form").serialize(), function(e) {
        updateAjaxModal(e)
    }, "json").fail(function() {
        jQuery("#modalAjax .modal-body").html("An error occurred while communicating with the server. Please try again."), jQuery("#modalAjax .loader").fadeOut()
    })
}

function dialogClose() {
    jQuery("#modalAjax").modal("hide")
}
if (function(e, t) {
        "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
            if (!e.document) throw new Error("jQuery requires a window with a document");
            return t(e)
        } : t(e)
    }("undefined" != typeof window ? window : this, function(e, t) {
        function n(e) {
            var t = !!e && "length" in e && e.length,
                n = fe.type(e);
            return "function" !== n && !fe.isWindow(e) && ("array" === n || 0 === t || "number" == typeof t && t > 0 && t - 1 in e)
        }

        function i(e, t, n) {
            if (fe.isFunction(t)) return fe.grep(e, function(e, i) {
                return !!t.call(e, i, e) !== n
            });
            if (t.nodeType) return fe.grep(e, function(e) {
                return e === t !== n
            });
            if ("string" == typeof t) {
                if (Se.test(t)) return fe.filter(t, e, n);
                t = fe.filter(t, e)
            }
            return fe.grep(e, function(e) {
                return fe.inArray(e, t) > -1 !== n
            })
        }

        function r(e, t) {
            do e = e[t]; while (e && 1 !== e.nodeType);
            return e
        }

        function o(e) {
            var t = {};
            return fe.each(e.match(Ae) || [], function(e, n) {
                t[n] = !0
            }), t
        }

        function a() {
            ie.addEventListener ? (ie.removeEventListener("DOMContentLoaded", s), e.removeEventListener("load", s)) : (ie.detachEvent("onreadystatechange", s), e.detachEvent("onload", s))
        }

        function s() {
            (ie.addEventListener || "load" === e.event.type || "complete" === ie.readyState) && (a(), fe.ready())
        }

        function l(e, t, n) {
            if (void 0 === n && 1 === e.nodeType) {
                var i = "data-" + t.replace(Ee, "-$1").toLowerCase();
                if (n = e.getAttribute(i), "string" == typeof n) {
                    try {
                        n = "true" === n || "false" !== n && ("null" === n ? null : +n + "" === n ? +n : Ne.test(n) ? fe.parseJSON(n) : n)
                    } catch (e) {}
                    fe.data(e, t, n)
                } else n = void 0
            }
            return n
        }

        function u(e) {
            var t;
            for (t in e)
                if (("data" !== t || !fe.isEmptyObject(e[t])) && "toJSON" !== t) return !1;
            return !0
        }

        function c(e, t, n, i) {
            if (Le(e)) {
                var r, o, a = fe.expando,
                    s = e.nodeType,
                    l = s ? fe.cache : e,
                    u = s ? e[a] : e[a] && a;
                if (u && l[u] && (i || l[u].data) || void 0 !== n || "string" != typeof t) return u || (u = s ? e[a] = ne.pop() || fe.guid++ : a), l[u] || (l[u] = s ? {} : {
                    toJSON: fe.noop
                }), "object" != typeof t && "function" != typeof t || (i ? l[u] = fe.extend(l[u], t) : l[u].data = fe.extend(l[u].data, t)), o = l[u], i || (o.data || (o.data = {}), o = o.data), void 0 !== n && (o[fe.camelCase(t)] = n), "string" == typeof t ? (r = o[t], null == r && (r = o[fe.camelCase(t)])) : r = o, r
            }
        }

        function d(e, t, n) {
            if (Le(e)) {
                var i, r, o = e.nodeType,
                    a = o ? fe.cache : e,
                    s = o ? e[fe.expando] : fe.expando;
                if (a[s]) {
                    if (t && (i = n ? a[s] : a[s].data)) {
                        fe.isArray(t) ? t = t.concat(fe.map(t, fe.camelCase)) : t in i ? t = [t] : (t = fe.camelCase(t), t = t in i ? [t] : t.split(" ")), r = t.length;
                        for (; r--;) delete i[t[r]];
                        if (n ? !u(i) : !fe.isEmptyObject(i)) return
                    }(n || (delete a[s].data, u(a[s]))) && (o ? fe.cleanData([e], !0) : de.deleteExpando || a != a.window ? delete a[s] : a[s] = void 0)
                }
            }
        }

        function h(e, t, n, i) {
            var r, o = 1,
                a = 20,
                s = i ? function() {
                    return i.cur()
                } : function() {
                    return fe.css(e, t, "")
                },
                l = s(),
                u = n && n[3] || (fe.cssNumber[t] ? "" : "px"),
                c = (fe.cssNumber[t] || "px" !== u && +l) && Pe.exec(fe.css(e, t));
            if (c && c[3] !== u) {
                u = u || c[3], n = n || [], c = +l || 1;
                do o = o || ".5", c /= o, fe.style(e, t, c + u); while (o !== (o = s() / l) && 1 !== o && --a)
            }
            return n && (c = +c || +l || 0, r = n[1] ? c + (n[1] + 1) * n[2] : +n[2], i && (i.unit = u, i.start = c, i.end = r)), r
        }

        function f(e) {
            var t = ze.split("|"),
                n = e.createDocumentFragment();
            if (n.createElement)
                for (; t.length;) n.createElement(t.pop());
            return n
        }

        function p(e, t) {
            var n, i, r = 0,
                o = "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName(t || "*") : "undefined" != typeof e.querySelectorAll ? e.querySelectorAll(t || "*") : void 0;
            if (!o)
                for (o = [], n = e.childNodes || e; null != (i = n[r]); r++) !t || fe.nodeName(i, t) ? o.push(i) : fe.merge(o, p(i, t));
            return void 0 === t || t && fe.nodeName(e, t) ? fe.merge([e], o) : o
        }

        function g(e, t) {
            for (var n, i = 0; null != (n = e[i]); i++) fe._data(n, "globalEval", !t || fe._data(t[i], "globalEval"))
        }

        function m(e) {
            Qe.test(e.type) && (e.defaultChecked = e.checked)
        }

        function v(e, t, n, i, r) {
            for (var o, a, s, l, u, c, d, h = e.length, v = f(t), y = [], b = 0; b < h; b++)
                if (a = e[b], a || 0 === a)
                    if ("object" === fe.type(a)) fe.merge(y, a.nodeType ? [a] : a);
                    else if (Ue.test(a)) {
                for (l = l || v.appendChild(t.createElement("div")), u = (Be.exec(a) || ["", ""])[1].toLowerCase(), d = qe[u] || qe._default, l.innerHTML = d[1] + fe.htmlPrefilter(a) + d[2], o = d[0]; o--;) l = l.lastChild;
                if (!de.leadingWhitespace && We.test(a) && y.push(t.createTextNode(We.exec(a)[0])), !de.tbody)
                    for (a = "table" !== u || Ve.test(a) ? "<table>" !== d[1] || Ve.test(a) ? 0 : l : l.firstChild, o = a && a.childNodes.length; o--;) fe.nodeName(c = a.childNodes[o], "tbody") && !c.childNodes.length && a.removeChild(c);
                for (fe.merge(y, l.childNodes), l.textContent = ""; l.firstChild;) l.removeChild(l.firstChild);
                l = v.lastChild
            } else y.push(t.createTextNode(a));
            for (l && v.removeChild(l), de.appendChecked || fe.grep(p(y, "input"), m), b = 0; a = y[b++];)
                if (i && fe.inArray(a, i) > -1) r && r.push(a);
                else if (s = fe.contains(a.ownerDocument, a), l = p(v.appendChild(a), "script"), s && g(l), n)
                for (o = 0; a = l[o++];) Me.test(a.type || "") && n.push(a);
            return l = null, v
        }

        function y() {
            return !0
        }

        function b() {
            return !1
        }

        function x() {
            try {
                return ie.activeElement
            } catch (e) {}
        }

        function w(e, t, n, i, r, o) {
            var a, s;
            if ("object" == typeof t) {
                "string" != typeof n && (i = i || n, n = void 0);
                for (s in t) w(e, s, n, i, t[s], o);
                return e
            }
            if (null == i && null == r ? (r = n, i = n = void 0) : null == r && ("string" == typeof n ? (r = i, i = void 0) : (r = i, i = n, n = void 0)), r === !1) r = b;
            else if (!r) return e;
            return 1 === o && (a = r, r = function(e) {
                return fe().off(e), a.apply(this, arguments)
            }, r.guid = a.guid || (a.guid = fe.guid++)), e.each(function() {
                fe.event.add(this, t, r, i, n)
            })
        }

        function C(e, t) {
            return fe.nodeName(e, "table") && fe.nodeName(11 !== t.nodeType ? t : t.firstChild, "tr") ? e.getElementsByTagName("tbody")[0] || e.appendChild(e.ownerDocument.createElement("tbody")) : e
        }

        function S(e) {
            return e.type = (null !== fe.find.attr(e, "type")) + "/" + e.type, e
        }

        function T(e) {
            var t = rt.exec(e.type);
            return t ? e.type = t[1] : e.removeAttribute("type"), e
        }

        function k(e, t) {
            if (1 === t.nodeType && fe.hasData(e)) {
                var n, i, r, o = fe._data(e),
                    a = fe._data(t, o),
                    s = o.events;
                if (s) {
                    delete a.handle, a.events = {};
                    for (n in s)
                        for (i = 0, r = s[n].length; i < r; i++) fe.event.add(t, n, s[n][i])
                }
                a.data && (a.data = fe.extend({}, a.data))
            }
        }

        function D(e, t) {
            var n, i, r;
            if (1 === t.nodeType) {
                if (n = t.nodeName.toLowerCase(), !de.noCloneEvent && t[fe.expando]) {
                    r = fe._data(t);
                    for (i in r.events) fe.removeEvent(t, i, r.handle);
                    t.removeAttribute(fe.expando)
                }
                "script" === n && t.text !== e.text ? (S(t).text = e.text, T(t)) : "object" === n ? (t.parentNode && (t.outerHTML = e.outerHTML), de.html5Clone && e.innerHTML && !fe.trim(t.innerHTML) && (t.innerHTML = e.innerHTML)) : "input" === n && Qe.test(e.type) ? (t.defaultChecked = t.checked = e.checked, t.value !== e.value && (t.value = e.value)) : "option" === n ? t.defaultSelected = t.selected = e.defaultSelected : "input" !== n && "textarea" !== n || (t.defaultValue = e.defaultValue)
            }
        }

        function _(e, t, n, i) {
            t = oe.apply([], t);
            var r, o, a, s, l, u, c = 0,
                d = e.length,
                h = d - 1,
                f = t[0],
                g = fe.isFunction(f);
            if (g || d > 1 && "string" == typeof f && !de.checkClone && it.test(f)) return e.each(function(r) {
                var o = e.eq(r);
                g && (t[0] = f.call(this, r, o.html())), _(o, t, n, i)
            });
            if (d && (u = v(t, e[0].ownerDocument, !1, e, i), r = u.firstChild, 1 === u.childNodes.length && (u = r), r || i)) {
                for (s = fe.map(p(u, "script"), S), a = s.length; c < d; c++) o = u, c !== h && (o = fe.clone(o, !0, !0), a && fe.merge(s, p(o, "script"))), n.call(e[c], o, c);
                if (a)
                    for (l = s[s.length - 1].ownerDocument, fe.map(s, T), c = 0; c < a; c++) o = s[c], Me.test(o.type || "") && !fe._data(o, "globalEval") && fe.contains(l, o) && (o.src ? fe._evalUrl && fe._evalUrl(o.src) : fe.globalEval((o.text || o.textContent || o.innerHTML || "").replace(ot, "")));
                u = r = null
            }
            return e
        }

        function j(e, t, n) {
            for (var i, r = t ? fe.filter(t, e) : e, o = 0; null != (i = r[o]); o++) n || 1 !== i.nodeType || fe.cleanData(p(i)), i.parentNode && (n && fe.contains(i.ownerDocument, i) && g(p(i, "script")), i.parentNode.removeChild(i));
            return e
        }

        function A(e, t) {
            var n = fe(t.createElement(e)).appendTo(t.body),
                i = fe.css(n[0], "display");
            return n.detach(), i
        }

        function I(e) {
            var t = ie,
                n = ut[e];
            return n || (n = A(e, t), "none" !== n && n || (lt = (lt || fe("<iframe frameborder='0' width='0' height='0'/>")).appendTo(t.documentElement), t = (lt[0].contentWindow || lt[0].contentDocument).document, t.write(), t.close(), n = A(e, t), lt.detach()), ut[e] = n), n
        }

        function $(e, t) {
            return {
                get: function() {
                    return e() ? void delete this.get : (this.get = t).apply(this, arguments)
                }
            }
        }

        function L(e) {
            if (e in Tt) return e;
            for (var t = e.charAt(0).toUpperCase() + e.slice(1), n = St.length; n--;)
                if (e = St[n] + t, e in Tt) return e
        }

        function N(e, t) {
            for (var n, i, r, o = [], a = 0, s = e.length; a < s; a++) i = e[a], i.style && (o[a] = fe._data(i, "olddisplay"), n = i.style.display, t ? (o[a] || "none" !== n || (i.style.display = ""), "" === i.style.display && He(i) && (o[a] = fe._data(i, "olddisplay", I(i.nodeName)))) : (r = He(i), (n && "none" !== n || !r) && fe._data(i, "olddisplay", r ? n : fe.css(i, "display"))));
            for (a = 0; a < s; a++) i = e[a], i.style && (t && "none" !== i.style.display && "" !== i.style.display || (i.style.display = t ? o[a] || "" : "none"));
            return e
        }

        function E(e, t, n) {
            var i = xt.exec(t);
            return i ? Math.max(0, i[1] - (n || 0)) + (i[2] || "px") : t
        }

        function R(e, t, n, i, r) {
            for (var o = n === (i ? "border" : "content") ? 4 : "width" === t ? 1 : 0, a = 0; o < 4; o += 2) "margin" === n && (a += fe.css(e, n + Fe[o], !0, r)), i ? ("content" === n && (a -= fe.css(e, "padding" + Fe[o], !0, r)), "margin" !== n && (a -= fe.css(e, "border" + Fe[o] + "Width", !0, r))) : (a += fe.css(e, "padding" + Fe[o], !0, r), "padding" !== n && (a += fe.css(e, "border" + Fe[o] + "Width", !0, r)));
            return a
        }

        function P(e, t, n) {
            var i = !0,
                r = "width" === t ? e.offsetWidth : e.offsetHeight,
                o = pt(e),
                a = de.boxSizing && "border-box" === fe.css(e, "boxSizing", !1, o);
            if (r <= 0 || null == r) {
                if (r = gt(e, t, o), (r < 0 || null == r) && (r = e.style[t]), dt.test(r)) return r;
                i = a && (de.boxSizingReliable() || r === e.style[t]), r = parseFloat(r) || 0
            }
            return r + R(e, t, n || (a ? "border" : "content"), i, o) + "px"
        }

        function F(e, t, n, i, r) {
            return new F.prototype.init(e, t, n, i, r)
        }

        function H() {
            return e.setTimeout(function() {
                kt = void 0
            }), kt = fe.now()
        }

        function O(e, t) {
            var n, i = {
                    height: e
                },
                r = 0;
            for (t = t ? 1 : 0; r < 4; r += 2 - t) n = Fe[r], i["margin" + n] = i["padding" + n] = e;
            return t && (i.opacity = i.width = e), i
        }

        function Q(e, t, n) {
            for (var i, r = (W.tweeners[t] || []).concat(W.tweeners["*"]), o = 0, a = r.length; o < a; o++)
                if (i = r[o].call(n, t, e)) return i
        }

        function B(e, t, n) {
            var i, r, o, a, s, l, u, c, d = this,
                h = {},
                f = e.style,
                p = e.nodeType && He(e),
                g = fe._data(e, "fxshow");
            n.queue || (s = fe._queueHooks(e, "fx"), null == s.unqueued && (s.unqueued = 0, l = s.empty.fire, s.empty.fire = function() {
                s.unqueued || l()
            }), s.unqueued++, d.always(function() {
                d.always(function() {
                    s.unqueued--, fe.queue(e, "fx").length || s.empty.fire()
                })
            })), 1 === e.nodeType && ("height" in t || "width" in t) && (n.overflow = [f.overflow, f.overflowX, f.overflowY], u = fe.css(e, "display"), c = "none" === u ? fe._data(e, "olddisplay") || I(e.nodeName) : u, "inline" === c && "none" === fe.css(e, "float") && (de.inlineBlockNeedsLayout && "inline" !== I(e.nodeName) ? f.zoom = 1 : f.display = "inline-block")), n.overflow && (f.overflow = "hidden", de.shrinkWrapBlocks() || d.always(function() {
                f.overflow = n.overflow[0], f.overflowX = n.overflow[1], f.overflowY = n.overflow[2]
            }));
            for (i in t)
                if (r = t[i], _t.exec(r)) {
                    if (delete t[i], o = o || "toggle" === r, r === (p ? "hide" : "show")) {
                        if ("show" !== r || !g || void 0 === g[i]) continue;
                        p = !0
                    }
                    h[i] = g && g[i] || fe.style(e, i)
                } else u = void 0;
            if (fe.isEmptyObject(h)) "inline" === ("none" === u ? I(e.nodeName) : u) && (f.display = u);
            else {
                g ? "hidden" in g && (p = g.hidden) : g = fe._data(e, "fxshow", {}), o && (g.hidden = !p), p ? fe(e).show() : d.done(function() {
                    fe(e).hide()
                }), d.done(function() {
                    var t;
                    fe._removeData(e, "fxshow");
                    for (t in h) fe.style(e, t, h[t])
                });
                for (i in h) a = Q(p ? g[i] : 0, i, d), i in g || (g[i] = a.start, p && (a.end = a.start, a.start = "width" === i || "height" === i ? 1 : 0))
            }
        }

        function M(e, t) {
            var n, i, r, o, a;
            for (n in e)
                if (i = fe.camelCase(n), r = t[i], o = e[n], fe.isArray(o) && (r = o[1], o = e[n] = o[0]), n !== i && (e[i] = o, delete e[n]), a = fe.cssHooks[i], a && "expand" in a) {
                    o = a.expand(o), delete e[i];
                    for (n in o) n in e || (e[n] = o[n], t[n] = r)
                } else t[i] = r
        }

        function W(e, t, n) {
            var i, r, o = 0,
                a = W.prefilters.length,
                s = fe.Deferred().always(function() {
                    delete l.elem
                }),
                l = function() {
                    if (r) return !1;
                    for (var t = kt || H(), n = Math.max(0, u.startTime + u.duration - t), i = n / u.duration || 0, o = 1 - i, a = 0, l = u.tweens.length; a < l; a++) u.tweens[a].run(o);
                    return s.notifyWith(e, [u, o, n]), o < 1 && l ? n : (s.resolveWith(e, [u]), !1)
                },
                u = s.promise({
                    elem: e,
                    props: fe.extend({}, t),
                    opts: fe.extend(!0, {
                        specialEasing: {},
                        easing: fe.easing._default
                    }, n),
                    originalProperties: t,
                    originalOptions: n,
                    startTime: kt || H(),
                    duration: n.duration,
                    tweens: [],
                    createTween: function(t, n) {
                        var i = fe.Tween(e, u.opts, t, n, u.opts.specialEasing[t] || u.opts.easing);
                        return u.tweens.push(i), i
                    },
                    stop: function(t) {
                        var n = 0,
                            i = t ? u.tweens.length : 0;
                        if (r) return this;
                        for (r = !0; n < i; n++) u.tweens[n].run(1);
                        return t ? (s.notifyWith(e, [u, 1, 0]), s.resolveWith(e, [u, t])) : s.rejectWith(e, [u, t]), this
                    }
                }),
                c = u.props;
            for (M(c, u.opts.specialEasing); o < a; o++)
                if (i = W.prefilters[o].call(u, e, c, u.opts)) return fe.isFunction(i.stop) && (fe._queueHooks(u.elem, u.opts.queue).stop = fe.proxy(i.stop, i)), i;
            return fe.map(c, Q, u), fe.isFunction(u.opts.start) && u.opts.start.call(e, u), fe.fx.timer(fe.extend(l, {
                elem: e,
                anim: u,
                queue: u.opts.queue
            })), u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always)
        }

        function z(e) {
            return fe.attr(e, "class") || ""
        }

        function q(e) {
            return function(t, n) {
                "string" != typeof t && (n = t, t = "*");
                var i, r = 0,
                    o = t.toLowerCase().match(Ae) || [];
                if (fe.isFunction(n))
                    for (; i = o[r++];) "+" === i.charAt(0) ? (i = i.slice(1) || "*", (e[i] = e[i] || []).unshift(n)) : (e[i] = e[i] || []).push(n)
            }
        }

        function U(e, t, n, i) {
            function r(s) {
                var l;
                return o[s] = !0, fe.each(e[s] || [], function(e, s) {
                    var u = s(t, n, i);
                    return "string" != typeof u || a || o[u] ? a ? !(l = u) : void 0 : (t.dataTypes.unshift(u), r(u), !1)
                }), l
            }
            var o = {},
                a = e === Yt;
            return r(t.dataTypes[0]) || !o["*"] && r("*")
        }

        function V(e, t) {
            var n, i, r = fe.ajaxSettings.flatOptions || {};
            for (i in t) void 0 !== t[i] && ((r[i] ? e : n || (n = {}))[i] = t[i]);
            return n && fe.extend(!0, e, n), e
        }

        function X(e, t, n) {
            for (var i, r, o, a, s = e.contents, l = e.dataTypes;
                "*" === l[0];) l.shift(), void 0 === r && (r = e.mimeType || t.getResponseHeader("Content-Type"));
            if (r)
                for (a in s)
                    if (s[a] && s[a].test(r)) {
                        l.unshift(a);
                        break
                    }
            if (l[0] in n) o = l[0];
            else {
                for (a in n) {
                    if (!l[0] || e.converters[a + " " + l[0]]) {
                        o = a;
                        break
                    }
                    i || (i = a)
                }
                o = o || i
            }
            if (o) return o !== l[0] && l.unshift(o), n[o]
        }

        function J(e, t, n, i) {
            var r, o, a, s, l, u = {},
                c = e.dataTypes.slice();
            if (c[1])
                for (a in e.converters) u[a.toLowerCase()] = e.converters[a];
            for (o = c.shift(); o;)
                if (e.responseFields[o] && (n[e.responseFields[o]] = t), !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = o, o = c.shift())
                    if ("*" === o) o = l;
                    else if ("*" !== l && l !== o) {
                if (a = u[l + " " + o] || u["* " + o], !a)
                    for (r in u)
                        if (s = r.split(" "), s[1] === o && (a = u[l + " " + s[0]] || u["* " + s[0]])) {
                            a === !0 ? a = u[r] : u[r] !== !0 && (o = s[0], c.unshift(s[1]));
                            break
                        }
                if (a !== !0)
                    if (a && e.throws) t = a(t);
                    else try {
                        t = a(t)
                    } catch (e) {
                        return {
                            state: "parsererror",
                            error: a ? e : "No conversion from " + l + " to " + o
                        }
                    }
            }
            return {
                state: "success",
                data: t
            }
        }

        function G(e) {
            return e.style && e.style.display || fe.css(e, "display")
        }

        function K(e) {
            if (!fe.contains(e.ownerDocument || ie, e)) return !0;
            for (; e && 1 === e.nodeType;) {
                if ("none" === G(e) || "hidden" === e.type) return !0;
                e = e.parentNode
            }
            return !1
        }

        function Y(e, t, n, i) {
            var r;
            if (fe.isArray(t)) fe.each(t, function(t, r) {
                n || rn.test(e) ? i(e, r) : Y(e + "[" + ("object" == typeof r && null != r ? t : "") + "]", r, n, i)
            });
            else if (n || "object" !== fe.type(t)) i(e, t);
            else
                for (r in t) Y(e + "[" + r + "]", t[r], n, i)
        }

        function Z() {
            try {
                return new e.XMLHttpRequest
            } catch (e) {}
        }

        function ee() {
            try {
                return new e.ActiveXObject("Microsoft.XMLHTTP")
            } catch (e) {}
        }

        function te(e) {
            return fe.isWindow(e) ? e : 9 === e.nodeType && (e.defaultView || e.parentWindow)
        }
        var ne = [],
            ie = e.document,
            re = ne.slice,
            oe = ne.concat,
            ae = ne.push,
            se = ne.indexOf,
            le = {},
            ue = le.toString,
            ce = le.hasOwnProperty,
            de = {},
            he = "1.12.4",
            fe = function(e, t) {
                return new fe.fn.init(e, t)
            },
            pe = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
            ge = /^-ms-/,
            me = /-([\da-z])/gi,
            ve = function(e, t) {
                return t.toUpperCase()
            };
        fe.fn = fe.prototype = {
            jquery: he,
            constructor: fe,
            selector: "",
            length: 0,
            toArray: function() {
                return re.call(this)
            },
            get: function(e) {
                return null != e ? e < 0 ? this[e + this.length] : this[e] : re.call(this)
            },
            pushStack: function(e) {
                var t = fe.merge(this.constructor(), e);
                return t.prevObject = this, t.context = this.context, t
            },
            each: function(e) {
                return fe.each(this, e)
            },
            map: function(e) {
                return this.pushStack(fe.map(this, function(t, n) {
                    return e.call(t, n, t)
                }))
            },
            slice: function() {
                return this.pushStack(re.apply(this, arguments))
            },
            first: function() {
                return this.eq(0)
            },
            last: function() {
                return this.eq(-1)
            },
            eq: function(e) {
                var t = this.length,
                    n = +e + (e < 0 ? t : 0);
                return this.pushStack(n >= 0 && n < t ? [this[n]] : [])
            },
            end: function() {
                return this.prevObject || this.constructor()
            },
            push: ae,
            sort: ne.sort,
            splice: ne.splice
        }, fe.extend = fe.fn.extend = function() {
            var e, t, n, i, r, o, a = arguments[0] || {},
                s = 1,
                l = arguments.length,
                u = !1;
            for ("boolean" == typeof a && (u = a, a = arguments[s] || {}, s++), "object" == typeof a || fe.isFunction(a) || (a = {}), s === l && (a = this, s--); s < l; s++)
                if (null != (r = arguments[s]))
                    for (i in r) e = a[i], n = r[i], a !== n && (u && n && (fe.isPlainObject(n) || (t = fe.isArray(n))) ? (t ? (t = !1, o = e && fe.isArray(e) ? e : []) : o = e && fe.isPlainObject(e) ? e : {}, a[i] = fe.extend(u, o, n)) : void 0 !== n && (a[i] = n));
            return a
        }, fe.extend({
            expando: "jQuery" + (he + Math.random()).replace(/\D/g, ""),
            isReady: !0,
            error: function(e) {
                throw new Error(e)
            },
            noop: function() {},
            isFunction: function(e) {
                return "function" === fe.type(e)
            },
            isArray: Array.isArray || function(e) {
                return "array" === fe.type(e)
            },
            isWindow: function(e) {
                return null != e && e == e.window
            },
            isNumeric: function(e) {
                var t = e && e.toString();
                return !fe.isArray(e) && t - parseFloat(t) + 1 >= 0
            },
            isEmptyObject: function(e) {
                var t;
                for (t in e) return !1;
                return !0
            },
            isPlainObject: function(e) {
                var t;
                if (!e || "object" !== fe.type(e) || e.nodeType || fe.isWindow(e)) return !1;
                try {
                    if (e.constructor && !ce.call(e, "constructor") && !ce.call(e.constructor.prototype, "isPrototypeOf")) return !1
                } catch (e) {
                    return !1
                }
                if (!de.ownFirst)
                    for (t in e) return ce.call(e, t);
                for (t in e);
                return void 0 === t || ce.call(e, t)
            },
            type: function(e) {
                return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? le[ue.call(e)] || "object" : typeof e
            },
            globalEval: function(t) {
                t && fe.trim(t) && (e.execScript || function(t) {
                    e.eval.call(e, t)
                })(t)
            },
            camelCase: function(e) {
                return e.replace(ge, "ms-").replace(me, ve)
            },
            nodeName: function(e, t) {
                return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
            },
            each: function(e, t) {
                var i, r = 0;
                if (n(e))
                    for (i = e.length; r < i && t.call(e[r], r, e[r]) !== !1; r++);
                else
                    for (r in e)
                        if (t.call(e[r], r, e[r]) === !1) break;
                return e
            },
            trim: function(e) {
                return null == e ? "" : (e + "").replace(pe, "")
            },
            makeArray: function(e, t) {
                var i = t || [];
                return null != e && (n(Object(e)) ? fe.merge(i, "string" == typeof e ? [e] : e) : ae.call(i, e)), i
            },
            inArray: function(e, t, n) {
                var i;
                if (t) {
                    if (se) return se.call(t, e, n);
                    for (i = t.length, n = n ? n < 0 ? Math.max(0, i + n) : n : 0; n < i; n++)
                        if (n in t && t[n] === e) return n
                }
                return -1
            },
            merge: function(e, t) {
                for (var n = +t.length, i = 0, r = e.length; i < n;) e[r++] = t[i++];
                if (n !== n)
                    for (; void 0 !== t[i];) e[r++] = t[i++];
                return e.length = r, e
            },
            grep: function(e, t, n) {
                for (var i, r = [], o = 0, a = e.length, s = !n; o < a; o++) i = !t(e[o], o), i !== s && r.push(e[o]);
                return r
            },
            map: function(e, t, i) {
                var r, o, a = 0,
                    s = [];
                if (n(e))
                    for (r = e.length; a < r; a++) o = t(e[a], a, i), null != o && s.push(o);
                else
                    for (a in e) o = t(e[a], a, i), null != o && s.push(o);
                return oe.apply([], s)
            },
            guid: 1,
            proxy: function(e, t) {
                var n, i, r;
                if ("string" == typeof t && (r = e[t], t = e, e = r), fe.isFunction(e)) return n = re.call(arguments, 2), i = function() {
                    return e.apply(t || this, n.concat(re.call(arguments)))
                }, i.guid = e.guid = e.guid || fe.guid++, i
            },
            now: function() {
                return +new Date
            },
            support: de
        }), "function" == typeof Symbol && (fe.fn[Symbol.iterator] = ne[Symbol.iterator]), fe.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(e, t) {
            le["[object " + t + "]"] = t.toLowerCase()
        });
        var ye = function(e) {
            function t(e, t, n, i) {
                var r, o, a, s, l, u, d, f, p = t && t.ownerDocument,
                    g = t ? t.nodeType : 9;
                if (n = n || [], "string" != typeof e || !e || 1 !== g && 9 !== g && 11 !== g) return n;
                if (!i && ((t ? t.ownerDocument || t : Q) !== L && $(t), t = t || L, E)) {
                    if (11 !== g && (u = ve.exec(e)))
                        if (r = u[1]) {
                            if (9 === g) {
                                if (!(a = t.getElementById(r))) return n;
                                if (a.id === r) return n.push(a), n
                            } else if (p && (a = p.getElementById(r)) && H(t, a) && a.id === r) return n.push(a), n
                        } else {
                            if (u[2]) return Y.apply(n, t.getElementsByTagName(e)), n;
                            if ((r = u[3]) && w.getElementsByClassName && t.getElementsByClassName) return Y.apply(n, t.getElementsByClassName(r)), n
                        }
                    if (w.qsa && !q[e + " "] && (!R || !R.test(e))) {
                        if (1 !== g) p = t, f = e;
                        else if ("object" !== t.nodeName.toLowerCase()) {
                            for ((s = t.getAttribute("id")) ? s = s.replace(be, "\\$&") : t.setAttribute("id", s = O), d = k(e), o = d.length, l = he.test(s) ? "#" + s : "[id='" + s + "']"; o--;) d[o] = l + " " + h(d[o]);
                            f = d.join(","), p = ye.test(e) && c(t.parentNode) || t
                        }
                        if (f) try {
                            return Y.apply(n, p.querySelectorAll(f)), n
                        } catch (e) {} finally {
                            s === O && t.removeAttribute("id")
                        }
                    }
                }
                return _(e.replace(se, "$1"), t, n, i)
            }

            function n() {
                function e(n, i) {
                    return t.push(n + " ") > C.cacheLength && delete e[t.shift()], e[n + " "] = i
                }
                var t = [];
                return e
            }

            function i(e) {
                return e[O] = !0, e
            }

            function r(e) {
                var t = L.createElement("div");
                try {
                    return !!e(t)
                } catch (e) {
                    return !1
                } finally {
                    t.parentNode && t.parentNode.removeChild(t), t = null
                }
            }

            function o(e, t) {
                for (var n = e.split("|"), i = n.length; i--;) C.attrHandle[n[i]] = t
            }

            function a(e, t) {
                var n = t && e,
                    i = n && 1 === e.nodeType && 1 === t.nodeType && (~t.sourceIndex || V) - (~e.sourceIndex || V);
                if (i) return i;
                if (n)
                    for (; n = n.nextSibling;)
                        if (n === t) return -1;
                return e ? 1 : -1
            }

            function s(e) {
                return function(t) {
                    var n = t.nodeName.toLowerCase();
                    return "input" === n && t.type === e
                }
            }

            function l(e) {
                return function(t) {
                    var n = t.nodeName.toLowerCase();
                    return ("input" === n || "button" === n) && t.type === e
                }
            }

            function u(e) {
                return i(function(t) {
                    return t = +t, i(function(n, i) {
                        for (var r, o = e([], n.length, t), a = o.length; a--;) n[r = o[a]] && (n[r] = !(i[r] = n[r]))
                    })
                })
            }

            function c(e) {
                return e && "undefined" != typeof e.getElementsByTagName && e
            }

            function d() {}

            function h(e) {
                for (var t = 0, n = e.length, i = ""; t < n; t++) i += e[t].value;
                return i
            }

            function f(e, t, n) {
                var i = t.dir,
                    r = n && "parentNode" === i,
                    o = M++;
                return t.first ? function(t, n, o) {
                    for (; t = t[i];)
                        if (1 === t.nodeType || r) return e(t, n, o)
                } : function(t, n, a) {
                    var s, l, u, c = [B, o];
                    if (a) {
                        for (; t = t[i];)
                            if ((1 === t.nodeType || r) && e(t, n, a)) return !0
                    } else
                        for (; t = t[i];)
                            if (1 === t.nodeType || r) {
                                if (u = t[O] || (t[O] = {}), l = u[t.uniqueID] || (u[t.uniqueID] = {}), (s = l[i]) && s[0] === B && s[1] === o) return c[2] = s[2];
                                if (l[i] = c, c[2] = e(t, n, a)) return !0
                            }
                }
            }

            function p(e) {
                return e.length > 1 ? function(t, n, i) {
                    for (var r = e.length; r--;)
                        if (!e[r](t, n, i)) return !1;
                    return !0
                } : e[0]
            }

            function g(e, n, i) {
                for (var r = 0, o = n.length; r < o; r++) t(e, n[r], i);
                return i
            }

            function m(e, t, n, i, r) {
                for (var o, a = [], s = 0, l = e.length, u = null != t; s < l; s++)(o = e[s]) && (n && !n(o, i, r) || (a.push(o), u && t.push(s)));
                return a
            }

            function v(e, t, n, r, o, a) {
                return r && !r[O] && (r = v(r)), o && !o[O] && (o = v(o, a)), i(function(i, a, s, l) {
                    var u, c, d, h = [],
                        f = [],
                        p = a.length,
                        v = i || g(t || "*", s.nodeType ? [s] : s, []),
                        y = !e || !i && t ? v : m(v, h, e, s, l),
                        b = n ? o || (i ? e : p || r) ? [] : a : y;
                    if (n && n(y, b, s, l), r)
                        for (u = m(b, f), r(u, [], s, l), c = u.length; c--;)(d = u[c]) && (b[f[c]] = !(y[f[c]] = d));
                    if (i) {
                        if (o || e) {
                            if (o) {
                                for (u = [], c = b.length; c--;)(d = b[c]) && u.push(y[c] = d);
                                o(null, b = [], u, l)
                            }
                            for (c = b.length; c--;)(d = b[c]) && (u = o ? ee(i, d) : h[c]) > -1 && (i[u] = !(a[u] = d))
                        }
                    } else b = m(b === a ? b.splice(p, b.length) : b), o ? o(null, a, b, l) : Y.apply(a, b)
                })
            }

            function y(e) {
                for (var t, n, i, r = e.length, o = C.relative[e[0].type], a = o || C.relative[" "], s = o ? 1 : 0, l = f(function(e) {
                        return e === t
                    }, a, !0), u = f(function(e) {
                        return ee(t, e) > -1
                    }, a, !0), c = [function(e, n, i) {
                        var r = !o && (i || n !== j) || ((t = n).nodeType ? l(e, n, i) : u(e, n, i));
                        return t = null, r
                    }]; s < r; s++)
                    if (n = C.relative[e[s].type]) c = [f(p(c), n)];
                    else {
                        if (n = C.filter[e[s].type].apply(null, e[s].matches), n[O]) {
                            for (i = ++s; i < r && !C.relative[e[i].type]; i++);
                            return v(s > 1 && p(c), s > 1 && h(e.slice(0, s - 1).concat({
                                value: " " === e[s - 2].type ? "*" : ""
                            })).replace(se, "$1"), n, s < i && y(e.slice(s, i)), i < r && y(e = e.slice(i)), i < r && h(e))
                        }
                        c.push(n)
                    }
                return p(c)
            }

            function b(e, n) {
                var r = n.length > 0,
                    o = e.length > 0,
                    a = function(i, a, s, l, u) {
                        var c, d, h, f = 0,
                            p = "0",
                            g = i && [],
                            v = [],
                            y = j,
                            b = i || o && C.find.TAG("*", u),
                            x = B += null == y ? 1 : Math.random() || .1,
                            w = b.length;
                        for (u && (j = a === L || a || u); p !== w && null != (c = b[p]); p++) {
                            if (o && c) {
                                for (d = 0, a || c.ownerDocument === L || ($(c), s = !E); h = e[d++];)
                                    if (h(c, a || L, s)) {
                                        l.push(c);
                                        break
                                    }
                                u && (B = x)
                            }
                            r && ((c = !h && c) && f--, i && g.push(c))
                        }
                        if (f += p, r && p !== f) {
                            for (d = 0; h = n[d++];) h(g, v, a, s);
                            if (i) {
                                if (f > 0)
                                    for (; p--;) g[p] || v[p] || (v[p] = G.call(l));
                                v = m(v)
                            }
                            Y.apply(l, v), u && !i && v.length > 0 && f + n.length > 1 && t.uniqueSort(l)
                        }
                        return u && (B = x, j = y), g
                    };
                return r ? i(a) : a
            }
            var x, w, C, S, T, k, D, _, j, A, I, $, L, N, E, R, P, F, H, O = "sizzle" + 1 * new Date,
                Q = e.document,
                B = 0,
                M = 0,
                W = n(),
                z = n(),
                q = n(),
                U = function(e, t) {
                    return e === t && (I = !0), 0
                },
                V = 1 << 31,
                X = {}.hasOwnProperty,
                J = [],
                G = J.pop,
                K = J.push,
                Y = J.push,
                Z = J.slice,
                ee = function(e, t) {
                    for (var n = 0, i = e.length; n < i; n++)
                        if (e[n] === t) return n;
                    return -1
                },
                te = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
                ne = "[\\x20\\t\\r\\n\\f]",
                ie = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
                re = "\\[" + ne + "*(" + ie + ")(?:" + ne + "*([*^$|!~]?=)" + ne + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + ie + "))|)" + ne + "*\\]",
                oe = ":(" + ie + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + re + ")*)|.*)\\)|)",
                ae = new RegExp(ne + "+", "g"),
                se = new RegExp("^" + ne + "+|((?:^|[^\\\\])(?:\\\\.)*)" + ne + "+$", "g"),
                le = new RegExp("^" + ne + "*," + ne + "*"),
                ue = new RegExp("^" + ne + "*([>+~]|" + ne + ")" + ne + "*"),
                ce = new RegExp("=" + ne + "*([^\\]'\"]*?)" + ne + "*\\]", "g"),
                de = new RegExp(oe),
                he = new RegExp("^" + ie + "$"),
                fe = {
                    ID: new RegExp("^#(" + ie + ")"),
                    CLASS: new RegExp("^\\.(" + ie + ")"),
                    TAG: new RegExp("^(" + ie + "|[*])"),
                    ATTR: new RegExp("^" + re),
                    PSEUDO: new RegExp("^" + oe),
                    CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + ne + "*(even|odd|(([+-]|)(\\d*)n|)" + ne + "*(?:([+-]|)" + ne + "*(\\d+)|))" + ne + "*\\)|)", "i"),
                    bool: new RegExp("^(?:" + te + ")$", "i"),
                    needsContext: new RegExp("^" + ne + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + ne + "*((?:-\\d)?\\d*)" + ne + "*\\)|)(?=[^-]|$)", "i")
                },
                pe = /^(?:input|select|textarea|button)$/i,
                ge = /^h\d$/i,
                me = /^[^{]+\{\s*\[native \w/,
                ve = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
                ye = /[+~]/,
                be = /'|\\/g,
                xe = new RegExp("\\\\([\\da-f]{1,6}" + ne + "?|(" + ne + ")|.)", "ig"),
                we = function(e, t, n) {
                    var i = "0x" + t - 65536;
                    return i !== i || n ? t : i < 0 ? String.fromCharCode(i + 65536) : String.fromCharCode(i >> 10 | 55296, 1023 & i | 56320)
                },
                Ce = function() {
                    $()
                };
            try {
                Y.apply(J = Z.call(Q.childNodes), Q.childNodes), J[Q.childNodes.length].nodeType
            } catch (e) {
                Y = {
                    apply: J.length ? function(e, t) {
                        K.apply(e, Z.call(t))
                    } : function(e, t) {
                        for (var n = e.length, i = 0; e[n++] = t[i++];);
                        e.length = n - 1
                    }
                }
            }
            w = t.support = {}, T = t.isXML = function(e) {
                var t = e && (e.ownerDocument || e).documentElement;
                return !!t && "HTML" !== t.nodeName
            }, $ = t.setDocument = function(e) {
                var t, n, i = e ? e.ownerDocument || e : Q;
                return i !== L && 9 === i.nodeType && i.documentElement ? (L = i, N = L.documentElement, E = !T(L), (n = L.defaultView) && n.top !== n && (n.addEventListener ? n.addEventListener("unload", Ce, !1) : n.attachEvent && n.attachEvent("onunload", Ce)), w.attributes = r(function(e) {
                    return e.className = "i", !e.getAttribute("className")
                }), w.getElementsByTagName = r(function(e) {
                    return e.appendChild(L.createComment("")), !e.getElementsByTagName("*").length
                }), w.getElementsByClassName = me.test(L.getElementsByClassName), w.getById = r(function(e) {
                    return N.appendChild(e).id = O, !L.getElementsByName || !L.getElementsByName(O).length
                }), w.getById ? (C.find.ID = function(e, t) {
                    if ("undefined" != typeof t.getElementById && E) {
                        var n = t.getElementById(e);
                        return n ? [n] : []
                    }
                }, C.filter.ID = function(e) {
                    var t = e.replace(xe, we);
                    return function(e) {
                        return e.getAttribute("id") === t
                    }
                }) : (delete C.find.ID, C.filter.ID = function(e) {
                    var t = e.replace(xe, we);
                    return function(e) {
                        var n = "undefined" != typeof e.getAttributeNode && e.getAttributeNode("id");
                        return n && n.value === t
                    }
                }), C.find.TAG = w.getElementsByTagName ? function(e, t) {
                    return "undefined" != typeof t.getElementsByTagName ? t.getElementsByTagName(e) : w.qsa ? t.querySelectorAll(e) : void 0
                } : function(e, t) {
                    var n, i = [],
                        r = 0,
                        o = t.getElementsByTagName(e);
                    if ("*" === e) {
                        for (; n = o[r++];) 1 === n.nodeType && i.push(n);
                        return i
                    }
                    return o
                }, C.find.CLASS = w.getElementsByClassName && function(e, t) {
                    if ("undefined" != typeof t.getElementsByClassName && E) return t.getElementsByClassName(e)
                }, P = [], R = [], (w.qsa = me.test(L.querySelectorAll)) && (r(function(e) {
                    N.appendChild(e).innerHTML = "<a id='" + O + "'></a><select id='" + O + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && R.push("[*^$]=" + ne + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || R.push("\\[" + ne + "*(?:value|" + te + ")"), e.querySelectorAll("[id~=" + O + "-]").length || R.push("~="), e.querySelectorAll(":checked").length || R.push(":checked"), e.querySelectorAll("a#" + O + "+*").length || R.push(".#.+[+~]")
                }), r(function(e) {
                    var t = L.createElement("input");
                    t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && R.push("name" + ne + "*[*^$|!~]?="), e.querySelectorAll(":enabled").length || R.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), R.push(",.*:")
                })), (w.matchesSelector = me.test(F = N.matches || N.webkitMatchesSelector || N.mozMatchesSelector || N.oMatchesSelector || N.msMatchesSelector)) && r(function(e) {
                    w.disconnectedMatch = F.call(e, "div"), F.call(e, "[s!='']:x"), P.push("!=", oe)
                }), R = R.length && new RegExp(R.join("|")), P = P.length && new RegExp(P.join("|")), t = me.test(N.compareDocumentPosition), H = t || me.test(N.contains) ? function(e, t) {
                    var n = 9 === e.nodeType ? e.documentElement : e,
                        i = t && t.parentNode;
                    return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)))
                } : function(e, t) {
                    if (t)
                        for (; t = t.parentNode;)
                            if (t === e) return !0;
                    return !1
                }, U = t ? function(e, t) {
                    if (e === t) return I = !0, 0;
                    var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
                    return n ? n : (n = (e.ownerDocument || e) === (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1, 1 & n || !w.sortDetached && t.compareDocumentPosition(e) === n ? e === L || e.ownerDocument === Q && H(Q, e) ? -1 : t === L || t.ownerDocument === Q && H(Q, t) ? 1 : A ? ee(A, e) - ee(A, t) : 0 : 4 & n ? -1 : 1)
                } : function(e, t) {
                    if (e === t) return I = !0, 0;
                    var n, i = 0,
                        r = e.parentNode,
                        o = t.parentNode,
                        s = [e],
                        l = [t];
                    if (!r || !o) return e === L ? -1 : t === L ? 1 : r ? -1 : o ? 1 : A ? ee(A, e) - ee(A, t) : 0;
                    if (r === o) return a(e, t);
                    for (n = e; n = n.parentNode;) s.unshift(n);
                    for (n = t; n = n.parentNode;) l.unshift(n);
                    for (; s[i] === l[i];) i++;
                    return i ? a(s[i], l[i]) : s[i] === Q ? -1 : l[i] === Q ? 1 : 0
                }, L) : L
            }, t.matches = function(e, n) {
                return t(e, null, null, n)
            }, t.matchesSelector = function(e, n) {
                if ((e.ownerDocument || e) !== L && $(e), n = n.replace(ce, "='$1']"), w.matchesSelector && E && !q[n + " "] && (!P || !P.test(n)) && (!R || !R.test(n))) try {
                    var i = F.call(e, n);
                    if (i || w.disconnectedMatch || e.document && 11 !== e.document.nodeType) return i
                } catch (e) {}
                return t(n, L, null, [e]).length > 0
            }, t.contains = function(e, t) {
                return (e.ownerDocument || e) !== L && $(e), H(e, t)
            }, t.attr = function(e, t) {
                (e.ownerDocument || e) !== L && $(e);
                var n = C.attrHandle[t.toLowerCase()],
                    i = n && X.call(C.attrHandle, t.toLowerCase()) ? n(e, t, !E) : void 0;
                return void 0 !== i ? i : w.attributes || !E ? e.getAttribute(t) : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
            }, t.error = function(e) {
                throw new Error("Syntax error, unrecognized expression: " + e)
            }, t.uniqueSort = function(e) {
                var t, n = [],
                    i = 0,
                    r = 0;
                if (I = !w.detectDuplicates, A = !w.sortStable && e.slice(0), e.sort(U), I) {
                    for (; t = e[r++];) t === e[r] && (i = n.push(r));
                    for (; i--;) e.splice(n[i], 1)
                }
                return A = null, e
            }, S = t.getText = function(e) {
                var t, n = "",
                    i = 0,
                    r = e.nodeType;
                if (r) {
                    if (1 === r || 9 === r || 11 === r) {
                        if ("string" == typeof e.textContent) return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += S(e)
                    } else if (3 === r || 4 === r) return e.nodeValue
                } else
                    for (; t = e[i++];) n += S(t);
                return n
            }, C = t.selectors = {
                cacheLength: 50,
                createPseudo: i,
                match: fe,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {
                        dir: "parentNode",
                        first: !0
                    },
                    " ": {
                        dir: "parentNode"
                    },
                    "+": {
                        dir: "previousSibling",
                        first: !0
                    },
                    "~": {
                        dir: "previousSibling"
                    }
                },
                preFilter: {
                    ATTR: function(e) {
                        return e[1] = e[1].replace(xe, we), e[3] = (e[3] || e[4] || e[5] || "").replace(xe, we), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                    },
                    CHILD: function(e) {
                        return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || t.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && t.error(e[0]), e
                    },
                    PSEUDO: function(e) {
                        var t, n = !e[6] && e[2];
                        return fe.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && de.test(n) && (t = k(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function(e) {
                        var t = e.replace(xe, we).toLowerCase();
                        return "*" === e ? function() {
                            return !0
                        } : function(e) {
                            return e.nodeName && e.nodeName.toLowerCase() === t
                        }
                    },
                    CLASS: function(e) {
                        var t = W[e + " "];
                        return t || (t = new RegExp("(^|" + ne + ")" + e + "(" + ne + "|$)")) && W(e, function(e) {
                            return t.test("string" == typeof e.className && e.className || "undefined" != typeof e.getAttribute && e.getAttribute("class") || "")
                        })
                    },
                    ATTR: function(e, n, i) {
                        return function(r) {
                            var o = t.attr(r, e);
                            return null == o ? "!=" === n : !n || (o += "", "=" === n ? o === i : "!=" === n ? o !== i : "^=" === n ? i && 0 === o.indexOf(i) : "*=" === n ? i && o.indexOf(i) > -1 : "$=" === n ? i && o.slice(-i.length) === i : "~=" === n ? (" " + o.replace(ae, " ") + " ").indexOf(i) > -1 : "|=" === n && (o === i || o.slice(0, i.length + 1) === i + "-"))
                        }
                    },
                    CHILD: function(e, t, n, i, r) {
                        var o = "nth" !== e.slice(0, 3),
                            a = "last" !== e.slice(-4),
                            s = "of-type" === t;
                        return 1 === i && 0 === r ? function(e) {
                            return !!e.parentNode
                        } : function(t, n, l) {
                            var u, c, d, h, f, p, g = o !== a ? "nextSibling" : "previousSibling",
                                m = t.parentNode,
                                v = s && t.nodeName.toLowerCase(),
                                y = !l && !s,
                                b = !1;
                            if (m) {
                                if (o) {
                                    for (; g;) {
                                        for (h = t; h = h[g];)
                                            if (s ? h.nodeName.toLowerCase() === v : 1 === h.nodeType) return !1;
                                        p = g = "only" === e && !p && "nextSibling"
                                    }
                                    return !0
                                }
                                if (p = [a ? m.firstChild : m.lastChild], a && y) {
                                    for (h = m, d = h[O] || (h[O] = {}), c = d[h.uniqueID] || (d[h.uniqueID] = {}), u = c[e] || [], f = u[0] === B && u[1], b = f && u[2], h = f && m.childNodes[f]; h = ++f && h && h[g] || (b = f = 0) || p.pop();)
                                        if (1 === h.nodeType && ++b && h === t) {
                                            c[e] = [B, f, b];
                                            break
                                        }
                                } else if (y && (h = t, d = h[O] || (h[O] = {}), c = d[h.uniqueID] || (d[h.uniqueID] = {}), u = c[e] || [], f = u[0] === B && u[1], b = f), b === !1)
                                    for (;
                                        (h = ++f && h && h[g] || (b = f = 0) || p.pop()) && ((s ? h.nodeName.toLowerCase() !== v : 1 !== h.nodeType) || !++b || (y && (d = h[O] || (h[O] = {}), c = d[h.uniqueID] || (d[h.uniqueID] = {}), c[e] = [B, b]), h !== t)););
                                return b -= r, b === i || b % i === 0 && b / i >= 0
                            }
                        }
                    },
                    PSEUDO: function(e, n) {
                        var r, o = C.pseudos[e] || C.setFilters[e.toLowerCase()] || t.error("unsupported pseudo: " + e);
                        return o[O] ? o(n) : o.length > 1 ? (r = [e, e, "", n], C.setFilters.hasOwnProperty(e.toLowerCase()) ? i(function(e, t) {
                            for (var i, r = o(e, n), a = r.length; a--;) i = ee(e, r[a]), e[i] = !(t[i] = r[a])
                        }) : function(e) {
                            return o(e, 0, r)
                        }) : o
                    }
                },
                pseudos: {
                    not: i(function(e) {
                        var t = [],
                            n = [],
                            r = D(e.replace(se, "$1"));
                        return r[O] ? i(function(e, t, n, i) {
                            for (var o, a = r(e, null, i, []), s = e.length; s--;)(o = a[s]) && (e[s] = !(t[s] = o))
                        }) : function(e, i, o) {
                            return t[0] = e, r(t, null, o, n), t[0] = null, !n.pop()
                        }
                    }),
                    has: i(function(e) {
                        return function(n) {
                            return t(e, n).length > 0
                        }
                    }),
                    contains: i(function(e) {
                        return e = e.replace(xe, we),
                            function(t) {
                                return (t.textContent || t.innerText || S(t)).indexOf(e) > -1
                            }
                    }),
                    lang: i(function(e) {
                        return he.test(e || "") || t.error("unsupported lang: " + e), e = e.replace(xe, we).toLowerCase(),
                            function(t) {
                                var n;
                                do
                                    if (n = E ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return n = n.toLowerCase(), n === e || 0 === n.indexOf(e + "-"); while ((t = t.parentNode) && 1 === t.nodeType);
                                return !1
                            }
                    }),
                    target: function(t) {
                        var n = e.location && e.location.hash;
                        return n && n.slice(1) === t.id
                    },
                    root: function(e) {
                        return e === N
                    },
                    focus: function(e) {
                        return e === L.activeElement && (!L.hasFocus || L.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                    },
                    enabled: function(e) {
                        return e.disabled === !1
                    },
                    disabled: function(e) {
                        return e.disabled === !0
                    },
                    checked: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && !!e.checked || "option" === t && !!e.selected
                    },
                    selected: function(e) {
                        return e.parentNode && e.parentNode.selectedIndex, e.selected === !0
                    },
                    empty: function(e) {
                        for (e = e.firstChild; e; e = e.nextSibling)
                            if (e.nodeType < 6) return !1;
                        return !0
                    },
                    parent: function(e) {
                        return !C.pseudos.empty(e)
                    },
                    header: function(e) {
                        return ge.test(e.nodeName)
                    },
                    input: function(e) {
                        return pe.test(e.nodeName)
                    },
                    button: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && "button" === e.type || "button" === t
                    },
                    text: function(e) {
                        var t;
                        return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                    },
                    first: u(function() {
                        return [0]
                    }),
                    last: u(function(e, t) {
                        return [t - 1]
                    }),
                    eq: u(function(e, t, n) {
                        return [n < 0 ? n + t : n]
                    }),
                    even: u(function(e, t) {
                        for (var n = 0; n < t; n += 2) e.push(n);
                        return e
                    }),
                    odd: u(function(e, t) {
                        for (var n = 1; n < t; n += 2) e.push(n);
                        return e
                    }),
                    lt: u(function(e, t, n) {
                        for (var i = n < 0 ? n + t : n; --i >= 0;) e.push(i);
                        return e
                    }),
                    gt: u(function(e, t, n) {
                        for (var i = n < 0 ? n + t : n; ++i < t;) e.push(i);
                        return e
                    })
                }
            }, C.pseudos.nth = C.pseudos.eq;
            for (x in {
                    radio: !0,
                    checkbox: !0,
                    file: !0,
                    password: !0,
                    image: !0
                }) C.pseudos[x] = s(x);
            for (x in {
                    submit: !0,
                    reset: !0
                }) C.pseudos[x] = l(x);
            return d.prototype = C.filters = C.pseudos, C.setFilters = new d, k = t.tokenize = function(e, n) {
                var i, r, o, a, s, l, u, c = z[e + " "];
                if (c) return n ? 0 : c.slice(0);
                for (s = e, l = [], u = C.preFilter; s;) {
                    i && !(r = le.exec(s)) || (r && (s = s.slice(r[0].length) || s), l.push(o = [])), i = !1, (r = ue.exec(s)) && (i = r.shift(), o.push({
                        value: i,
                        type: r[0].replace(se, " ")
                    }), s = s.slice(i.length));
                    for (a in C.filter) !(r = fe[a].exec(s)) || u[a] && !(r = u[a](r)) || (i = r.shift(), o.push({
                        value: i,
                        type: a,
                        matches: r
                    }), s = s.slice(i.length));
                    if (!i) break
                }
                return n ? s.length : s ? t.error(e) : z(e, l).slice(0)
            }, D = t.compile = function(e, t) {
                var n, i = [],
                    r = [],
                    o = q[e + " "];
                if (!o) {
                    for (t || (t = k(e)), n = t.length; n--;) o = y(t[n]), o[O] ? i.push(o) : r.push(o);
                    o = q(e, b(r, i)), o.selector = e
                }
                return o
            }, _ = t.select = function(e, t, n, i) {
                var r, o, a, s, l, u = "function" == typeof e && e,
                    d = !i && k(e = u.selector || e);
                if (n = n || [], 1 === d.length) {
                    if (o = d[0] = d[0].slice(0), o.length > 2 && "ID" === (a = o[0]).type && w.getById && 9 === t.nodeType && E && C.relative[o[1].type]) {
                        if (t = (C.find.ID(a.matches[0].replace(xe, we), t) || [])[0], !t) return n;
                        u && (t = t.parentNode), e = e.slice(o.shift().value.length)
                    }
                    for (r = fe.needsContext.test(e) ? 0 : o.length; r-- && (a = o[r], !C.relative[s = a.type]);)
                        if ((l = C.find[s]) && (i = l(a.matches[0].replace(xe, we), ye.test(o[0].type) && c(t.parentNode) || t))) {
                            if (o.splice(r, 1), e = i.length && h(o), !e) return Y.apply(n, i), n;
                            break
                        }
                }
                return (u || D(e, d))(i, t, !E, n, !t || ye.test(e) && c(t.parentNode) || t), n
            }, w.sortStable = O.split("").sort(U).join("") === O, w.detectDuplicates = !!I, $(), w.sortDetached = r(function(e) {
                return 1 & e.compareDocumentPosition(L.createElement("div"))
            }), r(function(e) {
                return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
            }) || o("type|href|height|width", function(e, t, n) {
                if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
            }), w.attributes && r(function(e) {
                return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
            }) || o("value", function(e, t, n) {
                if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
            }), r(function(e) {
                return null == e.getAttribute("disabled")
            }) || o(te, function(e, t, n) {
                var i;
                if (!n) return e[t] === !0 ? t.toLowerCase() : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
            }), t
        }(e);
        fe.find = ye, fe.expr = ye.selectors, fe.expr[":"] = fe.expr.pseudos, fe.uniqueSort = fe.unique = ye.uniqueSort, fe.text = ye.getText, fe.isXMLDoc = ye.isXML, fe.contains = ye.contains;
        var be = function(e, t, n) {
                for (var i = [], r = void 0 !== n;
                    (e = e[t]) && 9 !== e.nodeType;)
                    if (1 === e.nodeType) {
                        if (r && fe(e).is(n)) break;
                        i.push(e)
                    }
                return i
            },
            xe = function(e, t) {
                for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
                return n
            },
            we = fe.expr.match.needsContext,
            Ce = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/,
            Se = /^.[^:#\[\.,]*$/;
        fe.filter = function(e, t, n) {
            var i = t[0];
            return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? fe.find.matchesSelector(i, e) ? [i] : [] : fe.find.matches(e, fe.grep(t, function(e) {
                return 1 === e.nodeType
            }))
        }, fe.fn.extend({
            find: function(e) {
                var t, n = [],
                    i = this,
                    r = i.length;
                if ("string" != typeof e) return this.pushStack(fe(e).filter(function() {
                    for (t = 0; t < r; t++)
                        if (fe.contains(i[t], this)) return !0
                }));
                for (t = 0; t < r; t++) fe.find(e, i[t], n);
                return n = this.pushStack(r > 1 ? fe.unique(n) : n), n.selector = this.selector ? this.selector + " " + e : e, n
            },
            filter: function(e) {
                return this.pushStack(i(this, e || [], !1))
            },
            not: function(e) {
                return this.pushStack(i(this, e || [], !0))
            },
            is: function(e) {
                return !!i(this, "string" == typeof e && we.test(e) ? fe(e) : e || [], !1).length
            }
        });
        var Te, ke = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,
            De = fe.fn.init = function(e, t, n) {
                var i, r;
                if (!e) return this;
                if (n = n || Te, "string" == typeof e) {
                    if (i = "<" === e.charAt(0) && ">" === e.charAt(e.length - 1) && e.length >= 3 ? [null, e, null] : ke.exec(e), !i || !i[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
                    if (i[1]) {
                        if (t = t instanceof fe ? t[0] : t, fe.merge(this, fe.parseHTML(i[1], t && t.nodeType ? t.ownerDocument || t : ie, !0)), Ce.test(i[1]) && fe.isPlainObject(t))
                            for (i in t) fe.isFunction(this[i]) ? this[i](t[i]) : this.attr(i, t[i]);
                        return this
                    }
                    if (r = ie.getElementById(i[2]), r && r.parentNode) {
                        if (r.id !== i[2]) return Te.find(e);
                        this.length = 1, this[0] = r
                    }
                    return this.context = ie, this.selector = e, this
                }
                return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : fe.isFunction(e) ? "undefined" != typeof n.ready ? n.ready(e) : e(fe) : (void 0 !== e.selector && (this.selector = e.selector, this.context = e.context), fe.makeArray(e, this))
            };
        De.prototype = fe.fn, Te = fe(ie);
        var _e = /^(?:parents|prev(?:Until|All))/,
            je = {
                children: !0,
                contents: !0,
                next: !0,
                prev: !0
            };
        fe.fn.extend({
            has: function(e) {
                var t, n = fe(e, this),
                    i = n.length;
                return this.filter(function() {
                    for (t = 0; t < i; t++)
                        if (fe.contains(this, n[t])) return !0
                })
            },
            closest: function(e, t) {
                for (var n, i = 0, r = this.length, o = [], a = we.test(e) || "string" != typeof e ? fe(e, t || this.context) : 0; i < r; i++)
                    for (n = this[i]; n && n !== t; n = n.parentNode)
                        if (n.nodeType < 11 && (a ? a.index(n) > -1 : 1 === n.nodeType && fe.find.matchesSelector(n, e))) {
                            o.push(n);
                            break
                        }
                return this.pushStack(o.length > 1 ? fe.uniqueSort(o) : o)
            },
            index: function(e) {
                return e ? "string" == typeof e ? fe.inArray(this[0], fe(e)) : fe.inArray(e.jquery ? e[0] : e, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
            },
            add: function(e, t) {
                return this.pushStack(fe.uniqueSort(fe.merge(this.get(), fe(e, t))))
            },
            addBack: function(e) {
                return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
            }
        }), fe.each({
            parent: function(e) {
                var t = e.parentNode;
                return t && 11 !== t.nodeType ? t : null
            },
            parents: function(e) {
                return be(e, "parentNode")
            },
            parentsUntil: function(e, t, n) {
                return be(e, "parentNode", n)
            },
            next: function(e) {
                return r(e, "nextSibling")
            },
            prev: function(e) {
                return r(e, "previousSibling")
            },
            nextAll: function(e) {
                return be(e, "nextSibling")
            },
            prevAll: function(e) {
                return be(e, "previousSibling")
            },
            nextUntil: function(e, t, n) {
                return be(e, "nextSibling", n)
            },
            prevUntil: function(e, t, n) {
                return be(e, "previousSibling", n)
            },
            siblings: function(e) {
                return xe((e.parentNode || {}).firstChild, e)
            },
            children: function(e) {
                return xe(e.firstChild)
            },
            contents: function(e) {
                return fe.nodeName(e, "iframe") ? e.contentDocument || e.contentWindow.document : fe.merge([], e.childNodes)
            }
        }, function(e, t) {
            fe.fn[e] = function(n, i) {
                var r = fe.map(this, t, n);
                return "Until" !== e.slice(-5) && (i = n), i && "string" == typeof i && (r = fe.filter(i, r)), this.length > 1 && (je[e] || (r = fe.uniqueSort(r)), _e.test(e) && (r = r.reverse())), this.pushStack(r)
            }
        });
        var Ae = /\S+/g;
        fe.Callbacks = function(e) {
            e = "string" == typeof e ? o(e) : fe.extend({}, e);
            var t, n, i, r, a = [],
                s = [],
                l = -1,
                u = function() {
                    for (r = e.once, i = t = !0; s.length; l = -1)
                        for (n = s.shift(); ++l < a.length;) a[l].apply(n[0], n[1]) === !1 && e.stopOnFalse && (l = a.length, n = !1);
                    e.memory || (n = !1), t = !1, r && (a = n ? [] : "")
                },
                c = {
                    add: function() {
                        return a && (n && !t && (l = a.length - 1, s.push(n)), function t(n) {
                            fe.each(n, function(n, i) {
                                fe.isFunction(i) ? e.unique && c.has(i) || a.push(i) : i && i.length && "string" !== fe.type(i) && t(i)
                            })
                        }(arguments), n && !t && u()), this
                    },
                    remove: function() {
                        return fe.each(arguments, function(e, t) {
                            for (var n;
                                (n = fe.inArray(t, a, n)) > -1;) a.splice(n, 1), n <= l && l--
                        }), this
                    },
                    has: function(e) {
                        return e ? fe.inArray(e, a) > -1 : a.length > 0
                    },
                    empty: function() {
                        return a && (a = []), this
                    },
                    disable: function() {
                        return r = s = [], a = n = "", this
                    },
                    disabled: function() {
                        return !a
                    },
                    lock: function() {
                        return r = !0, n || c.disable(), this
                    },
                    locked: function() {
                        return !!r
                    },
                    fireWith: function(e, n) {
                        return r || (n = n || [], n = [e, n.slice ? n.slice() : n], s.push(n), t || u()), this
                    },
                    fire: function() {
                        return c.fireWith(this, arguments), this
                    },
                    fired: function() {
                        return !!i
                    }
                };
            return c
        }, fe.extend({
            Deferred: function(e) {
                var t = [
                        ["resolve", "done", fe.Callbacks("once memory"), "resolved"],
                        ["reject", "fail", fe.Callbacks("once memory"), "rejected"],
                        ["notify", "progress", fe.Callbacks("memory")]
                    ],
                    n = "pending",
                    i = {
                        state: function() {
                            return n
                        },
                        always: function() {
                            return r.done(arguments).fail(arguments), this
                        },
                        then: function() {
                            var e = arguments;
                            return fe.Deferred(function(n) {
                                fe.each(t, function(t, o) {
                                    var a = fe.isFunction(e[t]) && e[t];
                                    r[o[1]](function() {
                                        var e = a && a.apply(this, arguments);
                                        e && fe.isFunction(e.promise) ? e.promise().progress(n.notify).done(n.resolve).fail(n.reject) : n[o[0] + "With"](this === i ? n.promise() : this, a ? [e] : arguments)
                                    })
                                }), e = null
                            }).promise()
                        },
                        promise: function(e) {
                            return null != e ? fe.extend(e, i) : i
                        }
                    },
                    r = {};
                return i.pipe = i.then, fe.each(t, function(e, o) {
                    var a = o[2],
                        s = o[3];
                    i[o[1]] = a.add, s && a.add(function() {
                        n = s
                    }, t[1 ^ e][2].disable, t[2][2].lock), r[o[0]] = function() {
                        return r[o[0] + "With"](this === r ? i : this, arguments), this
                    }, r[o[0] + "With"] = a.fireWith
                }), i.promise(r), e && e.call(r, r), r
            },
            when: function(e) {
                var t, n, i, r = 0,
                    o = re.call(arguments),
                    a = o.length,
                    s = 1 !== a || e && fe.isFunction(e.promise) ? a : 0,
                    l = 1 === s ? e : fe.Deferred(),
                    u = function(e, n, i) {
                        return function(r) {
                            n[e] = this, i[e] = arguments.length > 1 ? re.call(arguments) : r, i === t ? l.notifyWith(n, i) : --s || l.resolveWith(n, i)
                        }
                    };
                if (a > 1)
                    for (t = new Array(a), n = new Array(a), i = new Array(a); r < a; r++) o[r] && fe.isFunction(o[r].promise) ? o[r].promise().progress(u(r, n, t)).done(u(r, i, o)).fail(l.reject) : --s;
                return s || l.resolveWith(i, o), l.promise()
            }
        });
        var Ie;
        fe.fn.ready = function(e) {
            return fe.ready.promise().done(e), this
        }, fe.extend({
            isReady: !1,
            readyWait: 1,
            holdReady: function(e) {
                e ? fe.readyWait++ : fe.ready(!0)
            },
            ready: function(e) {
                (e === !0 ? --fe.readyWait : fe.isReady) || (fe.isReady = !0, e !== !0 && --fe.readyWait > 0 || (Ie.resolveWith(ie, [fe]), fe.fn.triggerHandler && (fe(ie).triggerHandler("ready"), fe(ie).off("ready"))))
            }
        }), fe.ready.promise = function(t) {
            if (!Ie)
                if (Ie = fe.Deferred(), "complete" === ie.readyState || "loading" !== ie.readyState && !ie.documentElement.doScroll) e.setTimeout(fe.ready);
                else if (ie.addEventListener) ie.addEventListener("DOMContentLoaded", s), e.addEventListener("load", s);
            else {
                ie.attachEvent("onreadystatechange", s), e.attachEvent("onload", s);
                var n = !1;
                try {
                    n = null == e.frameElement && ie.documentElement
                } catch (e) {}
                n && n.doScroll && ! function t() {
                    if (!fe.isReady) {
                        try {
                            n.doScroll("left")
                        } catch (n) {
                            return e.setTimeout(t, 50)
                        }
                        a(), fe.ready()
                    }
                }()
            }
            return Ie.promise(t)
        }, fe.ready.promise();
        var $e;
        for ($e in fe(de)) break;
        de.ownFirst = "0" === $e, de.inlineBlockNeedsLayout = !1, fe(function() {
                var e, t, n, i;
                n = ie.getElementsByTagName("body")[0], n && n.style && (t = ie.createElement("div"), i = ie.createElement("div"), i.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", n.appendChild(i).appendChild(t), "undefined" != typeof t.style.zoom && (t.style.cssText = "display:inline;margin:0;border:0;padding:1px;width:1px;zoom:1", de.inlineBlockNeedsLayout = e = 3 === t.offsetWidth, e && (n.style.zoom = 1)), n.removeChild(i))
            }),
            function() {
                var e = ie.createElement("div");
                de.deleteExpando = !0;
                try {
                    delete e.test
                } catch (e) {
                    de.deleteExpando = !1
                }
                e = null
            }();
        var Le = function(e) {
                var t = fe.noData[(e.nodeName + " ").toLowerCase()],
                    n = +e.nodeType || 1;
                return (1 === n || 9 === n) && (!t || t !== !0 && e.getAttribute("classid") === t)
            },
            Ne = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
            Ee = /([A-Z])/g;
        fe.extend({
                cache: {},
                noData: {
                    "applet ": !0,
                    "embed ": !0,
                    "object ": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                },
                hasData: function(e) {
                    return e = e.nodeType ? fe.cache[e[fe.expando]] : e[fe.expando], !!e && !u(e)
                },
                data: function(e, t, n) {
                    return c(e, t, n)
                },
                removeData: function(e, t) {
                    return d(e, t)
                },
                _data: function(e, t, n) {
                    return c(e, t, n, !0)
                },
                _removeData: function(e, t) {
                    return d(e, t, !0)
                }
            }), fe.fn.extend({
                data: function(e, t) {
                    var n, i, r, o = this[0],
                        a = o && o.attributes;
                    if (void 0 === e) {
                        if (this.length && (r = fe.data(o), 1 === o.nodeType && !fe._data(o, "parsedAttrs"))) {
                            for (n = a.length; n--;) a[n] && (i = a[n].name, 0 === i.indexOf("data-") && (i = fe.camelCase(i.slice(5)), l(o, i, r[i])));
                            fe._data(o, "parsedAttrs", !0)
                        }
                        return r
                    }
                    return "object" == typeof e ? this.each(function() {
                        fe.data(this, e)
                    }) : arguments.length > 1 ? this.each(function() {
                        fe.data(this, e, t)
                    }) : o ? l(o, e, fe.data(o, e)) : void 0
                },
                removeData: function(e) {
                    return this.each(function() {
                        fe.removeData(this, e)
                    })
                }
            }), fe.extend({
                queue: function(e, t, n) {
                    var i;
                    if (e) return t = (t || "fx") + "queue", i = fe._data(e, t), n && (!i || fe.isArray(n) ? i = fe._data(e, t, fe.makeArray(n)) : i.push(n)), i || []
                },
                dequeue: function(e, t) {
                    t = t || "fx";
                    var n = fe.queue(e, t),
                        i = n.length,
                        r = n.shift(),
                        o = fe._queueHooks(e, t),
                        a = function() {
                            fe.dequeue(e, t)
                        };
                    "inprogress" === r && (r = n.shift(), i--), r && ("fx" === t && n.unshift("inprogress"), delete o.stop, r.call(e, a, o)), !i && o && o.empty.fire()
                },
                _queueHooks: function(e, t) {
                    var n = t + "queueHooks";
                    return fe._data(e, n) || fe._data(e, n, {
                        empty: fe.Callbacks("once memory").add(function() {
                            fe._removeData(e, t + "queue"), fe._removeData(e, n)
                        })
                    })
                }
            }), fe.fn.extend({
                queue: function(e, t) {
                    var n = 2;
                    return "string" != typeof e && (t = e, e = "fx", n--), arguments.length < n ? fe.queue(this[0], e) : void 0 === t ? this : this.each(function() {
                        var n = fe.queue(this, e, t);
                        fe._queueHooks(this, e), "fx" === e && "inprogress" !== n[0] && fe.dequeue(this, e)
                    })
                },
                dequeue: function(e) {
                    return this.each(function() {
                        fe.dequeue(this, e)
                    })
                },
                clearQueue: function(e) {
                    return this.queue(e || "fx", [])
                },
                promise: function(e, t) {
                    var n, i = 1,
                        r = fe.Deferred(),
                        o = this,
                        a = this.length,
                        s = function() {
                            --i || r.resolveWith(o, [o])
                        };
                    for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; a--;) n = fe._data(o[a], e + "queueHooks"), n && n.empty && (i++, n.empty.add(s));
                    return s(), r.promise(t)
                }
            }),
            function() {
                var e;
                de.shrinkWrapBlocks = function() {
                    if (null != e) return e;
                    e = !1;
                    var t, n, i;
                    return n = ie.getElementsByTagName("body")[0], n && n.style ? (t = ie.createElement("div"), i = ie.createElement("div"), i.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", n.appendChild(i).appendChild(t), "undefined" != typeof t.style.zoom && (t.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1", t.appendChild(ie.createElement("div")).style.width = "5px", e = 3 !== t.offsetWidth), n.removeChild(i), e) : void 0
                }
            }();
        var Re = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
            Pe = new RegExp("^(?:([+-])=|)(" + Re + ")([a-z%]*)$", "i"),
            Fe = ["Top", "Right", "Bottom", "Left"],
            He = function(e, t) {
                return e = t || e, "none" === fe.css(e, "display") || !fe.contains(e.ownerDocument, e)
            },
            Oe = function(e, t, n, i, r, o, a) {
                var s = 0,
                    l = e.length,
                    u = null == n;
                if ("object" === fe.type(n)) {
                    r = !0;
                    for (s in n) Oe(e, t, s, n[s], !0, o, a)
                } else if (void 0 !== i && (r = !0, fe.isFunction(i) || (a = !0), u && (a ? (t.call(e, i), t = null) : (u = t, t = function(e, t, n) {
                        return u.call(fe(e), n)
                    })), t))
                    for (; s < l; s++) t(e[s], n, a ? i : i.call(e[s], s, t(e[s], n)));
                return r ? e : u ? t.call(e) : l ? t(e[0], n) : o
            },
            Qe = /^(?:checkbox|radio)$/i,
            Be = /<([\w:-]+)/,
            Me = /^$|\/(?:java|ecma)script/i,
            We = /^\s+/,
            ze = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|dialog|figcaption|figure|footer|header|hgroup|main|mark|meter|nav|output|picture|progress|section|summary|template|time|video";
        ! function() {
            var e = ie.createElement("div"),
                t = ie.createDocumentFragment(),
                n = ie.createElement("input");
            e.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", de.leadingWhitespace = 3 === e.firstChild.nodeType, de.tbody = !e.getElementsByTagName("tbody").length, de.htmlSerialize = !!e.getElementsByTagName("link").length, de.html5Clone = "<:nav></:nav>" !== ie.createElement("nav").cloneNode(!0).outerHTML, n.type = "checkbox", n.checked = !0, t.appendChild(n), de.appendChecked = n.checked, e.innerHTML = "<textarea>x</textarea>", de.noCloneChecked = !!e.cloneNode(!0).lastChild.defaultValue, t.appendChild(e), n = ie.createElement("input"), n.setAttribute("type", "radio"), n.setAttribute("checked", "checked"), n.setAttribute("name", "t"), e.appendChild(n), de.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked, de.noCloneEvent = !!e.addEventListener, e[fe.expando] = 1, de.attributes = !e.getAttribute(fe.expando)
        }();
        var qe = {
            option: [1, "<select multiple='multiple'>", "</select>"],
            legend: [1, "<fieldset>", "</fieldset>"],
            area: [1, "<map>", "</map>"],
            param: [1, "<object>", "</object>"],
            thead: [1, "<table>", "</table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: de.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
        };
        qe.optgroup = qe.option, qe.tbody = qe.tfoot = qe.colgroup = qe.caption = qe.thead, qe.th = qe.td;
        var Ue = /<|&#?\w+;/,
            Ve = /<tbody/i;
        ! function() {
            var t, n, i = ie.createElement("div");
            for (t in {
                    submit: !0,
                    change: !0,
                    focusin: !0
                }) n = "on" + t, (de[t] = n in e) || (i.setAttribute(n, "t"), de[t] = i.attributes[n].expando === !1);
            i = null
        }();
        var Xe = /^(?:input|select|textarea)$/i,
            Je = /^key/,
            Ge = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
            Ke = /^(?:focusinfocus|focusoutblur)$/,
            Ye = /^([^.]*)(?:\.(.+)|)/;
        fe.event = {
            global: {},
            add: function(e, t, n, i, r) {
                var o, a, s, l, u, c, d, h, f, p, g, m = fe._data(e);
                if (m) {
                    for (n.handler && (l = n, n = l.handler, r = l.selector), n.guid || (n.guid = fe.guid++), (a = m.events) || (a = m.events = {}), (c = m.handle) || (c = m.handle = function(e) {
                            return "undefined" == typeof fe || e && fe.event.triggered === e.type ? void 0 : fe.event.dispatch.apply(c.elem, arguments)
                        }, c.elem = e), t = (t || "").match(Ae) || [""], s = t.length; s--;) o = Ye.exec(t[s]) || [], f = g = o[1], p = (o[2] || "").split(".").sort(), f && (u = fe.event.special[f] || {}, f = (r ? u.delegateType : u.bindType) || f, u = fe.event.special[f] || {}, d = fe.extend({
                        type: f,
                        origType: g,
                        data: i,
                        handler: n,
                        guid: n.guid,
                        selector: r,
                        needsContext: r && fe.expr.match.needsContext.test(r),
                        namespace: p.join(".")
                    }, l), (h = a[f]) || (h = a[f] = [], h.delegateCount = 0, u.setup && u.setup.call(e, i, p, c) !== !1 || (e.addEventListener ? e.addEventListener(f, c, !1) : e.attachEvent && e.attachEvent("on" + f, c))), u.add && (u.add.call(e, d), d.handler.guid || (d.handler.guid = n.guid)), r ? h.splice(h.delegateCount++, 0, d) : h.push(d), fe.event.global[f] = !0);
                    e = null
                }
            },
            remove: function(e, t, n, i, r) {
                var o, a, s, l, u, c, d, h, f, p, g, m = fe.hasData(e) && fe._data(e);
                if (m && (c = m.events)) {
                    for (t = (t || "").match(Ae) || [""], u = t.length; u--;)
                        if (s = Ye.exec(t[u]) || [], f = g = s[1], p = (s[2] || "").split(".").sort(), f) {
                            for (d = fe.event.special[f] || {}, f = (i ? d.delegateType : d.bindType) || f, h = c[f] || [], s = s[2] && new RegExp("(^|\\.)" + p.join("\\.(?:.*\\.|)") + "(\\.|$)"), l = o = h.length; o--;) a = h[o], !r && g !== a.origType || n && n.guid !== a.guid || s && !s.test(a.namespace) || i && i !== a.selector && ("**" !== i || !a.selector) || (h.splice(o, 1), a.selector && h.delegateCount--, d.remove && d.remove.call(e, a));
                            l && !h.length && (d.teardown && d.teardown.call(e, p, m.handle) !== !1 || fe.removeEvent(e, f, m.handle), delete c[f])
                        } else
                            for (f in c) fe.event.remove(e, f + t[u], n, i, !0);
                    fe.isEmptyObject(c) && (delete m.handle, fe._removeData(e, "events"))
                }
            },
            trigger: function(t, n, i, r) {
                var o, a, s, l, u, c, d, h = [i || ie],
                    f = ce.call(t, "type") ? t.type : t,
                    p = ce.call(t, "namespace") ? t.namespace.split(".") : [];
                if (s = c = i = i || ie, 3 !== i.nodeType && 8 !== i.nodeType && !Ke.test(f + fe.event.triggered) && (f.indexOf(".") > -1 && (p = f.split("."), f = p.shift(), p.sort()), a = f.indexOf(":") < 0 && "on" + f, t = t[fe.expando] ? t : new fe.Event(f, "object" == typeof t && t), t.isTrigger = r ? 2 : 3, t.namespace = p.join("."), t.rnamespace = t.namespace ? new RegExp("(^|\\.)" + p.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, t.result = void 0, t.target || (t.target = i), n = null == n ? [t] : fe.makeArray(n, [t]), u = fe.event.special[f] || {}, r || !u.trigger || u.trigger.apply(i, n) !== !1)) {
                    if (!r && !u.noBubble && !fe.isWindow(i)) {
                        for (l = u.delegateType || f, Ke.test(l + f) || (s = s.parentNode); s; s = s.parentNode) h.push(s), c = s;
                        c === (i.ownerDocument || ie) && h.push(c.defaultView || c.parentWindow || e)
                    }
                    for (d = 0;
                        (s = h[d++]) && !t.isPropagationStopped();) t.type = d > 1 ? l : u.bindType || f, o = (fe._data(s, "events") || {})[t.type] && fe._data(s, "handle"), o && o.apply(s, n), o = a && s[a], o && o.apply && Le(s) && (t.result = o.apply(s, n), t.result === !1 && t.preventDefault());
                    if (t.type = f, !r && !t.isDefaultPrevented() && (!u._default || u._default.apply(h.pop(), n) === !1) && Le(i) && a && i[f] && !fe.isWindow(i)) {
                        c = i[a], c && (i[a] = null), fe.event.triggered = f;
                        try {
                            i[f]()
                        } catch (e) {}
                        fe.event.triggered = void 0, c && (i[a] = c)
                    }
                    return t.result
                }
            },
            dispatch: function(e) {
                e = fe.event.fix(e);
                var t, n, i, r, o, a = [],
                    s = re.call(arguments),
                    l = (fe._data(this, "events") || {})[e.type] || [],
                    u = fe.event.special[e.type] || {};
                if (s[0] = e, e.delegateTarget = this, !u.preDispatch || u.preDispatch.call(this, e) !== !1) {
                    for (a = fe.event.handlers.call(this, e, l), t = 0;
                        (r = a[t++]) && !e.isPropagationStopped();)
                        for (e.currentTarget = r.elem, n = 0;
                            (o = r.handlers[n++]) && !e.isImmediatePropagationStopped();) e.rnamespace && !e.rnamespace.test(o.namespace) || (e.handleObj = o, e.data = o.data, i = ((fe.event.special[o.origType] || {}).handle || o.handler).apply(r.elem, s), void 0 !== i && (e.result = i) === !1 && (e.preventDefault(), e.stopPropagation()));
                    return u.postDispatch && u.postDispatch.call(this, e), e.result
                }
            },
            handlers: function(e, t) {
                var n, i, r, o, a = [],
                    s = t.delegateCount,
                    l = e.target;
                if (s && l.nodeType && ("click" !== e.type || isNaN(e.button) || e.button < 1))
                    for (; l != this; l = l.parentNode || this)
                        if (1 === l.nodeType && (l.disabled !== !0 || "click" !== e.type)) {
                            for (i = [], n = 0; n < s; n++) o = t[n], r = o.selector + " ", void 0 === i[r] && (i[r] = o.needsContext ? fe(r, this).index(l) > -1 : fe.find(r, this, null, [l]).length), i[r] && i.push(o);
                            i.length && a.push({
                                elem: l,
                                handlers: i
                            })
                        }
                return s < t.length && a.push({
                    elem: this,
                    handlers: t.slice(s)
                }), a
            },
            fix: function(e) {
                if (e[fe.expando]) return e;
                var t, n, i, r = e.type,
                    o = e,
                    a = this.fixHooks[r];
                for (a || (this.fixHooks[r] = a = Ge.test(r) ? this.mouseHooks : Je.test(r) ? this.keyHooks : {}), i = a.props ? this.props.concat(a.props) : this.props, e = new fe.Event(o), t = i.length; t--;) n = i[t], e[n] = o[n];
                return e.target || (e.target = o.srcElement || ie), 3 === e.target.nodeType && (e.target = e.target.parentNode), e.metaKey = !!e.metaKey, a.filter ? a.filter(e, o) : e
            },
            props: "altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
            fixHooks: {},
            keyHooks: {
                props: "char charCode key keyCode".split(" "),
                filter: function(e, t) {
                    return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
                }
            },
            mouseHooks: {
                props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
                filter: function(e, t) {
                    var n, i, r, o = t.button,
                        a = t.fromElement;
                    return null == e.pageX && null != t.clientX && (i = e.target.ownerDocument || ie, r = i.documentElement, n = i.body, e.pageX = t.clientX + (r && r.scrollLeft || n && n.scrollLeft || 0) - (r && r.clientLeft || n && n.clientLeft || 0), e.pageY = t.clientY + (r && r.scrollTop || n && n.scrollTop || 0) - (r && r.clientTop || n && n.clientTop || 0)), !e.relatedTarget && a && (e.relatedTarget = a === e.target ? t.toElement : a), e.which || void 0 === o || (e.which = 1 & o ? 1 : 2 & o ? 3 : 4 & o ? 2 : 0), e
                }
            },
            special: {
                load: {
                    noBubble: !0
                },
                focus: {
                    trigger: function() {
                        if (this !== x() && this.focus) try {
                            return this.focus(), !1
                        } catch (e) {}
                    },
                    delegateType: "focusin"
                },
                blur: {
                    trigger: function() {
                        if (this === x() && this.blur) return this.blur(), !1
                    },
                    delegateType: "focusout"
                },
                click: {
                    trigger: function() {
                        if (fe.nodeName(this, "input") && "checkbox" === this.type && this.click) return this.click(), !1
                    },
                    _default: function(e) {
                        return fe.nodeName(e.target, "a")
                    }
                },
                beforeunload: {
                    postDispatch: function(e) {
                        void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                    }
                }
            },
            simulate: function(e, t, n) {
                var i = fe.extend(new fe.Event, n, {
                    type: e,
                    isSimulated: !0
                });
                fe.event.trigger(i, null, t), i.isDefaultPrevented() && n.preventDefault()
            }
        }, fe.removeEvent = ie.removeEventListener ? function(e, t, n) {
            e.removeEventListener && e.removeEventListener(t, n)
        } : function(e, t, n) {
            var i = "on" + t;
            e.detachEvent && ("undefined" == typeof e[i] && (e[i] = null), e.detachEvent(i, n));
        }, fe.Event = function(e, t) {
            return this instanceof fe.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && e.returnValue === !1 ? y : b) : this.type = e, t && fe.extend(this, t), this.timeStamp = e && e.timeStamp || fe.now(), void(this[fe.expando] = !0)) : new fe.Event(e, t)
        }, fe.Event.prototype = {
            constructor: fe.Event,
            isDefaultPrevented: b,
            isPropagationStopped: b,
            isImmediatePropagationStopped: b,
            preventDefault: function() {
                var e = this.originalEvent;
                this.isDefaultPrevented = y, e && (e.preventDefault ? e.preventDefault() : e.returnValue = !1)
            },
            stopPropagation: function() {
                var e = this.originalEvent;
                this.isPropagationStopped = y, e && !this.isSimulated && (e.stopPropagation && e.stopPropagation(), e.cancelBubble = !0)
            },
            stopImmediatePropagation: function() {
                var e = this.originalEvent;
                this.isImmediatePropagationStopped = y, e && e.stopImmediatePropagation && e.stopImmediatePropagation(), this.stopPropagation()
            }
        }, fe.each({
            mouseenter: "mouseover",
            mouseleave: "mouseout",
            pointerenter: "pointerover",
            pointerleave: "pointerout"
        }, function(e, t) {
            fe.event.special[e] = {
                delegateType: t,
                bindType: t,
                handle: function(e) {
                    var n, i = this,
                        r = e.relatedTarget,
                        o = e.handleObj;
                    return r && (r === i || fe.contains(i, r)) || (e.type = o.origType, n = o.handler.apply(this, arguments), e.type = t), n
                }
            }
        }), de.submit || (fe.event.special.submit = {
            setup: function() {
                return !fe.nodeName(this, "form") && void fe.event.add(this, "click._submit keypress._submit", function(e) {
                    var t = e.target,
                        n = fe.nodeName(t, "input") || fe.nodeName(t, "button") ? fe.prop(t, "form") : void 0;
                    n && !fe._data(n, "submit") && (fe.event.add(n, "submit._submit", function(e) {
                        e._submitBubble = !0
                    }), fe._data(n, "submit", !0))
                })
            },
            postDispatch: function(e) {
                e._submitBubble && (delete e._submitBubble, this.parentNode && !e.isTrigger && fe.event.simulate("submit", this.parentNode, e))
            },
            teardown: function() {
                return !fe.nodeName(this, "form") && void fe.event.remove(this, "._submit")
            }
        }), de.change || (fe.event.special.change = {
            setup: function() {
                return Xe.test(this.nodeName) ? ("checkbox" !== this.type && "radio" !== this.type || (fe.event.add(this, "propertychange._change", function(e) {
                    "checked" === e.originalEvent.propertyName && (this._justChanged = !0)
                }), fe.event.add(this, "click._change", function(e) {
                    this._justChanged && !e.isTrigger && (this._justChanged = !1), fe.event.simulate("change", this, e)
                })), !1) : void fe.event.add(this, "beforeactivate._change", function(e) {
                    var t = e.target;
                    Xe.test(t.nodeName) && !fe._data(t, "change") && (fe.event.add(t, "change._change", function(e) {
                        !this.parentNode || e.isSimulated || e.isTrigger || fe.event.simulate("change", this.parentNode, e)
                    }), fe._data(t, "change", !0))
                })
            },
            handle: function(e) {
                var t = e.target;
                if (this !== t || e.isSimulated || e.isTrigger || "radio" !== t.type && "checkbox" !== t.type) return e.handleObj.handler.apply(this, arguments)
            },
            teardown: function() {
                return fe.event.remove(this, "._change"), !Xe.test(this.nodeName)
            }
        }), de.focusin || fe.each({
            focus: "focusin",
            blur: "focusout"
        }, function(e, t) {
            var n = function(e) {
                fe.event.simulate(t, e.target, fe.event.fix(e))
            };
            fe.event.special[t] = {
                setup: function() {
                    var i = this.ownerDocument || this,
                        r = fe._data(i, t);
                    r || i.addEventListener(e, n, !0), fe._data(i, t, (r || 0) + 1)
                },
                teardown: function() {
                    var i = this.ownerDocument || this,
                        r = fe._data(i, t) - 1;
                    r ? fe._data(i, t, r) : (i.removeEventListener(e, n, !0), fe._removeData(i, t))
                }
            }
        }), fe.fn.extend({
            on: function(e, t, n, i) {
                return w(this, e, t, n, i)
            },
            one: function(e, t, n, i) {
                return w(this, e, t, n, i, 1)
            },
            off: function(e, t, n) {
                var i, r;
                if (e && e.preventDefault && e.handleObj) return i = e.handleObj, fe(e.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;
                if ("object" == typeof e) {
                    for (r in e) this.off(r, t, e[r]);
                    return this
                }
                return t !== !1 && "function" != typeof t || (n = t, t = void 0), n === !1 && (n = b), this.each(function() {
                    fe.event.remove(this, e, n, t)
                })
            },
            trigger: function(e, t) {
                return this.each(function() {
                    fe.event.trigger(e, t, this)
                })
            },
            triggerHandler: function(e, t) {
                var n = this[0];
                if (n) return fe.event.trigger(e, t, n, !0)
            }
        });
        var Ze = / jQuery\d+="(?:null|\d+)"/g,
            et = new RegExp("<(?:" + ze + ")[\\s/>]", "i"),
            tt = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi,
            nt = /<script|<style|<link/i,
            it = /checked\s*(?:[^=]|=\s*.checked.)/i,
            rt = /^true\/(.*)/,
            ot = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
            at = f(ie),
            st = at.appendChild(ie.createElement("div"));
        fe.extend({
            htmlPrefilter: function(e) {
                return e.replace(tt, "<$1></$2>")
            },
            clone: function(e, t, n) {
                var i, r, o, a, s, l = fe.contains(e.ownerDocument, e);
                if (de.html5Clone || fe.isXMLDoc(e) || !et.test("<" + e.nodeName + ">") ? o = e.cloneNode(!0) : (st.innerHTML = e.outerHTML, st.removeChild(o = st.firstChild)), !(de.noCloneEvent && de.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || fe.isXMLDoc(e)))
                    for (i = p(o), s = p(e), a = 0; null != (r = s[a]); ++a) i[a] && D(r, i[a]);
                if (t)
                    if (n)
                        for (s = s || p(e), i = i || p(o), a = 0; null != (r = s[a]); a++) k(r, i[a]);
                    else k(e, o);
                return i = p(o, "script"), i.length > 0 && g(i, !l && p(e, "script")), i = s = r = null, o
            },
            cleanData: function(e, t) {
                for (var n, i, r, o, a = 0, s = fe.expando, l = fe.cache, u = de.attributes, c = fe.event.special; null != (n = e[a]); a++)
                    if ((t || Le(n)) && (r = n[s], o = r && l[r])) {
                        if (o.events)
                            for (i in o.events) c[i] ? fe.event.remove(n, i) : fe.removeEvent(n, i, o.handle);
                        l[r] && (delete l[r], u || "undefined" == typeof n.removeAttribute ? n[s] = void 0 : n.removeAttribute(s), ne.push(r))
                    }
            }
        }), fe.fn.extend({
            domManip: _,
            detach: function(e) {
                return j(this, e, !0)
            },
            remove: function(e) {
                return j(this, e)
            },
            text: function(e) {
                return Oe(this, function(e) {
                    return void 0 === e ? fe.text(this) : this.empty().append((this[0] && this[0].ownerDocument || ie).createTextNode(e))
                }, null, e, arguments.length)
            },
            append: function() {
                return _(this, arguments, function(e) {
                    if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                        var t = C(this, e);
                        t.appendChild(e)
                    }
                })
            },
            prepend: function() {
                return _(this, arguments, function(e) {
                    if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                        var t = C(this, e);
                        t.insertBefore(e, t.firstChild)
                    }
                })
            },
            before: function() {
                return _(this, arguments, function(e) {
                    this.parentNode && this.parentNode.insertBefore(e, this)
                })
            },
            after: function() {
                return _(this, arguments, function(e) {
                    this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
                })
            },
            empty: function() {
                for (var e, t = 0; null != (e = this[t]); t++) {
                    for (1 === e.nodeType && fe.cleanData(p(e, !1)); e.firstChild;) e.removeChild(e.firstChild);
                    e.options && fe.nodeName(e, "select") && (e.options.length = 0)
                }
                return this
            },
            clone: function(e, t) {
                return e = null != e && e, t = null == t ? e : t, this.map(function() {
                    return fe.clone(this, e, t)
                })
            },
            html: function(e) {
                return Oe(this, function(e) {
                    var t = this[0] || {},
                        n = 0,
                        i = this.length;
                    if (void 0 === e) return 1 === t.nodeType ? t.innerHTML.replace(Ze, "") : void 0;
                    if ("string" == typeof e && !nt.test(e) && (de.htmlSerialize || !et.test(e)) && (de.leadingWhitespace || !We.test(e)) && !qe[(Be.exec(e) || ["", ""])[1].toLowerCase()]) {
                        e = fe.htmlPrefilter(e);
                        try {
                            for (; n < i; n++) t = this[n] || {}, 1 === t.nodeType && (fe.cleanData(p(t, !1)), t.innerHTML = e);
                            t = 0
                        } catch (e) {}
                    }
                    t && this.empty().append(e)
                }, null, e, arguments.length)
            },
            replaceWith: function() {
                var e = [];
                return _(this, arguments, function(t) {
                    var n = this.parentNode;
                    fe.inArray(this, e) < 0 && (fe.cleanData(p(this)), n && n.replaceChild(t, this))
                }, e)
            }
        }), fe.each({
            appendTo: "append",
            prependTo: "prepend",
            insertBefore: "before",
            insertAfter: "after",
            replaceAll: "replaceWith"
        }, function(e, t) {
            fe.fn[e] = function(e) {
                for (var n, i = 0, r = [], o = fe(e), a = o.length - 1; i <= a; i++) n = i === a ? this : this.clone(!0), fe(o[i])[t](n), ae.apply(r, n.get());
                return this.pushStack(r)
            }
        });
        var lt, ut = {
                HTML: "block",
                BODY: "block"
            },
            ct = /^margin/,
            dt = new RegExp("^(" + Re + ")(?!px)[a-z%]+$", "i"),
            ht = function(e, t, n, i) {
                var r, o, a = {};
                for (o in t) a[o] = e.style[o], e.style[o] = t[o];
                r = n.apply(e, i || []);
                for (o in t) e.style[o] = a[o];
                return r
            },
            ft = ie.documentElement;
        ! function() {
            function t() {
                var t, c, d = ie.documentElement;
                d.appendChild(l), u.style.cssText = "-webkit-box-sizing:border-box;box-sizing:border-box;position:relative;display:block;margin:auto;border:1px;padding:1px;top:1%;width:50%", n = r = s = !1, i = a = !0, e.getComputedStyle && (c = e.getComputedStyle(u), n = "1%" !== (c || {}).top, s = "2px" === (c || {}).marginLeft, r = "4px" === (c || {
                    width: "4px"
                }).width, u.style.marginRight = "50%", i = "4px" === (c || {
                    marginRight: "4px"
                }).marginRight, t = u.appendChild(ie.createElement("div")), t.style.cssText = u.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", t.style.marginRight = t.style.width = "0", u.style.width = "1px", a = !parseFloat((e.getComputedStyle(t) || {}).marginRight), u.removeChild(t)), u.style.display = "none", o = 0 === u.getClientRects().length, o && (u.style.display = "", u.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", u.childNodes[0].style.borderCollapse = "separate", t = u.getElementsByTagName("td"), t[0].style.cssText = "margin:0;border:0;padding:0;display:none", o = 0 === t[0].offsetHeight, o && (t[0].style.display = "", t[1].style.display = "none", o = 0 === t[0].offsetHeight)), d.removeChild(l)
            }
            var n, i, r, o, a, s, l = ie.createElement("div"),
                u = ie.createElement("div");
            u.style && (u.style.cssText = "float:left;opacity:.5", de.opacity = "0.5" === u.style.opacity, de.cssFloat = !!u.style.cssFloat, u.style.backgroundClip = "content-box", u.cloneNode(!0).style.backgroundClip = "", de.clearCloneStyle = "content-box" === u.style.backgroundClip, l = ie.createElement("div"), l.style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;padding:0;margin-top:1px;position:absolute", u.innerHTML = "", l.appendChild(u), de.boxSizing = "" === u.style.boxSizing || "" === u.style.MozBoxSizing || "" === u.style.WebkitBoxSizing, fe.extend(de, {
                reliableHiddenOffsets: function() {
                    return null == n && t(), o
                },
                boxSizingReliable: function() {
                    return null == n && t(), r
                },
                pixelMarginRight: function() {
                    return null == n && t(), i
                },
                pixelPosition: function() {
                    return null == n && t(), n
                },
                reliableMarginRight: function() {
                    return null == n && t(), a
                },
                reliableMarginLeft: function() {
                    return null == n && t(), s
                }
            }))
        }();
        var pt, gt, mt = /^(top|right|bottom|left)$/;
        e.getComputedStyle ? (pt = function(t) {
            var n = t.ownerDocument.defaultView;
            return n && n.opener || (n = e), n.getComputedStyle(t)
        }, gt = function(e, t, n) {
            var i, r, o, a, s = e.style;
            return n = n || pt(e), a = n ? n.getPropertyValue(t) || n[t] : void 0, "" !== a && void 0 !== a || fe.contains(e.ownerDocument, e) || (a = fe.style(e, t)), n && !de.pixelMarginRight() && dt.test(a) && ct.test(t) && (i = s.width, r = s.minWidth, o = s.maxWidth, s.minWidth = s.maxWidth = s.width = a, a = n.width, s.width = i, s.minWidth = r, s.maxWidth = o), void 0 === a ? a : a + ""
        }) : ft.currentStyle && (pt = function(e) {
            return e.currentStyle
        }, gt = function(e, t, n) {
            var i, r, o, a, s = e.style;
            return n = n || pt(e), a = n ? n[t] : void 0, null == a && s && s[t] && (a = s[t]), dt.test(a) && !mt.test(t) && (i = s.left, r = e.runtimeStyle, o = r && r.left, o && (r.left = e.currentStyle.left), s.left = "fontSize" === t ? "1em" : a, a = s.pixelLeft + "px", s.left = i, o && (r.left = o)), void 0 === a ? a : a + "" || "auto"
        });
        var vt = /alpha\([^)]*\)/i,
            yt = /opacity\s*=\s*([^)]*)/i,
            bt = /^(none|table(?!-c[ea]).+)/,
            xt = new RegExp("^(" + Re + ")(.*)$", "i"),
            wt = {
                position: "absolute",
                visibility: "hidden",
                display: "block"
            },
            Ct = {
                letterSpacing: "0",
                fontWeight: "400"
            },
            St = ["Webkit", "O", "Moz", "ms"],
            Tt = ie.createElement("div").style;
        fe.extend({
            cssHooks: {
                opacity: {
                    get: function(e, t) {
                        if (t) {
                            var n = gt(e, "opacity");
                            return "" === n ? "1" : n
                        }
                    }
                }
            },
            cssNumber: {
                animationIterationCount: !0,
                columnCount: !0,
                fillOpacity: !0,
                flexGrow: !0,
                flexShrink: !0,
                fontWeight: !0,
                lineHeight: !0,
                opacity: !0,
                order: !0,
                orphans: !0,
                widows: !0,
                zIndex: !0,
                zoom: !0
            },
            cssProps: {
                float: de.cssFloat ? "cssFloat" : "styleFloat"
            },
            style: function(e, t, n, i) {
                if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                    var r, o, a, s = fe.camelCase(t),
                        l = e.style;
                    if (t = fe.cssProps[s] || (fe.cssProps[s] = L(s) || s), a = fe.cssHooks[t] || fe.cssHooks[s], void 0 === n) return a && "get" in a && void 0 !== (r = a.get(e, !1, i)) ? r : l[t];
                    if (o = typeof n, "string" === o && (r = Pe.exec(n)) && r[1] && (n = h(e, t, r), o = "number"), null != n && n === n && ("number" === o && (n += r && r[3] || (fe.cssNumber[s] ? "" : "px")), de.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), !(a && "set" in a && void 0 === (n = a.set(e, n, i))))) try {
                        l[t] = n
                    } catch (e) {}
                }
            },
            css: function(e, t, n, i) {
                var r, o, a, s = fe.camelCase(t);
                return t = fe.cssProps[s] || (fe.cssProps[s] = L(s) || s), a = fe.cssHooks[t] || fe.cssHooks[s], a && "get" in a && (o = a.get(e, !0, n)), void 0 === o && (o = gt(e, t, i)), "normal" === o && t in Ct && (o = Ct[t]), "" === n || n ? (r = parseFloat(o), n === !0 || isFinite(r) ? r || 0 : o) : o
            }
        }), fe.each(["height", "width"], function(e, t) {
            fe.cssHooks[t] = {
                get: function(e, n, i) {
                    if (n) return bt.test(fe.css(e, "display")) && 0 === e.offsetWidth ? ht(e, wt, function() {
                        return P(e, t, i)
                    }) : P(e, t, i)
                },
                set: function(e, n, i) {
                    var r = i && pt(e);
                    return E(e, n, i ? R(e, t, i, de.boxSizing && "border-box" === fe.css(e, "boxSizing", !1, r), r) : 0)
                }
            }
        }), de.opacity || (fe.cssHooks.opacity = {
            get: function(e, t) {
                return yt.test((t && e.currentStyle ? e.currentStyle.filter : e.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : t ? "1" : ""
            },
            set: function(e, t) {
                var n = e.style,
                    i = e.currentStyle,
                    r = fe.isNumeric(t) ? "alpha(opacity=" + 100 * t + ")" : "",
                    o = i && i.filter || n.filter || "";
                n.zoom = 1, (t >= 1 || "" === t) && "" === fe.trim(o.replace(vt, "")) && n.removeAttribute && (n.removeAttribute("filter"), "" === t || i && !i.filter) || (n.filter = vt.test(o) ? o.replace(vt, r) : o + " " + r)
            }
        }), fe.cssHooks.marginRight = $(de.reliableMarginRight, function(e, t) {
            if (t) return ht(e, {
                display: "inline-block"
            }, gt, [e, "marginRight"])
        }), fe.cssHooks.marginLeft = $(de.reliableMarginLeft, function(e, t) {
            if (t) return (parseFloat(gt(e, "marginLeft")) || (fe.contains(e.ownerDocument, e) ? e.getBoundingClientRect().left - ht(e, {
                marginLeft: 0
            }, function() {
                return e.getBoundingClientRect().left
            }) : 0)) + "px"
        }), fe.each({
            margin: "",
            padding: "",
            border: "Width"
        }, function(e, t) {
            fe.cssHooks[e + t] = {
                expand: function(n) {
                    for (var i = 0, r = {}, o = "string" == typeof n ? n.split(" ") : [n]; i < 4; i++) r[e + Fe[i] + t] = o[i] || o[i - 2] || o[0];
                    return r
                }
            }, ct.test(e) || (fe.cssHooks[e + t].set = E)
        }), fe.fn.extend({
            css: function(e, t) {
                return Oe(this, function(e, t, n) {
                    var i, r, o = {},
                        a = 0;
                    if (fe.isArray(t)) {
                        for (i = pt(e), r = t.length; a < r; a++) o[t[a]] = fe.css(e, t[a], !1, i);
                        return o
                    }
                    return void 0 !== n ? fe.style(e, t, n) : fe.css(e, t)
                }, e, t, arguments.length > 1)
            },
            show: function() {
                return N(this, !0)
            },
            hide: function() {
                return N(this)
            },
            toggle: function(e) {
                return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function() {
                    He(this) ? fe(this).show() : fe(this).hide()
                })
            }
        }), fe.Tween = F, F.prototype = {
            constructor: F,
            init: function(e, t, n, i, r, o) {
                this.elem = e, this.prop = n, this.easing = r || fe.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = i, this.unit = o || (fe.cssNumber[n] ? "" : "px")
            },
            cur: function() {
                var e = F.propHooks[this.prop];
                return e && e.get ? e.get(this) : F.propHooks._default.get(this)
            },
            run: function(e) {
                var t, n = F.propHooks[this.prop];
                return this.options.duration ? this.pos = t = fe.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : F.propHooks._default.set(this), this
            }
        }, F.prototype.init.prototype = F.prototype, F.propHooks = {
            _default: {
                get: function(e) {
                    var t;
                    return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = fe.css(e.elem, e.prop, ""), t && "auto" !== t ? t : 0)
                },
                set: function(e) {
                    fe.fx.step[e.prop] ? fe.fx.step[e.prop](e) : 1 !== e.elem.nodeType || null == e.elem.style[fe.cssProps[e.prop]] && !fe.cssHooks[e.prop] ? e.elem[e.prop] = e.now : fe.style(e.elem, e.prop, e.now + e.unit)
                }
            }
        }, F.propHooks.scrollTop = F.propHooks.scrollLeft = {
            set: function(e) {
                e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
            }
        }, fe.easing = {
            linear: function(e) {
                return e
            },
            swing: function(e) {
                return .5 - Math.cos(e * Math.PI) / 2
            },
            _default: "swing"
        }, fe.fx = F.prototype.init, fe.fx.step = {};
        var kt, Dt, _t = /^(?:toggle|show|hide)$/,
            jt = /queueHooks$/;
        fe.Animation = fe.extend(W, {
                tweeners: {
                    "*": [function(e, t) {
                        var n = this.createTween(e, t);
                        return h(n.elem, e, Pe.exec(t), n), n
                    }]
                },
                tweener: function(e, t) {
                    fe.isFunction(e) ? (t = e, e = ["*"]) : e = e.match(Ae);
                    for (var n, i = 0, r = e.length; i < r; i++) n = e[i], W.tweeners[n] = W.tweeners[n] || [], W.tweeners[n].unshift(t)
                },
                prefilters: [B],
                prefilter: function(e, t) {
                    t ? W.prefilters.unshift(e) : W.prefilters.push(e)
                }
            }), fe.speed = function(e, t, n) {
                var i = e && "object" == typeof e ? fe.extend({}, e) : {
                    complete: n || !n && t || fe.isFunction(e) && e,
                    duration: e,
                    easing: n && t || t && !fe.isFunction(t) && t
                };
                return i.duration = fe.fx.off ? 0 : "number" == typeof i.duration ? i.duration : i.duration in fe.fx.speeds ? fe.fx.speeds[i.duration] : fe.fx.speeds._default, null != i.queue && i.queue !== !0 || (i.queue = "fx"), i.old = i.complete, i.complete = function() {
                    fe.isFunction(i.old) && i.old.call(this), i.queue && fe.dequeue(this, i.queue)
                }, i
            }, fe.fn.extend({
                fadeTo: function(e, t, n, i) {
                    return this.filter(He).css("opacity", 0).show().end().animate({
                        opacity: t
                    }, e, n, i)
                },
                animate: function(e, t, n, i) {
                    var r = fe.isEmptyObject(e),
                        o = fe.speed(t, n, i),
                        a = function() {
                            var t = W(this, fe.extend({}, e), o);
                            (r || fe._data(this, "finish")) && t.stop(!0)
                        };
                    return a.finish = a, r || o.queue === !1 ? this.each(a) : this.queue(o.queue, a)
                },
                stop: function(e, t, n) {
                    var i = function(e) {
                        var t = e.stop;
                        delete e.stop, t(n)
                    };
                    return "string" != typeof e && (n = t, t = e, e = void 0), t && e !== !1 && this.queue(e || "fx", []), this.each(function() {
                        var t = !0,
                            r = null != e && e + "queueHooks",
                            o = fe.timers,
                            a = fe._data(this);
                        if (r) a[r] && a[r].stop && i(a[r]);
                        else
                            for (r in a) a[r] && a[r].stop && jt.test(r) && i(a[r]);
                        for (r = o.length; r--;) o[r].elem !== this || null != e && o[r].queue !== e || (o[r].anim.stop(n), t = !1, o.splice(r, 1));
                        !t && n || fe.dequeue(this, e)
                    })
                },
                finish: function(e) {
                    return e !== !1 && (e = e || "fx"), this.each(function() {
                        var t, n = fe._data(this),
                            i = n[e + "queue"],
                            r = n[e + "queueHooks"],
                            o = fe.timers,
                            a = i ? i.length : 0;
                        for (n.finish = !0, fe.queue(this, e, []), r && r.stop && r.stop.call(this, !0), t = o.length; t--;) o[t].elem === this && o[t].queue === e && (o[t].anim.stop(!0), o.splice(t, 1));
                        for (t = 0; t < a; t++) i[t] && i[t].finish && i[t].finish.call(this);
                        delete n.finish
                    })
                }
            }), fe.each(["toggle", "show", "hide"], function(e, t) {
                var n = fe.fn[t];
                fe.fn[t] = function(e, i, r) {
                    return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(O(t, !0), e, i, r)
                }
            }), fe.each({
                slideDown: O("show"),
                slideUp: O("hide"),
                slideToggle: O("toggle"),
                fadeIn: {
                    opacity: "show"
                },
                fadeOut: {
                    opacity: "hide"
                },
                fadeToggle: {
                    opacity: "toggle"
                }
            }, function(e, t) {
                fe.fn[e] = function(e, n, i) {
                    return this.animate(t, e, n, i)
                }
            }), fe.timers = [], fe.fx.tick = function() {
                var e, t = fe.timers,
                    n = 0;
                for (kt = fe.now(); n < t.length; n++) e = t[n], e() || t[n] !== e || t.splice(n--, 1);
                t.length || fe.fx.stop(), kt = void 0
            }, fe.fx.timer = function(e) {
                fe.timers.push(e), e() ? fe.fx.start() : fe.timers.pop()
            }, fe.fx.interval = 13, fe.fx.start = function() {
                Dt || (Dt = e.setInterval(fe.fx.tick, fe.fx.interval))
            }, fe.fx.stop = function() {
                e.clearInterval(Dt), Dt = null
            }, fe.fx.speeds = {
                slow: 600,
                fast: 200,
                _default: 400
            }, fe.fn.delay = function(t, n) {
                return t = fe.fx ? fe.fx.speeds[t] || t : t, n = n || "fx", this.queue(n, function(n, i) {
                    var r = e.setTimeout(n, t);
                    i.stop = function() {
                        e.clearTimeout(r)
                    }
                })
            },
            function() {
                var e, t = ie.createElement("input"),
                    n = ie.createElement("div"),
                    i = ie.createElement("select"),
                    r = i.appendChild(ie.createElement("option"));
                n = ie.createElement("div"), n.setAttribute("className", "t"), n.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", e = n.getElementsByTagName("a")[0], t.setAttribute("type", "checkbox"), n.appendChild(t), e = n.getElementsByTagName("a")[0], e.style.cssText = "top:1px", de.getSetAttribute = "t" !== n.className, de.style = /top/.test(e.getAttribute("style")), de.hrefNormalized = "/a" === e.getAttribute("href"), de.checkOn = !!t.value, de.optSelected = r.selected, de.enctype = !!ie.createElement("form").enctype, i.disabled = !0, de.optDisabled = !r.disabled, t = ie.createElement("input"), t.setAttribute("value", ""), de.input = "" === t.getAttribute("value"), t.value = "t", t.setAttribute("type", "radio"), de.radioValue = "t" === t.value
            }();
        var At = /\r/g,
            It = /[\x20\t\r\n\f]+/g;
        fe.fn.extend({
            val: function(e) {
                var t, n, i, r = this[0]; {
                    if (arguments.length) return i = fe.isFunction(e), this.each(function(n) {
                        var r;
                        1 === this.nodeType && (r = i ? e.call(this, n, fe(this).val()) : e, null == r ? r = "" : "number" == typeof r ? r += "" : fe.isArray(r) && (r = fe.map(r, function(e) {
                            return null == e ? "" : e + ""
                        })), t = fe.valHooks[this.type] || fe.valHooks[this.nodeName.toLowerCase()], t && "set" in t && void 0 !== t.set(this, r, "value") || (this.value = r))
                    });
                    if (r) return t = fe.valHooks[r.type] || fe.valHooks[r.nodeName.toLowerCase()], t && "get" in t && void 0 !== (n = t.get(r, "value")) ? n : (n = r.value, "string" == typeof n ? n.replace(At, "") : null == n ? "" : n)
                }
            }
        }), fe.extend({
            valHooks: {
                option: {
                    get: function(e) {
                        var t = fe.find.attr(e, "value");
                        return null != t ? t : fe.trim(fe.text(e)).replace(It, " ")
                    }
                },
                select: {
                    get: function(e) {
                        for (var t, n, i = e.options, r = e.selectedIndex, o = "select-one" === e.type || r < 0, a = o ? null : [], s = o ? r + 1 : i.length, l = r < 0 ? s : o ? r : 0; l < s; l++)
                            if (n = i[l], (n.selected || l === r) && (de.optDisabled ? !n.disabled : null === n.getAttribute("disabled")) && (!n.parentNode.disabled || !fe.nodeName(n.parentNode, "optgroup"))) {
                                if (t = fe(n).val(), o) return t;
                                a.push(t)
                            }
                        return a
                    },
                    set: function(e, t) {
                        for (var n, i, r = e.options, o = fe.makeArray(t), a = r.length; a--;)
                            if (i = r[a], fe.inArray(fe.valHooks.option.get(i), o) > -1) try {
                                i.selected = n = !0
                            } catch (e) {
                                i.scrollHeight
                            } else i.selected = !1;
                        return n || (e.selectedIndex = -1), r
                    }
                }
            }
        }), fe.each(["radio", "checkbox"], function() {
            fe.valHooks[this] = {
                set: function(e, t) {
                    if (fe.isArray(t)) return e.checked = fe.inArray(fe(e).val(), t) > -1
                }
            }, de.checkOn || (fe.valHooks[this].get = function(e) {
                return null === e.getAttribute("value") ? "on" : e.value
            })
        });
        var $t, Lt, Nt = fe.expr.attrHandle,
            Et = /^(?:checked|selected)$/i,
            Rt = de.getSetAttribute,
            Pt = de.input;
        fe.fn.extend({
            attr: function(e, t) {
                return Oe(this, fe.attr, e, t, arguments.length > 1)
            },
            removeAttr: function(e) {
                return this.each(function() {
                    fe.removeAttr(this, e)
                })
            }
        }), fe.extend({
            attr: function(e, t, n) {
                var i, r, o = e.nodeType;
                if (3 !== o && 8 !== o && 2 !== o) return "undefined" == typeof e.getAttribute ? fe.prop(e, t, n) : (1 === o && fe.isXMLDoc(e) || (t = t.toLowerCase(), r = fe.attrHooks[t] || (fe.expr.match.bool.test(t) ? Lt : $t)), void 0 !== n ? null === n ? void fe.removeAttr(e, t) : r && "set" in r && void 0 !== (i = r.set(e, n, t)) ? i : (e.setAttribute(t, n + ""), n) : r && "get" in r && null !== (i = r.get(e, t)) ? i : (i = fe.find.attr(e, t), null == i ? void 0 : i))
            },
            attrHooks: {
                type: {
                    set: function(e, t) {
                        if (!de.radioValue && "radio" === t && fe.nodeName(e, "input")) {
                            var n = e.value;
                            return e.setAttribute("type", t), n && (e.value = n), t
                        }
                    }
                }
            },
            removeAttr: function(e, t) {
                var n, i, r = 0,
                    o = t && t.match(Ae);
                if (o && 1 === e.nodeType)
                    for (; n = o[r++];) i = fe.propFix[n] || n, fe.expr.match.bool.test(n) ? Pt && Rt || !Et.test(n) ? e[i] = !1 : e[fe.camelCase("default-" + n)] = e[i] = !1 : fe.attr(e, n, ""), e.removeAttribute(Rt ? n : i)
            }
        }), Lt = {
            set: function(e, t, n) {
                return t === !1 ? fe.removeAttr(e, n) : Pt && Rt || !Et.test(n) ? e.setAttribute(!Rt && fe.propFix[n] || n, n) : e[fe.camelCase("default-" + n)] = e[n] = !0, n
            }
        }, fe.each(fe.expr.match.bool.source.match(/\w+/g), function(e, t) {
            var n = Nt[t] || fe.find.attr;
            Pt && Rt || !Et.test(t) ? Nt[t] = function(e, t, i) {
                var r, o;
                return i || (o = Nt[t], Nt[t] = r, r = null != n(e, t, i) ? t.toLowerCase() : null, Nt[t] = o), r
            } : Nt[t] = function(e, t, n) {
                if (!n) return e[fe.camelCase("default-" + t)] ? t.toLowerCase() : null
            }
        }), Pt && Rt || (fe.attrHooks.value = {
            set: function(e, t, n) {
                return fe.nodeName(e, "input") ? void(e.defaultValue = t) : $t && $t.set(e, t, n)
            }
        }), Rt || ($t = {
            set: function(e, t, n) {
                var i = e.getAttributeNode(n);
                if (i || e.setAttributeNode(i = e.ownerDocument.createAttribute(n)), i.value = t += "", "value" === n || t === e.getAttribute(n)) return t
            }
        }, Nt.id = Nt.name = Nt.coords = function(e, t, n) {
            var i;
            if (!n) return (i = e.getAttributeNode(t)) && "" !== i.value ? i.value : null
        }, fe.valHooks.button = {
            get: function(e, t) {
                var n = e.getAttributeNode(t);
                if (n && n.specified) return n.value
            },
            set: $t.set
        }, fe.attrHooks.contenteditable = {
            set: function(e, t, n) {
                $t.set(e, "" !== t && t, n)
            }
        }, fe.each(["width", "height"], function(e, t) {
            fe.attrHooks[t] = {
                set: function(e, n) {
                    if ("" === n) return e.setAttribute(t, "auto"), n
                }
            }
        })), de.style || (fe.attrHooks.style = {
            get: function(e) {
                return e.style.cssText || void 0
            },
            set: function(e, t) {
                return e.style.cssText = t + ""
            }
        });
        var Ft = /^(?:input|select|textarea|button|object)$/i,
            Ht = /^(?:a|area)$/i;
        fe.fn.extend({
            prop: function(e, t) {
                return Oe(this, fe.prop, e, t, arguments.length > 1)
            },
            removeProp: function(e) {
                return e = fe.propFix[e] || e, this.each(function() {
                    try {
                        this[e] = void 0, delete this[e]
                    } catch (e) {}
                })
            }
        }), fe.extend({
            prop: function(e, t, n) {
                var i, r, o = e.nodeType;
                if (3 !== o && 8 !== o && 2 !== o) return 1 === o && fe.isXMLDoc(e) || (t = fe.propFix[t] || t, r = fe.propHooks[t]), void 0 !== n ? r && "set" in r && void 0 !== (i = r.set(e, n, t)) ? i : e[t] = n : r && "get" in r && null !== (i = r.get(e, t)) ? i : e[t]
            },
            propHooks: {
                tabIndex: {
                    get: function(e) {
                        var t = fe.find.attr(e, "tabindex");
                        return t ? parseInt(t, 10) : Ft.test(e.nodeName) || Ht.test(e.nodeName) && e.href ? 0 : -1
                    }
                }
            },
            propFix: {
                for: "htmlFor",
                class: "className"
            }
        }), de.hrefNormalized || fe.each(["href", "src"], function(e, t) {
            fe.propHooks[t] = {
                get: function(e) {
                    return e.getAttribute(t, 4)
                }
            }
        }), de.optSelected || (fe.propHooks.selected = {
            get: function(e) {
                var t = e.parentNode;
                return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex), null
            },
            set: function(e) {
                var t = e.parentNode;
                t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
            }
        }), fe.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
            fe.propFix[this.toLowerCase()] = this
        }), de.enctype || (fe.propFix.enctype = "encoding");
        var Ot = /[\t\r\n\f]/g;
        fe.fn.extend({
            addClass: function(e) {
                var t, n, i, r, o, a, s, l = 0;
                if (fe.isFunction(e)) return this.each(function(t) {
                    fe(this).addClass(e.call(this, t, z(this)))
                });
                if ("string" == typeof e && e)
                    for (t = e.match(Ae) || []; n = this[l++];)
                        if (r = z(n), i = 1 === n.nodeType && (" " + r + " ").replace(Ot, " ")) {
                            for (a = 0; o = t[a++];) i.indexOf(" " + o + " ") < 0 && (i += o + " ");
                            s = fe.trim(i), r !== s && fe.attr(n, "class", s)
                        }
                return this
            },
            removeClass: function(e) {
                var t, n, i, r, o, a, s, l = 0;
                if (fe.isFunction(e)) return this.each(function(t) {
                    fe(this).removeClass(e.call(this, t, z(this)))
                });
                if (!arguments.length) return this.attr("class", "");
                if ("string" == typeof e && e)
                    for (t = e.match(Ae) || []; n = this[l++];)
                        if (r = z(n), i = 1 === n.nodeType && (" " + r + " ").replace(Ot, " ")) {
                            for (a = 0; o = t[a++];)
                                for (; i.indexOf(" " + o + " ") > -1;) i = i.replace(" " + o + " ", " ");
                            s = fe.trim(i), r !== s && fe.attr(n, "class", s)
                        }
                return this
            },
            toggleClass: function(e, t) {
                var n = typeof e;
                return "boolean" == typeof t && "string" === n ? t ? this.addClass(e) : this.removeClass(e) : fe.isFunction(e) ? this.each(function(n) {
                    fe(this).toggleClass(e.call(this, n, z(this), t), t)
                }) : this.each(function() {
                    var t, i, r, o;
                    if ("string" === n)
                        for (i = 0, r = fe(this), o = e.match(Ae) || []; t = o[i++];) r.hasClass(t) ? r.removeClass(t) : r.addClass(t);
                    else void 0 !== e && "boolean" !== n || (t = z(this), t && fe._data(this, "__className__", t), fe.attr(this, "class", t || e === !1 ? "" : fe._data(this, "__className__") || ""))
                })
            },
            hasClass: function(e) {
                var t, n, i = 0;
                for (t = " " + e + " "; n = this[i++];)
                    if (1 === n.nodeType && (" " + z(n) + " ").replace(Ot, " ").indexOf(t) > -1) return !0;
                return !1
            }
        }), fe.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(e, t) {
            fe.fn[t] = function(e, n) {
                return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
            }
        }), fe.fn.extend({
            hover: function(e, t) {
                return this.mouseenter(e).mouseleave(t || e)
            }
        });
        var Qt = e.location,
            Bt = fe.now(),
            Mt = /\?/,
            Wt = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;
        fe.parseJSON = function(t) {
            if (e.JSON && e.JSON.parse) return e.JSON.parse(t + "");
            var n, i = null,
                r = fe.trim(t + "");
            return r && !fe.trim(r.replace(Wt, function(e, t, r, o) {
                return n && t && (i = 0), 0 === i ? e : (n = r || t, i += !o - !r, "")
            })) ? Function("return " + r)() : fe.error("Invalid JSON: " + t)
        }, fe.parseXML = function(t) {
            var n, i;
            if (!t || "string" != typeof t) return null;
            try {
                e.DOMParser ? (i = new e.DOMParser, n = i.parseFromString(t, "text/xml")) : (n = new e.ActiveXObject("Microsoft.XMLDOM"), n.async = "false", n.loadXML(t))
            } catch (e) {
                n = void 0
            }
            return n && n.documentElement && !n.getElementsByTagName("parsererror").length || fe.error("Invalid XML: " + t), n
        };
        var zt = /#.*$/,
            qt = /([?&])_=[^&]*/,
            Ut = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm,
            Vt = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
            Xt = /^(?:GET|HEAD)$/,
            Jt = /^\/\//,
            Gt = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,
            Kt = {},
            Yt = {},
            Zt = "*/".concat("*"),
            en = Qt.href,
            tn = Gt.exec(en.toLowerCase()) || [];
        fe.extend({
            active: 0,
            lastModified: {},
            etag: {},
            ajaxSettings: {
                url: en,
                type: "GET",
                isLocal: Vt.test(tn[1]),
                global: !0,
                processData: !0,
                async: !0,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                accepts: {
                    "*": Zt,
                    text: "text/plain",
                    html: "text/html",
                    xml: "application/xml, text/xml",
                    json: "application/json, text/javascript"
                },
                contents: {
                    xml: /\bxml\b/,
                    html: /\bhtml/,
                    json: /\bjson\b/
                },
                responseFields: {
                    xml: "responseXML",
                    text: "responseText",
                    json: "responseJSON"
                },
                converters: {
                    "* text": String,
                    "text html": !0,
                    "text json": fe.parseJSON,
                    "text xml": fe.parseXML
                },
                flatOptions: {
                    url: !0,
                    context: !0
                }
            },
            ajaxSetup: function(e, t) {
                return t ? V(V(e, fe.ajaxSettings), t) : V(fe.ajaxSettings, e)
            },
            ajaxPrefilter: q(Kt),
            ajaxTransport: q(Yt),
            ajax: function(t, n) {
                function i(t, n, i, r) {
                    var o, d, y, b, w, S = n;
                    2 !== x && (x = 2, l && e.clearTimeout(l), c = void 0, s = r || "", C.readyState = t > 0 ? 4 : 0, o = t >= 200 && t < 300 || 304 === t, i && (b = X(h, C, i)), b = J(h, b, C, o), o ? (h.ifModified && (w = C.getResponseHeader("Last-Modified"), w && (fe.lastModified[a] = w), w = C.getResponseHeader("etag"), w && (fe.etag[a] = w)), 204 === t || "HEAD" === h.type ? S = "nocontent" : 304 === t ? S = "notmodified" : (S = b.state, d = b.data, y = b.error, o = !y)) : (y = S, !t && S || (S = "error", t < 0 && (t = 0))), C.status = t, C.statusText = (n || S) + "", o ? g.resolveWith(f, [d, S, C]) : g.rejectWith(f, [C, S, y]), C.statusCode(v), v = void 0, u && p.trigger(o ? "ajaxSuccess" : "ajaxError", [C, h, o ? d : y]), m.fireWith(f, [C, S]), u && (p.trigger("ajaxComplete", [C, h]), --fe.active || fe.event.trigger("ajaxStop")))
                }
                "object" == typeof t && (n = t, t = void 0), n = n || {};
                var r, o, a, s, l, u, c, d, h = fe.ajaxSetup({}, n),
                    f = h.context || h,
                    p = h.context && (f.nodeType || f.jquery) ? fe(f) : fe.event,
                    g = fe.Deferred(),
                    m = fe.Callbacks("once memory"),
                    v = h.statusCode || {},
                    y = {},
                    b = {},
                    x = 0,
                    w = "canceled",
                    C = {
                        readyState: 0,
                        getResponseHeader: function(e) {
                            var t;
                            if (2 === x) {
                                if (!d)
                                    for (d = {}; t = Ut.exec(s);) d[t[1].toLowerCase()] = t[2];
                                t = d[e.toLowerCase()]
                            }
                            return null == t ? null : t
                        },
                        getAllResponseHeaders: function() {
                            return 2 === x ? s : null
                        },
                        setRequestHeader: function(e, t) {
                            var n = e.toLowerCase();
                            return x || (e = b[n] = b[n] || e, y[e] = t), this
                        },
                        overrideMimeType: function(e) {
                            return x || (h.mimeType = e), this
                        },
                        statusCode: function(e) {
                            var t;
                            if (e)
                                if (x < 2)
                                    for (t in e) v[t] = [v[t], e[t]];
                                else C.always(e[C.status]);
                            return this
                        },
                        abort: function(e) {
                            var t = e || w;
                            return c && c.abort(t), i(0, t), this
                        }
                    };
                if (g.promise(C).complete = m.add, C.success = C.done, C.error = C.fail, h.url = ((t || h.url || en) + "").replace(zt, "").replace(Jt, tn[1] + "//"), h.type = n.method || n.type || h.method || h.type, h.dataTypes = fe.trim(h.dataType || "*").toLowerCase().match(Ae) || [""], null == h.crossDomain && (r = Gt.exec(h.url.toLowerCase()), h.crossDomain = !(!r || r[1] === tn[1] && r[2] === tn[2] && (r[3] || ("http:" === r[1] ? "80" : "443")) === (tn[3] || ("http:" === tn[1] ? "80" : "443")))), h.data && h.processData && "string" != typeof h.data && (h.data = fe.param(h.data, h.traditional)), U(Kt, h, n, C), 2 === x) return C;
                u = fe.event && h.global, u && 0 === fe.active++ && fe.event.trigger("ajaxStart"), h.type = h.type.toUpperCase(), h.hasContent = !Xt.test(h.type), a = h.url, h.hasContent || (h.data && (a = h.url += (Mt.test(a) ? "&" : "?") + h.data, delete h.data), h.cache === !1 && (h.url = qt.test(a) ? a.replace(qt, "$1_=" + Bt++) : a + (Mt.test(a) ? "&" : "?") + "_=" + Bt++)), h.ifModified && (fe.lastModified[a] && C.setRequestHeader("If-Modified-Since", fe.lastModified[a]), fe.etag[a] && C.setRequestHeader("If-None-Match", fe.etag[a])), (h.data && h.hasContent && h.contentType !== !1 || n.contentType) && C.setRequestHeader("Content-Type", h.contentType), C.setRequestHeader("Accept", h.dataTypes[0] && h.accepts[h.dataTypes[0]] ? h.accepts[h.dataTypes[0]] + ("*" !== h.dataTypes[0] ? ", " + Zt + "; q=0.01" : "") : h.accepts["*"]);
                for (o in h.headers) C.setRequestHeader(o, h.headers[o]);
                if (h.beforeSend && (h.beforeSend.call(f, C, h) === !1 || 2 === x)) return C.abort();
                w = "abort";
                for (o in {
                        success: 1,
                        error: 1,
                        complete: 1
                    }) C[o](h[o]);
                if (c = U(Yt, h, n, C)) {
                    if (C.readyState = 1, u && p.trigger("ajaxSend", [C, h]), 2 === x) return C;
                    h.async && h.timeout > 0 && (l = e.setTimeout(function() {
                        C.abort("timeout")
                    }, h.timeout));
                    try {
                        x = 1, c.send(y, i)
                    } catch (e) {
                        if (!(x < 2)) throw e;
                        i(-1, e)
                    }
                } else i(-1, "No Transport");
                return C
            },
            getJSON: function(e, t, n) {
                return fe.get(e, t, n, "json")
            },
            getScript: function(e, t) {
                return fe.get(e, void 0, t, "script")
            }
        }), fe.each(["get", "post"], function(e, t) {
            fe[t] = function(e, n, i, r) {
                return fe.isFunction(n) && (r = r || i, i = n, n = void 0), fe.ajax(fe.extend({
                    url: e,
                    type: t,
                    dataType: r,
                    data: n,
                    success: i
                }, fe.isPlainObject(e) && e))
            }
        }), fe._evalUrl = function(e) {
            return fe.ajax({
                url: e,
                type: "GET",
                dataType: "script",
                cache: !0,
                async: !1,
                global: !1,
                throws: !0
            })
        }, fe.fn.extend({
            wrapAll: function(e) {
                if (fe.isFunction(e)) return this.each(function(t) {
                    fe(this).wrapAll(e.call(this, t))
                });
                if (this[0]) {
                    var t = fe(e, this[0].ownerDocument).eq(0).clone(!0);
                    this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
                        for (var e = this; e.firstChild && 1 === e.firstChild.nodeType;) e = e.firstChild;
                        return e
                    }).append(this)
                }
                return this
            },
            wrapInner: function(e) {
                return fe.isFunction(e) ? this.each(function(t) {
                    fe(this).wrapInner(e.call(this, t))
                }) : this.each(function() {
                    var t = fe(this),
                        n = t.contents();
                    n.length ? n.wrapAll(e) : t.append(e)
                })
            },
            wrap: function(e) {
                var t = fe.isFunction(e);
                return this.each(function(n) {
                    fe(this).wrapAll(t ? e.call(this, n) : e)
                })
            },
            unwrap: function() {
                return this.parent().each(function() {
                    fe.nodeName(this, "body") || fe(this).replaceWith(this.childNodes)
                }).end()
            }
        }), fe.expr.filters.hidden = function(e) {
            return de.reliableHiddenOffsets() ? e.offsetWidth <= 0 && e.offsetHeight <= 0 && !e.getClientRects().length : K(e)
        }, fe.expr.filters.visible = function(e) {
            return !fe.expr.filters.hidden(e)
        };
        var nn = /%20/g,
            rn = /\[\]$/,
            on = /\r?\n/g,
            an = /^(?:submit|button|image|reset|file)$/i,
            sn = /^(?:input|select|textarea|keygen)/i;
        fe.param = function(e, t) {
            var n, i = [],
                r = function(e, t) {
                    t = fe.isFunction(t) ? t() : null == t ? "" : t, i[i.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
                };
            if (void 0 === t && (t = fe.ajaxSettings && fe.ajaxSettings.traditional), fe.isArray(e) || e.jquery && !fe.isPlainObject(e)) fe.each(e, function() {
                r(this.name, this.value)
            });
            else
                for (n in e) Y(n, e[n], t, r);
            return i.join("&").replace(nn, "+")
        }, fe.fn.extend({
            serialize: function() {
                return fe.param(this.serializeArray())
            },
            serializeArray: function() {
                return this.map(function() {
                    var e = fe.prop(this, "elements");
                    return e ? fe.makeArray(e) : this
                }).filter(function() {
                    var e = this.type;
                    return this.name && !fe(this).is(":disabled") && sn.test(this.nodeName) && !an.test(e) && (this.checked || !Qe.test(e))
                }).map(function(e, t) {
                    var n = fe(this).val();
                    return null == n ? null : fe.isArray(n) ? fe.map(n, function(e) {
                        return {
                            name: t.name,
                            value: e.replace(on, "\r\n")
                        }
                    }) : {
                        name: t.name,
                        value: n.replace(on, "\r\n")
                    }
                }).get()
            }
        }), fe.ajaxSettings.xhr = void 0 !== e.ActiveXObject ? function() {
            return this.isLocal ? ee() : ie.documentMode > 8 ? Z() : /^(get|post|head|put|delete|options)$/i.test(this.type) && Z() || ee()
        } : Z;
        var ln = 0,
            un = {},
            cn = fe.ajaxSettings.xhr();
        e.attachEvent && e.attachEvent("onunload", function() {
            for (var e in un) un[e](void 0, !0)
        }), de.cors = !!cn && "withCredentials" in cn, cn = de.ajax = !!cn, cn && fe.ajaxTransport(function(t) {
            if (!t.crossDomain || de.cors) {
                var n;
                return {
                    send: function(i, r) {
                        var o, a = t.xhr(),
                            s = ++ln;
                        if (a.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields)
                            for (o in t.xhrFields) a[o] = t.xhrFields[o];
                        t.mimeType && a.overrideMimeType && a.overrideMimeType(t.mimeType), t.crossDomain || i["X-Requested-With"] || (i["X-Requested-With"] = "XMLHttpRequest");
                        for (o in i) void 0 !== i[o] && a.setRequestHeader(o, i[o] + "");
                        a.send(t.hasContent && t.data || null), n = function(e, i) {
                            var o, l, u;
                            if (n && (i || 4 === a.readyState))
                                if (delete un[s], n = void 0, a.onreadystatechange = fe.noop, i) 4 !== a.readyState && a.abort();
                                else {
                                    u = {}, o = a.status, "string" == typeof a.responseText && (u.text = a.responseText);
                                    try {
                                        l = a.statusText
                                    } catch (e) {
                                        l = ""
                                    }
                                    o || !t.isLocal || t.crossDomain ? 1223 === o && (o = 204) : o = u.text ? 200 : 404
                                }
                            u && r(o, l, u, a.getAllResponseHeaders())
                        }, t.async ? 4 === a.readyState ? e.setTimeout(n) : a.onreadystatechange = un[s] = n : n()
                    },
                    abort: function() {
                        n && n(void 0, !0)
                    }
                }
            }
        }), fe.ajaxSetup({
            accepts: {
                script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
            },
            contents: {
                script: /\b(?:java|ecma)script\b/
            },
            converters: {
                "text script": function(e) {
                    return fe.globalEval(e), e
                }
            }
        }), fe.ajaxPrefilter("script", function(e) {
            void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET", e.global = !1)
        }), fe.ajaxTransport("script", function(e) {
            if (e.crossDomain) {
                var t, n = ie.head || fe("head")[0] || ie.documentElement;
                return {
                    send: function(i, r) {
                        t = ie.createElement("script"), t.async = !0, e.scriptCharset && (t.charset = e.scriptCharset), t.src = e.url, t.onload = t.onreadystatechange = function(e, n) {
                            (n || !t.readyState || /loaded|complete/.test(t.readyState)) && (t.onload = t.onreadystatechange = null, t.parentNode && t.parentNode.removeChild(t), t = null, n || r(200, "success"))
                        }, n.insertBefore(t, n.firstChild)
                    },
                    abort: function() {
                        t && t.onload(void 0, !0)
                    }
                }
            }
        });
        var dn = [],
            hn = /(=)\?(?=&|$)|\?\?/;
        fe.ajaxSetup({
            jsonp: "callback",
            jsonpCallback: function() {
                var e = dn.pop() || fe.expando + "_" + Bt++;
                return this[e] = !0, e
            }
        }), fe.ajaxPrefilter("json jsonp", function(t, n, i) {
            var r, o, a, s = t.jsonp !== !1 && (hn.test(t.url) ? "url" : "string" == typeof t.data && 0 === (t.contentType || "").indexOf("application/x-www-form-urlencoded") && hn.test(t.data) && "data");
            if (s || "jsonp" === t.dataTypes[0]) return r = t.jsonpCallback = fe.isFunction(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, s ? t[s] = t[s].replace(hn, "$1" + r) : t.jsonp !== !1 && (t.url += (Mt.test(t.url) ? "&" : "?") + t.jsonp + "=" + r), t.converters["script json"] = function() {
                return a || fe.error(r + " was not called"), a[0]
            }, t.dataTypes[0] = "json", o = e[r], e[r] = function() {
                a = arguments
            }, i.always(function() {
                void 0 === o ? fe(e).removeProp(r) : e[r] = o, t[r] && (t.jsonpCallback = n.jsonpCallback, dn.push(r)), a && fe.isFunction(o) && o(a[0]), a = o = void 0
            }), "script"
        }), fe.parseHTML = function(e, t, n) {
            if (!e || "string" != typeof e) return null;
            "boolean" == typeof t && (n = t, t = !1), t = t || ie;
            var i = Ce.exec(e),
                r = !n && [];
            return i ? [t.createElement(i[1])] : (i = v([e], t, r), r && r.length && fe(r).remove(), fe.merge([], i.childNodes))
        };
        var fn = fe.fn.load;
        fe.fn.load = function(e, t, n) {
            if ("string" != typeof e && fn) return fn.apply(this, arguments);
            var i, r, o, a = this,
                s = e.indexOf(" ");
            return s > -1 && (i = fe.trim(e.slice(s, e.length)), e = e.slice(0, s)), fe.isFunction(t) ? (n = t, t = void 0) : t && "object" == typeof t && (r = "POST"), a.length > 0 && fe.ajax({
                url: e,
                type: r || "GET",
                dataType: "html",
                data: t
            }).done(function(e) {
                o = arguments, a.html(i ? fe("<div>").append(fe.parseHTML(e)).find(i) : e)
            }).always(n && function(e, t) {
                a.each(function() {
                    n.apply(this, o || [e.responseText, t, e])
                })
            }), this
        }, fe.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(e, t) {
            fe.fn[t] = function(e) {
                return this.on(t, e)
            }
        }), fe.expr.filters.animated = function(e) {
            return fe.grep(fe.timers, function(t) {
                return e === t.elem
            }).length
        }, fe.offset = {
            setOffset: function(e, t, n) {
                var i, r, o, a, s, l, u, c = fe.css(e, "position"),
                    d = fe(e),
                    h = {};
                "static" === c && (e.style.position = "relative"), s = d.offset(), o = fe.css(e, "top"), l = fe.css(e, "left"), u = ("absolute" === c || "fixed" === c) && fe.inArray("auto", [o, l]) > -1, u ? (i = d.position(), a = i.top, r = i.left) : (a = parseFloat(o) || 0, r = parseFloat(l) || 0), fe.isFunction(t) && (t = t.call(e, n, fe.extend({}, s))), null != t.top && (h.top = t.top - s.top + a), null != t.left && (h.left = t.left - s.left + r), "using" in t ? t.using.call(e, h) : d.css(h)
            }
        }, fe.fn.extend({
            offset: function(e) {
                if (arguments.length) return void 0 === e ? this : this.each(function(t) {
                    fe.offset.setOffset(this, e, t)
                });
                var t, n, i = {
                        top: 0,
                        left: 0
                    },
                    r = this[0],
                    o = r && r.ownerDocument;
                if (o) return t = o.documentElement, fe.contains(t, r) ? ("undefined" != typeof r.getBoundingClientRect && (i = r.getBoundingClientRect()), n = te(o), {
                    top: i.top + (n.pageYOffset || t.scrollTop) - (t.clientTop || 0),
                    left: i.left + (n.pageXOffset || t.scrollLeft) - (t.clientLeft || 0)
                }) : i
            },
            position: function() {
                if (this[0]) {
                    var e, t, n = {
                            top: 0,
                            left: 0
                        },
                        i = this[0];
                    return "fixed" === fe.css(i, "position") ? t = i.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), fe.nodeName(e[0], "html") || (n = e.offset()), n.top += fe.css(e[0], "borderTopWidth", !0), n.left += fe.css(e[0], "borderLeftWidth", !0)), {
                        top: t.top - n.top - fe.css(i, "marginTop", !0),
                        left: t.left - n.left - fe.css(i, "marginLeft", !0)
                    }
                }
            },
            offsetParent: function() {
                return this.map(function() {
                    for (var e = this.offsetParent; e && !fe.nodeName(e, "html") && "static" === fe.css(e, "position");) e = e.offsetParent;
                    return e || ft
                })
            }
        }), fe.each({
            scrollLeft: "pageXOffset",
            scrollTop: "pageYOffset"
        }, function(e, t) {
            var n = /Y/.test(t);
            fe.fn[e] = function(i) {
                return Oe(this, function(e, i, r) {
                    var o = te(e);
                    return void 0 === r ? o ? t in o ? o[t] : o.document.documentElement[i] : e[i] : void(o ? o.scrollTo(n ? fe(o).scrollLeft() : r, n ? r : fe(o).scrollTop()) : e[i] = r)
                }, e, i, arguments.length, null)
            }
        }), fe.each(["top", "left"], function(e, t) {
            fe.cssHooks[t] = $(de.pixelPosition, function(e, n) {
                if (n) return n = gt(e, t), dt.test(n) ? fe(e).position()[t] + "px" : n
            })
        }), fe.each({
            Height: "height",
            Width: "width"
        }, function(e, t) {
            fe.each({
                padding: "inner" + e,
                content: t,
                "": "outer" + e
            }, function(n, i) {
                fe.fn[i] = function(i, r) {
                    var o = arguments.length && (n || "boolean" != typeof i),
                        a = n || (i === !0 || r === !0 ? "margin" : "border");
                    return Oe(this, function(t, n, i) {
                        var r;
                        return fe.isWindow(t) ? t.document.documentElement["client" + e] : 9 === t.nodeType ? (r = t.documentElement, Math.max(t.body["scroll" + e], r["scroll" + e], t.body["offset" + e], r["offset" + e], r["client" + e])) : void 0 === i ? fe.css(t, n, a) : fe.style(t, n, i, a)
                    }, t, o ? i : void 0, o, null)
                }
            })
        }), fe.fn.extend({
            bind: function(e, t, n) {
                return this.on(e, null, t, n)
            },
            unbind: function(e, t) {
                return this.off(e, null, t)
            },
            delegate: function(e, t, n, i) {
                return this.on(t, e, n, i)
            },
            undelegate: function(e, t, n) {
                return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
            }
        }), fe.fn.size = function() {
            return this.length
        }, fe.fn.andSelf = fe.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function() {
            return fe
        });
        var pn = e.jQuery,
            gn = e.$;
        return fe.noConflict = function(t) {
            return e.$ === fe && (e.$ = gn), t && e.jQuery === fe && (e.jQuery = pn), fe
        }, t || (e.jQuery = e.$ = fe), fe
    }), "undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery"); + function(e) {
    "use strict";
    var t = e.fn.jquery.split(" ")[0].split(".");
    if (t[0] < 2 && t[1] < 9 || 1 == t[0] && 9 == t[1] && t[2] < 1 || t[0] > 3) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")
}(jQuery), + function(e) {
    "use strict";

    function t() {
        var e = document.createElement("bootstrap"),
            t = {
                WebkitTransition: "webkitTransitionEnd",
                MozTransition: "transitionend",
                OTransition: "oTransitionEnd otransitionend",
                transition: "transitionend"
            };
        for (var n in t)
            if (void 0 !== e.style[n]) return {
                end: t[n]
            };
        return !1
    }
    e.fn.emulateTransitionEnd = function(t) {
        var n = !1,
            i = this;
        e(this).one("bsTransitionEnd", function() {
            n = !0
        });
        var r = function() {
            n || e(i).trigger(e.support.transition.end)
        };
        return setTimeout(r, t), this
    }, e(function() {
        e.support.transition = t(), e.support.transition && (e.event.special.bsTransitionEnd = {
            bindType: e.support.transition.end,
            delegateType: e.support.transition.end,
            handle: function(t) {
                if (e(t.target).is(this)) return t.handleObj.handler.apply(this, arguments)
            }
        })
    })
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        return this.each(function() {
            var n = e(this),
                r = n.data("bs.alert");
            r || n.data("bs.alert", r = new i(this)), "string" == typeof t && r[t].call(n)
        })
    }
    var n = '[data-dismiss="alert"]',
        i = function(t) {
            e(t).on("click", n, this.close)
        };
    i.VERSION = "3.3.7", i.TRANSITION_DURATION = 150, i.prototype.close = function(t) {
        function n() {
            a.detach().trigger("closed.bs.alert").remove()
        }
        var r = e(this),
            o = r.attr("data-target");
        o || (o = r.attr("href"), o = o && o.replace(/.*(?=#[^\s]*$)/, ""));
        var a = e("#" === o ? [] : o);
        t && t.preventDefault(), a.length || (a = r.closest(".alert")), a.trigger(t = e.Event("close.bs.alert")), t.isDefaultPrevented() || (a.removeClass("in"), e.support.transition && a.hasClass("fade") ? a.one("bsTransitionEnd", n).emulateTransitionEnd(i.TRANSITION_DURATION) : n())
    };
    var r = e.fn.alert;
    e.fn.alert = t, e.fn.alert.Constructor = i, e.fn.alert.noConflict = function() {
        return e.fn.alert = r, this
    }, e(document).on("click.bs.alert.data-api", n, i.prototype.close)
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        return this.each(function() {
            var i = e(this),
                r = i.data("bs.button"),
                o = "object" == typeof t && t;
            r || i.data("bs.button", r = new n(this, o)), "toggle" == t ? r.toggle() : t && r.setState(t)
        })
    }
    var n = function(t, i) {
        this.$element = e(t), this.options = e.extend({}, n.DEFAULTS, i), this.isLoading = !1
    };
    n.VERSION = "3.3.7", n.DEFAULTS = {
        loadingText: "loading..."
    }, n.prototype.setState = function(t) {
        var n = "disabled",
            i = this.$element,
            r = i.is("input") ? "val" : "html",
            o = i.data();
        t += "Text", null == o.resetText && i.data("resetText", i[r]()), setTimeout(e.proxy(function() {
            i[r](null == o[t] ? this.options[t] : o[t]), "loadingText" == t ? (this.isLoading = !0, i.addClass(n).attr(n, n).prop(n, !0)) : this.isLoading && (this.isLoading = !1, i.removeClass(n).removeAttr(n).prop(n, !1))
        }, this), 0)
    }, n.prototype.toggle = function() {
        var e = !0,
            t = this.$element.closest('[data-toggle="buttons"]');
        if (t.length) {
            var n = this.$element.find("input");
            "radio" == n.prop("type") ? (n.prop("checked") && (e = !1), t.find(".active").removeClass("active"), this.$element.addClass("active")) : "checkbox" == n.prop("type") && (n.prop("checked") !== this.$element.hasClass("active") && (e = !1), this.$element.toggleClass("active")), n.prop("checked", this.$element.hasClass("active")), e && n.trigger("change")
        } else this.$element.attr("aria-pressed", !this.$element.hasClass("active")), this.$element.toggleClass("active")
    };
    var i = e.fn.button;
    e.fn.button = t, e.fn.button.Constructor = n, e.fn.button.noConflict = function() {
        return e.fn.button = i, this
    }, e(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function(n) {
        var i = e(n.target).closest(".btn");
        t.call(i, "toggle"), e(n.target).is('input[type="radio"], input[type="checkbox"]') || (n.preventDefault(), i.is("input,button") ? i.trigger("focus") : i.find("input:visible,button:visible").first().trigger("focus"))
    }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function(t) {
        e(t.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(t.type))
    })
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        return this.each(function() {
            var i = e(this),
                r = i.data("bs.carousel"),
                o = e.extend({}, n.DEFAULTS, i.data(), "object" == typeof t && t),
                a = "string" == typeof t ? t : o.slide;
            r || i.data("bs.carousel", r = new n(this, o)), "number" == typeof t ? r.to(t) : a ? r[a]() : o.interval && r.pause().cycle()
        })
    }
    var n = function(t, n) {
        this.$element = e(t), this.$indicators = this.$element.find(".carousel-indicators"), this.options = n, this.paused = null, this.sliding = null, this.interval = null, this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", e.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", e.proxy(this.pause, this)).on("mouseleave.bs.carousel", e.proxy(this.cycle, this))
    };
    n.VERSION = "3.3.7", n.TRANSITION_DURATION = 600, n.DEFAULTS = {
        interval: 5e3,
        pause: "hover",
        wrap: !0,
        keyboard: !0
    }, n.prototype.keydown = function(e) {
        if (!/input|textarea/i.test(e.target.tagName)) {
            switch (e.which) {
                case 37:
                    this.prev();
                    break;
                case 39:
                    this.next();
                    break;
                default:
                    return
            }
            e.preventDefault()
        }
    }, n.prototype.cycle = function(t) {
        return t || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(e.proxy(this.next, this), this.options.interval)), this
    }, n.prototype.getItemIndex = function(e) {
        return this.$items = e.parent().children(".item"), this.$items.index(e || this.$active)
    }, n.prototype.getItemForDirection = function(e, t) {
        var n = this.getItemIndex(t),
            i = "prev" == e && 0 === n || "next" == e && n == this.$items.length - 1;
        if (i && !this.options.wrap) return t;
        var r = "prev" == e ? -1 : 1,
            o = (n + r) % this.$items.length;
        return this.$items.eq(o)
    }, n.prototype.to = function(e) {
        var t = this,
            n = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        if (!(e > this.$items.length - 1 || e < 0)) return this.sliding ? this.$element.one("slid.bs.carousel", function() {
            t.to(e)
        }) : n == e ? this.pause().cycle() : this.slide(e > n ? "next" : "prev", this.$items.eq(e))
    }, n.prototype.pause = function(t) {
        return t || (this.paused = !0), this.$element.find(".next, .prev").length && e.support.transition && (this.$element.trigger(e.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
    }, n.prototype.next = function() {
        if (!this.sliding) return this.slide("next")
    }, n.prototype.prev = function() {
        if (!this.sliding) return this.slide("prev")
    }, n.prototype.slide = function(t, i) {
        var r = this.$element.find(".item.active"),
            o = i || this.getItemForDirection(t, r),
            a = this.interval,
            s = "next" == t ? "left" : "right",
            l = this;
        if (o.hasClass("active")) return this.sliding = !1;
        var u = o[0],
            c = e.Event("slide.bs.carousel", {
                relatedTarget: u,
                direction: s
            });
        if (this.$element.trigger(c), !c.isDefaultPrevented()) {
            if (this.sliding = !0, a && this.pause(), this.$indicators.length) {
                this.$indicators.find(".active").removeClass("active");
                var d = e(this.$indicators.children()[this.getItemIndex(o)]);
                d && d.addClass("active")
            }
            var h = e.Event("slid.bs.carousel", {
                relatedTarget: u,
                direction: s
            });
            return e.support.transition && this.$element.hasClass("slide") ? (o.addClass(t), o[0].offsetWidth, r.addClass(s), o.addClass(s), r.one("bsTransitionEnd", function() {
                o.removeClass([t, s].join(" ")).addClass("active"), r.removeClass(["active", s].join(" ")), l.sliding = !1, setTimeout(function() {
                    l.$element.trigger(h)
                }, 0)
            }).emulateTransitionEnd(n.TRANSITION_DURATION)) : (r.removeClass("active"), o.addClass("active"), this.sliding = !1, this.$element.trigger(h)), a && this.cycle(), this
        }
    };
    var i = e.fn.carousel;
    e.fn.carousel = t, e.fn.carousel.Constructor = n, e.fn.carousel.noConflict = function() {
        return e.fn.carousel = i, this
    };
    var r = function(n) {
        var i, r = e(this),
            o = e(r.attr("data-target") || (i = r.attr("href")) && i.replace(/.*(?=#[^\s]+$)/, ""));
        if (o.hasClass("carousel")) {
            var a = e.extend({}, o.data(), r.data()),
                s = r.attr("data-slide-to");
            s && (a.interval = !1), t.call(o, a), s && o.data("bs.carousel").to(s), n.preventDefault()
        }
    };
    e(document).on("click.bs.carousel.data-api", "[data-slide]", r).on("click.bs.carousel.data-api", "[data-slide-to]", r), e(window).on("load", function() {
        e('[data-ride="carousel"]').each(function() {
            var n = e(this);
            t.call(n, n.data())
        })
    })
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        var n, i = t.attr("data-target") || (n = t.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, "");
        return e(i)
    }

    function n(t) {
        return this.each(function() {
            var n = e(this),
                r = n.data("bs.collapse"),
                o = e.extend({}, i.DEFAULTS, n.data(), "object" == typeof t && t);
            !r && o.toggle && /show|hide/.test(t) && (o.toggle = !1), r || n.data("bs.collapse", r = new i(this, o)), "string" == typeof t && r[t]()
        })
    }
    var i = function(t, n) {
        this.$element = e(t), this.options = e.extend({}, i.DEFAULTS, n), this.$trigger = e('[data-toggle="collapse"][href="#' + t.id + '"],[data-toggle="collapse"][data-target="#' + t.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle()
    };
    i.VERSION = "3.3.7", i.TRANSITION_DURATION = 350, i.DEFAULTS = {
        toggle: !0
    }, i.prototype.dimension = function() {
        var e = this.$element.hasClass("width");
        return e ? "width" : "height"
    }, i.prototype.show = function() {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var t, r = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
            if (!(r && r.length && (t = r.data("bs.collapse"), t && t.transitioning))) {
                var o = e.Event("show.bs.collapse");
                if (this.$element.trigger(o), !o.isDefaultPrevented()) {
                    r && r.length && (n.call(r, "hide"), t || r.data("bs.collapse", null));
                    var a = this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[a](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                    var s = function() {
                        this.$element.removeClass("collapsing").addClass("collapse in")[a](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                    };
                    if (!e.support.transition) return s.call(this);
                    var l = e.camelCase(["scroll", a].join("-"));
                    this.$element.one("bsTransitionEnd", e.proxy(s, this)).emulateTransitionEnd(i.TRANSITION_DURATION)[a](this.$element[0][l])
                }
            }
        }
    }, i.prototype.hide = function() {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var t = e.Event("hide.bs.collapse");
            if (this.$element.trigger(t), !t.isDefaultPrevented()) {
                var n = this.dimension();
                this.$element[n](this.$element[n]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                var r = function() {
                    this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                };
                return e.support.transition ? void this.$element[n](0).one("bsTransitionEnd", e.proxy(r, this)).emulateTransitionEnd(i.TRANSITION_DURATION) : r.call(this)
            }
        }
    }, i.prototype.toggle = function() {
        this[this.$element.hasClass("in") ? "hide" : "show"]()
    }, i.prototype.getParent = function() {
        return e(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(e.proxy(function(n, i) {
            var r = e(i);
            this.addAriaAndCollapsedClass(t(r), r)
        }, this)).end()
    }, i.prototype.addAriaAndCollapsedClass = function(e, t) {
        var n = e.hasClass("in");
        e.attr("aria-expanded", n), t.toggleClass("collapsed", !n).attr("aria-expanded", n)
    };
    var r = e.fn.collapse;
    e.fn.collapse = n, e.fn.collapse.Constructor = i, e.fn.collapse.noConflict = function() {
        return e.fn.collapse = r, this
    }, e(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function(i) {
        var r = e(this);
        r.attr("data-target") || i.preventDefault();
        var o = t(r),
            a = o.data("bs.collapse"),
            s = a ? "toggle" : r.data();
        n.call(o, s)
    })
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        var n = t.attr("data-target");
        n || (n = t.attr("href"), n = n && /#[A-Za-z]/.test(n) && n.replace(/.*(?=#[^\s]*$)/, ""));
        var i = n && e(n);
        return i && i.length ? i : t.parent()
    }

    function n(n) {
        n && 3 === n.which || (e(r).remove(), e(o).each(function() {
            var i = e(this),
                r = t(i),
                o = {
                    relatedTarget: this
                };
            r.hasClass("open") && (n && "click" == n.type && /input|textarea/i.test(n.target.tagName) && e.contains(r[0], n.target) || (r.trigger(n = e.Event("hide.bs.dropdown", o)), n.isDefaultPrevented() || (i.attr("aria-expanded", "false"), r.removeClass("open").trigger(e.Event("hidden.bs.dropdown", o)))))
        }))
    }

    function i(t) {
        return this.each(function() {
            var n = e(this),
                i = n.data("bs.dropdown");
            i || n.data("bs.dropdown", i = new a(this)), "string" == typeof t && i[t].call(n)
        })
    }
    var r = ".dropdown-backdrop",
        o = '[data-toggle="dropdown"]',
        a = function(t) {
            e(t).on("click.bs.dropdown", this.toggle)
        };
    a.VERSION = "3.3.7", a.prototype.toggle = function(i) {
        var r = e(this);
        if (!r.is(".disabled, :disabled")) {
            var o = t(r),
                a = o.hasClass("open");
            if (n(), !a) {
                "ontouchstart" in document.documentElement && !o.closest(".navbar-nav").length && e(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(e(this)).on("click", n);
                var s = {
                    relatedTarget: this
                };
                if (o.trigger(i = e.Event("show.bs.dropdown", s)), i.isDefaultPrevented()) return;
                r.trigger("focus").attr("aria-expanded", "true"), o.toggleClass("open").trigger(e.Event("shown.bs.dropdown", s))
            }
            return !1
        }
    }, a.prototype.keydown = function(n) {
        if (/(38|40|27|32)/.test(n.which) && !/input|textarea/i.test(n.target.tagName)) {
            var i = e(this);
            if (n.preventDefault(), n.stopPropagation(), !i.is(".disabled, :disabled")) {
                var r = t(i),
                    a = r.hasClass("open");
                if (!a && 27 != n.which || a && 27 == n.which) return 27 == n.which && r.find(o).trigger("focus"), i.trigger("click");
                var s = " li:not(.disabled):visible a",
                    l = r.find(".dropdown-menu" + s);
                if (l.length) {
                    var u = l.index(n.target);
                    38 == n.which && u > 0 && u--, 40 == n.which && u < l.length - 1 && u++, ~u || (u = 0), l.eq(u).trigger("focus")
                }
            }
        }
    };
    var s = e.fn.dropdown;
    e.fn.dropdown = i, e.fn.dropdown.Constructor = a, e.fn.dropdown.noConflict = function() {
        return e.fn.dropdown = s, this
    }, e(document).on("click.bs.dropdown.data-api", n).on("click.bs.dropdown.data-api", ".dropdown form", function(e) {
        e.stopPropagation()
    }).on("click.bs.dropdown.data-api", o, a.prototype.toggle).on("keydown.bs.dropdown.data-api", o, a.prototype.keydown).on("keydown.bs.dropdown.data-api", ".dropdown-menu", a.prototype.keydown)
}(jQuery), + function(e) {
    "use strict";

    function t(t, i) {
        return this.each(function() {
            var r = e(this),
                o = r.data("bs.modal"),
                a = e.extend({}, n.DEFAULTS, r.data(), "object" == typeof t && t);
            o || r.data("bs.modal", o = new n(this, a)), "string" == typeof t ? o[t](i) : a.show && o.show(i)
        })
    }
    var n = function(t, n) {
        this.options = n, this.$body = e(document.body), this.$element = e(t), this.$dialog = this.$element.find(".modal-dialog"), this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, e.proxy(function() {
            this.$element.trigger("loaded.bs.modal")
        }, this))
    };
    n.VERSION = "3.3.7", n.TRANSITION_DURATION = 300, n.BACKDROP_TRANSITION_DURATION = 150, n.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, n.prototype.toggle = function(e) {
        return this.isShown ? this.hide() : this.show(e)
    }, n.prototype.show = function(t) {
        var i = this,
            r = e.Event("show.bs.modal", {
                relatedTarget: t
            });
        this.$element.trigger(r), this.isShown || r.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', e.proxy(this.hide, this)), this.$dialog.on("mousedown.dismiss.bs.modal", function() {
            i.$element.one("mouseup.dismiss.bs.modal", function(t) {
                e(t.target).is(i.$element) && (i.ignoreBackdropClick = !0)
            })
        }), this.backdrop(function() {
            var r = e.support.transition && i.$element.hasClass("fade");
            i.$element.parent().length || i.$element.appendTo(i.$body), i.$element.show().scrollTop(0), i.adjustDialog(), r && i.$element[0].offsetWidth, i.$element.addClass("in"), i.enforceFocus();
            var o = e.Event("shown.bs.modal", {
                relatedTarget: t
            });
            r ? i.$dialog.one("bsTransitionEnd", function() {
                i.$element.trigger("focus").trigger(o)
            }).emulateTransitionEnd(n.TRANSITION_DURATION) : i.$element.trigger("focus").trigger(o)
        }))
    }, n.prototype.hide = function(t) {
        t && t.preventDefault(), t = e.Event("hide.bs.modal"), this.$element.trigger(t), this.isShown && !t.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), e(document).off("focusin.bs.modal"), this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), this.$dialog.off("mousedown.dismiss.bs.modal"), e.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", e.proxy(this.hideModal, this)).emulateTransitionEnd(n.TRANSITION_DURATION) : this.hideModal())
    }, n.prototype.enforceFocus = function() {
        e(document).off("focusin.bs.modal").on("focusin.bs.modal", e.proxy(function(e) {
            document === e.target || this.$element[0] === e.target || this.$element.has(e.target).length || this.$element.trigger("focus")
        }, this))
    }, n.prototype.escape = function() {
        this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", e.proxy(function(e) {
            27 == e.which && this.hide()
        }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
    }, n.prototype.resize = function() {
        this.isShown ? e(window).on("resize.bs.modal", e.proxy(this.handleUpdate, this)) : e(window).off("resize.bs.modal")
    }, n.prototype.hideModal = function() {
        var e = this;
        this.$element.hide(), this.backdrop(function() {
            e.$body.removeClass("modal-open"), e.resetAdjustments(), e.resetScrollbar(), e.$element.trigger("hidden.bs.modal")
        })
    }, n.prototype.removeBackdrop = function() {
        this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
    }, n.prototype.backdrop = function(t) {
        var i = this,
            r = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var o = e.support.transition && r;
            if (this.$backdrop = e(document.createElement("div")).addClass("modal-backdrop " + r).appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", e.proxy(function(e) {
                    return this.ignoreBackdropClick ? void(this.ignoreBackdropClick = !1) : void(e.target === e.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide()))
                }, this)), o && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !t) return;
            o ? this.$backdrop.one("bsTransitionEnd", t).emulateTransitionEnd(n.BACKDROP_TRANSITION_DURATION) : t()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var a = function() {
                i.removeBackdrop(), t && t()
            };
            e.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", a).emulateTransitionEnd(n.BACKDROP_TRANSITION_DURATION) : a()
        } else t && t()
    }, n.prototype.handleUpdate = function() {
        this.adjustDialog()
    }, n.prototype.adjustDialog = function() {
        var e = this.$element[0].scrollHeight > document.documentElement.clientHeight;
        this.$element.css({
            paddingLeft: !this.bodyIsOverflowing && e ? this.scrollbarWidth : "",
            paddingRight: this.bodyIsOverflowing && !e ? this.scrollbarWidth : ""
        })
    }, n.prototype.resetAdjustments = function() {
        this.$element.css({
            paddingLeft: "",
            paddingRight: ""
        })
    }, n.prototype.checkScrollbar = function() {
        var e = window.innerWidth;
        if (!e) {
            var t = document.documentElement.getBoundingClientRect();
            e = t.right - Math.abs(t.left)
        }
        this.bodyIsOverflowing = document.body.clientWidth < e, this.scrollbarWidth = this.measureScrollbar()
    }, n.prototype.setScrollbar = function() {
        var e = parseInt(this.$body.css("padding-right") || 0, 10);
        this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", e + this.scrollbarWidth)
    }, n.prototype.resetScrollbar = function() {
        this.$body.css("padding-right", this.originalBodyPad)
    }, n.prototype.measureScrollbar = function() {
        var e = document.createElement("div");
        e.className = "modal-scrollbar-measure", this.$body.append(e);
        var t = e.offsetWidth - e.clientWidth;
        return this.$body[0].removeChild(e), t
    };
    var i = e.fn.modal;
    e.fn.modal = t, e.fn.modal.Constructor = n, e.fn.modal.noConflict = function() {
        return e.fn.modal = i, this
    }, e(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function(n) {
        var i = e(this),
            r = i.attr("href"),
            o = e(i.attr("data-target") || r && r.replace(/.*(?=#[^\s]+$)/, "")),
            a = o.data("bs.modal") ? "toggle" : e.extend({
                remote: !/#/.test(r) && r
            }, o.data(), i.data());
        i.is("a") && n.preventDefault(), o.one("show.bs.modal", function(e) {
            e.isDefaultPrevented() || o.one("hidden.bs.modal", function() {
                i.is(":visible") && i.trigger("focus")
            })
        }), t.call(o, a, this)
    })
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        return this.each(function() {
            var i = e(this),
                r = i.data("bs.tooltip"),
                o = "object" == typeof t && t;
            !r && /destroy|hide/.test(t) || (r || i.data("bs.tooltip", r = new n(this, o)), "string" == typeof t && r[t]())
        })
    }
    var n = function(e, t) {
        this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.inState = null, this.init("tooltip", e, t)
    };
    n.VERSION = "3.3.7", n.TRANSITION_DURATION = 150, n.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1,
        viewport: {
            selector: "body",
            padding: 0
        }
    }, n.prototype.init = function(t, n, i) {
        if (this.enabled = !0, this.type = t, this.$element = e(n), this.options = this.getOptions(i), this.$viewport = this.options.viewport && e(e.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport), this.inState = {
                click: !1,
                hover: !1,
                focus: !1
            }, this.$element[0] instanceof document.constructor && !this.options.selector) throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
        for (var r = this.options.trigger.split(" "), o = r.length; o--;) {
            var a = r[o];
            if ("click" == a) this.$element.on("click." + this.type, this.options.selector, e.proxy(this.toggle, this));
            else if ("manual" != a) {
                var s = "hover" == a ? "mouseenter" : "focusin",
                    l = "hover" == a ? "mouseleave" : "focusout";
                this.$element.on(s + "." + this.type, this.options.selector, e.proxy(this.enter, this)), this.$element.on(l + "." + this.type, this.options.selector, e.proxy(this.leave, this))
            }
        }
        this.options.selector ? this._options = e.extend({}, this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle()
    }, n.prototype.getDefaults = function() {
        return n.DEFAULTS
    }, n.prototype.getOptions = function(t) {
        return t = e.extend({}, this.getDefaults(), this.$element.data(), t), t.delay && "number" == typeof t.delay && (t.delay = {
            show: t.delay,
            hide: t.delay
        }), t
    }, n.prototype.getDelegateOptions = function() {
        var t = {},
            n = this.getDefaults();
        return this._options && e.each(this._options, function(e, i) {
            n[e] != i && (t[e] = i)
        }), t
    }, n.prototype.enter = function(t) {
        var n = t instanceof this.constructor ? t : e(t.currentTarget).data("bs." + this.type);
        return n || (n = new this.constructor(t.currentTarget, this.getDelegateOptions()), e(t.currentTarget).data("bs." + this.type, n)), t instanceof e.Event && (n.inState["focusin" == t.type ? "focus" : "hover"] = !0), n.tip().hasClass("in") || "in" == n.hoverState ? void(n.hoverState = "in") : (clearTimeout(n.timeout), n.hoverState = "in", n.options.delay && n.options.delay.show ? void(n.timeout = setTimeout(function() {
            "in" == n.hoverState && n.show()
        }, n.options.delay.show)) : n.show())
    }, n.prototype.isInStateTrue = function() {
        for (var e in this.inState)
            if (this.inState[e]) return !0;
        return !1
    }, n.prototype.leave = function(t) {
        var n = t instanceof this.constructor ? t : e(t.currentTarget).data("bs." + this.type);
        if (n || (n = new this.constructor(t.currentTarget, this.getDelegateOptions()), e(t.currentTarget).data("bs." + this.type, n)), t instanceof e.Event && (n.inState["focusout" == t.type ? "focus" : "hover"] = !1), !n.isInStateTrue()) return clearTimeout(n.timeout), n.hoverState = "out", n.options.delay && n.options.delay.hide ? void(n.timeout = setTimeout(function() {
            "out" == n.hoverState && n.hide()
        }, n.options.delay.hide)) : n.hide()
    }, n.prototype.show = function() {
        var t = e.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(t);
            var i = e.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
            if (t.isDefaultPrevented() || !i) return;
            var r = this,
                o = this.tip(),
                a = this.getUID(this.type);
            this.setContent(), o.attr("id", a), this.$element.attr("aria-describedby", a),
                this.options.animation && o.addClass("fade");
            var s = "function" == typeof this.options.placement ? this.options.placement.call(this, o[0], this.$element[0]) : this.options.placement,
                l = /\s?auto?\s?/i,
                u = l.test(s);
            u && (s = s.replace(l, "") || "top"), o.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(s).data("bs." + this.type, this), this.options.container ? o.appendTo(this.options.container) : o.insertAfter(this.$element), this.$element.trigger("inserted.bs." + this.type);
            var c = this.getPosition(),
                d = o[0].offsetWidth,
                h = o[0].offsetHeight;
            if (u) {
                var f = s,
                    p = this.getPosition(this.$viewport);
                s = "bottom" == s && c.bottom + h > p.bottom ? "top" : "top" == s && c.top - h < p.top ? "bottom" : "right" == s && c.right + d > p.width ? "left" : "left" == s && c.left - d < p.left ? "right" : s, o.removeClass(f).addClass(s)
            }
            var g = this.getCalculatedOffset(s, c, d, h);
            this.applyPlacement(g, s);
            var m = function() {
                var e = r.hoverState;
                r.$element.trigger("shown.bs." + r.type), r.hoverState = null, "out" == e && r.leave(r)
            };
            e.support.transition && this.$tip.hasClass("fade") ? o.one("bsTransitionEnd", m).emulateTransitionEnd(n.TRANSITION_DURATION) : m()
        }
    }, n.prototype.applyPlacement = function(t, n) {
        var i = this.tip(),
            r = i[0].offsetWidth,
            o = i[0].offsetHeight,
            a = parseInt(i.css("margin-top"), 10),
            s = parseInt(i.css("margin-left"), 10);
        isNaN(a) && (a = 0), isNaN(s) && (s = 0), t.top += a, t.left += s, e.offset.setOffset(i[0], e.extend({
            using: function(e) {
                i.css({
                    top: Math.round(e.top),
                    left: Math.round(e.left)
                })
            }
        }, t), 0), i.addClass("in");
        var l = i[0].offsetWidth,
            u = i[0].offsetHeight;
        "top" == n && u != o && (t.top = t.top + o - u);
        var c = this.getViewportAdjustedDelta(n, t, l, u);
        c.left ? t.left += c.left : t.top += c.top;
        var d = /top|bottom/.test(n),
            h = d ? 2 * c.left - r + l : 2 * c.top - o + u,
            f = d ? "offsetWidth" : "offsetHeight";
        i.offset(t), this.replaceArrow(h, i[0][f], d)
    }, n.prototype.replaceArrow = function(e, t, n) {
        this.arrow().css(n ? "left" : "top", 50 * (1 - e / t) + "%").css(n ? "top" : "left", "")
    }, n.prototype.setContent = function() {
        var e = this.tip(),
            t = this.getTitle();
        e.find(".tooltip-inner")[this.options.html ? "html" : "text"](t), e.removeClass("fade in top bottom left right")
    }, n.prototype.hide = function(t) {
        function i() {
            "in" != r.hoverState && o.detach(), r.$element && r.$element.removeAttr("aria-describedby").trigger("hidden.bs." + r.type), t && t()
        }
        var r = this,
            o = e(this.$tip),
            a = e.Event("hide.bs." + this.type);
        if (this.$element.trigger(a), !a.isDefaultPrevented()) return o.removeClass("in"), e.support.transition && o.hasClass("fade") ? o.one("bsTransitionEnd", i).emulateTransitionEnd(n.TRANSITION_DURATION) : i(), this.hoverState = null, this
    }, n.prototype.fixTitle = function() {
        var e = this.$element;
        (e.attr("title") || "string" != typeof e.attr("data-original-title")) && e.attr("data-original-title", e.attr("title") || "").attr("title", "")
    }, n.prototype.hasContent = function() {
        return this.getTitle()
    }, n.prototype.getPosition = function(t) {
        t = t || this.$element;
        var n = t[0],
            i = "BODY" == n.tagName,
            r = n.getBoundingClientRect();
        null == r.width && (r = e.extend({}, r, {
            width: r.right - r.left,
            height: r.bottom - r.top
        }));
        var o = window.SVGElement && n instanceof window.SVGElement,
            a = i ? {
                top: 0,
                left: 0
            } : o ? null : t.offset(),
            s = {
                scroll: i ? document.documentElement.scrollTop || document.body.scrollTop : t.scrollTop()
            },
            l = i ? {
                width: e(window).width(),
                height: e(window).height()
            } : null;
        return e.extend({}, r, s, l, a)
    }, n.prototype.getCalculatedOffset = function(e, t, n, i) {
        return "bottom" == e ? {
            top: t.top + t.height,
            left: t.left + t.width / 2 - n / 2
        } : "top" == e ? {
            top: t.top - i,
            left: t.left + t.width / 2 - n / 2
        } : "left" == e ? {
            top: t.top + t.height / 2 - i / 2,
            left: t.left - n
        } : {
            top: t.top + t.height / 2 - i / 2,
            left: t.left + t.width
        }
    }, n.prototype.getViewportAdjustedDelta = function(e, t, n, i) {
        var r = {
            top: 0,
            left: 0
        };
        if (!this.$viewport) return r;
        var o = this.options.viewport && this.options.viewport.padding || 0,
            a = this.getPosition(this.$viewport);
        if (/right|left/.test(e)) {
            var s = t.top - o - a.scroll,
                l = t.top + o - a.scroll + i;
            s < a.top ? r.top = a.top - s : l > a.top + a.height && (r.top = a.top + a.height - l)
        } else {
            var u = t.left - o,
                c = t.left + o + n;
            u < a.left ? r.left = a.left - u : c > a.right && (r.left = a.left + a.width - c)
        }
        return r
    }, n.prototype.getTitle = function() {
        var e, t = this.$element,
            n = this.options;
        return e = t.attr("data-original-title") || ("function" == typeof n.title ? n.title.call(t[0]) : n.title)
    }, n.prototype.getUID = function(e) {
        do e += ~~(1e6 * Math.random()); while (document.getElementById(e));
        return e
    }, n.prototype.tip = function() {
        if (!this.$tip && (this.$tip = e(this.options.template), 1 != this.$tip.length)) throw new Error(this.type + " `template` option must consist of exactly 1 top-level element!");
        return this.$tip
    }, n.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
    }, n.prototype.enable = function() {
        this.enabled = !0
    }, n.prototype.disable = function() {
        this.enabled = !1
    }, n.prototype.toggleEnabled = function() {
        this.enabled = !this.enabled
    }, n.prototype.toggle = function(t) {
        var n = this;
        t && (n = e(t.currentTarget).data("bs." + this.type), n || (n = new this.constructor(t.currentTarget, this.getDelegateOptions()), e(t.currentTarget).data("bs." + this.type, n))), t ? (n.inState.click = !n.inState.click, n.isInStateTrue() ? n.enter(n) : n.leave(n)) : n.tip().hasClass("in") ? n.leave(n) : n.enter(n)
    }, n.prototype.destroy = function() {
        var e = this;
        clearTimeout(this.timeout), this.hide(function() {
            e.$element.off("." + e.type).removeData("bs." + e.type), e.$tip && e.$tip.detach(), e.$tip = null, e.$arrow = null, e.$viewport = null, e.$element = null
        })
    };
    var i = e.fn.tooltip;
    e.fn.tooltip = t, e.fn.tooltip.Constructor = n, e.fn.tooltip.noConflict = function() {
        return e.fn.tooltip = i, this
    }
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        return this.each(function() {
            var i = e(this),
                r = i.data("bs.popover"),
                o = "object" == typeof t && t;
            !r && /destroy|hide/.test(t) || (r || i.data("bs.popover", r = new n(this, o)), "string" == typeof t && r[t]())
        })
    }
    var n = function(e, t) {
        this.init("popover", e, t)
    };
    if (!e.fn.tooltip) throw new Error("Popover requires tooltip.js");
    n.VERSION = "3.3.7", n.DEFAULTS = e.extend({}, e.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), n.prototype = e.extend({}, e.fn.tooltip.Constructor.prototype), n.prototype.constructor = n, n.prototype.getDefaults = function() {
        return n.DEFAULTS
    }, n.prototype.setContent = function() {
        var e = this.tip(),
            t = this.getTitle(),
            n = this.getContent();
        e.find(".popover-title")[this.options.html ? "html" : "text"](t), e.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof n ? "html" : "append" : "text"](n), e.removeClass("fade top bottom left right in"), e.find(".popover-title").html() || e.find(".popover-title").hide()
    }, n.prototype.hasContent = function() {
        return this.getTitle() || this.getContent()
    }, n.prototype.getContent = function() {
        var e = this.$element,
            t = this.options;
        return e.attr("data-content") || ("function" == typeof t.content ? t.content.call(e[0]) : t.content)
    }, n.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".arrow")
    };
    var i = e.fn.popover;
    e.fn.popover = t, e.fn.popover.Constructor = n, e.fn.popover.noConflict = function() {
        return e.fn.popover = i, this
    }
}(jQuery), + function(e) {
    "use strict";

    function t(n, i) {
        this.$body = e(document.body), this.$scrollElement = e(e(n).is(document.body) ? window : n), this.options = e.extend({}, t.DEFAULTS, i), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", e.proxy(this.process, this)), this.refresh(), this.process()
    }

    function n(n) {
        return this.each(function() {
            var i = e(this),
                r = i.data("bs.scrollspy"),
                o = "object" == typeof n && n;
            r || i.data("bs.scrollspy", r = new t(this, o)), "string" == typeof n && r[n]()
        })
    }
    t.VERSION = "3.3.7", t.DEFAULTS = {
        offset: 10
    }, t.prototype.getScrollHeight = function() {
        return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
    }, t.prototype.refresh = function() {
        var t = this,
            n = "offset",
            i = 0;
        this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), e.isWindow(this.$scrollElement[0]) || (n = "position", i = this.$scrollElement.scrollTop()), this.$body.find(this.selector).map(function() {
            var t = e(this),
                r = t.data("target") || t.attr("href"),
                o = /^#./.test(r) && e(r);
            return o && o.length && o.is(":visible") && [
                [o[n]().top + i, r]
            ] || null
        }).sort(function(e, t) {
            return e[0] - t[0]
        }).each(function() {
            t.offsets.push(this[0]), t.targets.push(this[1])
        })
    }, t.prototype.process = function() {
        var e, t = this.$scrollElement.scrollTop() + this.options.offset,
            n = this.getScrollHeight(),
            i = this.options.offset + n - this.$scrollElement.height(),
            r = this.offsets,
            o = this.targets,
            a = this.activeTarget;
        if (this.scrollHeight != n && this.refresh(), t >= i) return a != (e = o[o.length - 1]) && this.activate(e);
        if (a && t < r[0]) return this.activeTarget = null, this.clear();
        for (e = r.length; e--;) a != o[e] && t >= r[e] && (void 0 === r[e + 1] || t < r[e + 1]) && this.activate(o[e])
    }, t.prototype.activate = function(t) {
        this.activeTarget = t, this.clear();
        var n = this.selector + '[data-target="' + t + '"],' + this.selector + '[href="' + t + '"]',
            i = e(n).parents("li").addClass("active");
        i.parent(".dropdown-menu").length && (i = i.closest("li.dropdown").addClass("active")), i.trigger("activate.bs.scrollspy")
    }, t.prototype.clear = function() {
        e(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
    };
    var i = e.fn.scrollspy;
    e.fn.scrollspy = n, e.fn.scrollspy.Constructor = t, e.fn.scrollspy.noConflict = function() {
        return e.fn.scrollspy = i, this
    }, e(window).on("load.bs.scrollspy.data-api", function() {
        e('[data-spy="scroll"]').each(function() {
            var t = e(this);
            n.call(t, t.data())
        })
    })
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        return this.each(function() {
            var i = e(this),
                r = i.data("bs.tab");
            r || i.data("bs.tab", r = new n(this)), "string" == typeof t && r[t]()
        })
    }
    var n = function(t) {
        this.element = e(t)
    };
    n.VERSION = "3.3.7", n.TRANSITION_DURATION = 150, n.prototype.show = function() {
        var t = this.element,
            n = t.closest("ul:not(.dropdown-menu)"),
            i = t.data("target");
        if (i || (i = t.attr("href"), i = i && i.replace(/.*(?=#[^\s]*$)/, "")), !t.parent("li").hasClass("active")) {
            var r = n.find(".active:last a"),
                o = e.Event("hide.bs.tab", {
                    relatedTarget: t[0]
                }),
                a = e.Event("show.bs.tab", {
                    relatedTarget: r[0]
                });
            if (r.trigger(o), t.trigger(a), !a.isDefaultPrevented() && !o.isDefaultPrevented()) {
                var s = e(i);
                this.activate(t.closest("li"), n), this.activate(s, s.parent(), function() {
                    r.trigger({
                        type: "hidden.bs.tab",
                        relatedTarget: t[0]
                    }), t.trigger({
                        type: "shown.bs.tab",
                        relatedTarget: r[0]
                    })
                })
            }
        }
    }, n.prototype.activate = function(t, i, r) {
        function o() {
            a.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), t.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), s ? (t[0].offsetWidth, t.addClass("in")) : t.removeClass("fade"), t.parent(".dropdown-menu").length && t.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), r && r()
        }
        var a = i.find("> .active"),
            s = r && e.support.transition && (a.length && a.hasClass("fade") || !!i.find("> .fade").length);
        a.length && s ? a.one("bsTransitionEnd", o).emulateTransitionEnd(n.TRANSITION_DURATION) : o(), a.removeClass("in")
    };
    var i = e.fn.tab;
    e.fn.tab = t, e.fn.tab.Constructor = n, e.fn.tab.noConflict = function() {
        return e.fn.tab = i, this
    };
    var r = function(n) {
        n.preventDefault(), t.call(e(this), "show")
    };
    e(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', r).on("click.bs.tab.data-api", '[data-toggle="pill"]', r)
}(jQuery), + function(e) {
    "use strict";

    function t(t) {
        return this.each(function() {
            var i = e(this),
                r = i.data("bs.affix"),
                o = "object" == typeof t && t;
            r || i.data("bs.affix", r = new n(this, o)), "string" == typeof t && r[t]()
        })
    }
    var n = function(t, i) {
        this.options = e.extend({}, n.DEFAULTS, i), this.$target = e(this.options.target).on("scroll.bs.affix.data-api", e.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", e.proxy(this.checkPositionWithEventLoop, this)), this.$element = e(t), this.affixed = null, this.unpin = null, this.pinnedOffset = null, this.checkPosition()
    };
    n.VERSION = "3.3.7", n.RESET = "affix affix-top affix-bottom", n.DEFAULTS = {
        offset: 0,
        target: window
    }, n.prototype.getState = function(e, t, n, i) {
        var r = this.$target.scrollTop(),
            o = this.$element.offset(),
            a = this.$target.height();
        if (null != n && "top" == this.affixed) return r < n && "top";
        if ("bottom" == this.affixed) return null != n ? !(r + this.unpin <= o.top) && "bottom" : !(r + a <= e - i) && "bottom";
        var s = null == this.affixed,
            l = s ? r : o.top,
            u = s ? a : t;
        return null != n && r <= n ? "top" : null != i && l + u >= e - i && "bottom"
    }, n.prototype.getPinnedOffset = function() {
        if (this.pinnedOffset) return this.pinnedOffset;
        this.$element.removeClass(n.RESET).addClass("affix");
        var e = this.$target.scrollTop(),
            t = this.$element.offset();
        return this.pinnedOffset = t.top - e
    }, n.prototype.checkPositionWithEventLoop = function() {
        setTimeout(e.proxy(this.checkPosition, this), 1)
    }, n.prototype.checkPosition = function() {
        if (this.$element.is(":visible")) {
            var t = this.$element.height(),
                i = this.options.offset,
                r = i.top,
                o = i.bottom,
                a = Math.max(e(document).height(), e(document.body).height());
            "object" != typeof i && (o = r = i), "function" == typeof r && (r = i.top(this.$element)), "function" == typeof o && (o = i.bottom(this.$element));
            var s = this.getState(a, t, r, o);
            if (this.affixed != s) {
                null != this.unpin && this.$element.css("top", "");
                var l = "affix" + (s ? "-" + s : ""),
                    u = e.Event(l + ".bs.affix");
                if (this.$element.trigger(u), u.isDefaultPrevented()) return;
                this.affixed = s, this.unpin = "bottom" == s ? this.getPinnedOffset() : null, this.$element.removeClass(n.RESET).addClass(l).trigger(l.replace("affix", "affixed") + ".bs.affix")
            }
            "bottom" == s && this.$element.offset({
                top: a - t - o
            })
        }
    };
    var i = e.fn.affix;
    e.fn.affix = t, e.fn.affix.Constructor = n, e.fn.affix.noConflict = function() {
        return e.fn.affix = i, this
    }, e(window).on("load", function() {
        e('[data-spy="affix"]').each(function() {
            var n = e(this),
                i = n.data();
            i.offset = i.offset || {}, null != i.offsetBottom && (i.offset.bottom = i.offsetBottom), null != i.offsetTop && (i.offset.top = i.offsetTop), t.call(n, i)
        })
    })
}(jQuery), jQuery(document).ready(function() {
    function e(e, t, n) {
        n = n || saving;
        var i = /[^\s]+/g,
            r = [],
            o = 0,
            a = 0;
        if (e && (r = e.match(i), a = e.split(/\\r\\n|\\r|\\n/).length), r)
            for (var s = 0; s < r.length; s++) o += r[s].charCodeAt(0) >= 19968 ? r[s].length : 1;
        return '<div class="small-font">lines: ' + a + "&nbsp;&nbsp;&nbsp;words: " + o + (t ? '&nbsp;&nbsp;&nbsp;<span class="markdown-save">' + n + "</span>" : "") + "</div>"
    }

    function t() {
        o >= 0 && (0 == o && jQuery("span.markdown-save").html(saved), o--, setTimeout(t, 1e3))
    }
    if (jQuery("#languageChooser").popover({
            container: "body",
            placement: "bottom",
            template: '<div class="popover language-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
            html: !0,
            content: function() {
                return jQuery("#languageChooserContent").html()
            }
        }), jQuery("#loginOrRegister").popover({
            container: "body",
            placement: "bottom",
            template: '<div class="popover login-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
            html: !0,
            content: function() {
                return jQuery("#loginOrRegisterContent").html()
            }
        }), jQuery("#accountNotifications").popover({
            container: "body",
            placement: "bottom",
            template: '<div class="popover popover-user-notifications" role="tooltip"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
            html: !0,
            content: function() {
                return jQuery("#accountNotificationsContent").html()
            }
        }), jQuery(".truncate").each(function() {
            jQuery(this).attr("title", jQuery(this).text()).attr("data-toggle", "tooltip").attr("data-placement", "bottom")
        }), jQuery('[data-toggle="popover"]').popover({
            html: !0
        }), jQuery('[data-toggle="tooltip"]').tooltip(), jQuery("body").on("click", function(e) {
            jQuery('[data-toggle="popover"]').each(function() {
                jQuery(this).is(e.target) || 0 !== jQuery(this).has(e.target).length || 0 !== jQuery(".popover").has(e.target).length || jQuery(this).popover("hide")
            })
        }), jQuery(".list-group-tab-nav a").click(function() {
            if (jQuery(this).hasClass("disabled")) return !1;
            jQuery(".list-group-tab-nav a").removeClass("active"), jQuery(this).addClass("active");
            var e = this.href.split("#")[1];
            e && (window.location.hash = "#" + e)
        }), jQuery(".panel-minimise").click(function(e) {
            e.preventDefault(), jQuery(this).hasClass("minimised") ? (jQuery(this).parents(".panel").find(".panel-body, .list-group").slideDown(), jQuery(this).removeClass("minimised")) : (jQuery(this).parents(".panel").find(".panel-body, .list-group").slideUp(), jQuery(this).addClass("minimised"))
        }), jQuery(".container").width() <= 720 && (jQuery(".panel-sidebar").find(".panel-body, .list-group").hide(), jQuery(".panel-sidebar").find(".panel-minimise").addClass("minimised")), "" != jQuery(location).attr("hash").substr(1)) {
        var n = jQuery(location).attr("hash");
        try{
          jQuery(n).removeClass("fade").addClass("active");
        }
        catch(e){}
        jQuery(".tab-pane").removeClass("active"), jQuery(".list-group-tab-nav a").removeClass("active"), jQuery('a[href="' + n + '"]').addClass("active"), setTimeout(function() {
            window.scrollTo(0, 0)
        }, 1)
    }
    jQuery.prototype.bootstrapSwitch && jQuery(".toggle-switch-success").bootstrapSwitch({
        onColor: "success"
    }), jQuery(".panel-collapsable .panel-heading").click(function(e) {
        var t = jQuery(this);
        t.parents(".panel").hasClass("panel-collapsed") ? (t.parents(".panel").removeClass("panel-collapsed").find(".panel-body").slideDown(), t.find(".collapse-icon i").removeClass("fa-plus").addClass("fa-minus")) : (t.parents(".panel").addClass("panel-collapsed").find(".panel-body").slideUp(), t.find(".collapse-icon i").removeClass("fa-minus").addClass("fa-plus"))
    }), "#frmLogin".length > 0 && jQuery("#frmLogin input:text:visible:first").focus(), "#twofaactivation".length > 0 && jQuery("#twofaactivation input:text:visible:first,#twofaactivation input:password:visible:first").focus(), jQuery("#inputSubaccountActivate").click(function() {
        null != jQuery("#inputSubaccountActivate:checked").val() ? jQuery("#subacct-container").removeClass("hidden") : jQuery("#subacct-container").addClass("hidden")
    }), jQuery(".setBulkAction").click(function(e) {
        e.preventDefault();
        var t = jQuery(this).attr("id").replace("Link", "");
        if (0 != jQuery("#" + t).length) {
            var n = jQuery("#domainForm").attr("action");
            jQuery("#domainForm").attr("action", n + "#" + t)
        }
        jQuery("#bulkaction").val(t), jQuery("#domainForm").submit()
    }), jQuery(".stopEventBubble").click(function(e) {
        e.stopPropagation()
    }), jQuery(".tabControlLink").on("click", function(e) {
        e.preventDefault();
        var t = jQuery(this).attr("href");
        jQuery("a[href='/" + t + "']").click()
    }), jQuery(".ticket-reply .rating span.star").click(function(e) {
        window.location = "viewticket.php?tid=" + jQuery(this).parent(".rating").attr("ticketid") + "&c=" + jQuery(this).parent(".rating").attr("ticketkey") + "&rating=rate" + jQuery(this).parent(".rating").attr("ticketreplyid") + "_" + jQuery(this).attr("rate")
    }), jQuery("a.autoLinked").click(function(e) {
        e.preventDefault();
        var t = window.open();
        t.opener = null, t.location = e.target.href
    }), jQuery("#inputAllowSso").on("switchChange.bootstrapSwitch", function(e, t) {
        t ? (jQuery("#ssoStatusTextEnabled").removeClass("hidden").show(), jQuery("#ssoStatusTextDisabled").hide()) : (jQuery("#ssoStatusTextDisabled").removeClass("hidden").show(), jQuery("#ssoStatusTextEnabled").hide()), jQuery.post("clientarea.php", jQuery("#frmSingleSignOn").serialize())
    }), jQuery(".btn-service-sso").on("click", function(e) {
        e.preventDefault();
        var t = jQuery(this),
            n = t.parents("form");
        0 == n.length && (n = t.find("form")), n.hasClass("disabled") || (t.find(".loading").removeClass("hidden").show().end().attr("disabled", "disabled"), jQuery.post(window.location.href, n.serialize(), function(e) {
            t.find(".loading").hide().end().removeAttr("disabled"), n.find(".login-feedback").html(""), e.error && n.find(".login-feedback").html(e.error), void 0 !== e.redirect && "window|" === e.redirect.substr(0, 7) && window.open(e.redirect.substr(7), "_blank")
        }, "json"))
    }), jQuery(".btn-sidebar-form-submit").on("click", function(e) {
        e.preventDefault(), jQuery(this).find(".loading").removeClass("hidden").show().end().attr("disabled", "disabled");
        var t = jQuery(this).parents("form");
        0 == t.length && (t = jQuery(this).find("form")), 0 !== t.length && t.hasClass("disabled") === !1 ? t.submit() : jQuery(this).find(".loading").hide().end().removeAttr("disabled")
    }), jQuery(".email-verification .btn.close").click(function(e) {
        e.preventDefault(), jQuery.post("clientarea.php", "action=dismiss-email-banner&token=" + csrfToken), jQuery(".email-verification").hide()
    }), jQuery(".back-to-top").click(function(e) {
        e.preventDefault(), jQuery("body,html").animate({
            scrollTop: 0
        }, 500)
    }), jQuery(".choose-language").click(function(e) {
        e.preventDefault()
    });
    var i = 0,
        r = "clientMDE",
        o = 0;
    jQuery(".markdown-editor").each(function(n) {
        i++;
        var a = jQuery(this).data("auto-save-name"),
            s = jQuery(this).attr("id") + "-footer";
        "undefined" == typeof a && (a = "client_area"), window[r + i.toString()] = jQuery(this).markdown({
            footer: '<div id="' + s + '" class="markdown-editor-status"></div>',
            autofocus: !1,
            savable: !1,
            resize: "vertical",
            iconlibrary: "fa",
            language: locale,
            onShow: function(t) {
                var n = "",
                    i = !1;
                "undefined" != typeof Storage && (n = localStorage.getItem(a), i = !0, n && "undefined" != typeof n && t.setContent(n)), jQuery("#" + s).html(e(n, i, saved))
            },
            onChange: function(n) {
                var i = n.getContent(),
                    r = !1;
                "undefined" != typeof Storage && (o = 3, r = !0, localStorage.setItem(a, i), t()), jQuery("#" + s).html(e(i, r))
            },
            onPreview: function(e) {
                var t, n = e.getContent();
                return jQuery.ajax({
                    url: "clientarea.php",
                    async: !1,
                    data: {
                        token: csrfToken,
                        action: "parseMarkdown",
                        content: n
                    },
                    dataType: "json",
                    success: function(e) {
                        t = e
                    }
                }), t.body ? t.body : ""
            },
            additionalButtons: [
                [{
                    name: "groupCustom",
                    data: [{
                        name: "cmdHelp",
                        title: "Help",
                        hotkey: "Ctrl+F1",
                        btnClass: "btn open-modal",
                        icon: {
                            glyph: "glyphicons glyphicons-question-sign",
                            fa: "fa fa-question-circle",
                            "fa-3": "icon-question-sign"
                        },
                        callback: function(e) {
                            e.$editor.removeClass("md-fullscreen-mode")
                        }
                    }]
                }]
            ],
            hiddenButtons: ["cmdImage"]
        }), jQuery('button[data-handler="bootstrap-markdown-cmdHelp"]').attr("data-modal-title", markdownGuide).attr("href", "submitticket.php?action=markdown"), jQuery(this).closest("form").bind({
            submit: function() {
                "undefined" != typeof Storage && localStorage.removeItem(a)
            }
        })
    }), jQuery("#btnResendVerificationEmail").click(function() {
        jQuery.post("clientarea.php", {
            token: csrfToken,
            action: "resendVerificationEmail"
        }).done(function(e) {
            jQuery("#btnResendVerificationEmail").html("Email Sent").prop("disabled", !0)
        })
    });
    var a = jQuery("input[name=2fasetup]").parent("form");
    a.submit(function(e) {
        e.preventDefault(), openModal(a.attr("action"), a.serialize(), "Loading...")
    }), jQuery("#frmPayment").find("#btnSubmit").on("click", function() {
        jQuery(this).find("span").toggleClass("hidden")
    }), jQuery(".btn-resend-approver-email").click(function() {
        jQuery.post(jQuery(this).data("url"), {
            addonId: jQuery(this).data("addonid"),
            serviceId: jQuery(this).data("serviceid")
        }, function(e) {
            1 == e.success ? jQuery(".alert-table-ssl-manage").addClass("alert-success").text("Approver Email Resent").removeClass("hidden") : jQuery(".alert-table-ssl-manage").addClass("alert-danger").text("Error: " + e.message).removeClass("hidden")
        })
    })
});
var lastTicketMsg;
jQuery(document).ready(function() {
        jQuery(document).on("click", ".open-modal", function(e) {
            e.preventDefault();
            var t = jQuery(this).attr("href"),
                n = jQuery(this).data("modal-size"),
                i = jQuery(this).data("modal-class"),
                r = jQuery(this).data("modal-title"),
                o = jQuery(this).data("btn-submit-id"),
                a = jQuery(this).data("btn-submit-label"),
                s = jQuery(this).data("btn-close-hide"),
                l = jQuery(this).attr("disabled");
            l || openModal(t, "", r, n, i, a, o, s)
        }), jQuery("#modalAjax").on("hidden.bs.modal", function(e) {
            if (jQuery(this).hasClass("modal-feature-highlights")) {
                var t = jQuery("#cbFeatureHighlightsDismissForVersion").is(":checked");
                jQuery.ajax("whatsnew.php?dismiss=1&until_next_update=" + (t ? "1" : "0"), {
                    dataType: "json"
                })
            }
            jQuery("#modalAjax").find(".modal-body").empty(), jQuery("#modalAjax").children("div.modal-dialog").removeClass("modal-lg"), jQuery("#modalAjax").removeClass().addClass("modal whmcs-modal fade"), jQuery("#modalAjax .modal-title").html("Title"), jQuery("#modalAjax .modal-submit").html("Submit").removeClass().addClass("btn btn-primary modal-submit").removeAttr("id").removeAttr("disabled"), jQuery("#modalAjax .loader").show()
        })
    }),
    function(e) {
        "function" == typeof define && define.amd ? define(["jquery"], e) : e("object" == typeof exports ? require("jquery") : jQuery)
    }(function(e) {
        "use strict";
        var t = function(t, n) {
            var i = ["autofocus", "savable", "hideable", "width", "height", "resize", "iconlibrary", "language", "footer", "fullscreen", "hiddenButtons", "disabledButtons"];
            e.each(i, function(i, r) {
                "undefined" != typeof e(t).data(r) && (n = "object" == typeof n ? n : {}, n[r] = e(t).data(r))
            }), this.$ns = "bootstrap-markdown", this.$element = e(t), this.$editable = {
                el: null,
                type: null,
                attrKeys: [],
                attrValues: [],
                content: null
            }, this.$options = e.extend(!0, {}, e.fn.markdown.defaults, n, this.$element.data("options")), this.$oldContent = null, this.$isPreview = !1, this.$isFullscreen = !1, this.$editor = null, this.$textarea = null, this.$handler = [], this.$callback = [], this.$nextTab = [], this.showEditor()
        };
        t.prototype = {
            constructor: t,
            __alterButtons: function(t, n) {
                var i = this.$handler,
                    r = "all" == t,
                    o = this;
                e.each(i, function(e, i) {
                    var a = !0;
                    a = !r && i.indexOf(t) < 0, a === !1 && n(o.$editor.find('button[data-handler="' + i + '"]'))
                })
            },
            __buildButtons: function(t, n) {
                var i, r = this.$ns,
                    o = this.$handler,
                    a = this.$callback;
                for (i = 0; i < t.length; i++) {
                    var s, l = t[i];
                    for (s = 0; s < l.length; s++) {
                        var u, c = l[s].data,
                            d = e("<div/>", {
                                class: "btn-group"
                            });
                        for (u = 0; u < c.length; u++) {
                            var h, f, p = c[u],
                                g = r + "-" + p.name,
                                m = this.__getIcon(p.icon),
                                v = p.btnText ? p.btnText : "",
                                y = p.btnClass ? p.btnClass : "btn",
                                b = p.tabIndex ? p.tabIndex : "-1",
                                x = "undefined" != typeof p.hotkey ? p.hotkey : "",
                                w = "undefined" != typeof jQuery.hotkeys && "" !== x ? " (" + x + ")" : "";
                            h = e("<button></button>"), h.text(" " + this.__localize(v)).addClass("btn-default btn-sm").addClass(y), y.match(/btn\-(primary|success|info|warning|danger|link)/) && h.removeClass("btn-default"), h.attr({
                                type: "button",
                                title: this.__localize(p.title) + w,
                                tabindex: b,
                                "data-provider": r,
                                "data-handler": g,
                                "data-hotkey": x
                            }), p.toggle === !0 && h.attr("data-toggle", "button"), f = e("<span/>"), f.addClass(m), f.prependTo(h), d.append(h), o.push(g), a.push(p.callback)
                        }
                        n.append(d)
                    }
                }
                return n
            },
            __setListener: function() {
                var t = "undefined" != typeof this.$textarea.attr("rows"),
                    n = this.$textarea.val().split("\n").length > 5 ? this.$textarea.val().split("\n").length : "5",
                    i = t ? this.$textarea.attr("rows") : n;
                this.$textarea.attr("rows", i), this.$options.resize && this.$textarea.css("resize", this.$options.resize), this.$textarea.on({
                    focus: e.proxy(this.focus, this),
                    keyup: e.proxy(this.keyup, this),
                    change: e.proxy(this.change, this),
                    select: e.proxy(this.select, this)
                }), this.eventSupported("keydown") && this.$textarea.on("keydown", e.proxy(this.keydown, this)), this.eventSupported("keypress") && this.$textarea.on("keypress", e.proxy(this.keypress, this)), this.$textarea.data("markdown", this)
            },
            __handle: function(t) {
                var n = e(t.currentTarget),
                    i = this.$handler,
                    r = this.$callback,
                    o = n.attr("data-handler"),
                    a = i.indexOf(o),
                    s = r[a];
                e(t.currentTarget).focus(), s(this), this.change(this), o.indexOf("cmdSave") < 0 && this.$textarea.focus(), t.preventDefault()
            },
            __localize: function(t) {
                var n = e.fn.markdown.messages,
                    i = this.$options.language;
                return "undefined" != typeof n && "undefined" != typeof n[i] && "undefined" != typeof n[i][t] ? n[i][t] : t
            },
            __getIcon: function(e) {
                return "object" == typeof e ? e[this.$options.iconlibrary] : e
            },
            setFullscreen: function(t) {
                var n = this.$editor,
                    i = this.$textarea;
                t === !0 ? (n.addClass("md-fullscreen-mode"), e("body").addClass("md-nooverflow"), this.$options.onFullscreen(this)) : (n.removeClass("md-fullscreen-mode"), e("body").removeClass("md-nooverflow"), 1 == this.$isPreview && this.hidePreview().showPreview()), this.$isFullscreen = t, i.focus()
            },
            showEditor: function() {
                var t, n = this,
                    i = this.$ns,
                    r = this.$element,
                    o = (r.css("height"), r.css("width"), this.$editable),
                    a = this.$handler,
                    s = this.$callback,
                    l = this.$options,
                    u = e("<div/>", {
                        class: "md-editor",
                        click: function() {
                            n.focus()
                        }
                    });
                if (null === this.$editor) {
                    var c = e("<div/>", {
                            class: "md-header btn-toolbar"
                        }),
                        d = [];
                    if (l.buttons.length > 0 && (d = d.concat(l.buttons[0])), l.additionalButtons.length > 0 && e.each(l.additionalButtons[0], function(t, n) {
                            var i = e.grep(d, function(e, t) {
                                return e.name === n.name
                            });
                            i.length > 0 ? i[0].data = i[0].data.concat(n.data) : d.push(l.additionalButtons[0][t])
                        }), l.reorderButtonGroups.length > 0 && (d = d.filter(function(e) {
                            return l.reorderButtonGroups.indexOf(e.name) > -1
                        }).sort(function(e, t) {
                            return l.reorderButtonGroups.indexOf(e.name) < l.reorderButtonGroups.indexOf(t.name) ? -1 : l.reorderButtonGroups.indexOf(e.name) > l.reorderButtonGroups.indexOf(t.name) ? 1 : 0
                        })), d.length > 0 && (c = this.__buildButtons([d], c)), l.fullscreen.enable && c.append('<div class="md-controls"><a class="md-control md-control-fullscreen" href="#"><span class="' + this.__getIcon(l.fullscreen.icons.fullscreenOn) + '"></span></a></div>').on("click", ".md-control-fullscreen", function(e) {
                            e.preventDefault(), n.setFullscreen(!0)
                        }), u.append(c), r.is("textarea")) r.before(u), t = r, t.addClass("md-input"), u.append(t);
                    else {
                        var h = "function" == typeof toMarkdown ? toMarkdown(r.html()) : r.html(),
                            f = e.trim(h);
                        t = e("<textarea/>", {
                            class: "md-input",
                            val: f
                        }), u.append(t), o.el = r, o.type = r.prop("tagName").toLowerCase(), o.content = r.html(), e(r[0].attributes).each(function() {
                            o.attrKeys.push(this.nodeName), o.attrValues.push(this.nodeValue)
                        }), r.replaceWith(u)
                    }
                    var p = e("<div/>", {
                            class: "md-footer"
                        }),
                        g = !1,
                        m = "";
                    if (l.savable) {
                        g = !0;
                        var v = "cmdSave";
                        a.push(v), s.push(l.onSave), p.append('<button class="btn btn-success" data-provider="' + i + '" data-handler="' + v + '"><i class="icon icon-white icon-ok"></i> ' + this.__localize("Save") + "</button>")
                    }
                    if (m = "function" == typeof l.footer ? l.footer(this) : l.footer, "" !== e.trim(m) && (g = !0, p.append(m)), g && u.append(p), l.width && "inherit" !== l.width && (jQuery.isNumeric(l.width) ? (u.css("display", "table"), t.css("width", l.width + "px")) : u.addClass(l.width)), l.height && "inherit" !== l.height)
                        if (jQuery.isNumeric(l.height)) {
                            var y = l.height;
                            c && (y = Math.max(0, y - c.outerHeight())), p && (y = Math.max(0, y - p.outerHeight())), t.css("height", y + "px")
                        } else u.addClass(l.height);
                    this.$editor = u, this.$textarea = t, this.$editable = o, this.$oldContent = this.getContent(), this.__setListener(), this.$editor.attr("id", (new Date).getTime()), this.$editor.on("click", '[data-provider="bootstrap-markdown"]', e.proxy(this.__handle, this)), (this.$element.is(":disabled") || this.$element.is("[readonly]")) && (this.$editor.addClass("md-editor-disabled"), this.disableButtons("all")), this.eventSupported("keydown") && "object" == typeof jQuery.hotkeys && c.find('[data-provider="bootstrap-markdown"]').each(function() {
                        var n = e(this),
                            i = n.attr("data-hotkey");
                        "" !== i.toLowerCase() && t.bind("keydown", i, function() {
                            return n.trigger("click"), !1
                        })
                    }), "preview" === l.initialstate ? this.showPreview() : "fullscreen" === l.initialstate && l.fullscreen.enable && this.setFullscreen(!0)
                } else this.$editor.show();
                return l.autofocus && (this.$textarea.focus(), this.$editor.addClass("active")), l.fullscreen.enable && l.fullscreen !== !1 && (this.$editor.append('<div class="md-fullscreen-controls"><a href="#" class="exit-fullscreen" title="Exit fullscreen"><span class="' + this.__getIcon(l.fullscreen.icons.fullscreenOff) + '"></span></a></div>'), this.$editor.on("click", ".exit-fullscreen", function(e) {
                    e.preventDefault(), n.setFullscreen(!1)
                })), this.hideButtons(l.hiddenButtons), this.disableButtons(l.disabledButtons), l.onShow(this), this
            },
            parseContent: function(e) {
                var t, e = e || this.$textarea.val();
                return t = this.$options.parser ? this.$options.parser(e) : "object" == typeof markdown ? markdown.toHTML(e) : "function" == typeof marked ? marked(e) : e
            },
            showPreview: function() {
                var t, n, i = this.$options,
                    r = this.$textarea,
                    o = r.next(),
                    a = e("<div/>", {
                        class: "md-preview",
                        "data-provider": "markdown-preview"
                    });
                return 1 == this.$isPreview ? this : (this.$isPreview = !0, this.disableButtons("all").enableButtons("cmdPreview"), n = i.onPreview(this), t = "string" == typeof n ? n : this.parseContent(), a.html(t), o && "md-footer" == o.attr("class") ? a.insertBefore(o) : r.parent().append(a), a.css({
                    width: r.outerWidth() + "px",
                    height: r.outerHeight() + "px"
                }), this.$options.resize && a.css("resize", this.$options.resize), r.hide(), a.data("markdown", this), (this.$element.is(":disabled") || this.$element.is("[readonly]")) && (this.$editor.addClass("md-editor-disabled"), this.disableButtons("all")), this)
            },
            hidePreview: function() {
                this.$isPreview = !1;
                var e = this.$editor.find('div[data-provider="markdown-preview"]');
                return e.remove(), this.enableButtons("all"), this.disableButtons(this.$options.disabledButtons), this.$textarea.show(), this.__setListener(), this
            },
            isDirty: function() {
                return this.$oldContent != this.getContent()
            },
            getContent: function() {
                return this.$textarea.val()
            },
            setContent: function(e) {
                return this.$textarea.val(e), this
            },
            findSelection: function(e) {
                var t, n = this.getContent();
                if (t = n.indexOf(e), t >= 0 && e.length > 0) {
                    var i, r = this.getSelection();
                    return this.setSelection(t, t + e.length), i = this.getSelection(), this.setSelection(r.start, r.end),
                        i
                }
                return null
            },
            getSelection: function() {
                var e = this.$textarea[0];
                return ("selectionStart" in e && function() {
                    var t = e.selectionEnd - e.selectionStart;
                    return {
                        start: e.selectionStart,
                        end: e.selectionEnd,
                        length: t,
                        text: e.value.substr(e.selectionStart, t)
                    }
                } || function() {
                    return null
                })()
            },
            setSelection: function(e, t) {
                var n = this.$textarea[0];
                return ("selectionStart" in n && function() {
                    n.selectionStart = e, n.selectionEnd = t
                } || function() {
                    return null
                })()
            },
            replaceSelection: function(e) {
                var t = this.$textarea[0];
                return ("selectionStart" in t && function() {
                    return t.value = t.value.substr(0, t.selectionStart) + e + t.value.substr(t.selectionEnd, t.value.length), t.selectionStart = t.value.length, this
                } || function() {
                    return t.value += e, jQuery(t)
                })()
            },
            getNextTab: function() {
                if (0 === this.$nextTab.length) return null;
                var e, t = this.$nextTab.shift();
                return "function" == typeof t ? e = t() : "object" == typeof t && t.length > 0 && (e = t), e
            },
            setNextTab: function(e, t) {
                if ("string" == typeof e) {
                    var n = this;
                    this.$nextTab.push(function() {
                        return n.findSelection(e)
                    })
                } else if ("number" == typeof e && "number" == typeof t) {
                    var i = this.getSelection();
                    this.setSelection(e, t), this.$nextTab.push(this.getSelection()), this.setSelection(i.start, i.end)
                }
            },
            __parseButtonNameParam: function(e) {
                return "string" == typeof e ? e.split(" ") : e
            },
            enableButtons: function(t) {
                var n = this.__parseButtonNameParam(t),
                    i = this;
                return e.each(n, function(e, t) {
                    i.__alterButtons(n[e], function(e) {
                        e.removeAttr("disabled")
                    })
                }), this
            },
            disableButtons: function(t) {
                var n = this.__parseButtonNameParam(t),
                    i = this;
                return e.each(n, function(e, t) {
                    i.__alterButtons(n[e], function(e) {
                        e.attr("disabled", "disabled")
                    })
                }), this
            },
            hideButtons: function(t) {
                var n = this.__parseButtonNameParam(t),
                    i = this;
                return e.each(n, function(e, t) {
                    i.__alterButtons(n[e], function(e) {
                        e.addClass("hidden")
                    })
                }), this
            },
            showButtons: function(t) {
                var n = this.__parseButtonNameParam(t),
                    i = this;
                return e.each(n, function(e, t) {
                    i.__alterButtons(n[e], function(e) {
                        e.removeClass("hidden")
                    })
                }), this
            },
            eventSupported: function(e) {
                var t = e in this.$element;
                return t || (this.$element.setAttribute(e, "return;"), t = "function" == typeof this.$element[e]), t
            },
            keyup: function(e) {
                var t = !1;
                switch (e.keyCode) {
                    case 40:
                    case 38:
                    case 16:
                    case 17:
                    case 18:
                        break;
                    case 9:
                        var n;
                        if (n = this.getNextTab(), null !== n) {
                            var i = this;
                            setTimeout(function() {
                                i.setSelection(n.start, n.end)
                            }, 500), t = !0
                        } else {
                            var r = this.getSelection();
                            r.start == r.end && r.end == this.getContent().length ? t = !1 : (this.setSelection(this.getContent().length, this.getContent().length), t = !0)
                        }
                        break;
                    case 13:
                        t = !1;
                        break;
                    case 27:
                        this.$isFullscreen && this.setFullscreen(!1), t = !1;
                        break;
                    default:
                        t = !1
                }
                t && (e.stopPropagation(), e.preventDefault()), this.$options.onChange(this)
            },
            change: function(e) {
                return this.$options.onChange(this), this
            },
            select: function(e) {
                return this.$options.onSelect(this), this
            },
            focus: function(t) {
                var n = this.$options,
                    i = (n.hideable, this.$editor);
                return i.addClass("active"), e(document).find(".md-editor").each(function() {
                    if (e(this).attr("id") !== i.attr("id")) {
                        var t;
                        t = e(this).find("textarea").data("markdown"), null === t && (t = e(this).find('div[data-provider="markdown-preview"]').data("markdown")), t && t.blur()
                    }
                }), n.onFocus(this), this
            },
            blur: function(t) {
                var n = this.$options,
                    i = n.hideable,
                    r = this.$editor,
                    o = this.$editable;
                if (r.hasClass("active") || 0 === this.$element.parent().length) {
                    if (r.removeClass("active"), i)
                        if (null !== o.el) {
                            var a = e("<" + o.type + "/>"),
                                s = this.getContent(),
                                l = this.parseContent(s);
                            e(o.attrKeys).each(function(e, t) {
                                a.attr(o.attrKeys[e], o.attrValues[e])
                            }), a.html(l), r.replaceWith(a)
                        } else r.hide();
                    n.onBlur(this)
                }
                return this
            }
        };
        var n = e.fn.markdown;
        e.fn.markdown = function(n) {
            return this.each(function() {
                var i = e(this),
                    r = i.data("markdown"),
                    o = "object" == typeof n && n;
                r || i.data("markdown", r = new t(this, o))
            })
        }, e.fn.markdown.messages = {}, e.fn.markdown.defaults = {
            autofocus: !1,
            hideable: !1,
            savable: !1,
            width: "inherit",
            height: "inherit",
            resize: "none",
            iconlibrary: "glyph",
            language: "en",
            initialstate: "editor",
            parser: null,
            buttons: [
                [{
                    name: "groupFont",
                    data: [{
                        name: "cmdBold",
                        hotkey: "Ctrl+B",
                        title: "Bold",
                        icon: {
                            glyph: "glyphicon glyphicon-bold",
                            fa: "fa fa-bold",
                            "fa-3": "icon-bold"
                        },
                        callback: function(e) {
                            var t, n, i = e.getSelection(),
                                r = e.getContent();
                            t = 0 === i.length ? e.__localize("strong text") : i.text, "**" === r.substr(i.start - 2, 2) && "**" === r.substr(i.end, 2) ? (e.setSelection(i.start - 2, i.end + 2), e.replaceSelection(t), n = i.start - 2) : (e.replaceSelection("**" + t + "**"), n = i.start + 2), e.setSelection(n, n + t.length)
                        }
                    }, {
                        name: "cmdItalic",
                        title: "Italic",
                        hotkey: "Ctrl+I",
                        icon: {
                            glyph: "glyphicon glyphicon-italic",
                            fa: "fa fa-italic",
                            "fa-3": "icon-italic"
                        },
                        callback: function(e) {
                            var t, n, i = e.getSelection(),
                                r = e.getContent();
                            t = 0 === i.length ? e.__localize("emphasized text") : i.text, "_" === r.substr(i.start - 1, 1) && "_" === r.substr(i.end, 1) ? (e.setSelection(i.start - 1, i.end + 1), e.replaceSelection(t), n = i.start - 1) : (e.replaceSelection("_" + t + "_"), n = i.start + 1), e.setSelection(n, n + t.length)
                        }
                    }, {
                        name: "cmdHeading",
                        title: "Heading",
                        hotkey: "Ctrl+H",
                        icon: {
                            glyph: "glyphicon glyphicon-header",
                            fa: "fa fa-header",
                            "fa-3": "icon-font"
                        },
                        callback: function(e) {
                            var t, n, i, r, o = e.getSelection(),
                                a = e.getContent();
                            t = 0 === o.length ? e.__localize("heading text") : o.text + "\n", i = 4, "### " === a.substr(o.start - i, i) || (i = 3, "###" === a.substr(o.start - i, i)) ? (e.setSelection(o.start - i, o.end), e.replaceSelection(t), n = o.start - i) : o.start > 0 && (r = a.substr(o.start - 1, 1), !!r && "\n" != r) ? (e.replaceSelection("\n\n### " + t), n = o.start + 6) : (e.replaceSelection("### " + t), n = o.start + 4), e.setSelection(n, n + t.length)
                        }
                    }]
                }, {
                    name: "groupLink",
                    data: [{
                        name: "cmdUrl",
                        title: "URL/Link",
                        hotkey: "Ctrl+L",
                        icon: {
                            glyph: "glyphicon glyphicon-link",
                            fa: "fa fa-link",
                            "fa-3": "icon-link"
                        },
                        callback: function(t) {
                            var n, i, r, o = t.getSelection();
                            t.getContent();
                            n = 0 === o.length ? t.__localize("enter link description here") : o.text, r = prompt(t.__localize("Insert Hyperlink"), "http://");
                            var a = new RegExp("^((http|https)://|(mailto:)|(//))[a-z0-9]", "i");
                            if (null !== r && "" !== r && "http://" !== r && a.test(r)) {
                                var s = e("<div>" + r + "</div>").text();
                                t.replaceSelection("[" + n + "](" + s + ")"), i = o.start + 1, t.setSelection(i, i + n.length)
                            }
                        }
                    }, {
                        name: "cmdImage",
                        title: "Image",
                        hotkey: "Ctrl+G",
                        icon: {
                            glyph: "glyphicon glyphicon-picture",
                            fa: "fa fa-picture-o",
                            "fa-3": "icon-picture"
                        },
                        callback: function(t) {
                            var n, i, r, o = t.getSelection();
                            t.getContent();
                            n = 0 === o.length ? t.__localize("enter image description here") : o.text, r = prompt(t.__localize("Insert Image Hyperlink"), "http://");
                            var a = new RegExp("^((http|https)://|(//))[a-z0-9]", "i");
                            if (null !== r && "" !== r && "http://" !== r && a.test(r)) {
                                var s = e("<div>" + r + "</div>").text();
                                t.replaceSelection("![" + n + "](" + s + ' "' + t.__localize("enter image title here") + '")'), i = o.start + 2, t.setNextTab(t.__localize("enter image title here")), t.setSelection(i, i + n.length)
                            }
                        }
                    }]
                }, {
                    name: "groupMisc",
                    data: [{
                        name: "cmdList",
                        hotkey: "Ctrl+U",
                        title: "Unordered List",
                        icon: {
                            glyph: "glyphicon glyphicon-list",
                            fa: "fa fa-list",
                            "fa-3": "icon-list-ul"
                        },
                        callback: function(t) {
                            var n, i, r = t.getSelection();
                            t.getContent();
                            if (0 === r.length) n = t.__localize("list text here"), t.replaceSelection("- " + n), i = r.start + 2;
                            else if (r.text.indexOf("\n") < 0) n = r.text, t.replaceSelection("- " + n), i = r.start + 2;
                            else {
                                var o = [];
                                o = r.text.split("\n"), n = o[0], e.each(o, function(e, t) {
                                    o[e] = "- " + t
                                }), t.replaceSelection("\n\n" + o.join("\n")), i = r.start + 4
                            }
                            t.setSelection(i, i + n.length)
                        }
                    }, {
                        name: "cmdListO",
                        hotkey: "Ctrl+O",
                        title: "Ordered List",
                        icon: {
                            glyph: "glyphicon glyphicon-th-list",
                            fa: "fa fa-list-ol",
                            "fa-3": "icon-list-ol"
                        },
                        callback: function(t) {
                            var n, i, r = t.getSelection();
                            t.getContent();
                            if (0 === r.length) n = t.__localize("list text here"), t.replaceSelection("1. " + n), i = r.start + 3;
                            else if (r.text.indexOf("\n") < 0) n = r.text, t.replaceSelection("1. " + n), i = r.start + 3;
                            else {
                                var o = [];
                                o = r.text.split("\n"), n = o[0], e.each(o, function(e, t) {
                                    o[e] = "1. " + t
                                }), t.replaceSelection("\n\n" + o.join("\n")), i = r.start + 5
                            }
                            t.setSelection(i, i + n.length)
                        }
                    }, {
                        name: "cmdCode",
                        hotkey: "Ctrl+K",
                        title: "Code",
                        icon: {
                            glyph: "glyphicon glyphicon-asterisk",
                            fa: "fa fa-code",
                            "fa-3": "icon-code"
                        },
                        callback: function(e) {
                            var t, n, i = e.getSelection(),
                                r = e.getContent();
                            t = 0 === i.length ? e.__localize("code text here") : i.text, "```\n" === r.substr(i.start - 4, 4) && "\n```" === r.substr(i.end, 4) ? (e.setSelection(i.start - 4, i.end + 4), e.replaceSelection(t), n = i.start - 4) : "`" === r.substr(i.start - 1, 1) && "`" === r.substr(i.end, 1) ? (e.setSelection(i.start - 1, i.end + 1), e.replaceSelection(t), n = i.start - 1) : r.indexOf("\n") > -1 ? (e.replaceSelection("```\n" + t + "\n```"), n = i.start + 4) : (e.replaceSelection("`" + t + "`"), n = i.start + 1), e.setSelection(n, n + t.length)
                        }
                    }, {
                        name: "cmdQuote",
                        hotkey: "Ctrl+Q",
                        title: "Quote",
                        icon: {
                            glyph: "glyphicon glyphicon-comment",
                            fa: "fa fa-quote-left",
                            "fa-3": "icon-quote-left"
                        },
                        callback: function(t) {
                            var n, i, r = t.getSelection();
                            t.getContent();
                            if (0 === r.length) n = t.__localize("quote here"), t.replaceSelection("> " + n), i = r.start + 2;
                            else if (r.text.indexOf("\n") < 0) n = r.text, t.replaceSelection("> " + n), i = r.start + 2;
                            else {
                                var o = [];
                                o = r.text.split("\n"), n = o[0], e.each(o, function(e, t) {
                                    o[e] = "> " + t
                                }), t.replaceSelection("\n\n" + o.join("\n")), i = r.start + 4
                            }
                            t.setSelection(i, i + n.length)
                        }
                    }]
                }, {
                    name: "groupUtil",
                    data: [{
                        name: "cmdPreview",
                        toggle: !0,
                        hotkey: "Ctrl+P",
                        title: "Preview",
                        btnText: "Preview",
                        btnClass: "btn btn-primary btn-sm",
                        icon: {
                            glyph: "glyphicon glyphicon-search",
                            fa: "fa fa-search",
                            "fa-3": "icon-search"
                        },
                        callback: function(e) {
                            var t = e.$isPreview;
                            t === !1 ? e.showPreview() : e.hidePreview()
                        }
                    }]
                }]
            ],
            additionalButtons: [],
            reorderButtonGroups: [],
            hiddenButtons: [],
            disabledButtons: [],
            footer: "",
            fullscreen: {
                enable: !0,
                icons: {
                    fullscreenOn: {
                        fa: "fa fa-expand",
                        glyph: "glyphicon glyphicon-fullscreen",
                        "fa-3": "icon-resize-full"
                    },
                    fullscreenOff: {
                        fa: "fa fa-compress",
                        glyph: "glyphicon glyphicon-fullscreen",
                        "fa-3": "icon-resize-small"
                    }
                }
            },
            onShow: function(e) {},
            onPreview: function(e) {},
            onSave: function(e) {},
            onBlur: function(e) {},
            onFocus: function(e) {},
            onChange: function(e) {},
            onFullscreen: function(e) {},
            onSelect: function(e) {}
        }, e.fn.markdown.Constructor = t, e.fn.markdown.noConflict = function() {
            return e.fn.markdown = n, this
        };
        var i = function(e) {
                var t = e;
                return t.data("markdown") ? void t.data("markdown").showEditor() : void t.markdown()
            },
            r = function(t) {
                var n = e(document.activeElement);
                e(document).find(".md-editor").each(function() {
                    var t = e(this),
                        i = n.closest(".md-editor")[0] === this,
                        r = t.find("textarea").data("markdown") || t.find('div[data-provider="markdown-preview"]').data("markdown");
                    r && !i && r.blur()
                })
            };
        e(document).on("click.markdown.data-api", '[data-provide="markdown-editable"]', function(t) {
            i(e(this)), t.preventDefault()
        }).on("click focusin", function(e) {
            r(e)
        }).ready(function() {
            e('textarea[data-provide="markdown"]').each(function() {
                i(e(this))
            })
        })
    }),
    function(e) {
        e.fn.markdown.messages.nl = {
            Bold: "ØºØ§Ù…Ù‚",
            Italic: "Ù…Ø§Ø¦Ù„",
            Heading: "Ø¹Ù†ÙˆØ§Ù†",
            "URL/Link": "URL/Ø±Ø§Ø¨Ø·",
            Image: "ØµÙˆØ±Ø©",
            List: "Ù‚Ø§Ø¦Ù…Ø©",
            Preview: "Ø§Ø³ØªØ¹Ø±Ø§Ø¶",
            "strong text": "Ù†Øµ ØºØ§Ù…Ù‚",
            "emphasized text": "Ù†Øµ Ù‡Ø§Ù…",
            "heading text": "Ø§Ù„Ø¹Ù†ÙˆØ§Ù†",
            "enter link description here": "Ø§Ø¯Ø®Ù„ ÙˆØµÙ Ø§Ù„Ø±Ø§Ø¨Ø· Ù‡Ù†Ø§",
            "Insert Hyperlink": "Ø§Ø¯Ø®Ù„ Ø§Ù„Ø±Ø§Ø¨Ø· Ù‡Ù†Ø§",
            "enter image description here": "Ø§Ø¯Ø®Ù„ ÙˆØµÙ Ø§Ù„ØµÙˆØ±Ø© Ù‡Ù†Ø§",
            "Insert Image Hyperlink": "Ø§Ø¯Ø®Ù„ Ø±Ø§Ø¨Ø· Ø§Ù„ØµÙˆØ±Ø© Ù‡Ù†Ø§",
            "enter image title here": "Ø§Ø¯Ø®Ù„ Ø¹Ù†ÙˆØ§Ù† Ø§Ù„ØµÙˆØ±Ø© Ù‡Ù†Ø§",
            "list text here": "Ø§ÙƒØªØ¨ Ø§Ù„Ù†Øµ Ù‡Ù†Ø§"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.cs = {
            Bold: "TuÄnÄ›",
            Italic: "KurzÃ­va",
            Heading: "Nadpis",
            "URL/Link": "URL/Odkaz",
            Image: "ObrÃ¡zek",
            "Unordered List": "Seznam",
            "Ordered List": "SeÅ™azenÃ½ seznam",
            Code: "Ãšsek kÃ³du",
            Quote: "Citace",
            Preview: "NÃ¡hled",
            "strong text": "tuÄnÃ½ text",
            "emphasized text": "zdÅ¯raznÄ›nÃ½ text",
            "heading text": "text nadpisu",
            "enter link description here": "sem vloÅ¾ popis odkazu",
            "Insert Hyperlink": "VloÅ¾it Hyperlink",
            "enter image description here": "sem vloÅ¾ popis obrÃ¡zku",
            "Insert Image Hyperlink": "VloÅ¾ adresu obrÃ¡zku",
            "enter image title here": "sem vloÅ¾ popis obrÃ¡zku",
            "list text here": "poloÅ¾ka seznamu"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.nb = {
            Bold: "Fed",
            Italic: "Kursiv",
            Heading: "Overskrift",
            "URL/Link": "URL/Link",
            Image: "Billede",
            List: "Liste",
            Preview: "ForhÃ¥ndsvisning",
            "strong text": "stÃ¦rk tekst",
            "emphasized text": "fremhÃ¦vet tekst",
            "heading text": "overskrift tekst",
            "enter link description here": "Skriv link beskrivelse her",
            "Insert Hyperlink": "IndsÃ¦t link",
            "enter image description here": "IndsÃ¦t billede beskrivelse her",
            "Insert Image Hyperlink": "IndsÃ¦t billede link",
            "enter image title here": "IndsÃ¦t billede titel",
            "list text here": "IndsÃ¦t liste tekst her",
            "quote here": "IndsÃ¦t citat her",
            "code text here": "IndsÃ¦t kode her"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.de = {
            Bold: "Fett",
            Italic: "Kursiv",
            Heading: "Ãœberschrift",
            "URL/Link": "Link hinzufÃ¼gen",
            Image: "Bild hinzufÃ¼gen",
            "Unordered List": "Unnummerierte Liste",
            "Ordered List": "Nummerierte Liste",
            Code: "Quelltext",
            Quote: "Zitat",
            Preview: "Vorschau",
            "strong text": "Sehr betonter Text",
            "emphasized text": "Betonter Text",
            "heading text": "Ãœberschrift Text",
            "enter link description here": "Linkbeschreibung",
            "Insert Hyperlink": "URL",
            "enter image description here": "Bildbeschreibung",
            "Insert Image Hyperlink": "Bild-URL",
            "enter image title here": "Titel des Bildes",
            "list text here": "AufzÃ¤hlungs-Text"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.es = {
            Bold: "Negrita",
            Italic: "ItÃ¡lica",
            Heading: "TÃ­tulo",
            "URL/Link": "Inserte un link",
            Image: "Inserte una imagen",
            List: "Lista de items",
            Preview: "Previsualizar",
            "strong text": "texto importante",
            "emphasized text": "texto con Ã©nfasis",
            "heading text": "texto titular",
            "enter link description here": "descripciÃ³n del link",
            "Insert Hyperlink": "Inserte un hipervÃ­nculo",
            "enter image description here": "descripciÃ³n de la imagen",
            "Insert Image Hyperlink": "Inserte una imagen con un hipervÃ­nculo",
            "enter image title here": "Inserte una imagen con tÃ­tulo",
            "list text here": "lista con texto"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.fa = {
            Bold: "ØªÙˆÙ¾Ø±",
            Italic: "Ù…ÙˆØ±Ø¨",
            Heading: "Ø¹Ù†ÙˆØ§Ù†",
            "URL/Link": "Ù¾ÛŒÙˆÙ†Ø¯",
            Image: "ØªØµÙˆÛŒØ±",
            List: "ÙÙ‡Ø±Ø³Øª",
            Preview: "Ù¾ÛŒØ´ Ù†Ù…Ø§ÛŒØ´",
            "strong text": "Ù…ØªÙ† Ø¶Ø®ÛŒÙ…",
            "emphasized text": "Ù†ÙˆØ´ØªÙ‡ ØªØ§Ú©ÛŒØ¯ÛŒ",
            "heading text": "Ø¹Ù†ÙˆØ§Ù†",
            "enter link description here": "ØªÙˆØ¶ÛŒØ­Ø§Øª Ù¾ÛŒÙˆÙ†Ø¯ Ø±Ø§ Ø¨Ù†ÙˆÛŒØ³ÛŒØ¯.",
            "Insert Hyperlink": "Ù¾ÛŒÙˆÙ†Ø¯ Ø±Ø§ Ø¯Ø±Ø¬ Ù†Ù…Ø§ÛŒÛŒØ¯:",
            "enter image description here": "ØªÙˆØ¶ÛŒØ­ÛŒ Ø¨Ø±Ø§ÛŒ ØªØµÙˆÛŒ Ø¨Ù†ÙˆÛŒØ³ÛŒØ¯.",
            "Insert Image Hyperlink": "Ø¢Ø¯Ø±Ø³ ØªØµÙˆÛŒØ± Ø±Ø§ Ø¨Ù†ÙˆÛŒØ³ÛŒØ¯.",
            "enter image title here": "Ø¹Ù†ÙˆØ§Ù† ØªØµÙˆÛŒØ± Ø±Ø§ Ø§ÛŒÙ†Ø¬Ø§ Ø¨Ù†ÙˆÛŒØ³ÛŒØ¯",
            "list text here": "Ù…Ø­Ù„ Ù…ØªÙ† ÙÙ‡Ø±Ø³Øª"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.fr = {
            Bold: "Gras",
            Italic: "Italique",
            Heading: "Titre",
            "URL/Link": "InsÃ©rer un lien HTTP",
            Image: "InsÃ©rer une image",
            List: "Liste Ã  puces",
            Preview: "PrÃ©visualiser",
            "strong text": "texte important",
            "emphasized text": "texte en italique",
            "heading text": "texte d'entÃªte",
            "enter link description here": "entrez la description du lien ici",
            "Insert Hyperlink": "InsÃ©rez le lien hypertexte",
            "enter image description here": "entrez la description de l'image ici",
            "Insert Image Hyperlink": "InsÃ©rez le lien hypertexte de l'image",
            "enter image title here": "entrez le titre de l'image ici",
            "list text here": "texte Ã  puce ici",
            Save: "Sauvegarder",
            "Ordered List": "Liste ordonnÃ©e",
            "Unordered List": "Liste dÃ©sordonnÃ©e",
            Quote: "Citation",
            "quote here": "Votre citation",
            Code: "Code",
            "code text here": "Ã©crire du code ici"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.ja = {
            Bold: "å¤ªå­—",
            Italic: "æ–œä½“",
            Heading: "è¦‹å‡ºã—",
            "URL/Link": "ãƒªãƒ³ã‚¯",
            Image: "ç”»åƒ",
            "Unordered List": "ãƒªã‚¹ãƒˆ",
            "Ordered List": "æ•°å­—ãƒªã‚¹ãƒˆ",
            Code: "ã‚³ãƒ¼ãƒ‰",
            Quote: "å¼•ç”¨",
            Preview: "ãƒ—ãƒ¬ãƒ“ãƒ¥ãƒ¼",
            "strong text": "å¤ªå­—",
            "emphasized text": "å¼·èª¿",
            "heading text": "è¦‹å‡ºã—",
            "enter link description here": "ãƒªãƒ³ã‚¯èª¬æ˜Ž",
            "Insert Hyperlink": "ãƒªãƒ³ã‚¯æŒ¿å…¥",
            "enter image description here": "ç”»åƒèª¬æ˜Ž",
            "Insert Image Hyperlink": "ç”»åƒæŒ¿å…¥",
            "enter image title here": "ç”»åƒã‚¿ã‚¤ãƒˆãƒ«",
            "list text here": "ãƒªã‚¹ãƒˆæŒ¿å…¥",
            "code text here": "ã‚³ãƒ¼ãƒ‰",
            "quote here": "å¼•ç”¨æŒ¿å…¥"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.kr = {
            Bold: "ì§„í•˜ê²Œ",
            Italic: "ì´íƒ¤ë¦­ì²´",
            Heading: "ë¨¸ë¦¬ê¸€",
            "URL/Link": "ë§í¬ì£¼ì†Œ",
            Image: "ì´ë¯¸ì§€",
            List: "ë¦¬ìŠ¤íŠ¸",
            Preview: "ë¯¸ë¦¬ë³´ê¸°",
            "strong text": "ê°•í•œ ê°•ì¡° í…ìŠ¤íŠ¸",
            "emphasized text": "ê°•ì¡° í…ìŠ¤íŠ¸",
            "heading text": "ë¨¸ë¦¬ê¸€ í…ìŠ¤íŠ¸",
            "enter link description here": "ì—¬ê¸°ì— ë§í¬ì˜ ì„¤ëª…ì„ ì ìœ¼ì„¸ìš”",
            "Insert Hyperlink": "í•˜ì´í¼ë§í¬ ì‚½ìž…",
            "enter image description here": "ì—¬ê¸°ì„¸ ì´ë¯¸ì§€ ì„¤ëª…ì„ ì ìœ¼ì„¸ìš”",
            "Insert Image Hyperlink": "ì´ë¯¸ì§€ ë§í¬ ì‚½ìž…",
            "enter image title here": "ì—¬ê¸°ì— ì´ë¯¸ì§€ ì œëª©ì„ ì ìœ¼ì„¸ìš”",
            "list text here": "ë¦¬ìŠ¤íŠ¸ í…ìŠ¤íŠ¸"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.nb = {
            Bold: "Fet",
            Italic: "Kursiv",
            Heading: "Overskrift",
            "URL/Link": "URL/Lenke",
            Image: "Bilde",
            List: "Liste",
            Preview: "ForhÃ¥ndsvisning",
            "strong text": "sterk tekst",
            "emphasized text": "streket tekst",
            "heading text": "overskriften tekst",
            "enter link description here": "Skriv linken beskrivelse her",
            "Insert Hyperlink": "Sett inn lenke",
            "enter image description here": "Angi bildebeskrivelse her",
            "Insert Image Hyperlink": "Sett inn lenke for bilde",
            "enter image title here": "Angi bildetittel her",
            "list text here": "liste tekst her"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.nl = {
            Bold: "Vet",
            Italic: "Cursief",
            Heading: "Titel",
            "URL/Link": "URL/Link",
            Image: "Afbeelding",
            List: "Lijst",
            Preview: "Voorbeeld",
            "strong text": "vet gedrukte tekst",
            "emphasized text": "schuin gedrukte tekst",
            "heading text": "Titel",
            "enter link description here": "Voer een link beschrijving in",
            "Insert Hyperlink": "Voer een http link in",
            "enter image description here": "Voer een afbeelding beschrijving in",
            "Insert Image Hyperlink": "Voer een afbeelding link in",
            "enter image title here": "Voer de afbeelding titel in",
            "list text here": "lijst item"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.pl = {
            Bold: "Pogrubienie",
            Italic: "Kursywa",
            Heading: "NagÅ‚Ã³wek",
            "URL/Link": "Wstaw link",
            Image: "Wstaw obrazek",
            "Unordered List": "Lista punktowana",
            "Ordered List": "Lista numerowana",
            Code: "Kod ÅºrÃ³dÅ‚owy",
            Quote: "Cytat",
            Preview: "PodglÄ…d",
            "strong text": "pogrubiony tekst",
            "emphasized text": "pochylony tekst",
            "heading text": "nagÅ‚Ã³wek",
            "enter link description here": "opis linka",
            "Insert Hyperlink": "Wstaw link",
            "enter image description here": "opis obrazka",
            "Insert Image Hyperlink": "Wstaw obrazek",
            "enter image title here": "tytuÅ‚ obrazka",
            "list text here": "lista"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.sl = {
            Bold: "Odebeljeno",
            Italic: "PoÅ¡evno",
            Heading: "Naslov",
            "URL/Link": "Povezava",
            Image: "Slika",
            "Unordered List": "Neurejen seznam",
            "Ordered List": "Urejen seznam",
            Code: "Koda",
            Quote: "Citat",
            Preview: "Predogled",
            "strong text": "odebeljeno besedilo",
            "emphasized text": "poÅ¡evno besedilo",
            "heading text": "naslov",
            "enter link description here": "opis povezave",
            "Insert Hyperlink": "Vstavi povezavo",
            "enter image description here": "opis slike",
            "Insert Image Hyperlink": "Vstavi povezavo do slike",
            "enter image title here": "naslov slike",
            "list text here": "seznam"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.sv = {
            Bold: "Fet",
            Italic: "Kursiv",
            Heading: "Rubrik",
            "URL/Link": "URL/LÃ¤nk",
            Image: "Bild",
            List: "Lista",
            Preview: "FÃ¶rhandsgranska",
            "strong text": "fet text",
            "emphasized text": "Ã¶verstruken text",
            "heading text": "Rubrik",
            "enter link description here": "Ange lÃ¤nk beskrivning hÃ¤r",
            "Insert Hyperlink": "SÃ¤tt in lÃ¤nk",
            "enter image description here": "Ange bild beskrivning hÃ¤r",
            "Insert Image Hyperlink": "SÃ¤tt in lÃ¤nk fÃ¶r bild",
            "enter image title here": "Ange bild rubrik hÃ¤r",
            "list text here": "list text"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.tr = {
            Bold: "KalÄ±n",
            Italic: "Ä°talik",
            Heading: "BaÅŸlÄ±k",
            "URL/Link": "Link ekle",
            Image: "Resim ekle",
            List: "Liste OluÅŸturun",
            Preview: "Ã–nizleme",
            "strong text": "kalÄ±n yazÄ±",
            "emphasized text": "italik yazÄ±",
            "heading text": "BaÅŸlÄ±k YazÄ±sÄ±",
            "enter link description here": "Link aÃ§Ä±klamasÄ±nÄ± buraya girin",
            "Insert Hyperlink": "Ä°nternet adresi girin",
            "enter image description here": "resim aÃ§Ä±klamasÄ±nÄ± buraya ekleyin",
            "Insert Image Hyperlink": "Resim linkini ekleyin",
            "enter image title here": "resim baÅŸlÄ±ÄŸÄ±nÄ± buraya ekleyin",
            "list text here": "liste yazÄ±sÄ±",
            Save: "Kaydet",
            "Ordered List": "NumaralÄ± Liste",
            "Unordered List": "Madde imli liste",
            Quote: "AlÄ±ntÄ±",
            "quote here": "alÄ±ntÄ±yÄ± buraya ekleyin",
            Code: "Kod",
            "code text here": "kodu buraya ekleyin"
        }
    }(jQuery),
    function(e) {
        e.fn.markdown.messages.zh = {
            Bold: "ç²—ä½“",
            Italic: "æ–œä½“",
            Heading: "æ ‡é¢˜",
            "URL/Link": "é“¾æŽ¥",
            Image: "å›¾ç‰‡",
            List: "åˆ—è¡¨",
            "Unordered List": "æ— åºåˆ—è¡¨",
            "Ordered List": "æœ‰åºåˆ—è¡¨",
            Code: "ä»£ç ",
            Quote: "å¼•ç”¨",
            Preview: "é¢„è§ˆ",
            "strong text": "ç²—ä½“",
            "emphasized text": "å¼ºè°ƒ",
            "heading text": "æ ‡é¢˜",
            "enter link description here": "è¾“å…¥é“¾æŽ¥è¯´æ˜Ž",
            "Insert Hyperlink": "URLåœ°å€",
            "enter image description here": "è¾“å…¥å›¾ç‰‡è¯´æ˜Ž",
            "Insert Image Hyperlink": "å›¾ç‰‡URLåœ°å€",
            "enter image title here": "åœ¨è¿™é‡Œè¾“å…¥å›¾ç‰‡æ ‡é¢˜",
            "list text here": "è¿™é‡Œæ˜¯åˆ—è¡¨æ–‡æœ¬",
            "code text here": "è¿™é‡Œè¾“å…¥ä»£ç ",
            "quote here": "è¿™é‡Œè¾“å…¥å¼•ç”¨æ–‡æœ¬"
        }
    }(jQuery),
    function(e) {
        "use strict";
        "function" == typeof define && define.amd ? define(["jquery"], function(t) {
            return e(t, window, document)
        }) : "object" == typeof exports ? module.exports = function(t, n) {
            return t || (t = window), n || (n = "undefined" != typeof window ? require("jquery") : require("jquery")(t)), e(n, t, t.document)
        } : e(jQuery, window, document)
    }(function(e, t, n, i) {
        "use strict";

        function r(t) {
            var n, i, o = "a aa ai ao as b fn i m o s ",
                a = {};
            e.each(t, function(e, s) {
                n = e.match(/^([^A-Z]+?)([A-Z])/), n && o.indexOf(n[1] + " ") !== -1 && (i = e.replace(n[0], n[2].toLowerCase()), a[i] = e, "o" === n[1] && r(t[e]))
            }), t._hungarianMap = a
        }

        function o(t, n, a) {
            t._hungarianMap || r(t);
            var s;
            e.each(n, function(r, l) {
                s = t._hungarianMap[r], s === i || !a && n[s] !== i || ("o" === s.charAt(0) ? (n[s] || (n[s] = {}), e.extend(!0, n[s], n[r]), o(t[s], n[s], a)) : n[s] = n[r])
            })
        }

        function a(e) {
            var t = Xe.defaults.oLanguage,
                n = e.sZeroRecords;
            !e.sEmptyTable && n && "No data available in table" === t.sEmptyTable && Ne(e, e, "sZeroRecords", "sEmptyTable"), !e.sLoadingRecords && n && "Loading..." === t.sLoadingRecords && Ne(e, e, "sZeroRecords", "sLoadingRecords"), e.sInfoThousands && (e.sThousands = e.sInfoThousands);
            var i = e.sDecimal;
            i && Me(i)
        }

        function s(e) {
            pt(e, "ordering", "bSort"), pt(e, "orderMulti", "bSortMulti"), pt(e, "orderClasses", "bSortClasses"), pt(e, "orderCellsTop", "bSortCellsTop"), pt(e, "order", "aaSorting"), pt(e, "orderFixed", "aaSortingFixed"), pt(e, "paging", "bPaginate"), pt(e, "pagingType", "sPaginationType"), pt(e, "pageLength", "iDisplayLength"), pt(e, "searching", "bFilter"), "boolean" == typeof e.sScrollX && (e.sScrollX = e.sScrollX ? "100%" : ""), "boolean" == typeof e.scrollX && (e.scrollX = e.scrollX ? "100%" : "");
            var t = e.aoSearchCols;
            if (t)
                for (var n = 0, i = t.length; n < i; n++) t[n] && o(Xe.models.oSearch, t[n])
        }

        function l(t) {
            pt(t, "orderable", "bSortable"), pt(t, "orderData", "aDataSort"), pt(t, "orderSequence", "asSorting"), pt(t, "orderDataType", "sortDataType");
            var n = t.aDataSort;
            n && !e.isArray(n) && (t.aDataSort = [n])
        }

        function u(t) {
            if (!Xe.__browser) {
                var n = {};
                Xe.__browser = n;
                var i = e("<div/>").css({
                        position: "fixed",
                        top: 0,
                        left: 0,
                        height: 1,
                        width: 1,
                        overflow: "hidden"
                    }).append(e("<div/>").css({
                        position: "absolute",
                        top: 1,
                        left: 1,
                        width: 100,
                        overflow: "scroll"
                    }).append(e("<div/>").css({
                        width: "100%",
                        height: 10
                    }))).appendTo("body"),
                    r = i.children(),
                    o = r.children();
                n.barWidth = r[0].offsetWidth - r[0].clientWidth, n.bScrollOversize = 100 === o[0].offsetWidth && 100 !== r[0].clientWidth, n.bScrollbarLeft = 1 !== Math.round(o.offset().left), n.bBounding = !!i[0].getBoundingClientRect().width, i.remove()
            }
            e.extend(t.oBrowser, Xe.__browser), t.oScroll.iBarWidth = Xe.__browser.barWidth
        }

        function c(e, t, n, r, o, a) {
            var s, l = r,
                u = !1;
            for (n !== i && (s = n, u = !0); l !== o;) e.hasOwnProperty(l) && (s = u ? t(s, e[l], l, e) : e[l], u = !0, l += a);
            return s
        }

        function d(t, i) {
            var r = Xe.defaults.column,
                o = t.aoColumns.length,
                a = e.extend({}, Xe.models.oColumn, r, {
                    nTh: i ? i : n.createElement("th"),
                    sTitle: r.sTitle ? r.sTitle : i ? i.innerHTML : "",
                    aDataSort: r.aDataSort ? r.aDataSort : [o],
                    mData: r.mData ? r.mData : o,
                    idx: o
                });
            t.aoColumns.push(a);
            var s = t.aoPreSearchCols;
            s[o] = e.extend({}, Xe.models.oSearch, s[o]), h(t, o, e(i).data())
        }

        function h(t, n, r) {
            var a = t.aoColumns[n],
                s = t.oClasses,
                u = e(a.nTh);
            if (!a.sWidthOrig) {
                a.sWidthOrig = u.attr("width") || null;
                var c = (u.attr("style") || "").match(/width:\s*(\d+[pxem%]+)/);
                c && (a.sWidthOrig = c[1])
            }
            r !== i && null !== r && (l(r), o(Xe.defaults.column, r), r.mDataProp === i || r.mData || (r.mData = r.mDataProp), r.sType && (a._sManualType = r.sType), r.className && !r.sClass && (r.sClass = r.className), e.extend(a, r), Ne(a, r, "sWidth", "sWidthOrig"), r.iDataSort !== i && (a.aDataSort = [r.iDataSort]), Ne(a, r, "aDataSort"));
            var d = a.mData,
                h = _(d),
                f = a.mRender ? _(a.mRender) : null,
                p = function(e) {
                    return "string" == typeof e && e.indexOf("@") !== -1
                };
            a._bAttrSrc = e.isPlainObject(d) && (p(d.sort) || p(d.type) || p(d.filter)), a._setter = null, a.fnGetData = function(e, t, n) {
                var r = h(e, t, i, n);
                return f && t ? f(r, t, e, n) : r
            }, a.fnSetData = function(e, t, n) {
                return j(d)(e, t, n)
            }, "number" != typeof d && (t._rowReadObject = !0), t.oFeatures.bSort || (a.bSortable = !1, u.addClass(s.sSortableNone));
            var g = e.inArray("asc", a.asSorting) !== -1,
                m = e.inArray("desc", a.asSorting) !== -1;
            a.bSortable && (g || m) ? g && !m ? (a.sSortingClass = s.sSortableAsc, a.sSortingClassJUI = s.sSortJUIAscAllowed) : !g && m ? (a.sSortingClass = s.sSortableDesc, a.sSortingClassJUI = s.sSortJUIDescAllowed) : (a.sSortingClass = s.sSortable, a.sSortingClassJUI = s.sSortJUI) : (a.sSortingClass = s.sSortableNone, a.sSortingClassJUI = "")
        }

        function f(e) {
            if (e.oFeatures.bAutoWidth !== !1) {
                var t = e.aoColumns;
                ve(e);
                for (var n = 0, i = t.length; n < i; n++) t[n].nTh.style.width = t[n].sWidth
            }
            var r = e.oScroll;
            "" === r.sY && "" === r.sX || ge(e), Fe(e, null, "column-sizing", [e])
        }

        function p(e, t) {
            var n = v(e, "bVisible");
            return "number" == typeof n[t] ? n[t] : null
        }

        function g(t, n) {
            var i = v(t, "bVisible"),
                r = e.inArray(n, i);
            return r !== -1 ? r : null
        }

        function m(t) {
            var n = 0;
            return e.each(t.aoColumns, function(t, i) {
                i.bVisible && "none" !== e(i.nTh).css("display") && n++
            }), n
        }

        function v(t, n) {
            var i = [];
            return e.map(t.aoColumns, function(e, t) {
                e[n] && i.push(t)
            }), i
        }

        function y(e) {
            var t, n, r, o, a, s, l, u, c, d = e.aoColumns,
                h = e.aoData,
                f = Xe.ext.type.detect;
            for (t = 0, n = d.length; t < n; t++)
                if (l = d[t], c = [], !l.sType && l._sManualType) l.sType = l._sManualType;
                else if (!l.sType) {
                for (r = 0, o = f.length; r < o; r++) {
                    for (a = 0, s = h.length; a < s && (c[a] === i && (c[a] = T(e, a, t, "type")), u = f[r](c[a], e), u || r === f.length - 1) && "html" !== u; a++);
                    if (u) {
                        l.sType = u;
                        break
                    }
                }
                l.sType || (l.sType = "string")
            }
        }

        function b(t, n, r, o) {
            var a, s, l, u, c, h, f, p = t.aoColumns;
            if (n)
                for (a = n.length - 1; a >= 0; a--) {
                    f = n[a];
                    var g = f.targets !== i ? f.targets : f.aTargets;
                    for (e.isArray(g) || (g = [g]), l = 0, u = g.length; l < u; l++)
                        if ("number" == typeof g[l] && g[l] >= 0) {
                            for (; p.length <= g[l];) d(t);
                            o(g[l], f)
                        } else if ("number" == typeof g[l] && g[l] < 0) o(p.length + g[l], f);
                    else if ("string" == typeof g[l])
                        for (c = 0, h = p.length; c < h; c++)("_all" == g[l] || e(p[c].nTh).hasClass(g[l])) && o(c, f)
                }
            if (r)
                for (a = 0, s = r.length; a < s; a++) o(a, r[a])
        }

        function x(t, n, r, o) {
            var a = t.aoData.length,
                s = e.extend(!0, {}, Xe.models.oRow, {
                    src: r ? "dom" : "data",
                    idx: a
                });
            s._aData = n, t.aoData.push(s);
            for (var l = t.aoColumns, u = 0, c = l.length; u < c; u++) l[u].sType = null;
            t.aiDisplayMaster.push(a);
            var d = t.rowIdFn(n);
            return d !== i && (t.aIds[d] = s), !r && t.oFeatures.bDeferRender || E(t, a, r, o), a
        }

        function w(t, n) {
            var i;
            return n instanceof e || (n = e(n)), n.map(function(e, n) {
                return i = N(t, n), x(t, i.data, n, i.cells)
            })
        }

        function C(e, t) {
            return t._DT_RowIndex !== i ? t._DT_RowIndex : null
        }

        function S(t, n, i) {
            return e.inArray(i, t.aoData[n].anCells)
        }

        function T(e, t, n, r) {
            var o = e.iDraw,
                a = e.aoColumns[n],
                s = e.aoData[t]._aData,
                l = a.sDefaultContent,
                u = a.fnGetData(s, r, {
                    settings: e,
                    row: t,
                    col: n
                });
            if (u === i) return e.iDrawError != o && null === l && (Le(e, 0, "Requested unknown parameter " + ("function" == typeof a.mData ? "{function}" : "'" + a.mData + "'") + " for row " + t + ", column " + n, 4), e.iDrawError = o), l;
            if (u !== s && null !== u || null === l || r === i) {
                if ("function" == typeof u) return u.call(s)
            } else u = l;
            return null === u && "display" == r ? "" : u
        }

        function k(e, t, n, i) {
            var r = e.aoColumns[n],
                o = e.aoData[t]._aData;
            r.fnSetData(o, i, {
                settings: e,
                row: t,
                col: n
            })
        }

        function D(t) {
            return e.map(t.match(/(\\.|[^\.])+/g) || [""], function(e) {
                return e.replace(/\\./g, ".")
            })
        }

        function _(t) {
            if (e.isPlainObject(t)) {
                var n = {};
                return e.each(t, function(e, t) {
                        t && (n[e] = _(t))
                    }),
                    function(e, t, r, o) {
                        var a = n[t] || n._;
                        return a !== i ? a(e, t, r, o) : e
                    }
            }
            if (null === t) return function(e) {
                return e
            };
            if ("function" == typeof t) return function(e, n, i, r) {
                return t(e, n, i, r)
            };
            if ("string" != typeof t || t.indexOf(".") === -1 && t.indexOf("[") === -1 && t.indexOf("(") === -1) return function(e, n) {
                return e[t]
            };
            var r = function(t, n, o) {
                var a, s, l, u;
                if ("" !== o)
                    for (var c = D(o), d = 0, h = c.length; d < h; d++) {
                        if (a = c[d].match(gt), s = c[d].match(mt), a) {
                            if (c[d] = c[d].replace(gt, ""), "" !== c[d] && (t = t[c[d]]), l = [], c.splice(0, d + 1), u = c.join("."), e.isArray(t))
                                for (var f = 0, p = t.length; f < p; f++) l.push(r(t[f], n, u));
                            var g = a[0].substring(1, a[0].length - 1);
                            t = "" === g ? l : l.join(g);
                            break
                        }
                        if (s) c[d] = c[d].replace(mt, ""), t = t[c[d]]();
                        else {
                            if (null === t || t[c[d]] === i) return i;
                            t = t[c[d]]
                        }
                    }
                return t
            };
            return function(e, n) {
                return r(e, n, t)
            }
        }

        function j(t) {
            if (e.isPlainObject(t)) return j(t._);
            if (null === t) return function() {};
            if ("function" == typeof t) return function(e, n, i) {
                t(e, "set", n, i)
            };
            if ("string" != typeof t || t.indexOf(".") === -1 && t.indexOf("[") === -1 && t.indexOf("(") === -1) return function(e, n) {
                e[t] = n
            };
            var n = function(t, r, o) {
                for (var a, s, l, u, c, d = D(o), h = d[d.length - 1], f = 0, p = d.length - 1; f < p; f++) {
                    if (s = d[f].match(gt), l = d[f].match(mt), s) {
                        if (d[f] = d[f].replace(gt, ""), t[d[f]] = [], a = d.slice(), a.splice(0, f + 1), c = a.join("."), e.isArray(r))
                            for (var g = 0, m = r.length; g < m; g++) u = {}, n(u, r[g], c), t[d[f]].push(u);
                        else t[d[f]] = r;
                        return
                    }
                    l && (d[f] = d[f].replace(mt, ""), t = t[d[f]](r)), null !== t[d[f]] && t[d[f]] !== i || (t[d[f]] = {}), t = t[d[f]]
                }
                h.match(mt) ? t = t[h.replace(mt, "")](r) : t[h.replace(gt, "")] = r
            };
            return function(e, i) {
                return n(e, i, t)
            }
        }

        function A(e) {
            return lt(e.aoData, "_aData")
        }

        function I(e) {
            e.aoData.length = 0, e.aiDisplayMaster.length = 0, e.aiDisplay.length = 0, e.aIds = {}
        }

        function $(e, t, n) {
            for (var r = -1, o = 0, a = e.length; o < a; o++) e[o] == t ? r = o : e[o] > t && e[o]--;
            r != -1 && n === i && e.splice(r, 1)
        }

        function L(e, t, n, r) {
            var o, a, s = e.aoData[t],
                l = function(n, i) {
                    for (; n.childNodes.length;) n.removeChild(n.firstChild);
                    n.innerHTML = T(e, t, i, "display")
                };
            if ("dom" !== n && (n && "auto" !== n || "dom" !== s.src)) {
                var u = s.anCells;
                if (u)
                    if (r !== i) l(u[r], r);
                    else
                        for (o = 0, a = u.length; o < a; o++) l(u[o], o)
            } else s._aData = N(e, s, r, r === i ? i : s._aData).data;
            s._aSortData = null, s._aFilterData = null;
            var c = e.aoColumns;
            if (r !== i) c[r].sType = null;
            else {
                for (o = 0, a = c.length; o < a; o++) c[o].sType = null;
                R(e, s)
            }
        }

        function N(t, n, r, o) {
            var a, s, l, u = [],
                c = n.firstChild,
                d = 0,
                h = t.aoColumns,
                f = t._rowReadObject;
            o = o !== i ? o : f ? {} : [];
            var p = function(e, t) {
                    if ("string" == typeof e) {
                        var n = e.indexOf("@");
                        if (n !== -1) {
                            var i = e.substring(n + 1),
                                r = j(e);
                            r(o, t.getAttribute(i))
                        }
                    }
                },
                g = function(t) {
                    if (r === i || r === d)
                        if (s = h[d], l = e.trim(t.innerHTML), s && s._bAttrSrc) {
                            var n = j(s.mData._);
                            n(o, l), p(s.mData.sort, t), p(s.mData.type, t), p(s.mData.filter, t)
                        } else f ? (s._setter || (s._setter = j(s.mData)), s._setter(o, l)) : o[d] = l;
                    d++
                };
            if (c)
                for (; c;) a = c.nodeName.toUpperCase(), "TD" != a && "TH" != a || (g(c), u.push(c)), c = c.nextSibling;
            else {
                u = n.anCells;
                for (var m = 0, v = u.length; m < v; m++) g(u[m])
            }
            var y = n.firstChild ? n : n.nTr;
            if (y) {
                var b = y.getAttribute("id");
                b && j(t.rowId)(o, b)
            }
            return {
                data: o,
                cells: u
            }
        }

        function E(t, i, r, o) {
            var a, s, l, u, c, d = t.aoData[i],
                h = d._aData,
                f = [];
            if (null === d.nTr) {
                for (a = r || n.createElement("tr"), d.nTr = a, d.anCells = f, a._DT_RowIndex = i, R(t, d), u = 0, c = t.aoColumns.length; u < c; u++) l = t.aoColumns[u], s = r ? o[u] : n.createElement(l.sCellType), s._DT_CellIndex = {
                    row: i,
                    column: u
                }, f.push(s), r && !l.mRender && l.mData === u || e.isPlainObject(l.mData) && l.mData._ === u + ".display" || (s.innerHTML = T(t, i, u, "display")), l.sClass && (s.className += " " + l.sClass), l.bVisible && !r ? a.appendChild(s) : !l.bVisible && r && s.parentNode.removeChild(s), l.fnCreatedCell && l.fnCreatedCell.call(t.oInstance, s, T(t, i, u), h, i, u);
                Fe(t, "aoRowCreatedCallback", null, [a, h, i])
            }
            d.nTr.setAttribute("role", "row")
        }

        function R(t, n) {
            var i = n.nTr,
                r = n._aData;
            if (i) {
                var o = t.rowIdFn(r);
                if (o && (i.id = o), r.DT_RowClass) {
                    var a = r.DT_RowClass.split(" ");
                    n.__rowc = n.__rowc ? ft(n.__rowc.concat(a)) : a, e(i).removeClass(n.__rowc.join(" ")).addClass(r.DT_RowClass)
                }
                r.DT_RowAttr && e(i).attr(r.DT_RowAttr), r.DT_RowData && e(i).data(r.DT_RowData)
            }
        }

        function P(t) {
            var n, i, r, o, a, s = t.nTHead,
                l = t.nTFoot,
                u = 0 === e("th, td", s).length,
                c = t.oClasses,
                d = t.aoColumns;
            for (u && (o = e("<tr/>").appendTo(s)), n = 0, i = d.length; n < i; n++) a = d[n], r = e(a.nTh).addClass(a.sClass), u && r.appendTo(o), t.oFeatures.bSort && (r.addClass(a.sSortingClass), a.bSortable !== !1 && (r.attr("tabindex", t.iTabIndex).attr("aria-controls", t.sTableId), De(t, a.nTh, n))), a.sTitle != r[0].innerHTML && r.html(a.sTitle), Oe(t, "header")(t, r, a, c);
            if (u && B(t.aoHeader, s), e(s).find(">tr").attr("role", "row"), e(s).find(">tr>th, >tr>td").addClass(c.sHeaderTH), e(l).find(">tr>th, >tr>td").addClass(c.sFooterTH), null !== l) {
                var h = t.aoFooter[0];
                for (n = 0, i = h.length; n < i; n++) a = d[n], a.nTf = h[n].cell, a.sClass && e(a.nTf).addClass(a.sClass)
            }
        }

        function F(t, n, r) {
            var o, a, s, l, u, c, d, h, f, p = [],
                g = [],
                m = t.aoColumns.length;
            if (n) {
                for (r === i && (r = !1), o = 0, a = n.length; o < a; o++) {
                    for (p[o] = n[o].slice(), p[o].nTr = n[o].nTr, s = m - 1; s >= 0; s--) t.aoColumns[s].bVisible || r || p[o].splice(s, 1);
                    g.push([])
                }
                for (o = 0, a = p.length; o < a; o++) {
                    if (d = p[o].nTr)
                        for (; c = d.firstChild;) d.removeChild(c);
                    for (s = 0, l = p[o].length; s < l; s++)
                        if (h = 1, f = 1, g[o][s] === i) {
                            for (d.appendChild(p[o][s].cell), g[o][s] = 1; p[o + h] !== i && p[o][s].cell == p[o + h][s].cell;) g[o + h][s] = 1, h++;
                            for (; p[o][s + f] !== i && p[o][s].cell == p[o][s + f].cell;) {
                                for (u = 0; u < h; u++) g[o + u][s + f] = 1;
                                f++
                            }
                            e(p[o][s].cell).attr("rowspan", h).attr("colspan", f)
                        }
                }
            }
        }

        function H(t) {
            var n = Fe(t, "aoPreDrawCallback", "preDraw", [t]);
            if (e.inArray(!1, n) !== -1) return void fe(t, !1);
            var r = [],
                o = 0,
                a = t.asStripeClasses,
                s = a.length,
                l = (t.aoOpenRows.length,
                    t.oLanguage),
                u = t.iInitDisplayStart,
                c = "ssp" == Qe(t),
                d = t.aiDisplay;
            t.bDrawing = !0, u !== i && u !== -1 && (t._iDisplayStart = c ? u : u >= t.fnRecordsDisplay() ? 0 : u, t.iInitDisplayStart = -1);
            var h = t._iDisplayStart,
                f = t.fnDisplayEnd();
            if (t.bDeferLoading) t.bDeferLoading = !1, t.iDraw++, fe(t, !1);
            else if (c) {
                if (!t.bDestroying && !z(t)) return
            } else t.iDraw++;
            if (0 !== d.length)
                for (var p = c ? 0 : h, g = c ? t.aoData.length : f, v = p; v < g; v++) {
                    var y = d[v],
                        b = t.aoData[y];
                    null === b.nTr && E(t, y);
                    var x = b.nTr;
                    if (0 !== s) {
                        var w = a[o % s];
                        b._sRowStripe != w && (e(x).removeClass(b._sRowStripe).addClass(w), b._sRowStripe = w)
                    }
                    Fe(t, "aoRowCallback", null, [x, b._aData, o, v]), r.push(x), o++
                } else {
                    var C = l.sZeroRecords;
                    1 == t.iDraw && "ajax" == Qe(t) ? C = l.sLoadingRecords : l.sEmptyTable && 0 === t.fnRecordsTotal() && (C = l.sEmptyTable), r[0] = e("<tr/>", {
                        class: s ? a[0] : ""
                    }).append(e("<td />", {
                        valign: "top",
                        colSpan: m(t),
                        class: t.oClasses.sRowEmpty
                    }).html(C))[0]
                }
            Fe(t, "aoHeaderCallback", "header", [e(t.nTHead).children("tr")[0], A(t), h, f, d]), Fe(t, "aoFooterCallback", "footer", [e(t.nTFoot).children("tr")[0], A(t), h, f, d]);
            var S = e(t.nTBody);
            S.children().detach(), S.append(e(r)), Fe(t, "aoDrawCallback", "draw", [t]), t.bSorted = !1, t.bFiltered = !1, t.bDrawing = !1
        }

        function O(e, t) {
            var n = e.oFeatures,
                i = n.bSort,
                r = n.bFilter;
            i && Se(e), r ? J(e, e.oPreviousSearch) : e.aiDisplay = e.aiDisplayMaster.slice(), t !== !0 && (e._iDisplayStart = 0), e._drawHold = t, H(e), e._drawHold = !1
        }

        function Q(t) {
            var n = t.oClasses,
                i = e(t.nTable),
                r = e("<div/>").insertBefore(i),
                o = t.oFeatures,
                a = e("<div/>", {
                    id: t.sTableId + "_wrapper",
                    class: n.sWrapper + (t.nTFoot ? "" : " " + n.sNoFooter)
                });
            t.nHolding = r[0], t.nTableWrapper = a[0], t.nTableReinsertBefore = t.nTable.nextSibling;
            for (var s, l, u, c, d, h, f = t.sDom.split(""), p = 0; p < f.length; p++) {
                if (s = null, l = f[p], "<" == l) {
                    if (u = e("<div/>")[0], c = f[p + 1], "'" == c || '"' == c) {
                        for (d = "", h = 2; f[p + h] != c;) d += f[p + h], h++;
                        if ("H" == d ? d = n.sJUIHeader : "F" == d && (d = n.sJUIFooter), d.indexOf(".") != -1) {
                            var g = d.split(".");
                            u.id = g[0].substr(1, g[0].length - 1), u.className = g[1]
                        } else "#" == d.charAt(0) ? u.id = d.substr(1, d.length - 1) : u.className = d;
                        p += h
                    }
                    a.append(u), a = e(u)
                } else if (">" == l) a = a.parent();
                else if ("l" == l && o.bPaginate && o.bLengthChange) s = ue(t);
                else if ("f" == l && o.bFilter) s = X(t);
                else if ("r" == l && o.bProcessing) s = he(t);
                else if ("t" == l) s = pe(t);
                else if ("i" == l && o.bInfo) s = ie(t);
                else if ("p" == l && o.bPaginate) s = ce(t);
                else if (0 !== Xe.ext.feature.length)
                    for (var m = Xe.ext.feature, v = 0, y = m.length; v < y; v++)
                        if (l == m[v].cFeature) {
                            s = m[v].fnInit(t);
                            break
                        }
                if (s) {
                    var b = t.aanFeatures;
                    b[l] || (b[l] = []), b[l].push(s), a.append(s)
                }
            }
            r.replaceWith(a), t.nHolding = null
        }

        function B(t, n) {
            var i, r, o, a, s, l, u, c, d, h, f, p = e(n).children("tr"),
                g = function(e, t, n) {
                    for (var i = e[t]; i[n];) n++;
                    return n
                };
            for (t.splice(0, t.length), o = 0, l = p.length; o < l; o++) t.push([]);
            for (o = 0, l = p.length; o < l; o++)
                for (i = p[o], c = 0, r = i.firstChild; r;) {
                    if ("TD" == r.nodeName.toUpperCase() || "TH" == r.nodeName.toUpperCase())
                        for (d = 1 * r.getAttribute("colspan"), h = 1 * r.getAttribute("rowspan"), d = d && 0 !== d && 1 !== d ? d : 1, h = h && 0 !== h && 1 !== h ? h : 1, u = g(t, o, c), f = 1 === d, s = 0; s < d; s++)
                            for (a = 0; a < h; a++) t[o + a][u + s] = {
                                cell: r,
                                unique: f
                            }, t[o + a].nTr = i;
                    r = r.nextSibling
                }
        }

        function M(e, t, n) {
            var i = [];
            n || (n = e.aoHeader, t && (n = [], B(n, t)));
            for (var r = 0, o = n.length; r < o; r++)
                for (var a = 0, s = n[r].length; a < s; a++) !n[r][a].unique || i[a] && e.bSortCellsTop || (i[a] = n[r][a].cell);
            return i
        }

        function W(t, n, i) {
            if (Fe(t, "aoServerParams", "serverParams", [n]), n && e.isArray(n)) {
                var r = {},
                    o = /(.*?)\[\]$/;
                e.each(n, function(e, t) {
                    var n = t.name.match(o);
                    if (n) {
                        var i = n[0];
                        r[i] || (r[i] = []), r[i].push(t.value)
                    } else r[t.name] = t.value
                }), n = r
            }
            var a, s = t.ajax,
                l = t.oInstance,
                u = function(e) {
                    Fe(t, null, "xhr", [t, e, t.jqXHR]), i(e)
                };
            if (e.isPlainObject(s) && s.data) {
                a = s.data;
                var c = e.isFunction(a) ? a(n, t) : a;
                n = e.isFunction(a) && c ? c : e.extend(!0, n, c), delete s.data
            }
            var d = {
                data: n,
                success: function(e) {
                    var n = e.error || e.sError;
                    n && Le(t, 0, n), t.json = e, u(e)
                },
                dataType: "json",
                cache: !1,
                type: t.sServerMethod,
                error: function(n, i, r) {
                    var o = Fe(t, null, "xhr", [t, null, t.jqXHR]);
                    e.inArray(!0, o) === -1 && ("parsererror" == i ? Le(t, 0, "Invalid JSON response", 1) : 4 === n.readyState && Le(t, 0, "Ajax error", 7)), fe(t, !1)
                }
            };
            t.oAjaxData = n, Fe(t, null, "preXhr", [t, n]), t.fnServerData ? t.fnServerData.call(l, t.sAjaxSource, e.map(n, function(e, t) {
                return {
                    name: t,
                    value: e
                }
            }), u, t) : t.sAjaxSource || "string" == typeof s ? t.jqXHR = e.ajax(e.extend(d, {
                url: s || t.sAjaxSource
            })) : e.isFunction(s) ? t.jqXHR = s.call(l, n, u, t) : (t.jqXHR = e.ajax(e.extend(d, s)), s.data = a)
        }

        function z(e) {
            return !e.bAjaxDataGet || (e.iDraw++, fe(e, !0), W(e, q(e), function(t) {
                U(e, t)
            }), !1)
        }

        function q(t) {
            var n, i, r, o, a = t.aoColumns,
                s = a.length,
                l = t.oFeatures,
                u = t.oPreviousSearch,
                c = t.aoPreSearchCols,
                d = [],
                h = Ce(t),
                f = t._iDisplayStart,
                p = l.bPaginate !== !1 ? t._iDisplayLength : -1,
                g = function(e, t) {
                    d.push({
                        name: e,
                        value: t
                    })
                };
            g("sEcho", t.iDraw), g("iColumns", s), g("sColumns", lt(a, "sName").join(",")), g("iDisplayStart", f), g("iDisplayLength", p);
            var m = {
                draw: t.iDraw,
                columns: [],
                order: [],
                start: f,
                length: p,
                search: {
                    value: u.sSearch,
                    regex: u.bRegex
                }
            };
            for (n = 0; n < s; n++) r = a[n], o = c[n], i = "function" == typeof r.mData ? "function" : r.mData, m.columns.push({
                data: i,
                name: r.sName,
                searchable: r.bSearchable,
                orderable: r.bSortable,
                search: {
                    value: o.sSearch,
                    regex: o.bRegex
                }
            }), g("mDataProp_" + n, i), l.bFilter && (g("sSearch_" + n, o.sSearch), g("bRegex_" + n, o.bRegex), g("bSearchable_" + n, r.bSearchable)), l.bSort && g("bSortable_" + n, r.bSortable);
            l.bFilter && (g("sSearch", u.sSearch), g("bRegex", u.bRegex)), l.bSort && (e.each(h, function(e, t) {
                m.order.push({
                    column: t.col,
                    dir: t.dir
                }), g("iSortCol_" + e, t.col), g("sSortDir_" + e, t.dir)
            }), g("iSortingCols", h.length));
            var v = Xe.ext.legacy.ajax;
            return null === v ? t.sAjaxSource ? d : m : v ? d : m
        }

        function U(e, t) {
            var n = function(e, n) {
                    return t[e] !== i ? t[e] : t[n]
                },
                r = V(e, t),
                o = n("sEcho", "draw"),
                a = n("iTotalRecords", "recordsTotal"),
                s = n("iTotalDisplayRecords", "recordsFiltered");
            if (o) {
                if (1 * o < e.iDraw) return;
                e.iDraw = 1 * o
            }
            I(e), e._iRecordsTotal = parseInt(a, 10), e._iRecordsDisplay = parseInt(s, 10);
            for (var l = 0, u = r.length; l < u; l++) x(e, r[l]);
            e.aiDisplay = e.aiDisplayMaster.slice(), e.bAjaxDataGet = !1, H(e), e._bInitComplete || se(e, t), e.bAjaxDataGet = !0, fe(e, !1)
        }

        function V(t, n) {
            var r = e.isPlainObject(t.ajax) && t.ajax.dataSrc !== i ? t.ajax.dataSrc : t.sAjaxDataProp;
            return "data" === r ? n.aaData || n[r] : "" !== r ? _(r)(n) : n
        }

        function X(t) {
            var i = t.oClasses,
                r = t.sTableId,
                o = t.oLanguage,
                a = t.oPreviousSearch,
                s = t.aanFeatures,
                l = '<input type="search" class="' + i.sFilterInput + '"/>',
                u = o.sSearch;
            u = u.match(/_INPUT_/) ? u.replace("_INPUT_", l) : u + l;
            var c = e("<div/>", {
                    id: s.f ? null : r + "_filter",
                    class: i.sFilter
                }).append(e("<label/>").append(u)),
                d = function() {
                    var e = (s.f, this.value ? this.value : "");
                    e != a.sSearch && (J(t, {
                        sSearch: e,
                        bRegex: a.bRegex,
                        bSmart: a.bSmart,
                        bCaseInsensitive: a.bCaseInsensitive
                    }), t._iDisplayStart = 0, H(t))
                },
                h = null !== t.searchDelay ? t.searchDelay : "ssp" === Qe(t) ? 400 : 0,
                f = e("input", c).val(a.sSearch).attr("placeholder", o.sSearchPlaceholder).bind("keyup.DT search.DT input.DT paste.DT cut.DT", h ? wt(d, h) : d).bind("keypress.DT", function(e) {
                    if (13 == e.keyCode) return !1
                }).attr("aria-controls", r);
            return e(t.nTable).on("search.dt.DT", function(e, i) {
                if (t === i) try {
                    f[0] !== n.activeElement && f.val(a.sSearch)
                } catch (e) {}
            }), c[0]
        }

        function J(e, t, n) {
            var r = e.oPreviousSearch,
                o = e.aoPreSearchCols,
                a = function(e) {
                    r.sSearch = e.sSearch, r.bRegex = e.bRegex, r.bSmart = e.bSmart, r.bCaseInsensitive = e.bCaseInsensitive
                },
                s = function(e) {
                    return e.bEscapeRegex !== i ? !e.bEscapeRegex : e.bRegex
                };
            if (y(e), "ssp" != Qe(e)) {
                Y(e, t.sSearch, n, s(t), t.bSmart, t.bCaseInsensitive), a(t);
                for (var l = 0; l < o.length; l++) K(e, o[l].sSearch, l, s(o[l]), o[l].bSmart, o[l].bCaseInsensitive);
                G(e)
            } else a(t);
            e.bFiltered = !0, Fe(e, null, "search", [e])
        }

        function G(t) {
            for (var n, i, r = Xe.ext.search, o = t.aiDisplay, a = 0, s = r.length; a < s; a++) {
                for (var l = [], u = 0, c = o.length; u < c; u++) i = o[u], n = t.aoData[i], r[a](t, n._aFilterData, i, n._aData, u) && l.push(i);
                o.length = 0, e.merge(o, l)
            }
        }

        function K(e, t, n, i, r, o) {
            if ("" !== t)
                for (var a, s = e.aiDisplay, l = Z(t, i, r, o), u = s.length - 1; u >= 0; u--) a = e.aoData[s[u]]._aFilterData[n], l.test(a) || s.splice(u, 1)
        }

        function Y(e, t, n, i, r, o) {
            var a, s, l, u = Z(t, i, r, o),
                c = e.oPreviousSearch.sSearch,
                d = e.aiDisplayMaster;
            if (0 !== Xe.ext.search.length && (n = !0), s = ee(e), t.length <= 0) e.aiDisplay = d.slice();
            else
                for ((s || n || c.length > t.length || 0 !== t.indexOf(c) || e.bSorted) && (e.aiDisplay = d.slice()), a = e.aiDisplay, l = a.length - 1; l >= 0; l--) u.test(e.aoData[a[l]]._sFilterRow) || a.splice(l, 1)
        }

        function Z(t, n, i, r) {
            if (t = n ? t : vt(t), i) {
                var o = e.map(t.match(/"[^"]+"|[^ ]+/g) || [""], function(e) {
                    if ('"' === e.charAt(0)) {
                        var t = e.match(/^"(.*)"$/);
                        e = t ? t[1] : e
                    }
                    return e.replace('"', "")
                });
                t = "^(?=.*?" + o.join(")(?=.*?") + ").*$"
            }
            return new RegExp(t, r ? "i" : "")
        }

        function ee(e) {
            var t, n, i, r, o, a, s, l, u = e.aoColumns,
                c = Xe.ext.type.search,
                d = !1;
            for (n = 0, r = e.aoData.length; n < r; n++)
                if (l = e.aoData[n], !l._aFilterData) {
                    for (a = [], i = 0, o = u.length; i < o; i++) t = u[i], t.bSearchable ? (s = T(e, n, i, "filter"), c[t.sType] && (s = c[t.sType](s)), null === s && (s = ""), "string" != typeof s && s.toString && (s = s.toString())) : s = "", s.indexOf && s.indexOf("&") !== -1 && (yt.innerHTML = s, s = bt ? yt.textContent : yt.innerText), s.replace && (s = s.replace(/[\r\n]/g, "")), a.push(s);
                    l._aFilterData = a, l._sFilterRow = a.join("  "), d = !0
                }
            return d
        }

        function te(e) {
            return {
                search: e.sSearch,
                smart: e.bSmart,
                regex: e.bRegex,
                caseInsensitive: e.bCaseInsensitive
            }
        }

        function ne(e) {
            return {
                sSearch: e.search,
                bSmart: e.smart,
                bRegex: e.regex,
                bCaseInsensitive: e.caseInsensitive
            }
        }

        function ie(t) {
            var n = t.sTableId,
                i = t.aanFeatures.i,
                r = e("<div/>", {
                    class: t.oClasses.sInfo,
                    id: i ? null : n + "_info"
                });
            return i || (t.aoDrawCallback.push({
                fn: re,
                sName: "information"
            }), r.attr("role", "status").attr("aria-live", "polite"), e(t.nTable).attr("aria-describedby", n + "_info")), r[0]
        }

        function re(t) {
            var n = t.aanFeatures.i;
            if (0 !== n.length) {
                var i = t.oLanguage,
                    r = t._iDisplayStart + 1,
                    o = t.fnDisplayEnd(),
                    a = t.fnRecordsTotal(),
                    s = t.fnRecordsDisplay(),
                    l = s ? i.sInfo : i.sInfoEmpty;
                s !== a && (l += " " + i.sInfoFiltered), l += i.sInfoPostFix, l = oe(t, l);
                var u = i.fnInfoCallback;
                null !== u && (l = u.call(t.oInstance, t, r, o, a, s, l)), e(n).html(l)
            }
        }

        function oe(e, t) {
            var n = e.fnFormatNumber,
                i = e._iDisplayStart + 1,
                r = e._iDisplayLength,
                o = e.fnRecordsDisplay(),
                a = r === -1;
            return t.replace(/_START_/g, n.call(e, i)).replace(/_END_/g, n.call(e, e.fnDisplayEnd())).replace(/_MAX_/g, n.call(e, e.fnRecordsTotal())).replace(/_TOTAL_/g, n.call(e, o)).replace(/_PAGE_/g, n.call(e, a ? 1 : Math.ceil(i / r))).replace(/_PAGES_/g, n.call(e, a ? 1 : Math.ceil(o / r)))
        }

        function ae(e) {
            var t, n, i, r = e.iInitDisplayStart,
                o = e.aoColumns,
                a = e.oFeatures,
                s = e.bDeferLoading;
            if (!e.bInitialised) return void setTimeout(function() {
                ae(e)
            }, 200);
            for (Q(e), P(e), F(e, e.aoHeader), F(e, e.aoFooter), fe(e, !0), a.bAutoWidth && ve(e), t = 0, n = o.length; t < n; t++) i = o[t], i.sWidth && (i.nTh.style.width = we(i.sWidth));
            Fe(e, null, "preInit", [e]), O(e);
            var l = Qe(e);
            ("ssp" != l || s) && ("ajax" == l ? W(e, [], function(n) {
                var i = V(e, n);
                for (t = 0; t < i.length; t++) x(e, i[t]);
                e.iInitDisplayStart = r, O(e), fe(e, !1), se(e, n)
            }, e) : (fe(e, !1), se(e)))
        }

        function se(e, t) {
            e._bInitComplete = !0, (t || e.oInit.aaData) && f(e), Fe(e, null, "plugin-init", [e, t]), Fe(e, "aoInitComplete", "init", [e, t])
        }

        function le(e, t) {
            var n = parseInt(t, 10);
            e._iDisplayLength = n, He(e), Fe(e, null, "length", [e, n])
        }

        function ue(t) {
            for (var n = t.oClasses, i = t.sTableId, r = t.aLengthMenu, o = e.isArray(r[0]), a = o ? r[0] : r, s = o ? r[1] : r, l = e("<select/>", {
                    name: i + "_length",
                    "aria-controls": i,
                    class: n.sLengthSelect
                }), u = 0, c = a.length; u < c; u++) l[0][u] = new Option(s[u], a[u]);
            var d = e("<div><label/></div>").addClass(n.sLength);
            return t.aanFeatures.l || (d[0].id = i + "_length"), d.children().append(t.oLanguage.sLengthMenu.replace("_MENU_", l[0].outerHTML)), e("select", d).val(t._iDisplayLength).bind("change.DT", function(n) {
                le(t, e(this).val()), H(t)
            }), e(t.nTable).bind("length.dt.DT", function(n, i, r) {
                t === i && e("select", d).val(r)
            }), d[0]
        }

        function ce(t) {
            var n = t.sPaginationType,
                i = Xe.ext.pager[n],
                r = "function" == typeof i,
                o = function(e) {
                    H(e)
                },
                a = e("<div/>").addClass(t.oClasses.sPaging + n)[0],
                s = t.aanFeatures;
            return r || i.fnInit(t, a, o), s.p || (a.id = t.sTableId + "_paginate", t.aoDrawCallback.push({
                fn: function(e) {
                    if (r) {
                        var t, n, a = e._iDisplayStart,
                            l = e._iDisplayLength,
                            u = e.fnRecordsDisplay(),
                            c = l === -1,
                            d = c ? 0 : Math.ceil(a / l),
                            h = c ? 1 : Math.ceil(u / l),
                            f = i(d, h);
                        for (t = 0, n = s.p.length; t < n; t++) Oe(e, "pageButton")(e, s.p[t], t, f, d, h)
                    } else i.fnUpdate(e, o)
                },
                sName: "pagination"
            })), a
        }

        function de(e, t, n) {
            var i = e._iDisplayStart,
                r = e._iDisplayLength,
                o = e.fnRecordsDisplay();
            0 === o || r === -1 ? i = 0 : "number" == typeof t ? (i = t * r, i > o && (i = 0)) : "first" == t ? i = 0 : "previous" == t ? (i = r >= 0 ? i - r : 0, i < 0 && (i = 0)) : "next" == t ? i + r < o && (i += r) : "last" == t ? i = Math.floor((o - 1) / r) * r : Le(e, 0, "Unknown paging action: " + t, 5);
            var a = e._iDisplayStart !== i;
            return e._iDisplayStart = i, a && (Fe(e, null, "page", [e]), n && H(e)), a
        }

        function he(t) {
            return e("<div/>", {
                id: t.aanFeatures.r ? null : t.sTableId + "_processing",
                class: t.oClasses.sProcessing
            }).html(t.oLanguage.sProcessing).insertBefore(t.nTable)[0]
        }

        function fe(t, n) {
            t.oFeatures.bProcessing && e(t.aanFeatures.r).css("display", n ? "block" : "none"), Fe(t, null, "processing", [t, n])
        }

        function pe(t) {
            var n = e(t.nTable);
            n.attr("role", "grid");
            var i = t.oScroll;
            if ("" === i.sX && "" === i.sY) return t.nTable;
            var r = i.sX,
                o = i.sY,
                a = t.oClasses,
                s = n.children("caption"),
                l = s.length ? s[0]._captionSide : null,
                u = e(n[0].cloneNode(!1)),
                c = e(n[0].cloneNode(!1)),
                d = n.children("tfoot"),
                h = "<div/>",
                f = function(e) {
                    return e ? we(e) : null
                };
            d.length || (d = null);
            var p = e(h, {
                class: a.sScrollWrapper
            }).append(e(h, {
                class: a.sScrollHead
            }).css({
                overflow: "hidden",
                position: "relative",
                border: 0,
                width: r ? f(r) : "100%"
            }).append(e(h, {
                class: a.sScrollHeadInner
            }).css({
                "box-sizing": "content-box",
                width: i.sXInner || "100%"
            }).append(u.removeAttr("id").css("margin-left", 0).append("top" === l ? s : null).append(n.children("thead"))))).append(e(h, {
                class: a.sScrollBody
            }).css({
                position: "relative",
                overflow: "auto",
                width: f(r)
            }).append(n));
            d && p.append(e(h, {
                class: a.sScrollFoot
            }).css({
                overflow: "hidden",
                border: 0,
                width: r ? f(r) : "100%"
            }).append(e(h, {
                class: a.sScrollFootInner
            }).append(c.removeAttr("id").css("margin-left", 0).append("bottom" === l ? s : null).append(n.children("tfoot")))));
            var g = p.children(),
                m = g[0],
                v = g[1],
                y = d ? g[2] : null;
            return r && e(v).on("scroll.DT", function(e) {
                var t = this.scrollLeft;
                m.scrollLeft = t, d && (y.scrollLeft = t)
            }), e(v).css(o && i.bCollapse ? "max-height" : "height", o), t.nScrollHead = m, t.nScrollBody = v, t.nScrollFoot = y, t.aoDrawCallback.push({
                fn: ge,
                sName: "scrolling"
            }), p[0]
        }

        function ge(t) {
            var n, r, o, a, s, l, u, c, d, h = t.oScroll,
                g = h.sX,
                m = h.sXInner,
                v = h.sY,
                y = h.iBarWidth,
                b = e(t.nScrollHead),
                x = b[0].style,
                w = b.children("div"),
                C = w[0].style,
                S = w.children("table"),
                T = t.nScrollBody,
                k = e(T),
                D = T.style,
                _ = e(t.nScrollFoot),
                j = _.children("div"),
                A = j.children("table"),
                I = e(t.nTHead),
                $ = e(t.nTable),
                L = $[0],
                N = L.style,
                E = t.nTFoot ? e(t.nTFoot) : null,
                R = t.oBrowser,
                P = R.bScrollOversize,
                F = lt(t.aoColumns, "nTh"),
                H = [],
                O = [],
                Q = [],
                B = [],
                W = function(e) {
                    var t = e.style;
                    t.paddingTop = "0", t.paddingBottom = "0", t.borderTopWidth = "0", t.borderBottomWidth = "0", t.height = 0
                },
                z = T.scrollHeight > T.clientHeight;
            if (t.scrollBarVis !== z && t.scrollBarVis !== i) return t.scrollBarVis = z, void f(t);
            t.scrollBarVis = z, $.children("thead, tfoot").remove(), E && (l = E.clone().prependTo($), r = E.find("tr"), a = l.find("tr")), s = I.clone().prependTo($), n = I.find("tr"), o = s.find("tr"), s.find("th, td").removeAttr("tabindex"), g || (D.width = "100%", b[0].style.width = "100%"), e.each(M(t, s), function(e, n) {
                u = p(t, e), n.style.width = t.aoColumns[u].sWidth
            }), E && me(function(e) {
                e.style.width = ""
            }, a), d = $.outerWidth(), "" === g ? (N.width = "100%", P && ($.find("tbody").height() > T.offsetHeight || "scroll" == k.css("overflow-y")) && (N.width = we($.outerWidth() - y)), d = $.outerWidth()) : "" !== m && (N.width = we(m), d = $.outerWidth()), me(W, o), me(function(t) {
                Q.push(t.innerHTML), H.push(we(e(t).css("width")))
            }, o), me(function(t, n) {
                e.inArray(t, F) !== -1 && (t.style.width = H[n])
            }, n), e(o).height(0), E && (me(W, a), me(function(t) {
                B.push(t.innerHTML), O.push(we(e(t).css("width")))
            }, a), me(function(e, t) {
                e.style.width = O[t]
            }, r), e(a).height(0)), me(function(e, t) {
                e.innerHTML = '<div class="dataTables_sizing" style="height:0;overflow:hidden;">' + Q[t] + "</div>", e.style.width = H[t]
            }, o), E && me(function(e, t) {
                e.innerHTML = '<div class="dataTables_sizing" style="height:0;overflow:hidden;">' + B[t] + "</div>", e.style.width = O[t]
            }, a), $.outerWidth() < d ? (c = T.scrollHeight > T.offsetHeight || "scroll" == k.css("overflow-y") ? d + y : d, P && (T.scrollHeight > T.offsetHeight || "scroll" == k.css("overflow-y")) && (N.width = we(c - y)), "" !== g && "" === m || Le(t, 1, "Possible column misalignment", 6)) : c = "100%", D.width = we(c), x.width = we(c), E && (t.nScrollFoot.style.width = we(c)), v || P && (D.height = we(L.offsetHeight + y));
            var q = $.outerWidth();
            S[0].style.width = we(q), C.width = we(q);
            var U = $.height() > T.clientHeight || "scroll" == k.css("overflow-y"),
                V = "padding" + (R.bScrollbarLeft ? "Left" : "Right");
            C[V] = U ? y + "px" : "0px", E && (A[0].style.width = we(q), j[0].style.width = we(q), j[0].style[V] = U ? y + "px" : "0px"), $.children("colgroup").insertBefore($.children("thead")), k.scroll(), !t.bSorted && !t.bFiltered || t._drawHold || (T.scrollTop = 0)
        }

        function me(e, t, n) {
            for (var i, r, o = 0, a = 0, s = t.length; a < s;) {
                for (i = t[a].firstChild, r = n ? n[a].firstChild : null; i;) 1 === i.nodeType && (n ? e(i, r, o) : e(i, o), o++), i = i.nextSibling, r = n ? r.nextSibling : null;
                a++
            }
        }

        function ve(n) {
            var i, r, o, a = n.nTable,
                s = n.aoColumns,
                l = n.oScroll,
                u = l.sY,
                c = l.sX,
                d = l.sXInner,
                h = s.length,
                g = v(n, "bVisible"),
                y = e("th", n.nTHead),
                b = a.getAttribute("width"),
                x = a.parentNode,
                w = !1,
                C = n.oBrowser,
                S = C.bScrollOversize,
                T = a.style.width;
            for (T && T.indexOf("%") !== -1 && (b = T), i = 0; i < g.length; i++) r = s[g[i]], null !== r.sWidth && (r.sWidth = ye(r.sWidthOrig, x), w = !0);
            if (S || !w && !c && !u && h == m(n) && h == y.length)
                for (i = 0; i < h; i++) {
                    var k = p(n, i);
                    null !== k && (s[k].sWidth = we(y.eq(i).width()))
                } else {
                    var D = e(a).clone().css("visibility", "hidden").removeAttr("id");
                    D.find("tbody tr").remove();
                    var _ = e("<tr/>").appendTo(D.find("tbody"));
                    for (D.find("thead, tfoot").remove(), D.append(e(n.nTHead).clone()).append(e(n.nTFoot).clone()), D.find("tfoot th, tfoot td").css("width", ""), y = M(n, D.find("thead")[0]), i = 0; i < g.length; i++) r = s[g[i]], y[i].style.width = null !== r.sWidthOrig && "" !== r.sWidthOrig ? we(r.sWidthOrig) : "", r.sWidthOrig && c && e(y[i]).append(e("<div/>").css({
                        width: r.sWidthOrig,
                        margin: 0,
                        padding: 0,
                        border: 0,
                        height: 1
                    }));
                    if (n.aoData.length)
                        for (i = 0; i < g.length; i++) o = g[i], r = s[o], e(be(n, o)).clone(!1).append(r.sContentPadding).appendTo(_);
                    e("[name]", D).removeAttr("name");
                    var j = e("<div/>").css(c || u ? {
                        position: "absolute",
                        top: 0,
                        left: 0,
                        height: 1,
                        right: 0,
                        overflow: "hidden"
                    } : {}).append(D).appendTo(x);
                    c && d ? D.width(d) : c ? (D.css("width", "auto"), D.removeAttr("width"), D.width() < x.clientWidth && b && D.width(x.clientWidth)) : u ? D.width(x.clientWidth) : b && D.width(b);
                    var A = 0;
                    for (i = 0; i < g.length; i++) {
                        var I = e(y[i]),
                            $ = I.outerWidth() - I.width(),
                            L = C.bBounding ? Math.ceil(y[i].getBoundingClientRect().width) : I.outerWidth();
                        A += L, s[g[i]].sWidth = we(L - $)
                    }
                    a.style.width = we(A), j.remove()
                }
            if (b && (a.style.width = we(b)), (b || c) && !n._reszEvt) {
                var N = function() {
                    e(t).bind("resize.DT-" + n.sInstance, wt(function() {
                        f(n)
                    }))
                };
                S ? setTimeout(N, 1e3) : N(), n._reszEvt = !0
            }
        }

        function ye(t, i) {
            if (!t) return 0;
            var r = e("<div/>").css("width", we(t)).appendTo(i || n.body),
                o = r[0].offsetWidth;
            return r.remove(), o
        }

        function be(t, n) {
            var i = xe(t, n);
            if (i < 0) return null;
            var r = t.aoData[i];
            return r.nTr ? r.anCells[n] : e("<td/>").html(T(t, i, n, "display"))[0]
        }

        function xe(e, t) {
            for (var n, i = -1, r = -1, o = 0, a = e.aoData.length; o < a; o++) n = T(e, o, t, "display") + "", n = n.replace(xt, ""), n = n.replace(/&nbsp;/g, " "), n.length > i && (i = n.length, r = o);
            return r
        }

        function we(e) {
            return null === e ? "0px" : "number" == typeof e ? e < 0 ? "0px" : e + "px" : e.match(/\d$/) ? e + "px" : e
        }

        function Ce(t) {
            var n, r, o, a, s, l, u, c = [],
                d = t.aoColumns,
                h = t.aaSortingFixed,
                f = e.isPlainObject(h),
                p = [],
                g = function(t) {
                    t.length && !e.isArray(t[0]) ? p.push(t) : e.merge(p, t)
                };
            for (e.isArray(h) && g(h), f && h.pre && g(h.pre), g(t.aaSorting), f && h.post && g(h.post), n = 0; n < p.length; n++)
                for (u = p[n][0], a = d[u].aDataSort, r = 0, o = a.length; r < o; r++) s = a[r], l = d[s].sType || "string", p[n]._idx === i && (p[n]._idx = e.inArray(p[n][1], d[s].asSorting)), c.push({
                    src: u,
                    col: s,
                    dir: p[n][1],
                    index: p[n]._idx,
                    type: l,
                    formatter: Xe.ext.type.order[l + "-pre"]
                });
            return c
        }

        function Se(e) {
            var t, n, i, r, o, a = [],
                s = Xe.ext.type.order,
                l = e.aoData,
                u = (e.aoColumns, 0),
                c = e.aiDisplayMaster;
            for (y(e), o = Ce(e), t = 0, n = o.length; t < n; t++) r = o[t], r.formatter && u++, je(e, r.col);
            if ("ssp" != Qe(e) && 0 !== o.length) {
                for (t = 0, i = c.length; t < i; t++) a[c[t]] = t;
                u === o.length ? c.sort(function(e, t) {
                    var n, i, r, s, u, c = o.length,
                        d = l[e]._aSortData,
                        h = l[t]._aSortData;
                    for (r = 0; r < c; r++)
                        if (u = o[r], n = d[u.col], i = h[u.col], s = n < i ? -1 : n > i ? 1 : 0, 0 !== s) return "asc" === u.dir ? s : -s;
                    return n = a[e], i = a[t], n < i ? -1 : n > i ? 1 : 0
                }) : c.sort(function(e, t) {
                    var n, i, r, u, c, d, h = o.length,
                        f = l[e]._aSortData,
                        p = l[t]._aSortData;
                    for (r = 0; r < h; r++)
                        if (c = o[r], n = f[c.col], i = p[c.col], d = s[c.type + "-" + c.dir] || s["string-" + c.dir], u = d(n, i), 0 !== u) return u;
                    return n = a[e], i = a[t], n < i ? -1 : n > i ? 1 : 0
                })
            }
            e.bSorted = !0
        }

        function Te(e) {
            for (var t, n, i = e.aoColumns, r = Ce(e), o = e.oLanguage.oAria, a = 0, s = i.length; a < s; a++) {
                var l = i[a],
                    u = l.asSorting,
                    c = l.sTitle.replace(/<.*?>/g, ""),
                    d = l.nTh;
                d.removeAttribute("aria-sort"), l.bSortable ? (r.length > 0 && r[0].col == a ? (d.setAttribute("aria-sort", "asc" == r[0].dir ? "ascending" : "descending"), n = u[r[0].index + 1] || u[0]) : n = u[0], t = c + ("asc" === n ? o.sSortAscending : o.sSortDescending)) : t = c, d.setAttribute("aria-label", t)
            }
        }

        function ke(t, n, r, o) {
            var a, s = t.aoColumns[n],
                l = t.aaSorting,
                u = s.asSorting,
                c = function(t, n) {
                    var r = t._idx;
                    return r === i && (r = e.inArray(t[1], u)), r + 1 < u.length ? r + 1 : n ? null : 0
                };
            if ("number" == typeof l[0] && (l = t.aaSorting = [l]), r && t.oFeatures.bSortMulti) {
                var d = e.inArray(n, lt(l, "0"));
                d !== -1 ? (a = c(l[d], !0), null === a && 1 === l.length && (a = 0), null === a ? l.splice(d, 1) : (l[d][1] = u[a], l[d]._idx = a)) : (l.push([n, u[0], 0]), l[l.length - 1]._idx = 0)
            } else l.length && l[0][0] == n ? (a = c(l[0]), l.length = 1, l[0][1] = u[a], l[0]._idx = a) : (l.length = 0, l.push([n, u[0]]), l[0]._idx = 0);
            O(t), "function" == typeof o && o(t)
        }

        function De(e, t, n, i) {
            var r = e.aoColumns[n];
            Re(t, {}, function(t) {
                r.bSortable !== !1 && (e.oFeatures.bProcessing ? (fe(e, !0), setTimeout(function() {
                    ke(e, n, t.shiftKey, i), "ssp" !== Qe(e) && fe(e, !1)
                }, 0)) : ke(e, n, t.shiftKey, i))
            })
        }

        function _e(t) {
            var n, i, r, o = t.aLastSort,
                a = t.oClasses.sSortColumn,
                s = Ce(t),
                l = t.oFeatures;
            if (l.bSort && l.bSortClasses) {
                for (n = 0, i = o.length; n < i; n++) r = o[n].src, e(lt(t.aoData, "anCells", r)).removeClass(a + (n < 2 ? n + 1 : 3));
                for (n = 0, i = s.length; n < i; n++) r = s[n].src, e(lt(t.aoData, "anCells", r)).addClass(a + (n < 2 ? n + 1 : 3))
            }
            t.aLastSort = s
        }

        function je(e, t) {
            var n, i = e.aoColumns[t],
                r = Xe.ext.order[i.sSortDataType];
            r && (n = r.call(e.oInstance, e, t, g(e, t)));
            for (var o, a, s = Xe.ext.type.order[i.sType + "-pre"], l = 0, u = e.aoData.length; l < u; l++) o = e.aoData[l], o._aSortData || (o._aSortData = []), o._aSortData[t] && !r || (a = r ? n[l] : T(e, l, t, "sort"), o._aSortData[t] = s ? s(a) : a)
        }

        function Ae(t) {
            if (t.oFeatures.bStateSave && !t.bDestroying) {
                var n = {
                    time: +new Date,
                    start: t._iDisplayStart,
                    length: t._iDisplayLength,
                    order: e.extend(!0, [], t.aaSorting),
                    search: te(t.oPreviousSearch),
                    columns: e.map(t.aoColumns, function(e, n) {
                        return {
                            visible: e.bVisible,
                            search: te(t.aoPreSearchCols[n])
                        }
                    })
                };
                Fe(t, "aoStateSaveParams", "stateSaveParams", [t, n]), t.oSavedState = n, t.fnStateSaveCallback.call(t.oInstance, t, n)
            }
        }

        function Ie(t, n) {
            var r, o, a = t.aoColumns;
            if (t.oFeatures.bStateSave) {
                var s = t.fnStateLoadCallback.call(t.oInstance, t);
                if (s && s.time) {
                    var l = Fe(t, "aoStateLoadParams", "stateLoadParams", [t, s]);
                    if (e.inArray(!1, l) === -1) {
                        var u = t.iStateDuration;
                        if (!(u > 0 && s.time < +new Date - 1e3 * u) && a.length === s.columns.length) {
                            for (t.oLoadedState = e.extend(!0, {}, s), s.start !== i && (t._iDisplayStart = s.start, t.iInitDisplayStart = s.start), s.length !== i && (t._iDisplayLength = s.length), s.order !== i && (t.aaSorting = [], e.each(s.order, function(e, n) {
                                    t.aaSorting.push(n[0] >= a.length ? [0, n[1]] : n)
                                })), s.search !== i && e.extend(t.oPreviousSearch, ne(s.search)), r = 0, o = s.columns.length; r < o; r++) {
                                var c = s.columns[r];
                                c.visible !== i && (a[r].bVisible = c.visible), c.search !== i && e.extend(t.aoPreSearchCols[r], ne(c.search))
                            }
                            Fe(t, "aoStateLoaded", "stateLoaded", [t, s])
                        }
                    }
                }
            }
        }

        function $e(t) {
            var n = Xe.settings,
                i = e.inArray(t, lt(n, "nTable"));
            return i !== -1 ? n[i] : null
        }

        function Le(e, n, i, r) {
            if (i = "DataTables warning: " + (e ? "table id=" + e.sTableId + " - " : "") + i, r && (i += ". For more information about this error, please see http://datatables.net/tn/" + r), n) t.console && console.log && console.log(i);
            else {
                var o = Xe.ext,
                    a = o.sErrMode || o.errMode;
                if (e && Fe(e, null, "error", [e, r, i]), "alert" == a) alert(i);
                else {
                    if ("throw" == a) throw new Error(i);
                    "function" == typeof a && a(e, r, i)
                }
            }
        }

        function Ne(t, n, r, o) {
            return e.isArray(r) ? void e.each(r, function(i, r) {
                e.isArray(r) ? Ne(t, n, r[0], r[1]) : Ne(t, n, r)
            }) : (o === i && (o = r), void(n[r] !== i && (t[o] = n[r])))
        }

        function Ee(t, n, i) {
            var r;
            for (var o in n) n.hasOwnProperty(o) && (r = n[o], e.isPlainObject(r) ? (e.isPlainObject(t[o]) || (t[o] = {}), e.extend(!0, t[o], r)) : i && "data" !== o && "aaData" !== o && e.isArray(r) ? t[o] = r.slice() : t[o] = r);
            return t
        }

        function Re(t, n, i) {
            e(t).bind("click.DT", n, function(e) {
                t.blur(), i(e)
            }).bind("keypress.DT", n, function(e) {
                13 === e.which && (e.preventDefault(), i(e))
            }).bind("selectstart.DT", function() {
                return !1
            })
        }

        function Pe(e, t, n, i) {
            n && e[t].push({
                fn: n,
                sName: i
            })
        }

        function Fe(t, n, i, r) {
            var o = [];
            if (n && (o = e.map(t[n].slice().reverse(), function(e, n) {
                    return e.fn.apply(t.oInstance, r)
                })), null !== i) {
                var a = e.Event(i + ".dt");
                e(t.nTable).trigger(a, r), o.push(a.result)
            }
            return o
        }

        function He(e) {
            var t = e._iDisplayStart,
                n = e.fnDisplayEnd(),
                i = e._iDisplayLength;
            t >= n && (t = n - i), t -= t % i, (i === -1 || t < 0) && (t = 0), e._iDisplayStart = t
        }

        function Oe(t, n) {
            var i = t.renderer,
                r = Xe.ext.renderer[n];
            return e.isPlainObject(i) && i[n] ? r[i[n]] || r._ : "string" == typeof i ? r[i] || r._ : r._
        }

        function Qe(e) {
            return e.oFeatures.bServerSide ? "ssp" : e.ajax || e.sAjaxSource ? "ajax" : "dom"
        }

        function Be(e, t) {
            var n = [],
                i = zt.numbers_length,
                r = Math.floor(i / 2);
            return t <= i ? n = ct(0, t) : e <= r ? (n = ct(0, i - 2), n.push("ellipsis"), n.push(t - 1)) : e >= t - 1 - r ? (n = ct(t - (i - 2), t), n.splice(0, 0, "ellipsis"), n.splice(0, 0, 0)) : (n = ct(e - r + 2, e + r - 1), n.push("ellipsis"), n.push(t - 1), n.splice(0, 0, "ellipsis"), n.splice(0, 0, 0)), n.DT_el = "span", n
        }

        function Me(t) {
            e.each({
                num: function(e) {
                    return qt(e, t)
                },
                "num-fmt": function(e) {
                    return qt(e, t, tt)
                },
                "html-num": function(e) {
                    return qt(e, t, Ke)
                },
                "html-num-fmt": function(e) {
                    return qt(e, t, Ke, tt)
                }
            }, function(e, n) {
                ze.type.order[e + t + "-pre"] = n, e.match(/^html\-/) && (ze.type.search[e + t] = ze.type.search.html)
            })
        }

        function We(e) {
            return function() {
                var t = [$e(this[Xe.ext.iApiIndex])].concat(Array.prototype.slice.call(arguments));
                return Xe.ext.internal[e].apply(this, t)
            }
        }
        var ze, qe, Ue, Ve, Xe = function(t) {
                this.$ = function(e, t) {
                    return this.api(!0).$(e, t)
                }, this._ = function(e, t) {
                    return this.api(!0).rows(e, t).data()
                }, this.api = function(e) {
                    return new qe(e ? $e(this[ze.iApiIndex]) : this)
                }, this.fnAddData = function(t, n) {
                    var r = this.api(!0),
                        o = e.isArray(t) && (e.isArray(t[0]) || e.isPlainObject(t[0])) ? r.rows.add(t) : r.row.add(t);
                    return (n === i || n) && r.draw(), o.flatten().toArray()
                }, this.fnAdjustColumnSizing = function(e) {
                    var t = this.api(!0).columns.adjust(),
                        n = t.settings()[0],
                        r = n.oScroll;
                    e === i || e ? t.draw(!1) : "" === r.sX && "" === r.sY || ge(n)
                }, this.fnClearTable = function(e) {
                    var t = this.api(!0).clear();
                    (e === i || e) && t.draw()
                }, this.fnClose = function(e) {
                    this.api(!0).row(e).child.hide()
                }, this.fnDeleteRow = function(e, t, n) {
                    var r = this.api(!0),
                        o = r.rows(e),
                        a = o.settings()[0],
                        s = a.aoData[o[0][0]];
                    return o.remove(), t && t.call(this, a, s), (n === i || n) && r.draw(), s
                }, this.fnDestroy = function(e) {
                    this.api(!0).destroy(e)
                }, this.fnDraw = function(e) {
                    this.api(!0).draw(e)
                }, this.fnFilter = function(e, t, n, r, o, a) {
                    var s = this.api(!0);
                    null === t || t === i ? s.search(e, n, r, a) : s.column(t).search(e, n, r, a), s.draw()
                }, this.fnGetData = function(e, t) {
                    var n = this.api(!0);
                    if (e !== i) {
                        var r = e.nodeName ? e.nodeName.toLowerCase() : "";
                        return t !== i || "td" == r || "th" == r ? n.cell(e, t).data() : n.row(e).data() || null
                    }
                    return n.data().toArray()
                }, this.fnGetNodes = function(e) {
                    var t = this.api(!0);
                    return e !== i ? t.row(e).node() : t.rows().nodes().flatten().toArray()
                }, this.fnGetPosition = function(e) {
                    var t = this.api(!0),
                        n = e.nodeName.toUpperCase();
                    if ("TR" == n) return t.row(e).index();
                    if ("TD" == n || "TH" == n) {
                        var i = t.cell(e).index();
                        return [i.row, i.columnVisible, i.column]
                    }
                    return null
                }, this.fnIsOpen = function(e) {
                    return this.api(!0).row(e).child.isShown()
                }, this.fnOpen = function(e, t, n) {
                    return this.api(!0).row(e).child(t, n).show().child()[0]
                }, this.fnPageChange = function(e, t) {
                    var n = this.api(!0).page(e);
                    (t === i || t) && n.draw(!1)
                }, this.fnSetColumnVis = function(e, t, n) {
                    var r = this.api(!0).column(e).visible(t);
                    (n === i || n) && r.columns.adjust().draw()
                }, this.fnSettings = function() {
                    return $e(this[ze.iApiIndex])
                }, this.fnSort = function(e) {
                    this.api(!0).order(e).draw()
                }, this.fnSortListener = function(e, t, n) {
                    this.api(!0).order.listener(e, t, n)
                }, this.fnUpdate = function(e, t, n, r, o) {
                    var a = this.api(!0);
                    return n === i || null === n ? a.row(t).data(e) : a.cell(t, n).data(e), (o === i || o) && a.columns.adjust(), (r === i || r) && a.draw(), 0
                }, this.fnVersionCheck = ze.fnVersionCheck;
                var n = this,
                    r = t === i,
                    c = this.length;
                r && (t = {}), this.oApi = this.internal = ze.internal;
                for (var f in Xe.ext.internal) f && (this[f] = We(f));
                return this.each(function() {
                    var f, p = {},
                        g = c > 1 ? Ee(p, t, !0) : t,
                        m = 0,
                        v = this.getAttribute("id"),
                        y = !1,
                        C = Xe.defaults,
                        S = e(this);
                    if ("table" != this.nodeName.toLowerCase()) return void Le(null, 0, "Non-table node initialisation (" + this.nodeName + ")", 2);
                    s(C), l(C.column), o(C, C, !0), o(C.column, C.column, !0), o(C, e.extend(g, S.data()));
                    var T = Xe.settings;
                    for (m = 0, f = T.length; m < f; m++) {
                        var k = T[m];
                        if (k.nTable == this || k.nTHead.parentNode == this || k.nTFoot && k.nTFoot.parentNode == this) {
                            var D = g.bRetrieve !== i ? g.bRetrieve : C.bRetrieve,
                                j = g.bDestroy !== i ? g.bDestroy : C.bDestroy;
                            if (r || D) return k.oInstance;
                            if (j) {
                                k.oInstance.fnDestroy();
                                break
                            }
                            return void Le(k, 0, "Cannot reinitialise DataTable", 3)
                        }
                        if (k.sTableId == this.id) {
                            T.splice(m, 1);
                            break
                        }
                    }
                    null !== v && "" !== v || (v = "DataTables_Table_" + Xe.ext._unique++, this.id = v);
                    var A = e.extend(!0, {}, Xe.models.oSettings, {
                        sDestroyWidth: S[0].style.width,
                        sInstance: v,
                        sTableId: v
                    });
                    A.nTable = this, A.oApi = n.internal, A.oInit = g, T.push(A), A.oInstance = 1 === n.length ? n : S.dataTable(), s(g), g.oLanguage && a(g.oLanguage), g.aLengthMenu && !g.iDisplayLength && (g.iDisplayLength = e.isArray(g.aLengthMenu[0]) ? g.aLengthMenu[0][0] : g.aLengthMenu[0]), g = Ee(e.extend(!0, {}, C), g), Ne(A.oFeatures, g, ["bPaginate", "bLengthChange", "bFilter", "bSort", "bSortMulti", "bInfo", "bProcessing", "bAutoWidth", "bSortClasses", "bServerSide", "bDeferRender"]), Ne(A, g, ["asStripeClasses", "ajax", "fnServerData", "fnFormatNumber", "sServerMethod", "aaSorting", "aaSortingFixed", "aLengthMenu", "sPaginationType", "sAjaxSource", "sAjaxDataProp", "iStateDuration", "sDom", "bSortCellsTop", "iTabIndex", "fnStateLoadCallback", "fnStateSaveCallback", "renderer", "searchDelay", "rowId", ["iCookieDuration", "iStateDuration"],
                        ["oSearch", "oPreviousSearch"],
                        ["aoSearchCols", "aoPreSearchCols"],
                        ["iDisplayLength", "_iDisplayLength"],
                        ["bJQueryUI", "bJUI"]
                    ]), Ne(A.oScroll, g, [
                        ["sScrollX", "sX"],
                        ["sScrollXInner", "sXInner"],
                        ["sScrollY", "sY"],
                        ["bScrollCollapse", "bCollapse"]
                    ]), Ne(A.oLanguage, g, "fnInfoCallback"), Pe(A, "aoDrawCallback", g.fnDrawCallback, "user"), Pe(A, "aoServerParams", g.fnServerParams, "user"), Pe(A, "aoStateSaveParams", g.fnStateSaveParams, "user"), Pe(A, "aoStateLoadParams", g.fnStateLoadParams, "user"), Pe(A, "aoStateLoaded", g.fnStateLoaded, "user"), Pe(A, "aoRowCallback", g.fnRowCallback, "user"), Pe(A, "aoRowCreatedCallback", g.fnCreatedRow, "user"), Pe(A, "aoHeaderCallback", g.fnHeaderCallback, "user"), Pe(A, "aoFooterCallback", g.fnFooterCallback, "user"), Pe(A, "aoInitComplete", g.fnInitComplete, "user"), Pe(A, "aoPreDrawCallback", g.fnPreDrawCallback, "user"), A.rowIdFn = _(g.rowId), u(A);
                    var I = A.oClasses;
                    if (g.bJQueryUI ? (e.extend(I, Xe.ext.oJUIClasses, g.oClasses), g.sDom === C.sDom && "lfrtip" === C.sDom && (A.sDom = '<"H"lfr>t<"F"ip>'), A.renderer ? e.isPlainObject(A.renderer) && !A.renderer.header && (A.renderer.header = "jqueryui") : A.renderer = "jqueryui") : e.extend(I, Xe.ext.classes, g.oClasses), S.addClass(I.sTable), A.iInitDisplayStart === i && (A.iInitDisplayStart = g.iDisplayStart, A._iDisplayStart = g.iDisplayStart), null !== g.iDeferLoading) {
                        A.bDeferLoading = !0;
                        var $ = e.isArray(g.iDeferLoading);
                        A._iRecordsDisplay = $ ? g.iDeferLoading[0] : g.iDeferLoading, A._iRecordsTotal = $ ? g.iDeferLoading[1] : g.iDeferLoading
                    }
                    var L = A.oLanguage;
                    e.extend(!0, L, g.oLanguage), "" !== L.sUrl && (e.ajax({
                        dataType: "json",
                        url: L.sUrl,
                        success: function(t) {
                            a(t), o(C.oLanguage, t), e.extend(!0, L, t), ae(A)
                        },
                        error: function() {
                            ae(A)
                        }
                    }), y = !0), null === g.asStripeClasses && (A.asStripeClasses = [I.sStripeOdd, I.sStripeEven]);
                    var N = A.asStripeClasses,
                        E = S.children("tbody").find("tr").eq(0);
                    e.inArray(!0, e.map(N, function(e, t) {
                        return E.hasClass(e)
                    })) !== -1 && (e("tbody tr", this).removeClass(N.join(" ")), A.asDestroyStripes = N.slice());
                    var R, P = [],
                        F = this.getElementsByTagName("thead");
                    if (0 !== F.length && (B(A.aoHeader, F[0]), P = M(A)), null === g.aoColumns)
                        for (R = [], m = 0, f = P.length; m < f; m++) R.push(null);
                    else R = g.aoColumns;
                    for (m = 0, f = R.length; m < f; m++) d(A, P ? P[m] : null);
                    if (b(A, g.aoColumnDefs, R, function(e, t) {
                            h(A, e, t)
                        }), E.length) {
                        var H = function(e, t) {
                            return null !== e.getAttribute("data-" + t) ? t : null
                        };
                        e(E[0]).children("th, td").each(function(e, t) {
                            var n = A.aoColumns[e];
                            if (n.mData === e) {
                                var r = H(t, "sort") || H(t, "order"),
                                    o = H(t, "filter") || H(t, "search");
                                null === r && null === o || (n.mData = {
                                    _: e + ".display",
                                    sort: null !== r ? e + ".@data-" + r : i,
                                    type: null !== r ? e + ".@data-" + r : i,
                                    filter: null !== o ? e + ".@data-" + o : i
                                }, h(A, e))
                            }
                        })
                    }
                    var O = A.oFeatures;
                    if (g.bStateSave && (O.bStateSave = !0, Ie(A, g), Pe(A, "aoDrawCallback", Ae, "state_save")), g.aaSorting === i) {
                        var Q = A.aaSorting;
                        for (m = 0, f = Q.length; m < f; m++) Q[m][1] = A.aoColumns[m].asSorting[0]
                    }
                    _e(A), O.bSort && Pe(A, "aoDrawCallback", function() {
                        if (A.bSorted) {
                            var t = Ce(A),
                                n = {};
                            e.each(t, function(e, t) {
                                n[t.src] = t.dir
                            }), Fe(A, null, "order", [A, t, n]), Te(A)
                        }
                    }), Pe(A, "aoDrawCallback", function() {
                        (A.bSorted || "ssp" === Qe(A) || O.bDeferRender) && _e(A)
                    }, "sc");
                    var W = S.children("caption").each(function() {
                            this._captionSide = S.css("caption-side")
                        }),
                        z = S.children("thead");
                    0 === z.length && (z = e("<thead/>").appendTo(this)), A.nTHead = z[0];
                    var q = S.children("tbody");
                    0 === q.length && (q = e("<tbody/>").appendTo(this)), A.nTBody = q[0];
                    var U = S.children("tfoot");
                    if (0 === U.length && W.length > 0 && ("" !== A.oScroll.sX || "" !== A.oScroll.sY) && (U = e("<tfoot/>").appendTo(this)), 0 === U.length || 0 === U.children().length ? S.addClass(I.sNoFooter) : U.length > 0 && (A.nTFoot = U[0], B(A.aoFooter, A.nTFoot)), g.aaData)
                        for (m = 0; m < g.aaData.length; m++) x(A, g.aaData[m]);
                    else(A.bDeferLoading || "dom" == Qe(A)) && w(A, e(A.nTBody).children("tr"));
                    A.aiDisplay = A.aiDisplayMaster.slice(), A.bInitialised = !0, y === !1 && ae(A)
                }), n = null, this
            },
            Je = {},
            Ge = /[\r\n]/g,
            Ke = /<.*?>/g,
            Ye = /^[\w\+\-]/,
            Ze = /[\w\+\-]$/,
            et = new RegExp("(\\" + ["/", ".", "*", "+", "?", "|", "(", ")", "[", "]", "{", "}", "\\", "$", "^", "-"].join("|\\") + ")", "g"),
            tt = /[',$Â£â‚¬Â¥%\u2009\u202F\u20BD\u20a9\u20BArfk]/gi,
            nt = function(e) {
                return !e || e === !0 || "-" === e
            },
            it = function(e) {
                var t = parseInt(e, 10);
                return !isNaN(t) && isFinite(e) ? t : null
            },
            rt = function(e, t) {
                return Je[t] || (Je[t] = new RegExp(vt(t), "g")), "string" == typeof e && "." !== t ? e.replace(/\./g, "").replace(Je[t], ".") : e
            },
            ot = function(e, t, n) {
                var i = "string" == typeof e;
                return !!nt(e) || (t && i && (e = rt(e, t)), n && i && (e = e.replace(tt, "")), !isNaN(parseFloat(e)) && isFinite(e))
            },
            at = function(e) {
                return nt(e) || "string" == typeof e
            },
            st = function(e, t, n) {
                if (nt(e)) return !0;
                var i = at(e);
                return i ? !!ot(ht(e), t, n) || null : null
            },
            lt = function(e, t, n) {
                var r = [],
                    o = 0,
                    a = e.length;
                if (n !== i)
                    for (; o < a; o++) e[o] && e[o][t] && r.push(e[o][t][n]);
                else
                    for (; o < a; o++) e[o] && r.push(e[o][t]);
                return r
            },
            ut = function(e, t, n, r) {
                var o = [],
                    a = 0,
                    s = t.length;
                if (r !== i)
                    for (; a < s; a++) e[t[a]][n] && o.push(e[t[a]][n][r]);
                else
                    for (; a < s; a++) o.push(e[t[a]][n]);
                return o
            },
            ct = function(e, t) {
                var n, r = [];
                t === i ? (t = 0, n = e) : (n = t, t = e);
                for (var o = t; o < n; o++) r.push(o);
                return r
            },
            dt = function(e) {
                for (var t = [], n = 0, i = e.length; n < i; n++) e[n] && t.push(e[n]);
                return t
            },
            ht = function(e) {
                return e.replace(Ke, "")
            },
            ft = function(e) {
                var t, n, i, r = [],
                    o = e.length,
                    a = 0;
                e: for (n = 0; n < o; n++) {
                    for (t = e[n], i = 0; i < a; i++)
                        if (r[i] === t) continue e;
                    r.push(t), a++
                }
                return r
            };
        Xe.util = {
            throttle: function(e, t) {
                var n, r, o = t !== i ? t : 200;
                return function() {
                    var t = this,
                        a = +new Date,
                        s = arguments;
                    n && a < n + o ? (clearTimeout(r), r = setTimeout(function() {
                        n = i, e.apply(t, s)
                    }, o)) : (n = a, e.apply(t, s))
                }
            },
            escapeRegex: function(e) {
                return e.replace(et, "\\$1")
            }
        };
        var pt = function(e, t, n) {
                e[t] !== i && (e[n] = e[t])
            },
            gt = /\[.*?\]$/,
            mt = /\(\)$/,
            vt = Xe.util.escapeRegex,
            yt = e("<div>")[0],
            bt = yt.textContent !== i,
            xt = /<.*?>/g,
            wt = Xe.util.throttle,
            Ct = [],
            St = Array.prototype,
            Tt = function(t) {
                var n, i, r = Xe.settings,
                    o = e.map(r, function(e, t) {
                        return e.nTable
                    });
                return t ? t.nTable && t.oApi ? [t] : t.nodeName && "table" === t.nodeName.toLowerCase() ? (n = e.inArray(t, o), n !== -1 ? [r[n]] : null) : t && "function" == typeof t.settings ? t.settings().toArray() : ("string" == typeof t ? i = e(t) : t instanceof e && (i = t), i ? i.map(function(t) {
                    return n = e.inArray(this, o), n !== -1 ? r[n] : null
                }).toArray() : void 0) : []
            };
        qe = function(t, n) {
            if (!(this instanceof qe)) return new qe(t, n);
            var i = [],
                r = function(e) {
                    var t = Tt(e);
                    t && (i = i.concat(t))
                };
            if (e.isArray(t))
                for (var o = 0, a = t.length; o < a; o++) r(t[o]);
            else r(t);
            this.context = ft(i), n && e.merge(this, n), this.selector = {
                rows: null,
                cols: null,
                opts: null
            }, qe.extend(this, this, Ct)
        }, Xe.Api = qe, e.extend(qe.prototype, {
            any: function() {
                return 0 !== this.count()
            },
            concat: St.concat,
            context: [],
            count: function() {
                return this.flatten().length
            },
            each: function(e) {
                for (var t = 0, n = this.length; t < n; t++) e.call(this, this[t], t, this);
                return this
            },
            eq: function(e) {
                var t = this.context;
                return t.length > e ? new qe(t[e], this[e]) : null
            },
            filter: function(e) {
                var t = [];
                if (St.filter) t = St.filter.call(this, e, this);
                else
                    for (var n = 0, i = this.length; n < i; n++) e.call(this, this[n], n, this) && t.push(this[n]);
                return new qe(this.context, t)
            },
            flatten: function() {
                var e = [];
                return new qe(this.context, e.concat.apply(e, this.toArray()))
            },
            join: St.join,
            indexOf: St.indexOf || function(e, t) {
                for (var n = t || 0, i = this.length; n < i; n++)
                    if (this[n] === e) return n;
                return -1
            },
            iterator: function(e, t, n, r) {
                var o, a, s, l, u, c, d, h, f = [],
                    p = this.context,
                    g = this.selector;
                for ("string" == typeof e && (r = n, n = t, t = e, e = !1), a = 0, s = p.length; a < s; a++) {
                    var m = new qe(p[a]);
                    if ("table" === t) o = n.call(m, p[a], a), o !== i && f.push(o);
                    else if ("columns" === t || "rows" === t) o = n.call(m, p[a], this[a], a), o !== i && f.push(o);
                    else if ("column" === t || "column-rows" === t || "row" === t || "cell" === t)
                        for (d = this[a], "column-rows" === t && (c = It(p[a], g.opts)), l = 0, u = d.length; l < u; l++) h = d[l], o = "cell" === t ? n.call(m, p[a], h.row, h.column, a, l) : n.call(m, p[a], h, a, l, c), o !== i && f.push(o)
                }
                if (f.length || r) {
                    var v = new qe(p, e ? f.concat.apply([], f) : f),
                        y = v.selector;
                    return y.rows = g.rows, y.cols = g.cols, y.opts = g.opts, v
                }
                return this
            },
            lastIndexOf: St.lastIndexOf || function(e, t) {
                return this.indexOf.apply(this.toArray.reverse(), arguments)
            },
            length: 0,
            map: function(e) {
                var t = [];
                if (St.map) t = St.map.call(this, e, this);
                else
                    for (var n = 0, i = this.length; n < i; n++) t.push(e.call(this, this[n], n));
                return new qe(this.context, t)
            },
            pluck: function(e) {
                return this.map(function(t) {
                    return t[e]
                })
            },
            pop: St.pop,
            push: St.push,
            reduce: St.reduce || function(e, t) {
                return c(this, e, t, 0, this.length, 1)
            },
            reduceRight: St.reduceRight || function(e, t) {
                return c(this, e, t, this.length - 1, -1, -1)
            },
            reverse: St.reverse,
            selector: null,
            shift: St.shift,
            sort: St.sort,
            splice: St.splice,
            toArray: function() {
                return St.slice.call(this)
            },
            to$: function() {
                return e(this)
            },
            toJQuery: function() {
                return e(this)
            },
            unique: function() {
                return new qe(this.context, ft(this))
            },
            unshift: St.unshift
        }), qe.extend = function(t, n, i) {
            if (i.length && n && (n instanceof qe || n.__dt_wrapper)) {
                var r, o, a, s = function(e, t, n) {
                    return function() {
                        var i = t.apply(e, arguments);
                        return qe.extend(i, i, n.methodExt), i
                    }
                };
                for (r = 0, o = i.length; r < o; r++) a = i[r], n[a.name] = "function" == typeof a.val ? s(t, a.val, a) : e.isPlainObject(a.val) ? {} : a.val, n[a.name].__dt_wrapper = !0, qe.extend(t, n[a.name], a.propExt)
            }
        }, qe.register = Ue = function(t, n) {
            if (e.isArray(t))
                for (var i = 0, r = t.length; i < r; i++) qe.register(t[i], n);
            else {
                var o, a, s, l, u = t.split("."),
                    c = Ct,
                    d = function(e, t) {
                        for (var n = 0, i = e.length; n < i; n++)
                            if (e[n].name === t) return e[n];
                        return null
                    };
                for (o = 0, a = u.length; o < a; o++) {
                    l = u[o].indexOf("()") !== -1, s = l ? u[o].replace("()", "") : u[o];
                    var h = d(c, s);
                    h || (h = {
                        name: s,
                        val: {},
                        methodExt: [],
                        propExt: []
                    }, c.push(h)), o === a - 1 ? h.val = n : c = l ? h.methodExt : h.propExt
                }
            }
        }, qe.registerPlural = Ve = function(t, n, r) {
            qe.register(t, r), qe.register(n, function() {
                var t = r.apply(this, arguments);
                return t === this ? this : t instanceof qe ? t.length ? e.isArray(t[0]) ? new qe(t.context, t[0]) : t[0] : i : t
            })
        };
        var kt = function(t, n) {
            if ("number" == typeof t) return [n[t]];
            var i = e.map(n, function(e, t) {
                return e.nTable
            });
            return e(i).filter(t).map(function(t) {
                var r = e.inArray(this, i);
                return n[r]
            }).toArray()
        };
        Ue("tables()", function(e) {
            return e ? new qe(kt(e, this.context)) : this
        }), Ue("table()", function(e) {
            var t = this.tables(e),
                n = t.context;
            return n.length ? new qe(n[0]) : t
        }), Ve("tables().nodes()", "table().node()", function() {
            return this.iterator("table", function(e) {
                return e.nTable
            }, 1)
        }), Ve("tables().body()", "table().body()", function() {
            return this.iterator("table", function(e) {
                return e.nTBody
            }, 1)
        }), Ve("tables().header()", "table().header()", function() {
            return this.iterator("table", function(e) {
                return e.nTHead
            }, 1)
        }), Ve("tables().footer()", "table().footer()", function() {
            return this.iterator("table", function(e) {
                return e.nTFoot
            }, 1)
        }), Ve("tables().containers()", "table().container()", function() {
            return this.iterator("table", function(e) {
                return e.nTableWrapper
            }, 1)
        }), Ue("draw()", function(e) {
            return this.iterator("table", function(t) {
                "page" === e ? H(t) : ("string" == typeof e && (e = "full-hold" !== e), O(t, e === !1))
            })
        }), Ue("page()", function(e) {
            return e === i ? this.page.info().page : this.iterator("table", function(t) {
                de(t, e)
            })
        }), Ue("page.info()", function(e) {
            if (0 === this.context.length) return i;
            var t = this.context[0],
                n = t._iDisplayStart,
                r = t.oFeatures.bPaginate ? t._iDisplayLength : -1,
                o = t.fnRecordsDisplay(),
                a = r === -1;
            return {
                page: a ? 0 : Math.floor(n / r),
                pages: a ? 1 : Math.ceil(o / r),
                start: n,
                end: t.fnDisplayEnd(),
                length: r,
                recordsTotal: t.fnRecordsTotal(),
                recordsDisplay: o,
                serverSide: "ssp" === Qe(t)
            }
        }), Ue("page.len()", function(e) {
            return e === i ? 0 !== this.context.length ? this.context[0]._iDisplayLength : i : this.iterator("table", function(t) {
                le(t, e)
            })
        });
        var Dt = function(e, t, n) {
            if (n) {
                var i = new qe(e);
                i.one("draw", function() {
                    n(i.ajax.json())
                })
            }
            if ("ssp" == Qe(e)) O(e, t);
            else {
                fe(e, !0);
                var r = e.jqXHR;
                r && 4 !== r.readyState && r.abort(), W(e, [], function(n) {
                    I(e);
                    for (var i = V(e, n), r = 0, o = i.length; r < o; r++) x(e, i[r]);
                    O(e, t), fe(e, !1)
                })
            }
        };
        Ue("ajax.json()", function() {
            var e = this.context;
            if (e.length > 0) return e[0].json
        }), Ue("ajax.params()", function() {
            var e = this.context;
            if (e.length > 0) return e[0].oAjaxData
        }), Ue("ajax.reload()", function(e, t) {
            return this.iterator("table", function(n) {
                Dt(n, t === !1, e)
            })
        }), Ue("ajax.url()", function(t) {
            var n = this.context;
            return t === i ? 0 === n.length ? i : (n = n[0], n.ajax ? e.isPlainObject(n.ajax) ? n.ajax.url : n.ajax : n.sAjaxSource) : this.iterator("table", function(n) {
                e.isPlainObject(n.ajax) ? n.ajax.url = t : n.ajax = t
            })
        }), Ue("ajax.url().load()", function(e, t) {
            return this.iterator("table", function(n) {
                Dt(n, t === !1, e)
            })
        });
        var _t = function(t, n, r, o, a) {
                var s, l, u, c, d, h, f = [],
                    p = typeof n;
                for (n && "string" !== p && "function" !== p && n.length !== i || (n = [n]), u = 0, c = n.length; u < c; u++)
                    for (l = n[u] && n[u].split ? n[u].split(",") : [n[u]], d = 0, h = l.length; d < h; d++) s = r("string" == typeof l[d] ? e.trim(l[d]) : l[d]), s && s.length && (f = f.concat(s));
                var g = ze.selector[t];
                if (g.length)
                    for (u = 0, c = g.length; u < c; u++) f = g[u](o, a, f);
                return ft(f)
            },
            jt = function(t) {
                return t || (t = {}), t.filter && t.search === i && (t.search = t.filter), e.extend({
                    search: "none",
                    order: "current",
                    page: "all"
                }, t)
            },
            At = function(e) {
                for (var t = 0, n = e.length; t < n; t++)
                    if (e[t].length > 0) return e[0] = e[t], e[0].length = 1, e.length = 1, e.context = [e.context[t]], e;
                return e.length = 0, e
            },
            It = function(t, n) {
                var i, r, o, a = [],
                    s = t.aiDisplay,
                    l = t.aiDisplayMaster,
                    u = n.search,
                    c = n.order,
                    d = n.page;
                if ("ssp" == Qe(t)) return "removed" === u ? [] : ct(0, l.length);
                if ("current" == d)
                    for (i = t._iDisplayStart, r = t.fnDisplayEnd(); i < r; i++) a.push(s[i]);
                else if ("current" == c || "applied" == c) a = "none" == u ? l.slice() : "applied" == u ? s.slice() : e.map(l, function(t, n) {
                    return e.inArray(t, s) === -1 ? t : null
                });
                else if ("index" == c || "original" == c)
                    for (i = 0, r = t.aoData.length; i < r; i++) "none" == u ? a.push(i) : (o = e.inArray(i, s), (o === -1 && "removed" == u || o >= 0 && "applied" == u) && a.push(i));
                return a
            },
            $t = function(t, n, r) {
                var o = function(n) {
                    var o = it(n);
                    if (null !== o && !r) return [o];
                    var a = It(t, r);
                    if (null !== o && e.inArray(o, a) !== -1) return [o];
                    if (!n) return a;
                    if ("function" == typeof n) return e.map(a, function(e) {
                        var i = t.aoData[e];
                        return n(e, i._aData, i.nTr) ? e : null
                    });
                    var s = dt(ut(t.aoData, a, "nTr"));
                    if (n.nodeName) {
                        if (n._DT_RowIndex !== i) return [n._DT_RowIndex];
                        if (n._DT_CellIndex) return [n._DT_CellIndex.row];
                        var l = e(n).closest("*[data-dt-row]");
                        return l.length ? [l.data("dt-row")] : []
                    }
                    if ("string" == typeof n && "#" === n.charAt(0)) {
                        var u = t.aIds[n.replace(/^#/, "")];
                        if (u !== i) return [u.idx]
                    }
                    return e(s).filter(n).map(function() {
                        return this._DT_RowIndex
                    }).toArray()
                };
                return _t("row", n, o, t, r)
            };
        Ue("rows()", function(t, n) {
            t === i ? t = "" : e.isPlainObject(t) && (n = t, t = ""), n = jt(n);
            var r = this.iterator("table", function(e) {
                return $t(e, t, n)
            }, 1);
            return r.selector.rows = t, r.selector.opts = n, r
        }), Ue("rows().nodes()", function() {
            return this.iterator("row", function(e, t) {
                return e.aoData[t].nTr || i
            }, 1)
        }), Ue("rows().data()", function() {
            return this.iterator(!0, "rows", function(e, t) {
                return ut(e.aoData, t, "_aData")
            }, 1)
        }), Ve("rows().cache()", "row().cache()", function(e) {
            return this.iterator("row", function(t, n) {
                var i = t.aoData[n];
                return "search" === e ? i._aFilterData : i._aSortData
            }, 1)
        }), Ve("rows().invalidate()", "row().invalidate()", function(e) {
            return this.iterator("row", function(t, n) {
                L(t, n, e)
            })
        }), Ve("rows().indexes()", "row().index()", function() {
            return this.iterator("row", function(e, t) {
                return t
            }, 1)
        }), Ve("rows().ids()", "row().id()", function(e) {
            for (var t = [], n = this.context, i = 0, r = n.length; i < r; i++)
                for (var o = 0, a = this[i].length; o < a; o++) {
                    var s = n[i].rowIdFn(n[i].aoData[this[i][o]]._aData);
                    t.push((e === !0 ? "#" : "") + s)
                }
            return new qe(n, t)
        }), Ve("rows().remove()", "row().remove()", function() {
            var e = this;
            return this.iterator("row", function(t, n, r) {
                var o, a, s, l, u, c, d = t.aoData,
                    h = d[n];
                for (d.splice(n, 1), o = 0, a = d.length; o < a; o++)
                    if (u = d[o], c = u.anCells, null !== u.nTr && (u.nTr._DT_RowIndex = o), null !== c)
                        for (s = 0, l = c.length; s < l; s++) c[s]._DT_CellIndex.row = o;
                $(t.aiDisplayMaster, n), $(t.aiDisplay, n), $(e[r], n, !1), He(t);
                var f = t.rowIdFn(h._aData);
                f !== i && delete t.aIds[f]
            }), this.iterator("table", function(e) {
                for (var t = 0, n = e.aoData.length; t < n; t++) e.aoData[t].idx = t
            }), this
        }), Ue("rows.add()", function(t) {
            var n = this.iterator("table", function(e) {
                    var n, i, r, o = [];
                    for (i = 0, r = t.length; i < r; i++) n = t[i], n.nodeName && "TR" === n.nodeName.toUpperCase() ? o.push(w(e, n)[0]) : o.push(x(e, n));
                    return o
                }, 1),
                i = this.rows(-1);
            return i.pop(), e.merge(i, n), i
        }), Ue("row()", function(e, t) {
            return At(this.rows(e, t))
        }), Ue("row().data()", function(e) {
            var t = this.context;
            return e === i ? t.length && this.length ? t[0].aoData[this[0]]._aData : i : (t[0].aoData[this[0]]._aData = e, L(t[0], this[0], "data"), this)
        }), Ue("row().node()", function() {
            var e = this.context;
            return e.length && this.length ? e[0].aoData[this[0]].nTr || null : null
        }), Ue("row.add()", function(t) {
            t instanceof e && t.length && (t = t[0]);
            var n = this.iterator("table", function(e) {
                return t.nodeName && "TR" === t.nodeName.toUpperCase() ? w(e, t)[0] : x(e, t)
            });
            return this.row(n[0])
        });
        var Lt = function(t, n, i, r) {
                var o = [],
                    a = function(n, i) {
                        if (e.isArray(n) || n instanceof e)
                            for (var r = 0, s = n.length; r < s; r++) a(n[r], i);
                        else if (n.nodeName && "tr" === n.nodeName.toLowerCase()) o.push(n);
                        else {
                            var l = e("<tr><td/></tr>").addClass(i);
                            e("td", l).addClass(i).html(n)[0].colSpan = m(t), o.push(l[0])
                        }
                    };
                a(i, r), n._details && n._details.remove(), n._details = e(o), n._detailsShow && n._details.insertAfter(n.nTr)
            },
            Nt = function(e, t) {
                var n = e.context;
                if (n.length) {
                    var r = n[0].aoData[t !== i ? t : e[0]];
                    r && r._details && (r._details.remove(), r._detailsShow = i, r._details = i)
                }
            },
            Et = function(e, t) {
                var n = e.context;
                if (n.length && e.length) {
                    var i = n[0].aoData[e[0]];
                    i._details && (i._detailsShow = t, t ? i._details.insertAfter(i.nTr) : i._details.detach(), Rt(n[0]))
                }
            },
            Rt = function(e) {
                var t = new qe(e),
                    n = ".dt.DT_details",
                    i = "draw" + n,
                    r = "column-visibility" + n,
                    o = "destroy" + n,
                    a = e.aoData;
                t.off(i + " " + r + " " + o), lt(a, "_details").length > 0 && (t.on(i, function(n, i) {
                    e === i && t.rows({
                        page: "current"
                    }).eq(0).each(function(e) {
                        var t = a[e];
                        t._detailsShow && t._details.insertAfter(t.nTr)
                    })
                }), t.on(r, function(t, n, i, r) {
                    if (e === n)
                        for (var o, s = m(n), l = 0, u = a.length; l < u; l++) o = a[l], o._details && o._details.children("td[colspan]").attr("colspan", s)
                }), t.on(o, function(n, i) {
                    if (e === i)
                        for (var r = 0, o = a.length; r < o; r++) a[r]._details && Nt(t, r)
                }))
            },
            Pt = "",
            Ft = Pt + "row().child",
            Ht = Ft + "()";
        Ue(Ht, function(e, t) {
            var n = this.context;
            return e === i ? n.length && this.length ? n[0].aoData[this[0]]._details : i : (e === !0 ? this.child.show() : e === !1 ? Nt(this) : n.length && this.length && Lt(n[0], n[0].aoData[this[0]], e, t), this)
        }), Ue([Ft + ".show()", Ht + ".show()"], function(e) {
            return Et(this, !0), this
        }), Ue([Ft + ".hide()", Ht + ".hide()"], function() {
            return Et(this, !1), this
        }), Ue([Ft + ".remove()", Ht + ".remove()"], function() {
            return Nt(this), this
        }), Ue(Ft + ".isShown()", function() {
            var e = this.context;
            return !(!e.length || !this.length) && (e[0].aoData[this[0]]._detailsShow || !1)
        });
        var Ot = /^(.+):(name|visIdx|visible)$/,
            Qt = function(e, t, n, i, r) {
                for (var o = [], a = 0, s = r.length; a < s; a++) o.push(T(e, r[a], t));
                return o
            },
            Bt = function(t, n, i) {
                var r = t.aoColumns,
                    o = lt(r, "sName"),
                    a = lt(r, "nTh"),
                    s = function(n) {
                        var s = it(n);
                        if ("" === n) return ct(r.length);
                        if (null !== s) return [s >= 0 ? s : r.length + s];
                        if ("function" == typeof n) {
                            var l = It(t, i);
                            return e.map(r, function(e, i) {
                                return n(i, Qt(t, i, 0, 0, l), a[i]) ? i : null
                            })
                        }
                        var u = "string" == typeof n ? n.match(Ot) : "";
                        if (u) switch (u[2]) {
                            case "visIdx":
                            case "visible":
                                var c = parseInt(u[1], 10);
                                if (c < 0) {
                                    var d = e.map(r, function(e, t) {
                                        return e.bVisible ? t : null
                                    });
                                    return [d[d.length + c]]
                                }
                                return [p(t, c)];
                            case "name":
                                return e.map(o, function(e, t) {
                                    return e === u[1] ? t : null
                                });
                            default:
                                return []
                        }
                        if (n.nodeName && n._DT_CellIndex) return [n._DT_CellIndex.column];
                        var h = e(a).filter(n).map(function() {
                            return e.inArray(this, a)
                        }).toArray();
                        if (h.length || !n.nodeName) return h;
                        var f = e(n).closest("*[data-dt-column]");
                        return f.length ? [f.data("dt-column")] : []
                    };
                return _t("column", n, s, t, i)
            },
            Mt = function(t, n, r) {
                var o, a, s, l, u = t.aoColumns,
                    c = u[n],
                    d = t.aoData;
                if (r === i) return c.bVisible;
                if (c.bVisible !== r) {
                    if (r) {
                        var h = e.inArray(!0, lt(u, "bVisible"), n + 1);
                        for (a = 0, s = d.length; a < s; a++) l = d[a].nTr, o = d[a].anCells, l && l.insertBefore(o[n], o[h] || null)
                    } else e(lt(t.aoData, "anCells", n)).detach();
                    c.bVisible = r, F(t, t.aoHeader), F(t, t.aoFooter), Ae(t)
                }
            };
        Ue("columns()", function(t, n) {
            t === i ? t = "" : e.isPlainObject(t) && (n = t, t = ""), n = jt(n);
            var r = this.iterator("table", function(e) {
                return Bt(e, t, n)
            }, 1);
            return r.selector.cols = t, r.selector.opts = n, r
        }), Ve("columns().header()", "column().header()", function(e, t) {
            return this.iterator("column", function(e, t) {
                return e.aoColumns[t].nTh
            }, 1)
        }), Ve("columns().footer()", "column().footer()", function(e, t) {
            return this.iterator("column", function(e, t) {
                return e.aoColumns[t].nTf
            }, 1)
        }), Ve("columns().data()", "column().data()", function() {
            return this.iterator("column-rows", Qt, 1)
        }), Ve("columns().dataSrc()", "column().dataSrc()", function() {
            return this.iterator("column", function(e, t) {
                return e.aoColumns[t].mData
            }, 1)
        }), Ve("columns().cache()", "column().cache()", function(e) {
            return this.iterator("column-rows", function(t, n, i, r, o) {
                return ut(t.aoData, o, "search" === e ? "_aFilterData" : "_aSortData", n)
            }, 1)
        }), Ve("columns().nodes()", "column().nodes()", function() {
            return this.iterator("column-rows", function(e, t, n, i, r) {
                return ut(e.aoData, r, "anCells", t)
            }, 1)
        }), Ve("columns().visible()", "column().visible()", function(e, t) {
            var n = this.iterator("column", function(t, n) {
                return e === i ? t.aoColumns[n].bVisible : void Mt(t, n, e)
            });
            return e !== i && (this.iterator("column", function(n, i) {
                Fe(n, null, "column-visibility", [n, i, e, t])
            }), (t === i || t) && this.columns.adjust()), n
        }), Ve("columns().indexes()", "column().index()", function(e) {
            return this.iterator("column", function(t, n) {
                return "visible" === e ? g(t, n) : n
            }, 1)
        }), Ue("columns.adjust()", function() {
            return this.iterator("table", function(e) {
                f(e)
            }, 1)
        }), Ue("column.index()", function(e, t) {
            if (0 !== this.context.length) {
                var n = this.context[0];
                if ("fromVisible" === e || "toData" === e) return p(n, t);
                if ("fromData" === e || "toVisible" === e) return g(n, t)
            }
        }), Ue("column()", function(e, t) {
            return At(this.columns(e, t))
        });
        var Wt = function(t, n, r) {
            var o, a, s, l, u, c, d, h = t.aoData,
                f = It(t, r),
                p = dt(ut(h, f, "anCells")),
                g = e([].concat.apply([], p)),
                m = t.aoColumns.length,
                v = function(n) {
                    var r = "function" == typeof n;
                    if (null === n || n === i || r) {
                        for (a = [], s = 0, l = f.length; s < l; s++)
                            for (o = f[s], u = 0; u < m; u++) c = {
                                row: o,
                                column: u
                            }, r ? (d = h[o], n(c, T(t, o, u), d.anCells ? d.anCells[u] : null) && a.push(c)) : a.push(c);
                        return a
                    }
                    if (e.isPlainObject(n)) return [n];
                    var p = g.filter(n).map(function(e, t) {
                        return {
                            row: t._DT_CellIndex.row,
                            column: t._DT_CellIndex.column
                        }
                    }).toArray();
                    return p.length || !n.nodeName ? p : (d = e(n).closest("*[data-dt-row]"), d.length ? [{
                        row: d.data("dt-row"),
                        column: d.data("dt-column")
                    }] : [])
                };
            return _t("cell", n, v, t, r)
        };
        Ue("cells()", function(t, n, r) {
                if (e.isPlainObject(t) && (t.row === i ? (r = t, t = null) : (r = n, n = null)), e.isPlainObject(n) && (r = n, n = null), null === n || n === i) return this.iterator("table", function(e) {
                    return Wt(e, t, jt(r))
                });
                var o, a, s, l, u, c = this.columns(n, r),
                    d = this.rows(t, r),
                    h = this.iterator("table", function(e, t) {
                        for (o = [], a = 0, s = d[t].length; a < s; a++)
                            for (l = 0, u = c[t].length; l < u; l++) o.push({
                                row: d[t][a],
                                column: c[t][l]
                            });
                        return o
                    }, 1);
                return e.extend(h.selector, {
                    cols: n,
                    rows: t,
                    opts: r
                }), h
            }), Ve("cells().nodes()", "cell().node()", function() {
                return this.iterator("cell", function(e, t, n) {
                    var r = e.aoData[t];
                    return r && r.anCells ? r.anCells[n] : i
                }, 1)
            }), Ue("cells().data()", function() {
                return this.iterator("cell", function(e, t, n) {
                    return T(e, t, n)
                }, 1)
            }), Ve("cells().cache()", "cell().cache()", function(e) {
                return e = "search" === e ? "_aFilterData" : "_aSortData", this.iterator("cell", function(t, n, i) {
                    return t.aoData[n][e][i]
                }, 1)
            }), Ve("cells().render()", "cell().render()", function(e) {
                return this.iterator("cell", function(t, n, i) {
                    return T(t, n, i, e)
                }, 1)
            }), Ve("cells().indexes()", "cell().index()", function() {
                return this.iterator("cell", function(e, t, n) {
                    return {
                        row: t,
                        column: n,
                        columnVisible: g(e, n)
                    }
                }, 1)
            }), Ve("cells().invalidate()", "cell().invalidate()", function(e) {
                return this.iterator("cell", function(t, n, i) {
                    L(t, n, e, i)
                })
            }), Ue("cell()", function(e, t, n) {
                return At(this.cells(e, t, n))
            }), Ue("cell().data()", function(e) {
                var t = this.context,
                    n = this[0];
                return e === i ? t.length && n.length ? T(t[0], n[0].row, n[0].column) : i : (k(t[0], n[0].row, n[0].column, e), L(t[0], n[0].row, "data", n[0].column), this)
            }), Ue("order()", function(t, n) {
                var r = this.context;
                return t === i ? 0 !== r.length ? r[0].aaSorting : i : ("number" == typeof t ? t = [
                    [t, n]
                ] : t.length && !e.isArray(t[0]) && (t = Array.prototype.slice.call(arguments)), this.iterator("table", function(e) {
                    e.aaSorting = t.slice()
                }))
            }), Ue("order.listener()", function(e, t, n) {
                return this.iterator("table", function(i) {
                    De(i, e, t, n)
                })
            }), Ue("order.fixed()", function(t) {
                if (!t) {
                    var n = this.context,
                        r = n.length ? n[0].aaSortingFixed : i;
                    return e.isArray(r) ? {
                        pre: r
                    } : r
                }
                return this.iterator("table", function(n) {
                    n.aaSortingFixed = e.extend(!0, {}, t)
                })
            }), Ue(["columns().order()", "column().order()"], function(t) {
                var n = this;
                return this.iterator("table", function(i, r) {
                    var o = [];
                    e.each(n[r], function(e, n) {
                        o.push([n, t])
                    }), i.aaSorting = o
                })
            }), Ue("search()", function(t, n, r, o) {
                var a = this.context;
                return t === i ? 0 !== a.length ? a[0].oPreviousSearch.sSearch : i : this.iterator("table", function(i) {
                    i.oFeatures.bFilter && J(i, e.extend({}, i.oPreviousSearch, {
                        sSearch: t + "",
                        bRegex: null !== n && n,
                        bSmart: null === r || r,
                        bCaseInsensitive: null === o || o
                    }), 1)
                })
            }), Ve("columns().search()", "column().search()", function(t, n, r, o) {
                return this.iterator("column", function(a, s) {
                    var l = a.aoPreSearchCols;
                    return t === i ? l[s].sSearch : void(a.oFeatures.bFilter && (e.extend(l[s], {
                        sSearch: t + "",
                        bRegex: null !== n && n,
                        bSmart: null === r || r,
                        bCaseInsensitive: null === o || o
                    }), J(a, a.oPreviousSearch, 1)))
                })
            }), Ue("state()", function() {
                return this.context.length ? this.context[0].oSavedState : null
            }), Ue("state.clear()", function() {
                return this.iterator("table", function(e) {
                    e.fnStateSaveCallback.call(e.oInstance, e, {})
                })
            }), Ue("state.loaded()", function() {
                return this.context.length ? this.context[0].oLoadedState : null
            }), Ue("state.save()", function() {
                return this.iterator("table", function(e) {
                    Ae(e)
                })
            }), Xe.versionCheck = Xe.fnVersionCheck = function(e) {
                for (var t, n, i = Xe.version.split("."), r = e.split("."), o = 0, a = r.length; o < a; o++)
                    if (t = parseInt(i[o], 10) || 0, n = parseInt(r[o], 10) || 0, t !== n) return t > n;
                return !0
            }, Xe.isDataTable = Xe.fnIsDataTable = function(t) {
                var n = e(t).get(0),
                    i = !1;
                return e.each(Xe.settings, function(t, r) {
                    var o = r.nScrollHead ? e("table", r.nScrollHead)[0] : null,
                        a = r.nScrollFoot ? e("table", r.nScrollFoot)[0] : null;
                    r.nTable !== n && o !== n && a !== n || (i = !0)
                }), i
            }, Xe.tables = Xe.fnTables = function(t) {
                var n = !1;
                e.isPlainObject(t) && (n = t.api, t = t.visible);
                var i = e.map(Xe.settings, function(n) {
                    if (!t || t && e(n.nTable).is(":visible")) return n.nTable
                });
                return n ? new qe(i) : i
            }, Xe.camelToHungarian = o, Ue("$()", function(t, n) {
                var i = this.rows(n).nodes(),
                    r = e(i);
                return e([].concat(r.filter(t).toArray(), r.find(t).toArray()))
            }), e.each(["on", "one", "off"], function(t, n) {
                Ue(n + "()", function() {
                    var t = Array.prototype.slice.call(arguments);
                    t[0].match(/\.dt\b/) || (t[0] += ".dt");
                    var i = e(this.tables().nodes());
                    return i[n].apply(i, t), this
                })
            }), Ue("clear()", function() {
                return this.iterator("table", function(e) {
                    I(e)
                })
            }), Ue("settings()", function() {
                return new qe(this.context, this.context)
            }), Ue("init()", function() {
                var e = this.context;
                return e.length ? e[0].oInit : null
            }), Ue("data()", function() {
                return this.iterator("table", function(e) {
                    return lt(e.aoData, "_aData")
                }).flatten()
            }), Ue("destroy()", function(n) {
                return n = n || !1, this.iterator("table", function(i) {
                    var r, o = i.nTableWrapper.parentNode,
                        a = i.oClasses,
                        s = i.nTable,
                        l = i.nTBody,
                        u = i.nTHead,
                        c = i.nTFoot,
                        d = e(s),
                        h = e(l),
                        f = e(i.nTableWrapper),
                        p = e.map(i.aoData, function(e) {
                            return e.nTr
                        });
                    i.bDestroying = !0, Fe(i, "aoDestroyCallback", "destroy", [i]), n || new qe(i).columns().visible(!0), f.unbind(".DT").find(":not(tbody *)").unbind(".DT"), e(t).unbind(".DT-" + i.sInstance), s != u.parentNode && (d.children("thead").detach(), d.append(u)), c && s != c.parentNode && (d.children("tfoot").detach(), d.append(c)), i.aaSorting = [], i.aaSortingFixed = [], _e(i), e(p).removeClass(i.asStripeClasses.join(" ")), e("th, td", u).removeClass(a.sSortable + " " + a.sSortableAsc + " " + a.sSortableDesc + " " + a.sSortableNone), i.bJUI && (e("th span." + a.sSortIcon + ", td span." + a.sSortIcon, u).detach(), e("th, td", u).each(function() {
                        var t = e("div." + a.sSortJUIWrapper, this);
                        e(this).append(t.contents()), t.detach()
                    })), h.children().detach(), h.append(p);
                    var g = n ? "remove" : "detach";
                    d[g](), f[g](), !n && o && (o.insertBefore(s, i.nTableReinsertBefore), d.css("width", i.sDestroyWidth).removeClass(a.sTable), r = i.asDestroyStripes.length, r && h.children().each(function(t) {
                        e(this).addClass(i.asDestroyStripes[t % r])
                    }));
                    var m = e.inArray(i, Xe.settings);
                    m !== -1 && Xe.settings.splice(m, 1)
                })
            }), e.each(["column", "row", "cell"], function(e, t) {
                Ue(t + "s().every()", function(e) {
                    var n = this.selector.opts,
                        r = this;
                    return this.iterator(t, function(o, a, s, l, u) {
                        e.call(r[t](a, "cell" === t ? s : n, "cell" === t ? n : i), a, s, l, u)
                    })
                })
            }), Ue("i18n()", function(t, n, r) {
                var o = this.context[0],
                    a = _(t)(o.oLanguage);
                return a === i && (a = n), r !== i && e.isPlainObject(a) && (a = a[r] !== i ? a[r] : a._), a.replace("%d", r)
            }), Xe.version = "1.10.12", Xe.settings = [], Xe.models = {}, Xe.models.oSearch = {
                bCaseInsensitive: !0,
                sSearch: "",
                bRegex: !1,
                bSmart: !0
            }, Xe.models.oRow = {
                nTr: null,
                anCells: null,
                _aData: [],
                _aSortData: null,
                _aFilterData: null,
                _sFilterRow: null,
                _sRowStripe: "",
                src: null,
                idx: -1
            }, Xe.models.oColumn = {
                idx: null,
                aDataSort: null,
                asSorting: null,
                bSearchable: null,
                bSortable: null,
                bVisible: null,
                _sManualType: null,
                _bAttrSrc: !1,
                fnCreatedCell: null,
                fnGetData: null,
                fnSetData: null,
                mData: null,
                mRender: null,
                nTh: null,
                nTf: null,
                sClass: null,
                sContentPadding: null,
                sDefaultContent: null,
                sName: null,
                sSortDataType: "std",
                sSortingClass: null,
                sSortingClassJUI: null,
                sTitle: null,
                sType: null,
                sWidth: null,
                sWidthOrig: null
            }, Xe.defaults = {
                aaData: null,
                aaSorting: [
                    [0, "asc"]
                ],
                aaSortingFixed: [],
                ajax: null,
                aLengthMenu: [10, 25, 50, 100],
                aoColumns: null,
                aoColumnDefs: null,
                aoSearchCols: [],
                asStripeClasses: null,
                bAutoWidth: !0,
                bDeferRender: !1,
                bDestroy: !1,
                bFilter: !0,
                bInfo: !0,
                bJQueryUI: !1,
                bLengthChange: !0,
                bPaginate: !0,
                bProcessing: !1,
                bRetrieve: !1,
                bScrollCollapse: !1,
                bServerSide: !1,
                bSort: !0,
                bSortMulti: !0,
                bSortCellsTop: !1,
                bSortClasses: !0,
                bStateSave: !1,
                fnCreatedRow: null,
                fnDrawCallback: null,
                fnFooterCallback: null,
                fnFormatNumber: function(e) {
                    return e.toString().replace(/\B(?=(\d{3})+(?!\d))/g, this.oLanguage.sThousands)
                },
                fnHeaderCallback: null,
                fnInfoCallback: null,
                fnInitComplete: null,
                fnPreDrawCallback: null,
                fnRowCallback: null,
                fnServerData: null,
                fnServerParams: null,
                fnStateLoadCallback: function(e) {
                    try {
                        return JSON.parse((e.iStateDuration === -1 ? sessionStorage : localStorage).getItem("DataTables_" + e.sInstance + "_" + location.pathname))
                    } catch (e) {}
                },
                fnStateLoadParams: null,
                fnStateLoaded: null,
                fnStateSaveCallback: function(e, t) {
                    try {
                        (e.iStateDuration === -1 ? sessionStorage : localStorage).setItem("DataTables_" + e.sInstance + "_" + location.pathname, JSON.stringify(t))
                    } catch (e) {}
                },
                fnStateSaveParams: null,
                iStateDuration: 7200,
                iDeferLoading: null,
                iDisplayLength: 10,
                iDisplayStart: 0,
                iTabIndex: 0,
                oClasses: {},
                oLanguage: {
                    oAria: {
                        sSortAscending: ": activate to sort column ascending",
                        sSortDescending: ": activate to sort column descending"
                    },
                    oPaginate: {
                        sFirst: "First",
                        sLast: "Last",
                        sNext: "Next",
                        sPrevious: "Previous"
                    },
                    sEmptyTable: "No data available in table",
                    sInfo: "Showing _START_ to _END_ of _TOTAL_ entries",
                    sInfoEmpty: "Showing 0 to 0 of 0 entries",
                    sInfoFiltered: "(filtered from _MAX_ total entries)",
                    sInfoPostFix: "",
                    sDecimal: "",
                    sThousands: ",",
                    sLengthMenu: "Show _MENU_ entries",
                    sLoadingRecords: "Loading...",
                    sProcessing: "Processing...",
                    sSearch: "Search:",
                    sSearchPlaceholder: "",
                    sUrl: "",
                    sZeroRecords: "No matching records found"
                },
                oSearch: e.extend({}, Xe.models.oSearch),
                sAjaxDataProp: "data",
                sAjaxSource: null,
                sDom: "lfrtip",
                searchDelay: null,
                sPaginationType: "simple_numbers",
                sScrollX: "",
                sScrollXInner: "",
                sScrollY: "",
                sServerMethod: "GET",
                renderer: null,
                rowId: "DT_RowId"
            }, r(Xe.defaults), Xe.defaults.column = {
                aDataSort: null,
                iDataSort: -1,
                asSorting: ["asc", "desc"],
                bSearchable: !0,
                bSortable: !0,
                bVisible: !0,
                fnCreatedCell: null,
                mData: null,
                mRender: null,
                sCellType: "td",
                sClass: "",
                sContentPadding: "",
                sDefaultContent: null,
                sName: "",
                sSortDataType: "std",
                sTitle: null,
                sType: null,
                sWidth: null
            }, r(Xe.defaults.column), Xe.models.oSettings = {
                oFeatures: {
                    bAutoWidth: null,
                    bDeferRender: null,
                    bFilter: null,
                    bInfo: null,
                    bLengthChange: null,
                    bPaginate: null,
                    bProcessing: null,
                    bServerSide: null,
                    bSort: null,
                    bSortMulti: null,
                    bSortClasses: null,
                    bStateSave: null
                },
                oScroll: {
                    bCollapse: null,
                    iBarWidth: 0,
                    sX: null,
                    sXInner: null,
                    sY: null
                },
                oLanguage: {
                    fnInfoCallback: null
                },
                oBrowser: {
                    bScrollOversize: !1,
                    bScrollbarLeft: !1,
                    bBounding: !1,
                    barWidth: 0
                },
                ajax: null,
                aanFeatures: [],
                aoData: [],
                aiDisplay: [],
                aiDisplayMaster: [],
                aIds: {},
                aoColumns: [],
                aoHeader: [],
                aoFooter: [],
                oPreviousSearch: {},
                aoPreSearchCols: [],
                aaSorting: null,
                aaSortingFixed: [],
                asStripeClasses: null,
                asDestroyStripes: [],
                sDestroyWidth: 0,
                aoRowCallback: [],
                aoHeaderCallback: [],
                aoFooterCallback: [],
                aoDrawCallback: [],
                aoRowCreatedCallback: [],
                aoPreDrawCallback: [],
                aoInitComplete: [],
                aoStateSaveParams: [],
                aoStateLoadParams: [],
                aoStateLoaded: [],
                sTableId: "",
                nTable: null,
                nTHead: null,
                nTFoot: null,
                nTBody: null,
                nTableWrapper: null,
                bDeferLoading: !1,
                bInitialised: !1,
                aoOpenRows: [],
                sDom: null,
                searchDelay: null,
                sPaginationType: "two_button",
                iStateDuration: 0,
                aoStateSave: [],
                aoStateLoad: [],
                oSavedState: null,
                oLoadedState: null,
                sAjaxSource: null,
                sAjaxDataProp: null,
                bAjaxDataGet: !0,
                jqXHR: null,
                json: i,
                oAjaxData: i,
                fnServerData: null,
                aoServerParams: [],
                sServerMethod: null,
                fnFormatNumber: null,
                aLengthMenu: null,
                iDraw: 0,
                bDrawing: !1,
                iDrawError: -1,
                _iDisplayLength: 10,
                _iDisplayStart: 0,
                _iRecordsTotal: 0,
                _iRecordsDisplay: 0,
                bJUI: null,
                oClasses: {},
                bFiltered: !1,
                bSorted: !1,
                bSortCellsTop: null,
                oInit: null,
                aoDestroyCallback: [],
                fnRecordsTotal: function() {
                    return "ssp" == Qe(this) ? 1 * this._iRecordsTotal : this.aiDisplayMaster.length
                },
                fnRecordsDisplay: function() {
                    return "ssp" == Qe(this) ? 1 * this._iRecordsDisplay : this.aiDisplay.length
                },
                fnDisplayEnd: function() {
                    var e = this._iDisplayLength,
                        t = this._iDisplayStart,
                        n = t + e,
                        i = this.aiDisplay.length,
                        r = this.oFeatures,
                        o = r.bPaginate;
                    return r.bServerSide ? o === !1 || e === -1 ? t + i : Math.min(t + e, this._iRecordsDisplay) : !o || n > i || e === -1 ? i : n
                },
                oInstance: null,
                sInstance: null,
                iTabIndex: 0,
                nScrollHead: null,
                nScrollFoot: null,
                aLastSort: [],
                oPlugins: {},
                rowIdFn: null,
                rowId: null
            }, Xe.ext = ze = {
                buttons: {},
                classes: {},
                builder: "-source-",
                errMode: "alert",
                feature: [],
                search: [],
                selector: {
                    cell: [],
                    column: [],
                    row: []
                },
                internal: {},
                legacy: {
                    ajax: null
                },
                pager: {},
                renderer: {
                    pageButton: {},
                    header: {}
                },
                order: {},
                type: {
                    detect: [],
                    search: {},
                    order: {}
                },
                _unique: 0,
                fnVersionCheck: Xe.fnVersionCheck,
                iApiIndex: 0,
                oJUIClasses: {},
                sVersion: Xe.version
            }, e.extend(ze, {
                afnFiltering: ze.search,
                aTypes: ze.type.detect,
                ofnSearch: ze.type.search,
                oSort: ze.type.order,
                afnSortData: ze.order,
                aoFeatures: ze.feature,
                oApi: ze.internal,
                oStdClasses: ze.classes,
                oPagination: ze.pager
            }), e.extend(Xe.ext.classes, {
                sTable: "dataTable",
                sNoFooter: "no-footer",
                sPageButton: "paginate_button",
                sPageButtonActive: "current",
                sPageButtonDisabled: "disabled",
                sStripeOdd: "odd",
                sStripeEven: "even",
                sRowEmpty: "dataTables_empty",
                sWrapper: "dataTables_wrapper",
                sFilter: "dataTables_filter",
                sInfo: "dataTables_info",
                sPaging: "dataTables_paginate paging_",
                sLength: "dataTables_length",
                sProcessing: "dataTables_processing",
                sSortAsc: "sorting_asc",
                sSortDesc: "sorting_desc",
                sSortable: "sorting",
                sSortableAsc: "sorting_asc_disabled",
                sSortableDesc: "sorting_desc_disabled",
                sSortableNone: "sorting_disabled",
                sSortColumn: "sorting_",
                sFilterInput: "",
                sLengthSelect: "",
                sScrollWrapper: "dataTables_scroll",
                sScrollHead: "dataTables_scrollHead",
                sScrollHeadInner: "dataTables_scrollHeadInner",
                sScrollBody: "dataTables_scrollBody",
                sScrollFoot: "dataTables_scrollFoot",
                sScrollFootInner: "dataTables_scrollFootInner",
                sHeaderTH: "",
                sFooterTH: "",
                sSortJUIAsc: "",
                sSortJUIDesc: "",
                sSortJUI: "",
                sSortJUIAscAllowed: "",
                sSortJUIDescAllowed: "",
                sSortJUIWrapper: "",
                sSortIcon: "",
                sJUIHeader: "",
                sJUIFooter: ""
            }),
            function() {
                var t = "";
                t = "";
                var n = t + "ui-state-default",
                    i = t + "css_right ui-icon ui-icon-",
                    r = t + "fg-toolbar ui-toolbar ui-widget-header ui-helper-clearfix";
                e.extend(Xe.ext.oJUIClasses, Xe.ext.classes, {
                    sPageButton: "fg-button ui-button " + n,
                    sPageButtonActive: "ui-state-disabled",
                    sPageButtonDisabled: "ui-state-disabled",
                    sPaging: "dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_",
                    sSortAsc: n + " sorting_asc",
                    sSortDesc: n + " sorting_desc",
                    sSortable: n + " sorting",
                    sSortableAsc: n + " sorting_asc_disabled",
                    sSortableDesc: n + " sorting_desc_disabled",
                    sSortableNone: n + " sorting_disabled",
                    sSortJUIAsc: i + "triangle-1-n",
                    sSortJUIDesc: i + "triangle-1-s",
                    sSortJUI: i + "carat-2-n-s",
                    sSortJUIAscAllowed: i + "carat-1-n",
                    sSortJUIDescAllowed: i + "carat-1-s",
                    sSortJUIWrapper: "DataTables_sort_wrapper",
                    sSortIcon: "DataTables_sort_icon",
                    sScrollHead: "dataTables_scrollHead " + n,
                    sScrollFoot: "dataTables_scrollFoot " + n,
                    sHeaderTH: n,
                    sFooterTH: n,
                    sJUIHeader: r + " ui-corner-tl ui-corner-tr",
                    sJUIFooter: r + " ui-corner-bl ui-corner-br"
                })
            }();
        var zt = Xe.ext.pager;
        e.extend(zt, {
            simple: function(e, t) {
                return ["previous", "next"]
            },
            full: function(e, t) {
                return ["first", "previous", "next", "last"]
            },
            numbers: function(e, t) {
                return [Be(e, t)]
            },
            simple_numbers: function(e, t) {
                return ["previous", Be(e, t), "next"]
            },
            full_numbers: function(e, t) {
                return ["first", "previous", Be(e, t), "next", "last"]
            },
            _numbers: Be,
            numbers_length: 7
        }), e.extend(!0, Xe.ext.renderer, {
            pageButton: {
                _: function(t, i, r, o, a, s) {
                    var l, u, c, d = t.oClasses,
                        h = t.oLanguage.oPaginate,
                        f = t.oLanguage.oAria.paginate || {},
                        p = 0,
                        g = function(n, i) {
                            var o, c, m, v, y = function(e) {
                                de(t, e.data.action, !0)
                            };
                            for (o = 0, c = i.length; o < c; o++)
                                if (v = i[o], e.isArray(v)) {
                                    var b = e("<" + (v.DT_el || "div") + "/>").appendTo(n);
                                    g(b, v)
                                } else {
                                    switch (l = null, u = "", v) {
                                        case "ellipsis":
                                            n.append('<span class="ellipsis">&#x2026;</span>');
                                            break;
                                        case "first":
                                            l = h.sFirst, u = v + (a > 0 ? "" : " " + d.sPageButtonDisabled);
                                            break;
                                        case "previous":
                                            l = h.sPrevious, u = v + (a > 0 ? "" : " " + d.sPageButtonDisabled);
                                            break;
                                        case "next":
                                            l = h.sNext, u = v + (a < s - 1 ? "" : " " + d.sPageButtonDisabled);
                                            break;
                                        case "last":
                                            l = h.sLast, u = v + (a < s - 1 ? "" : " " + d.sPageButtonDisabled);
                                            break;
                                        default:
                                            l = v + 1, u = a === v ? d.sPageButtonActive : ""
                                    }
                                    null !== l && (m = e("<a>", {
                                        class: d.sPageButton + " " + u,
                                        "aria-controls": t.sTableId,
                                        "aria-label": f[v],
                                        "data-dt-idx": p,
                                        tabindex: t.iTabIndex,
                                        id: 0 === r && "string" == typeof v ? t.sTableId + "_" + v : null
                                    }).html(l).appendTo(n), Re(m, {
                                        action: v
                                    }, y), p++)
                                }
                        };
                    try {
                        c = e(i).find(n.activeElement).data("dt-idx")
                    } catch (e) {}
                    g(e(i).empty(), o), c && e(i).find("[data-dt-idx=" + c + "]").focus()
                }
            }
        }), e.extend(Xe.ext.type.detect, [function(e, t) {
            var n = t.oLanguage.sDecimal;
            return ot(e, n) ? "num" + n : null
        }, function(e, t) {
            if (e && !(e instanceof Date) && (!Ye.test(e) || !Ze.test(e))) return null;
            var n = Date.parse(e);
            return null !== n && !isNaN(n) || nt(e) ? "date" : null
        }, function(e, t) {
            var n = t.oLanguage.sDecimal;
            return ot(e, n, !0) ? "num-fmt" + n : null
        }, function(e, t) {
            var n = t.oLanguage.sDecimal;
            return st(e, n) ? "html-num" + n : null
        }, function(e, t) {
            var n = t.oLanguage.sDecimal;
            return st(e, n, !0) ? "html-num-fmt" + n : null
        }, function(e, t) {
            return nt(e) || "string" == typeof e && e.indexOf("<") !== -1 ? "html" : null
        }]), e.extend(Xe.ext.type.search, {
            html: function(e) {
                return nt(e) ? e : "string" == typeof e ? e.replace(Ge, " ").replace(Ke, "") : ""
            },
            string: function(e) {
                return nt(e) ? e : "string" == typeof e ? e.replace(Ge, " ") : e
            }
        });
        var qt = function(e, t, n, i) {
            return 0 === e || e && "-" !== e ? (t && (e = rt(e, t)), e.replace && (n && (e = e.replace(n, "")), i && (e = e.replace(i, ""))), 1 * e) : -(1 / 0)
        };
        e.extend(ze.type.order, {
            "date-pre": function(e) {
                return Date.parse(e) || 0
            },
            "html-pre": function(e) {
                return nt(e) ? "" : e.replace ? e.replace(/<.*?>/g, "").toLowerCase() : e + ""
            },
            "string-pre": function(e) {
                return nt(e) ? "" : "string" == typeof e ? e.toLowerCase() : e.toString ? e.toString() : ""
            },
            "string-asc": function(e, t) {
                return e < t ? -1 : e > t ? 1 : 0
            },
            "string-desc": function(e, t) {
                return e < t ? 1 : e > t ? -1 : 0
            }
        }), Me(""), e.extend(!0, Xe.ext.renderer, {
            header: {
                _: function(t, n, i, r) {
                    e(t.nTable).on("order.dt.DT", function(e, o, a, s) {
                        if (t === o) {
                            var l = i.idx;
                            n.removeClass(i.sSortingClass + " " + r.sSortAsc + " " + r.sSortDesc).addClass("asc" == s[l] ? r.sSortAsc : "desc" == s[l] ? r.sSortDesc : i.sSortingClass)
                        }
                    })
                },
                jqueryui: function(t, n, i, r) {
                    e("<div/>").addClass(r.sSortJUIWrapper).append(n.contents()).append(e("<span/>").addClass(r.sSortIcon + " " + i.sSortingClassJUI)).appendTo(n), e(t.nTable).on("order.dt.DT", function(e, o, a, s) {
                        if (t === o) {
                            var l = i.idx;
                            n.removeClass(r.sSortAsc + " " + r.sSortDesc).addClass("asc" == s[l] ? r.sSortAsc : "desc" == s[l] ? r.sSortDesc : i.sSortingClass), n.find("span." + r.sSortIcon).removeClass(r.sSortJUIAsc + " " + r.sSortJUIDesc + " " + r.sSortJUI + " " + r.sSortJUIAscAllowed + " " + r.sSortJUIDescAllowed).addClass("asc" == s[l] ? r.sSortJUIAsc : "desc" == s[l] ? r.sSortJUIDesc : i.sSortingClassJUI)
                        }
                    })
                }
            }
        });
        var Ut = function(e) {
            return "string" == typeof e ? e.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;") : e
        };
        return Xe.render = {
            number: function(e, t, n, i, r) {
                return {
                    display: function(o) {
                        if ("number" != typeof o && "string" != typeof o) return o;
                        var a = o < 0 ? "-" : "",
                            s = parseFloat(o);
                        if (isNaN(s)) return Ut(o);
                        o = Math.abs(s);
                        var l = parseInt(o, 10),
                            u = n ? t + (o - l).toFixed(n).substring(2) : "";
                        return a + (i || "") + l.toString().replace(/\B(?=(\d{3})+(?!\d))/g, e) + u + (r || "")
                    }
                }
            },
            text: function() {
                return {
                    display: Ut
                }
            }
        }, e.extend(Xe.ext.internal, {
            _fnExternApiFunc: We,
            _fnBuildAjax: W,
            _fnAjaxUpdate: z,
            _fnAjaxParameters: q,
            _fnAjaxUpdateDraw: U,
            _fnAjaxDataSrc: V,
            _fnAddColumn: d,
            _fnColumnOptions: h,
            _fnAdjustColumnSizing: f,
            _fnVisibleToColumnIndex: p,
            _fnColumnIndexToVisible: g,
            _fnVisbleColumns: m,
            _fnGetColumns: v,
            _fnColumnTypes: y,
            _fnApplyColumnDefs: b,
            _fnHungarianMap: r,
            _fnCamelToHungarian: o,
            _fnLanguageCompat: a,
            _fnBrowserDetect: u,
            _fnAddData: x,
            _fnAddTr: w,
            _fnNodeToDataIndex: C,
            _fnNodeToColumnIndex: S,
            _fnGetCellData: T,
            _fnSetCellData: k,
            _fnSplitObjNotation: D,
            _fnGetObjectDataFn: _,
            _fnSetObjectDataFn: j,
            _fnGetDataMaster: A,
            _fnClearTable: I,
            _fnDeleteIndex: $,
            _fnInvalidate: L,
            _fnGetRowElements: N,
            _fnCreateTr: E,
            _fnBuildHead: P,
            _fnDrawHead: F,
            _fnDraw: H,
            _fnReDraw: O,
            _fnAddOptionsHtml: Q,
            _fnDetectHeader: B,
            _fnGetUniqueThs: M,
            _fnFeatureHtmlFilter: X,
            _fnFilterComplete: J,
            _fnFilterCustom: G,
            _fnFilterColumn: K,
            _fnFilter: Y,
            _fnFilterCreateSearch: Z,
            _fnEscapeRegex: vt,
            _fnFilterData: ee,
            _fnFeatureHtmlInfo: ie,
            _fnUpdateInfo: re,
            _fnInfoMacros: oe,
            _fnInitialise: ae,
            _fnInitComplete: se,
            _fnLengthChange: le,
            _fnFeatureHtmlLength: ue,
            _fnFeatureHtmlPaginate: ce,
            _fnPageChange: de,
            _fnFeatureHtmlProcessing: he,
            _fnProcessingDisplay: fe,
            _fnFeatureHtmlTable: pe,
            _fnScrollDraw: ge,
            _fnApplyToChildren: me,
            _fnCalculateColumnWidths: ve,
            _fnThrottle: wt,
            _fnConvertToWidth: ye,
            _fnGetWidestNode: be,
            _fnGetMaxLenString: xe,
            _fnStringToCss: we,
            _fnSortFlatten: Ce,
            _fnSort: Se,
            _fnSortAria: Te,
            _fnSortListener: ke,
            _fnSortAttachListener: De,
            _fnSortingClasses: _e,
            _fnSortData: je,
            _fnSaveState: Ae,
            _fnLoadState: Ie,
            _fnSettingsFromNode: $e,
            _fnLog: Le,
            _fnMap: Ne,
            _fnBindAction: Re,
            _fnCallbackReg: Pe,
            _fnCallbackFire: Fe,
            _fnLengthOverflow: He,
            _fnRenderer: Oe,
            _fnDataSource: Qe,
            _fnRowAttributes: R,
            _fnCalculateEnd: function() {}
        }), e.fn.dataTable = Xe, Xe.$ = e, e.fn.dataTableSettings = Xe.settings, e.fn.dataTableExt = Xe.ext, e.fn.DataTable = function(t) {
            return e(this).dataTable(t).api()
        }, e.each(Xe, function(t, n) {
            e.fn.DataTable[t] = n
        }), e.fn.dataTable
    }),
    function(e) {
        "function" == typeof define && define.amd ? define(["jquery", "datatables.net"], function(t) {
            return e(t, window, document)
        }) : "object" == typeof exports ? module.exports = function(t, n) {
            return t || (t = window), n && n.fn.dataTable || (n = require("datatables.net")(t, n).$), e(n, t, t.document)
        } : e(jQuery, window, document)
    }(function(e, t, n, i) {
        "use strict";
        var r = e.fn.dataTable;
        return e.extend(!0, r.defaults, {
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
            renderer: "bootstrap"
        }), e.extend(r.ext.classes, {
            sWrapper: "dataTables_wrapper form-inline dt-bootstrap",
            sFilterInput: "form-control input-sm",
            sLengthSelect: "form-control input-sm",
            sProcessing: "dataTables_processing panel panel-default"
        }), r.ext.renderer.pageButton.bootstrap = function(t, i, o, a, s, l) {
            var u, c, d, h = new r.Api(t),
                f = t.oClasses,
                p = t.oLanguage.oPaginate,
                g = t.oLanguage.oAria.paginate || {},
                m = 0,
                v = function(n, i) {
                    var r, a, d, y, b = function(t) {
                        t.preventDefault(), e(t.currentTarget).hasClass("disabled") || h.page() == t.data.action || h.page(t.data.action).draw("page")
                    };
                    for (r = 0, a = i.length; r < a; r++)
                        if (y = i[r], e.isArray(y)) v(n, y);
                        else {
                            switch (u = "", c = "", y) {
                                case "ellipsis":
                                    u = "&#x2026;", c = "disabled";
                                    break;
                                case "first":
                                    u = p.sFirst, c = y + (s > 0 ? "" : " disabled");
                                    break;
                                case "previous":
                                    u = p.sPrevious, c = y + (s > 0 ? "" : " disabled");
                                    break;
                                case "next":
                                    u = p.sNext, c = y + (s < l - 1 ? "" : " disabled");
                                    break;
                                case "last":
                                    u = p.sLast, c = y + (s < l - 1 ? "" : " disabled");
                                    break;
                                default:
                                    u = y + 1, c = s === y ? "active" : ""
                            }
                            u && (d = e("<li>", {
                                class: f.sPageButton + " " + c,
                                id: 0 === o && "string" == typeof y ? t.sTableId + "_" + y : null
                            }).append(e("<a>", {
                                href: "#",
                                "aria-controls": t.sTableId,
                                "aria-label": g[y],
                                "data-dt-idx": m,
                                tabindex: t.iTabIndex
                            }).html(u)).appendTo(n), t.oApi._fnBindAction(d, {
                                action: y
                            }, b), m++)
                        }
                };
            try {
                d = e(i).find(n.activeElement).data("dt-idx")
            } catch (e) {}
            v(e(i).empty().html('<ul class="pagination"/>').children("ul"), a), d && e(i).find("[data-dt-idx=" + d + "]").focus()
        }, r
    }),
    function(e) {
        "function" == typeof define && define.amd ? define(["jquery", "datatables.net"], function(t) {
            return e(t, window, document)
        }) : "object" == typeof exports ? module.exports = function(t, n) {
            return t || (t = window), n && n.fn.dataTable || (n = require("datatables.net")(t, n).$), e(n, t, t.document)
        } : e(jQuery, window, document)
    }(function(e, t, n, i) {
        "use strict";
        var r = e.fn.dataTable,
            o = function(t, n) {
                if (!r.versionCheck || !r.versionCheck("1.10.3")) throw "DataTables Responsive requires DataTables 1.10.3 or newer";
                this.s = {
                    dt: new r.Api(t),
                    columns: [],
                    current: []
                }, this.s.dt.settings()[0].responsive || (n && "string" == typeof n.details ? n.details = {
                    type: n.details
                } : n && n.details === !1 ? n.details = {
                    type: !1
                } : n && n.details === !0 && (n.details = {
                    type: "inline"
                }), this.c = e.extend(!0, {}, o.defaults, r.defaults.responsive, n), t.responsive = this, this._constructor())
            };
        e.extend(o.prototype, {
            _constructor: function() {
                var n = this,
                    i = this.s.dt,
                    o = i.settings()[0],
                    a = e(t).width();
                i.settings()[0]._responsive = this, e(t).on("resize.dtr orientationchange.dtr", r.util.throttle(function() {
                    var i = e(t).width();
                    i !== a && (n._resize(), a = i)
                })), o.oApi._fnCallbackReg(o, "aoRowCreatedCallback", function(t, r, o) {
                    e.inArray(!1, n.s.current) !== -1 && e("td, th", t).each(function(t) {
                        var r = i.column.index("toData", t);
                        n.s.current[r] === !1 && e(this).css("display", "none")
                    })
                }), i.on("destroy.dtr", function() {
                    i.off(".dtr"), e(i.table().body()).off(".dtr"), e(t).off("resize.dtr orientationchange.dtr"), e.each(n.s.current, function(e, t) {
                        t === !1 && n._setColumnVis(e, !0)
                    })
                }), this.c.breakpoints.sort(function(e, t) {
                    return e.width < t.width ? 1 : e.width > t.width ? -1 : 0
                }), this._classLogic(), this._resizeAuto();
                var s = this.c.details;
                s.type !== !1 && (n._detailsInit(), i.on("column-visibility.dtr", function(e, t, i, r) {
                    n._classLogic(), n._resizeAuto(), n._resize()
                }), i.on("draw.dtr", function() {
                    n._redrawChildren()
                }), e(i.table().node()).addClass("dtr-" + s.type)), i.on("column-reorder.dtr", function(e, t, i) {
                    n._classLogic(), n._resizeAuto(), n._resize()
                }), i.on("column-sizing.dtr", function() {
                    n._resizeAuto(), n._resize()
                }), i.on("init.dtr", function(t, r, o) {
                    n._resizeAuto(), n._resize(), e.inArray(!1, n.s.current) && i.columns.adjust()
                }), this._resize()
            },
            _columnsVisiblity: function(t) {
                var n, i, r = this.s.dt,
                    o = this.s.columns,
                    a = o.map(function(e, t) {
                        return {
                            columnIdx: t,
                            priority: e.priority
                        }
                    }).sort(function(e, t) {
                        return e.priority !== t.priority ? e.priority - t.priority : e.columnIdx - t.columnIdx
                    }),
                    s = e.map(o, function(n) {
                        return (!n.auto || null !== n.minWidth) && (n.auto === !0 ? "-" : e.inArray(t, n.includeIn) !== -1)
                    }),
                    l = 0;
                for (n = 0, i = s.length; n < i; n++) s[n] === !0 && (l += o[n].minWidth);
                var u = r.settings()[0].oScroll,
                    c = u.sY || u.sX ? u.iBarWidth : 0,
                    d = r.table().container().offsetWidth - c,
                    h = d - l;
                for (n = 0, i = s.length; n < i; n++) o[n].control && (h -= o[n].minWidth);
                var f = !1;
                for (n = 0, i = a.length; n < i; n++) {
                    var p = a[n].columnIdx;
                    "-" === s[p] && !o[p].control && o[p].minWidth && (f || h - o[p].minWidth < 0 ? (f = !0, s[p] = !1) : s[p] = !0, h -= o[p].minWidth)
                }
                var g = !1;
                for (n = 0, i = o.length; n < i; n++)
                    if (!o[n].control && !o[n].never && !s[n]) {
                        g = !0;
                        break
                    }
                for (n = 0, i = o.length; n < i; n++) o[n].control && (s[n] = g);
                return e.inArray(!0, s) === -1 && (s[0] = !0), s
            },
            _classLogic: function() {
                var t = this,
                    n = this.c.breakpoints,
                    r = this.s.dt,
                    o = r.columns().eq(0).map(function(t) {
                        var n = this.column(t),
                            o = n.header().className,
                            a = r.settings()[0].aoColumns[t].responsivePriority;
                        if (a === i) {
                            var s = e(n.header()).data("priority");
                            a = s !== i ? 1 * s : 1e4
                        }
                        return {
                            className: o,
                            includeIn: [],
                            auto: !1,
                            control: !1,
                            never: !!o.match(/\bnever\b/),
                            priority: a
                        }
                    }),
                    a = function(t, n) {
                        var i = o[t].includeIn;
                        e.inArray(n, i) === -1 && i.push(n)
                    },
                    s = function(e, i, r, s) {
                        var l, u, c;
                        if (r) {
                            if ("max-" === r)
                                for (l = t._find(i).width, u = 0, c = n.length; u < c; u++) n[u].width <= l && a(e, n[u].name);
                            else if ("min-" === r)
                                for (l = t._find(i).width, u = 0, c = n.length; u < c; u++) n[u].width >= l && a(e, n[u].name);
                            else if ("not-" === r)
                                for (u = 0, c = n.length; u < c; u++) n[u].name.indexOf(s) === -1 && a(e, n[u].name)
                        } else o[e].includeIn.push(i)
                    };
                o.each(function(t, i) {
                    for (var r = t.className.split(" "), o = !1, a = 0, l = r.length; a < l; a++) {
                        var u = e.trim(r[a]);
                        if ("all" === u) return o = !0, void(t.includeIn = e.map(n, function(e) {
                            return e.name
                        }));
                        if ("none" === u || t.never) return void(o = !0);
                        if ("control" === u) return o = !0, void(t.control = !0);
                        e.each(n, function(e, t) {
                            var n = t.name.split("-"),
                                r = new RegExp("(min\\-|max\\-|not\\-)?(" + n[0] + ")(\\-[_a-zA-Z0-9])?"),
                                a = u.match(r);
                            a && (o = !0, a[2] === n[0] && a[3] === "-" + n[1] ? s(i, t.name, a[1], a[2] + a[3]) : a[2] !== n[0] || a[3] || s(i, t.name, a[1], a[2]))
                        })
                    }
                    o || (t.auto = !0)
                }), this.s.columns = o
            },
            _detailsDisplay: function(t, n) {
                var i = this,
                    r = this.s.dt,
                    o = this.c.details;
                if (o && o.type !== !1) {
                    var a = o.display(t, n, function() {
                        return o.renderer(r, t[0], i._detailsObj(t[0]))
                    });
                    a !== !0 && a !== !1 || e(r.table().node()).triggerHandler("responsive-display.dt", [r, t, a, n])
                }
            },
            _detailsInit: function() {
                var t = this,
                    n = this.s.dt,
                    i = this.c.details;
                "inline" === i.type && (i.target = "td:first-child, th:first-child"), n.on("draw.dtr", function() {
                    t._tabIndexes()
                }), t._tabIndexes(), e(n.table().body()).on("keyup.dtr", "td, th", function(t) {
                    13 === t.keyCode && e(this).data("dtr-keyboard") && e(this).click()
                });
                var r = i.target,
                    o = "string" == typeof r ? r : "td, th";
                e(n.table().body()).on("click.dtr mousedown.dtr mouseup.dtr", o, function(i) {
                    if (e(n.table().node()).hasClass("collapsed") && n.row(e(this).closest("tr")).length) {
                        if ("number" == typeof r) {
                            var o = r < 0 ? n.columns().eq(0).length + r : r;
                            if (n.cell(this).index().column !== o) return
                        }
                        var a = n.row(e(this).closest("tr"));
                        "click" === i.type ? t._detailsDisplay(a, !1) : "mousedown" === i.type ? e(this).css("outline", "none") : "mouseup" === i.type && e(this).blur().css("outline", "")
                    }
                })
            },
            _detailsObj: function(t) {
                var n = this,
                    i = this.s.dt;
                return e.map(this.s.columns, function(e, r) {
                    if (!e.never && !e.control) return {
                        title: i.settings()[0].aoColumns[r].sTitle,
                        data: i.cell(t, r).render(n.c.orthogonal),
                        hidden: i.column(r).visible() && !n.s.current[r],
                        columnIndex: r,
                        rowIndex: t
                    }
                })
            },
            _find: function(e) {
                for (var t = this.c.breakpoints, n = 0, i = t.length; n < i; n++)
                    if (t[n].name === e) return t[n]
            },
            _redrawChildren: function() {
                var e = this,
                    t = this.s.dt;
                t.rows({
                    page: "current"
                }).iterator("row", function(n, i) {
                    t.row(i);
                    e._detailsDisplay(t.row(i), !0)
                })
            },
            _resize: function() {
                var n, i, r = this,
                    o = this.s.dt,
                    a = e(t).width(),
                    s = this.c.breakpoints,
                    l = s[0].name,
                    u = this.s.columns,
                    c = this.s.current.slice();
                for (n = s.length - 1; n >= 0; n--)
                    if (a <= s[n].width) {
                        l = s[n].name;
                        break
                    }
                var d = this._columnsVisiblity(l);
                this.s.current = d;
                var h = !1;
                for (n = 0, i = u.length; n < i; n++)
                    if (d[n] === !1 && !u[n].never && !u[n].control) {
                        h = !0;
                        break
                    }
                e(o.table().node()).toggleClass("collapsed", h);
                var f = !1;
                o.columns().eq(0).each(function(e, t) {
                    d[t] !== c[t] && (f = !0, r._setColumnVis(e, d[t]))
                }), f && (this._redrawChildren(), e(o.table().node()).trigger("responsive-resize.dt", [o, this.s.current]))
            },
            _resizeAuto: function() {
                var t = this.s.dt,
                    n = this.s.columns;
                if (this.c.auto && e.inArray(!0, e.map(n, function(e) {
                        return e.auto
                    })) !== -1) {
                    var i = (t.table().node().offsetWidth, t.columns, t.table().node().cloneNode(!1)),
                        r = e(t.table().header().cloneNode(!1)).appendTo(i),
                        o = e(t.table().body()).clone(!1, !1).empty().appendTo(i),
                        a = t.columns().header().filter(function(e) {
                            return t.column(e).visible()
                        }).to$().clone(!1).css("display", "table-cell");
                    e(o).append(e(t.rows({
                        page: "current"
                    }).nodes()).clone(!1)).find("th, td").css("display", "");
                    var s = t.table().footer();
                    if (s) {
                        var l = e(s.cloneNode(!1)).appendTo(i),
                            u = t.columns().footer().filter(function(e) {
                                return t.column(e).visible()
                            }).to$().clone(!1).css("display", "table-cell");
                        e("<tr/>").append(u).appendTo(l)
                    }
                    e("<tr/>").append(a).appendTo(r), "inline" === this.c.details.type && e(i).addClass("dtr-inline collapsed"), e(i).find("[name]").removeAttr("name");
                    var c = e("<div/>").css({
                        width: 1,
                        height: 1,
                        overflow: "hidden"
                    }).append(i);
                    c.insertBefore(t.table().node()), a.each(function(e) {
                        var i = t.column.index("fromVisible", e);
                        n[i].minWidth = this.offsetWidth || 0
                    }), c.remove()
                }
            },
            _setColumnVis: function(t, n) {
                var i = this.s.dt,
                    r = n ? "" : "none";
                e(i.column(t).header()).css("display", r), e(i.column(t).footer()).css("display", r), i.column(t).nodes().to$().css("display", r)
            },
            _tabIndexes: function() {
                var t = this.s.dt,
                    n = t.cells({
                        page: "current"
                    }).nodes().to$(),
                    i = t.settings()[0],
                    r = this.c.details.target;
                n.filter("[data-dtr-keyboard]").removeData("[data-dtr-keyboard]");
                var o = "number" == typeof r ? ":eq(" + r + ")" : r;
                e(o, t.rows({
                    page: "current"
                }).nodes()).attr("tabIndex", i.iTabIndex).data("dtr-keyboard", 1)
            }
        }), o.breakpoints = [{
            name: "desktop",
            width: 1 / 0
        }, {
            name: "tablet-l",
            width: 1024
        }, {
            name: "tablet-p",
            width: 768
        }, {
            name: "mobile-l",
            width: 480
        }, {
            name: "mobile-p",
            width: 320
        }], o.display = {
            childRow: function(t, n, i) {
                return n ? e(t.node()).hasClass("parent") ? (t.child(i(), "child").show(), !0) : void 0 : t.child.isShown() ? (t.child(!1), e(t.node()).removeClass("parent"), !1) : (t.child(i(), "child").show(), e(t.node()).addClass("parent"), !0)
            },
            childRowImmediate: function(t, n, i) {
                return !n && t.child.isShown() || !t.responsive.hasHidden() ? (t.child(!1), e(t.node()).removeClass("parent"), !1) : (t.child(i(), "child").show(), e(t.node()).addClass("parent"), !0)
            },
            modal: function(t) {
                return function(i, r, o) {
                    if (r) e("div.dtr-modal-content").empty().append(o());
                    else {
                        var a = function() {
                                s.remove(), e(n).off("keypress.dtr")
                            },
                            s = e('<div class="dtr-modal"/>').append(e('<div class="dtr-modal-display"/>').append(e('<div class="dtr-modal-content"/>').append(o())).append(e('<div class="dtr-modal-close">&times;</div>').click(function() {
                                a()
                            }))).append(e('<div class="dtr-modal-background"/>').click(function() {
                                a()
                            })).appendTo("body");
                        e(n).on("keyup.dtr", function(e) {
                            27 === e.keyCode && (e.stopPropagation(), a())
                        })
                    }
                    t && t.header && e("div.dtr-modal-content").prepend("<h2>" + t.header(i) + "</h2>")
                }
            }
        }, o.renderer = {
            listHidden: function() {
                return function(t, n, i) {
                    var r = e.map(i, function(e) {
                        return e.hidden ? '<li data-dtr-index="' + e.columnIndex + '" data-dt-row="' + e.rowIndex + '" data-dt-column="' + e.columnIndex + '"><span class="dtr-title">' + e.title + '</span> <span class="dtr-data">' + e.data + "</span></li>" : ""
                    }).join("");
                    return !!r && e('<ul data-dtr-index="' + n + '"/>').append(r)
                }
            },
            tableAll: function(t) {
                return t = e.extend({
                        tableClass: ""
                    }, t),
                    function(n, i, r) {
                        var o = e.map(r, function(e) {
                            return '<tr data-dt-row="' + e.rowIndex + '" data-dt-column="' + e.columnIndex + '"><td>' + e.title + ":</td> <td>" + e.data + "</td></tr>"
                        }).join("");
                        return e('<table class="' + t.tableClass + '" width="100%"/>').append(o)
                    }
            }
        }, o.defaults = {
            breakpoints: o.breakpoints,
            auto: !0,
            details: {
                display: o.display.childRow,
                renderer: o.renderer.listHidden(),
                target: 0,
                type: "inline"
            },
            orthogonal: "display"
        };
        var a = e.fn.dataTable.Api;
        return a.register("responsive()", function() {
            return this
        }), a.register("responsive.index()", function(t) {
            return t = e(t), {
                column: t.data("dtr-index"),
                row: t.parent().data("dtr-index")
            }
        }), a.register("responsive.rebuild()", function() {
            return this.iterator("table", function(e) {
                e._responsive && e._responsive._classLogic()
            })
        }), a.register("responsive.recalc()", function() {
            return this.iterator("table", function(e) {
                e._responsive && (e._responsive._resizeAuto(), e._responsive._resize())
            })
        }), a.register("responsive.hasHidden()", function() {
            var t = this.context[0];
            return !!t._responsive && e.inArray(!1, t._responsive.s.current) !== -1
        }), o.version = "2.1.0", e.fn.dataTable.Responsive = o, e.fn.DataTable.Responsive = o, e(n).on("preInit.dt.dtr", function(t, n, i) {
            if ("dt" === t.namespace && (e(n.nTable).hasClass("responsive") || e(n.nTable).hasClass("dt-responsive") || n.oInit.responsive || r.defaults.responsive)) {
                var a = n.oInit.responsive;
                a !== !1 && new o(n, e.isPlainObject(a) ? a : {})
            }
        }), o
    }),
    function(e) {
        "function" == typeof define && define.amd ? define(["jquery", "datatables.net-bs", "datatables.net-responsive"], function(t) {
            return e(t, window, document)
        }) : "object" == typeof exports ? module.exports = function(t, n) {
            return t || (t = window), n && n.fn.dataTable || (n = require("datatables.net-bs")(t, n).$), n.fn.dataTable.Responsive || require("datatables.net-responsive")(t, n), e(n, t, t.document)
        } : e(jQuery, window, document)
    }(function(e, t, n, i) {
        "use strict";
        var r = e.fn.dataTable,
            o = r.Responsive.display,
            a = o.modal,
            s = e('<div class="modal fade dtr-bs-modal" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"/></div></div></div>');
        return o.modal = function(t) {
            return function(n, i, r) {
                e.fn.modal ? i || (t && t.header && s.find("div.modal-header").empty().append('<h4 class="modal-title">' + t.header(n) + "</h4>"), s.find("div.modal-body").empty().append(r()), s.appendTo("body").modal()) : a(n, i, r)
            }
        }, r.Responsive
    }), ! function(e) {
        "use strict";

        function t(e, t) {
            for (var n = 0; n < e.length; ++n) t(e[n], n)
        }

        function n(t, n) {
            this.$select = e(t), this.$select.attr("data-placeholder") && (n.nonSelectedText = this.$select.data("placeholder")), this.options = this.mergeOptions(e.extend({}, n, this.$select.data())), this.originalOptions = this.$select.clone()[0].options, this.query = "", this.searchTimeout = null, this.lastToggledInput = null, this.options.multiple = "multiple" === this.$select.attr("multiple"), this.options.onChange = e.proxy(this.options.onChange, this), this.options.onDropdownShow = e.proxy(this.options.onDropdownShow, this), this.options.onDropdownHide = e.proxy(this.options.onDropdownHide, this), this.options.onDropdownShown = e.proxy(this.options.onDropdownShown, this), this.options.onDropdownHidden = e.proxy(this.options.onDropdownHidden, this), this.buildContainer(), this.buildButton(), this.buildDropdown(), this.buildSelectAll(), this.buildDropdownOptions(), this.buildFilter(), this.updateButtonText(), this.updateSelectAll(), this.options.disableIfEmpty && e("option", this.$select).length <= 0 && this.disable(), this.$select.hide().after(this.$container)
        }
        "undefined" != typeof ko && ko.bindingHandlers && !ko.bindingHandlers.multiselect && (ko.bindingHandlers.multiselect = {
            after: ["options", "value", "selectedOptions"],
            init: function(t, n, i, r, o) {
                var a = e(t),
                    s = ko.toJS(n());
                if (a.multiselect(s), i.has("options")) {
                    var l = i.get("options");
                    ko.isObservable(l) && ko.computed({
                        read: function() {
                            l(), setTimeout(function() {
                                var e = a.data("multiselect");
                                e && e.updateOriginalOptions(), a.multiselect("rebuild")
                            }, 1)
                        },
                        disposeWhenNodeIsRemoved: t
                    })
                }
                if (i.has("value")) {
                    var u = i.get("value");
                    ko.isObservable(u) && ko.computed({
                        read: function() {
                            u(), setTimeout(function() {
                                a.multiselect("refresh")
                            }, 1)
                        },
                        disposeWhenNodeIsRemoved: t
                    }).extend({
                        rateLimit: 100,
                        notifyWhenChangesStop: !0
                    })
                }
                if (i.has("selectedOptions")) {
                    var c = i.get("selectedOptions");
                    ko.isObservable(c) && ko.computed({
                        read: function() {
                            c(), setTimeout(function() {
                                a.multiselect("refresh")
                            }, 1)
                        },
                        disposeWhenNodeIsRemoved: t
                    }).extend({
                        rateLimit: 100,
                        notifyWhenChangesStop: !0
                    })
                }
                ko.utils.domNodeDisposal.addDisposeCallback(t, function() {
                    a.multiselect("destroy")
                })
            },
            update: function(t, n, i, r, o) {
                var a = e(t),
                    s = ko.toJS(n());
                a.multiselect("setOptions", s), a.multiselect("rebuild")
            }
        }), n.prototype = {
            defaults: {
                buttonText: function(t, n) {
                    if (0 === t.length) return this.nonSelectedText;
                    if (this.allSelectedText && t.length === e("option", e(n)).length && 1 !== e("option", e(n)).length && this.multiple) return this.selectAllNumber ? this.allSelectedText + " (" + t.length + ")" : this.allSelectedText;
                    if (t.length > this.numberDisplayed) return t.length + " " + this.nSelectedText;
                    var i = "",
                        r = this.delimiterText;
                    return t.each(function() {
                        var t = void 0 !== e(this).attr("label") ? e(this).attr("label") : e(this).text();
                        i += t + r
                    }), i.substr(0, i.length - 2)
                },
                buttonTitle: function(t, n) {
                    if (0 === t.length) return this.nonSelectedText;
                    var i = "",
                        r = this.delimiterText;
                    return t.each(function() {
                        var t = void 0 !== e(this).attr("label") ? e(this).attr("label") : e(this).text();
                        i += t + r
                    }), i.substr(0, i.length - 2)
                },
                optionLabel: function(t) {
                    return e(t).attr("label") || e(t).text()
                },
                onChange: function(e, t) {},
                onDropdownShow: function(e) {},
                onDropdownHide: function(e) {},
                onDropdownShown: function(e) {},
                onDropdownHidden: function(e) {},
                onSelectAll: function() {},
                enableHTML: !1,
                buttonClass: "btn btn-default",
                inheritClass: !1,
                buttonWidth: "auto",
                buttonContainer: '<div class="btn-group" />',
                dropRight: !1,
                selectedClass: "active",
                maxHeight: !1,
                checkboxName: !1,
                includeSelectAllOption: !1,
                includeSelectAllIfMoreThan: 0,
                selectAllText: " Select all",
                selectAllValue: "multiselect-all",
                selectAllName: !1,
                selectAllNumber: !0,
                enableFiltering: !1,
                enableCaseInsensitiveFiltering: !1,
                enableClickableOptGroups: !1,
                filterPlaceholder: "Search",
                filterBehavior: "text",
                includeFilterClearBtn: !0,
                preventInputChangeEvent: !1,
                nonSelectedText: "None selected",
                nSelectedText: "selected",
                allSelectedText: "All selected",
                numberDisplayed: 3,
                disableIfEmpty: !1,
                delimiterText: ", ",
                templates: {
                    button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> <b class="caret"></b></button>',
                    ul: '<ul class="multiselect-container dropdown-menu"></ul>',
                    filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
                    filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default multiselect-clear-filter" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>',
                    li: '<li><a tabindex="0"><label></label></a></li>',
                    divider: '<li class="multiselect-item divider"></li>',
                    liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
                }
            },
            constructor: n,
            buildContainer: function() {
                this.$container = e(this.options.buttonContainer), this.$container.on("show.bs.dropdown", this.options.onDropdownShow), this.$container.on("hide.bs.dropdown", this.options.onDropdownHide), this.$container.on("shown.bs.dropdown", this.options.onDropdownShown), this.$container.on("hidden.bs.dropdown", this.options.onDropdownHidden)
            },
            buildButton: function() {
                this.$button = e(this.options.templates.button).addClass(this.options.buttonClass), this.$select.attr("class") && this.options.inheritClass && this.$button.addClass(this.$select.attr("class")), this.$select.prop("disabled") ? this.disable() : this.enable(), this.options.buttonWidth && "auto" !== this.options.buttonWidth && (this.$button.css({
                    width: this.options.buttonWidth,
                    overflow: "hidden",
                    "text-overflow": "ellipsis"
                }), this.$container.css({
                    width: this.options.buttonWidth
                }));
                var t = this.$select.attr("tabindex");
                t && this.$button.attr("tabindex", t), this.$container.prepend(this.$button)
            },
            buildDropdown: function() {
                this.$ul = e(this.options.templates.ul), this.options.dropRight && this.$ul.addClass("pull-right"), this.options.maxHeight && this.$ul.css({
                    "max-height": this.options.maxHeight + "px",
                    "overflow-y": "auto",
                    "overflow-x": "hidden"
                }), this.$container.append(this.$ul)
            },
            buildDropdownOptions: function() {
                this.$select.children().each(e.proxy(function(t, n) {
                    var i = e(n),
                        r = i.prop("tagName").toLowerCase();
                    i.prop("value") !== this.options.selectAllValue && ("optgroup" === r ? this.createOptgroup(n) : "option" === r && ("divider" === i.data("role") ? this.createDivider() : this.createOptionValue(n)))
                }, this)), e("li input", this.$ul).on("change", e.proxy(function(t) {
                    var n = e(t.target),
                        i = n.prop("checked") || !1,
                        r = n.val() === this.options.selectAllValue;
                    this.options.selectedClass && (i ? n.closest("li").addClass(this.options.selectedClass) : n.closest("li").removeClass(this.options.selectedClass));
                    var o = n.val(),
                        a = this.getOptionByValue(o),
                        s = e("option", this.$select).not(a),
                        l = e("input", this.$container).not(n);
                    if (r && (i ? this.selectAll() : this.deselectAll()), r || (i ? (a.prop("selected", !0), this.options.multiple ? a.prop("selected", !0) : (this.options.selectedClass && e(l).closest("li").removeClass(this.options.selectedClass), e(l).prop("checked", !1), s.prop("selected", !1), this.$button.click()), "active" === this.options.selectedClass && s.closest("a").css("outline", "")) : a.prop("selected", !1)), this.$select.change(), this.updateButtonText(), this.updateSelectAll(), this.options.onChange(a, i), this.options.preventInputChangeEvent) return !1
                }, this)), e("li a", this.$ul).on("mousedown", function(e) {
                    if (e.shiftKey) return !1
                }), e("li a", this.$ul).on("touchstart click", e.proxy(function(t) {
                    t.stopPropagation();
                    var n = e(t.target);
                    if (t.shiftKey && this.options.multiple) {
                        n.is("label") && (t.preventDefault(), n = n.find("input"), n.prop("checked", !n.prop("checked")));
                        var i = n.prop("checked") || !1;
                        if (null !== this.lastToggledInput && this.lastToggledInput !== n) {
                            var r = n.closest("li").index(),
                                o = this.lastToggledInput.closest("li").index();
                            if (r > o) {
                                var a = o;
                                o = r, r = a
                            }++o;
                            var s = this.$ul.find("li").slice(r, o).find("input");
                            s.prop("checked", i), this.options.selectedClass && s.closest("li").toggleClass(this.options.selectedClass, i);
                            for (var l = 0, u = s.length; l < u; l++) {
                                var c = e(s[l]),
                                    d = this.getOptionByValue(c.val());
                                d.prop("selected", i)
                            }
                        }
                        n.trigger("change")
                    }
                    n.is("input") && !n.closest("li").is(".multiselect-item") && (this.lastToggledInput = n), n.blur()
                }, this)), this.$container.off("keydown.multiselect").on("keydown.multiselect", e.proxy(function(t) {
                    if (!e('input[type="text"]', this.$container).is(":focus"))
                        if (9 === t.keyCode && this.$container.hasClass("open")) this.$button.click();
                        else {
                            var n = e(this.$container).find("li:not(.divider):not(.disabled) a").filter(":visible");
                            if (!n.length) return;
                            var i = n.index(n.filter(":focus"));
                            38 === t.keyCode && i > 0 ? i-- : 40 === t.keyCode && i < n.length - 1 ? i++ : ~i || (i = 0);
                            var r = n.eq(i);
                            if (r.focus(), 32 === t.keyCode || 13 === t.keyCode) {
                                var o = r.find("input");
                                o.prop("checked", !o.prop("checked")), o.change()
                            }
                            t.stopPropagation(), t.preventDefault()
                        }
                }, this)), this.options.enableClickableOptGroups && this.options.multiple && e("li.multiselect-group", this.$ul).on("click", e.proxy(function(t) {
                    t.stopPropagation();
                    var n = e(t.target).parent(),
                        i = n.nextUntil("li.multiselect-group"),
                        r = i.filter(":visible:not(.disabled)"),
                        o = !0,
                        a = r.find("input");
                    a.each(function() {
                        o = o && e(this).prop("checked")
                    }), a.prop("checked", !o).trigger("change")
                }, this))
            },
            createOptionValue: function(t) {
                var n = e(t);
                n.is(":selected") && n.prop("selected", !0);
                var i = this.options.optionLabel(t),
                    r = n.val(),
                    o = this.options.multiple ? "checkbox" : "radio",
                    a = e(this.options.templates.li),
                    s = e("label", a);
                s.addClass(o), this.options.enableHTML ? s.html(" " + i) : s.text(" " + i);
                var l = e("<input/>").attr("type", o);
                this.options.checkboxName && l.attr("name", this.options.checkboxName), s.prepend(l);
                var u = n.prop("selected") || !1;
                l.val(r), r === this.options.selectAllValue && (a.addClass("multiselect-item multiselect-all"), l.parent().parent().addClass("multiselect-all")), s.attr("title", n.attr("title")), this.$ul.append(a), n.is(":disabled") && l.attr("disabled", "disabled").prop("disabled", !0).closest("a").attr("tabindex", "-1").closest("li").addClass("disabled"), l.prop("checked", u), u && this.options.selectedClass && l.closest("li").addClass(this.options.selectedClass)
            },
            createDivider: function(t) {
                var n = e(this.options.templates.divider);
                this.$ul.append(n)
            },
            createOptgroup: function(t) {
                var n = e(t).prop("label"),
                    i = e(this.options.templates.liGroup);
                this.options.enableHTML ? e("label", i).html(n) : e("label", i).text(n), this.options.enableClickableOptGroups && i.addClass("multiselect-group-clickable"), this.$ul.append(i), e(t).is(":disabled") && i.addClass("disabled"), e("option", t).each(e.proxy(function(e, t) {
                    this.createOptionValue(t)
                }, this))
            },
            buildSelectAll: function() {
                "number" == typeof this.options.selectAllValue && (this.options.selectAllValue = this.options.selectAllValue.toString());
                var t = this.hasSelectAll();
                if (!t && this.options.includeSelectAllOption && this.options.multiple && e("option", this.$select).length > this.options.includeSelectAllIfMoreThan) {
                    this.options.includeSelectAllDivider && this.$ul.prepend(e(this.options.templates.divider));
                    var n = e(this.options.templates.li);
                    e("label", n).addClass("checkbox"), this.options.enableHTML ? e("label", n).html(" " + this.options.selectAllText) : e("label", n).text(" " + this.options.selectAllText), this.options.selectAllName ? e("label", n).prepend('<input type="checkbox" name="' + this.options.selectAllName + '" />') : e("label", n).prepend('<input type="checkbox" />');
                    var i = e("input", n);
                    i.val(this.options.selectAllValue), n.addClass("multiselect-item multiselect-all"),
                        i.parent().parent().addClass("multiselect-all"), this.$ul.prepend(n), i.prop("checked", !1)
                }
            },
            buildFilter: function() {
                if (this.options.enableFiltering || this.options.enableCaseInsensitiveFiltering) {
                    var t = Math.max(this.options.enableFiltering, this.options.enableCaseInsensitiveFiltering);
                    if (this.$select.find("option").length >= t) {
                        if (this.$filter = e(this.options.templates.filter), e("input", this.$filter).attr("placeholder", this.options.filterPlaceholder), this.options.includeFilterClearBtn) {
                            var n = e(this.options.templates.filterClearBtn);
                            n.on("click", e.proxy(function(t) {
                                clearTimeout(this.searchTimeout), this.$filter.find(".multiselect-search").val(""), e("li", this.$ul).show().removeClass("filter-hidden"), this.updateSelectAll()
                            }, this)), this.$filter.find(".input-group").append(n)
                        }
                        this.$ul.prepend(this.$filter), this.$filter.val(this.query).on("click", function(e) {
                            e.stopPropagation()
                        }).on("input keydown", e.proxy(function(t) {
                            13 === t.which && t.preventDefault(), clearTimeout(this.searchTimeout), this.searchTimeout = this.asyncFunction(e.proxy(function() {
                                if (this.query !== t.target.value) {
                                    this.query = t.target.value;
                                    var n, i;
                                    e.each(e("li", this.$ul), e.proxy(function(t, r) {
                                        var o = e("input", r).length > 0 ? e("input", r).val() : "",
                                            a = e("label", r).text(),
                                            s = "";
                                        if ("text" === this.options.filterBehavior ? s = a : "value" === this.options.filterBehavior ? s = o : "both" === this.options.filterBehavior && (s = a + "\n" + o), o !== this.options.selectAllValue && a) {
                                            var l = !1;
                                            this.options.enableCaseInsensitiveFiltering && s.toLowerCase().indexOf(this.query.toLowerCase()) > -1 ? l = !0 : s.indexOf(this.query) > -1 && (l = !0), e(r).toggle(l).toggleClass("filter-hidden", !l), e(r).hasClass("multiselect-group") ? (n = r, i = l) : (l && e(n).show().removeClass("filter-hidden"), !l && i && e(r).show().removeClass("filter-hidden"))
                                        }
                                    }, this))
                                }
                                this.updateSelectAll()
                            }, this), 300, this)
                        }, this))
                    }
                }
            },
            destroy: function() {
                this.$container.remove(), this.$select.show(), this.$select.data("multiselect", null)
            },
            refresh: function() {
                e("option", this.$select).each(e.proxy(function(t, n) {
                    var i = e("li input", this.$ul).filter(function() {
                        return e(this).val() === e(n).val()
                    });
                    e(n).is(":selected") ? (i.prop("checked", !0), this.options.selectedClass && i.closest("li").addClass(this.options.selectedClass)) : (i.prop("checked", !1), this.options.selectedClass && i.closest("li").removeClass(this.options.selectedClass)), e(n).is(":disabled") ? i.attr("disabled", "disabled").prop("disabled", !0).closest("li").addClass("disabled") : i.prop("disabled", !1).closest("li").removeClass("disabled")
                }, this)), this.updateButtonText(), this.updateSelectAll()
            },
            select: function(t, n) {
                e.isArray(t) || (t = [t]);
                for (var i = 0; i < t.length; i++) {
                    var r = t[i];
                    if (null !== r && void 0 !== r) {
                        var o = this.getOptionByValue(r),
                            a = this.getInputByValue(r);
                        void 0 !== o && void 0 !== a && (this.options.multiple || this.deselectAll(!1), this.options.selectedClass && a.closest("li").addClass(this.options.selectedClass), a.prop("checked", !0), o.prop("selected", !0), n && this.options.onChange(o, !0))
                    }
                }
                this.updateButtonText(), this.updateSelectAll()
            },
            clearSelection: function() {
                this.deselectAll(!1), this.updateButtonText(), this.updateSelectAll()
            },
            deselect: function(t, n) {
                e.isArray(t) || (t = [t]);
                for (var i = 0; i < t.length; i++) {
                    var r = t[i];
                    if (null !== r && void 0 !== r) {
                        var o = this.getOptionByValue(r),
                            a = this.getInputByValue(r);
                        void 0 !== o && void 0 !== a && (this.options.selectedClass && a.closest("li").removeClass(this.options.selectedClass), a.prop("checked", !1), o.prop("selected", !1), n && this.options.onChange(o, !1))
                    }
                }
                this.updateButtonText(), this.updateSelectAll()
            },
            selectAll: function(t, n) {
                var t = "undefined" == typeof t || t,
                    i = e("li input[type='checkbox']:enabled", this.$ul),
                    r = i.filter(":visible"),
                    o = i.length,
                    a = r.length;
                if (t ? (r.prop("checked", !0), e("li:not(.divider):not(.disabled)", this.$ul).filter(":visible").addClass(this.options.selectedClass)) : (i.prop("checked", !0), e("li:not(.divider):not(.disabled)", this.$ul).addClass(this.options.selectedClass)), o === a || t === !1) e("option:enabled", this.$select).prop("selected", !0);
                else {
                    var s = r.map(function() {
                        return e(this).val()
                    }).get();
                    e("option:enabled", this.$select).filter(function(t) {
                        return e.inArray(e(this).val(), s) !== -1
                    }).prop("selected", !0)
                }
                n && this.options.onSelectAll()
            },
            deselectAll: function(t) {
                var t = "undefined" == typeof t || t;
                if (t) {
                    var n = e("li input[type='checkbox']:not(:disabled)", this.$ul).filter(":visible");
                    n.prop("checked", !1);
                    var i = n.map(function() {
                        return e(this).val()
                    }).get();
                    e("option:enabled", this.$select).filter(function(t) {
                        return e.inArray(e(this).val(), i) !== -1
                    }).prop("selected", !1), this.options.selectedClass && e("li:not(.divider):not(.disabled)", this.$ul).filter(":visible").removeClass(this.options.selectedClass)
                } else e("li input[type='checkbox']:enabled", this.$ul).prop("checked", !1), e("option:enabled", this.$select).prop("selected", !1), this.options.selectedClass && e("li:not(.divider):not(.disabled)", this.$ul).removeClass(this.options.selectedClass)
            },
            rebuild: function() {
                this.$ul.html(""), this.options.multiple = "multiple" === this.$select.attr("multiple"), this.buildSelectAll(), this.buildDropdownOptions(), this.buildFilter(), this.updateButtonText(), this.updateSelectAll(), this.options.disableIfEmpty && e("option", this.$select).length <= 0 ? this.disable() : this.enable(), this.options.dropRight && this.$ul.addClass("pull-right")
            },
            dataprovider: function(n) {
                var i = 0,
                    r = this.$select.empty();
                e.each(n, function(n, o) {
                    var a;
                    e.isArray(o.children) ? (i++, a = e("<optgroup/>").attr({
                        label: o.label || "Group " + i,
                        disabled: !!o.disabled
                    }), t(o.children, function(t) {
                        a.append(e("<option/>").attr({
                            value: t.value,
                            label: t.label || t.value,
                            title: t.title,
                            selected: !!t.selected,
                            disabled: !!t.disabled
                        }))
                    })) : a = e("<option/>").attr({
                        value: o.value,
                        label: o.label || o.value,
                        title: o.title,
                        selected: !!o.selected,
                        disabled: !!o.disabled
                    }), r.append(a)
                }), this.rebuild()
            },
            enable: function() {
                this.$select.prop("disabled", !1), this.$button.prop("disabled", !1).removeClass("disabled")
            },
            disable: function() {
                this.$select.prop("disabled", !0), this.$button.prop("disabled", !0).addClass("disabled")
            },
            setOptions: function(e) {
                this.options = this.mergeOptions(e)
            },
            mergeOptions: function(t) {
                return e.extend(!0, {}, this.defaults, this.options, t)
            },
            hasSelectAll: function() {
                return e("li.multiselect-all", this.$ul).length > 0
            },
            updateSelectAll: function() {
                if (this.hasSelectAll()) {
                    var t = e("li:not(.multiselect-item):not(.filter-hidden) input:enabled", this.$ul),
                        n = t.length,
                        i = t.filter(":checked").length,
                        r = e("li.multiselect-all", this.$ul),
                        o = r.find("input");
                    i > 0 && i === n ? (o.prop("checked", !0), r.addClass(this.options.selectedClass), this.options.onSelectAll()) : (o.prop("checked", !1), r.removeClass(this.options.selectedClass))
                }
            },
            updateButtonText: function() {
                var t = this.getSelected();
                this.options.enableHTML ? e(".multiselect .multiselect-selected-text", this.$container).html(this.options.buttonText(t, this.$select)) : e(".multiselect .multiselect-selected-text", this.$container).text(this.options.buttonText(t, this.$select)), e(".multiselect", this.$container).attr("title", this.options.buttonTitle(t, this.$select))
            },
            getSelected: function() {
                return e("option", this.$select).filter(":selected")
            },
            getOptionByValue: function(t) {
                for (var n = e("option", this.$select), i = t.toString(), r = 0; r < n.length; r += 1) {
                    var o = n[r];
                    if (o.value === i) return e(o)
                }
            },
            getInputByValue: function(t) {
                for (var n = e("li input", this.$ul), i = t.toString(), r = 0; r < n.length; r += 1) {
                    var o = n[r];
                    if (o.value === i) return e(o)
                }
            },
            updateOriginalOptions: function() {
                this.originalOptions = this.$select.clone()[0].options
            },
            asyncFunction: function(e, t, n) {
                var i = Array.prototype.slice.call(arguments, 3);
                return setTimeout(function() {
                    e.apply(n || window, i)
                }, t)
            },
            setAllSelectedText: function(e) {
                this.options.allSelectedText = e, this.updateButtonText()
            }
        }, e.fn.multiselect = function(t, i, r) {
            return this.each(function() {
                var o = e(this).data("multiselect"),
                    a = "object" == typeof t && t;
                o || (o = new n(this, a), e(this).data("multiselect", o)), "string" == typeof t && (o[t](i, r), "destroy" === t && e(this).data("multiselect", !1))
            })
        }, e.fn.multiselect.Constructor = n, e(function() {
            e("select[data-role=multiselect]").multiselect()
        })
    }(window.jQuery);