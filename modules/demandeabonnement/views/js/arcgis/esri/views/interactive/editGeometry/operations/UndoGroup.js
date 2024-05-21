// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(c){let f=function(){function d(){this._operations=[];this._closed=!1}var b=d.prototype;b.close=function(){this._closed=!0};b.apply=function(){for(const a of this._operations)a.apply()};b.undo=function(){for(let a=this._operations.length-1;0<=a;a--)this._operations[a].undo()};b.accumulate=function(a){if(this._closed)return!1;const e=this._operations.length?this._operations[this._operations.length-1]:null;e&&e.accumulate(a)||(this._operations.push(a),a.apply());return!0};
return d}();c.UndoGroup=f;Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});