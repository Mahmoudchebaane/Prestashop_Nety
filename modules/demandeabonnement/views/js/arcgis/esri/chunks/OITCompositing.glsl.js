// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./_rollupPluginBabelHelpers ../views/3d/webgl-engine/core/shaderLibrary/ScreenSpacePass ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform".split(" "),function(c,h,k,e,l,d){function f(){const b=new l.ShaderBuilder;b.include(k.ScreenSpacePass);b.fragment.uniforms.add([new d.Texture2DPassUniform("colorTexture",a=>a.colorTexture),new d.Texture2DPassUniform("alphaTexture",
a=>a.alphaTexture),new d.Texture2DPassUniform("frontFaceTexture",a=>a.frontFaceTexture)]);b.fragment.code.add(e.glsl`void main() {
vec4 srcColor = texture2D(colorTexture, uv);
if(srcColor.a <= 1e-5){
discard;
}
float srcAlpha = texture2D(alphaTexture, uv).r;
vec4 frontFace = texture2D(frontFaceTexture, uv);
gl_FragColor = vec4(mix(srcColor.rgb/srcColor.a, frontFace.rgb, frontFace.a), 1.0 - srcAlpha);
}`);return b}let g=function(b){function a(){return b.apply(this,arguments)||this}h._inheritsLoose(a,b);return a}(e.NoParameters);const m=Object.freeze(Object.defineProperty({__proto__:null,OITCompositingPassParameters:g,build:f},Symbol.toStringTag,{value:"Module"}));c.OITCompositing=m;c.OITCompositingPassParameters=g;c.build=f});