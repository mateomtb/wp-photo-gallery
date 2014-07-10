function gallerytracklib(Name, useTL, test) {
    var s = null;
    var ex = null;
    var clock = null;
    var timespent = 0;
    var timeout = 600;
    var focused = false;
    var lastCall = null;
    var threshhold = 1.4;
    var galleryloaded = false;
    var timerbtn_started = false;
    var testing = (test != null && test == true);
    var tlmethod = (useTL == null) ? true : useTL;
    var hasFocusEnabled = (typeof (document.hasFocus) != "undefined");
    if (typeof (window.s) != "undefined") {
        if (typeof (window.s.tl) != "undefined" && typeof (window.s.t) != "undefined") {
            s = window.s;
        } else {
            s = null; 
        }
     }
    var lib = {
        start: function start() {
            timespent = 0
            timerbtn_started = true;
            clock = window.setInterval(incrementTime, 1000);
            if (testing) { alert("Timer started") }
        },
        stop: function stop() {
            timerbtn_started = false;
            clearInterval(clock);
            offloadTime();
            timespent = 0
            if (testing) { alert("Timer stopped") }
        },
		deleteIt: function deleteIt() {
            RemoveEvent(window, "unload", offloadTime);
			
        },
        record_photoView: function record_photoView(ImageName) {
            if (!timerbtn_started) {
                if (photo_qualifies()) {
                    var gName = cleanForOmn(Name);
                    var iName = "[gal] " + gName + "-[img] (c):" + cleanForOmn(ImageName);
					//
                    if (testing) { alert('Photo View Recorded for: "' + gName + '"\n"' + iName + '"') } else {
                        if (s != null) {
                            s.events = "event31,event34";
                            s.linkTrackVars = "";
                            s.linkTrackEvents = "event31,event34";
                            s.products = "gallery;" + "[gal total] " + gName + ";1;;event34=1," + "image;" + iName + ";1;;event31=1";
                            s.linkName = Name;
                            s.linkType = "o";
                            if (tlmethod) {
                                s.tl(this, "o", s.linkName);
                            } else {
                                s.t();
                            }
                        }
                    }
                    if (!galleryloaded) { galleryLoad() }
                }
            } else { if (testing) { alert('The timer is still running!') } }
        }
    }
    function galleryLoad() {
        var gName = "[gal total] " + cleanForOmn(Name);
        if (testing) { alert("Gallery load recorded for " + gName) } else {
            if (s != null) {
                s.events = "event32";
                s.linkTrackVars = "";
                s.linkTrackEvents = "event32";
                s.products = "gallery;" + gName + ";1;;event32=1";
                s.linkName = Name;
                s.linkType = "o";
                s.tl(this, "o", s.linkName);
            }
        }
        galleryloaded = true;
    }
    function timedEvent(n) {
        var gName = "[gal total] " + cleanForOmn(Name);
        if (time_qualifies()) {
            if (testing) { alert("Time offloaded: " + n + " second(s)") } else {
                if (s != null) {
                    s.events = "event33";
                    s.linkTrackVars = "";
                    s.linkTrackEvents = "event33";
                    s.products = "gallery;" + gName + ";1;;event33=" + n;
                    s.linkName = Name;
                    s.linkType = "o";
                    s.tl(this, "o", s.linkName);
                }
            }
        } else {
            if (testing) { alert("The recorded time spent did not meet the threshold requirement.") }
        }
    }
    function offloadTime() {
        if (timespent) {
            if (!galleryloaded) {
                galleryLoad();
            }
            var n = (timespent);
            timespent = 0;
            timedEvent(n);
        }
    }
    function incrementTime() {
        if (hasFocusEnabled) {
            if (document.hasFocus()) {
                timespent++;
                return null;
            }
        } else if (focused) {
            timespent++;
            return null;
        }
    }
    function time_qualifies() { return (timeout > timespent) }
    function photo_qualifies() {
        var tNow = new Date().getTime();
        var diff;
        if (lastCall != null) {
            diff = tNow - lastCall;
        } else { diff = null }
        lastCall = new Date().getTime();
        var result = (diff == null) ? true : ((diff / 1000) >= threshhold) ? true : false;
        if (result == false) { if (testing) { alert("This photo view did not meet the time requirements: " + diff / 1000) + " seconds" } }
        return result;
    }
    function captureFocus() {
        if (!hasFocusEnabled) {
            /*check for the existance of every variation of the focus and blur events*/;
            if (typeof (document.onblur) != "undefined" && typeof (document.onfocus) != "undefined") {
                AttachEvent(document, "onblur", focusOut, true);
                AttachEvent(document, "onfocus", focusIn, true);
                return null;
            }
            if (typeof (window.onblur) != "undefined" && typeof (window.onfocus) != "undefined") {
                AttachEvent(window, "onblur", focusOut, true);
                AttachEvent(window, "onfocus", focusIn, true);
                return null;
            }
            if (typeof (document.onfocusout) != "undefined" && typeof (document.onfocusin) != "undefined") {
                AttachEvent(document, "onfocusout", focusOut, true);
                AttachEvent(document, "onfocusin", focusIn, true);
                return null;
            }
            if (typeof (window.onfocusout) != "undefined" && typeof (window.onfocusin) != "undefined") {
                AttachEvent(window, "onfocusout", focusOut, true);
                AttachEvent(window, "onfocusin", focusIn, true);
                return null;
            }
            if (typeof (document.ondomfocusout) != "undefined" && typeof (document.ondomfocusin) != "undefined") {
                AttachEvent(document, "ondomfocusout", focusOut, true);
                AttachEvent(document, "ondomfocusin", focusIn, true);
                return null;
            }
            if (typeof (window.ondomfocusout) != "undefined" && typeof (window.ondomfocusin) != "undefined") {
                AttachEvent(window, "ondomfocusout", focusOut, true);
                AttachEvent(window, "ondomfocusin", focusIn, true);
                return null;
            }
            if (typeof (document.onBlur) != "undefined" && typeof (document.onFocus) != "undefined") {
                AttachEvent(document, "onBlur", focusOut, true);
                AttachEvent(document, "onFocus", focusIn, true);
                return null;
            }
            if (typeof (window.onBlur) != "undefined" && typeof (window.onFocus) != "undefined") {
                AttachEvent(window, "onBlur", focusOut, true);
                AttachEvent(window, "onFocus", focusIn, true);
                return null;
            }
            if (typeof (document.onFocusOut) != "undefined" && typeof (document.onFocusIn) != "undefined") {
                AttachEvent(document, "onFocusOut", focusOut, true);
                AttachEvent(document, "onFocusIn", focusIn, true);
                return null;
            }
            if (typeof (window.onFocusOut) != "undefined" && typeof (window.onFocusIn) != "undefined") {
                AttachEvent(window, "onFocusOut", focusOut, true);
                AttachEvent(window, "onFocusIn", focusIn, true);
                return null;
            }
            if (typeof (document.onDOMFocusOut) != "undefined" && typeof (document.onDOMFocusIn) != "undefined") {
                AttachEvent(document, "onDOMFocusOut", focusOut, true);
                AttachEvent(document, "onDOMFocusIn", focusIn, true);
                return null;
            }
            if (typeof (window.onDOMFocusOut) != "undefined" && typeof (window.onDOMFocusIn) != "undefined") {
                AttachEvent(window, "onDOMFocusOut", focusOut, true);
                AttachEvent(window, "onDOMFocusIn", focusIn, true);
                return null;
            }
            if (typeof (document.blur) != "undefined" && typeof (document.focus) != "undefined") {
                AttachEvent(document, "blur", focusOut, true);
                AttachEvent(document, "focus", focusIn, true);
                return null;
            }
            if (typeof (window.blur) != "undefined" && typeof (window.focus) != "undefined") {
                AttachEvent(window, "blur", focusOut, true);
                AttachEvent(window, "focus", focusIn, true);
                return null;
            }
            if (typeof (document.focusout) != "undefined" && typeof (document.focusin) != "undefined") {
                AttachEvent(document, "focusout", focusOut, true);
                AttachEvent(document, "focusin", focusIn, true);
                return null;
            }
            if (typeof (window.focusout) != "undefined" && typeof (window.focusin) != "undefined") {
                AttachEvent(window, "focusout", focusOut, true);
                AttachEvent(window, "focusin", focusIn, true);
                return null;
            }
            if (typeof (document.domfocusout) != "undefined" && typeof (document.domfocusin) != "undefined") {
                AttachEvent(document, "domfocusout", focusOut, true);
                AttachEvent(document, "domfocusin", focusIn, true);
                return null;
            }
            if (typeof (window.domfocusout) != "undefined" && typeof (window.domfocusin) != "undefined") {
                AttachEvent(window, "domfocusout", focusOut, true);
                AttachEvent(window, "domfocusin", focusIn, true);
                return null;
            }
            if (typeof (document.Blur) != "undefined" && typeof (document.Focus) != "undefined") {
                AttachEvent(document, "Blur", focusOut, true);
                AttachEvent(document, "Focus", focusIn, true);
                return null;
            }
            if (typeof (window.Blur) != "undefined" && typeof (window.Focus) != "undefined") {
                AttachEvent(window, "Blur", focusOut, true);
                AttachEvent(window, "Focus", focusIn, true);
                return null;
            }
            if (typeof (document.FocusOut) != "undefined" && typeof (document.FocusIn) != "undefined") {
                AttachEvent(document, "focusOut", focusOut, true);
                AttachEvent(document, "focusIn", focusIn, true);
                return null;
            }
            if (typeof (window.FocusOut) != "undefined" && typeof (window.FocusIn) != "undefined") {
                AttachEvent(window, "focusOut", focusOut, true);
                AttachEvent(window, "focusIn", focusIn, true);
                return null;
            }
            if (typeof (document.DOMFocusOut) != "undefined" && typeof (document.DOMFocusIn) != "undefined") {
                AttachEvent(document, "DOMFocusOut", focusOut, true);
                AttachEvent(document, "DOMFocusIn", focusIn, true);
                return null;
            }
            if (typeof (window.DOMFocusOut) != "undefined" && typeof (window.DOMFocusIn) != "undefined") {
                AttachEvent(window, "DOMFocusOut", focusOut, true);
                AttachEvent(window, "DOMFocusIn", focusIn, true);
                return null;
            }
        }
        function focusOut() { focused = false }
        function focusIn() { focused = true }
    }
    function replaceAll(str, replace_this, with_this) {
        return str.replace(new RegExp(replace_this, 'g'), with_this);
    }
    function AttachEvent(thiselement, eName, functcall, useExact) {
        if (thiselement.addEventListener) {
            return thiselement.addEventListener(eName, functcall, true);
        } else if (thiselement.attachEvent) {
            if (useExact != null && useExact == true) {
                return thiselement.attachEvent(eName, functcall);
            } else {
                return thiselement.attachEvent("on" + eName, functcall);
            }
        }
    }
    function RemoveEvent(thiselement, eName, functcall, useExact) {
        if (thiselement.removeEventListener) {
            return thiselement.removeEventListener(eName, functcall, true);
        } else if (thiselement.detachEvent) {
            if (useExact != null && useExact == true) {
                return thiselement.detachEvent(eName, functcall);
            } else {
                return thiselement.detachEvent("on" + eName, functcall);
            }
        }
    }
    function cleanForOmn(txt) {
        txt = replaceAll(txt, "'", " ")
        txt = replaceAll(txt, '"', " ")
        txt = replaceAll(txt, ";", " ")
        txt = replaceAll(txt, ",", " ")
        return txt
    }
    AttachEvent(window, "unload", offloadTime);
    return lib;
}