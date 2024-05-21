// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./_rollupPluginBabelHelpers ./vec3f64 ../views/2d/engine/imagery/enums ../views/3d/webgl-engine/core/shaderLibrary/raster/Colormap.glsl ../views/3d/webgl-engine/core/shaderLibrary/raster/Common.glsl ../views/3d/webgl-engine/core/shaderLibrary/terrain/TileBackground.glsl ../views/3d/webgl-engine/core/shaderLibrary/terrain/TileComposite.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/ColorConversion.glsl ../views/3d/webgl-engine/core/shaderModules/BooleanPassUniform ../views/3d/webgl-engine/core/shaderModules/Float2PassUniform ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/FloatsPassUniform ../views/3d/webgl-engine/core/shaderModules/IntegerPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform".split(" "),
function(g,m,v,k,w,n,x,y,z,A,p,h,f,q,e,B,C){function r(b){const c=new B.ShaderBuilder;c.include(y.TileComposite);c.include(n.Common,b);c.include(w.Colormap,b);c.include(x.TileBackground,b);c.fragment.code.add(e.glsl`vec4 applyBackgroundBlend(vec4 layerColor) {
vec4 bgColor = getBackground(vuv);
return blendLayers(bgColor, layerColor, u_opacity);
}`);b.colorizerType===k.RasterColorizerType.Stretch?D(c,b):b.colorizerType===k.RasterColorizerType.Lut?c.fragment.code.add(e.glsl`void main() {
vec2 pixelLocation = getPixelLocation(uv);
if (isOutside(pixelLocation)) {
gl_FragColor = applyBackgroundBlend(vec4(0.0, 0.0, 0.0, 0.0));
return;
}
vec4 currentPixel = getPixel(pixelLocation);
gl_FragColor = applyBackgroundBlend(colormap(currentPixel, true));
}`):b.colorizerType===k.RasterColorizerType.Hillshade&&E(c,b);return c}function D(b,c){b.fragment.uniforms.add([new q.IntegerPassUniform("u_bandCount",d=>d.symbolizer.u_bandCount),new f.FloatsPassUniform("u_minCutOff",d=>d.symbolizer.u_minCutOff,3),new f.FloatsPassUniform("u_maxCutOff",d=>d.symbolizer.u_maxCutOff,3),new f.FloatsPassUniform("u_factor",d=>d.symbolizer.u_factor,3),new h.FloatPassUniform("u_minOutput",d=>d.symbolizer.u_minOutput),new h.FloatPassUniform("u_maxOutput",d=>d.symbolizer.u_maxOutput),
new A.BooleanPassUniform("u_useGamma",d=>d.symbolizer.u_useGamma),new f.FloatsPassUniform("u_gamma",d=>d.symbolizer.u_gamma,3),new f.FloatsPassUniform("u_gammaCorrection",d=>d.symbolizer.u_gammaCorrection,3),new h.FloatPassUniform("u_opacity",d=>d.common.u_opacity)]);b.fragment.code.add(e.glsl`float stretchOneValue(float val, float minCutOff, float maxCutOff, float minOutput, float maxOutput, float factor, bool useGamma, float gamma, float gammaCorrection) {
if (val >= maxCutOff) {
return maxOutput;
} else if (val <= minCutOff) {
return minOutput;
}
float stretchedVal;
if (useGamma) {
float tempf = 1.0;
float outRange = maxOutput - minOutput;
float relativeVal = (val - minCutOff) / (maxCutOff - minCutOff);
if (gamma > 1.0) {
tempf -= pow(1.0 / outRange, relativeVal * gammaCorrection);
}
stretchedVal = (tempf * outRange * pow(relativeVal, 1.0 / gamma) + minOutput) / 255.0;
} else {
stretchedVal = minOutput + (val - minCutOff) * factor;
}
return stretchedVal;
}`);const a=c.applyColormap?e.glsl`gl_FragColor = applyBackgroundBlend(colormap(vec4(grayVal, grayVal, grayVal, currentPixel.a), !u_useGamma));`:e.glsl`gl_FragColor = applyBackgroundBlend(vec4(grayVal, grayVal, grayVal, currentPixel.a));`;b.fragment.code.add(e.glsl`
      void main() {
        vec2 pixelLocation = getPixelLocation(uv);
        if (isOutside(pixelLocation)) {
          gl_FragColor = applyBackgroundBlend(vec4(0.0, 0.0, 0.0, 0.0));
          return;
        }

        vec4 currentPixel = getPixel(pixelLocation);
        ${c.stretchType===k.RasterColorizerStretchType.Noop?e.glsl`
        gl_FragColor = applyBackgroundBlend(currentPixel);`:e.glsl`
        if (currentPixel.a == 0.0) {
          gl_FragColor = applyBackgroundBlend(vec4(0.0, 0.0, 0.0, 0.0));
          return;
        }
        if (u_bandCount == 1) {
          float grayVal = stretchOneValue(currentPixel.r, u_minCutOff[0], u_maxCutOff[0], u_minOutput, u_maxOutput, u_factor[0], u_useGamma, u_gamma[0], u_gammaCorrection[0]);
          ${a}
        } else {
          float redVal = stretchOneValue(currentPixel.r, u_minCutOff[0], u_maxCutOff[0], u_minOutput, u_maxOutput, u_factor[0], u_useGamma, u_gamma[0], u_gammaCorrection[0]);
          float greenVal = stretchOneValue(currentPixel.g, u_minCutOff[1], u_maxCutOff[1], u_minOutput, u_maxOutput, u_factor[1], u_useGamma, u_gamma[1], u_gammaCorrection[1]);
          float blueVal = stretchOneValue(currentPixel.b, u_minCutOff[2], u_maxCutOff[2], u_minOutput, u_maxOutput, u_factor[2], u_useGamma, u_gamma[2], u_gammaCorrection[2]);
          gl_FragColor = applyBackgroundBlend(vec4(redVal, greenVal, blueVal, currentPixel.a));
        }`}
      }`)}function E(b,c){b=b.fragment;b.uniforms.add([new C.Texture2DPassUniform("u_image",a=>a.u_image),new q.IntegerPassUniform("u_hillshadeType",a=>a.symbolizer.u_hillshadeType),new f.FloatsPassUniform("u_sinZcosAs",a=>a.symbolizer.u_sinZcosAs,6),new f.FloatsPassUniform("u_sinZsinAs",a=>a.symbolizer.u_sinZsinAs,6),new f.FloatsPassUniform("u_cosZs",a=>a.symbolizer.u_cosZs,6),new f.FloatsPassUniform("u_weights",a=>a.symbolizer.u_weights,6),new p.Float2PassUniform("u_factor",a=>a.symbolizer.u_factor),
new h.FloatPassUniform("u_minValue",a=>a.symbolizer.u_minValue),new h.FloatPassUniform("u_maxValue",a=>a.symbolizer.u_maxValue),new p.Float2PassUniform("u_srcImageSize",a=>a.common.u_srcImageSize)]);b.include(z.ColorConversion);b.code.add(e.glsl`vec4 overlay(float val, float minValue, float maxValue, float hillshade, float alpha) {
val = clamp((val - minValue) / (maxValue - minValue), 0.0, 1.0);
vec3 hsv = rgb2hsv(colormap(vec4(val, val, val, 1.0), false).rgb);
hsv.z = hillshade;
return vec4(hsv2rgb(hsv) * alpha, alpha);
}`);b.code.add(e.glsl`float getNeighborHoodAlpha(float a, float b, float c, float d, float e, float f, float g, float h, float i){
if (a == 0.0 || a == 0.0 || a==0.0 || a == 0.0 || a == 0.0 || a==0.0 || a == 0.0 || a == 0.0 || a==0.0) {
return 0.0;
}  else {
return e;
}
}`);c=c.applyColormap?e.glsl`gl_FragColor = applyBackgroundBlend(overlay(ve.r, u_minValue, u_maxValue, hillshade, alpha));`:e.glsl`hillshade *= alpha;
gl_FragColor = applyBackgroundBlend(vec4(hillshade, hillshade, hillshade, alpha));`;b.code.add(e.glsl`
    void main() {
      vec2 pixelLocation = getPixelLocation(uv);
      if (isOutside(pixelLocation)) {
        gl_FragColor = applyBackgroundBlend(vec4(0.0, 0.0, 0.0, 0.0));
        return;
      }

      vec4 currentPixel = getPixel(pixelLocation);
      if (currentPixel.a == 0.0) {
        gl_FragColor = applyBackgroundBlend(vec4(0.0, 0.0, 0.0, 0.0));
        return;
      }

      //mirror edge pixels
      vec2 axy = vec2(-1.0, -1.0);
      vec2 bxy = vec2(0.0, -1.0);
      vec2 cxy = vec2(1.0, -1.0);
      vec2 dxy = vec2(-1.0, 0.0);
      vec2 fxy = vec2(1.0, 0.0);
      vec2 gxy = vec2(-1.0, 1.0);
      vec2 hxy = vec2(0.0, 1.0);
      vec2 ixy = vec2(1.0, 1.0);
      vec2 onePixel = 1.0 / u_srcImageSize;
      if (pixelLocation.s < onePixel.s) {
        axy[0] = 1.0;
        dxy[0] = 1.0;
        gxy[0] = 1.0;
      }
      if (pixelLocation.t < onePixel.t) {
        axy[1] = 1.0;
        bxy[1] = 1.0;
        cxy[1] = 1.0;
      }
      if (pixelLocation.s > 1.0 - onePixel.s) {
        cxy[0] = -1.0;
        fxy[0] = -1.0;
        ixy[0] = -1.0;
      }
      if (pixelLocation.t > 1.0 - onePixel.t) {
        gxy[1] = -1.0;
        hxy[1] = -1.0;
        ixy[1] = -1.0;
      }

      // calculate hillshade
      vec4 va = texture2D(u_image, pixelLocation + onePixel * axy);
      vec4 vb = texture2D(u_image, pixelLocation + onePixel * bxy);
      vec4 vc = texture2D(u_image, pixelLocation + onePixel * cxy);
      vec4 vd = texture2D(u_image, pixelLocation + onePixel * dxy);
      vec4 ve = texture2D(u_image, pixelLocation);
      vec4 vf = texture2D(u_image, pixelLocation + onePixel * fxy);
      vec4 vg = texture2D(u_image, pixelLocation + onePixel * gxy);
      vec4 vh = texture2D(u_image, pixelLocation + onePixel * hxy);
      vec4 vi = texture2D(u_image, pixelLocation + onePixel * ixy);

      // calculate the rate of z change along the x, y, and diagonal direction
      float dzx = (vc + 2.0 * vf + vi - va - 2.0 * vd - vg).r * u_factor.s;
      float dzy = (vg + 2.0 * vh + vi - va - 2.0 * vb - vc).r * u_factor.t;
      float dzd = sqrt(1.0 + dzx * dzx + dzy * dzy);
      float hillshade = 0.0;

      // traditional single light source
      if (u_hillshadeType == 0){
        float cosDelta = u_sinZsinAs[0] * dzy - u_sinZcosAs[0] * dzx;
        float z = (u_cosZs[0] + cosDelta) / dzd;
        if (z < 0.0)  z = 0.0;
        hillshade = z;
      } else {
        // multi-directional with 6 light sources
        for (int k = 0; k < 6; k++) {
        float cosDelta = u_sinZsinAs[k] * dzy - u_sinZcosAs[k] * dzx;
        float z = (u_cosZs[k] + cosDelta) / dzd;
        if (z < 0.0) z = 0.0;
        hillshade = hillshade + z * u_weights[k];
        if (k == 5) break;
        }
      }

      // set color
      float alpha = getNeighborHoodAlpha(va.a, vb.a, vc.a, vd.a, ve.a, vf.a, vg.a, vh.a, vi.a);
      alpha *= u_opacity;
      ${c}
    }
  `)}let l=function(b){function c(a,d,F,G,H,I){a=b.call(this,a,G,H)||this;a.colormap=d;a.symbolizer=F;a.u_colormap=I;a.backgroundColor=v.ZEROS;a.fboTexture=null;a.baseOpacity=1;return a}m._inheritsLoose(c,b);return c}(n.CommonPassParameters),t=function(b){function c(){return b.apply(this,arguments)||this}m._inheritsLoose(c,b);return c}(l),u=function(b){function c(){return b.apply(this,arguments)||this}m._inheritsLoose(c,b);return c}(l);const J=Object.freeze(Object.defineProperty({__proto__:null,ColorizerUniforms:l,
ColorizerStretchUniforms:t,ColorizerHillshadeUniforms:u,build:r},Symbol.toStringTag,{value:"Module"}));g.ColorizerHillshadeUniforms=u;g.ColorizerStretchUniforms=t;g.ColorizerUniforms=l;g.RasterColorizer=J;g.build=r});