// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["../../../../../../core/maybe","../../../../../../symbols/cim/effects/CIMEffectHelper"],function(k,e){return function(){function h(){}var f=h.prototype;f.bindFeature=function(c,a,b){};f.write=function(c,a,b,d){if(k.isNone(this._effects)||0===this._effects?.length)return this._write(c,a,d);b=e.CIMEffectHelper.executeEffects(this._effects,a.readLegacyGeometryForDisplay(),d.geometryEngine);let g=e.CIMEffectHelper.next(b);for(;g;)this._write(c,a,d,g),g=e.CIMEffectHelper.next(b)};f._write=function(c,
a,b,d){};return h}()});