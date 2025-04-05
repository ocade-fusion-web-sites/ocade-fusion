const t=window.ShadowRoot&&(void 0===window.ShadyCSS||window.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,i=Symbol(),s=new Map;class e{constructor(t,e){if(this._$cssResult$=!0,e!==i)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t}get styleSheet(){let e=s.get(this.cssText);return t&&void 0===e&&(s.set(this.cssText,e=new CSSStyleSheet),e.replaceSync(this.cssText)),e}toString(){return this.cssText}}const o=t?t=>t:t=>t instanceof CSSStyleSheet?(t=>{let o="";for(const e of t.cssRules)o+=e.cssText;return(t=>new e("string"==typeof t?t:t+"",i))(o)})(t):t
;var n;const r=window.trustedTypes,h=r?r.emptyScript:"",l=window.reactiveElementPolyfillSupport,d={toAttribute(t,e){switch(e){case Boolean:t=t?h:null;break;case Object:case Array:t=null==t?t:JSON.stringify(t)}return t},fromAttribute(t,e){let i=t;switch(e){case Boolean:i=null!==t;break;case Number:i=null===t?null:Number(t);break;case Object:case Array:try{i=JSON.parse(t)}catch(t){i=null}}return i}},a=(t,e)=>e!==t&&(e==e||t==t),c={attribute:!0,type:String,converter:d,reflect:!1,hasChanged:a};class u extends HTMLElement{constructor(){super(),this._$Et=new Map,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Ei=null,this.o()}static addInitializer(t){var e;null!==(e=this.l)&&void 0!==e||(this.l=[]),this.l.push(t)}static get observedAttributes(){this.finalize();const t=[];return this.elementProperties.forEach(((e,i)=>{const o=this._$Eh(i,e);void 0!==o&&(this._$Eu.set(o,i),t.push(o))})),t}static createProperty(t,e=c){if(e.state&&(e.attribute=!1),this.finalize(),this.elementProperties.set(t,e),!e.noAccessor&&!this.prototype.hasOwnProperty(t)){const i="symbol"==typeof t?Symbol():"__"+t,o=this.getPropertyDescriptor(t,i,e);void 0!==o&&Object.defineProperty(this.prototype,t,o)}}static getPropertyDescriptor(t,e,i){return{get(){return this[e]},set(o){const s=this[t];this[e]=o,this.requestUpdate(t,s,i)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)||c}static finalize(){if(this.hasOwnProperty("finalized"))return!1;this.finalized=!0;const t=Object.getPrototypeOf(this);if(t.finalize(),this.elementProperties=new Map(t.elementProperties),this._$Eu=new Map,this.hasOwnProperty("properties")){const t=this.properties,e=[...Object.getOwnPropertyNames(t),...Object.getOwnPropertySymbols(t)];for(const i of e)this.createProperty(i,t[i])}return this.elementStyles=this.finalizeStyles(this.styles),!0}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const i=new Set(t.flat(1/0).reverse());for(const t of i)e.unshift(o(t))}else void 0!==t&&e.push(o(t));return e}static _$Eh(t,e){const i=e.attribute;return!1===i?void 0:"string"==typeof i?i:"string"==typeof t?t.toLowerCase():void 0}o(){var t;this._$Ep=new Promise((t=>this.enableUpdating=t)),this._$AL=new Map,this._$Em(),this.requestUpdate(),null===(t=this.constructor.l)||void 0===t||t.forEach((t=>t(this)))}addController(t){var e,i;(null!==(e=this._$Eg)&&void 0!==e?e:this._$Eg=[]).push(t),void 0!==this.renderRoot&&this.isConnected&&(null===(i=t.hostConnected)||void 0===i||i.call(t))}removeController(t){var e;null===(e=this._$Eg)||void 0===e||e.splice(this._$Eg.indexOf(t)>>>0,1)}_$Em(){this.constructor.elementProperties.forEach(((t,e)=>{this.hasOwnProperty(e)&&(this._$Et.set(e,this[e]),delete this[e])}))}createRenderRoot(){var e;const i=null!==(e=this.shadowRoot)&&void 0!==e?e:this.attachShadow(this.constructor.shadowRootOptions);return((e,i)=>{t?e.adoptedStyleSheets=i.map((t=>t instanceof CSSStyleSheet?t:t.styleSheet)):i.forEach((t=>{const i=document.createElement("style"),o=window.litNonce;void 0!==o&&i.setAttribute("nonce",o),i.textContent=t.cssText,e.appendChild(i)}))})(i,this.constructor.elementStyles),i}connectedCallback(){var t;void 0===this.renderRoot&&(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),null===(t=this._$Eg)||void 0===t||t.forEach((t=>{var e;return null===(e=t.hostConnected)||void 0===e?void 0:e.call(t)}))}enableUpdating(t){}disconnectedCallback(){var t;null===(t=this._$Eg)||void 0===t||t.forEach((t=>{var e;return null===(e=t.hostDisconnected)||void 0===e?void 0:e.call(t)}))}attributeChangedCallback(t,e,i){this._$AK(t,i)}_$ES(t,e,i=c){var o,s;const r=this.constructor._$Eh(t,i);if(void 0!==r&&!0===i.reflect){const n=(null!==(s=null===(o=i.converter)||void 0===o?void 0:o.toAttribute)&&void 0!==s?s:d.toAttribute)(e,i.type);this._$Ei=t,null==n?this.removeAttribute(r):this.setAttribute(r,n),this._$Ei=null}}_$AK(t,e){var i,o,s;const r=this.constructor,n=r._$Eu.get(t);if(void 0!==n&&this._$Ei!==n){const t=r.getPropertyOptions(n),l=t.converter,a=null!==(s=null!==(o=null===(i=l)||void 0===i?void 0:i.fromAttribute)&&void 0!==o?o:"function"==typeof l?l:null)&&void 0!==s?s:d.fromAttribute;this._$Ei=n,this[n]=a(e,t.type),this._$Ei=null}}requestUpdate(t,e,i){let o=!0;void 0!==t&&(((i=i||this.constructor.getPropertyOptions(t)).hasChanged||a)(this[t],e)?(this._$AL.has(t)||this._$AL.set(t,e),!0===i.reflect&&this._$Ei!==t&&(void 0===this._$E_&&(this._$E_=new Map),this._$E_.set(t,i))):o=!1),!this.isUpdatePending&&o&&(this._$Ep=this._$EC())}async _$EC(){this.isUpdatePending=!0;try{await this._$Ep}catch(t){Promise.reject(t)}const t=this.scheduleUpdate();return null!=t&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var t;if(!this.isUpdatePending)return;this.hasUpdated,this._$Et&&(this._$Et.forEach(((t,e)=>this[e]=t)),this._$Et=void 0);let e=!1;const i=this._$AL;try{e=this.shouldUpdate(i),e?(this.willUpdate(i),null===(t=this._$Eg)||void 0===t||t.forEach((t=>{var e;return null===(e=t.hostUpdate)||void 0===e?void 0:e.call(t)})),this.update(i)):this._$EU()}catch(t){throw e=!1,this._$EU(),t}e&&this._$AE(i)}willUpdate(t){}_$AE(t){var e;null===(e=this._$Eg)||void 0===e||e.forEach((t=>{var e;return null===(e=t.hostUpdated)||void 0===e?void 0:e.call(t)})),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$Ep}shouldUpdate(t){return!0}update(t){void 0!==this._$E_&&(this._$E_.forEach(((t,e)=>this._$ES(e,this[e],t))),this._$E_=void 0),this._$EU()}updated(t){}firstUpdated(t){}}
var v;u.finalized=!0,u.elementProperties=new Map,u.elementStyles=[],u.shadowRootOptions={mode:"open"},null==l||l({ReactiveElement:u}),(null!==(n=globalThis.reactiveElementVersions)&&void 0!==n?n:globalThis.reactiveElementVersions=[]).push("1.2.1");const p=globalThis.trustedTypes,f=p?p.createPolicy("lit-html",{createHTML:t=>t}):void 0,w=`lit$${(Math.random()+"").slice(9)}$`,b="?"+w,m=`<${b}>`,g=document,y=(t="")=>g.createComment(t),_=t=>null===t||"object"!=typeof t&&"function"!=typeof t,$=Array.isArray,k=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,S=/-->/g,x=/>/g,C=/>|[ 	\n\r](?:([^\s"'>=/]+)([ 	\n\r]*=[ 	\n\r]*(?:[^ 	\n\r"'`<>=]|("|')|))|$)/g,A=/'/g,M=/"/g,E=/^(?:script|style|textarea)$/i,N=(t,...e)=>({_$litType$:1,strings:t,values:e}),O=Symbol.for("lit-noChange"),T=Symbol.for("lit-nothing"),j=new WeakMap,U=g.createTreeWalker(g,129,null,!1),z=(t,e)=>{const i=t.length-1,o=[];let s,r=2===e?"<svg>":"",n=k;for(let e=0;e<i;e++){const i=t[e];let l,a,h=-1,d=0;for(;d<i.length&&(n.lastIndex=d,a=n.exec(i),null!==a);)d=n.lastIndex,n===k?"!--"===a[1]?n=S:void 0!==a[1]?n=x:void 0!==a[2]?(E.test(a[2])&&(s=RegExp("</"+a[2],"g")),n=C):void 0!==a[3]&&(n=C):n===C?">"===a[0]?(n=null!=s?s:k,h=-1):void 0===a[1]?h=-2:(h=n.lastIndex-a[2].length,l=a[1],n=void 0===a[3]?C:'"'===a[3]?M:A):n===M||n===A?n=C:n===S||n===x?n=k:(n=C,s=void 0);const c=n===C&&t[e+1].startsWith("/>")?" ":"";r+=n===k?i+m:h>=0?(o.push(l),i.slice(0,h)+"$lit$"+i.slice(h)+w+c):i+w+(-2===h?(o.push(void 0),e):c)}const l=r+(t[i]||"<?>")+(2===e?"</svg>":"");if(!Array.isArray(t)||!t.hasOwnProperty("raw"))throw Error("invalid template strings array");return[void 0!==f?f.createHTML(l):l,o]};class I{constructor({strings:t,_$litType$:e},i){let o;this.parts=[];let s=0,r=0;const n=t.length-1,l=this.parts,[a,h]=z(t,e);if(this.el=I.createElement(a,i),U.currentNode=this.el.content,2===e){const t=this.el.content,e=t.firstChild;e.remove(),t.append(...e.childNodes)}for(;null!==(o=U.nextNode())&&l.length<n;){if(1===o.nodeType){if(o.hasAttributes()){const t=[];for(const e of o.getAttributeNames())if(e.endsWith("$lit$")||e.startsWith(w)){const i=h[r++];if(t.push(e),void 0!==i){const t=o.getAttribute(i.toLowerCase()+"$lit$").split(w),e=/([.?@])?(.*)/.exec(i);l.push({type:1,index:s,name:e[2],strings:t,ctor:"."===e[1]?V:"?"===e[1]?B:"@"===e[1]?H:L})}else l.push({type:6,index:s})}for(const e of t)o.removeAttribute(e)}if(E.test(o.tagName)){const t=o.textContent.split(w),e=t.length-1;if(e>0){o.textContent=p?p.emptyScript:"";for(let i=0;i<e;i++)o.append(t[i],y()),U.nextNode(),l.push({type:2,index:++s});o.append(t[e],y())}}}else if(8===o.nodeType)if(o.data===b)l.push({type:2,index:s});else{let t=-1;for(;-1!==(t=o.data.indexOf(w,t+1));)l.push({type:7,index:s}),t+=w.length-1}s++}}static createElement(t,e){const i=g.createElement("template");return i.innerHTML=t,i}}function R(t,e,i=t,o){var s,r,n,l;if(e===O)return e;let a=void 0!==o?null===(s=i._$Cl)||void 0===s?void 0:s[o]:i._$Cu;const h=_(e)?void 0:e._$litDirective$;return(null==a?void 0:a.constructor)!==h&&(null===(r=null==a?void 0:a._$AO)||void 0===r||r.call(a,!1),void 0===h?a=void 0:(a=new h(t),a._$AT(t,i,o)),void 0!==o?(null!==(n=(l=i)._$Cl)&&void 0!==n?n:l._$Cl=[])[o]=a:i._$Cu=a),void 0!==a&&(e=R(t,a._$AS(t,e.values),a,o)),e}class J{constructor(t,e){this.v=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}p(t){var e;const{el:{content:i},parts:o}=this._$AD,s=(null!==(e=null==t?void 0:t.creationScope)&&void 0!==e?e:g).importNode(i,!0);U.currentNode=s;let r=U.nextNode(),n=0,l=0,a=o[0];for(;void 0!==a;){if(n===a.index){let e;2===a.type?e=new D(r,r.nextSibling,this,t):1===a.type?e=new a.ctor(r,a.name,a.strings,this,t):6===a.type&&(e=new W(r,this,t)),this.v.push(e),a=o[++l]}n!==(null==a?void 0:a.index)&&(r=U.nextNode(),n++)}return s}m(t){let e=0;for(const i of this.v)void 0!==i&&(void 0!==i.strings?(i._$AI(t,i,e),e+=i.strings.length-2):i._$AI(t[e])),e++}}class D{constructor(t,e,i,o){var s;this.type=2,this._$AH=T,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=i,this.options=o,this._$Cg=null===(s=null==o?void 0:o.isConnected)||void 0===s||s}get _$AU(){var t,e;return null!==(e=null===(t=this._$AM)||void 0===t?void 0:t._$AU)&&void 0!==e?e:this._$Cg}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return void 0!==e&&11===t.nodeType&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=R(this,t,e),_(t)?t===T||null==t||""===t?(this._$AH!==T&&this._$AR(),this._$AH=T):t!==this._$AH&&t!==O&&this.$(t):void 0!==t._$litType$?this.T(t):void 0!==t.nodeType?this.S(t):(t=>{var e;return $(t)||"function"==typeof(null===(e=t)||void 0===e?void 0:e[Symbol.iterator])})(t)?this.A(t):this.$(t)}M(t,e=this._$AB){return this._$AA.parentNode.insertBefore(t,e)}S(t){this._$AH!==t&&(this._$AR(),this._$AH=this.M(t))}$(t){this._$AH!==T&&_(this._$AH)?this._$AA.nextSibling.data=t:this.S(g.createTextNode(t)),this._$AH=t}T(t){var e;const{values:i,_$litType$:o}=t,s="number"==typeof o?this._$AC(t):(void 0===o.el&&(o.el=I.createElement(o.h,this.options)),o);if((null===(e=this._$AH)||void 0===e?void 0:e._$AD)===s)this._$AH.m(i);else{const t=new J(s,this),e=t.p(this.options);t.m(i),this.S(e),this._$AH=t}}_$AC(t){let e=j.get(t.strings);return void 0===e&&j.set(t.strings,e=new I(t)),e}A(t){$(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let i,o=0;for(const s of t)o===e.length?e.push(i=new D(this.M(y()),this.M(y()),this,this.options)):i=e[o],i._$AI(s),o++;o<e.length&&(this._$AR(i&&i._$AB.nextSibling,o),e.length=o)}_$AR(t=this._$AA.nextSibling,e){var i;for(null===(i=this._$AP)||void 0===i||i.call(this,!1,!0,e);t&&t!==this._$AB;){const e=t.nextSibling;t.remove(),t=e}}setConnected(t){var e;void 0===this._$AM&&(this._$Cg=t,null===(e=this._$AP)||void 0===e||e.call(this,t))}}class L{constructor(t,e,i,o,s){this.type=1,this._$AH=T,this._$AN=void 0,this.element=t,this.name=e,this._$AM=o,this.options=s,i.length>2||""!==i[0]||""!==i[1]?(this._$AH=Array(i.length-1).fill(new String),this.strings=i):this._$AH=T}get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}_$AI(t,e=this,i,o){const s=this.strings;let r=!1;if(void 0===s)t=R(this,t,e,0),r=!_(t)||t!==this._$AH&&t!==O,r&&(this._$AH=t);else{const o=t;let n,l;for(t=s[0],n=0;n<s.length-1;n++)l=R(this,o[i+n],e,n),l===O&&(l=this._$AH[n]),r||(r=!_(l)||l!==this._$AH[n]),l===T?t=T:t!==T&&(t+=(null!=l?l:"")+s[n+1]),this._$AH[n]=l}r&&!o&&this.k(t)}k(t){t===T?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,null!=t?t:"")}}class V extends L{constructor(){super(...arguments),this.type=3}k(t){this.element[this.name]=t===T?void 0:t}}const P=p?p.emptyScript:"";class B extends L{constructor(){super(...arguments),this.type=4}k(t){t&&t!==T?this.element.setAttribute(this.name,P):this.element.removeAttribute(this.name)}}class H extends L{constructor(t,e,i,o,s){super(t,e,i,o,s),this.type=5}_$AI(t,e=this){var i;if((t=null!==(i=R(this,t,e,0))&&void 0!==i?i:T)===O)return;const o=this._$AH,s=t===T&&o!==T||t.capture!==o.capture||t.once!==o.once||t.passive!==o.passive,r=t!==T&&(o===T||s);s&&this.element.removeEventListener(this.name,this,o),r&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e,i;"function"==typeof this._$AH?this._$AH.call(null!==(i=null===(e=this.options)||void 0===e?void 0:e.host)&&void 0!==i?i:this.element,t):this._$AH.handleEvent(t)}}class W{constructor(t,e,i){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=i}get _$AU(){return this._$AM._$AU}_$AI(t){R(this,t)}}const K=window.litHtmlPolyfillSupport;
var Z,q;null==K||K(I,D),(null!==(v=globalThis.litHtmlVersions)&&void 0!==v?v:globalThis.litHtmlVersions=[]).push("2.1.2");class Y extends u{constructor(){super(...arguments),this.renderOptions={host:this},this._$Dt=void 0}createRenderRoot(){var t,e;const i=super.createRenderRoot();return null!==(t=(e=this.renderOptions).renderBefore)&&void 0!==t||(e.renderBefore=i.firstChild),i}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Dt=((t,e,i)=>{var o,s;const r=null!==(o=null==i?void 0:i.renderBefore)&&void 0!==o?o:e;let n=r._$litPart$;if(void 0===n){const t=null!==(s=null==i?void 0:i.renderBefore)&&void 0!==s?s:null;r._$litPart$=n=new D(e.insertBefore(y(),t),t,void 0,null!=i?i:{})}return n._$AI(t),n})(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),null===(t=this._$Dt)||void 0===t||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),null===(t=this._$Dt)||void 0===t||t.setConnected(!1)}render(){return O}}Y.finalized=!0,Y._$litElement$=!0,null===(Z=globalThis.litElementHydrateSupport)||void 0===Z||Z.call(globalThis,{LitElement:Y});const F=globalThis.litElementPolyfillSupport;null==F||F({LitElement:Y}),(null!==(q=globalThis.litElementVersions)&&void 0!==q?q:globalThis.litElementVersions=[]).push("3.1.2");
const G=(t,e)=>"method"===e.kind&&e.descriptor&&!("value"in e.descriptor)?{...e,finisher(i){i.createProperty(e.key,t)}}:{kind:"field",key:Symbol(),placement:"own",descriptor:{},originalKey:e.key,initializer(){"function"==typeof e.initializer&&(this[e.key]=e.initializer.call(this))},finisher(i){i.createProperty(e.key,t)}}
;function Q(t){return(e,i)=>void 0!==i?((t,e,i)=>{e.constructor.createProperty(i,t)})(t,e,i):G(t,e)
}function X(t){return Q({...t,state:!0})}
var tt;null===(tt=window.HTMLSlotElement)||void 0===tt||tt.prototype.assignedElements;
const it=1,st=(t=>(...e)=>({_$litDirective$:t,values:e}))(class extends class{constructor(t){}get _$AU(){return this._$AM._$AU}_$AT(t,e,i){this._$Ct=t,this._$AM=e,this._$Ci=i}_$AS(t,e){return this.update(t,e)}update(t,e){return this.render(...e)}}{constructor(t){var e;if(super(t),1!==t.type||"class"!==t.name||(null===(e=t.strings)||void 0===e?void 0:e.length)>2)throw Error("`classMap()` can only be used in the `class` attribute and must be the only part in the attribute.")}render(t){return" "+Object.keys(t).filter((e=>t[e])).join(" ")+" "}update(t,[e]){var i,o;if(void 0===this.st){this.st=new Set,void 0!==t.strings&&(this.et=new Set(t.strings.join(" ").split(/\s/).filter((t=>""!==t))));for(const t in e)e[t]&&!(null===(i=this.et)||void 0===i?void 0:i.has(t))&&this.st.add(t);return this.render(e)}const s=t.element.classList;this.st.forEach((t=>{t in e||(s.remove(t),this.st.delete(t))}));for(const t in e){const i=!!e[t];i===this.st.has(t)||(null===(o=this.et)||void 0===o?void 0:o.has(t))||(i?(s.add(t),this.st.add(t)):(s.remove(t),this.st.delete(t)))}return O}});
var et=function(t,e,i,o){for(var s,r=arguments.length,n=r<3?e:null===o?o=Object.getOwnPropertyDescriptor(e,i):o,l=t.length-1;l>=0;l--)(s=t[l])&&(n=(r<3?s(n):r>3?s(e,i,n):s(e,i))||n);return r>3&&n&&Object.defineProperty(e,i,n),n};function ot(t){try{JSON.parse(t)}catch(t){return!1}return!0}let nt=class extends Y{constructor(){super(...arguments),this.workflow="{}",this.frame="false",this.src="https://n8n-preview-service.internal.n8n.cloud/workflows/demo",this.collapseformobile="true",this.clicktointeract="false",this.hidecanvaserrors="false",this.disableinteractivity="false",this.theme=void 0,this.showCode=!1,this.showPreview=!0,this.fullscreen=!1,this.insideIframe=!1,this.copyText="Copy",this.isMobileView=!1,this.error=!1,this.interactive=!0,this.scrollX=0,this.scrollY=0,this.receiveMessage=({data:t,source:e})=>{const i=this.shadowRoot.getElementById("int_iframe");if(i&&ot(t)&&i.contentWindow===e){const e=JSON.parse(t);"n8nReady"===e.command?this.loadWorkflow():"openNDV"===e.command?this.fullscreen=!0:"closeNDV"===e.command?this.fullscreen=!1:"error"===e.command&&(this.error=!0,this.showPreview=!1)}},this.onDocumentScroll=()=>{this.interactive&&this.insideIframe&&!("ontouchstart"in window)&&!navigator.maxTouchPoints&&window.scrollTo(this.scrollX,this.scrollY)}}connectedCallback(){super.connectedCallback();try{"string"==typeof this.workflow&&this.workflow.startsWith("%7B%")&&(this.workflow=decodeURIComponent(this.workflow))}catch(t){}"true"!==this.clicktointeract&&"true"!==this.disableinteractivity||(this.interactive=!1),window.matchMedia("only screen and (max-width: 760px)").matches&&(this.isMobileView=!0),"true"===this.collapseformobile&&this.isMobileView&&(this.showPreview=!1),window.addEventListener("message",this.receiveMessage),document.addEventListener("scroll",this.onDocumentScroll)}disconnectedCallback(){window.removeEventListener("message",this.receiveMessage),document.removeEventListener("scroll",this.onDocumentScroll),super.disconnectedCallback()}loadWorkflow(){try{const t=JSON.parse(this.workflow);if(!t)throw new Error("Missing workflow");if(!t.nodes||!Array.isArray(t.nodes))throw new Error("Must have an array of nodes");const e=this.shadowRoot.getElementById("int_iframe");e.contentWindow&&e.contentWindow.postMessage(JSON.stringify({command:"openWorkflow",workflow:t,hideNodeIssues:"true"===this.hidecanvaserrors}),"*")}catch{this.error=!0}}toggleCode(){this.showCode=!this.showCode}onMouseEnter(){this.insideIframe=!0,this.scrollX=window.scrollX,this.scrollY=window.scrollY}onMouseLeave(){this.insideIframe=!1}onOverlayClick(){"true"!==this.disableinteractivity&&(this.interactive=!0)}copyClipboard(){navigator.clipboard.writeText(this.workflow),this.copyText="Copied",setTimeout((()=>{this.copyText="Copy"}),1500)}toggleView(){this.showPreview=!0}renderIframe(){if(!this.showPreview||this.error)return N``;const t=this.theme?`?theme=${this.theme}`:"",e=`${this.src}${t}`,i="true"===this.disableinteractivity,o=N`<iframe
      class=${st({embedded_workflow_iframe_node_view:this.fullscreen,embedded_workflow_iframe:!this.fullscreen,non_interactive:!this.interactive})}
      allow="${i?T:"clipboard-write"}"
      src=${e}
      id="int_iframe"
      title="n8n workflow"
    ></iframe>`;let s="";return i?s=N`<div
        class="overlay"
        ?hidden="${!(this.insideIframe||this.isMobileView)}"
      ></div>`:this.interactive||(s=N`<div
        class="overlay"
        @click="${this.onOverlayClick}"
        ?hidden="${!(this.insideIframe||this.isMobileView)}"
      >
        <button>Click to explore</button>
      </div>`),N`<div class="canvas-container">${s}${o}</div>`}render(){const t="true"===this.frame&&this.showPreview&&!this.error;return N`
      <div
        class="${st({embedded_workflow:!0,frame:t})}"
        @mouseenter=${this.onMouseEnter}
        @mouseleave=${this.onMouseLeave}
      >
        ${this.showPreview||this.error?"":N`<div
              class=${st({embedded_tip_error:!0})}
              ?hidden=${this.showPreview||this.error}
            >
              <button class="code_toggle" @click=${this.toggleView}>
                Show workflow
              </button>
            </div>`}
        ${this.renderIframe()}
        ${this.error?N`<div
              class=${st({embedded_tip_error:!0,embedded_tip_error_with_code:this.showCode})}
            >
              Could not load workflow preview. You can still
              <button class="code_toggle" @click=${this.toggleCode}>
                view the code
              </button>
              and paste it into n8n
            </div>`:""}
        ${t?N`<div
              class=${st({embedded_tip:!0,embedded_tip_with_code:this.showCode})}
            >
              💡 Double-click a node to see its settings, or paste
              <button class="code_toggle" @click=${this.toggleCode}>
                this workflow's code
              </button>
              into n8n to import it
            </div>`:""}
        ${this.showCode?N`<div class="workflow_json">
              <div class="copy_button" @click=${this.copyClipboard}>
                ${this.copyText}
              </div>
              <pre class="json_renderer" id="json">
${ot(this.workflow)?JSON.stringify(JSON.parse(this.workflow),void 0,2):"Invalid JSON"}
          </pre
              >
            </div>`:""}
      </div>
    `}};nt.styles=((t,...o)=>{const s=1===t.length?t[0]:o.reduce(((e,i,o)=>e+(t=>{if(!0===t._$cssResult$)return t.cssText;if("number"==typeof t)return t;throw Error("Value passed to 'css' function must be a 'css' function result: "+t+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(i)+t[o+1]),t[0]);return new e(s,i)})`
    :host {
      --n8n-color-primary-h: 6.9;
      --n8n-color-primary-s: 100%;
      --n8n-color-primary-l: 67.6%;
      --n8n-color-primary: hsl(
        var(--n8n-color-primary-h),
        var(--n8n-color-primary-s),
        var(--n8n-color-primary-l)
      );
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    button {
      outline: none;
      text-decoration: none;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      -webkit-appearance: none;
    }

    .workflow_json {
      height: 300px;
      padding-left: 10px;
      overflow: auto;
      background-color: var(--n8n-json-background-color, hsl(260deg 100% 99%));
      word-wrap: normal;
      font-family: 'Lucida Console', 'Liberation Mono', 'DejaVu Sans Mono',
        'Bitstream Vera Sans Mono', 'Courier New', monospace;
      font-size: 1.2em;
      color: hsl(0, 0%, 20%);
    }

    .overlay {
      height: 100%;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
      background: var(--n8n-overlay-background, hsla(232, 48%, 12%, 0.1));
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
    }

    .overlay:hover {
      opacity: 1;
      transition: 250ms opacity;
    }

    .overlay > button {
      padding: 20px 40px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 18px;
      line-height: 24px;
      border: var(--n8n-overlay-border, none);
      background-color: var(
        --n8n-overlay-background-color,
        var(--n8n-color-primary)
      );
      color: var(--n8n-interact-button-color, white);
    }

    .overlay > button:hover {
      filter: brightness(85%);
      cursor: pointer;
    }

    .canvas-container {
      height: var(--n8n-workflow-min-height, 300px);
      position: relative;
    }

    .embedded_workflow.frame {
      padding: 10px;
      background-color: var(--n8n-frame-background-color, hsl(260, 11%, 95%));
    }

    .embedded_workflow .embedded_tip_error {
      color: hsl(0, 0%, 40%);
      text-align: center;
      font-size: 0.9em;
    }

    .embedded_workflow .embedded_tip_error_with_code {
      margin-bottom: 10px;
    }

    .embedded_workflow .embedded_tip {
      margin-top: 7px;
      color: hsl(0, 0%, 40%);
      text-align: center;
      font-size: 0.9em;
    }

    .embedded_workflow .embedded_tip_with_code {
      margin-top: 7px;
      margin-bottom: 10px;
    }

    .embedded_workflow_iframe {
      width: 100%;
      min-height: var(--n8n-workflow-min-height, 300px);
      border: 0;
      border-radius: var(--n8n-iframe-border-radius, 0px);
    }

    .embedded_workflow_iframe_node_view {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      z-index: 9999999;
    }

    .code_toggle {
      background: none;
      border: none;
      padding: 0px;
      margin: -1px;
      cursor: pointer;
      color: var(--n8n-color-primary);
      font-size: 1em;
    }

    .copy_button {
      display: none; /* Hide button */
    }

    .workflow_json:hover .copy_button {
      display: block;
      float: right;
      right: 0px;
      margin-top: 10px;
      margin-right: 10px;
      padding: 5px;
      font-family: 'Arial', 'sans-serif';
      font-size: 0.8em;
      color: #646464;
      background: var(--n8n-copy-button-background-color, rgb(239, 239, 239));
      cursor: pointer;
    }

    .non_interactive {
      pointer-events: none;
    }
  `,et([Q({type:String})],nt.prototype,"workflow",void 0),et([Q({type:String})],nt.prototype,"frame",void 0),et([Q({type:String})],nt.prototype,"src",void 0),et([Q({type:String})],nt.prototype,"collapseformobile",void 0),et([Q({type:String})],nt.prototype,"clicktointeract",void 0),et([Q({type:String})],nt.prototype,"hidecanvaserrors",void 0),et([Q({type:String})],nt.prototype,"disableinteractivity",void 0),et([Q({type:[String,void 0]})],nt.prototype,"theme",void 0),et([X()],nt.prototype,"showCode",void 0),et([X()],nt.prototype,"showPreview",void 0),et([X()],nt.prototype,"fullscreen",void 0),et([X()],nt.prototype,"insideIframe",void 0),et([X()],nt.prototype,"copyText",void 0),et([X()],nt.prototype,"isMobileView",void 0),et([X()],nt.prototype,"error",void 0),et([X()],nt.prototype,"interactive",void 0),nt=et([(t=>e=>"function"==typeof e?((t,e)=>(window.customElements.define(t,e),e))(t,e):((t,e)=>{const{kind:i,elements:o}=e;return{kind:i,elements:o,finisher(e){window.customElements.define(t,e)}}})(t,e))("n8n-demo")],nt);export{nt as N8NDemo};