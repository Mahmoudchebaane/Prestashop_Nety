// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["../../../chunks/_rollupPluginBabelHelpers","../webgl-engine/lib/Camera"],function(c,d){return function(){function a(e){this.view=e;this.camera=new d.Camera;this._renderTargetHelper=null}var b=a.prototype;b.resetWebGLState=function(){null!=this.rctx&&(this.rctx.enforceState(),this._renderTargetHelper&&this._renderTargetHelper.bindFramebuffer())};b.bindRenderTarget=function(){this._renderTargetHelper&&this._renderTargetHelper.framebuffer.initializeAndBind()};c._createClass(a,[{key:"gl",get:function(){return this.rctx.gl}}]);
return a}()});