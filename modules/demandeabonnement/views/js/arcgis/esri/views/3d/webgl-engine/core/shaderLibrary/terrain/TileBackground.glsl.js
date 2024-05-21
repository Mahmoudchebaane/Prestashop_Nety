// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/_rollupPluginBabelHelpers ../../../../../../chunks/vec3f64 ../output/BlendOptions ./BackgroundGrid.glsl ../util/BlendModes.glsl ../util/WebGL2Utils ../../shaderModules/Float3PassUniform ../../shaderModules/FloatPassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType".split(" "),function(b,n,p,q,r,t,u,v,w,d,x,h){b.BlendLayersOutput=void 0;(function(a){a[a.Composite=0]="Composite";a[a.ColorComposite=
1]="ColorComposite";a[a.GridComposite=2]="GridComposite";a[a.GroupBackgroundComposite=3]="GroupBackgroundComposite";a[a.COUNT=4]="COUNT"})(b.BlendLayersOutput||(b.BlendLayersOutput={}));b.BaseOpacityMode=void 0;(function(a){a[a.NotRequired=0]="NotRequired";a[a.Required=1]="Required";a[a.COUNT=2]="COUNT"})(b.BaseOpacityMode||(b.BaseOpacityMode={}));b.PremultipliedAlphaSource=void 0;(function(a){a[a.Off=0]="Off";a[a.On=1]="On";a[a.COUNT=2]="COUNT"})(b.PremultipliedAlphaSource||(b.PremultipliedAlphaSource=
{}));let y=function(a){function c(){var e=a.apply(this,arguments)||this;e.baseOpacity=1;e.backgroundColor=p.ZEROS;e.fboTexture=null;return e}n._inheritsLoose(c,a);return c}(d.NoParameters);b.TileBackground=function(a,c){const e=c.output===b.BlendLayersOutput.GridComposite,k=c.output===b.BlendLayersOutput.ColorComposite,l=c.output===b.BlendLayersOutput.GroupBackgroundComposite,m=c.output===b.BlendLayersOutput.Composite;e&&(a.extensions.add("GL_OES_standard_derivatives"),a.fragment.include(r.BackgroundGrid));
k&&a.fragment.uniforms.add(new v.Float3PassUniform("backgroundColor",f=>f.backgroundColor));const g=c.baseOpacityMode===b.BaseOpacityMode.Required;g&&a.fragment.uniforms.add(new w.FloatPassUniform("baseOpacity",f=>f.baseOpacity));m&&a.fragment.uniforms.add(x.createTexture2DPassSizeUniforms("fboColor",f=>f.fboTexture,c.hasWebGL2Context?h.TextureSizeUniformType.None:h.TextureSizeUniformType.InvSize));const z=c.blendMode!==q.LayerBlendMode.Normal,A=c.premultipliedSource===b.PremultipliedAlphaSource.On;
a.fragment.include(t.BlendModes,c);a.fragment.code.add(d.glsl`
    vec4 getBackground(vec2 uv) {
      return ${g?d.glsl`baseOpacity *`:""} ${l?d.glsl`vec4(0.0, 0.0, 0.0, 0.0)`:k?d.glsl`vec4(backgroundColor, 1.0)`:e?d.glsl`gridColor(uv)`:d.glsl`${u.texelFetch(c,"fboColor","gl_FragCoord.xy")}`};
    }

    vec4 blendLayers(vec4 bgColor, vec4 colorLayer, float opacity) {
      ${z?d.glsl`
          vec3 Cb = bgColor.a == 0.0 ? bgColor.rgb : vec3(bgColor.rgb * bgColor.a);
          return applyBlendMode(colorLayer.rgb, colorLayer.a * opacity, Cb, bgColor.a);`:d.glsl`
          vec4 pmColorLayer = vec4(colorLayer.xyz, 1.0);
          float composeAlpha = colorLayer.a * opacity;
          return ${A?d.glsl`bgColor * (1.0 - composeAlpha) + colorLayer * opacity;`:m&&!g||l?d.glsl`pmColorLayer * composeAlpha;`:d.glsl`mix(bgColor, pmColorLayer, composeAlpha);`}`}
    }`)};b.TileBackgroundPassParameters=y;Object.defineProperties(b,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});