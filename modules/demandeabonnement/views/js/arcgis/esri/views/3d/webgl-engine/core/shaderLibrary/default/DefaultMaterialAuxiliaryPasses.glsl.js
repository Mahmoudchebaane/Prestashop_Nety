// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../core/maybe ../../../../../../chunks/mat4f64 ../ForwardLinearDepth.glsl ../ShaderOutput ../Slice.glsl ../Transform.glsl ../attributes/NormalAttribute.glsl ../attributes/ObjectAndLayerIdColor.glsl ../attributes/TextureCoordinateAttribute.glsl ../attributes/VertexNormal.glsl ../output/OutputDepth.glsl ../output/OutputHighlight.glsl ../shading/VisualVariables.glsl ../util/AlphaDiscard.glsl ../util/View.glsl ../../shaderModules/interfaces ../../shaderModules/Matrix4PassUniform ../../shaderModules/Texture2DPassUniform ../../../lib/basicInterfaces".split(" "),
function(v,w,x,y,d,l,m,n,z,p,A,B,C,q,r,t,c,D,u,E){v.DefaultMaterialAuxiliaryPasses=function(b,a){const {vertex:f,fragment:g}=b,k=a.hasModelTransformation;k&&f.uniforms.add(new D.Matrix4PassUniform("model",e=>w.isSome(e.modelTransformation)?e.modelTransformation:x.IDENTITY));const h=a.hasColorTexture&&a.alphaDiscardMode!==E.AlphaDiscardMode.Opaque;switch(a.output){case d.ShaderOutput.Depth:case d.ShaderOutput.Shadow:case d.ShaderOutput.ShadowHighlight:case d.ShaderOutput.ShadowExludeHighlight:case d.ShaderOutput.ObjectAndLayerIdColor:t.addProjViewLocalOrigin(f,
a);b.include(m.Transform,a);b.include(p.TextureCoordinateAttribute,a);b.include(q.VisualVariables,a);b.include(B.OutputDepth,a);b.include(l.SliceDraw,a);b.include(z.ObjectAndLayerIdColor,a);y.addNearFar(b);b.varyings.add("depth","float");h&&g.uniforms.add(new u.Texture2DPassUniform("tex",e=>e.texture));f.code.add(c.glsl`
          void main(void) {
            vpos = calculateVPos();
            vpos = subtractOrigin(vpos);
            vpos = addVerticalOffset(vpos, localOrigin);
            gl_Position = transformPositionWithDepth(proj, view, ${k?"model,":""} vpos, nearFar, depth);
            forwardTextureCoordinates();
            forwardObjectAndLayerIdColor();
          }
        `);b.include(r.DiscardOrAdjustAlphaPass,a);g.code.add(c.glsl`
          void main(void) {
            discardBySlice(vpos);
            ${h?c.glsl`
                    vec4 texColor = texture2D(tex, ${a.hasColorTextureTransform?c.glsl`colorUV`:c.glsl`vuv0`});
                    discardOrAdjustAlpha(texColor);`:""}
            ${a.output===d.ShaderOutput.ObjectAndLayerIdColor?c.glsl`outputObjectAndLayerIdColor();`:c.glsl`outputDepth(depth);`}
          }
        `);break;case d.ShaderOutput.Normal:t.addProjViewLocalOrigin(f,a);b.include(m.Transform,a);b.include(n.NormalAttribute,a);b.include(A.VertexNormal,a);b.include(p.TextureCoordinateAttribute,a);b.include(q.VisualVariables,a);h&&g.uniforms.add(new u.Texture2DPassUniform("tex",e=>e.texture));b.varyings.add("vPositionView","vec3");f.code.add(c.glsl`
          void main(void) {
            vpos = calculateVPos();
            vpos = subtractOrigin(vpos);
            ${a.normalType===n.NormalAttributeType.Attribute?c.glsl`
            vNormalWorld = dpNormalView(vvLocalNormal(normalModel()));`:""}
            vpos = addVerticalOffset(vpos, localOrigin);
            gl_Position = transformPosition(proj, view, ${k?"model,":""} vpos);
            forwardTextureCoordinates();
          }
        `);b.include(l.SliceDraw,a);b.include(r.DiscardOrAdjustAlphaPass,a);g.code.add(c.glsl`
          void main() {
            discardBySlice(vpos);
            ${h?c.glsl`
                    vec4 texColor = texture2D(tex, ${a.hasColorTextureTransform?c.glsl`colorUV`:c.glsl`vuv0`});
                    discardOrAdjustAlpha(texColor);`:""}

            ${a.normalType===n.NormalAttributeType.ScreenDerivative?c.glsl`
                vec3 normal = screenDerivativeNormal(vPositionView);`:c.glsl`
                vec3 normal = normalize(vNormalWorld);
                if (gl_FrontFacing == false) normal = -normal;`}
            gl_FragColor = vec4(vec3(0.5) + 0.5 * normal, 1.0);
          }
        `);break;case d.ShaderOutput.Highlight:t.addProjViewLocalOrigin(f,a),b.include(m.Transform,a),b.include(p.TextureCoordinateAttribute,a),b.include(q.VisualVariables,a),h&&g.uniforms.add(new u.Texture2DPassUniform("tex",e=>e.texture)),f.code.add(c.glsl`
          void main(void) {
            vpos = calculateVPos();
            vpos = subtractOrigin(vpos);
            vpos = addVerticalOffset(vpos, localOrigin);
            gl_Position = transformPosition(proj, view, ${k?"model,":""} vpos);
            forwardTextureCoordinates();
          }
        `),b.include(l.SliceDraw,a),b.include(r.DiscardOrAdjustAlphaPass,a),b.include(C.OutputHighlight,a),g.code.add(c.glsl`
          void main() {
            discardBySlice(vpos);
            ${h?c.glsl`
                    vec4 texColor = texture2D(tex, ${a.hasColorTextureTransform?c.glsl`colorUV`:c.glsl`vuv0`});
                    discardOrAdjustAlpha(texColor);`:""}
            outputHighlight();
          }
        `)}};Object.defineProperties(v,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});