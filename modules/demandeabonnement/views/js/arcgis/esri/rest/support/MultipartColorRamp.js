// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("../../chunks/_rollupPluginBabelHelpers ../../chunks/tslib.es6 ../../core/lang ../../core/accessorSupport/decorators/property ../../core/accessorSupport/ensureType ../../core/accessorSupport/decorators/subclass ./AlgorithmicColorRamp ./ColorRamp".split(" "),function(h,c,k,f,a,l,m,n){var d;a=d=function(g){function e(b){b=g.call(this,b)||this;b.colorRamps=null;b.type="multipart";return b}h._inheritsLoose(e,g);e.prototype.clone=function(){return new d({colorRamps:k.clone(this.colorRamps)})};return e}(n);
c.__decorate([f.property({type:[m],json:{write:!0}})],a.prototype,"colorRamps",void 0);c.__decorate([f.property({type:["multipart"]})],a.prototype,"type",void 0);return a=d=c.__decorate([l.subclass("esri.rest.support.MultipartColorRamp")],a)});