// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../collections/Component/Material/shader/ComponentData.glsl ../../../core/shaderLibrary/util/DoublePrecision.glsl ../../../core/shaderLibrary/util/RgbaFloatEncoding.glsl ../../../core/shaderLibrary/util/WebGL2Utils ../../../core/shaderModules/Float3DrawUniform ../../../core/shaderModules/Float3PassUniform ../../../core/shaderModules/FloatPassUniform ../../../core/shaderModules/interfaces ../../../core/shaderModules/Matrix3DrawUniform ../../../core/shaderModules/Matrix3PassUniform ../../../core/shaderModules/Matrix4PassUniform ../../../core/shaderModules/Texture2DDrawUniform ../../../core/shaderModules/TextureSizeUniformType ../../../lib/VertexAttribute".split(" "),
function(e,q,k,r,g,l,m,t,d,n,u,v,w,p,h){e.EdgeUtilMode=void 0;(function(b){b[b.SOLID=0]="SOLID";b[b.SKETCH=1]="SKETCH";b[b.MIXED=2]="MIXED";b[b.COUNT=3]="COUNT"})(e.EdgeUtilMode||(e.EdgeUtilMode={}));e.EdgeUtil=function(b,f){const a=b.vertex;a.include(r.RgbaFloatEncoding);a.uniforms.add(new t.FloatPassUniform("distanceFalloffFactor",c=>c.distanceFalloffFactor));a.code.add(d.glsl`float distanceBasedPerspectiveFactor(float distance) {
return clamp(sqrt(distanceFalloffFactor / distance), 0.0, 1.0);
}`);a.uniforms.add(w.createTexture2DDrawSizeUniforms("componentDataTex",c=>c.componentDataTexture,f.hasWebGL2Context?p.TextureSizeUniformType.None:p.TextureSizeUniformType.InvSize));b.attributes.add(h.VertexAttribute.COMPONENTINDEX,"float");a.constants.add("componentColorFieldOffset","float",0);a.constants.add("componentOtherFieldOffset","float",1);a.constants.add("componentVerticalOffsetFieldOffset","float",2);a.constants.add("componentFieldCount","float",3);a.constants.add("lineWidthFractionFactor",
"float",8);a.constants.add("extensionLengthOffset","float",128);a.constants.add("verticalOffsetScale","float",2*q.MAX_ELEVATION_OFFSET);a.code.add(d.glsl`
    vec2 _componentTextureCoords(float componentIndex, float fieldOffset) {
      float fieldIndex = componentFieldCount * componentIndex + fieldOffset;

      vec2 textureSizeInverse = ${g.textureSize(f,"componentDataTex",!0)};

      float colIndex = mod(fieldIndex, 1.0 / textureSizeInverse.x);
      float rowIndex = floor(fieldIndex * textureSizeInverse.x);

      vec2 textureCoordinates = vec2(colIndex, rowIndex) + 0.5;

      return textureCoordinates;
    }

    struct ComponentData {
      vec4 color;
      float lineWidth;
      float extensionLength;
      float type;
      float verticalOffset;
    };

    ComponentData readComponentData() {
      vec2 colorIndex = _componentTextureCoords(componentIndex, componentColorFieldOffset);
      vec2 otherIndex = _componentTextureCoords(componentIndex, componentOtherFieldOffset);
      vec2 verticalOffsetIndex = _componentTextureCoords(componentIndex, componentVerticalOffsetFieldOffset);

      vec4 colorValue = ${g.texelFetch(f,"componentDataTex","colorIndex")};
      vec4 otherValue = ${g.texelFetch(f,"componentDataTex","otherIndex")};
      float verticalOffset = (rgba2float(${g.texelFetch(f,"componentDataTex","verticalOffsetIndex")}) - 0.5) * verticalOffsetScale;

      return ComponentData(
        vec4(colorValue.rgb, colorValue.a * otherValue.w), // otherValue.w stores separate opacity
        otherValue.x * (255.0 / lineWidthFractionFactor),
        otherValue.y * 255.0 - extensionLengthOffset,
        -(otherValue.z * 255.0) + 0.5, // SOLID (=0/255) needs to be > 0.0, SKETCHY (=1/255) needs to be <= 0;
        verticalOffset
      );
    }
  `);f.legacy?a.code.add(d.glsl`vec3 _modelToWorldNormal(vec3 normal) {
return (model * vec4(normal, 0.0)).xyz;
}
vec3 _modelToViewNormal(vec3 normal) {
return (localView * model * vec4(normal, 0.0)).xyz;
}`):(a.uniforms.add(new n.Matrix3DrawUniform("transformNormalGlobalFromModel",c=>c.transformNormalGlobalFromModel)),a.code.add(d.glsl`vec3 _modelToWorldNormal(vec3 normal) {
return transformNormalGlobalFromModel * normal;
}`));f.silhouette?(b.attributes.add(h.VertexAttribute.NORMALA,"vec3"),b.attributes.add(h.VertexAttribute.NORMALB,"vec3"),a.code.add(d.glsl`vec3 worldNormal() {
return _modelToWorldNormal(normalize(normalA + normalB));
}`)):(b.attributes.add(h.VertexAttribute.NORMAL,"vec3"),a.code.add(d.glsl`vec3 worldNormal() {
return _modelToWorldNormal(normal);
}`));f.legacy?a.code.add(d.glsl`void worldAndViewFromModelPosition(vec3 modelPos, float verticalOffset, out vec3 worldPos, out vec3 viewPos) {
worldPos = (model * vec4(modelPos, 1.0)).xyz;
viewPos = (localView * vec4(worldPos, 1.0)).xyz;
}`):(a.include(k.DoublePrecision,f),a.include(k.DoublePrecision,f),a.uniforms.add([new u.Matrix3PassUniform("transformViewFromCameraRelativeRS",c=>c.transformViewFromCameraRelativeRS),new n.Matrix3DrawUniform("transformWorldFromModelRS",c=>c.transformWorldFromModelRS),new l.Float3DrawUniform("transformWorldFromModelTL",c=>c.transformWorldFromModelTL),new l.Float3DrawUniform("transformWorldFromModelTH",c=>c.transformWorldFromModelTH),new m.Float3PassUniform("transformWorldFromViewTL",c=>c.transformWorldFromViewTL),
new m.Float3PassUniform("transformWorldFromViewTH",c=>c.transformWorldFromViewTH)]),a.code.add(d.glsl`
      void worldAndViewFromModelPosition(vec3 modelPos, float verticalOffset, out vec3 worldPos, out vec3 viewPos) {
        vec3 rotatedModelPosition = transformWorldFromModelRS * modelPos;

        vec3 transformCameraRelativeFromModel = dpAdd(
          transformWorldFromModelTL,
          transformWorldFromModelTH,
          -transformWorldFromViewTL,
          -transformWorldFromViewTH
        );

        worldPos = transformCameraRelativeFromModel + rotatedModelPosition;

        if (verticalOffset != 0.0) {
          vec3 vUp = ${f.spherical?d.glsl`normalize(transformWorldFromModelTL + rotatedModelPosition);`:d.glsl`vec3(0.0, 0.0, 1.0);`}
          worldPos += verticalOffset * vUp;
        }

        viewPos = transformViewFromCameraRelativeRS * worldPos;
      }
    `));a.uniforms.add(new v.Matrix4PassUniform("transformProjFromView",(c,x)=>x.camera.projectionMatrix));a.code.add(d.glsl`vec4 projFromViewPosition(vec3 position) {
return transformProjFromView * vec4(position, 1.0);
}`);a.code.add(d.glsl`float calculateExtensionLength(float extensionLength, float lineLength) {
return extensionLength / (log2(max(1.0, 256.0 / lineLength)) * 0.2 + 1.0);
}`)};e.usesSketchLogic=function(b){return b.mode===e.EdgeUtilMode.SKETCH||b.mode===e.EdgeUtilMode.MIXED};e.usesSolidLogic=function(b){return b.mode===e.EdgeUtilMode.SOLID||b.mode===e.EdgeUtilMode.MIXED};Object.defineProperties(e,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});