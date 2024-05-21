// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/_rollupPluginBabelHelpers ./Projection.glsl ../terrain/TileComposite.glsl ../../shaderModules/BooleanPassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform".split(" "),function(e,h,k,f,g,l,m){f=function(b){function c(a,n,p){var d=b.call(this)||this;d.common=a;d.u_image=n;d.u_transformGrid=p;return d}h._inheritsLoose(c,b);return c}(f.TileCompositePassParameters);e.Common=function(b,c){b.include(k.Projection,c);b.fragment.uniforms.add([new m.Texture2DPassUniform("u_image",
a=>a.u_image),new g.BooleanPassUniform("u_flipY",a=>a.common.u_flipY),new g.BooleanPassUniform("u_applyTransform",a=>a.common.u_applyTransform)]);b.fragment.code.add(l.glsl`vec2 getPixelLocation(vec2 coords) {
vec2 targetLocation = u_flipY ? vec2(coords.s, 1.0 - coords.t) : coords;
if (!u_applyTransform) {
return targetLocation;
}
return projectPixelLocation(targetLocation);
}
bool isOutside(vec2 coords){
if (coords.t>1.00001 ||coords.t<-0.00001 || coords.s>1.00001 ||coords.s<-0.00001) {
return true;
} else {
return false;
}
}
vec4 getPixel(vec2 pixelLocation) {
return texture2D(u_image, pixelLocation);
}`)};e.CommonPassParameters=f;Object.defineProperties(e,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});