// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../core/maybe ../util/RgbaFloatEncoding.glsl ../util/View.glsl ../util/WebGL2Utils ../../shaderModules/Float4PassUniform ../../shaderModules/FloatPassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType ../../../materials/StippleTextureRepository ../../../shaders/ensureColor4".split(" "),function(h,m,q,r,t,u,g,b,v,n,k,w){function x(d,a){const y=!(a.draped&&a.stipplePreferContinuous),{vertex:f,fragment:e}=
d;e.include(q.RgbaFloatEncoding);a.draped||(r.addCameraPosition(f,a),f.uniforms.add(new g.FloatPassUniform("worldToScreenPerDistanceRatio",(c,l)=>1/l.camera.perScreenPixelRatio)),f.code.add(b.glsl`float computeWorldToScreenRatio(vec3 segmentCenter) {
float segmentDistanceToCamera = length(segmentCenter - cameraPosition);
return worldToScreenPerDistanceRatio / segmentDistanceToCamera;
}`));d.varyings.add("vStippleDistance","float");a.stippleRequiresClamp&&d.varyings.add("vStippleDistanceLimits","vec2");a.stippleRequiresStretchMeasure&&d.varyings.add("vStipplePatternStretch","float");f.code.add(b.glsl`
    float discretizeWorldToScreenRatio(float worldToScreenRatio) {
      float step = ${z};

      float discreteWorldToScreenRatio = log(worldToScreenRatio);
      discreteWorldToScreenRatio = ceil(discreteWorldToScreenRatio / step) * step;
      discreteWorldToScreenRatio = exp(discreteWorldToScreenRatio);
      return discreteWorldToScreenRatio;
    }
  `);f.code.add(b.glsl`vec2 computeStippleDistanceLimits(float startPseudoScreen, float segmentLengthPseudoScreen, float segmentLengthScreen, float patternLength) {`);f.code.add(b.glsl`
    if (segmentLengthPseudoScreen >= ${y?"patternLength":"1e4"}) {
  `);f.uniforms.add(new g.FloatPassUniform("pixelRatio",(c,l)=>l.camera.pixelRatio));f.code.add(b.glsl`
        // Round the screen length to get an integer number of pattern repetitions (minimum 1).
        float repetitions = segmentLengthScreen / (patternLength * pixelRatio);
        float flooredRepetitions = max(1.0, floor(repetitions + 0.5));
        float segmentLengthScreenRounded = flooredRepetitions * patternLength;

        ${a.stippleRequiresStretchMeasure?b.glsl`
              float stretch = repetitions / flooredRepetitions;

              // We need to impose a lower bound on the stretch factor to prevent the dots from merging together when there is only 1 repetition.
              // 0.75 is the lowest possible stretch value for flooredRepetitions > 1, so it makes sense as lower bound.
              vStipplePatternStretch = max(0.75, stretch);`:""}

        return vec2(0.0, segmentLengthScreenRounded);
      }
      return vec2(startPseudoScreen, startPseudoScreen + segmentLengthPseudoScreen);
    }
  `);e.constants.add("stippleTexturePadding","float",k.STIPPLE_TEXTURE_PADDING);e.uniforms.add(v.createTexture2DPassSizeUniforms("stipplePatternTexture",c=>c.stippleTexture,a.hasWebGL2Context?n.TextureSizeUniformType.None:n.TextureSizeUniformType.Size));e.uniforms.add([new g.FloatPassUniform("stipplePatternSDFNormalizer",c=>{c=c.stipplePattern;return m.isSome(c)?(Math.floor(.5*(k.computeLongestPattern(c)-1))+.5)/c.pixelRatio:1}),new g.FloatPassUniform("stipplePatternPixelSizeInv",c=>1/p(c))]);e.code.add(b.glsl`
    float padStippleTexture(float u) {
      float paddedTextureSize = ${t.textureSize(a,"stipplePatternTexture")}.x;
      float unpaddedTextureSize = paddedTextureSize - stippleTexturePadding;

      return (u * unpaddedTextureSize + stippleTexturePadding * 0.5) / paddedTextureSize;
    }
  `);e.code.add(b.glsl`
    float getStippleSDF(out bool isClamped) {
      ${a.stippleRequiresClamp?b.glsl`
          float stippleDistanceClamped = clamp(vStippleDistance, vStippleDistanceLimits.x, vStippleDistanceLimits.y);
          vec2 aaCorrectedLimits = vStippleDistanceLimits + vec2(1.0, -1.0) / gl_FragCoord.w;
          isClamped = vStippleDistance < aaCorrectedLimits.x || vStippleDistance > aaCorrectedLimits.y;`:b.glsl`
          float stippleDistanceClamped = vStippleDistance;
          isClamped = false;`}

      float u = stippleDistanceClamped * gl_FragCoord.w * stipplePatternPixelSizeInv;
      ${a.stippleScaleWithLineWidth?b.glsl`u *= vLineSizeInv;`:""}
      u = padStippleTexture(fract(u));

      float encodedSDF = rgba2float(texture2D(stipplePatternTexture, vec2(u, 0.5)));
      float sdf = (encodedSDF * 2.0 - 1.0) * stipplePatternSDFNormalizer;

      ${a.stippleRequiresStretchMeasure?b.glsl`return (sdf - 0.5) * vStipplePatternStretch + 0.5;`:b.glsl`return sdf;`}
    }

    float getStippleSDF() {
      bool ignored;
      return getStippleSDF(ignored);
    }

    float getStippleAlpha() {
      bool isClamped;
      float stippleSDF = getStippleSDF(isClamped);

      float antiAliasedResult = ${a.stippleScaleWithLineWidth?b.glsl`clamp(stippleSDF * vLineWidth + 0.5, 0.0, 1.0);`:b.glsl`clamp(stippleSDF + 0.5, 0.0, 1.0);`}

      return isClamped ? floor(antiAliasedResult + 0.5) : antiAliasedResult;
    }
  `);a.stippleOffColorEnabled?(e.uniforms.add(new u.Float4PassUniform("stippleOffColor",c=>w.ensureColor4(c.stippleOffColor))),e.code.add(b.glsl`#define discardByStippleAlpha(stippleAlpha, threshold) {}
#define blendStipple(color, stippleAlpha) mix(color, stippleOffColor, stippleAlpha)`)):e.code.add(b.glsl`#define discardByStippleAlpha(stippleAlpha, threshold) if (stippleAlpha < threshold) { discard; }
#define blendStipple(color, stippleAlpha) vec4(color.rgb, color.a * stippleAlpha)`)}function p(d){const a=d.stipplePattern;return m.isSome(a)?k.computeTextureSize(d.stipplePattern)/a.pixelRatio:1}const z=b.glsl.float(.4);h.LineStipple=function(d,a){d.constants.add("stippleAlphaColorDiscard","float",.001);d.constants.add("stippleAlphaHighlightDiscard","float",.5);a.stippleEnabled?x(d,a):d.fragment.code.add(b.glsl`float getStippleAlpha() { return 1.0; }
#define discardByStippleAlpha(_stippleAlpha_, _threshold_) {}
#define blendStipple(color, _stippleAlpha_) color`)};h.computePixelSize=p;Object.defineProperties(h,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});