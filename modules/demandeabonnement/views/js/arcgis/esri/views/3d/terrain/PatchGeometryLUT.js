// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","./TerrainConst"],function(e,c){let m=function(){function f(){this.sinLonLUT=Array(c.MAX_PATCH_TESSELATION+1);this.cosLonLUT=Array(c.MAX_PATCH_TESSELATION+1);this.sinLatLUT=Array(c.MAX_PATCH_TESSELATION+1);this.cosLatLUT=Array(c.MAX_PATCH_TESSELATION+1)}f.prototype.update=function(g,d,k){const l=d[0];d=d[2];for(let a=0;a<=g;a++){var b=a/g;const h=l*(1-b)+d*b;this.sinLonLUT[a]=Math.sin(h);this.cosLonLUT[a]=Math.cos(h);b=k(b);this.sinLatLUT[a]=Math.sin(b);this.cosLatLUT[a]=Math.cos(b)}};
return f}();e.PatchGeometryLUT=m;Object.defineProperties(e,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});