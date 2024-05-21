// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("../../../chunks/_rollupPluginBabelHelpers ../../../chunks/tslib.es6 ../../../Viewpoint ../../../core/Accessor ../../../core/accessorSupport/decorators/property ../../../core/arrayUtils ../../../core/accessorSupport/ensureType ../../../core/accessorSupport/decorators/subclass ../../../geometry/Point ../viewpointUtils ./ZoomBox ./actions/Pan ./actions/Pinch ./actions/Rotate".split(" "),function(n,g,e,A,h,H,I,B,C,m,D,E,F,G){const t=new e({targetGeometry:new C}),u=[0,0];e=function(z){function v(b){b=
z.call(this,b)||this;b._endTimer=null;b.animationManager=null;return b}n._inheritsLoose(v,z);var d=v.prototype;d.initialize=function(){this.pan=new E({navigation:this});this.rotate=new G({navigation:this});this.pinch=new F({navigation:this});this.zoomBox=new D({view:this.view,navigation:this})};d.destroy=function(){this.pan.destroy();this.rotate.destroy();this.pinch.destroy();this.zoomBox.destroy();this.pan=this.rotate=this.pinch=this.zoomBox=this.animationManager=null};d.begin=function(){this._set("interacting",
!0)};d.end=function(){this._lastEventTimestamp=performance.now();this._startTimer(250)};d.zoom=function(){var b=n._asyncToGenerator(function*(a,c=this._getDefaultAnchor()){this.stop();this.begin();if(this.view.constraints.snapToZoom&&this.view.constraints.effectiveLODs)return 1>a?this.zoomIn(c):this.zoomOut(c);this.setViewpoint(c,a,0,[0,0])});return function(a){return b.apply(this,arguments)}}();d.zoomIn=function(){var b=n._asyncToGenerator(function*(a){var c=this.view;c=c.constraints.snapToNextScale(c.scale);
return this._zoomToScale(c,a)});return function(a){return b.apply(this,arguments)}}();d.zoomOut=function(){var b=n._asyncToGenerator(function*(a){var c=this.view;c=c.constraints.snapToPreviousScale(c.scale);return this._zoomToScale(c,a)});return function(a){return b.apply(this,arguments)}}();d.setViewpoint=function(b,a,c,f){this.begin();this.view.state.viewpoint=this._scaleRotateTranslateViewpoint(this.view.viewpoint,b,a,c,f);this.end()};d.setViewpointImmediate=function(b,a=0,c=[0,0],f=this._getDefaultAnchor()){this.view.state.viewpoint=
this._scaleRotateTranslateViewpoint(this.view.viewpoint,f,b,a,c)};d.continousRotateClockwise=function(){const b=this.get("view.viewpoint");this.animationManager.animateContinous(b,a=>{m.rotateBy(a,a,-1)})};d.continousRotateCounterclockwise=function(){const b=this.get("view.viewpoint");this.animationManager.animateContinous(b,a=>{m.rotateBy(a,a,1)})};d.resetRotation=function(){this.view.rotation=0};d.continousPanLeft=function(){this._continuousPan([-10,0])};d.continousPanRight=function(){this._continuousPan([10,
0])};d.continousPanUp=function(){this._continuousPan([0,10])};d.continousPanDown=function(){this._continuousPan([0,-10])};d.stop=function(){this.pan.stopMomentumNavigation();this.animationManager.stop();this.end();null!==this._endTimer&&(clearTimeout(this._endTimer),this._endTimer=null,this._set("interacting",!1))};d._continuousPan=function(b){this.animationManager.animateContinous(this.view.viewpoint,a=>{m.translateBy(a,a,b);this.view.constraints.constrainByGeometry(a)})};d._startTimer=function(b){return null!==
this._endTimer?this._endTimer:this._endTimer=setTimeout(()=>{this._endTimer=null;const a=performance.now()-this._lastEventTimestamp;250>a?this._endTimer=this._startTimer(a):this._set("interacting",!1)},b)};d._getDefaultAnchor=function(){const {size:b,padding:{left:a,right:c,top:f,bottom:k}}=this.view;u[0]=.5*(b[0]-c+a);u[1]=.5*(b[1]-k+f);return u};d._zoomToScale=function(){var b=n._asyncToGenerator(function*(a,c=this._getDefaultAnchor()){const {view:f}=this,{constraints:k,scale:l,viewpoint:w,size:x,
padding:p}=f,y=k.canZoomInTo(a),q=k.canZoomOutTo(a);if(!(a<l&&!y||a>l&&!q))return m.padAndScaleAndRotateBy(t,w,a/l,0,c,x,p),k.constrainByGeometry(t),f.goTo(t,{animate:!0})});return function(a){return b.apply(this,arguments)}}();d._scaleRotateTranslateViewpoint=function(b,a,c,f,k){var {view:l}=this;const {size:w,padding:x,constraints:p,scale:y,viewpoint:q}=l;var r=y*c;l=p.canZoomInTo(r);r=p.canZoomOutTo(r);if(1>c&&!l||1<c&&!r)c=1;m.translateBy(q,q,k);m.padAndScaleAndRotateBy(b,q,c,f,a,w,x);return p.constrainByGeometry(b)};
return v}(A);g.__decorate([h.property()],e.prototype,"animationManager",void 0);g.__decorate([h.property({type:Boolean,readOnly:!0})],e.prototype,"interacting",void 0);g.__decorate([h.property()],e.prototype,"pan",void 0);g.__decorate([h.property()],e.prototype,"pinch",void 0);g.__decorate([h.property()],e.prototype,"rotate",void 0);g.__decorate([h.property()],e.prototype,"view",void 0);g.__decorate([h.property()],e.prototype,"zoomBox",void 0);return e=g.__decorate([B.subclass("esri.views.2d.navigation.MapViewNavigation")],
e)});