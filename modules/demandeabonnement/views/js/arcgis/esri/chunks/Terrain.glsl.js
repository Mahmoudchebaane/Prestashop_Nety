// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./_rollupPluginBabelHelpers ./mat4 ./mat4f64 ./vec3 ./vec3f64 ../views/3d/terrain/interfaces ../views/3d/webgl-engine/core/shaderLibrary/ForwardLinearDepth.glsl ../views/3d/webgl-engine/core/shaderLibrary/ShaderOutput ../views/3d/webgl-engine/core/shaderLibrary/Slice.glsl ../views/3d/webgl-engine/core/shaderLibrary/Transform.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/NormalAttribute.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/PositionAttribute.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/TextureCoordinateAttribute.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/VertexTangent.glsl ../views/3d/webgl-engine/core/shaderLibrary/output/OutputDepth.glsl ../views/3d/webgl-engine/core/shaderLibrary/output/OutputHighlight.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/EvaluateAmbientOcclusion.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/EvaluateSceneLighting.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/MainLighting.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/NormalUtils.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/PhysicallyBasedRenderingParameters.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/ReadShadowMap.glsl ../views/3d/webgl-engine/core/shaderLibrary/terrain/Overlay.glsl ../views/3d/webgl-engine/core/shaderLibrary/terrain/TerrainTexture.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/View.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/WebGL2Utils ../views/3d/webgl-engine/core/shaderModules/Float3PassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/Matrix4DrawUniform ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform".split(" "),
function(u,F,G,v,w,H,I,l,f,J,K,L,M,N,O,x,P,Q,p,y,R,z,S,A,h,q,B,T,b,U,V,W){function C(a){const c=new V.ShaderBuilder,{vertex:e,fragment:d,varyings:k}=c;c.include(M.PositionAttribute);c.include(L.NormalAttribute,a);c.include(N.TextureCoordinateAttribute,a);var r=()=>{c.include(R.NormalUtils,a);e.code.add(b.glsl`
  vec3 decodeNormalTerrain(vec2 e) {
    float z = 1.0 - abs(e.x) - abs(e.y);
    vec3 n = vec3(e + vec2(e.x >= 0.0 ? 1.0 : -1.0, e.y >= 0.0 ? 1.0 : -1.0) * min(z,0.0),z);
    return normalize(n);
  }

  vec3 getNormal() {
    return  ${a.shading?b.glsl`normalize(decodeNormalTerrain(normalCompressed))`:b.glsl`getLocalUp(position, localOrigin)`};
  }
  `)};q.addProjViewLocalOrigin(e,a);c.include(K.Transform,a);const m=a.overlayMode!==A.OverlayMode.Disabled;switch(a.output){case f.ShaderOutput.Color:c.include(h.TerrainTexture,a);c.include(p.EvaluateSceneLighting,a);const n=a.overlayMode===A.OverlayMode.EnabledWithWater;m&&c.include(h.OverlayTerrain,{...a,pbrMode:z.PBRMode.Water});n&&c.include(O.VertexTangent,a);k.add("vnormal","vec3");k.add("vpos","vec3");r();(a.atmosphere||a.screenSizePerspective)&&q.addViewNormal(e);(r=a.receiveShadows&&!a.renderOccluded)&&
c.include(l.ForwardLinearDepth,a);a.atmosphere&&k.add("wnormal","vec3");a.screenSizePerspective&&(k.add("screenSizeDistanceToCamera","float"),k.add("screenSizeCosAngle","float"));e.code.add(b.glsl`
        void main(void) {
          //Position
          vpos = position;
          vec3 positionWorld = position + localOrigin;
          gl_Position = transformPosition(proj, view, vpos);

          //Normal
          vnormal = getNormal();

          ${n?b.glsl`forwardVertexTangent(vnormal);`:b.glsl``}

          ${a.atmosphere?b.glsl`
          wnormal = normalize((viewNormal * vec4(normalize(positionWorld), 1.0)).xyz);`:""}

          //Texture UV
          vec2 uv = getUV0();
          forwardTextureCoordinatesWithTransform(uv);
          ${m?b.glsl`setOverlayVTC(uv);`:""}
          ${a.tileBorders?b.glsl`forwardTextureCoordinates();`:""}

          ${a.screenSizePerspective?b.glsl`
          vec3 viewPos = (view * vec4(vpos, 1.0)).xyz;
          screenSizeDistanceToCamera = length(viewPos);
          vec3 viewSpaceNormal = (viewNormal * vec4(normalize(positionWorld), 1.0)).xyz;
          screenSizeCosAngle = abs(viewSpaceNormal.z);`:""}

          ${r?b.glsl`forwardLinearDepth();`:""}

        }
      `);c.extensions.add("GL_OES_standard_derivatives");c.extensions.add("GL_EXT_shader_texture_lod");c.include(J.SliceDraw,a);c.include(p.EvaluateSceneLighting,a);c.include(Q.EvaluateAmbientOcclusion,a);c.include(S.ReadShadowMapDraw,a);n&&q.addCameraPosition(d,a);p.addAmbientBoostFactor(d);p.addLightingGlobalFactor(d);d.uniforms.add([e.uniforms.get("localOrigin"),new T.Float3PassUniform("viewDirection",(t,g)=>w.normalize(D,w.set(D,g.camera.viewMatrix[12],g.camera.viewMatrix[13],g.camera.viewMatrix[14])))]);
n&&d.uniforms.add([new W.Texture2DPassUniform("ovWaterTex",(t,g)=>0===g.overlays.length?null:g.overlays[I.OverlayIndex.INNER].getNormalTexture(t.overlaySource)),new U.Matrix4DrawUniform("view",(t,g)=>G.translate(X,g.camera.viewMatrix,t.origin))]);d.code.add(b.glsl`const float sliceOpacity = 0.2;
float lum(vec3 c) {
return (min(min(c.r, c.g), c.b) + max(max(c.r, c.g), c.b)) * 0.5;
}`);y.addMainLightDirection(d);y.addMainLightIntensity(d);d.code.add(b.glsl`
        void main() {
          vec3 normal = normalize(vnormal);
          float vndl = dot(normal, mainLightDirection);

          float additionalAmbientScale = smoothstep(0.0, 1.0, clamp(vndl*2.5, 0.0, 1.0));
          float shadow = ${a.receiveShadows&&!a.renderOccluded?"readShadowMap(vpos, linearDepth)":a.spherical&&a.shading?"lightingGlobalFactor * (1.0 - additionalAmbientScale)":"0.0"};

          float ssao = evaluateAmbientOcclusionInverse();
          vec4 tileColor = getTileColor();

          ${m?b.glsl`
              vec4 overlayColorOpaque = getOverlayColor(ovColorTex, vtcOverlay);
              vec4 overlayColor = overlayOpacity * overlayColorOpaque;
              ${a.transparent?b.glsl`if (overlayColor.a == 0.0) { discard; }`:""}
              vec4 groundColor = tileColor;
              tileColor = tileColor * (1.0 - overlayColor.a) + overlayColor;`:""}
          if (rejectBySlice(vpos)) {
            tileColor *= sliceOpacity;
          }
          ${a.atmosphere?b.glsl`
              float ndotl = clamp(vndl, 0.0, 1.0);
              vec3 atm = vec3(clamp(1.0 - dot(-viewDirection, wnormal), 0.0, 1.0));
              atm *= clamp(1.0 - lum(tileColor.rgb) * 1.5, 0.0, 1.0); // avoid atmosphere on bright base maps
              atm *= clamp(ndotl * 2.0, 0.0, 1.0); // avoid atmosphere on dark side of the globe
              atm *= tileColor.a; // premultiply with tile alpha`:""}

          vec3 albedo = ${a.atmosphere?b.glsl`atm + tileColor.rgb;`:b.glsl`tileColor.rgb;`}

          // heuristic shading function used in the old terrain, now used to add ambient lighting

          vec3 additionalLight = ssao * mainLightIntensity * additionalAmbientScale * ambientBoostFactor * lightingGlobalFactor;

          gl_FragColor = vec4(evaluateSceneLighting(normal, albedo, shadow, 1.0 - ssao, additionalLight), tileColor.a);
          ${n?b.glsl`
              vec4 overlayWaterMask = getOverlayColor(ovWaterTex, vtcOverlay);
              float waterNormalLength = length(overlayWaterMask);
              if (waterNormalLength > 0.95) {
                mat3 tbnMatrix = mat3(tbnTangent, tbnBiTangent, vnormal);
                vec4 waterOverlayColor = vec4(overlayColor.w > 0.0 ? overlayColorOpaque.xyz/overlayColor.w : vec3(1.0), overlayColor.w);
                vec4 viewPosition = view*vec4(vpos, 1.0);
                vec4 waterColorLinear = getOverlayWaterColor(overlayWaterMask, waterOverlayColor, -normalize(vpos - cameraPosition), shadow, vnormal, tbnMatrix, viewPosition.xyz,  vpos + localOrigin);
                vec4 waterColorNonLinear = delinearizeGamma(vec4(waterColorLinear.xyz, 1.0));
                // un-gamma the ground color to mix in linear space
                gl_FragColor = mix(groundColor, waterColorNonLinear, waterColorLinear.w);
              }`:""}
          ${a.screenSizePerspective?b.glsl`
            float perspectiveScale = screenSizePerspectiveScaleFloat(1.0, screenSizeCosAngle, screenSizeDistanceToCamera, vec4(0.0, 0.0, 0.0, 0.0));
            if (perspectiveScale <= 0.25) {
              gl_FragColor = mix(gl_FragColor, vec4(1.0, 0.0, 0.0, 1.0), perspectiveScale * 4.0);
            }
            else if (perspectiveScale <= 0.5) {
              gl_FragColor = mix(gl_FragColor, vec4(0.0, 0.0, 1.0, 1.0), (perspectiveScale - 0.25) * 4.0);
            }
            else if (perspectiveScale >= 0.99) {
              gl_FragColor = mix(gl_FragColor, vec4(0.0, 1.0, 0.0, 1.0), 0.2);
            }
            else {
              gl_FragColor = mix(gl_FragColor, vec4(1.0, 0.0, 1.0, 1.0), (perspectiveScale - 0.5) * 2.0);
            }`:""}
          ${a.visualizeNormals?a.spherical?b.glsl`
              vec3 localUp = normalize(vpos + localOrigin);
              vec3 right = normalize(cross(vec3(0.0,0.0,1.0),localUp));
              vec3 forward = normalize(cross(localUp,right));
              mat3 tbn = mat3(right, forward, localUp);
              vec3 tNormal = normalize(normal* tbn);
              gl_FragColor = vec4(vec3(0.5) + 0.5 * tNormal, 0.0);
          `:b.glsl`
          vec3 tNormal = normalize(normal);
          gl_FragColor = vec4(vec3(0.5) + 0.5 * tNormal, 0.0);
      `:""}
          ${a.tileBorders?b.glsl`
              vec2 dVuv = fwidth(vuv0);
              vec2 edgeFactors = smoothstep(vec2(0.0), 1.5 * dVuv, min(vuv0, 1.0 - vuv0));
              float edgeFactor = 1.0 - min(edgeFactors.x, edgeFactors.y);
              gl_FragColor = mix(gl_FragColor, vec4(1.0, 0.0, 0.0, 1.0), edgeFactor);`:""}
          gl_FragColor = highlightSlice(gl_FragColor, vpos);
        }
      `);break;case f.ShaderOutput.Depth:c.include(h.OverlayTerrain,a);c.include(x.OutputDepth,a);l.addLinearDepth(c);l.addNearFar(c);e.code.add(b.glsl`
              void main(void) {
                ${m?b.glsl`setOverlayVTC(getUV0());`:""}
                gl_Position = transformPositionWithDepth(proj, view, position, nearFar, linearDepth);
              }
          `);d.code.add(b.glsl`
              void main() {
                ${m?b.glsl`
                  vec4 overlayColor = getCombinedOverlayColor();
                  ${a.transparent?b.glsl`if (overlayColor.a == 0.0) { discard; }`:""}`:""}
                outputDepth(linearDepth);
              }
          `);break;case f.ShaderOutput.Shadow:case f.ShaderOutput.ShadowHighlight:case f.ShaderOutput.ShadowExludeHighlight:c.include(x.OutputDepth,a);l.addLinearDepth(c);l.addNearFar(c);e.code.add(b.glsl`void main(void) {
gl_Position = transformPositionWithDepth(proj, view, position, nearFar, linearDepth);
}`);d.code.add(b.glsl`void main() {
outputDepth(linearDepth);
}`);break;case f.ShaderOutput.Normal:k.add("vnormal","vec3");q.addViewNormal(e);r();e.code.add(b.glsl`void main(void) {
vec3 normal = getNormal();
gl_Position = transformPosition(proj, view, position);
vnormal = normalize((viewNormal * vec4(normal, 1.0)).xyz);
}`);d.code.add(b.glsl`void main() {
vec3 normal = normalize(vnormal);
if (gl_FrontFacing == false) {
normal = -normal;
}
gl_FragColor = vec4(vec3(0.5) + 0.5 * normal, 0.0);
}`);break;case f.ShaderOutput.Highlight:c.include(h.OverlayTerrain,a),e.code.add(b.glsl`void main() {
setOverlayVTC(getUV0());
gl_Position = transformPosition(proj, view, position);
}`),c.include(P.OutputHighlight,a),d.code.add(b.glsl`void main() {
vec4 overlayColor = getCombinedOverlayColor();
if (overlayColor.a == 0.0) {
discard;
}
outputHighlight();
}`)}a.output===f.ShaderOutput.ObjectAndLayerIdColor&&(c.include(h.OverlayTerrain,{...a,pbrMode:z.PBRMode.Disabled}),e.code.add(b.glsl`void main(void) {
gl_Position = transformPosition(proj, view, position);
setOverlayVTC(getUV0());
}`),d.code.add(b.glsl`
        void main() {
          vec2 texDim =  ${B.textureSize(a,"ovColorTex")};
          gl_FragColor =  ${B.texelFetch(a,"ovColorTex","vec2(vtcOverlay.x * 0.5, vtcOverlay.y)*texDim")};
        }
    `));return c}let E=function(a){function c(){return a.apply(this,arguments)||this}F._inheritsLoose(c,a);return c}(h.OverlayTerrainPassParameters);const X=v.create(),D=H.create();v=Object.freeze(Object.defineProperty({__proto__:null,TerrainPassParameters:E,build:C},Symbol.toStringTag,{value:"Module"}));u.Terrain=v;u.TerrainPassParameters=E;u.build=C});