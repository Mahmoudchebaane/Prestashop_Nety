// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define(["./chunks/_rollupPluginBabelHelpers","./colorUtils","./core/mathUtils","./core/maybe","./core/accessorSupport/ensureType"],function(q,l,r,m,t){function g(b){return r.clamp(t.ensureInteger(b),0,255)}function h(b,e,a){b=Number(b);return isNaN(b)?a:b<e?e:b>a?a:b}let k=function(){function b(a){this.b=this.g=this.r=255;this.a=1;a&&this.setColor(a)}b.blendColors=function(a,d,c,f=new b){f.r=Math.round(a.r+(d.r-a.r)*c);f.g=Math.round(a.g+(d.g-a.g)*c);f.b=Math.round(a.b+(d.b-a.b)*c);f.a=a.a+(d.a-a.a)*
c;return f._sanitize()};b.fromRgb=function(a,d){var c=a.toLowerCase().match(/^(rgba?|hsla?)\(([\s\.\-,%0-9]+)\)/);if(c){a=c[2].split(/\s*,\s*/);c=c[1];if("rgb"===c&&3===a.length||"rgba"===c&&4===a.length)return c=a[0],"%"===c.charAt(c.length-1)?(c=a.map(f=>2.56*parseFloat(f)),4===a.length&&(c[3]=parseFloat(a[3])),b.fromArray(c,d)):b.fromArray(a.map(f=>parseFloat(f)),d);if("hsl"===c&&3===a.length||"hsla"===c&&4===a.length)return b.fromArray(l.hsla2rgba(parseFloat(a[0]),parseFloat(a[1])/100,parseFloat(a[2])/
100,parseFloat(a[3])),d)}return null};b.fromHex=function(a,d=new b){if(4!==a.length&&7!==a.length||"#"!==a[0])return null;const c=4===a.length?4:8,f=(1<<c)-1;let n=Number("0x"+a.substr(1));if(isNaN(n))return null;["b","g","r"].forEach(u=>{const p=n&f;n>>=c;d[u]=4===c?17*p:p});d.a=1;return d};b.fromArray=function(a,d=new b){d._set(Number(a[0]),Number(a[1]),Number(a[2]),Number(a[3]));isNaN(d.a)&&(d.a=1);return d._sanitize()};b.fromString=function(a,d){const c=l.isNamedColor(a)?l.getNamedColor(a):null;
return c&&b.fromArray(c,d)||b.fromRgb(a,d)||b.fromHex(a,d)};b.fromJSON=function(a){return a&&new b([a[0],a[1],a[2],a[3]/255])};b.toUnitRGB=function(a){return m.isSome(a)?[a.r/255,a.g/255,a.b/255]:null};b.toUnitRGBA=function(a){return m.isSome(a)?[a.r/255,a.g/255,a.b/255,null!=a.a?a.a:1]:null};var e=b.prototype;e.setColor=function(a){"string"===typeof a?b.fromString(a,this):Array.isArray(a)?b.fromArray(a,this):(this._set(a.r??0,a.g??0,a.b??0,a.a??1),a instanceof b||this._sanitize());return this};e.toRgb=
function(){return[this.r,this.g,this.b]};e.toRgba=function(){return[this.r,this.g,this.b,this.a]};e.toHex=function(){const a=this.r.toString(16),d=this.g.toString(16),c=this.b.toString(16);return`#${2>a.length?"0"+a:a}${2>d.length?"0"+d:d}${2>c.length?"0"+c:c}`};e.toCss=function(a=!1){const d=this.r+", "+this.g+", "+this.b;return a?`rgba(${d}, ${this.a})`:`rgb(${d})`};e.toString=function(){return this.toCss(!0)};e.toJSON=function(){return this.toArray()};e.toArray=function(a=b.AlphaMode.ALWAYS){const d=
g(this.r),c=g(this.g),f=g(this.b);return a===b.AlphaMode.ALWAYS||1!==this.a?[d,c,f,g(255*this.a)]:[d,c,f]};e.clone=function(){return new b(this.toRgba())};e.hash=function(){return this.r<<24|this.g<<16|this.b<<8|255*this.a};e.equals=function(a){return m.isSome(a)&&a.r===this.r&&a.g===this.g&&a.b===this.b&&a.a===this.a};e._sanitize=function(){this.r=Math.round(h(this.r,0,255));this.g=Math.round(h(this.g,0,255));this.b=Math.round(h(this.b,0,255));this.a=h(this.a,0,1);return this};e._set=function(a,
d,c,f){this.r=a;this.g=d;this.b=c;this.a=f};q._createClass(b,[{key:"isBright",get:function(){return 127<=.299*this.r+.587*this.g+.114*this.b}}]);return b}();k.prototype.declaredClass="esri.Color";(function(b){b=b.AlphaMode||(b.AlphaMode={});b[b.ALWAYS=0]="ALWAYS";b[b.UNLESS_OPAQUE=1]="UNLESS_OPAQUE"})(k||(k={}));return k});