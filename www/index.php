<!DOCTYPE html>
<html>
<head>
    <title>PICTURE TAG</title>
    <link type="text/css" href="assets/picture-tag.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

</head>

<body>
<div id="unsupported" class="error">
    <h1>Browser not supported.</h1>
    <p>Please upgrade to a modern browser.</p>
</div>
<div id="app" style="display: none">
    <template>
        <header ></header>
        <enter-name v-if="!author"></enter-name>
        <images v-if="author" ></images>
        <footer ></footer>
    </template>
</div>
<script>

    function supported() {
        "use strict";
        return 'fetch' in window && 'assign' in Object;
    }

    function loadError(oError) {
        throw new URIError("The script " + oError.target.src + " didn't load correctly.");
    }

    function addScript(url, onloadFunction) {
        var s = document.createElement("script");
        s.onerror = loadError;
        if (onloadFunction) { s.onload = onloadFunction; }
        document.body.appendChild(s);
        s.src = url;
    }

    if (supported()) {
        // The engine supports ES6 features
        var unsupported = document.getElementById('unsupported');
        var app = document.getElementById('app');
        unsupported.remove();
        app.setAttribute('style', 'display: flex;');
        addScript('assets/dist/vendor.js', function(){
            addScript('assets/dist/bundle.js');
        });
    } else {
        console.warn('The engine doesn\'t support ES6 features');
    }
</script>
</body>
</html>
