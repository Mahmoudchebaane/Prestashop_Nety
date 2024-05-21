// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports","../core/has"],function(a,b){const c=()=>b.cache["enable-feature:direct-3d-object-feature-layer-display"]=!0;a.enableDirect3DObjectFeatureLayerDisplay=()=>!!b("enable-feature:direct-3d-object-feature-layer-display");a.enableSceneLayerEditing=()=>{b.cache["enable-feature:SceneLayer-editing"]=!0;c()};a.enableWebStyleForceWOSR=()=>!!b("enable-feature:force-wosr");a.sceneLayerEditingEnabled=()=>!!b("enable-feature:SceneLayer-editing");a.turnOnDirect3DObjectFeatureLayerDisplay=c;Object.defineProperties(a,
{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});