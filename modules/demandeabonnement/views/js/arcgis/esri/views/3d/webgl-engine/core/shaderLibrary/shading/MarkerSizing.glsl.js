// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../core/maybe ../../../../support/engineContent/marker ../../shaderModules/FloatPassUniform ../../shaderModules/interfaces ../../../shaders/LineMarkerTechniqueConfiguration".split(" "),function(c,g,h,d,e,k){c.MarkerSizing=function(f,l){const a=f.vertex;f.constants.add("markerSizePerLineWidth","float",h.MARKER_SIZE_PER_LINE_WIDTH);a.uniforms.add(new d.FloatPassUniform("pixelRatio",(m,b)=>b.camera.pixelRatio));g.isNone(a.uniforms.get("markerScale"))&&a.constants.add("markerScale",
"float",1);a.code.add(e.glsl`float getLineWidth() {
return max(getSize(), 1.0) * pixelRatio;
}
float getScreenMarkerSize() {
return markerSizePerLineWidth * markerScale * getLineWidth();
}`);l.space===k.LineMarkerSpace.World&&(a.constants.add("maxSegmentLengthFraction","float",.45),a.uniforms.add(new d.FloatPassUniform("perRenderPixelRatio",(m,b)=>b.camera.perRenderPixelRatio)),a.code.add(e.glsl`float getWorldMarkerSize(vec4 pos) {
float distanceToCamera = length(pos.xyz);
float screenToWorldRatio = perRenderPixelRatio * distanceToCamera * 0.5;
return getScreenMarkerSize() * screenToWorldRatio;
}
bool areWorldMarkersHidden(vec4 pos, vec4 other) {
vec3 midPoint = mix(pos.xyz, other.xyz, 0.5);
float distanceToCamera = length(midPoint);
float screenToWorldRatio = perRenderPixelRatio * distanceToCamera * 0.5;
float worldMarkerSize = getScreenMarkerSize() * screenToWorldRatio;
float segmentLen = length(pos.xyz - other.xyz);
return worldMarkerSize > maxSegmentLengthFraction * segmentLen;
}`))};Object.defineProperties(c,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});