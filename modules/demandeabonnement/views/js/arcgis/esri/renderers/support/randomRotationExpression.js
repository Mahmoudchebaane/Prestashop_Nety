// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(a){const b=/^hash\(\$feature\['((\\'|[^'])+)'\]\) \* 8\.381e-8$/;a.matchRandomRotationExpression=function(c){return c.match(b)?.[1]?.replace(/\\'/g,"'")??null};Object.defineProperties(a,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});