// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../attributes/TextureCoordinateAttribute.glsl ../attributes/VertexTextureCoordinates.glsl ./Normals.glsl ../util/WebGL2Utils ../../shaderModules/interfaces ../../shaderModules/Texture2DDrawUniform ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType ../../shaderTechnique/BindType ../../../lib/VertexAttribute".split(" "),function(g,h,k,l,m,c,n,p,e,q,r){g.ComputeNormalTexture=function(b,a){const d=b.fragment;a.hasVertexTangents?(b.attributes.add(r.VertexAttribute.TANGENT,
"vec4"),b.varyings.add("vTangent","vec4"),a.doubleSidedMode===l.NormalsDoubleSidedMode.WindingOrder?d.code.add(c.glsl`mat3 computeTangentSpace(vec3 normal) {
float tangentHeadedness = gl_FrontFacing ? vTangent.w : -vTangent.w;
vec3 tangent = normalize(gl_FrontFacing ? vTangent.xyz : -vTangent.xyz);
vec3 bitangent = cross(normal, tangent) * tangentHeadedness;
return mat3(tangent, bitangent, normal);
}`):d.code.add(c.glsl`mat3 computeTangentSpace(vec3 normal) {
float tangentHeadedness = vTangent.w;
vec3 tangent = normalize(vTangent.xyz);
vec3 bitangent = cross(normal, tangent) * tangentHeadedness;
return mat3(tangent, bitangent, normal);
}`)):(b.extensions.add("GL_OES_standard_derivatives"),d.code.add(c.glsl`mat3 computeTangentSpace(vec3 normal, vec3 pos, vec2 st) {
vec3 Q1 = dFdx(pos);
vec3 Q2 = dFdy(pos);
vec2 stx = dFdx(st);
vec2 sty = dFdy(st);
float det = stx.t * sty.s - sty.t * stx.s;
vec3 T = stx.t * Q2 - sty.t * Q1;
T = T - normal * dot(normal, T);
T *= inversesqrt(max(dot(T,T), 1.e-10));
vec3 B = sign(det) * cross(normal, T);
return mat3(T, B, normal);
}`));a.textureCoordinateType!==h.TextureCoordinateAttributeType.None&&(b.include(k.VertexTextureCoordinates,a),b=a.supportsTextureAtlas?a.hasWebGL2Context?e.TextureSizeUniformType.None:e.TextureSizeUniformType.Size:e.TextureSizeUniformType.None,d.uniforms.add(a.pbrTextureBindType===q.BindType.Pass?p.createTexture2DPassSizeUniforms("normalTexture",f=>f.textureNormal,b):n.createTexture2DDrawSizeUniforms("normalTexture",f=>f.textureNormal,b)),d.code.add(c.glsl`
    vec3 computeTextureNormal(mat3 tangentSpace, vec2 uv) {
      vtc.uv = uv;
      ${a.supportsTextureAtlas?c.glsl`vtc.size = ${m.textureSize(a,"normalTexture")};`:""}
      vec3 rawNormal = textureLookup(normalTexture, vtc).rgb * 2.0 - 1.0;
      return tangentSpace * rawNormal;
    }
  `))};Object.defineProperties(g,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});