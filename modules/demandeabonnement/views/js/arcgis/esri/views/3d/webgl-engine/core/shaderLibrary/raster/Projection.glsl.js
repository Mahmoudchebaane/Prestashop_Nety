// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../util/WebGL2Utils ../../shaderModules/Float2PassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType".split(" "),function(e,c,f,h,k,g){e.Projection=function(d,a){d.fragment.uniforms.add(k.createTexture2DPassSizeUniforms("u_transformGrid",b=>b.u_transformGrid,a.hasWebGL2Context?g.TextureSizeUniformType.None:g.TextureSizeUniformType.InvSize));d.fragment.uniforms.add(new f.Float2PassUniform("u_transformSpacing",b=>
b.common.u_transformSpacing));d.fragment.uniforms.add(new f.Float2PassUniform("u_targetImageSize",b=>b.common.u_targetImageSize));d.fragment.code.add(h.glsl`
    vec2 projectPixelLocation(vec2 coords) {
      // Pixel index in row/column, corresponds to upperleft corner, e.g. [100, 20]
      vec2 index_image = floor(coords * u_targetImageSize);

      // Pixel's corresponding cell index in transform grid
      // Each transform cell corresponds to 4 pixels: 6 coefficients from lowerleft triangle followed by 6 coefficients from upperright triangle
      vec2 oneTransformPixel = vec2(4.0, 1.0);
      vec2 index_transform = floor(index_image / u_transformSpacing) * oneTransformPixel;

      // Correspoding position in transform grid cell, cell center coordinates
      vec2 pos = fract((index_image + 0.5) / u_transformSpacing);

      // Pixel's corresponding transform cell location, cell center coordinates
      vec2 transform_location = index_transform + 0.5;

      vec2 srcLocation;

      // Use lower triangle or upper triangle
      if (pos.s <= pos.t) {
        vec3 ll_abc = ${c.texelFetch(a,"u_transformGrid","transform_location")}.rgb;
        vec3 ll_def = ${c.texelFetch(a,"u_transformGrid","vec2(transform_location.s + 1.0, transform_location.t)")}.rgb;
        srcLocation.s = dot(ll_abc, vec3(pos, 1.0));
        srcLocation.t = dot(ll_def, vec3(pos, 1.0));
      } else {
        vec3 ur_abc = ${c.texelFetch(a,"u_transformGrid","vec2(transform_location.s + 2.0, transform_location.t)")}.rgb;
        vec3 ur_def = ${c.texelFetch(a,"u_transformGrid","vec2(transform_location.s + 3.0, transform_location.t)")}.rgb;
        srcLocation.s = dot(ur_abc, vec3(pos, 1.0));
        srcLocation.t = dot(ur_def, vec3(pos, 1.0));
      }

      return srcLocation;
    }
  `)};Object.defineProperties(e,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});