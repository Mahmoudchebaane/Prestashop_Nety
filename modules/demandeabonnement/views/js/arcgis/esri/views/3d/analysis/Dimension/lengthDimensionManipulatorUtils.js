// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../Color ../../../../geometry ../../../../analysis/dimensionUtils ../../../../core/Cyclical ../../../../core/mathUtils ../../../../core/maybe ../../../../core/screenUtils ../../../../chunks/mat4 ../../../../chunks/mat4f64 ../../../../chunks/vec3 ../../../../chunks/vec3f64 ../../../../geometry/support/plane ../../../../geometry/support/vectorStacks ../../../../layers/graphics/hydratedFeatures ./lengthDimensionUtils ./settings ../../interactive/Manipulator3D ../../interactive/manipulatorUtils ../../interactive/editingTools/dragEventPipeline3D ../../interactive/visualElements/support/Segment ../../support/engineContent/marker ../../webgl-engine/lib/GeometryUtil ../../../interactive/dragEventPipeline ../../../interactive/interfaces ../../../../geometry/Point".split(" "),
function(m,Z,O,D,H,aa,E,I,J,ba,n,q,w,z,ca,k,t,P,x,B,da,ea,K,y,C,fa){function Q(c,{lineSizePt:a,material:b}){const {calloutOffsetPx:d,calloutOpacity:e,calloutWidth:f,discScale:h,focusMultiplier:g}=t.settings.orientationManipulator;return{calloutLength:.25*ea.MARKER_SIZE_PER_LINE_WIDTH*t.settings.markers.lineSizeFraction*I.pt2px(a)+d,calloutOpacity:e,calloutWidth:f,customStateMask:A,discScale:h,focusMultiplier:g,material:b,metadata:c}}function R(c){const {cancel:a,computation:b,settingHeading:d,steps:e,
view:f}=c;if(k.isValidComputation(b)){({renderCoordsHelper:c}=f);var {dimension:h,geometry:g}=b,l=q.create(),u=S(q.create(),g,g.directSegment,c);c=T(z.sv3d.get(),{forHeading:d,geometry:g,renderCoordsHelper:c});var r=w.fromPositionAndNormal(u,c,w.create()),v=d?E.unwrapOr(h.orientation,()=>k.headingFromGeometry(g,f.renderCoordsHelper)):E.unwrapOr(h.orientation,0);e.next(B.screenToRenderPlane(f,r)).next(p=>{"start"===p.action&&n.copy(l,p.renderStart);const L=w.normal(r);p=x.calculateInputRotationTransform(l,
p.renderEnd,u,L);p=v-aa.rad2deg(p);d||(p=U(p));h.orientation=p});a.next(y.resetProperties(h,["orientation"]))}}function U(c){const a=H.cyclicalDegrees.normalize(c)%90;return a<t.settings.orientationSnapThresholdDegrees?c-a:90-a<t.settings.orientationSnapThresholdDegrees?c+(90-a):c}function V(c,a,b,d){var e=n.subtract(z.sv3d.get(),b.endRenderSpace,b.startRenderSpace);n.cross(e,e,d);e=w.fromPositionAndNormal(b.startRenderSpace,e,w.create());const f=w.fromPositionAndNormal(b.startRenderSpace,d,w.create()),
h=a.offset;let g=0,l;const u=new y.EventPipeline;u.next(B.screenToRenderPlane(c,e)).next(r=>{"start"===r.action&&(g=w.signedDistance(f,r.renderStart));const v=(w.signedDistance(f,r.renderEnd)-g)*c.renderCoordsHelper.unitInMeters;a.offset=h+v;l=r});return r=>{u.execute(r);return l}}function W(c,a){var {directSegment:b}=c;const {renderCoordsHelper:d}=a;var e=k.directUp(z.sv3d.get(),c,d);c=k.directStartToEnd(z.sv3d.get(),c);e=n.cross(z.sv3d.get(),c,e);({viewForward:a}=a.state.camera);0<n.dot(e,a)&&n.scale(e,
e,-1);b=b.eval(.5,z.sv3d.get());return d.headingAtPosition(b,e)}function X(c,a,b,{forHeading:d}){const {dimension:e,geometry:f}=a;({primaryOffsetAxis:a}=f);a=n.scale(ha,a,0<=e.offset?1:-1);d=T(ia,{forHeading:d,geometry:f,renderCoordsHelper:b});n.cross(d,d,a);d=x.calculateTranslateRotateFromBases(a,d,q.ZEROS,G);c.modelTransform=d;c.renderLocation=S(F,f,f.dimensionSegment,b)}function S(c,a,b,d){const {startRenderSpace:e,endRenderSpace:f}=b;b=k.directStartToEnd(ja,a);a=k.directUp(ka,a,d);a=0<n.dot(b,
a);return n.copy(c,a?e:f)}function T(c,{forHeading:a,geometry:b,renderCoordsHelper:d}){return a?k.directUp(c,b,d):k.dimensionStartToEnd(c,b,{invert:!0})}function M(c){return I.pt2px(c)+t.settings.offsetManipulator.focusedLinePaddingPx}O=function(){function c(b){this.start=b.start;this.end=b.end;this.offset=b.offset;this.heading=b.heading;this.rotation=b.rotation;this.direct=b.direct;this.horizontal=b.horizontal;this.vertical=b.vertical}var a=c.prototype;a.manipulatorName=function(b){return Object.keys(this).find(d=>
this.hasOwnProperty(d)&&b===this[d])};a.values=function(){return[this.start,this.end,this.offset,this.heading,this.rotation,this.direct,this.horizontal,this.vertical]};a.forEachMeasureTypeManipulator=function(b){for(const d of D.lengthDimensionMeasureType)b(this.manipulatorForMeasureType(d),d)};a.manipulatorForMeasureType=function(b){switch(b){case D.LengthDimensionMeasureType.Direct:return this.direct;case D.LengthDimensionMeasureType.Horizontal:return this.horizontal;case D.LengthDimensionMeasureType.Vertical:return this.vertical}};
return c}();const ha=q.create(),ia=q.create(),ja=q.create(),ka=q.create(),A=C.ManipulatorStateCustomFlags.Custom1,F=q.create(),N=q.create(),G=ba.create(),Y=new da.EuclideanSegment;m.DidPointerMoveRecentlyFlag=A;m.LengthDimensionManipulators=O;m.automaticHeadingFromCamera=W;m.createMeasureTypeManipulator=function(c,a){const b=[q.fromValues(-.5,0,0),q.fromValues(.5,0,0)],{lengthFraction:d}=t.settings.offsetManipulator,e=K.createPolylineGeometry(b),f=K.createPolylineGeometry(b.map(h=>n.scale(q.create(),
h,d)));return new P.Manipulator3D({view:c,renderObjects:[{geometry:f,material:a.unfocusedMaterial,stateMask:C.ManipulatorStateFlags.Unfocused|A},{geometry:f,material:a.focusedMaterial,stateMask:C.ManipulatorStateFlags.Focused|A},{geometry:e,material:a.thinOffsetManipulatorMaterial,stateMask:A}],collisionType:{type:"line",paths:[b]},radius:M(a.lineSizePt)/2,available:!1,metadata:a.metadata,...x.worldScaledManipulatorSettings})};m.createOffsetManipulator=function(c,a){const b=[q.fromValues(-.5,0,0),
q.fromValues(.5,0,0)],{lengthFraction:d}=t.settings.offsetManipulator,e=K.createPolylineGeometry(b.map(f=>n.scale(q.create(),f,d)));return new P.Manipulator3D({view:c,renderObjects:[{geometry:e,material:a.unfocusedMaterial,stateMask:C.ManipulatorStateFlags.Unfocused|C.ManipulatorStateFlags.Selected|A},{geometry:e,material:a.focusedMaterial,stateMask:C.ManipulatorStateFlags.Focused|A}],collisionType:{type:"line",paths:[b]},radius:M(a.lineSizePt)/2,metadata:a.metadata,available:!1,...x.worldScaledManipulatorSettings})};
m.createOrientationManipulator=function(c,a){return x.createRotateManipulator(c,Q(a.metadata,a))};m.createPointManipulator=function(c,a){c=x.createSphereManipulator(c,Z.toUnitRGB(t.settings.pointManipulators.color),t.settings.pointManipulators.opacity,A);c.available=!1;c.grabCursor="crosshair";c.radius=t.settings.pointManipulators.radius;c.metadata=a.metadata;c.collisionPriority=1;return c};m.focusedOffsetWidth=M;m.headingManipulatorHandles=function(c,{computation:a,view:b}){return[y.createManipulatorDragEventPipeline(c,
(d,e,f)=>{R({cancel:f,computation:a,settingHeading:!0,steps:e,view:b})})]};m.measureTypeManipulatorHandles=function(c,{computation:a,manipulatorMeasureType:b,view:d}){let e=D.LengthDimensionMeasureType.Direct,f=0,h=0;return[c.events.on("grab-changed",g=>{if("start"===g.action&&k.isValidComputation(a)){var {dimension:l,geometry:u}=a;e=l.measureType;f=l.offset;h=l.orientation;g=n.copy(z.sv3d.get(),c.renderLocation);l.measureType=b;l.offset=k.computeOffsetForPoint(g,b,u,d.renderCoordsHelper);l.orientation=
0}}),y.createManipulatorDragEventPipeline(c,(g,l,u)=>{if(k.isValidComputation(a)){var {geometry:r,dimension:v}=a,{renderCoordsHelper:p}=d,L=k.computeSegmentForMeasureType(Y,b,a,p);p=k.computeOffsetAxis(z.sv3d.get(),{measureType:b,directSegment:r.directSegment,renderCoordsHelper:p});g=B.hideManipulatorWhileDragging(g);l.next(g).next(V(d,v,L,p));u.next(g).next(la=>{v.measureType=e;v.offset=f;v.orientation=h;return la})}})]};m.offsetManipulatorHandles=function(c,{computation:a,view:b}){return[y.createManipulatorDragEventPipeline(c,
(d,e,f)=>{if(k.isValidComputation(a)&&d.selected){var {geometry:h,dimension:g}=a;d=B.hideManipulatorWhileDragging(d);e.next(d).next(V(b,g,h.dimensionSegment,h.primaryOffsetAxis));f.next(d).next(y.resetProperties(g,["offset"]))}})]};m.pointManipulatorHandles=function(c,{isStart:a,createSnappingPipelineStep:b,dimension:d,onUpdate:e,snappingPipeline:f,view:h}){const g=a?"startPoint":"endPoint";return[y.createManipulatorDragEventPipeline(c,(l,u,r,v)=>{l=B.hideManipulatorWhileDragging(l);r=r.next(l).next(y.resetProperties(d,
[g,"measureType","orientation"]));u.next(l).next(B.screenToMap3D(h)).next(b(r,v),f.next).next(p=>{p=ca.clonePoint(p.mapEnd,new fa);e("startPoint"===g?{startPoint:p}:{endPoint:p})})})]};m.rotationManipulatorHandles=function(c,{computation:a,view:b}){return[y.createManipulatorDragEventPipeline(c,(d,e,f)=>{R({cancel:f,computation:a,settingHeading:!1,steps:e,view:b})}),c.events.on("immediate-click",d=>{{const {dimension:g,geometry:l}=a;if(90===g.orientation||270===g.orientation)g.orientation=0,d.stopPropagation();
else if(!E.isNone(l)){var {renderCoordsHelper:e}=b,f=k.computeGeometryFromDimension({...k.computationToGeometryDependencies(a),orientation:90},e),h=k.computeGeometryFromDimension({...k.computationToGeometryDependencies(a),orientation:270},e);E.isNone(f)||E.isNone(h)||(f=k.headingFromGeometry(f,e),e=k.headingFromGeometry(h,e),h=W(l,b),f=H.cyclicalDegrees.shortestSignedDiff(h,f),e=H.cyclicalDegrees.shortestSignedDiff(h,e),g.orientation=Math.abs(f)<Math.abs(e)?90:270,d.stopPropagation())}}})]};m.snapOrientationToNearestRightAngle=
U;m.unfocusedOffsetWidth=function(c){return I.pt2px(c)+t.settings.offsetManipulator.linePaddingPx};m.updateHeadingManipulatorTransform=function(c,a,b){X(c,a,b,{forHeading:!0})};m.updateMeasureTypeManipulatorTransform=function(c,a,b,d){const {geometry:e}=a;a=k.computeSegmentForMeasureType(Y,b,a,d);d=k.computeOffsetAxis(F,{measureType:b,directSegment:e.directSegment,renderCoordsHelper:d});b=n.sub(N,a.endRenderSpace,a.startRenderSpace);d=x.calculateTranslateRotateFromBases(b,d,q.ZEROS,G);b=n.length(b);
J.scale(d,d,n.set(N,b,b,b));c.modelTransform=d;c.renderLocation=a.eval(.5,N)};m.updateOffsetManipulatorTransform=function(c,a,b){const {dimensionSegment:d,primaryOffsetAxis:e}=a,f=k.dimensionStartToEnd(F,a);a=n.exactEquals(f,q.ZEROS)?J.identity(G):x.calculateTranslateRotateFromBases(f,e,q.ZEROS,G);b=Math.max(n.length(f),t.settings.offsetManipulator.minLengthMeters/b.unitInMeters);J.scale(a,a,n.set(F,b,b,b));c.modelTransform=a;c.renderLocation=d.eval(.5,F)};m.updateOrientationManipulator=function(c,
a){x.updateRotateManipulator(c,Q(c.metadata,a))};m.updateRotationManipulatorTransform=function(c,a,b){X(c,a,b,{forHeading:!1})};Object.defineProperties(m,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});