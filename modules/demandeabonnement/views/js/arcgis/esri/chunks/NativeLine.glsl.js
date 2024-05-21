// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../views/3d/webgl-engine/core/shaderLibrary/ShaderOutput ../views/3d/webgl-engine/core/shaderLibrary/Slice.glsl ../views/3d/webgl-engine/core/shaderLibrary/Transform.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/VertexColor.glsl ../views/3d/webgl-engine/core/shaderLibrary/output/OutputHighlight.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/LineStipple.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/AlphaCutoff ../views/3d/webgl-engine/core/shaderLibrary/util/View.glsl ../views/3d/webgl-engine/core/shaderModules/Float4PassUniform ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),
function(m,g,r,t,u,v,n,w,x,p,h,b,y,k){function q(a){const d=new y.ShaderBuilder,{vertex:c,fragment:l}=d;d.include(t.Transform,a);d.include(u.VertexColor,a);d.include(n.LineStipple,a);x.addProjViewLocalOrigin(c,a);a.stippleEnabled&&(d.attributes.add(k.VertexAttribute.UV0,"vec2"),d.attributes.add(k.VertexAttribute.AUXPOS1,"vec3"),c.uniforms.add(new p.Float4PassUniform("viewport",(e,f)=>f.camera.fullViewport)));d.attributes.add(k.VertexAttribute.POSITION,"vec3");d.varyings.add("vpos","vec3");c.code.add(b.glsl`void main(void) {
vpos = position;
forwardNormalizedVertexColor();
gl_Position = transformPosition(proj, view, vpos);`);a.stippleEnabled&&(c.code.add(b.glsl`vec4 vpos2 = transformPosition(proj, view, auxpos1);
vec2 ndcToPixel = viewport.zw * 0.5;
float lineSegmentPixelSize = length((vpos2.xy / vpos2.w - gl_Position.xy / gl_Position.w) * ndcToPixel);`),a.draped?c.uniforms.add(new h.FloatPassUniform("worldToScreenRatio",(e,f)=>1/f.screenToPCSRatio)):c.code.add(b.glsl`vec3 segmentCenter = (position + auxpos1) * 0.5;
float worldToScreenRatio = computeWorldToScreenRatio(segmentCenter);`),c.code.add(b.glsl`float discreteWorldToScreenRatio = discretizeWorldToScreenRatio(worldToScreenRatio);`),a.draped?c.code.add(b.glsl`float startPseudoScreen = uv0.y * discreteWorldToScreenRatio - mix(0.0, lineSegmentPixelSize, uv0.x);
float segmentLengthPseudoScreen = lineSegmentPixelSize;`):c.code.add(b.glsl`float segmentLengthRender = length(position - auxpos1);
float startPseudoScreen = mix(uv0.y, uv0.y - segmentLengthRender, uv0.x) * discreteWorldToScreenRatio;
float segmentLengthPseudoScreen = segmentLengthRender * discreteWorldToScreenRatio;`),c.uniforms.add(new h.FloatPassUniform("stipplePatternPixelSize",e=>n.computePixelSize(e))),c.code.add(b.glsl`vec2 stippleDistanceLimits = computeStippleDistanceLimits(startPseudoScreen, segmentLengthPseudoScreen, lineSegmentPixelSize, stipplePatternPixelSize);
vStippleDistance = mix(stippleDistanceLimits.x, stippleDistanceLimits.y, uv0.x);
vStippleDistance *= gl_Position.w;`));c.code.add(b.glsl`}`);a.output===g.ShaderOutput.Highlight&&d.include(v.OutputHighlight,a);d.include(r.SliceDraw,a);l.uniforms.add(new h.FloatPassUniform("alphaCoverage",(e,f)=>Math.min(1,e.width*f.camera.pixelRatio)));a.hasVertexColors||l.uniforms.add(new p.Float4PassUniform("constantColor",e=>e.color));l.code.add(b.glsl`
  void main() {
    discardBySlice(vpos);

    vec4 color = ${a.hasVertexColors?"vColor":"constantColor"};

    float stippleAlpha = getStippleAlpha();
    discardByStippleAlpha(stippleAlpha, stippleAlphaColorDiscard);

    vec4 finalColor = blendStipple(vec4(color.rgb, color.a * alphaCoverage), stippleAlpha);

    if (finalColor.a < ${b.glsl.float(w.symbolAlphaCutoff)}) {
      discard;
    }

    ${a.output===g.ShaderOutput.Color?b.glsl`gl_FragColor = highlightSlice(finalColor, vpos);`:""}
    ${a.output===g.ShaderOutput.Highlight?b.glsl`outputHighlight();`:""}
  }
  `);return d}const z=Object.freeze(Object.defineProperty({__proto__:null,build:q},Symbol.toStringTag,{value:"Module"}));m.NativeLine=z;m.build=q});