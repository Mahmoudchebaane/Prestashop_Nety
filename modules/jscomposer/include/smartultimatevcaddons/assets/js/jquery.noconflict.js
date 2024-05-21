function addjQuery() {
  if (!window.jQuery) {
    var jq = document.createElement("script");
    jq.type = "text/javascript";
    jq.src = "http://ultimate-addons.presta-demo.com/js/jquery/jquery-1.11.0.min.js";
    document.getElementsByTagName("head")[0].appendChild(jq);
    jQuery.noConflict();
    console.log("jQuery is loaded!");
  } else {
    console.log("jQuery already exists.")
  }
}

addjQuery();