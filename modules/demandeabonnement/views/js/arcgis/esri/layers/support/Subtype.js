// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("../../chunks/_rollupPluginBabelHelpers ../../chunks/tslib.es6 ../../core/JSONSupport ../../core/accessorSupport/decorators/property ../../core/arrayUtils ../../core/accessorSupport/ensureType ../../core/accessorSupport/decorators/reader ../../core/accessorSupport/decorators/subclass ../../core/accessorSupport/decorators/writer ./domains".split(" "),function(m,c,b,e,t,u,n,p,q,r){b=function(k){function g(){var a=k.apply(this,arguments)||this;a.code=null;a.defaultValues={};a.domains=null;a.name=
null;return a}m._inheritsLoose(g,k);var l=g.prototype;l.readDomains=function(a){if(!a)return null;const f={};for(const d of Object.keys(a))f[d]=r.fromJSON(a[d]);return f};l.writeDomains=function(a,f){if(a){var d={};for(const h of Object.keys(a))a[h]&&(d[h]=a[h]?.toJSON());f.domains=d}};return g}(b.JSONSupport);c.__decorate([e.property({type:Number,json:{write:!0}})],b.prototype,"code",void 0);c.__decorate([e.property({type:Object,json:{write:!0}})],b.prototype,"defaultValues",void 0);c.__decorate([e.property({json:{write:!0}})],
b.prototype,"domains",void 0);c.__decorate([n.reader("domains")],b.prototype,"readDomains",null);c.__decorate([q.writer("domains")],b.prototype,"writeDomains",null);c.__decorate([e.property({type:String,json:{write:!0}})],b.prototype,"name",void 0);return b=c.__decorate([p.subclass("esri.layers.support.Subtype")],b)});