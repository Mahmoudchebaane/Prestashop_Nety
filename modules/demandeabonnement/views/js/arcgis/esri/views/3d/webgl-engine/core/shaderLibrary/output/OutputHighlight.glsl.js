// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/vec4f64 ../util/WebGL2Utils ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType".split(" "),function(a,c,h,k,l,d){const e=c.fromValues(1,1,0,1),f=c.fromValues(1,0,1,1);a.OutputHighlight=function(b,g){b.fragment.uniforms.add(l.createTexture2DPassSizeUniforms("depthTex",(n,m)=>m.highlightDepthTexture,g.hasWebGL2Context?d.TextureSizeUniformType.None:d.TextureSizeUniformType.InvSize));b.fragment.constants.add("occludedHighlightFlag",
"vec4",e).add("unoccludedHighlightFlag","vec4",f);b.fragment.code.add(k.glsl`
    void outputHighlight() {
      vec3 fragCoord = gl_FragCoord.xyz;

      float sceneDepth = ${h.texelFetch(g,"depthTex","fragCoord.xy")}.x;
      if (fragCoord.z > sceneDepth + 5e-7) {
        gl_FragColor = occludedHighlightFlag;
      }
      else {
        gl_FragColor = unoccludedHighlightFlag;
      }
    }
  `)};a.occludedHighlightFlag=e;a.unoccludedHighlightFlag=f;Object.defineProperties(a,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});