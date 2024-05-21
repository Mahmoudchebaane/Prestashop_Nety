// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["../chunks/_rollupPluginBabelHelpers","./maybe"],function(d,e){return function(){function c(a,b=30){this.name=a;this._counter=0;this._samples=Array(b)}c.prototype.record=function(a){e.isSome(a)&&(this._samples[++this._counter%this._samples.length]=a)};d._createClass(c,[{key:"median",get:function(){return this._samples.slice().sort((a,b)=>a-b)[Math.floor(this._samples.length/2)]}},{key:"average",get:function(){return this._samples.reduce((a,b)=>a+b,0)/this._samples.length}},{key:"last",get:function(){return this._samples[this._counter%
this._samples.length]}}]);return c}()});