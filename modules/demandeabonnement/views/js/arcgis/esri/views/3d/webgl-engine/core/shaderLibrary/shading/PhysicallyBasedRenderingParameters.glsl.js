// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/_rollupPluginBabelHelpers ../../../../../../chunks/vec3f32 ../attributes/VertexTextureCoordinates.glsl ../util/WebGL2Utils ../../shaderModules/Float3DrawUniform ../../shaderModules/Float3PassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DDrawUniform ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType ../../shaderTechnique/BindType ../../../lib/GLTextureMaterial".split(" "),function(f,v,k,w,l,r,t,d,m,n,p,
g,q){k=k.fromValues(0,.6,.2);f.PBRMode=void 0;(function(b){b[b.Disabled=0]="Disabled";b[b.Normal=1]="Normal";b[b.Schematic=2]="Schematic";b[b.Water=3]="Water";b[b.WaterOnIntegratedMesh=4]="WaterOnIntegratedMesh";b[b.COUNT=5]="COUNT"})(f.PBRMode||(f.PBRMode={}));q=function(b){function a(){return b.apply(this,arguments)||this}v._inheritsLoose(a,b);return a}(q.GLTextureMaterialBindParameters);f.PBRBindParameters=q;f.PBRSchematicMRRValues=k;f.PhysicallyBasedRenderingParameters=function(b,a){const e=b.fragment,
u=a.hasMetallicRoughnessTexture||a.hasEmissionTexture||a.hasOcclusionTexture;a.pbrMode===f.PBRMode.Normal&&u&&b.include(w.VertexTextureCoordinates,a);if(a.pbrMode===f.PBRMode.Schematic)e.code.add(d.glsl`vec3 mrr = vec3(0.0, 0.6, 0.2);
vec3 emission = vec3(0.0);
float occlusion = 1.0;
void applyPBRFactors() {}
float getBakedOcclusion() { return 1.0; }`);else if(a.pbrMode===f.PBRMode.Disabled)e.code.add(d.glsl`float getBakedOcclusion() { return 1.0; }`);else if(a.pbrMode===f.PBRMode.Normal){e.code.add(d.glsl`vec3 mrr;
vec3 emission;
float occlusion;`);b=a.supportsTextureAtlas?a.hasWebGL2Context?p.TextureSizeUniformType.None:p.TextureSizeUniformType.Size:p.TextureSizeUniformType.None;const h=a.pbrTextureBindType;a.hasMetallicRoughnessTexture&&(e.uniforms.add(h===g.BindType.Pass?n.createTexture2DPassSizeUniforms("texMetallicRoughness",c=>c.textureMetallicRoughness,b):m.createTexture2DDrawSizeUniforms("texMetallicRoughness",c=>c.textureMetallicRoughness,b)),e.code.add(d.glsl`void applyMetallnessAndRoughness(TextureLookupParameter params) {
vec3 metallicRoughness = textureLookup(texMetallicRoughness, params).rgb;
mrr[0] *= metallicRoughness.b;
mrr[1] *= metallicRoughness.g;
}`));a.hasEmissionTexture&&(e.uniforms.add(h===g.BindType.Pass?n.createTexture2DPassSizeUniforms("texEmission",c=>c.textureEmissive,b):m.createTexture2DDrawSizeUniforms("texEmission",c=>c.textureEmissive,b)),e.code.add(d.glsl`void applyEmission(TextureLookupParameter params) {
emission *= textureLookup(texEmission, params).rgb;
}`));a.hasOcclusionTexture?(e.uniforms.add(h===g.BindType.Pass?n.createTexture2DPassSizeUniforms("texOcclusion",c=>c.textureOcclusion,b):m.createTexture2DDrawSizeUniforms("texOcclusion",c=>c.textureOcclusion,b)),e.code.add(d.glsl`void applyOcclusion(TextureLookupParameter params) {
occlusion *= textureLookup(texOcclusion, params).r;
}
float getBakedOcclusion() {
return occlusion;
}`)):e.code.add(d.glsl`float getBakedOcclusion() { return 1.0; }`);e.uniforms.add(h===g.BindType.Pass?[new t.Float3PassUniform("emissionFactor",c=>c.emissiveFactor),new t.Float3PassUniform("mrrFactors",c=>c.mrrFactors)]:[new r.Float3DrawUniform("emissionFactor",c=>c.emissiveFactor),new r.Float3DrawUniform("mrrFactors",c=>c.mrrFactors)]);e.code.add(d.glsl`
    void applyPBRFactors() {
      mrr = mrrFactors;
      emission = emissionFactor;
      occlusion = 1.0;
      ${u?d.glsl`vtc.uv = vuv0;`:""}
      ${a.hasMetallicRoughnessTextureTransform?d.glsl`vtc.uv = metallicRoughnessUV;`:""}
      ${a.hasMetallicRoughnessTexture?a.supportsTextureAtlas?d.glsl`
                vtc.size = ${l.textureSize(a,"texMetallicRoughness")};
                applyMetallnessAndRoughness(vtc);`:d.glsl`applyMetallnessAndRoughness(vtc);`:""}
      ${a.hasEmissiveTextureTransform?d.glsl`vtc.uv = emissiveUV;`:""}
      ${a.hasEmissionTexture?a.supportsTextureAtlas?d.glsl`
                vtc.size = ${l.textureSize(a,"texEmission")};
                applyEmission(vtc);`:d.glsl`applyEmission(vtc);`:""}
      ${a.hasOcclusionTextureTransform?d.glsl`vtc.uv = occlusionUV;`:""}
      ${a.hasOcclusionTexture?a.supportsTextureAtlas?d.glsl`
                vtc.size = ${l.textureSize(a,"texOcclusion")};
                applyOcclusion(vtc);`:d.glsl`applyOcclusion(vtc);`:""}
    }
  `)}};Object.defineProperties(f,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});