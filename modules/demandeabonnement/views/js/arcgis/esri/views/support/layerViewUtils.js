// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../core/maybe"],function(b,d){b.extractSafeScaleBounds=function(a){a=a.effectiveScaleRange;return{minScale:a?.minScale??0,maxScale:a?.maxScale??0}};b.highlightsSupported=function(a){return a&&"function"===typeof a.highlight};b.isScaleRangeActive=function(a,c){return 0<a||0<c};b.occludeesSupported=function(a){return a&&"function"===typeof a.maskOccludee};b.scaleBoundsPredicate=function(a,c,e){return d.isNone(a)||a>e&&(0===c||a<c)};Object.defineProperties(b,{__esModule:{value:!0},
[Symbol.toStringTag]:{value:"Module"}})});