// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../../../chunks/_rollupPluginBabelHelpers","../../../../core/time"],function(b,d,e){let f=function(){function a(){this.enabled=!0;this._time=e.Milliseconds(0)}a.prototype.advance=function(c){if(this._time===c.time)return!1;this._time=c.time;return!0};d._createClass(a,[{key:"time",get:function(){return this._time}}]);return a}();b.AnimationTimer=f;Object.defineProperties(b,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});