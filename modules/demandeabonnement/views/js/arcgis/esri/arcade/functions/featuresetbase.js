// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.25/esri/copyright.txt for details.
//>>built
define("exports ../../chunks/_rollupPluginBabelHelpers ../ArcadePortal ../Dictionary ../executionError ../Feature ../featureSetCollection ../featureSetUtils ../ImmutableArray ../../chunks/languageUtils ../featureset/actions/Adapted ../featureset/actions/AttributeFilter ../featureset/actions/OrderBy ../featureset/actions/Top ../featureset/sources/Empty ../featureset/sources/FeatureLayerMemory ../featureset/support/OrderbyClause ../featureset/support/shared ../featureset/support/sqlUtils ./fieldStats ../../core/promiseUtils ../../core/sql/WhereClause ../../layers/FeatureLayer ../../layers/support/Field".split(" "),
function(Q,z,I,A,p,V,R,y,W,f,u,X,Y,Z,aa,ba,ca,J,S,K,da,w,L,E){function M(l,b,e){return N.apply(this,arguments)}function N(){N=z._asyncToGenerator(function*(l,b,e){const k=l.getVariables();if(0<k.length){const d=[];for(let c=0;c<k.length;c++)d.push(yield b.evaluateIdentifier(e,{name:k[c]}));b={};for(e=0;e<k.length;e++)b[k[e]]=d[e];l.parameters=b}return l});return N.apply(this,arguments)}function r(l,b,e=null){for(const k in l)if(k.toLowerCase()===b.toLowerCase())return l[k];return e}function T(l){if(null===
l)return null;const b={type:r(l,"type",""),name:r(l,"name","")};if("range"===b.type)b.range=r(l,"range",[]);else{b.codedValues=[];for(const e of r(l,"codedValues",[]))b.codedValues.push({name:r(e,"name",""),code:r(e,"code",null)})}return b}function O(l){if(null===l)return null;const b={},e=r(l,"wkt",null);null!==e&&(b.wkt=e);l=r(l,"wkid",null);null!==l&&(b.wkid=l);return b}function U(l){if(null===l)return null;const b={hasZ:r(l,"hasz",!1),hasM:r(l,"hasm",!1)};var e=r(l,"spatialreference",null);e&&
(b.spatialReference=O(e));e=r(l,"x",null);if(null!==e)return b.x=e,b.y=r(l,"y",null),b;e=r(l,"rings",null);if(null!==e)return b.rings=e,b;e=r(l,"paths",null);if(null!==e)return b.paths=e,b;e=r(l,"points",null);if(null!==e)return b.points=e,b;for(const k of"xmin xmax ymin ymax zmin zmax mmin mmax".split(" "))e=r(l,k,null),null!==e&&(b[k]=e);return b}Q.registerFunctions=function(l){"async"===l.mode&&(l.functions.getuser=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,
c,a){f.pcCheck(a,0,2,b,e);d=f.defaultUndefined(a[1],"");c=!0===d;d=!0===d||!1===d?"":f.toString(d);if(0===a.length||a[0]instanceof I){var m=null;b.services&&b.services.portal&&(m=b.services.portal);0<a.length&&(m=y.getPortal(a[0],m));if(m=yield y.lookupUser(m,d,c)){m=JSON.parse(JSON.stringify(m));for(var g of["lastLogin","created","modified"])void 0!==m[g]&&null!==m[g]&&(m[g]=new Date(m[g]));return A.convertObjectToArcadeDictionary(m)}return null}g=null;f.isFeatureSet(a[0])&&(g=a[0]);if(g){c=!1;if(d)return null;
yield g.load();a=yield g.getOwningSystemUrl();if(!a)return!d&&(m=yield g.getIdentityUser())?A.convertObjectToArcadeDictionary({username:m}):null;g=null;b.services&&b.services.portal&&(g=b.services.portal);g=y.getPortal(new I(a),g);if(g=yield y.lookupUser(g,d,c)){g=JSON.parse(JSON.stringify(g));for(m of["lastLogin","created","modified"])void 0!==g[m]&&null!==g[m]&&(g[m]=new Date(g[m]));return A.convertObjectToArcadeDictionary(g)}return null}throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,
e);});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"getuser",min:1,max:2}),l.functions.featuresetbyid=function(b,e){return l.standardFunctionAsync(b,e,(k,d,c)=>{f.pcCheck(c,2,4,b,e);if(c[0]instanceof R){k=f.toString(c[1]);d=f.defaultUndefined(c[2],null);const a=f.toBoolean(f.defaultUndefined(c[3],!0));null===d&&(d=["*"]);if(!1===f.isArray(d))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);return c[0].featureSetById(k,a,d)}throw new p.ArcadeExecutionError(b,
p.ExecutionErrorCodes.InvalidParameter,e);})},l.signatures.push({name:"featuresetbyid",min:2,max:4}),l.functions.getfeatureset=function(b,e){return l.standardFunctionAsync(b,e,(k,d,c)=>{f.pcCheck(c,1,2,b,e);if(f.isFeature(c[0]))return k=f.defaultUndefined(c[1],"datasource"),null===k&&(k="datasource"),k=f.toString(k).toLowerCase(),y.convertToFeatureSet(c[0].fullSchema(),k,b.lrucache,b.interceptor,b.spatialReference);throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);})},l.signatures.push({name:"getfeatureset",
min:1,max:2}),l.functions.featuresetbyportalitem=function(b,e){return l.standardFunctionAsync(b,e,(k,d,c)=>{f.pcCheck(c,2,5,b,e);if(null===c[0])throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.PortalRequired,e);if(c[0]instanceof I){k=f.toString(c[1]);d=f.toString(c[2]);var a=f.defaultUndefined(c[3],null);const m=f.toBoolean(f.defaultUndefined(c[4],!0));null===a&&(a=["*"]);if(!1===f.isArray(a))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);let g=null;b.services&&
b.services.portal&&(g=b.services.portal);g=y.getPortal(c[0],g);return y.constructFeatureSetFromPortalItem(k,d,b.spatialReference,a,m,g,b.lrucache,b.interceptor)}if(!1===f.isString(c[0]))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.PortalRequired,e);k=f.toString(c[0]);d=f.toString(c[1]);a=f.defaultUndefined(c[2],null);c=f.toBoolean(f.defaultUndefined(c[3],!0));null===a&&(a=["*"]);if(!1===f.isArray(a))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);if(b.services&&
b.services.portal)return y.constructFeatureSetFromPortalItem(k,d,b.spatialReference,a,c,b.services.portal,b.lrucache,b.interceptor);throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.PortalRequired,e);})},l.signatures.push({name:"featuresetbyportalitem",min:2,max:5}),l.functions.featuresetbyname=function(b,e){return l.standardFunctionAsync(b,e,(k,d,c)=>{f.pcCheck(c,2,4,b,e);if(c[0]instanceof R){k=f.toString(c[1]);d=f.defaultUndefined(c[2],null);const a=f.toBoolean(f.defaultUndefined(c[3],!0));
null===d&&(d=["*"]);if(!1===f.isArray(d))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);return c[0].featureSetByName(k,a,d)}throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);})},l.signatures.push({name:"featuresetbyname",min:2,max:4}),l.functions.featureset=function(b,e){return l.standardFunction(b,e,(k,d,c)=>{f.pcCheck(c,1,1,b,e);d=c[0];k={layerDefinition:{geometryType:"",objectIdField:"",globalIdField:"",typeIdField:"",fields:[]},featureSet:{geometryType:"",
features:[]}};if(f.isString(d))d=JSON.parse(d),void 0!==d.layerDefinition?(k.layerDefinition=d.layerDefinition,k.featureSet=d.featureSet,d.layerDefinition.spatialReference&&(k.layerDefinition.spatialReference=d.layerDefinition.spatialReference)):(k.featureSet.features=d.features,k.featureSet.geometryType=d.geometryType,k.layerDefinition.geometryType=k.featureSet.geometryType,k.layerDefinition.objectIdField=d.objectIdFieldName,k.layerDefinition.typeIdField=d.typeIdFieldName,k.layerDefinition.globalIdField=
d.globalIdFieldName,k.layerDefinition.fields=d.fields,d.spatialReference&&(k.layerDefinition.spatialReference=d.spatialReference));else if(c[0]instanceof A)if(d=JSON.parse(c[0].castToText(!0)),c=r(d,"layerdefinition"),null!==c){k.layerDefinition.geometryType=r(c,"geometrytype","");k.featureSet.geometryType=k.layerDefinition.geometryType;k.layerDefinition.globalIdField=r(c,"globalidfield","");k.layerDefinition.objectIdField=r(c,"objectidfield","");k.layerDefinition.typeIdField=r(c,"typeidfield","");
var a=r(c,"spatialreference",null);a&&(k.layerDefinition.spatialReference=O(a));for(const q of r(c,"fields",[]))a={name:r(q,"name",""),alias:r(q,"alias",""),type:r(q,"type",""),nullable:r(q,"nullable",!0),editable:r(q,"editable",!0),length:r(q,"length",null),domain:T(r(q,"domain"))},k.layerDefinition.fields.push(a);var m=r(d,"featureset",null);if(m){a={};for(var g of k.layerDefinition.fields)a[g.name.toLowerCase()]=g.name;for(var h of r(m,"features",[])){m={};g=r(h,"attributes",{});for(var n in g)m[a[n.toLowerCase()]]=
g[n];k.featureSet.features.push({attributes:m,geometry:U(r(h,"geometry",null))})}}}else{k.layerDefinition.geometryType=r(d,"geometrytype","");k.featureSet.geometryType=k.layerDefinition.geometryType;k.layerDefinition.objectIdField=r(d,"objectidfieldname","");k.layerDefinition.typeIdField=r(d,"typeidfieldname","");if(h=r(d,"spatialreference",null))k.layerDefinition.spatialReference=O(h);for(const q of r(d,"fields",[]))h={name:r(q,"name",""),alias:r(q,"alias",""),type:r(q,"type",""),nullable:r(q,"nullable",
!0),editable:r(q,"editable",!0),length:r(q,"length",null),domain:T(r(q,"domain"))},k.layerDefinition.fields.push(h);h={};for(const q of k.layerDefinition.fields)h[q.name.toLowerCase()]=q.name;for(a of r(d,"features",[])){n={};g=r(a,"attributes",{});for(m in g)n[h[m.toLowerCase()]]=g[m];k.featureSet.features.push({attributes:n,geometry:U(r(a,"geometry",null))})}}else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);if(k.layerDefinition&&k.featureSet){b:{h=" esriGeometryPoint esriGeometryPolyline esriGeometryPolygon esriGeometryMultipoint esriGeometryEnvelope".split(" ");
for(t of h)if(t===k.layerDefinition.geometryType){var t=!0;break b}t=!1}t=!1===t||null===k.layerDefinition.objectIdField||""===k.layerDefinition.objectIdField||!1===f.isArray(k.layerDefinition.fields)||!1===f.isArray(k.featureSet.features)?!1:!0}else t=!1;if(!1===t)throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);return ba.create(k,b.spatialReference)})},l.signatures.push({name:"featureset",min:1,max:1}),l.functions.filter=function(b,e){return l.standardFunctionAsync(b,
e,function(){var k=z._asyncToGenerator(function*(d,c,a){f.pcCheck(a,2,2,b,e);if(f.isArray(a[0])||f.isImmutableArray(a[0])){d=[];var m=a[0];m instanceof W&&(m=m.toArray());c=null;if(f.isFunctionParameter(a[1]))c=a[1].createFunction(b);else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);for(var g of m)a=c(g),da.isPromiseLike(a)?!0===(yield a)&&d.push(g):!0===a&&d.push(g);return d}if(f.isFeatureSet(a[0])){g=yield a[0].load();g=w.WhereClause.create(a[1],g.getFieldsIndex());
d=g.getVariables();if(0<d.length){c=[];for(m=0;m<d.length;m++)c.push(yield l.evaluateIdentifier(b,{name:d[m]}));m={};for(let h=0;h<d.length;h++)m[d[h]]=c[h];g.parameters=m}return new X({parentfeatureset:a[0],whereclause:g})}throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"filter",min:2,max:2}),l.functions.orderby=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,
c,a){f.pcCheck(a,2,2,b,e);if(f.isFeatureSet(a[0]))return d=new ca(a[1]),new Y({parentfeatureset:a[0],orderbyclause:d});throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"orderby",min:2,max:2}),l.functions.top=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,c,a){f.pcCheck(a,2,2,b,e);if(f.isFeatureSet(a[0]))return new Z({parentfeatureset:a[0],
topnum:a[1]});if(f.isArray(a[0]))return f.toNumber(a[1])>=a[0].length?a[0].slice(0):a[0].slice(0,f.toNumber(a[1]));if(f.isImmutableArray(a[0]))return f.toNumber(a[1])>=a[0].length()?a[0].slice(0):a[0].slice(0,f.toNumber(a[1]));throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"top",min:2,max:2}),l.functions.first=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,
c,a){f.pcCheck(a,1,1,b,e);return f.isFeatureSet(a[0])?(d=yield a[0].first(d.abortSignal),null!==d?(a=V.createFromGraphicLikeObject(d.geometry,d.attributes,a[0]),a._underlyingGraphic=d,a):d):f.isArray(a[0])?0===a[0].length?null:a[0][0]:f.isImmutableArray(a[0])?0===a[0].length()?null:a[0].get(0):null});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"first",min:1,max:1}),l.functions.attachments=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,
c,a){f.pcCheck(a,1,2,b,e);c=d=-1;var m=null,g=!1;if(1<a.length)if(a[1]instanceof A){if(a[1].hasField("minsize")&&(d=f.toNumber(a[1].field("minsize"))),a[1].hasField("metadata")&&(g=f.toBoolean(a[1].field("metadata"))),a[1].hasField("maxsize")&&(c=f.toNumber(a[1].field("maxsize"))),a[1].hasField("types")){var h=f.toStringArray(a[1].field("types"),!1);0<h.length&&(m=h)}}else if(null!==a[1])throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);if(f.isFeature(a[0])){h=a[0]._layer;
h instanceof L&&(h=y.constructFeatureSet(h,b.spatialReference,["*"],!0,b.lrucache,b.interceptor));if(null===h||!1===f.isFeatureSet(h))return[];yield h.load();return h.queryAttachments(a[0].field(h.objectIdField),d,c,m,g)}if(null===a[0])return[];throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"attachments",min:1,max:2}),l.functions.featuresetbyrelationshipname=function(b,e){return l.standardFunctionAsync(b,
e,function(){var k=z._asyncToGenerator(function*(d,c,a){f.pcCheck(a,2,4,b,e);d=a[0];const m=f.toString(a[1]);c=f.defaultUndefined(a[2],null);var g=f.toBoolean(f.defaultUndefined(a[3],!0));null===c&&(c=["*"]);if(!1===f.isArray(c))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);if(null===a[0])return null;if(!f.isFeature(a[0]))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);a=d._layer;a instanceof L&&(a=y.constructFeatureSet(a,b.spatialReference,
["*"],!0,b.lrucache,b.interceptor));if(null===a||!1===f.isFeatureSet(a))return null;a=yield a.load();const h=a.relationshipMetaData().filter(t=>t.name===m);if(0===h.length)return null;if(void 0!==h[0].relationshipTableId&&null!==h[0].relationshipTableId&&-1<h[0].relationshipTableId)return y.constructFeatureSetFromRelationship(a,h[0],d.field(a.objectIdField),a.spatialReference,c,g,b.lrucache,b.interceptor);let n=a.serviceUrl();if(!n)return null;n="/"===n.charAt(n.length-1)?n+h[0].relatedTableId.toString():
n+"/"+h[0].relatedTableId.toString();c=yield y.constructFeatureSetFromUrl(n,a.spatialReference,c,g,b.lrucache,b.interceptor);yield c.load();g=c.relationshipMetaData();g=g.filter(t=>t.id===h[0].id);if(!1===d.hasField(h[0].keyField)||null===d.field(h[0].keyField))return(d=yield a.getFeatureByObjectId(d.field(a.objectIdField),[h[0].keyField]))?(a=w.WhereClause.create(g[0].keyField+"\x3d @id",c.getFieldsIndex()),a.parameters={id:d.attributes[h[0].keyField]},c.filter(a)):new aa({parentfeatureset:c});a=
w.WhereClause.create(g[0].keyField+"\x3d @id",c.getFieldsIndex());a.parameters={id:d.field(h[0].keyField)};return c.filter(a)});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"featuresetbyrelationshipname",min:2,max:4}),l.functions.featuresetbyassociation=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,c,a){f.pcCheck(a,2,3,b,e);var m=a[0],g=f.toString(f.defaultUndefined(a[1],"")).toLowerCase(),h=f.isString(a[2])?
f.toString(a[2]):null;if(null===a[0])return null;if(!f.isFeature(a[0]))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);var n=m._layer;n instanceof L&&(n=y.constructFeatureSet(n,b.spatialReference,["*"],!0,b.lrucache,b.interceptor));if(null===n||!1===f.isFeatureSet(n))return null;yield n.load();a=n.serviceUrl();a=yield y.constructAssociationMetaDataFeatureSetFromUrl(a,b.spatialReference);let t=c=null;d=!1;if(null!==h&&""!==h&&void 0!==h){for(var q of a.terminals)q.terminalName===
h&&(t=q.terminalId);null===t&&(d=!0)}var v=a.associations.getFieldsIndex();q=v.get("TOGLOBALID").name;h=v.get("FROMGLOBALID").name;const x=v.get("TOTERMINALID").name,P=v.get("FROMTERMINALID").name,F=v.get("FROMNETWORKSOURCEID").name,G=v.get("TONETWORKSOURCEID").name,D=v.get("ASSOCIATIONTYPE").name,ea=v.get("ISCONTENTVISIBLE").name,fa=v.get("OBJECTID").name;for(var H of n.fields)if("global-id"===H.type){c=m.field(H.name);break}let C=null;H=new u.SqlExpressionAdapted(new E({name:"percentalong",alias:"percentalong",
type:"double"}),w.WhereClause.create("0",a.associations.getFieldsIndex()));m=new u.SqlExpressionAdapted(new E({name:"side",alias:"side",type:"string"}),w.WhereClause.create("''",a.associations.getFieldsIndex()));n={};for(var B in a.lkp)n[B]=a.lkp[B].sourceId;B=new u.StringToCodeAdapted(new E({name:"classname",alias:"classname",type:"string"}),null,n);n="";switch(g){case "midspan":n=`((${q}='${c}') OR ( ${h}='${c}')) AND (${D} IN (5))`;B.codefield=w.WhereClause.create(`CASE WHEN (${q}='${c}') THEN ${F} ELSE ${G} END`,
a.associations.getFieldsIndex());g=J.cloneField(u.AdaptedFeatureSet.findField(a.associations.fields,h));g.name="globalid";g.alias="globalid";C=new u.SqlExpressionAdapted(g,w.WhereClause.create(`CASE WHEN (${h}='${c}') THEN ${q} ELSE ${h} END`,a.associations.getFieldsIndex()));H=4<=a.unVersion?new u.OriginalField(u.AdaptedFeatureSet.findField(a.associations.fields,v.get("PERCENTALONG").name)):new u.SqlExpressionAdapted(new E({name:"percentalong",alias:"percentalong",type:"double"}),w.WhereClause.create("0",
a.associations.getFieldsIndex()));break;case "junctionedge":n=`((${q}='${c}') OR ( ${h}='${c}')) AND (${D} IN (4,6))`;B.codefield=w.WhereClause.create(`CASE WHEN (${q}='${c}') THEN ${F} ELSE ${G} END`,a.associations.getFieldsIndex());g=J.cloneField(u.AdaptedFeatureSet.findField(a.associations.fields,h));g.name="globalid";g.alias="globalid";C=new u.SqlExpressionAdapted(g,w.WhereClause.create(`CASE WHEN (${h}='${c}') THEN ${q} ELSE ${h} END`,a.associations.getFieldsIndex()));m=new u.SqlExpressionAdapted(new E({name:"side",
alias:"side",type:"string"}),w.WhereClause.create(`CASE WHEN (${D}=4) THEN 'from' ELSE 'to' END`,a.associations.getFieldsIndex()));break;case "connected":g=`${q}='@T'`;v=`${h}='@T'`;null!==t&&(g+=` AND ${x}=@A`,v+=` AND ${P}=@A`);n="(("+g+") OR ("+v+"))";n=f.multiReplace(n,"@T",c??"");g=f.multiReplace(g,"@T",c??"");null!==t&&(g=f.multiReplace(g,"@A",t.toString()),n=f.multiReplace(n,"@A",t.toString()));B.codefield=w.WhereClause.create("CASE WHEN "+g+` THEN ${F} ELSE ${G} END`,a.associations.getFieldsIndex());
c=J.cloneField(u.AdaptedFeatureSet.findField(a.associations.fields,h));c.name="globalid";c.alias="globalid";C=new u.SqlExpressionAdapted(c,w.WhereClause.create("CASE WHEN "+g+` THEN ${h} ELSE ${q} END`,a.associations.getFieldsIndex()));break;case "container":n=`${q}='${c}' AND ${D} = 2`,null!==t&&(n+=` AND ${x} = `+t.toString()),B.codefield=F,n="( "+n+" )",C=new u.FieldRename(u.AdaptedFeatureSet.findField(a.associations.fields,h),"globalid","globalid");case "content":n=`(${h}='${c}' AND ${D} = 2)`;
null!==t&&(n+=` AND ${P} = `+t.toString());B.codefield=G;n="( "+n+" )";C=new u.FieldRename(u.AdaptedFeatureSet.findField(a.associations.fields,q),"globalid","globalid");break;case "structure":n=`(${q}='${c}' AND ${D} = 3)`;null!==t&&(n+=` AND ${x} = `+t.toString());B.codefield=F;n="( "+n+" )";C=new u.FieldRename(u.AdaptedFeatureSet.findField(a.associations.fields,h),"globalid","globalId");break;case "attached":n=`(${h}='${c}' AND ${D} = 3)`;null!==t&&(n+=` AND ${P} = `+t.toString());B.codefield=G;
n="( "+n+" )";C=new u.FieldRename(u.AdaptedFeatureSet.findField(a.associations.fields,q),"globalid","globalId");break;default:throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);}d&&(n="1 \x3c\x3e 1");return new u.AdaptedFeatureSet({parentfeatureset:a.associations,adaptedFields:[new u.OriginalField(u.AdaptedFeatureSet.findField(a.associations.fields,fa)),new u.OriginalField(u.AdaptedFeatureSet.findField(a.associations.fields,ea)),C,m,B,H],extraFilter:n?w.WhereClause.create(n,
a.associations.getFieldsIndex()):null})});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"featuresetbyassociation",min:2,max:6}),l.functions.groupby=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,c,a){f.pcCheck(a,3,3,b,e);if(!f.isFeatureSet(a[0]))throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);const m=yield a[0].load();d=[];c=[];let g=!1;var h=[];if(f.isString(a[1]))h.push(a[1]);else if(a[1]instanceof
A)h.push(a[1]);else if(f.isArray(a[1]))h=a[1];else if(f.isImmutableArray(a[1]))h=a[1].toArray();else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);for(var n of h)if(f.isString(n)){h=w.WhereClause.create(f.toString(n),m.getFieldsIndex());var t=!0===S.isSingleField(h)?f.toString(n):"%%%%FIELDNAME";d.push({name:t,expression:h});"%%%%FIELDNAME"===t&&(g=!0)}else if(n instanceof A){h=n.hasField("name")?n.field("name"):"%%%%FIELDNAME";t=n.hasField("expression")?n.field("expression"):
"";"%%%%FIELDNAME"===h&&(g=!0);if(!h)throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);d.push({name:h,expression:w.WhereClause.create(t?t:h,m.getFieldsIndex())})}else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);h=[];if(f.isString(a[2]))h.push(a[2]);else if(f.isArray(a[2]))h=a[2];else if(f.isImmutableArray(a[2]))h=a[2].toArray();else if(a[2]instanceof A)h.push(a[2]);else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,
e);for(var q of h)if(q instanceof A){n=q.hasField("name")?q.field("name"):"";h=q.hasField("statistic")?q.field("statistic"):"";t=q.hasField("expression")?q.field("expression"):"";if(!n||!h||!t)throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);c.push({name:n,statistic:h.toLowerCase(),expression:w.WhereClause.create(t,m.getFieldsIndex())})}else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);if(g){q={};for(var v of m.fields)q[v.name.toLowerCase()]=
1;for(const x of d)"%%%%FIELDNAME"!==x.name&&(q[x.name.toLowerCase()]=1);for(const x of c)"%%%%FIELDNAME"!==x.name&&(q[x.name.toLowerCase()]=1);v=0;for(const x of d)if("%%%%FIELDNAME"===x.name){for(;1===q["field_"+v.toString()];)v++;q["field_"+v.toString()]=1;x.name="FIELD_"+v.toString()}}for(const x of d)yield M(x.expression,l,b);for(const x of c)yield M(x.expression,l,b);return a[0].groupby(d,c)});return function(d,c,a){return k.apply(this,arguments)}}())},l.signatures.push({name:"groupby",min:3,
max:3}),l.functions.distinct=function(b,e){return l.standardFunctionAsync(b,e,function(){var k=z._asyncToGenerator(function*(d,c,a){if(f.isFeatureSet(a[0])){f.pcCheck(a,2,2,b,e);c=yield a[0].load();d=[];var m=[];if(f.isString(a[1]))m.push(a[1]);else if(a[1]instanceof A)m.push(a[1]);else if(f.isArray(a[1]))m=a[1];else if(f.isImmutableArray(a[1]))m=a[1].toArray();else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);let t=!1;for(var g of m)if(f.isString(g)){m=w.WhereClause.create(f.toString(g),
c.getFieldsIndex());var h=!0===S.isSingleField(m)?f.toString(g):"%%%%FIELDNAME";d.push({name:h,expression:m});"%%%%FIELDNAME"===h&&(t=!0)}else if(g instanceof A){m=g.hasField("name")?g.field("name"):"%%%%FIELDNAME";h=g.hasField("expression")?g.field("expression"):"";"%%%%FIELDNAME"===m&&(t=!0);if(!m)throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,e);d.push({name:m,expression:w.WhereClause.create(h?h:m,c.getFieldsIndex())})}else throw new p.ArcadeExecutionError(b,p.ExecutionErrorCodes.InvalidParameter,
e);if(t){g={};for(var n of c.fields)g[n.name.toLowerCase()]=1;for(const q of d)"%%%%FIELDNAME"!==q.name&&(g[q.name.toLowerCase()]=1);n=0;for(const q of d)if("%%%%FIELDNAME"===q.name){for(;1===g["field_"+n.toString()];)n++;g["field_"+n.toString()]=1;q.name="FIELD_"+n.toString()}}for(const q of d)yield M(q.expression,l,b);return a[0].groupby(d,[])}a:{if(1===a.length){if(f.isArray(a[0])){a=K.calculateStat("distinct",a[0],-1);break a}if(f.isImmutableArray(a[0])){a=K.calculateStat("distinct",a[0].toArray(),
-1);break a}}a=K.calculateStat("distinct",a,-1)}return a});return function(d,c,a){return k.apply(this,arguments)}}())})};Object.defineProperties(Q,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}})});