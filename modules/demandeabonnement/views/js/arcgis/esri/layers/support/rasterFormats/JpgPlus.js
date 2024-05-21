// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["../../../chunks/Jpg","../../../chunks/Zlib"],function(q,r){return function(){function n(){}n.decode=function(a,h=!1){const k=new Uint8Array(a);a=new q.JpegImage;a.parse(k);const {width:e,height:f,numComponents:t,eof:p}=a;a=a.getData(e,f,!0);const l=e*f;let m=null,b=0,g=0,d=0;if(!h&&p<k.length-1)try{var c=(new r.Zlib(k.subarray(p))).getBytes();m=new Uint8Array(l);for(b=h=0;b<c.length;b++)for(d=7;0<=d;d--)m[h++]=c[b]>>d&1}catch{}if(1===t&&a.length===e*f)c=[a,a,a];else{c=[];for(b=0;3>b;b++)c.push(new Uint8Array(l));
for(g=d=0;g<l;g++)for(b=0;3>b;b++)c[b][g]=a[d++]}return{width:e,height:f,pixels:c,mask:m}};return n}()});