// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../chunks/_rollupPluginBabelHelpers ../../../../geometry/support/aaBoundingRect ./BrushVectorField ./RasterVFTile ../webgl/enums ../webgl/TileContainer".split(" "),function(h,l,m,n,p,k,d){d=function(c){function e(){var a=c.apply(this,arguments)||this;a.isCustomTilingScheme=!1;a.symbolTypes=["triangle"];return a}l._inheritsLoose(e,c);var f=e.prototype;f.createTile=function(a){const b=this._tileInfoView.getTileBounds(m.create(),a),[g,q]=this._tileInfoView.tileInfo.size,r=this._tileInfoView.getTileResolution(a.level);
return new p.RasterVFTile(a,r,b[0],b[3],g,q)};f.prepareRenderPasses=function(a){const b=a.registerRenderPass({name:"imagery (vf tile)",brushes:[n],target:()=>this.children.map(g=>g.tileData),drawPhase:k.WGLDrawPhase.MAP});return[...c.prototype.prepareRenderPasses.call(this,a),b]};f.doRender=function(a){this.visible&&a.drawPhase===k.WGLDrawPhase.MAP&&this.symbolTypes.forEach(b=>{a.renderPass=b;c.prototype.doRender.call(this,a)})};return e}(d);h.RasterVFTileContainer=d;Object.defineProperties(h,{__esModule:{value:!0},
[Symbol.toStringTag]:{value:"Module"}})});