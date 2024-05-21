// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../shaderModules/interfaces"],function(d,b){d.TEXTURE_INVERSE_SIZE_UNIFORM_SUFFIX="InvSize";d.TEXTURE_SIZE_UNIFORM_SUFFIX="Size";d.texelFetch=function(a,c,e,f=null,g=0){if(a.hasWebGL2Context)return b.glsl`texelFetch(${c}, ivec2(${e}), ${b.glsl.int(g)})`;a=b.glsl`texture2D(${c}, ${e} * `;return a=f?a+b.glsl`(${f}))`:a+b.glsl`${c+"InvSize"})`};d.textureSize=function(a,c,e=!1,f=0){return a.hasWebGL2Context?(a=b.glsl`vec2(textureSize(${c}, ${b.glsl.int(f)}))`,e?"(1.0 / "+a+")":a):
e?c+"InvSize":c+"Size"};Object.defineProperties(d,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});