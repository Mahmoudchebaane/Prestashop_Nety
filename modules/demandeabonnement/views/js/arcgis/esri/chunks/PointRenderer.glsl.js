// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ./_rollupPluginBabelHelpers ../core/mathUtils ./mat4 ./mat4f64 ./vec2 ./vec2f64 ./vec3 ./vec3f64 ../geometry/support/aaBoundingBox ../views/3d/webgl-engine/core/shaderLibrary/ForwardLinearDepth.glsl ../views/3d/webgl-engine/core/shaderLibrary/ShaderOutput ../views/3d/webgl-engine/core/shaderLibrary/Slice.glsl ../views/3d/webgl-engine/core/shaderLibrary/output/OutputHighlight.glsl ../views/3d/webgl-engine/core/shaderLibrary/util/RgbaFloatEncoding.glsl ../views/3d/webgl-engine/core/shaderModules/Float2DrawUniform ../views/3d/webgl-engine/core/shaderModules/Float2PassUniform ../views/3d/webgl-engine/core/shaderModules/Float3DrawUniform ../views/3d/webgl-engine/core/shaderModules/interfaces ../views/3d/webgl-engine/core/shaderModules/Matrix4DrawUniform ../views/3d/webgl-engine/core/shaderModules/Matrix4PassUniform ../views/3d/webgl-engine/core/shaderModules/ShaderBuilder ../views/3d/webgl-engine/lib/VertexAttribute".split(" "),
function(l,q,k,v,r,t,K,w,L,x,y,n,z,M,N,A,O,B,h,P,Q,R,C){function D(a){const b=new R.ShaderBuilder,e=a.output===n.ShaderOutput.Color,m=a.output===n.ShaderOutput.Depth,p=a.output===n.ShaderOutput.Highlight,{vertex:g,fragment:E}=b;b.extensions.add("GL_OES_standard_derivatives");b.include(z.SliceDraw,a);b.attributes.add(C.VertexAttribute.POSITION,"vec3");b.attributes.add(C.VertexAttribute.COLOR,"vec3");g.uniforms.add([new P.Matrix4DrawUniform("modelView",(c,d)=>v.multiply(F,d.camera.viewMatrix,v.fromTranslation(F,
c.origin))),new Q.Matrix4PassUniform("proj",(c,d)=>d.camera.projectionMatrix),new A.Float2DrawUniform("screenMinMaxSize",(c,d,f)=>t.set(u,f.useFixedSizes?0:f.minSizePx*d.camera.pixelRatio,(c.isLeaf?256:64)*d.camera.pixelRatio))]);g.uniforms.add(a.useFixedSizes?new O.Float2PassUniform("pointScale",(c,d)=>t.set(u,c.fixedSize*d.camera.pixelRatio,d.camera.fullHeight)):new A.Float2DrawUniform("pointScale",(c,d,f)=>t.set(u,c.splatSize*f.scaleFactor*d.camera.pixelRatio,d.camera.fullHeight/d.camera.pixelRatio)));
a.clippingEnabled?g.uniforms.add([new B.Float3DrawUniform("clipMin",(c,d,f)=>w.set(G,f.clipBox[0]-c.origin[0],f.clipBox[1]-c.origin[1],f.clipBox[2]-c.origin[2])),new B.Float3DrawUniform("clipMax",(c,d,f)=>w.set(G,f.clipBox[3]-c.origin[0],f.clipBox[4]-c.origin[1],f.clipBox[5]-c.origin[2]))]):(g.constants.add("clipMin","vec3",[-k.NUMBER_MAX_FLOAT32,-k.NUMBER_MAX_FLOAT32,-k.NUMBER_MAX_FLOAT32]),g.constants.add("clipMax","vec3",[k.NUMBER_MAX_FLOAT32,k.NUMBER_MAX_FLOAT32,k.NUMBER_MAX_FLOAT32]));m?(y.addNearFar(b),
y.addCalculateLinearDepth(b),b.varyings.add("depth","float")):a.output!==n.ShaderOutput.Highlight&&b.varyings.add("vColor","vec3");g.code.add(h.glsl`
    void main(void) {
      // Move clipped points outside of clipspace
      if (position.x < clipMin.x || position.y < clipMin.y || position.z < clipMin.z ||
        position.x > clipMax.x || position.y > clipMax.y || position.z > clipMax.z) {
        gl_Position = vec4(0.0,0.0,0.0,2.0);
        gl_PointSize = 0.0;
        return;
      }

      if (rejectBySlice(position)) {
        gl_Position = vec4(0.0,0.0,0.0,2.0);
        gl_PointSize = 0.0;
        return;
      }

      // Position in camera space
      vec4 camera = modelView * vec4(position, 1.0);

      float pointSize = pointScale.x;
      vec4 position = proj * camera;
     ${a.drawScreenSize?h.glsl`
      float clampedScreenSize = pointSize;`:h.glsl`
      float pointRadius = 0.5 * pointSize;
      vec4 cameraOffset = camera + vec4(0.0, pointRadius, 0.0, 0.0);
      vec4 positionOffset = proj * cameraOffset;
      float radius = abs(positionOffset.y - position.y);
      float viewHeight = pointScale.y;
      // screen diameter = (2 * r / w) * (h / 2)
      float screenPointSize = (radius / position.w) * viewHeight;
      float clampedScreenSize = clamp(screenPointSize, screenMinMaxSize.x, screenMinMaxSize.y);
      // Shift towards camera, to move rendered point out of terrain i.e. to
      // the camera-facing end of the virtual point when considering it as a
      // 3D sphere.
      camera.xyz -= normalize(camera.xyz) * pointRadius * clampedScreenSize / screenPointSize;
      position = proj * camera;`}

     gl_PointSize = clampedScreenSize;
     gl_Position = position;

     ${m?h.glsl`depth = calculateLinearDepth(nearFar, camera.z);`:""}
     ${e?h.glsl`vColor = color;`:""}
    }
  `);E.include(N.RgbaFloatEncoding,a);p&&b.include(M.OutputHighlight,a);E.code.add(h.glsl`
    void main(void) {
      vec2 vOffset = gl_PointCoord - vec2(0.5, 0.5);
      float r2 = dot(vOffset, vOffset);

      if (r2 > 0.25) {
        discard;
      }
      ${m?h.glsl`gl_FragColor = float2rgba(depth);`:""}
      ${p?h.glsl`outputHighlight();`:""}
      ${e?h.glsl`gl_FragColor = vec4(vColor, 1.0);`:""}
    }
  `);return b}function H(a){return a?256:64}let I=function(a){function b(){var e=a.apply(this,arguments)||this;e.clipBox=x.create(x.POSITIVE_INFINITY);e.useFixedSizes=!1;e.useRealWorldSymbolSizes=!1;e.scaleFactor=1;e.minSizePx=0;e.size=0;e.sizePx=0;return e}q._inheritsLoose(b,a);q._createClass(b,[{key:"fixedSize",get:function(){return this.drawScreenSpace?this.sizePx:this.size}},{key:"screenMinSize",get:function(){return this.useFixedSizes?0:this.minSizePx}},{key:"drawScreenSpace",get:function(){return this.useFixedSizes&&
!this.useRealWorldSymbolSizes}}]);return b}(h.NoParameters),J=function(a){function b(e,m,p){var g=a.call(this,e)||this;g.origin=e;g.isLeaf=m;g.splatSize=p;return g}q._inheritsLoose(b,a);return b}(z.SlicePlaneParameters);const F=r.create(),G=L.create(),u=K.create();r=Object.freeze(Object.defineProperty({__proto__:null,PointRendererPassParameters:I,PointRendererDrawParameters:J,build:D,getMaxPointSizeScreenspace:H},Symbol.toStringTag,{value:"Module"}));l.PointRendererDrawParameters=J;l.PointRendererPassParameters=
I;l.PointRendererShader=r;l.build=D;l.getMaxPointSizeScreenspace=H});