// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../util/WebGL2Utils ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType ../../../lib/SSAOHelper".split(" "),function(c,f,d,g,e,h){c.EvaluateAmbientOcclusion=function(a,b){a=a.fragment;b.receiveAmbientOcclusion?(a.uniforms.add(g.createTexture2DPassSizeUniforms("ssaoTex",(l,k)=>k.ssaoHelper.colorTexture,b.hasWebGL2Context?e.TextureSizeUniformType.None:e.TextureSizeUniformType.InvSize)),a.constants.add("blurSizePixelsInverse",
"float",1/h.blurSizePixels),a.code.add(d.glsl`
      float evaluateAmbientOcclusionInverse() {
        vec2 ssaoTextureSizeInverse = ${f.textureSize(b,"ssaoTex",!0)};
        return texture2D(ssaoTex, gl_FragCoord.xy * blurSizePixelsInverse * ssaoTextureSizeInverse).a;
      }

      float evaluateAmbientOcclusion() {
        return 1.0 - evaluateAmbientOcclusionInverse();
      }
    `)):a.code.add(d.glsl`float evaluateAmbientOcclusionInverse() { return 1.0; }
float evaluateAmbientOcclusion() { return 0.0; }`)};Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});