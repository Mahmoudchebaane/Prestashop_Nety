// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/_rollupPluginBabelHelpers ../../../../terrain/interfaces ./BackgroundGrid.glsl ./Overlay.glsl ./TileBlendInput ../../shaderModules/FloatPassUniform ../../shaderModules/interfaces ../../shaderModules/Texture2DPassUniform ../../shaderModules/Uniform".split(" "),function(f,g,r,t,u,p,v,e,w,h){let x=function(a){function b(){var c=a.apply(this,arguments)||this;c.overlayOpacity=1;return c}g._inheritsLoose(b,a);return b}(e.NoParameters),y=function(a){function b(c){return a.call(this,
c,"float")||this}g._inheritsLoose(b,a);return b}(h.Uniform),k=function(a){function b(c){return a.call(this,c,"vec3")||this}g._inheritsLoose(b,a);return b}(h.Uniform),l=function(a){function b(c){return a.call(this,c,"vec4")||this}g._inheritsLoose(b,a);return b}(h.Uniform),m=function(a){function b(c){return a.call(this,c,"sampler2D")||this}g._inheritsLoose(b,a);return b}(h.Uniform);f.Float3Uniform=k;f.OverlayTerrain=function(a,b){a.vertex.uniforms.add([new l("overlayTexOffset"),new l("overlayTexScale")]);
a.fragment.uniforms.add([new v.FloatPassUniform("overlayOpacity",c=>c.overlayOpacity),new w.Texture2DPassUniform("ovColorTex",(c,d)=>0===d.overlays.length?null:d.overlays[r.OverlayIndex.INNER].getColorTexture(c.overlaySource))]);u.overlay(a,b)};f.OverlayTerrainPassParameters=x;f.TerrainTexture=function(a,b){const {vertex:c,fragment:d,varyings:q}=a;q.add("vtc","vec2");c.uniforms.add(new l("texOffsetAndScale"));d.uniforms.add(new m("tex"));d.uniforms.add(new k("textureOpacities"));if(a=b.textureFadingEnabled&&
!b.renderOccluded)c.uniforms.add(new l("nextTexOffsetAndScale")),q.add("nvtc","vec2"),d.uniforms.add(new m("texNext")),d.uniforms.add(new k("nextTexOpacities")),d.uniforms.add(new y("fadeFactor"));const n=b.tileBlendInput===p.TileBlendInput.ColorComposite;(b=b.tileBlendInput===p.TileBlendInput.GridComposite)&&d.include(t.BackgroundGrid);n&&d.uniforms.add(new k("backgroundColor"));c.code.add(e.glsl`
  void forwardTextureCoordinatesWithTransform(in vec2 uv) {
    vtc = uv * texOffsetAndScale.zw + texOffsetAndScale.xy;
    ${a?e.glsl`nvtc = uv * nextTexOffsetAndScale.zw + nextTexOffsetAndScale.xy;`:e.glsl``}
  }`);d.code.add(e.glsl`
    vec4 getColor(vec4 color, vec2 uv, vec3 opacities) {
      ${b||n?e.glsl`
              if (opacities.y <= 0.0) {
                return color * opacities.z * opacities.x;
              }
              vec4 bg = ${n?e.glsl`vec4(backgroundColor, 1.0)`:e.glsl`gridColor(uv)`} * opacities.y;
              float alpha = opacities.z * color.a;
              return mix(bg, color, alpha) * opacities.x;`:e.glsl`return color;`}
    }`);a?d.code.add(e.glsl`vec4 getTileColor() {
vec4 color = getColor(texture2D(tex, vtc), vtc, textureOpacities);
if (fadeFactor >= 1.0) {
return color;
}
vec4 nextColor = getColor(texture2D(texNext, nvtc), nvtc, nextTexOpacities);
return mix(nextColor, color, fadeFactor);
}`):d.code.add(e.glsl`vec4 getTileColor() {
return getColor(texture2D(tex, vtc), vtc, textureOpacities);
}`)};f.Texture2DUniform=m;Object.defineProperties(f,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});