// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["require","exports","../../chunks/_rollupPluginBabelHelpers","../../config","../../core/Logger"],function(f,e,g,h,k){function d(){d=g._asyncToGenerator(function*(a){a="portalItem"in a?a:{portalItem:a};var b=yield new Promise((c,l)=>f(["../../portal/support/portalLayers"],c,l));try{return yield b.fromItem(a)}catch(c){throw a=(b=a&&a.portalItem)&&b.id||"unset",b=b&&b.portal&&b.portal.url||h.portalUrl,k.getLogger("esri.layers.support.fromPortalItem").error("#fromPortalItem()","Failed to create layer from portal item (portal: '"+
b+"', id: '"+a+"')",c),c;}});return d.apply(this,arguments)}e.fromPortalItem=function(a){return d.apply(this,arguments)};Object.defineProperties(e,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});