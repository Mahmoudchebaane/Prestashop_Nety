// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../../../../chunks/vec3","../../../../../chunks/sphere"],function(c,b,e){c.MAX_CANDIDATE_COUNT=1E3;c.boundsFromEdge=function(f,g,h){const d=e.create(),a=e.getCenter(d);b.scaleAndAdd(a,a,f,.5);b.scaleAndAdd(a,a,g,.5);d[3]=b.distance(a,f);b.add(a,a,h);return d};Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});