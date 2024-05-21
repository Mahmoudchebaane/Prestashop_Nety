// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("../../../../../../chunks/_rollupPluginBabelHelpers ../../../../../../core/BidiText ../../../../../../core/screenUtils ../../../../../../symbols/cim/enums ../../alignmentUtils ../../color ../../definitions ../../number ../../materialKey/MaterialKey ./util ./WGLBaseTextTemplate ./WGLMeshTemplate".split(" "),function(w,r,f,t,m,h,n,x,y,p,z,A){return function(u){function g(a,e,c,d,k,q,l,v,B,C,D,E,F,G,H,I,J,K,L=!1,M,N){var b=u.call(this)||this;b._xOffset=f.pt2px(F);b._yOffset=f.pt2px(G);b._decoration=
C||"none";b._color=k;b._haloColor=q;b._haloSize=Math.min(Math.floor(5*f.pt2px(f.toPt(c))),127);b._size=Math.min(Math.round(f.pt2px(e)),127);e=Math.min(Math.round(f.pt2px(d||e)),127);b._referenceSize=Math.round(Math.sqrt(256*e));b._scale=b._size/n.GLYPH_SIZE;b._angle=E;b._justify=m.getJustification(l||"center");b._xAlignD=m.getXAnchorDirection(l||"center");b._yAlignD=m.getYAnchorDirection(v||"baseline");b._baseline="baseline"===(v||"baseline");b._bitset=(B===t.Alignment.MAP?1:0)|(D?1:0)<<1;a=y.MaterialKeyBase.load(a);
a.sdf=!0;b._materialKey=a.data;b._lineWidth=f.pt2px(H)||512;b._lineHeight=I||1;b._textPlacement=J;b._effects=K;b._isCIM=L;b._minMaxZoom=x.i1616to32(Math.round(M*n.MIN_MAX_ZOOM_PRECISION_FACTOR),Math.round(N*n.MIN_MAX_ZOOM_PRECISION_FACTOR));return b}w._inheritsLoose(g,u);g.fromText=function(a,e){const c=new g(a.materialKey,a.font.size,a.haloSize||0,a.font.size,a.color&&h.premultiplyAlphaRGBAArray(a.color)||0,a.haloColor&&h.premultiplyAlphaRGBAArray(a.haloColor)||0,a.horizontalAlignment,a.verticalAlignment,
t.Alignment.SCREEN,a.font.decoration,!1,a.angle||0,a.xoffset,a.yoffset,a.lineWidth,a.lineHeight,null,null,!1,p.DEFAULT_MIN_ZOOM,p.DEFAULT_MAX_ZOOM),[,d]=r.bidiText(a.text);c.bindTextInfo(e,d);c._vertexBoundsScale=a.maxVVSize?a.maxVVSize/a.font.size:1;return c};g.fromCIMText=function(a,e,c){var d=a.scaleFactor||1;const k=a.size*a.sizeRatio*d,[q,l]=p.getMinMaxZoom(a.scaleInfo,c);c=new g(a.materialKey,k,a.outlineSize*a.sizeRatio,a.referenceSize,h.premultiplyAlphaRGBA(a.color),h.premultiplyAlphaRGBA(a.outlineColor),
a.horizontalAlignment,a.verticalAlignment,a.alignment,a.decoration,a.colorLocked,a.angle,a.offsetX*a.sizeRatio*d,a.offsetY*a.sizeRatio*d,512,1,a.markerPlacement,a.effects,!0,q,l);[,d]=r.bidiText(a.text);c.bindTextInfo(e,d);c._vertexBoundsScale=a.maxVVSize?a.maxVVSize/k:1;return c};return g}(z(A))});