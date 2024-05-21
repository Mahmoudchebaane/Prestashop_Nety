// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./_rollupPluginBabelHelpers ./vec2f64 ./vec3f64 ../views/3d/environment/SimpleAtmosphereTechniqueConfiguration ../views/3d/webgl-engine/core/shaderLibrary/Transform.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/MainLighting.glsl ../views/3d/webgl-engine/core/shaderModules/Float2PassUniform ../views/3d/webgl-engine/core/shaderModules/Float3PassUniform ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/Matrix4PassUniform ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),
function(g,v,w,l,p,x,y,z,h,m,d,q,A,B,r){function t(e){const c=new A.ShaderBuilder,{vertex:b,fragment:k}=c;y.addMainLightDirection(b);e.geometry===p.SimpleAtmosphereGeometry.Underground?(c.attributes.add(r.VertexAttribute.POSITION,"vec2"),c.varyings.add("color","vec4"),b.uniforms.add([new h.Float3PassUniform("cameraPosition",(a,f)=>f.camera.eye),new m.FloatPassUniform("undergroundFadeAlpha",a=>a.undergroundFadeAlpha)]),b.code.add(d.glsl`void main(void) {
float ndotl = dot(normalize(cameraPosition), mainLightDirection);
float lighting = max(0.0, smoothstep(-1.0, 0.8, 2.0 * ndotl));
color = vec4(vec3(lighting), undergroundFadeAlpha);
gl_Position = vec4(position.xy, 1.0, 1.0);
}`),k.code.add(d.glsl`void main() {
gl_FragColor = color;
}`)):(c.include(x.Transform,e),c.attributes.add(r.VertexAttribute.POSITION,"vec3"),c.varyings.add("vtc","vec2"),c.varyings.add("falloff","float"),e=e.geometry===p.SimpleAtmosphereGeometry.Cylinder,b.uniforms.add([new q.Matrix4PassUniform("proj",(a,f)=>f.camera.projectionMatrix),new q.Matrix4PassUniform("view",(a,f)=>f.camera.viewMatrix)]),e||(c.varyings.add("innerFactor","float"),b.uniforms.add(new h.Float3PassUniform("silCircleCenter",a=>a.silhouette.center)),b.uniforms.add(new h.Float3PassUniform("silCircleV1",
a=>a.silhouette.v1)),b.uniforms.add(new h.Float3PassUniform("silCircleV2",a=>a.silhouette.v2)),b.uniforms.add(new z.Float2PassUniform("texV",a=>a.texV)),b.uniforms.add(new m.FloatPassUniform("innerScale",a=>a.innerScale))),b.code.add(d.glsl`
		void main(void) {
      ${e?d.glsl`
      vec3 pos = position;
      float ndotl = mainLightDirection.z;
      vtc = vec2(0.0, position.z + 0.05);`:d.glsl`
      innerFactor = clamp(-position.z, 0.0, 1.0);
      float scale = position.y * (1.0 + innerFactor * innerScale);
      float phi = position.x * ${d.glsl.float(.04908738515625)} + 1.0;
      vec3 pos =  (silCircleCenter + sin(phi) * silCircleV1 + cos(phi) * silCircleV2) * scale;
      float ndotl = dot(normalize(position.y > 0.0 ? pos: silCircleCenter), mainLightDirection);
      vtc.x = position.x  * ${d.glsl.float(.0078125)};
      vtc.y = texV.x * (1.0 - position.z) + texV.y * position.z;
      `}
      falloff = max(0.0, smoothstep(-1.0, 0.8, 2.0 * ndotl));

		  gl_Position = transformPosition(proj, view, pos);
		  gl_Position.z = gl_Position.w; // project atmosphere onto the far plane
    }
	  `),k.uniforms.add(new B.Texture2DPassUniform("tex",a=>a.texture)),e||k.uniforms.add(new m.FloatPassUniform("altitudeFade",a=>a.altitudeFade)),k.code.add(d.glsl`
		void main() {
			vec4 atmosphereColor = texture2D(tex, vtc) * falloff;
      ${e?d.glsl`gl_FragColor = atmosphereColor;`:d.glsl`
			vec4 innerColor = vec4(atmosphereColor.rgb, 1.0 - altitudeFade);
			gl_FragColor = mix(atmosphereColor, innerColor, smoothstep(0.0, 1.0, innerFactor));
      `}
    }`));return c}let u=function(e){function c(){var b=e.apply(this,arguments)||this;b.texV=w.create();b.altitudeFade=0;b.innerScale=0;b.undergroundFadeAlpha=0;b.silhouette=new n;return b}v._inheritsLoose(c,e);return c}(d.NoParameters),n=function(){this.center=l.create();this.v1=l.create();this.v2=l.create()};const C=Object.freeze(Object.defineProperty({__proto__:null,SimpleAtmospherePassParameters:u,SilhouetteCircle:n,build:t},Symbol.toStringTag,{value:"Module"}));g.SilhouetteCircle=n;g.SimpleAtmosphere=
C;g.SimpleAtmospherePassParameters=u;g.build=t});