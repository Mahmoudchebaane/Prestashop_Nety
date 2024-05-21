// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../../../core/maybe","../../../../chunks/mat3f32","../../../../chunks/vec2f32","../../../../chunks/mat3"],function(g,c,d,h,k){g.getTransformMatrix=function(a){if(c.isNone(a))return null;var e=c.isSome(a.offset)?a.offset:h.ZEROS,b=c.isSome(a.rotation)?a.rotation:0;a=c.isSome(a.scale)?a.scale:h.ONES;e=d.fromValues(1,0,0,0,1,0,e[0],e[1],1);b=d.fromValues(Math.cos(b),-Math.sin(b),0,Math.sin(b),Math.cos(b),0,0,0,1);a=d.fromValues(a[0],0,0,0,a[1],0,0,0,1);const f=d.create();k.multiply(f,
b,a);k.multiply(f,e,f);return f};Object.defineProperties(g,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});