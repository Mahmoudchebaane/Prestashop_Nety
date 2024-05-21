// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../../../../core/has","../../../../../core/maybe","../../../../../support/elevationInfoUtils","../isSupportedGraphicUtils"],function(c,f,e,d,a){c.isSupportedGraphic=function(b){if("graphics"!==b.layer?.type)return a.SupportedGraphicResult.GRAPHICS_LAYER_MISSING;if(e.isNone(b.geometry))return a.SupportedGraphicResult.GEOMETRY_MISSING;switch(b.geometry.type){case "polygon":case "point":case "polyline":case "mesh":break;case "multipoint":case "extent":return a.SupportedGraphicResult.GEOMETRY_TYPE_UNSUPPORTED;
default:return a.SupportedGraphicResult.GEOMETRY_TYPE_UNSUPPORTED}return"on-the-ground"!==d.getGraphicEffectiveElevationMode(b)&&d.hasGraphicFeatureExpressionInfo(b)?a.SupportedGraphicResult.ELEVATION_MODE_UNSUPPORTED:a.SupportedGraphicResult.SUPPORTED};Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});