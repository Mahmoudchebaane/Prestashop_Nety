// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../util/WebGL2Utils","../../shaderModules/FloatPassUniform","../../shaderModules/interfaces","../../shaderModules/Texture2DPassUniform"],function(c,e,b,f,g){c.Colormap=function(d,h){d.fragment.uniforms.add([new g.Texture2DPassUniform("u_colormap",a=>a.u_colormap),new b.FloatPassUniform("u_colormapOffset",a=>a.colormap.u_colormapOffset),new b.FloatPassUniform("u_colormapMaxIndex",a=>a.colormap.u_colormapMaxIndex),new b.FloatPassUniform("u_opacity",a=>a.common.u_opacity)]);d.fragment.code.add(f.glsl`
    vec4 colormap(vec4 currentPixel, bool isFloat) {
      float colorIndex = isFloat ? currentPixel.r - u_colormapOffset : currentPixel.r * 255.0 - u_colormapOffset;
      vec4 result;
      // handle no data and out of range pixels
      if (currentPixel.a == 0.0 || colorIndex > u_colormapMaxIndex) {
        result = vec4(0.0, 0.0, 0.0, 0.0);
      } else {
        // colormap lookup
        vec2 texelCoordinates = vec2((colorIndex + 0.5), 0.5);
        result = ${e.texelFetch(h,"u_colormap","texelCoordinates","(1.0 / vec2(u_colormapMaxIndex + 1.0, 1.0))")};
      }
      return result;
    }
  `)};Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});