// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./_rollupPluginBabelHelpers ./vec4f64 ../views/3d/webgl-engine/core/shaderLibrary/ScreenSpacePass ../views/3d/webgl-engine/core/shaderModules/Float4PassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform".split(" "),function(c,h,k,l,m,d,n,p){function e(){const a=new n.ShaderBuilder;a.include(l.ScreenSpacePass);a.fragment.uniforms.add([new p.Texture2DPassUniform("tex",
b=>b.texture),new m.Float4PassUniform("uColor",b=>b.color)]);a.fragment.code.add(d.glsl`void main() {
vec4 texColor = texture2D(tex, uv);
gl_FragColor = texColor * uColor;
}`);return a}let g=function(a){function b(){var f=a.apply(this,arguments)||this;f.color=k.fromValues(1,1,1,1);return f}h._inheritsLoose(b,a);return b}(d.NoParameters);const q=Object.freeze(Object.defineProperty({__proto__:null,TextureOnlyPassParameters:g,build:e},Symbol.toStringTag,{value:"Module"}));c.TextureOnly=q;c.TextureOnlyPassParameters=g;c.build=e});