// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../core/has ../../core/maybe ./enums ./reservedWordsGLSL3 ./testUtils ../../chunks/builtins".split(" "),function(D,T,L,v,M,E,z){function N(){function f(n){n.length&&t.push({type:O[g],data:n,position:u,line:r,column:B})}function k(){d=d.length?[]:d;if("/"===c&&"*"===a)return u=m+b-1,g=0,c=a,b+1;if("/"===c&&"/"===a)return u=m+b-1,g=1,c=a,b+1;if("#"===a)return g=2,u=m+b,b;if(/\s/.test(a))return g=9,u=m+b,b;F=/\d/.test(a);G=/[^\w_]/.test(a);u=m+b;g=F?4:G?3:9999;return b}function e(){if(("\r"===
a||"\n"===a)&&"\\"!==c)return f(d.join("")),g=999,b;d.push(a);c=a;return b+1}function h(){if("."===c&&/\d/.test(a))return g=5,b;if("/"===c&&"*"===a)return g=0,b;if("/"===c&&"/"===a)return g=1,b;if("."===a&&d.length){for(;l(d););g=5;return b}if(";"===a||")"===a||"("===a){if(d.length)for(;l(d););f(a);g=999;return b+1}var n=2===d.length&&"\x3d"!==a;if(/[\w_\d\s]/.test(a)||n){for(;l(d););g=999;return b}d.push(a);c=a;return b+1}function l(n){var x=0;do{var H=z.operators.indexOf(n.slice(0,n.length+x).join(""));
var A=z.operators[H];if(-1===H){if(0<x--+n.length)continue;A=n.slice(0,1).join("")}f(A);u+=A.length;d=d.slice(A.length);return d.length}while(1)}function p(){if("."===a||/[eE]/.test(a))return d.push(a),g=5,c=a,b+1;if("x"===a&&1===d.length&&"0"===d[0])return g=11,d.push(a),c=a,b+1;if(/[^\d]/.test(a))return f(d.join("")),g=999,b;d.push(a);c=a;return b+1}function q(){"f"===a&&(d.push(a),c=a,b+=1);if(/[eE]/.test(a)||"-"===a&&/[eE]/.test(c))return d.push(a),c=a,b+1;if(/[^\d]/.test(a))return f(d.join("")),
g=999,b;d.push(a);c=a;return b+1}var b=0,m=0,g=999,a,c,d=[],t=[],r=1,B=0,u=0,F=!1,G=!1,w="",I;return function(n){t=[];if(null!==n){n=n.replace?n.replace(/\r\n/g,"\n"):n;b=0;w+=n;for(I=w.length;a=w[b],b<I;){n=b;switch(g){case 0:"/"===a&&"*"===c?(d.push(a),f(d.join("")),g=999):(d.push(a),c=a);b+=1;break;case 1:b=e();break;case 2:b=e();break;case 3:b=h();break;case 4:b=p();break;case 11:/[^a-fA-F0-9]/.test(a)?(f(d.join("")),g=999):(d.push(a),c=a,b+=1);break;case 5:b=q();break;case 9999:if(/[^\d\w_]/.test(a)){var x=
d.join("");g=-1<z.literals.indexOf(x)?8:-1<z.builtins.indexOf(x)?7:6;f(d.join(""));g=999}else d.push(a),c=a,b+=1;break;case 9:/[^\s]/g.test(a)?(f(d.join("")),g=999):(d.push(a),c=a,b+=1);break;case 999:b=k()}if(n!==b)switch(w[n]){case "\n":B=0;++r;break;default:++B}}m+=b;w=w.slice(b);return t}d.length&&f(d.join(""));g=10;f("(eof)");return t}}function P(f){return f.map(k=>"eof"!==k.type?k.data:"").join("")}function Q(f,k="100",e="300 es"){const h=/^\s*#version\s+([0-9]+(\s+[a-zA-Z]+)?)\s*/;for(const l of f)if("preprocessor"===
l.type){const p=h.exec(l.data);if(p){f=p[1].replace(/\s\s+/g," ");if(f===e)return f;if(f===k)return l.data="#version "+e,k;throw Error("unknown glsl version: "+f);}}f.splice(0,0,{type:"preprocessor",data:"#version "+e},{type:"whitespace",data:"\n"});return null}function y(f,k,e,h){h=h||e;for(const l of f)if("ident"===l.type&&l.data===e)return h in k?k[h]++:k[h]=0,y(f,k,h+"_"+k[h],h);return e}function J(f,k,e="afterVersion"){const h={data:"\n",type:"whitespace"},l=q=>q<f.length?/[^\r\n]$/.test(f[q].data):
!1;let p=function(q){let b=-1,m=0,g=-1;for(let c=0;c<q.length;c++){var a=q[c];"preprocessor"===a.type&&(a.data.match(/#(if|ifdef|ifndef)\s+.+/)?++m:a.data.match(/#endif\s*.*/)&&--m);("afterVersion"===e||"afterPrecision"===e)&&"preprocessor"===a.type&&/^#version/.test(a.data)&&(g=Math.max(g,c));if("afterPrecision"===e&&"keyword"===a.type&&"precision"===a.data){a:{for(a=c;a<q.length;a++){const d=q[a];if("operator"===d.type&&";"===d.data)break a}a=null}if(null===a)throw Error("precision statement not followed by any semicolons!");
g=Math.max(g,a)}b<g&&0===m&&(b=c)}return b+1}(f);l(p-1)&&f.splice(p++,0,h);for(const q of k)f.splice(p++,0,q);l(p-1)&&l(p)&&f.splice(p,0,h)}function R(f,k,e,h="lowp"){J(f,[{type:"keyword",data:"out"},{type:"whitespace",data:" "},{type:"keyword",data:h},{type:"whitespace",data:" "},{type:"keyword",data:e},{type:"whitespace",data:" "},{type:"ident",data:k},{type:"operator",data:";"}],"afterPrecision")}function S(f,k,e,h,l="lowp"){J(f,[{type:"keyword",data:"layout"},{type:"operator",data:"("},{type:"keyword",
data:"location"},{type:"whitespace",data:" "},{type:"operator",data:"\x3d"},{type:"whitespace",data:" "},{type:"integer",data:h.toString()},{type:"operator",data:")"},{type:"whitespace",data:" "},{type:"keyword",data:"out"},{type:"whitespace",data:" "},{type:"keyword",data:l},{type:"whitespace",data:" "},{type:"keyword",data:e},{type:"whitespace",data:" "},{type:"ident",data:k},{type:"operator",data:";"}],"afterPrecision")}var O="block-comment line-comment preprocessor operator integer float ident builtin keyword whitespace eof integer".split(" ");
const C=["GL_OES_standard_derivatives","GL_EXT_frag_depth","GL_EXT_draw_buffers","GL_EXT_shader_texture_lod"],K=new Map;D.transpileShader=function(f,k){var e=E.shaderTranspiler.enableCache?K.get(f):null;if(L.isSome(e))return e;e=N();var h=[];h=h.concat(e(f));e=h=h.concat(e(null));if("300 es"===Q(e,"100","300 es"))return f;var l=h=null;const p={},q={};for(let a=0;a<e.length;++a){const c=e[a];switch(c.type){case "keyword":k===v.ShaderType.VERTEX_SHADER&&"attribute"===c.data?c.data="in":"varying"===
c.data&&(c.data=k===v.ShaderType.VERTEX_SHADER?"out":"in");break;case "builtin":/^texture(2D|Cube)(Proj)?(Lod|Grad)?(EXT)?$/.test(c.data.trim())&&(c.data=c.data.replace(/(2D|Cube|EXT)/g,""));k===v.ShaderType.FRAGMENT_SHADER&&"gl_FragColor"===c.data&&(h||(h=y(e,p,"fragColor"),R(e,h,"vec4")),c.data=h);if(k===v.ShaderType.FRAGMENT_SHADER&&"gl_FragData"===c.data){var b=void 0;let d=void 0;var m=e,g=a+1;let t=-1;for(;g<m.length;g++){const r=m[g];if("operator"===r.type&&("["===r.data&&(d=g),"]"===r.data)){b=
g;break}"integer"===r.type&&(t=parseInt(r.data,10))}d&&b&&m.splice(d,b-d+1);m=t;b=y(e,p,"fragData");S(e,b,"vec4",m,"mediump");c.data=b}else k===v.ShaderType.FRAGMENT_SHADER&&"gl_FragDepthEXT"===c.data&&(l||(l=y(e,p,"gl_FragDepth")),c.data=l);break;case "ident":if(M.includes(c.data)){if(m=k===v.ShaderType.VERTEX_SHADER)a:{for(m=a-1;0<=m;m--)if(b=e[m],"whitespace"!==b.type&&"block-comment"!==b.type)if("keyword"===b.type){if("attribute"===b.data||"in"===b.data){m=!0;break a}}else break;m=!1}if(m)throw Error("attribute in vertex shader uses a name that is a reserved word in glsl 300 es");
c.data in q||(q[c.data]=y(e,p,c.data));c.data=q[c.data]}}}for(k=e.length-1;0<=k;--k)h=e[k],"preprocessor"===h.type&&((l=h.data.match(/#extension\s+(.*):/))&&l[1]&&C.includes(l[1].trim())&&(l=e[k+1],e.splice(k,l&&"whitespace"===l.type?2:1)),(l=h.data.match(/#ifdef\s+(.*)/))&&l[1]&&C.includes(l[1].trim())&&(h.data="#if 1"),(l=h.data.match(/#ifndef\s+(.*)/))&&l[1]&&C.includes(l[1].trim())&&(h.data="#if 0"));e=P(e);E.shaderTranspiler.enableCache&&K.set(f,e);return e};Object.defineProperties(D,{__esModule:{value:!0},
[Symbol.toStringTag]:{value:"Module"}})});