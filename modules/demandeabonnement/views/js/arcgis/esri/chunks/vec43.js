// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["exports"],function(k){function l(b,e,a){const f=b.typedBuffer;b=b.typedBufferStride;const g=e.typedBuffer,c=e.typedBufferStride;e=a?a.count:e.count;let d=(a&&a.dstIndex?a.dstIndex:0)*b;a=(a&&a.srcIndex?a.srcIndex:0)*c;for(let h=0;h<e;++h)f[d]=g[a],f[d+1]=g[a+1],f[d+2]=g[a+2],f[d+3]=g[a+3],d+=b,a+=c}function m(b,e,a,f,g,c){const d=b.typedBuffer,h=b.typedBufferStride;b=c?.count??b.count;c=(c?.dstIndex??0)*h;for(let n=0;n<b;++n)d[c]=e,d[c+1]=a,d[c+2]=f,d[c+3]=g,c+=h}const p=Object.freeze(Object.defineProperty({__proto__:null,
copy:l,fill:m},Symbol.toStringTag,{value:"Module"}));k.copy=l;k.fill=m;k.vec4=p});