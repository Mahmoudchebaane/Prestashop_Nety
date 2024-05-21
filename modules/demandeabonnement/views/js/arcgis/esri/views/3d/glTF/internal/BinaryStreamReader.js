// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(c){let f=function(){function d(a){this._data=a;this._offset4=0;this._dataUint32=new Uint32Array(this._data,0,Math.floor(this._data.byteLength/4))}var b=d.prototype;b.readUint32=function(){const a=this._offset4;this._offset4+=1;return this._dataUint32[a]};b.readUint8Array=function(a){const e=4*this._offset4;this._offset4+=a/4;return new Uint8Array(this._data,e,a)};b.remainingBytes=function(){return this._data.byteLength-4*this._offset4};return d}();c.BinaryStreamReader=
f;Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});