// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../chunks/_rollupPluginBabelHelpers ../../../chunks/tslib.es6 ../../../core/handleUtils ../../../core/maybe ../../../core/Promise ../../../core/accessorSupport/decorators/property ../../../core/arrayUtils ../../../core/accessorSupport/ensureType ../../../core/accessorSupport/decorators/subclass".split(" "),function(f,g,b,k,l,m,c,p,q,n){f.AnalysisView3D=a=>{a=function(h){function e(){var d=h.apply(this,arguments)||this;d.parent=null;d._userInteractive=!1;d._interactiveViewModelCount=
0;return d}g._inheritsLoose(e,h);e.prototype.forceInteractiveForViewModel=function(){this._interactiveViewModelCount++;return k.makeHandle(()=>this._interactiveViewModelCount--)};g._createClass(e,[{key:"interactive",get:function(){return 0<this._interactiveViewModelCount?!0:this._userInteractive},set:function(d){this._userInteractive=d}},{key:"updating",get:function(){return!1}},{key:"visible",get:function(){return l.isSome(this.parent)?this.parent.visible&&!this.parent.suspended:!0},set:function(d){this._overrideIfSome("visible",
d)}}]);return e}(m.EsriPromiseMixin(a));b.__decorate([c.property({readOnly:!0})],a.prototype,"type",void 0);b.__decorate([c.property({constructOnly:!0})],a.prototype,"analysis",void 0);b.__decorate([c.property({constructOnly:!0})],a.prototype,"parent",void 0);b.__decorate([c.property({constructOnly:!0})],a.prototype,"view",void 0);b.__decorate([c.property({type:Boolean})],a.prototype,"interactive",null);b.__decorate([c.property()],a.prototype,"_userInteractive",void 0);b.__decorate([c.property({readOnly:!0})],
a.prototype,"updating",null);b.__decorate([c.property()],a.prototype,"visible",null);b.__decorate([c.property()],a.prototype,"_interactiveViewModelCount",void 0);return a=b.__decorate([n.subclass("esri.views.3d.analysis.AnalysisView3D")],a)};Object.defineProperties(f,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});