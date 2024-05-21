// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../ShaderOutput ../attributes/TextureCoordinateAttribute.glsl ../attributes/VertexTextureCoordinates.glsl ../util/TextureAtlasLookup.glsl ../util/WebGL2Utils ../../shaderModules/interfaces ../../shaderModules/Texture2DDrawUniform ../../shaderModules/TextureSizeUniformType ../../../lib/basicInterfaces".split(" "),function(f,h,k,l,m,n,c,p,d,q){f.ReadBaseColorTexture=function(e,a){const b=e.fragment;if(!a.hasBaseColorTexture||a.output!==h.ShaderOutput.Color&&a.alphaDiscardMode===q.AlphaDiscardMode.Opaque)b.code.add(c.glsl`vec4 readBaseColorTexture() { return vec4(1.0); }`);
else{e.include(l.VertexTextureCoordinates,a);const g=a.textureCoordinateType===k.TextureCoordinateAttributeType.Atlas;b.uniforms.add(p.createTexture2DDrawSizeUniforms("baseColorTexture",r=>r.texture,g?a.hasWebGL2Context?d.TextureSizeUniformType.None:d.TextureSizeUniformType.Size:d.TextureSizeUniformType.None));g?(e.include(m.TextureAtlasLookup),b.code.add(c.glsl`
        vec4 readBaseColorTexture() {
          vec2 textureSize = ${n.textureSize(a,"baseColorTexture")};
          return textureAtlasLookup(baseColorTexture, textureSize, vuv0, vuvRegion);
        }
      `)):b.code.add(c.glsl`vec4 readBaseColorTexture() {
return texture2D(baseColorTexture, vuv0);
}`)}};Object.defineProperties(f,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});