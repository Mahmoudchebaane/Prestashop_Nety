// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../shaderModules/Float3PassUniform","../../shaderModules/FloatPassUniform","../../shaderModules/interfaces"],function(c,e,k,l){function f(a){a.uniforms.add(new e.Float3PassUniform("mainLightDirection",(b,d)=>d.lighting.mainLight.direction))}function g(a){a.uniforms.add(new e.Float3PassUniform("mainLightIntensity",(b,d)=>d.lighting.mainLight.intensity))}function m(a,b){b.useLegacyTerrainShading?a.uniforms.add(new k.FloatPassUniform("lightingFixedFactor",(d,h)=>h.lighting.noonFactor*
(1-h.lighting.globalFactor))):a.constants.add("lightingFixedFactor","float",0)}c.MainLighting=function(a,b){a=a.fragment;f(a);g(a);m(a,b);a.code.add(l.glsl`vec3 evaluateMainLighting(vec3 normal_global, float shadowing) {
float dotVal = clamp(dot(normal_global, mainLightDirection), 0.0, 1.0);
dotVal = mix(dotVal, 1.0, lightingFixedFactor);
return mainLightIntensity * ((1.0 - shadowing) * dotVal);
}`)};c.addMainLightDirection=f;c.addMainLightIntensity=g;Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});