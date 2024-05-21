// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../../chunks/_rollupPluginBabelHelpers","../InputHandler"],function(g,k,d){d=function(h){function e(c){var a=h.call(this,!0)||this;a._onChange=c;a._value="mouse";a._x=null;a._y=null;a.registerIncoming("pointer-move",b=>{a._update(b.data)});return a}k._inheritsLoose(e,h);e.prototype._update=function(c){const a="touch"===c.native.pointerType?"touch":"mouse",{x:b,y:f}=c;if(a!==this._value||this._x!==b||this._y!==f)this._value=a,this._x=b,this._y=f,this._onChange(a,b,f)};return e}(d.InputHandler);
g.LatestPointer=d;Object.defineProperties(g,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});