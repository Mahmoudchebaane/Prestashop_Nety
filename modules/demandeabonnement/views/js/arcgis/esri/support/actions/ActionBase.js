// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("../../chunks/_rollupPluginBabelHelpers ../../chunks/tslib.es6 ../../core/Accessor ../../core/Identifiable ../../core/accessorSupport/decorators/property ../../core/arrayUtils ../../core/accessorSupport/ensureType ../../core/accessorSupport/decorators/subclass".split(" "),function(h,c,a,k,d,m,n,l){var e;a=e=function(g){function f(b){b=g.call(this,b)||this;b.active=!1;b.className=null;b.disabled=!1;b.id=null;b.indicator=!1;b.title=null;b.type=null;b.visible=!0;return b}h._inheritsLoose(f,g);
f.prototype.clone=function(){return new e({active:this.active,className:this.className,disabled:this.disabled,id:this.id,indicator:this.indicator,title:this.title,visible:this.visible})};return f}(k.IdentifiableMixin(a));c.__decorate([d.property()],a.prototype,"active",void 0);c.__decorate([d.property()],a.prototype,"className",void 0);c.__decorate([d.property()],a.prototype,"disabled",void 0);c.__decorate([d.property()],a.prototype,"id",void 0);c.__decorate([d.property()],a.prototype,"indicator",
void 0);c.__decorate([d.property()],a.prototype,"title",void 0);c.__decorate([d.property()],a.prototype,"type",void 0);c.__decorate([d.property()],a.prototype,"visible",void 0);return a=e=c.__decorate([l.subclass("esri.support.actions.ActionBase")],a)});