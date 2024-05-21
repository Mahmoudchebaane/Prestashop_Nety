// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","./sdfPrimitives"],function(a,c){a.MARKER_SIZE_PER_LINE_WIDTH=10;a.MARKER_SYMBOL_SIZE=32;a.MARKER_TEXTURE_SIZE=64;a.MARKER_THICKNESS=6.4;a.MARKER_TIP_THICKNESS_FACTOR=.25;a.prepareMarkerResources=function(d,b){return d.fromData(`${b}-marker`,()=>c.createTexture(b,64,32,6.4))};Object.defineProperties(a,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});