// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../attributes/VerticalOffset.glsl ./HUDUniforms ../util/ScreenSizePerspective.glsl ../util/View.glsl ../../shaderModules/Float4PassUniform ../../shaderModules/FloatPassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../../lib/VertexAttribute".split(" "),function(d,n,l,m,h,p,g,e,q,k){d.HUDSpace=void 0;(function(a){a[a.World=0]="World";a[a.Screen=1]="Screen";a[a.COUNT=2]="COUNT"})(d.HUDSpace||(d.HUDSpace={}));d.HUD=function(a,b){a.include(m.ScreenSizePerspective);
a.attributes.add(k.VertexAttribute.POSITION,"vec3");a.attributes.add(k.VertexAttribute.NORMAL,"vec3");a.attributes.add(k.VertexAttribute.AUXPOS1,"vec4");a=a.vertex;h.addProjViewLocalOrigin(a,b);h.addCameraPosition(a,b);a.uniforms.add([new p.Float4PassUniform("viewport",(f,c)=>c.camera.fullViewport),new g.FloatPassUniform("polygonOffset",f=>f.shaderPolygonOffset),new g.FloatPassUniform("cameraGroundRelative",(f,c)=>c.camera.aboveGround?1:-1),new g.FloatPassUniform("renderTransparentlyOccludedHUD",
(f,c)=>c.renderTransparentlyOccludedHUD===l.HUDTransparentRenderStyle.Occluded?1:c.renderTransparentlyOccludedHUD===l.HUDTransparentRenderStyle.NotOccluded?0:.75),new q.Texture2DPassUniform("hudVisibilityTexture",(f,c)=>c.hudVisibilityTexture)]);b.hasVerticalOffset&&n.addVerticalOffset(a);a.constants.add("smallOffsetAngle","float",.984807753012208);a.code.add(e.glsl`struct ProjectHUDAux {
vec3 posModel;
vec3 posView;
vec3 vnormal;
float distanceToCamera;
float absCosAngle;
};`);a.code.add(e.glsl`float applyHUDViewDependentPolygonOffset(float pointGroundDistance, float absCosAngle, inout vec3 posView) {
float pointGroundSign = sign(pointGroundDistance);
if (pointGroundSign == 0.0) {
pointGroundSign = cameraGroundRelative;
}
float groundRelative = cameraGroundRelative * pointGroundSign;
if (polygonOffset > .0) {
float cosAlpha = clamp(absCosAngle, 0.01, 1.0);
float tanAlpha = sqrt(1.0 - cosAlpha * cosAlpha) / cosAlpha;
float factor = (1.0 - tanAlpha / viewport[2]);
if (groundRelative > 0.0) {
posView *= factor;
}
else {
posView /= factor;
}
}
return groundRelative;
}`);b.isDraped&&!b.hasVerticalOffset||h.addViewNormal(a);b.isDraped||(a.uniforms.add(new g.FloatPassUniform("perDistancePixelRatio",(f,c)=>Math.tan(c.camera.fovY/2)/(c.camera.fullViewport[2]/2))),a.code.add(e.glsl`void applyHUDVerticalGroundOffset(vec3 normalModel, inout vec3 posModel, inout vec3 posView) {
float distanceToCamera = length(posView);
float pixelOffset = distanceToCamera * perDistancePixelRatio * 0.5;
vec3 modelOffset = normalModel * cameraGroundRelative * pixelOffset;
vec3 viewOffset = (viewNormal * vec4(modelOffset, 1.0)).xyz;
posModel += modelOffset;
posView += viewOffset;
}`));b.screenCenterOffsetUnitsEnabled===d.HUDSpace.Screen&&a.uniforms.add(new g.FloatPassUniform("pixelRatio",(f,c)=>c.camera.pixelRatio));b.hasScreenSizePerspective&&m.addScreenSizePerspectiveAlignment(a);a.code.add(e.glsl`
    vec4 projectPositionHUD(out ProjectHUDAux aux) {
      // centerOffset is in view space and is used to implement world size offsetting
      // of labels with respect to objects. It also pulls the label towards the viewer
      // so that the label is visible in front of the object.
      vec3 centerOffset = auxpos1.xyz;

      // The pointGroundDistance is the distance of the geometry to the ground and is
      // negative if the point is below the ground, or positive if the point is above
      // ground.
      float pointGroundDistance = auxpos1.w;

      aux.posModel = position;
      aux.posView = (view * vec4(aux.posModel, 1.0)).xyz;
      aux.vnormal = normal;
      ${b.isDraped?"":"applyHUDVerticalGroundOffset(aux.vnormal, aux.posModel, aux.posView);"}

      // Screen sized offset in world space, used for example for line callouts
      // Note: keep this implementation in sync with the CPU implementation, see
      //   - MaterialUtil.verticalOffsetAtDistance
      //   - HUDMaterial.applyVerticalOffsetTransformation

      aux.distanceToCamera = length(aux.posView);

      vec3 viewDirObjSpace = normalize(cameraPosition - aux.posModel);
      float cosAngle = dot(aux.vnormal, viewDirObjSpace);

      aux.absCosAngle = abs(cosAngle);

      ${b.hasScreenSizePerspective?b.hasVerticalOffset||b.screenCenterOffsetUnitsEnabled===d.HUDSpace.Screen?"vec4 perspectiveFactor \x3d screenSizePerspectiveScaleFactor(aux.absCosAngle, aux.distanceToCamera, screenSizePerspectiveAlignment);":"":""}

      ${b.hasVerticalOffset?b.hasScreenSizePerspective?"float verticalOffsetScreenHeight \x3d applyScreenSizePerspectiveScaleFactorFloat(verticalOffset.x, perspectiveFactor);":"float verticalOffsetScreenHeight \x3d verticalOffset.x;":""}

      ${b.hasVerticalOffset?e.glsl`
            float worldOffset = clamp(verticalOffsetScreenHeight * verticalOffset.y * aux.distanceToCamera, verticalOffset.z, verticalOffset.w);
            vec3 modelOffset = aux.vnormal * worldOffset;
            aux.posModel += modelOffset;
            vec3 viewOffset = (viewNormal * vec4(modelOffset, 1.0)).xyz;
            aux.posView += viewOffset;
            // Since we elevate the object, we need to take that into account
            // in the distance to ground
            pointGroundDistance += worldOffset;`:""}

      float groundRelative = applyHUDViewDependentPolygonOffset(pointGroundDistance, aux.absCosAngle, aux.posView);

      ${b.screenCenterOffsetUnitsEnabled!==d.HUDSpace.Screen?e.glsl`
            // Apply x/y in view space, but z in screen space (i.e. along posView direction)
            aux.posView += vec3(centerOffset.x, centerOffset.y, 0.0);

            // Same material all have same z != 0.0 condition so should not lead to
            // branch fragmentation and will save a normalization if it's not needed
            if (centerOffset.z != 0.0) {
              aux.posView -= normalize(aux.posView) * centerOffset.z;
            }
          `:""}

      vec4 posProj = proj * vec4(aux.posView, 1.0);

      ${b.screenCenterOffsetUnitsEnabled===d.HUDSpace.Screen?b.hasScreenSizePerspective?"float centerOffsetY \x3d applyScreenSizePerspectiveScaleFactorFloat(centerOffset.y, perspectiveFactor);":"float centerOffsetY \x3d centerOffset.y;":""}

      ${b.screenCenterOffsetUnitsEnabled===d.HUDSpace.Screen?"posProj.xy +\x3d vec2(centerOffset.x, centerOffsetY) * pixelRatio * 2.0 / viewport.zw * posProj.w;":""}

      // constant part of polygon offset emulation
      posProj.z -= groundRelative * polygonOffset * posProj.w;
      return posProj;
    }
  `);a.code.add(e.glsl`bool testVisibilityHUD(vec4 posProj) {
vec4 posProjCenter = alignToPixelCenter(posProj, viewport.zw);
vec4 occlusionPixel = texture2D(hudVisibilityTexture, .5 + .5 * posProjCenter.xy / posProjCenter.w);
if (renderTransparentlyOccludedHUD > 0.5) {
return occlusionPixel.r * occlusionPixel.g > 0.0 && occlusionPixel.g * renderTransparentlyOccludedHUD < 1.0;
}
return occlusionPixel.r * occlusionPixel.g > 0.0 && occlusionPixel.g == 1.0;
}`)};Object.defineProperties(d,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});