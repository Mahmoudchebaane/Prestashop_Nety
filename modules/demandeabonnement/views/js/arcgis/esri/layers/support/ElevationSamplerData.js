// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(c){c.ElevationSamplerData=function({values:d,width:b,height:e,noDataValue:f},a){this.pixelData=d;this.width=b;this.height=e;this.safeWidth=.99999999*(b-1);this.noDataValue=f;this.dx=(b-1)/(a[2]-a[0]);this.dy=(b-1)/(a[3]-a[1]);this.x0=a[0];this.y1=a[3]};Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});