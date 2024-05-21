// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../tracking","./SimpleObservable"],function(b,e,f){let g=function(){function c(a){this._observable=new f.SimpleObservable;this._value=a}var d=c.prototype;d.get=function(){e.trackAccess(this._observable);return this._value};d.set=function(a){a!==this._value&&(this._value=a,this._observable.notify())};return c}();b.ObservableValue=g;Object.defineProperties(b,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});