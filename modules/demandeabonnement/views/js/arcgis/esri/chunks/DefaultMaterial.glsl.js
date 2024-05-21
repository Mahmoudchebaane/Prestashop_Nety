// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../core/maybe ./mat4f64 ../views/3d/webgl-engine/core/shaderLibrary/ForwardLinearDepth.glsl ../views/3d/webgl-engine/core/shaderLibrary/Offset.glsl ../views/3d/webgl-engine/core/shaderLibrary/ShaderOutput ../views/3d/webgl-engine/core/shaderLibrary/Slice.glsl ../views/3d/webgl-engine/core/shaderLibrary/Transform.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/InstancedDoublePrecision.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/NormalAttribute.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/PositionAttribute.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/SymbolColor.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/TextureCoordinateAttribute.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/VertexColor.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/VertexNormal.glsl ../views/3d/webgl-engine/core/shaderLibrary/attributes/VerticalOffset.glsl ../views/3d/webgl-engine/core/shaderLibrary/default/DefaultMaterialAuxiliaryPasses.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/ComputeNormalTexture.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/EvaluateAmbientOcclusion.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/EvaluateSceneLighting.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/MainLighting.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/MultipassTerrainTest.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/Normals.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/PhysicallyBasedRendering.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/PhysicallyBasedRenderingParameters.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/ReadShadowMap.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/TextureTransformUV.glsl ../views/3d/webgl-engine/core/shaderLibrary/shading/VisualVariables.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/AlphaCutoff ../views/3d/webgl-engine/core/shaderLibrary/util/AlphaDiscard.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/MixExternalColor.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/View.glsl ../views/3d/webgl-engine/core/shaderModules/Float3PassUniform ../views/3d/webgl-engine/core/shaderModules/Float4PassUniform ../views/3d/webgl-engine/core/shaderModules/FloatPassUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/Matrix4PassUniform ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/core/shaderModules/Texture2DPassUniform ../views/3d/webgl-engine/lib/TransparencyPassType ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),
function(r,B,C,D,E,k,t,F,G,g,H,I,J,K,L,M,N,O,P,p,Q,u,R,S,l,v,h,T,U,w,x,q,y,V,m,c,W,X,z,Y,Z){function A(a){const b=new X.ShaderBuilder,{vertex:f,fragment:e,varyings:n}=b;q.addProjViewLocalOrigin(f,a);b.include(H.PositionAttribute);n.add("vpos","vec3");b.include(T.VisualVariables,a);b.include(G.InstancedDoublePrecision,a);b.include(M.VerticalOffset,a);a.hasColorTextureTransform&&b.include(h.colorTextureUV);if(a.output===k.ShaderOutput.Color||a.output===k.ShaderOutput.Alpha)a.hasNormalTextureTransform&&
b.include(h.normalTextureUV),a.hasEmissionTextureTransform&&b.include(h.emissiveTextureUV),a.hasOcclusionTextureTransform&&b.include(h.occlusionTextureUV),a.hasMetallicRoughnessTextureTransform&&b.include(h.metallicRoughnessTextureUV),q.addCameraPosition(f,a),b.include(g.NormalAttribute,a),b.include(F.Transform,a),a.normalType===g.NormalAttributeType.Attribute&&a.offsetBackfaces&&b.include(E.Offset),b.include(O.ComputeNormalTexture,a),b.include(L.VertexNormal,a),a.instancedColor&&b.attributes.add(Z.VertexAttribute.INSTANCECOLOR,
"vec4"),n.add("localvpos","vec3"),b.include(J.TextureCoordinateAttribute,a),b.include(D.ForwardLinearDepth,a),b.include(I.SymbolColor,a),b.include(K.VertexColor,a),f.uniforms.add(new V.Float4PassUniform("externalColor",d=>d.externalColor)),n.add("vcolorExt","vec4"),a.hasMultipassTerrain&&n.add("depth","float"),a.hasModelTransformation&&f.uniforms.add(new W.Matrix4PassUniform("model",d=>B.isSome(d.modelTransformation)?d.modelTransformation:C.IDENTITY)),f.code.add(c.glsl`
      void main(void) {
        forwardNormalizedVertexColor();
        vcolorExt = externalColor;
        ${a.instancedColor?"vcolorExt *\x3d instanceColor;":""}
        vcolorExt *= vvColor();
        vcolorExt *= getSymbolColor();
        forwardColorMixMode();

        if (vcolorExt.a < ${c.glsl.float(U.symbolAlphaCutoff)}) {
          gl_Position = vec4(1e38, 1e38, 1e38, 1.0);
        } else {
          vpos = calculateVPos();
          localvpos = vpos - view[3].xyz;
          vpos = subtractOrigin(vpos);
          ${a.normalType===g.NormalAttributeType.Attribute?c.glsl`vNormalWorld = dpNormal(vvLocalNormal(normalModel()));`:""}
          vpos = addVerticalOffset(vpos, localOrigin);
          ${a.hasVertexTangents?"vTangent \x3d dpTransformVertexTangent(tangent);":""}
          gl_Position = transformPosition(proj, view, ${a.hasModelTransformation?"model,":""} vpos);
          ${a.normalType===g.NormalAttributeType.Attribute&&a.offsetBackfaces?"gl_Position \x3d offsetBackfacingClipPosition(gl_Position, vpos, vNormalWorld, cameraPosition);":""}
        }

        ${a.hasMultipassTerrain?"depth \x3d (view * vec4(vpos, 1.0)).z;":""}
        forwardLinearDepth();
        forwardTextureCoordinates();
        ${a.hasColorTextureTransform?c.glsl`forwardColorUV();`:""}
        ${a.hasNormalTextureTransform?c.glsl`forwardNormalUV();`:""}
        ${a.hasEmissionTextureTransform?c.glsl`forwardEmissiveUV();`:""}
        ${a.hasOcclusionTextureTransform?c.glsl`forwardOcclusionUV();`:""}
        ${a.hasMetallicRoughnessTextureTransform?c.glsl`forwardMetallicRoughnessUV();`:""}
      }
    `);a.output===k.ShaderOutput.Alpha&&(b.include(t.SliceDraw,a),b.include(w.DiscardOrAdjustAlphaPass,a),b.include(u.multipassTerrainTest,a),e.uniforms.add([new m.FloatPassUniform("opacity",d=>d.opacity),new m.FloatPassUniform("layerOpacity",d=>d.layerOpacity)]),a.hasColorTexture&&e.uniforms.add(new z.Texture2DPassUniform("tex",d=>d.texture)),e.include(x.MixExternalColor),e.code.add(c.glsl`
      void main() {
        discardBySlice(vpos);
        ${a.hasMultipassTerrain?"terrainDepthTest(gl_FragCoord, depth);":""}
        ${a.hasColorTexture?c.glsl`
                vec4 texColor = texture2D(tex, ${a.hasColorTextureTransform?c.glsl`colorUV`:c.glsl`vuv0`});
                ${a.textureAlphaPremultiplied?"texColor.rgb /\x3d texColor.a;":""}
                discardOrAdjustAlpha(texColor);`:c.glsl`vec4 texColor = vec4(1.0);`}
        ${a.hasVertexColors?c.glsl`float opacity_ = layerOpacity * mixExternalOpacity(vColor.a * opacity, texColor.a, vcolorExt.a, int(colorMixMode));`:c.glsl`float opacity_ = layerOpacity * mixExternalOpacity(opacity, texColor.a, vcolorExt.a, int(colorMixMode));`}
        gl_FragColor = vec4(opacity_);
      }
    `));a.output===k.ShaderOutput.Color&&(b.include(t.SliceDraw,a),b.include(p.EvaluateSceneLighting,a),b.include(P.EvaluateAmbientOcclusion,a),b.include(w.DiscardOrAdjustAlphaPass,a),b.include(a.instancedDoublePrecision?v.ReadShadowMapPass:v.ReadShadowMapDraw,a),b.include(u.multipassTerrainTest,a),q.addCameraPosition(e,a),e.uniforms.add([f.uniforms.get("localOrigin"),new y.Float3PassUniform("ambient",d=>d.ambient),new y.Float3PassUniform("diffuse",d=>d.diffuse),new m.FloatPassUniform("opacity",d=>
d.opacity),new m.FloatPassUniform("layerOpacity",d=>d.layerOpacity)]),a.hasColorTexture&&e.uniforms.add(new z.Texture2DPassUniform("tex",d=>d.texture)),b.include(l.PhysicallyBasedRenderingParameters,a),b.include(S.PhysicallyBasedRendering,a),e.include(x.MixExternalColor),b.include(R.Normals,a),p.addAmbientBoostFactor(e),p.addLightingGlobalFactor(e),Q.addMainLightIntensity(e),e.code.add(c.glsl`
      void main() {
        discardBySlice(vpos);
        ${a.hasMultipassTerrain?"terrainDepthTest(gl_FragCoord, depth);":""}
        ${a.hasColorTexture?c.glsl`
                vec4 texColor = texture2D(tex, ${a.hasColorTextureTransform?c.glsl`colorUV`:c.glsl`vuv0`});
                ${a.textureAlphaPremultiplied?"texColor.rgb /\x3d texColor.a;":""}
                discardOrAdjustAlpha(texColor);`:c.glsl`vec4 texColor = vec4(1.0);`}
        shadingParams.viewDirection = normalize(vpos - cameraPosition);
        ${a.normalType===g.NormalAttributeType.ScreenDerivative?c.glsl`
                vec3 normal = screenDerivativeNormal(localvpos);`:c.glsl`
                shadingParams.normalView = vNormalWorld;
                vec3 normal = shadingNormal(shadingParams);`}
        ${a.pbrMode===l.PBRMode.Normal?"applyPBRFactors();":""}
        float ssao = evaluateAmbientOcclusionInverse();
        ssao *= getBakedOcclusion();

        vec3 posWorld = vpos + localOrigin;

        float additionalAmbientScale = additionalDirectedAmbientLight(posWorld);
        float shadow = ${a.receiveShadows?"readShadowMap(vpos, linearDepth)":a.spherical?"lightingGlobalFactor * (1.0 - additionalAmbientScale)":"0.0"};

        vec3 matColor = max(ambient, diffuse);
        ${a.hasVertexColors?c.glsl`
                vec3 albedo = mixExternalColor(vColor.rgb * matColor, texColor.rgb, vcolorExt.rgb, int(colorMixMode));
                float opacity_ = layerOpacity * mixExternalOpacity(vColor.a * opacity, texColor.a, vcolorExt.a, int(colorMixMode));`:c.glsl`
                vec3 albedo = mixExternalColor(matColor, texColor.rgb, vcolorExt.rgb, int(colorMixMode));
                float opacity_ = layerOpacity * mixExternalOpacity(opacity, texColor.a, vcolorExt.a, int(colorMixMode));`}
        ${a.hasNormalTexture?c.glsl`
                mat3 tangentSpace = ${a.hasVertexTangents?"computeTangentSpace(normal);":"computeTangentSpace(normal, vpos, vuv0);"}
                vec3 shadingNormal = computeTextureNormal(tangentSpace, vuv0);`:c.glsl`vec3 shadingNormal = normal;`}
        vec3 normalGround = ${a.spherical?c.glsl`normalize(posWorld);`:c.glsl`vec3(0.0, 0.0, 1.0);`}

        ${a.snowCover?c.glsl`
                float snow = smoothstep(0.5, 0.55, dot(normal, normalGround));
                albedo = mix(albedo, vec3(1), snow);
                shadingNormal = mix(shadingNormal, normal, snow);
                ssao = mix(ssao, 1.0, snow);`:""}

        vec3 additionalLight = ssao * mainLightIntensity * additionalAmbientScale * ambientBoostFactor * lightingGlobalFactor;

        ${a.pbrMode===l.PBRMode.Normal||a.pbrMode===l.PBRMode.Schematic?c.glsl`
                float additionalAmbientIrradiance = additionalAmbientIrradianceFactor * mainLightIntensity[2];
                ${a.snowCover?c.glsl`
                        mrr = mix(mrr, vec3(0.0, 1.0, 0.04), snow);
                        emission = mix(emission, vec3(0.0), snow);`:""}

                vec3 shadedColor = evaluateSceneLightingPBR(shadingNormal, albedo, shadow, 1.0 - ssao, additionalLight, shadingParams.viewDirection, normalGround, mrr, emission, additionalAmbientIrradiance);`:c.glsl`vec3 shadedColor = evaluateSceneLighting(shadingNormal, albedo, shadow, 1.0 - ssao, additionalLight);`}
        gl_FragColor = highlightSlice(vec4(shadedColor, opacity_), vpos);
        ${a.transparencyPassType===Y.TransparencyPassType.Color?c.glsl`gl_FragColor = premultiplyAlpha(gl_FragColor);`:""}
      }
    `));b.include(N.DefaultMaterialAuxiliaryPasses,a);return b}const aa=Object.freeze(Object.defineProperty({__proto__:null,build:A},Symbol.toStringTag,{value:"Module"}));r.DefaultMaterial=aa;r.build=A});