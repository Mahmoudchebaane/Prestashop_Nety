// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./vec4f64 ../views/3d/webgl-engine/core/shaderLibrary/ScreenSizeScaling.glsl ../views/3d/webgl-engine/core/shaderLibrary/ShaderOutput ../views/3d/webgl-engine/core/shaderLibrary/Slice.glsl ../views/3d/webgl-engine/core/shaderLibrary/Transform.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/MultipassTerrainTest.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/AlphaCutoff ../views/3d/webgl-engine/core/shaderLibrary/util/ColorConversion.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/View.glsl ../views/3d/webgl-engine/core/shaderModules/Float3PassUniform ../views/3d/webgl-engine/core/shaderModules/Float4PassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/lib/TransparencyPassType ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),
function(r,p,w,l,x,y,z,A,B,t,C,u,d,D,E,q){function v(a){const c=new D.ShaderBuilder,m=a.hasMultipassTerrain&&(a.output===l.ShaderOutput.Color||a.output===l.ShaderOutput.Alpha);c.include(y.Transform,a);c.include(w.ScreenSizeScaling,a);c.include(x.SliceDraw,a);const {vertex:h,fragment:f}=c;f.include(B.ColorConversion);t.addProjViewLocalOrigin(h,a);f.uniforms.add(new u.Float4PassUniform("uColor",b=>b.color));c.attributes.add(q.VertexAttribute.POSITION,"vec3");c.varyings.add("vWorldPosition","vec3");
m&&c.varyings.add("depth","float");a.screenSizeEnabled&&c.attributes.add(q.VertexAttribute.OFFSET,"vec3");a.shadingEnabled&&(t.addViewNormal(h),c.attributes.add(q.VertexAttribute.NORMAL,"vec3"),c.varyings.add("vViewNormal","vec3"));h.code.add(d.glsl`
    void main(void) {
      vWorldPosition = ${a.screenSizeEnabled?"screenSizeScaling(offset, position)":"position"};
  `);a.shadingEnabled&&h.code.add(d.glsl`vec3 worldNormal = normal;
vViewNormal = (viewNormal * vec4(worldNormal, 1)).xyz;`);h.code.add(d.glsl`
    ${m?"depth \x3d (view * vec4(vWorldPosition, 1.0)).z;":""}
    gl_Position = transformPosition(proj, view, vWorldPosition);
  }
  `);m&&c.include(z.multipassTerrainTest,a);f.code.add(d.glsl`
    void main() {
      discardBySlice(vWorldPosition);
      ${m?"terrainDepthTest(gl_FragCoord, depth);":""}
    `);a.shadingEnabled?(f.uniforms.add(new C.Float3PassUniform("shadingDirection",b=>b.shadingDirection)),f.uniforms.add(new u.Float4PassUniform("shadedColor",b=>{{var e=b.shadingTint;b=b.color;const n=1-e[3],k=e[3]+b[3]*n;0===k?g[3]=k:(g[0]=(e[0]*e[3]+b[0]*b[3]*n)/k,g[1]=(e[1]*e[3]+b[1]*b[3]*n)/k,g[2]=(e[2]*e[3]+b[2]*b[3]*n)/k,g[3]=b[3]);e=g}return e})),f.code.add(d.glsl`vec3 viewNormalNorm = normalize(vViewNormal);
float shadingFactor = 1.0 - clamp(-dot(viewNormalNorm, shadingDirection), 0.0, 1.0);
vec4 finalColor = mix(uColor, shadedColor, shadingFactor);`)):f.code.add(d.glsl`vec4 finalColor = uColor;`);f.code.add(d.glsl`
      if (finalColor.a < ${d.glsl.float(A.symbolAlphaCutoff)}) {
        discard;
      }
      ${a.output===l.ShaderOutput.Alpha?d.glsl`gl_FragColor = vec4(finalColor.a);`:""}

      ${a.output===l.ShaderOutput.Color?d.glsl`gl_FragColor = highlightSlice(finalColor, vWorldPosition); ${a.transparencyPassType===E.TransparencyPassType.Color?"gl_FragColor \x3d premultiplyAlpha(gl_FragColor);":""}`:""}
    }
    `);return c}const g=p.create();p=Object.freeze(Object.defineProperty({__proto__:null,build:v},Symbol.toStringTag,{value:"Module"}));r.ShadedColorMaterialShader=p;r.build=v});