// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../core/maybe ./vec2f64 ../views/3d/webgl-engine/core/shaderLibrary/ShaderOutput ../views/3d/webgl-engine/core/shaderLibrary/Slice.glsl ../views/3d/webgl-engine/core/shaderLibrary/Transform.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/MultipassTerrainTest.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/AlphaCutoff ../views/3d/webgl-engine/core/shaderLibrary/util/ColorConversion.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/View.glsl ../views/3d/webgl-engine/core/shaderModules/Float2PassUniform ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform ../views/3d/webgl-engine/lib/TransparencyPassType ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),
function(g,h,n,p,q,r,t,k,u,v,w,x,d,y,z,A,l){function m(a){const b=new y.ShaderBuilder,{vertex:f,fragment:e}=b;v.addProjViewLocalOrigin(f,a);b.include(r.Transform,a);b.attributes.add(l.VertexAttribute.POSITION,"vec3");b.attributes.add(l.VertexAttribute.UV0,"vec2");b.varyings.add("vpos","vec3");a.hasMultipassTerrain&&b.varyings.add("depth","float");f.uniforms.add(new w.Float2PassUniform("textureCoordinateScaleFactor",c=>h.isSome(c.texture)&&h.isSome(c.texture.descriptor.textureCoordinateScaleFactor)?
c.texture.descriptor.textureCoordinateScaleFactor:n.ONES));f.code.add(d.glsl`
    void main(void) {
      vpos = position;
      ${a.hasMultipassTerrain?"depth \x3d (view * vec4(vpos, 1.0)).z;":""}
      vTexCoord = uv0 * textureCoordinateScaleFactor;
      gl_Position = transformPosition(proj, view, vpos);
    }
  `);b.include(q.SliceDraw,a);b.include(t.multipassTerrainTest,a);e.uniforms.add([new z.Texture2DPassUniform("tex",c=>c.texture),new x.FloatPassUniform("opacity",c=>c.opacity)]);b.varyings.add("vTexCoord","vec2");a.output===p.ShaderOutput.Alpha?e.code.add(d.glsl`
    void main() {
      discardBySlice(vpos);
      ${a.hasMultipassTerrain?"terrainDepthTest(gl_FragCoord, depth);":""}

      float alpha = texture2D(tex, vTexCoord).a * opacity;
      if (alpha  < ${d.glsl.float(k.defaultMaskAlphaCutoff)}) {
        discard;
      }

      gl_FragColor = vec4(alpha);
    }
    `):(e.include(u.ColorConversion),e.code.add(d.glsl`
    void main() {
      discardBySlice(vpos);
      ${a.hasMultipassTerrain?"terrainDepthTest(gl_FragCoord, depth);":""}
      gl_FragColor = texture2D(tex, vTexCoord) * opacity;

      if (gl_FragColor.a < ${d.glsl.float(k.defaultMaskAlphaCutoff)}) {
        discard;
      }

      gl_FragColor = highlightSlice(gl_FragColor, vpos);
      ${a.transparencyPassType===A.TransparencyPassType.Color?"gl_FragColor \x3d premultiplyAlpha(gl_FragColor);":""}
    }
    `));return b}const B=Object.freeze(Object.defineProperty({__proto__:null,build:m},Symbol.toStringTag,{value:"Module"}));g.ImageMaterial=B;g.build=m});