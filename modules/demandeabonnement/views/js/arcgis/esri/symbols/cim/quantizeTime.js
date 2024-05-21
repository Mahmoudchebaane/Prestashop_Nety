// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(a){const c=new Set(["StartTimeOffset","Duration","RepeatDelay"]);a.quantizeIfNeeded=function(b,d){return c.has(d)?.05*Math.max(Math.round(b/.05),1):b};Object.defineProperties(a,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});