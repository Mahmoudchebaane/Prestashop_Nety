// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../views/3d/webgl-engine/core/shaderLibrary/util/View.glsl ../views/3d/webgl-engine/core/shaderModules/Float4PassUniform ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),function(c,m,d,n,e,p,f){function g(q){const b=new p.ShaderBuilder;b.extensions.add("GL_OES_standard_derivatives");const {vertex:h,fragment:k,
attributes:l,varyings:r}=b;m.addProjViewLocalOrigin(h,q);l.add(f.VertexAttribute.POSITION,"vec3");l.add(f.VertexAttribute.UV0,"vec2");r.add("vUV","vec2");h.code.add(e.glsl`void main(void) {
vUV = uv0;
gl_Position = proj * view * vec4(position, 1.0);
}`);k.uniforms.add([new d.Float4PassUniform("backgroundColor",a=>a.backgroundColor),new d.Float4PassUniform("gridColor",a=>a.gridColor),new n.FloatPassUniform("gridWidth",a=>a.gridWidth)]);k.code.add(e.glsl`void main() {
const float LINE_WIDTH = 1.0;
vec2 uvScaled = vUV * gridWidth;
vec2 gridUV = (fract(uvScaled + 0.5) - 0.5) / (LINE_WIDTH * fwidth(uvScaled));
vec2 grid = (1.0 - step(0.5, gridUV)) * step(-0.5, gridUV);
grid.x *= step(0.5, uvScaled.x) * step(uvScaled.x, gridWidth - 0.5);
grid.y *= step(0.5, uvScaled.y) * step(uvScaled.y, gridWidth - 0.5);
float gridFade = max(grid.x, grid.y);
float gridAlpha = gridColor.a * gridFade;
gl_FragColor =
vec4(backgroundColor.rgb * backgroundColor.a, backgroundColor.a) * (1.0 - gridAlpha) +
vec4(gridColor.rgb, 1.0) * gridAlpha;
}`);return b}const t=Object.freeze(Object.defineProperty({__proto__:null,build:g},Symbol.toStringTag,{value:"Module"}));c.SlicePlaneMaterial=t;c.build=g});