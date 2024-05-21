// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../views/3d/webgl-engine/core/shaderLibrary/util/View.glsl ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),function(f,n,p,b,q,c){function g(h){const a=new q.ShaderBuilder,{vertex:d,fragment:r}=a;n.addProjViewLocalOrigin(d,h);const {isAttributeDriven:e,usesHalfFloat:k}=h;a.attributes.add(c.VertexAttribute.POSITION,
"vec3");a.attributes.add(c.VertexAttribute.UV0,"vec2");e&&(a.attributes.add(c.VertexAttribute.FEATUREATTRIBUTE,"float"),a.varyings.add("attributeValue","float"));k&&a.constants.add("compressionFactor","float",.25);a.varyings.add("unitCirclePos","vec2");d.uniforms.add(new p.FloatPassUniform("radius",({resolutionForScale:l,searchRadius:t},{camera:m,screenToWorldRatio:u})=>2*t*(0===l?1:l/u)*m.pixelRatio/m.fullViewport[2]));d.code.add(b.glsl`
    void main() {
      unitCirclePos = uv0;

      vec4 posProj = proj * (view * vec4(${c.VertexAttribute.POSITION}, 1.0));
      vec4 quadOffset = vec4(unitCirclePos * radius, 0.0, 0.0);

      ${e?b.glsl`attributeValue = ${c.VertexAttribute.FEATUREATTRIBUTE};`:""}
      gl_Position = posProj + quadOffset;
    }
  `);r.code.add(b.glsl`
    void main() {
      float radiusRatioSquared = dot(unitCirclePos, unitCirclePos);
      if (radiusRatioSquared > 1.0) {
        discard;
      }

      float oneMinusRadiusRatioSquared = 1.0 - radiusRatioSquared;
      float density = oneMinusRadiusRatioSquared * oneMinusRadiusRatioSquared ${e?b.glsl` * attributeValue`:""} ${k?b.glsl` * compressionFactor`:""};
      gl_FragColor = vec4(density);
    }
  `);return a}const v=Object.freeze(Object.defineProperty({__proto__:null,build:g},Symbol.toStringTag,{value:"Module"}));f.HeatmapDensity=v;f.build=g});