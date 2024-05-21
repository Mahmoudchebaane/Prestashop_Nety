// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["../../../core/Logger","../../../core/maybe"],function(c,d){return function(b,a,e){if(d.isNone(b))return null;a=a.readArcadeFeature();try{return b.evaluate({...e,$feature:a})}catch(f){return c.getLogger("esri.views.2d.support.arcadeOnDemand").warn("Feature arcade evaluation failed:",f),null}}});