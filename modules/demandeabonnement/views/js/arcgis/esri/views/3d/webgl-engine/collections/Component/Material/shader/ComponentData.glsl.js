// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../../core/compilerUtils ../../../../../../../core/floatRGBA ../../../../../../../core/has ./DecodeSymbolColor.glsl ../../../../core/shaderLibrary/ShaderOutput ../../../../core/shaderLibrary/util/RgbaFloatEncoding.glsl ../../../../core/shaderLibrary/util/WebGL2Utils ../../../../core/shaderModules/Float4DrawUniform ../../../../core/shaderModules/IntegerDrawUniform ../../../../core/shaderModules/interfaces ../../../../core/shaderModules/Texture2DDrawUniform ../../../../core/shaderModules/TextureSizeUniformType ../../../../lib/VertexAttribute".split(" "),
function(c,m,n,p,q,r,t,g,u,v,e,w,l,x){function y(a,b){const {vertex:d,fragment:f}=a;d.include(t.RgbaFloatEncoding);d.uniforms.add(w.createTexture2DDrawSizeUniforms("componentColorTex",z=>z.componentParameters.texture.texture,b.hasWebGL2Context?l.TextureSizeUniformType.None:l.TextureSizeUniformType.Size));a.attributes.add(x.VertexAttribute.COMPONENTINDEX,"float");a.varyings.add("vExternalColorMixMode","mediump float");a.varyings.add("vExternalColor","vec4");const h=b.output===r.ShaderOutput.ObjectAndLayerIdColor;
h&&a.varyings.add("vObjectAndLayerIdColor","vec4");a.include(q.DecodeSymbolColor);d.constants.add("elevationScale","float",2*k);d.constants.add("stride","float",p("enable-feature:objectAndLayerId-rendering")?3:2);d.code.add(e.glsl`
  vec2 getComponentTextureCoordinates(float componentIndex, float typeOffset) {
    vec2 textureSize = ${g.textureSize(b,"componentColorTex")};

    float index = componentIndex * stride + typeOffset;
    float coordX = mod(index, textureSize.x);
    float coordY = floor(index / textureSize.x);

    return vec2(coordX, coordY) + 0.5;
  }
  `);d.code.add(e.glsl`
  vec4 _readComponentColor() {
    vec2 textureCoordinates = getComponentTextureCoordinates(componentIndex, 0.0);

    return ${g.texelFetch(b,"componentColorTex","textureCoordinates","1.0 / componentColorTexSize")};
   }

   float readElevationOffset() {
    vec2 textureCoordinates = getComponentTextureCoordinates(componentIndex, 1.0);

    vec4 encodedElevation = ${g.texelFetch(b,"componentColorTex","textureCoordinates","1.0 / componentColorTexSize")};
    return (rgba2float(encodedElevation) - 0.5) * elevationScale;
  }

  ${h?e.glsl`
          void forwardObjectAndLayerIdColor() {
            vec2 textureCoordinates = getComponentTextureCoordinates(componentIndex, 2.0);

            vObjectAndLayerIdColor = ${g.texelFetch(b,"componentColorTex","textureCoordinates","1.0 / componentColorTexSize")};
          }`:e.glsl`void forwardObjectAndLayerIdColor() {}`}

  vec4 forwardExternalColor(out bool castShadows) {
    vec4 componentColor = _readComponentColor() * 255.0;

    float shadowFlag = mod(componentColor.b * 255.0, 2.0);
    componentColor.b -= shadowFlag;
    castShadows = shadowFlag >= 1.0;

    int decodedColorMixMode;
    vExternalColor = decodeSymbolColor(componentColor, decodedColorMixMode) * 0.003921568627451; // = 1/255;
    vExternalColorMixMode = float(decodedColorMixMode) + 0.5; // add 0.5 to avoid interpolation artifacts

    return vExternalColor;
  }
`);f.code.add(e.glsl`
  void readExternalColor(out vec4 externalColor, out int externalColorMixMode) {
    externalColor = vExternalColor;
    externalColorMixMode = int(vExternalColorMixMode);
  }

  void outputObjectAndLayerIdColor() {
     ${h?e.glsl`gl_FragColor = vObjectAndLayerIdColor;`:""}
  }
`)}function A(a){const {vertex:b,fragment:d}=a;b.uniforms.add(new u.Float4DrawUniform("externalColor",f=>f.componentParameters.externalColor));d.uniforms.add(new v.IntegerDrawUniform("externalColorMixMode",f=>f.componentParameters.externalColorMixMode));a.varyings.add("vExternalColor","vec4");b.code.add(e.glsl`float readElevationOffset() {
return 0.0;
}
void forwardObjectAndLayerIdColor() {
}
vec4 forwardExternalColor(out bool castShadows) {
vExternalColor = externalColor;
castShadows = true;
return externalColor;
}`);d.code.add(e.glsl`void readExternalColor(out vec4 color, out int colorMixMode) {
color = vExternalColor;
colorMixMode = externalColorMixMode;
}
void outputObjectAndLayerIdColor() {
gl_FragColor = vec4(1.0,0.0,0.0,0.0);
}`)}c.ComponentDataType=void 0;(function(a){a[a.Uniform=0]="Uniform";a[a.Varying=1]="Varying";a[a.COUNT=2]="COUNT"})(c.ComponentDataType||(c.ComponentDataType={}));const k=2**32/1E4;c.ComponentData=function(a,b){switch(b.componentData){case c.ComponentDataType.Varying:return y(a,b);case c.ComponentDataType.Uniform:return A(a);case c.ComponentDataType.COUNT:break;default:m.neverReached(b.componentData)}};c.MAX_ELEVATION_OFFSET=k;c.encodeElevationOffset=function(a,b){n.packFloatRGBA(a/k*.5+.5,b)};Object.defineProperties(c,
{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});