// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("../../../../chunks/_rollupPluginBabelHelpers ../../../../chunks/tslib.es6 ../../../../core/Accessor ../../../../core/Evented ../../../../core/Logger ../../../../core/maybe ../../../../core/accessorSupport/decorators/property ../../../../core/arrayUtils ../../../../core/accessorSupport/ensureType ../../../../core/accessorSupport/decorators/subclass ../../../../chunks/mat4 ../../../../chunks/mat4f64 ../../../../chunks/vec3 ../../../../chunks/vec3f64 ../../../../geometry/support/aaBoundingRect ../../webgl-engine/lib/Intersector ../../webgl-engine/lib/IntersectorInterfaces".split(" "),
function(v,h,c,y,w,q,l,F,G,z,A,B,C,r,m,D,E){const d=m.empty(),k=B.create(),b=r.create(),t=r.create(),u=r.create();c=function(x){function n(a){a=x.call(this,a)||this;a._tmpEvent={spatialReference:null,extent:d,context:"scene"};return a}v._inheritsLoose(n,x);var e=n.prototype;e.initialize=function(){this.view=this.layerView.view;this._renderCoordsHelper=this.view.renderCoordsHelper;this._intersector=D.newIntersector(this.view.state.viewingMode);this._intersector.options.store=E.StoreResults.MIN;const a=
this.layerView.i3slayer.fullExtent;q.isNone(a)?w.getLogger(this.declaredClass).error("I3SElevationProvider expected fullExtent on I3SLayer."):(this._zmin=a.zmin,this._zmax=a.zmax);this._tmpEvent.context=this.intersectionHandler.isGround?"ground":"scene"};e.getElevation=function(a,g,p,f){b[0]=a;b[1]=g;b[2]=p;if(!this._renderCoordsHelper.toRenderCoords(b,f,b))return w.getLogger(this.declaredClass).error("could not project point to compute elevation"),null;a=this.layerView.elevationOffset;g=this._zmin+
a;this._renderCoordsHelper.setAltitude(t,this._zmax+a,b);this._renderCoordsHelper.setAltitude(u,g,b);this._intersector.reset(t,u,null);this.intersectionHandler.intersect(this._intersector,null,t,u);return this._intersector.results.min.getIntersectionPoint(b)?this._renderCoordsHelper.getAltitude(b):null};e.layerChanged=function(){this.spatialReference&&(this._tmpEvent.extent=this._computeLayerExtent(),this._tmpEvent.spatialReference=this.spatialReference,this.emit("elevation-change",this._tmpEvent))};
e.objectChanged=function(a){this.spatialReference&&(this._tmpEvent.extent=this._computeObjectExtent(a),this._tmpEvent.spatialReference=this.spatialReference,this.emit("elevation-change",this._tmpEvent))};e._computeObjectExtent=function(a){m.empty(d);this._expandExtent(a,d);return d};e._computeLayerExtent=function(){m.empty(d);for(const a of this.layerView.getVisibleNodes())this._expandExtent(a,d);return d};e._expandExtent=function(a,g){const p=this.spatialReference;if(!q.isNone(p)&&(a=this.layerView.getNodeComponentObb(a),
!q.isNone(a))){A.fromQuat(k,a.quaternion);k[12]=a.center[0];k[13]=a.center[1];k[14]=a.center[2];for(let f=0;8>f;++f)b[0]=f&1?a.halfSize[0]:-a.halfSize[0],b[1]=f&2?a.halfSize[1]:-a.halfSize[1],b[2]=f&4?a.halfSize[2]:-a.halfSize[2],C.transformMat4(b,b,k),this._renderCoordsHelper.fromRenderCoords(b,b,p),m.expand(g,b,g)}};v._createClass(n,[{key:"spatialReference",get:function(){return this.view?.elevationProvider?.spatialReference}}]);return n}(y.EventedMixin(c));h.__decorate([l.property({constructOnly:!0})],
c.prototype,"layerView",void 0);h.__decorate([l.property({constructOnly:!0})],c.prototype,"intersectionHandler",void 0);h.__decorate([l.property()],c.prototype,"view",void 0);h.__decorate([l.property()],c.prototype,"spatialReference",null);return c=h.__decorate([z.subclass("esri.views.3d.layers.i3s.I3SElevationProvider")],c)});