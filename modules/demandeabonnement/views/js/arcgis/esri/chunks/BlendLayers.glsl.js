// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../views/3d/webgl-engine/core/shaderLibrary/terrain/BackgroundGrid.glsl ../views/3d/webgl-engine/core/shaderLibrary/terrain/TileBackground.glsl ../views/3d/webgl-engine/core/shaderLibrary/terrain/TileComposite.glsl ../views/3d/webgl-engine/core/shaderModules/Float3PassUniform ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform".split(" "),
function(c,h,f,k,l,m,e,n,p){function g(a){const b=new n.ShaderBuilder;b.include(k.TileComposite);if(a.background===c.BackgroundMode.Only)return(a=a.output===f.BlendLayersOutput.ColorComposite)?b.fragment.uniforms.add(new l.Float3PassUniform("backgroundColor",d=>d.backgroundColor)):(b.extensions.add("GL_OES_standard_derivatives"),b.fragment.include(h.BackgroundGrid)),b.fragment.code.add(e.glsl`
    void main() {
      gl_FragColor = ${a?e.glsl`vec4(backgroundColor, 1.0)`:e.glsl`gridColor(uv)`};
    }
  `),b;b.include(f.TileBackground,a);b.fragment.uniforms.add(new p.Texture2DPassUniform("tex",d=>d.texture));b.fragment.uniforms.add(new m.FloatPassUniform("opacity",d=>d.opacity));b.fragment.code.add(e.glsl`void main() {
vec4 bgColor = getBackground(uv);
gl_FragColor = blendLayers(bgColor, texture2D(tex, uv), opacity);
}`);return b}c.BackgroundMode=void 0;(function(a){a[a.BelowLayer=0]="BelowLayer";a[a.Only=1]="Only";a[a.COUNT=2]="COUNT"})(c.BackgroundMode||(c.BackgroundMode={}));const q=Object.freeze(Object.defineProperty({__proto__:null,get BackgroundMode(){return c.BackgroundMode},build:g},Symbol.toStringTag,{value:"Module"}));c.BlendLayers=q;c.build=g});