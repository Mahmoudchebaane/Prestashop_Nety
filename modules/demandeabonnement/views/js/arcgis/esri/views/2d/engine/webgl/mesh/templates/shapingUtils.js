// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../../../../../chunks/_rollupPluginBabelHelpers ../../../../../../chunks/mat2d ../../../../../../chunks/mat2df32 ../../../../../../chunks/vec2 ../../../../../../chunks/vec2f32 ../../alignmentUtils ../../number ../../Rect ../../collisions/BoundingBox".split(" "),function(A,F,q,w,z,G,K,u,L,B){const M=Math.PI/180;let E=function(){function m(a,c,b,d){this._rotationT=w.create();this.minZoom=this._yBounds=this._xBounds=0;this.maxZoom=255;this._bounds=null;const f=b.rect,e=new Float32Array(8);
a*=d;c*=d;const l=b.code?f.width*d:b.metrics.width,g=b.code?f.height*d:b.metrics.height;e[0]=a;e[1]=c;e[2]=a+l;e[3]=c;e[4]=a;e[5]=c+g;e[6]=a+l;e[7]=c+g;this._data=e;this._setTextureCoords(f);this._scale=d;this._mosaic=b;this.x=a;this.y=c;this.maxOffset=Math.max(a+l,c+g)}var h=m.prototype;h.setTransform=function(a){this._transform=a;this._offsets=null};h._setOffsets=function(a){this._offsets||(this._offsets={upperLeft:0,upperRight:0,lowerLeft:0,lowerRight:0});const c=this._offsets,b=new Float32Array(8),
d=q.multiply(w.create(),this._rotationT,this._transform);w.transformMany(b,a,d);c.upperLeft=u.i1616to32(8*b[0],8*b[1]);c.upperRight=u.i1616to32(8*b[2],8*b[3]);c.lowerLeft=u.i1616to32(8*b[4],8*b[5]);c.lowerRight=u.i1616to32(8*b[6],8*b[7])};h._setTextureCoords=function({x:a,y:c,width:b,height:d}){this._texcoords={upperLeft:u.i1616to32(a,c),upperRight:u.i1616to32(a+b,c),lowerLeft:u.i1616to32(a,c+d),lowerRight:u.i1616to32(a+b,c+d)}};F._createClass(m,[{key:"width",get:function(){return this._mosaic.metrics.width*
this._scale}},{key:"mosaic",get:function(){return this._mosaic}},{key:"angle",get:function(){return this._angle},set:function(a){this._angle=a;q.fromRotation(this._rotationT,-a);this._setOffsets(this._data)}},{key:"xTopLeft",get:function(){return this._data[0]}},{key:"yTopLeft",get:function(){return this._data[1]}},{key:"xBottomRight",get:function(){return this._data[6]}},{key:"yBottomRight",get:function(){return this._data[7]}},{key:"texcoords",get:function(){return this._texcoords}},{key:"textureBinding",
get:function(){return this._mosaic.textureBinding}},{key:"offsets",get:function(){this._offsets||this._setOffsets(this._data);return this._offsets}},{key:"char",get:function(){return String.fromCharCode(this._mosaic.code)}},{key:"code",get:function(){return this._mosaic.code}},{key:"bounds",get:function(){if(!this._bounds){const {height:f,width:e}=this._mosaic.metrics;var a=e*this._scale,c=Math.abs(f)*this._scale,b=new Float32Array(8);b[0]=this.x;b[1]=this.y;b[2]=this.x+a;b[3]=this.y;b[4]=this.x;
b[5]=this.y+c;b[6]=this.x+a;b[7]=this.y+c;a=q.multiply(w.create(),this._rotationT,this._transform);w.transformMany(b,b,a);c=a=Infinity;let l=0;var d=0;for(let g=0;4>g;g++){const k=b[2*g],n=b[2*g+1];a=Math.min(a,k);c=Math.min(c,n);l=Math.max(l,k);d=Math.max(d,n)}b=l-a;d-=c;this._bounds=new B(a+b/2,c+d/2,b,d)}return this._bounds}}]);return m}(),H=function(){function m(a,c,b){this._rotation=0;this._decorate(a,c,b);this.glyphs=a;this.bounds=this._createBounds(a);this.isMultiline=1<c.length;this._hasRotation=
0!==b.angle;this._transform=this._createGlyphTransform(this.bounds,b);for(const d of a)d.setTransform(this._transform)}var h=m.prototype;h.setRotation=function(a){if(0!==a||0!==this._rotation){this._rotation=a;var c=this._transform;a=q.fromRotation(w.create(),a);q.multiply(c,a,c);for(const b of this.glyphs)b.setTransform(this._transform)}};h._decorate=function(a,c,b){if(b.decoration&&"none"!==b.decoration&&a.length){var d=b.scale;b="underline"===b.decoration?30:20;var f=a[0].textureBinding;for(const k of c){const n=
k.startX*d,p=k.startY*d;c=a;var e=c.push;var l=(k.width+k.glyphWidthEnd)*d;var g=f;l={code:0,page:0,sdf:!0,rect:new L(0,0,11,8),textureBinding:g,metrics:{advance:0,height:4,width:l,left:0,top:0}};e.call(c,new E(n,p+b*d,l,1))}}};h._createBounds=function(a){let c=Infinity,b=Infinity,d=0;var f=0;for(const e of a)c=Math.min(c,e.xTopLeft),b=Math.min(b,e.yTopLeft),d=Math.max(d,e.xTopLeft+e.width),f=Math.max(f,e.yBottomRight);a=d-c;f-=b;return new B(c+a/2,b+f/2,a,f)};h._createGlyphTransform=function(a,c){const b=
M*c.angle,d=w.create(),f=G.create();q.translate(d,d,z.set(f,c.xOffset,-c.yOffset));c.isCIM?q.rotate(d,d,b):(q.translate(d,d,z.set(f,a.x,a.y)),q.rotate(d,d,b),q.translate(d,d,z.set(f,-a.x,-a.y)));return d};F._createClass(m,[{key:"boundsT",get:function(){var a=this.bounds;const c=z.set(G.create(),a.x,a.y);z.transformMat2d(c,c,this._transform);return this._hasRotation?(a=Math.max(a.width,a.height),new B(c[0],c[1],a,a)):new B(c[0],c[1],a.width,a.height)}}]);return m}(),C=function(m,h,a,c,b,d){this.startY=
this.startX=this.glyphWidthEnd=0;this.start=Math.max(0,Math.min(h,a));this.end=Math.max(0,Math.max(h,a));this.end<m.length&&(this.glyphWidthEnd=m[this.end].metrics.width);this.width=c;this.yMin=b;this.yMax=d};A.ShapedGlyph=E;A.ShapingInfo=H;A.shapeGlyphs=function(m,h,a){const c=a.scale,b=[],d=[];var f=1/a.scale*a.maxLineWidth;var e=h?m.length-1:0,l=h?-1:m.length;h=h?-1:1;var g=e,k=0,n=0;let p=g,x=p,I=0,r=Infinity,t=0;for(;g!==l;){const {code:y,metrics:v}=m[g];var D=Math.abs(v.top);10!==y&&32!==y&&
(r=Math.min(r,D),t=Math.max(t,D+v.height));10===y?(g!==e&&(d.push(new C(m,p,g-h,k,r,t)),r=Infinity,t=0),k=0,p=g+h,x=g+h,n=0):32===y?(x=g+h,n=0,I=v.advance,k+=v.advance):(k>f&&(x!==p?(D=x-2*h,k-=I,d.push(new C(m,p,D,k-n,r,t)),r=Infinity,t=0,p=x,k=n):(d.push(new C(m,p,g-h,k,r,t)),r=Infinity,t=0,x=p=g,k=0)),k+=v.advance,n+=v.advance);g+=h}f=new C(m,p,g-h,k,r,t);0<=f.start&&f.end<m.length&&d.push(f);for(f=0;f<d.length;f++);e=d[0].yMin;f=d[d.length-1].yMax+a.lineHeight*(d.length-1)+("underline"===a.decoration?
4:0)-e;const {vAlign:J,hAlign:N}=a;l=J===K.VAlign.Baseline?1:0;f=(1-l)*-e+f/2*(l?0:J-1)+-26*(l?1:0);for(e=0;e<d.length;e++){const {start:y,end:v,width:O}=d[e];l=O/2*(N+1)*-1-3;h=e*a.lineHeight+f-3;d[e].startX=l;d[e].startY=h;for(g=y;g<=v;g++)k=m[g],10!==k.code&&(n=new E(l+k.metrics.left,h-k.metrics.top,k,c),l+=k.metrics.advance,b.push(n))}return new H(b,d,a)};Object.defineProperties(A,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});