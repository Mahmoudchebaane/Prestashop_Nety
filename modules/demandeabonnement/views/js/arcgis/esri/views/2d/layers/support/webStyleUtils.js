// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../chunks/_rollupPluginBabelHelpers ../../../../core/devEnvironmentUtils ../../../../core/Error ../../../../core/maybe ../../../../core/promiseUtils ../../../../core/urlUtils ../../../../portal/Portal ../../../../chunks/persistableUrlUtils ../../../../symbols/support/styleUtils".split(" "),function(p,h,q,r,t,k,u,v,w,e){function l(){l=h._asyncToGenerator(function*(a,c,b){if(!a.name)throw new r("style-symbol-reference-name-missing","Missing name in style symbol reference");
if(a.styleName&&"Esri2DPointSymbolsStyle"===a.styleName)return x(a,b);try{const f=yield e.fetchStyle(a,c,b);return y(f,a.name,c,b)}catch(f){return k.throwIfAborted(f),null}});return l.apply(this,arguments)}function x(a,c){return m.apply(this,arguments)}function m(){m=h._asyncToGenerator(function*(a,c){a=e.Style2DUrlTemplate.replace(/\{SymbolName\}/gi,a.name);try{const b=yield e.requestJSON(a,c);return e.makeCIMSymbolRef(b.data)}catch(b){return k.throwIfAborted(b),null}});return m.apply(this,arguments)}
function y(a,c,b,f){return n.apply(this,arguments)}function n(){n=h._asyncToGenerator(function*(a,c,b,f){var d=a.data;a={portal:b&&t.isSome(b.portal)?b.portal:v.getDefault(),url:u.urlToObject(a.baseUrl),origin:"portal-item"};d=d.items.find(g=>g.name===c);if(!d)throw new r("symbolstyleutils:symbol-name-not-found",`The symbol name '${c}' could not be found`,{symbolName:c});d=w.fromJSON(e.symbolUrlFromStyleItem(d,"cimRef"),a);q.isDevEnvironment()&&(d=q.adjustStaticAGOUrl(d));try{const g=yield e.requestJSON(d,
f);return e.makeCIMSymbolRef(g.data)}catch(g){return k.throwIfAborted(g),null}});return n.apply(this,arguments)}p.fetchCIMSymbolReference=function(a,c,b){return l.apply(this,arguments)};Object.defineProperties(p,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});