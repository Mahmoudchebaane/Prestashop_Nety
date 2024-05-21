// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../../../../../../core/maybe","../../../../../../chunks/mat3f32","../../shaderModules/interfaces","../../shaderModules/Matrix3PassUniform"],function(c,d,e,f,g){c.colorTextureUV=function(a){a.vertex.uniforms.add(new g.Matrix3PassUniform("colorTextureTransformMatrix",b=>d.isSome(b.colorTextureTransformMatrix)?b.colorTextureTransformMatrix:e.create()));a.varyings.add("colorUV","vec2");a.vertex.code.add(f.glsl`void forwardColorUV(){
colorUV = (colorTextureTransformMatrix * vec3(vuv0, 1.0)).xy;
}`)};c.emissiveTextureUV=function(a){a.vertex.uniforms.add(new g.Matrix3PassUniform("emissiveTextureTransformMatrix",b=>d.isSome(b.emissiveTextureTransformMatrix)?b.emissiveTextureTransformMatrix:e.create()));a.varyings.add("emissiveUV","vec2");a.vertex.code.add(f.glsl`void forwardEmissiveUV(){
emissiveUV = (emissiveTextureTransformMatrix * vec3(vuv0, 1.0)).xy;
}`)};c.metallicRoughnessTextureUV=function(a){a.vertex.uniforms.add(new g.Matrix3PassUniform("metallicRoughnessTextureTransformMatrix",b=>d.isSome(b.metallicRoughnessTextureTransformMatrix)?b.metallicRoughnessTextureTransformMatrix:e.create()));a.varyings.add("metallicRoughnessUV","vec2");a.vertex.code.add(f.glsl`void forwardMetallicRoughnessUV(){
metallicRoughnessUV = (metallicRoughnessTextureTransformMatrix * vec3(vuv0, 1.0)).xy;
}`)};c.normalTextureUV=function(a){a.vertex.uniforms.add(new g.Matrix3PassUniform("normalTextureTransformMatrix",b=>d.isSome(b.normalTextureTransformMatrix)?b.normalTextureTransformMatrix:e.create()));a.varyings.add("normalUV","vec2");a.vertex.code.add(f.glsl`void forwardNormalUV(){
normalUV = (normalTextureTransformMatrix * vec3(vuv0, 1.0)).xy;
}`)};c.occlusionTextureUV=function(a){a.vertex.uniforms.add(new g.Matrix3PassUniform("occlusionTextureTransformMatrix",b=>d.isSome(b.occlusionTextureTransformMatrix)?b.occlusionTextureTransformMatrix:e.create()));a.varyings.add("occlusionUV","vec2");a.vertex.code.add(f.glsl`void forwardOcclusionUV(){
occlusionUV = (occlusionTextureTransformMatrix * vec3(vuv0, 1.0)).xy;
}`)};Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});