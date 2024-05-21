// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./_rollupPluginBabelHelpers ../views/3d/webgl-engine/core/shaderLibrary/ScreenSpacePass ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform".split(" "),function(d,h,k,l,e,m,n){function f(c){const a=new m.ShaderBuilder;a.include(k.ScreenSpacePass);a.fragment.uniforms.add(new n.Texture2DPassUniform("tex",
b=>b.texture));c.hasOpacityFactor&&a.fragment.uniforms.add(new l.FloatPassUniform("opacity",b=>b.opacity));a.fragment.code.add(e.glsl`
    void main() {
      gl_FragColor = texture2D(tex, uv) ${c.hasOpacityFactor?"* opacity":""};
    }`);return a}let g=function(c){function a(){var b=c.apply(this,arguments)||this;b.opacity=1;return b}h._inheritsLoose(a,c);return a}(e.NoParameters);const p=Object.freeze(Object.defineProperty({__proto__:null,CompositingPassParameters:g,build:f},Symbol.toStringTag,{value:"Module"}));d.Compositing=p;d.CompositingPassParameters=g;d.build=f});