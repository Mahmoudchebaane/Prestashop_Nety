// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../chunks/_rollupPluginBabelHelpers ../../../../core/devEnvironmentUtils ../../../../core/maybe ../../../../chunks/mat3 ../../../../chunks/mat3f64 ../../../../chunks/mat4 ../../../../chunks/mat4f64 ../../../../chunks/vec3 ../../../../chunks/vec3f64 ../../../../geometry/support/aaBoundingBox ../../../../geometry/support/buffer/BufferView ../../../../chunks/vec32 ../../../../chunks/vec42 ../../../../geometry/support/buffer/utils ../../glTF/DefaultLoadingContext ../../glTF/loader ../../glTF/internal/indexUtils ../../glTF/internal/TextureTransformUtils ./ProcessedObjectResource ./wosrLoader ../../webgl-engine/lib/basicInterfaces ../../webgl-engine/lib/Geometry ../../webgl-engine/lib/Texture ../../webgl-engine/lib/VertexAttribute ../../webgl-engine/materials/DefaultMaterial ../../webgl-engine/materials/DefaultMaterial_COLOR_GAMMA ../../../webgl/enums ../../../../chunks/vec22 ../../../../chunks/vec43 ../../../../chunks/vec33".split(" "),
function(K,da,ea,f,X,fa,ha,ia,w,R,S,n,L,T,A,ja,ka,U,I,la,Y,y,ma,na,r,oa,D,V,pa,Z,qa){function W(){W=da._asyncToGenerator(function*(k,e){k=aa(ea.adjustStaticAGOUrl(k));if("wosr"===k.fileType){var t=yield e.cache?e.cache.loadWOSR(k.url,e):Y.load(k.url,e);const {engineResources:p,referenceBoundingBox:u}=Y.processLoadResult(t,e);return{lods:p,referenceBoundingBox:u,isEsriSymbolResource:!1,isWosr:!0}}const l=yield e.cache?e.cache.loadGLTF(k.url,e,e.usePBR):ka.loadGLTF(new ja.DefaultLoadingContext(e.streamDataRequester),
k.url,e,e.usePBR),x=f.get(l.model.meta,"ESRI_proxyEllipsoid"),E=l.meta.isEsriSymbolResource&&f.isSome(x)&&l.meta.uri.includes("/RealisticTrees/");if(E&&!l.customMeta.esriTreeRendering){l.customMeta.esriTreeRendering=!0;a:for(let p=0;p<l.model.lods.length;++p){var z=l.model.lods[p];for(t of z.parts){z=t.attributes.normal;if(f.isNone(z))break a;const u=t.attributes.position,F=u.count,G=R.create(),B=R.create(),g=R.create(),a=A.createBuffer(n.BufferViewVec4u8,F),h=A.createBuffer(n.BufferViewVec3f,F),
b=ha.invert(ia.create(),t.transform);for(let c=0;c<F;c++){u.getVec(c,B);z.getVec(c,G);w.transformMat4(B,B,t.transform);w.subtract(g,B,x.center);w.divide(g,g,x.radius);const v=g[2];var m=w.length(g);m=Math.min(.45+.55*m*m,1);w.divide(g,g,x.radius);null!==b&&w.transformMat4(g,g,b);w.normalize(g,g);p+1!==l.model.lods.length&&1<l.model.lods.length&&(-1<v?w.lerp(g,g,G,.2):w.lerp(g,g,G,Math.min(-4*v-3.8,1)));h.setVec(c,g);a.set(c,0,255*m);a.set(c,1,255*m);a.set(c,2,255*m);a.set(c,3,255)}t.attributes.normal=
h;t.attributes.color=a}}}const {engineResources:M,referenceBoundingBox:J}=ba(l,l.meta.isEsriSymbolResource?{usePBR:e.usePBR,isSchematic:!1,treeRendering:E,mrrFactors:[0,1,.2]}:{usePBR:e.usePBR,isSchematic:!1,treeRendering:!1,mrrFactors:[0,1,.5]},{...e.materialParamsMixin,treeRendering:E},e.skipHighLods&&null==k.specifiedLodIndex?{skipHighLods:!0}:{skipHighLods:!1,singleLodIndex:k.specifiedLodIndex});return{lods:M,referenceBoundingBox:J,isEsriSymbolResource:l.meta.isEsriSymbolResource,isWosr:!1}});
return W.apply(this,arguments)}function aa(k){const e=k.match(/(.*\.(gltf|glb))(\?lod=([0-9]+))?$/);return e?{fileType:"gltf",url:e[1],specifiedLodIndex:null!=e[4]?Number(e[4]):null}:k.match(/(.*\.(json|json\.gz))$/)?{fileType:"wosr",url:k,specifiedLodIndex:null}:{fileType:"unknown",url:k,specifiedLodIndex:null}}function ba(k,e,t,l){const x=k.model,E=[],z=new Map,m=new Map,M=x.lods.length,J=S.empty();x.lods.forEach((p,u)=>{const F=!0===l.skipHighLods&&(1<M&&0===u||3<M&&1===u)||!1===l.skipHighLods&&
null!=l.singleLodIndex&&u!==l.singleLodIndex;if(!F||0===u){var G=[],B=0;p.parts.forEach(a=>{a:{var h=a.indices||a.attributes.position.count;switch(a.primitiveType){case V.PrimitiveType.TRIANGLES:h=U.trianglesToTriangles(h);break a;case V.PrimitiveType.TRIANGLE_STRIP:h=U.triangleStripToTriangles(h);break a;case V.PrimitiveType.TRIANGLE_FAN:h=U.triangleFanToTriangles(h);break a}h=void 0}const b=a.attributes.position.count;var c=A.createBuffer(n.BufferViewVec3f,b);L.transformMat4(c,a.attributes.position,
a.transform);c=[[r.VertexAttribute.POSITION,{data:c.typedBuffer,size:c.elementCount,exclusive:!0}]];const v=[[r.VertexAttribute.POSITION,h]];if(f.isSome(a.attributes.normal)){var d=A.createBuffer(n.BufferViewVec3f,b);X.normalFromMat4(N,a.transform);L.transformMat3(d,a.attributes.normal,N);c.push([r.VertexAttribute.NORMAL,{data:d.typedBuffer,size:d.elementCount,exclusive:!0}]);v.push([r.VertexAttribute.NORMAL,h])}f.isSome(a.attributes.tangent)&&(d=A.createBuffer(n.BufferViewVec4f,b),X.normalFromMat4(N,
a.transform),T.transformMat3(d,a.attributes.tangent,N),c.push([r.VertexAttribute.TANGENT,{data:d.typedBuffer,size:d.elementCount,exclusive:!0}]),v.push([r.VertexAttribute.TANGENT,h]));f.isSome(a.attributes.texCoord0)&&(d=A.createBuffer(n.BufferViewVec2f,b),pa.normalizeIntegerBuffer(d,a.attributes.texCoord0),c.push([r.VertexAttribute.UV0,{data:d.typedBuffer,size:d.elementCount,exclusive:!0}]),v.push([r.VertexAttribute.UV0,h]));if(f.isSome(a.attributes.color)){d=A.createBuffer(n.BufferViewVec4u8,b);
if(4===a.attributes.color.elementCount)a.attributes.color instanceof n.BufferViewVec4f?T.scale(d,a.attributes.color,255):a.attributes.color instanceof n.BufferViewVec4u8?Z.copy(d,a.attributes.color):a.attributes.color instanceof n.BufferViewVec4u16&&T.scale(d,a.attributes.color,1/256);else{Z.fill(d,255,255,255,255);const H=new n.BufferViewVec3u8(d.buffer,0,4);a.attributes.color instanceof n.BufferViewVec3f?L.scale(H,a.attributes.color,255):a.attributes.color instanceof n.BufferViewVec3u8?qa.copy(H,
a.attributes.color):a.attributes.color instanceof n.BufferViewVec3u16&&L.scale(H,a.attributes.color,1/256)}c.push([r.VertexAttribute.COLOR,{data:d.typedBuffer,size:d.elementCount,exclusive:!0}]);v.push([r.VertexAttribute.COLOR,h])}a={geometry:new ma.Geometry(c,v),vertexCount:b};const {geometry:q,vertexCount:C}=a;G.push(q);B+=C;a=q.boundingInfo;f.isSome(a)&&0===u&&(S.expandWithVec3(J,a.getBBMin()),S.expandWithVec3(J,a.getBBMax()))});if(!F){var g=new la.ProcessedObjectResource(p.name,{textures:[],materials:[],
geometries:G},p.lodThreshold,[0,0,0],B);E.push(g);p.parts.forEach(a=>{const h=a.material+(a.attributes.normal?"_normal":"")+(a.attributes.color?"_color":"")+(a.attributes.texCoord0?"_texCoord0":"")+(a.attributes.tangent?"_tangent":""),b=x.materials.get(a.material),c=f.isSome(a.attributes.texCoord0),v=f.isSome(a.attributes.normal);if(!f.isNone(b)){a:{switch(b.alphaMode){case "BLEND":var d=y.AlphaDiscardMode.Blend;break a;case "MASK":d=y.AlphaDiscardMode.Mask;break a;case "OPAQUE":case null:case void 0:d=
y.AlphaDiscardMode.Opaque;break a}d=void 0}if(!z.has(h)){if(c){var q=(O,ca=!1)=>{if(f.isSome(O)&&!m.has(O)){const P=x.textures.get(O);f.isSome(P)&&m.set(O,new na.Texture(P.data,ca?{...P.parameters,preMultiplyAlpha:ca}:P.parameters))}};q(b.textureColor,d!==y.AlphaDiscardMode.Opaque);q(b.textureNormal);q(b.textureOcclusion);q(b.textureEmissive);q(b.textureMetallicRoughness)}q=b.color[0]**(1/D.COLOR_GAMMA);const C=b.color[1]**(1/D.COLOR_GAMMA),H=b.color[2]**(1/D.COLOR_GAMMA),ra=b.emissiveFactor[0]**
(1/D.COLOR_GAMMA),sa=b.emissiveFactor[1]**(1/D.COLOR_GAMMA),ta=b.emissiveFactor[2]**(1/D.COLOR_GAMMA),Q=f.isSome(b.textureColor)&&c?m.get(b.textureColor):null;z.set(h,new oa.DefaultMaterial({...e,transparent:d===y.AlphaDiscardMode.Blend,customDepthTest:y.DepthTestFunction.Lequal,textureAlphaMode:d,textureAlphaCutoff:b.alphaCutoff,diffuse:[q,C,H],ambient:[q,C,H],opacity:b.opacity,doubleSided:b.doubleSided,doubleSidedType:"winding-order",cullFace:b.doubleSided?y.CullFaceOptions.None:y.CullFaceOptions.Back,
hasVertexColors:!!a.attributes.color,hasVertexTangents:!!a.attributes.tangent,normals:v?"default":"screenDerivative",castShadows:!0,receiveSSAO:!0,textureId:f.isSome(Q)?Q.id:void 0,colorMixMode:b.colorMixMode,normalTextureId:f.isSome(b.textureNormal)&&c?m.get(b.textureNormal).id:void 0,textureAlphaPremultiplied:f.isSome(Q)&&!!Q.params.preMultiplyAlpha,occlusionTextureId:f.isSome(b.textureOcclusion)&&c?m.get(b.textureOcclusion).id:void 0,emissiveTextureId:f.isSome(b.textureEmissive)&&c?m.get(b.textureEmissive).id:
void 0,metallicRoughnessTextureId:f.isSome(b.textureMetallicRoughness)&&c?m.get(b.textureMetallicRoughness).id:void 0,emissiveFactor:[ra,sa,ta],mrrFactors:[b.metallicFactor,b.roughnessFactor,e.mrrFactors[2]],isSchematic:!1,colorTextureTransformMatrix:I.getTransformMatrix(b.colorTextureTransform),normalTextureTransformMatrix:I.getTransformMatrix(b.normalTextureTransform),occlusionTextureTransformMatrix:I.getTransformMatrix(b.occlusionTextureTransform),emissiveTextureTransformMatrix:I.getTransformMatrix(b.emissiveTextureTransform),
metallicRoughnessTextureTransformMatrix:I.getTransformMatrix(b.metallicRoughnessTextureTransform),...t}))}g.stageResources.materials.push(z.get(h));c&&(a=C=>{f.isSome(C)&&g.stageResources.textures.push(m.get(C))},a(b.textureColor),a(b.textureNormal),a(b.textureOcclusion),a(b.textureEmissive),a(b.textureMetallicRoughness))}})}}});return{engineResources:E,referenceBoundingBox:J}}const N=fa.create();K.fetch=function(k,e){return W.apply(this,arguments)};K.gltfToEngineResources=ba;K.parseUrl=aa;Object.defineProperties(K,
{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});