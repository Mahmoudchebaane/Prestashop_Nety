// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(function(){return function(){function d(){this.name=this.constructor.name||"UnnamedBrush";this.brushEffect=null}var a=d.prototype;a.prepareState=function(b,c){};a.draw=function(b,c,e){};a.drawMany=function(b,c,e){for(const f of c)f.visible&&this.draw(b,f,e)};return d}()});