// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(b){b.isEditableLayer=function(a){return!(a&&a.loaded&&"capabilities"in a&&a?.capabilities?.operations&&"supportsEditing"in a.capabilities.operations)||!0!==a.capabilities.operations.supportsEditing||"editingEnabled"in a&&!a.editingEnabled?!1:!0};Object.defineProperties(b,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});