// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/vec4f64 ../../../../../../geometry/support/aaBoundingRect ../../../../terrain/interfaces ../../renderPasses/AllRenderPasses ../shading/MainLighting.glsl ../shading/PhysicallyBasedRenderingParameters.glsl ../shading/Water.glsl ../../shaderModules/Float4DrawUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform".split(" "),function(f,y,d,p,q,u,m,z,v,n,A){function w(a,b){a.extensions.add("GL_OES_standard_derivatives");b.pbrMode!==m.PBRMode.Water&&
b.pbrMode!==m.PBRMode.WaterOnIntegratedMesh||a.include(z.Water,b);const {vertex:r,fragment:e}=a;a.varyings.add("vtcOverlay","vec4");r.code.add(n.glsl`void setOverlayVTC(in vec2 uv) {
vtcOverlay = vec4(uv, uv) * overlayTexScale + overlayTexOffset;
}`);e.code.add(n.glsl`bool isValid(vec2 uv, vec2 dxdy) {
return (uv.x >= 0.0 + dxdy.x) && (uv.x <= 1.0 - dxdy.x) && (uv.y >= 0.0 + dxdy.y) && (uv.y <= 1.0 - dxdy.y);
}
vec4 getOverlayColor(sampler2D ov0Tex, vec4 texCoords) {
vec4 color0 = texture2D(ov0Tex, vec2(texCoords.x * 0.5, texCoords.y));
vec4 color1 = texture2D(ov0Tex, vec2(texCoords.z * 0.5 + 0.5, texCoords.w));
bool isValid0 = isValid(texCoords.xy, fwidth(texCoords.xy));
bool isValid1 = isValid(texCoords.zw, vec2(0.0, 0.0));
return mix(color1 * float(isValid1), color0, float(isValid0));
}`);e.code.add(n.glsl`vec4 getCombinedOverlayColor() {
return overlayOpacity * getOverlayColor(ovColorTex, vtcOverlay);
}`);if(b.pbrMode===m.PBRMode.Water||b.pbrMode===m.PBRMode.WaterOnIntegratedMesh)u.addMainLightDirection(e),u.addMainLightIntensity(e),e.code.add(n.glsl`vec4 getOverlayWaterColor(vec4 maskInput, vec4 colorInput, vec3 vposEyeDir,
float shadow, vec3 localUp, mat3 tbn, vec3 position, vec3 positionWorld) {
vec3 n = normalize(tbn *  (2.0 * maskInput.rgb - vec3(1.0)));
vec3 v = vposEyeDir;
vec3 final = getSeaColor(n, v, mainLightDirection, colorInput.rgb, mainLightIntensity, localUp, 1.0 - shadow, maskInput.w, position, positionWorld);
return vec4(final, colorInput.w);
}`)}function x(a,b){return 0===b.overlays.length?null:a.identifier===q.RenderPassIdentifier.Material&&a.subPass===q.MaterialSubPass.Color?b.overlays[p.OverlayIndex.INNER].getColorTextureNoRasterImage():a.identifier===q.RenderPassIdentifier.Highlight?b.overlays[p.OverlayIndex.INNER].getValidTexture(p.RenderTargetType.Highlight):null}f.OverlayMode=void 0;(function(a){a[a.Disabled=0]="Disabled";a[a.Enabled=1]="Enabled";a[a.EnabledWithWater=2]="EnabledWithWater";a[a.COUNT=3]="COUNT"})(f.OverlayMode||
(f.OverlayMode={}));const h=y.create();f.OverlayIM=function(a,b){const {vertex:r,fragment:e}=a;r.uniforms.add([new v.Float4DrawUniform("overlayTexOffset",(g,k)=>{for(const t of k.overlays){const {index:l,extent:c}=t;0<d.area(c)&&(h[2*l]=g.toMapSpace[0]/d.width(c)-c[0]/d.width(c),h[2*l+1]=g.toMapSpace[1]/d.height(c)-c[1]/d.height(c))}return h}),new v.Float4DrawUniform("overlayTexScale",(g,k)=>{for(const t of k.overlays){const {index:l,extent:c}=t;0<d.area(c)&&(h[2*l]=g.toMapSpace[2]/d.width(c),h[2*
l+1]=g.toMapSpace[3]/d.height(c))}return h})]);e.constants.add("overlayOpacity","float",1);e.uniforms.add(new A.Texture2DPassUniform("ovColorTex",(g,k)=>x(g,k)));w(a,b)};f.getColorTexture=x;f.overlay=w;Object.defineProperties(f,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});