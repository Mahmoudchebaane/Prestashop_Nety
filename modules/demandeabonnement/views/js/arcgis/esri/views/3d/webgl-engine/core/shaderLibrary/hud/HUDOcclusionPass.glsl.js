// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../output/ReadLinearDepth.glsl ../shading/MultipassGeometryTest.glsl ../util/RgbaFloatEncoding.glsl ../util/WebGL2Utils ../../shaderModules/Float2PassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType".split(" "),function(e,k,l,m,n,p,b,q,f){e.HUDOcclusionPass=function(g,a){const {vertex:h,fragment:c}=g;a.hasMultipassGeometry&&h.include(l.multipassGeometryTest);a.hasMultipassTerrain&&g.varyings.add("depth","float");
h.code.add(b.glsl`
  void main(void) {
    vec4 posProjCenter;
    if (dot(position, position) > 0.0) {
      // Render single point to center of the pixel to avoid subpixel
      // filtering to affect the marker color
      ProjectHUDAux projectAux;
      vec4 posProj = projectPositionHUD(projectAux);
      posProjCenter = alignToPixelCenter(posProj, viewport.zw);

      ${a.hasMultipassGeometry?b.glsl`
        // Don't draw vertices behind geometry
        if(geometryDepthTest(.5 + .5 * posProjCenter.xy / posProjCenter.w, projectAux.posView.z)){
          posProjCenter = vec4(1e038, 1e038, 1e038, 1.0);
        }`:""}

      ${a.hasMultipassTerrain?"depth \x3d projectAux.posView.z;":""}
      vec3 vpos = projectAux.posModel;
      if (rejectBySlice(vpos)) {
        // Project out of clip space
        posProjCenter = vec4(1e038, 1e038, 1e038, 1.0);
      }

    } else {
      // Project out of clip space
      posProjCenter = vec4(1e038, 1e038, 1e038, 1.0);
    }

    gl_Position = posProjCenter;
    gl_PointSize = 1.0;
  }
  `);a.hasMultipassTerrain&&c.include(k.ReadLinearDepth);a.hasMultipassTerrain&&c.uniforms.add([...q.createTexture2DPassSizeUniforms("terrainDepthTexture",(r,d)=>d.multipassTerrain.linearDepthTexture,a.hasWebGL2Context?f.TextureSizeUniformType.None:f.TextureSizeUniformType.InvSize),new p.Float2PassUniform("nearFar",(r,d)=>d.camera.nearFar)]);c.include(m.RgbaFloatEncoding);c.code.add(b.glsl`
  void main() {
    gl_FragColor = vec4(1, 1, 1, 1);
    ${a.hasMultipassTerrain?b.glsl`
          vec2 uv = gl_FragCoord.xy;

          // Read the rgba data from the texture linear depth
          vec4 terrainDepthData = ${n.texelFetch(a,"terrainDepthTexture","uv")};

          float terrainDepth = linearDepthFromFloat(rgba2float(terrainDepthData), nearFar);

          // If HUD vertex is behind terrain and the terrain depth is not the initialize value (e.g. we are not looking at the sky)
          // Mark the HUD vertex as occluded by transparent terrain
          if(depth < terrainDepth && terrainDepthData != vec4(0,0,0,1)){
            gl_FragColor.g = 0.5;
          }`:""}
  }
  `)};Object.defineProperties(e,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});