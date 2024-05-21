// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../Color","../config","../views/support/colorUtils"],function(c,d,e,l){function f(a,b){b*=a.a;return 225<l.getColorLuminance(a)?new d([0,0,0,b]):new d([255,255,255,b])}function g(a,b){a=new d(a);a.a*=b;return a}function h(a=1){return g(e.analysisTheme.accentColor,a)}function k(a=1){return g(e.analysisTheme.textColor,a)}c.getAccentColor=h;c.getContrastColor=function(a=1){return f(h(),a)};c.getTextColor=k;c.getTextHaloColor=function(a=1){return f(k(),a)};Object.defineProperties(c,
{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});