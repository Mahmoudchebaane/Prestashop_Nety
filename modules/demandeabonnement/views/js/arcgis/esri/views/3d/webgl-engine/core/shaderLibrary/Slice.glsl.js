// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../chunks/_rollupPluginBabelHelpers ../../../../../core/maybe ../../../../../chunks/mat4 ../../../../../chunks/mat4f64 ../../../../../chunks/vec3 ../../../../../chunks/vec3f64 ../shaderModules/Float3DrawUniform ../shaderModules/Float3PassUniform ../shaderModules/interfaces".split(" "),function(l,y,e,z,A,f,h,p,q,g){function r(c,b,a){if(b.hasSlicePlane){c.extensions.add("GL_OES_standard_derivatives");b.hasSliceInVertexProgram&&c.vertex.uniforms.add(a);c.fragment.uniforms.add(a);
a=g.glsl`struct SliceFactors {
float front;
float side0;
float side1;
float side2;
float side3;
};
SliceFactors calculateSliceFactors(vec3 pos) {
vec3 rel = pos - slicePlaneOrigin;
vec3 slicePlaneNormal = -cross(slicePlaneBasis1, slicePlaneBasis2);
float slicePlaneW = -dot(slicePlaneNormal, slicePlaneOrigin);
float basis1Len2 = dot(slicePlaneBasis1, slicePlaneBasis1);
float basis2Len2 = dot(slicePlaneBasis2, slicePlaneBasis2);
float basis1Dot = dot(slicePlaneBasis1, rel);
float basis2Dot = dot(slicePlaneBasis2, rel);
return SliceFactors(
dot(slicePlaneNormal, pos) + slicePlaneW,
-basis1Dot - basis1Len2,
basis1Dot - basis1Len2,
-basis2Dot - basis2Len2,
basis2Dot - basis2Len2
);
}
bool sliceByFactors(SliceFactors factors) {
return factors.front < 0.0
&& factors.side0 < 0.0
&& factors.side1 < 0.0
&& factors.side2 < 0.0
&& factors.side3 < 0.0;
}
bool sliceEnabled() {
return dot(slicePlaneBasis1, slicePlaneBasis1) != 0.0;
}
bool sliceByPlane(vec3 pos) {
return sliceEnabled() && sliceByFactors(calculateSliceFactors(pos));
}
#define rejectBySlice(_pos_) sliceByPlane(_pos_)
#define discardBySlice(_pos_) { if (sliceByPlane(_pos_)) discard; }`;var d=g.glsl`vec4 applySliceHighlight(vec4 color, vec3 pos) {
SliceFactors factors = calculateSliceFactors(pos);
const float HIGHLIGHT_WIDTH = 1.0;
const vec4 HIGHLIGHT_COLOR = vec4(0.0, 0.0, 0.0, 0.3);
factors.front /= (2.0 * HIGHLIGHT_WIDTH) * fwidth(factors.front);
factors.side0 /= (2.0 * HIGHLIGHT_WIDTH) * fwidth(factors.side0);
factors.side1 /= (2.0 * HIGHLIGHT_WIDTH) * fwidth(factors.side1);
factors.side2 /= (2.0 * HIGHLIGHT_WIDTH) * fwidth(factors.side2);
factors.side3 /= (2.0 * HIGHLIGHT_WIDTH) * fwidth(factors.side3);
if (sliceByFactors(factors)) {
return color;
}
float highlightFactor = (1.0 - step(0.5, factors.front))
* (1.0 - step(0.5, factors.side0))
* (1.0 - step(0.5, factors.side1))
* (1.0 - step(0.5, factors.side2))
* (1.0 - step(0.5, factors.side3));
return mix(color, vec4(HIGHLIGHT_COLOR.rgb, color.a), highlightFactor * HIGHLIGHT_COLOR.a);
}`;d=b.hasSliceHighlight?g.glsl`
        ${d}
        #define highlightSlice(_color_, _pos_) (sliceEnabled() ? applySliceHighlight(_color_, _pos_) : (_color_))
      `:g.glsl`#define highlightSlice(_color_, _pos_) (_color_)`;b.hasSliceInVertexProgram&&c.vertex.code.add(a);c.fragment.code.add(a);c.fragment.code.add(d)}else a=g.glsl`#define rejectBySlice(_pos_) false
#define discardBySlice(_pos_) {}
#define highlightSlice(_color_, _pos_) (_color_)`,b.hasSliceInVertexProgram&&c.vertex.code.add(a),c.fragment.code.add(a)}function t(c,b,a){return c.instancedDoublePrecision?f.set(B,a.camera.viewInverseTransposeMatrix[3],a.camera.viewInverseTransposeMatrix[7],a.camera.viewInverseTransposeMatrix[11]):b.slicePlaneLocalOrigin}function u(c,b){return e.isSome(c)?f.subtract(m,b.origin,c):b.origin}function v(c,b,a){return c.hasSliceTranslatedView?e.isSome(b)?z.translate(C,a.camera.viewMatrix,b):a.camera.viewMatrix:
null}function w(c,b,a){if(e.isNone(a.slicePlane))return h.ZEROS;const d=t(c,b,a);b=u(d,a.slicePlane);c=v(c,d,a);return e.isSome(c)?f.transformMat4(m,b,c):b}function n(c,b,a,d){if(e.isNone(d)||e.isNone(a.slicePlane))return h.ZEROS;const x=t(c,b,a);b=u(x,a.slicePlane);c=v(c,x,a);return e.isSome(c)?(f.add(k,d,b),f.transformMat4(m,b,c),f.transformMat4(k,k,c),f.subtract(k,k,m)):d}let D=function(c){function b(a){var d=c.call(this)||this;d.slicePlaneLocalOrigin=a;return d}y._inheritsLoose(b,c);return b}(g.NoParameters);
const B=h.create(),m=h.create(),k=h.create(),C=A.create();l.SliceDraw=function(c,b){r(c,b,[new p.Float3DrawUniform("slicePlaneOrigin",(a,d)=>w(b,a,d)),new p.Float3DrawUniform("slicePlaneBasis1",(a,d)=>n(b,a,d,e.unwrap(d.slicePlane)?.basis1)),new p.Float3DrawUniform("slicePlaneBasis2",(a,d)=>n(b,a,d,e.unwrap(d.slicePlane)?.basis2))])};l.SlicePass=function(c,b){r(c,b,[new q.Float3PassUniform("slicePlaneOrigin",(a,d)=>w(b,a,d)),new q.Float3PassUniform("slicePlaneBasis1",(a,d)=>n(b,a,d,e.unwrap(d.slicePlane)?.basis1)),
new q.Float3PassUniform("slicePlaneBasis2",(a,d)=>n(b,a,d,e.unwrap(d.slicePlane)?.basis2))])};l.SlicePlaneParameters=D;Object.defineProperties(l,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});