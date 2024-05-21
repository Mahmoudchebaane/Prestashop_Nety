// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../chunks/_rollupPluginBabelHelpers ../../renderers/ClassBreaksRenderer ../../renderers/DictionaryRenderer ../../renderers/DotDensityRenderer ../../renderers/HeatmapRenderer ../../renderers/PieChartRenderer ../../renderers/Renderer ../../renderers/SimpleRenderer ../../renderers/UniqueValueRenderer ../../renderers/support/jsonUtils ../../core/Error ../../core/maybe ../heuristics/outline ../heuristics/sizeRange ./support/utils ../support/binningUtils ../support/adapters/support/layerUtils ../symbology/location".split(" "),
function(u,m,F,G,H,I,J,K,x,L,M,g,n,y,z,h,A,k,p){function B(b){return q.apply(this,arguments)}function q(){q=m._asyncToGenerator(function*(b){if(!b||!b.layer)throw new g("location-renderer:missing-parameters","'layer' parameter is required");b.forBinning&&A.verifyBinningParams(b,"location-renderer");const a={...b};a.symbolType=a.symbolType||"2d";var c=b.forBinning?k.binningCapableLayerTypes:k.featureCapableLayerTypes;b=k.createLayerAdapter(a.layer,c,b.forBinning);a.layer=b;if(!b)throw new g("location-renderer:invalid-parameters",
"'layer' must be one of these types: "+k.getLayerTypeLabels(c).join(", "));c=n.isSome(a.signal)?{signal:a.signal}:null;yield b.load(c);c=b.geometryType;a.outlineOptimizationEnabled="polygon"===c?a.outlineOptimizationEnabled:!1;a.sizeOptimizationEnabled="point"===c||"multipoint"===c||"polyline"===c?a.sizeOptimizationEnabled:!1;if("mesh"===c)a.symbolType="3d-volumetric",a.colorMixMode=a.colorMixMode||"replace",a.edgesType=a.edgesType||"none";else{if("3d-volumetric-uniform"===a.symbolType&&"point"!==
c)throw new g("location-renderer:not-supported","3d-volumetric-uniform symbols are supported for point layers only");if(a.symbolType.includes("3d-volumetric")&&(!a.view||"3d"!==a.view.type))throw new g("location-renderer:invalid-parameters","'view' parameter should be an instance of SceneView when 'symbolType' parameter is '3d-volumetric' or '3d-volumetric-uniform'");}return a});return q.apply(this,arguments)}function C(b,a){return r.apply(this,arguments)}function r(){r=m._asyncToGenerator(function*(b,
a){let c=b.locationScheme,e=null;var d=null;d=yield h.getBasemapInfo(b.basemap,b.view);e=n.isSome(d.basemapId)?d.basemapId:null;d=n.isSome(d.basemapTheme)?d.basemapTheme:null;if(c)return{scheme:p.cloneScheme(c),basemapId:e,basemapTheme:d};if(b=p.getSchemes({basemap:e,basemapTheme:d,geometryType:a,worldScale:b.symbolType.includes("3d-volumetric"),view:b.view}))c=b.primaryScheme,e=b.basemapId,d=b.basemapTheme;return{scheme:c,basemapId:e,basemapTheme:d}});return r.apply(this,arguments)}function t(){t=
m._asyncToGenerator(function*(b){var a=yield B(b);const c=a.layer.geometryType;b=yield C(a,c);const e=b.scheme;if(!e)throw new g("location-renderer:insufficient-info","Unable to find location scheme");const {view:d,layer:v,signal:w}=a,[f,l]=yield Promise.all([a.outlineOptimizationEnabled?y({view:d,layer:v,signal:w}):null,a.sizeOptimizationEnabled?z({view:d,layer:v,signal:w}):null]),D=f&&f.opacity;a=new x({symbol:h.createSymbol(c,{type:a.symbolType,color:e.color,size:h.getSymbolSizeFromScheme(e,c),
outline:h.getSymbolOutlineFromScheme(e,c,D),meshInfo:{colorMixMode:a.colorMixMode,edgesType:a.edgesType}})});f&&f.visualVariables&&f.visualVariables.length&&(a.visualVariables=f.visualVariables.map(E=>E.clone()));l&&l.minSize&&(a.visualVariables?a.visualVariables.push(l.minSize):a.visualVariables=[l.minSize]);return{renderer:a,locationScheme:p.cloneScheme(e),basemapId:b.basemapId,basemapTheme:b.basemapTheme}});return t.apply(this,arguments)}u.createRenderer=function(b){return t.apply(this,arguments)};
Object.defineProperties(u,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});