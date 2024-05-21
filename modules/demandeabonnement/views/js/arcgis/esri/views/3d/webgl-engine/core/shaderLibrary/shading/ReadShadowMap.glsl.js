// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/_rollupPluginBabelHelpers ../../../../../../chunks/vec3f64 ../util/RgbaFloatEncoding.glsl ../util/WebGL2Utils ../../shaderModules/Float4PassUniform ../../shaderModules/IntegerPassUniform ../../shaderModules/interfaces ../../shaderModules/Matrix4sDrawUniform ../../shaderModules/Matrix4sPassUniform ../../shaderModules/Texture2DPassUniform ../../shaderModules/TextureSizeUniformType".split(" "),function(e,k,l,m,n,p,q,f,r,t,u,g){function h(a,b){a=a.fragment;a.include(m.RgbaFloatEncoding);
a.uniforms.add([...u.createTexture2DPassSizeUniforms("shadowMapTex",(c,d)=>d.shadowMap.depthTexture,b.hasWebGL2Context?g.TextureSizeUniformType.None:g.TextureSizeUniformType.Size),new q.IntegerPassUniform("numCascades",(c,d)=>d.shadowMap.numCascades),new p.Float4PassUniform("cascadeDistances",(c,d)=>d.shadowMap.cascadeDistances)]);a.code.add(f.glsl`
    int chooseCascade(float depth, out mat4 mat) {
      vec4 distance = cascadeDistances;

      // choose correct cascade
      int i = depth < distance[1] ? 0 : depth < distance[2] ? 1 : depth < distance[3] ? 2 : 3;

      mat = i == 0 ? shadowMapMatrix[0] : i == 1 ? shadowMapMatrix[1] : i == 2 ? shadowMapMatrix[2] : shadowMapMatrix[3];

      return i;
    }

    vec3 lightSpacePosition(vec3 _vpos, mat4 mat) {
      vec4 lv = mat * vec4(_vpos, 1.0);
      lv.xy /= lv.w;
      return 0.5 * lv.xyz + vec3(0.5);
    }

    vec2 cascadeCoordinates(int i, vec3 lvpos) {
      return vec2(float(i - 2 * (i / 2)) * 0.5, float(i / 2) * 0.5) + 0.5 * lvpos.xy;
    }

    float readShadowMapDepth(vec2 uv, sampler2D _depthTex) {
      return rgba2float(texture2D(_depthTex, uv));
    }

    float posIsInShadow(vec2 uv, vec3 lvpos, sampler2D _depthTex) {
      return readShadowMapDepth(uv, _depthTex) < lvpos.z ? 1.0 : 0.0;
    }

    float filterShadow(vec2 uv, vec3 lvpos, float textureSize, sampler2D _depthTex) {
      float halfPixelSize = 0.5 / textureSize;

      // filter, offset by half pixels
      vec2 st = fract((vec2(halfPixelSize) + uv) * textureSize);

      float s00 = posIsInShadow(uv + vec2(-halfPixelSize, -halfPixelSize), lvpos, _depthTex);
      float s10 = posIsInShadow(uv + vec2(halfPixelSize, -halfPixelSize), lvpos, _depthTex);
      float s11 = posIsInShadow(uv + vec2(halfPixelSize, halfPixelSize), lvpos, _depthTex);
      float s01 = posIsInShadow(uv + vec2(-halfPixelSize, halfPixelSize), lvpos, _depthTex);

      return mix(mix(s00, s10, st.x), mix(s01, s11, st.x), st.y);
    }

    float readShadowMap(const in vec3 _vpos, float _linearDepth) {
      mat4 mat;
      int i = chooseCascade(_linearDepth, mat);

      if (i >= numCascades) { return 0.0; }

      vec3 lvpos = lightSpacePosition(_vpos, mat);

      // vertex completely outside? -> no shadow
      if (lvpos.z >= 1.0) { return 0.0; }
      if (lvpos.x < 0.0 || lvpos.x > 1.0 || lvpos.y < 0.0 || lvpos.y > 1.0) { return 0.0; }

      // calc coord in cascade texture
      vec2 uv = cascadeCoordinates(i, lvpos);

      vec2 textureSize = ${n.textureSize(b,"shadowMapTex")};

      return filterShadow(uv, lvpos, textureSize.x, shadowMapTex);
    }
  `)}let v=function(a){function b(){var c=a.apply(this,arguments)||this;c.origin=l.create();return c}k._inheritsLoose(b,a);return b}(f.NoParameters);e.ReadShadowMapBindParameters=v;e.ReadShadowMapDraw=function(a,b){b.receiveShadows&&(a.fragment.uniforms.add(new r.Matrix4sDrawUniform("shadowMapMatrix",(c,d)=>d.shadowMap.getShadowMapMatrices(c.origin),4)),h(a,b))};e.ReadShadowMapPass=function(a,b){b.receiveShadows&&(a.fragment.uniforms.add(new t.Matrix4sPassUniform("shadowMapMatrix",(c,d)=>d.shadowMap.getShadowMapMatrices(c.origin),
4)),h(a,b))};Object.defineProperties(e,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});