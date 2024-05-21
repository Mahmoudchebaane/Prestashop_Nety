// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(k){function l(b,d,a){const g=b.typedBuffer;b=b.typedBufferStride;const c=d.typedBuffer,f=d.typedBufferStride;d=a?a.count:d.count;let e=(a&&a.dstIndex?a.dstIndex:0)*b;a=(a&&a.srcIndex?a.srcIndex:0)*f;for(let h=0;h<d;++h)g[e]=c[a],g[e+1]=c[a+1],g[e+2]=c[a+2],e+=b,a+=f}function m(b,d,a,g,c){const f=b.typedBuffer,e=b.typedBufferStride;b=c?.count??b.count;c=(c?.dstIndex??0)*e;for(let h=0;h<b;++h)f[c]=d,f[c+1]=a,f[c+2]=g,c+=e}const n=Object.freeze(Object.defineProperty({__proto__:null,
copy:l,fill:m},Symbol.toStringTag,{value:"Module"}));k.copy=l;k.fill=m;k.vec3=n});