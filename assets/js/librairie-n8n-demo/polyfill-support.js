!function(i){"function"==typeof define&&define.amd?define(i):i()}((function(){"use strict";var i;i=function(){var i,n,o;i=function(){
  /**
                      * @license
                      * Copyright 2017 Google LLC
                      * SPDX-License-Identifier: BSD-3-Clause
                      */
  var i,n,o="__scoped";null!==(i=(n=globalThis).reactiveElementPlatformSupport)&&void 0!==i||(n.reactiveElementPlatformSupport=function(i){var n=i.ReactiveElement;if(void 0!==window.ShadyCSS&&(!window.ShadyCSS.nativeShadow||window.ShadyCSS.ApplyShim)){var t=n.prototype;window.ShadyDOM&&window.ShadyDOM.inUse&&!0===window.ShadyDOM.noPatch&&window.ShadyDOM.patchElementProto(t);var d=t.createRenderRoot;t.createRenderRoot=function(){var i,n,t,e=this.localName;if(window.ShadyCSS.nativeShadow)return d.call(this);if(!this.constructor.hasOwnProperty(o)){this.constructor[o]=!0;var v=this.constructor.elementStyles.map((function(i){return i instanceof CSSStyleSheet?Array.from(i.cssRules).reduce((function(i,n){return i+n.cssText}),""):i.cssText}));null===(n=null===(i=window.ShadyCSS)||void 0===i?void 0:i.ScopingShim)||void 0===n||n.prepareAdoptedCssText(v,e),void 0===this.constructor.J&&window.ShadyCSS.prepareTemplateStyles(document.createElement("template"),e)}return null!==(t=this.shadowRoot)&&void 0!==t?t:this.attachShadow(this.constructor.shadowRootOptions)};var e=t.connectedCallback;t.connectedCallback=function(){e.call(this),this.hasUpdated&&window.ShadyCSS.styleElement(this)};var v=t.E;t.E=function(i){var n=!this.hasUpdated;v.call(this,i),n&&window.ShadyCSS.styleElement(this)}}})},"function"==typeof define&&define.amd?define(i):i(),function(i){"function"==typeof define&&define.amd?define(i):i()}((function(){
  /**
                      * @license
                      * Copyright 2017 Google LLC
                      * SPDX-License-Identifier: BSD-3-Clause
                      */
  var i,n,o=new Set,t=new Map;null!==(i=(n=globalThis).litHtmlPlatformSupport)&&void 0!==i||(n.litHtmlPlatformSupport=function(i,n){if(void 0!==window.ShadyCSS&&(!window.ShadyCSS.nativeShadow||window.ShadyCSS.ApplyShim)){var d=function(i){var n=t.get(i);return void 0===n&&t.set(i,n=[]),n},e=new Map,v=i.createElement;i.createElement=function(n,o){var t=v.call(i,n,o),e=null==o?void 0:o.scope;if(void 0!==e){window.ShadyCSS.nativeShadow||window.ShadyCSS.prepareTemplateDom(t,e);var u=d(e),f=t.content.querySelectorAll("style");u.push.apply(u,Array.from(f).map((function(i){var n;return null===(n=i.parentNode)||void 0===n||n.removeChild(i),i.textContent})))}return t};var u=document.createDocumentFragment(),f=document.createComment(""),r=n.prototype,w=r.I;r.I=function(i,n){var e,v,r;void 0===n&&(n=this);var s,a=this.A.parentNode,l=null===(e=this.options)||void 0===e?void 0:e.scope;if(a instanceof ShadowRoot&&void 0!==(s=l)&&!o.has(s)){var h=this.A,c=this.B;u.appendChild(f),this.A=f,this.B=null,w.call(this,i,n);var y=(null===(v=i)||void 0===v?void 0:v._$litType$)?this.H.D.el:document.createElement("template");if(function(i,n){var e=d(i),v=0!==e.length;if(v){var u=document.createElement("style");u.textContent=e.join("\n"),n.content.appendChild(u)}o.add(i),t.delete(i),window.ShadyCSS.prepareTemplateStyles(n,i),v&&window.ShadyCSS.nativeShadow&&n.content.appendChild(n.content.querySelector("style"))}(l,y),u.removeChild(f),null===(r=window.ShadyCSS)||void 0===r?void 0:r.nativeShadow){var p=y.content.querySelector("style");null!==p&&u.appendChild(p.cloneNode(!0))}a.insertBefore(u,c),this.A=h,this.B=c}else w.call(this,i,n)},r.C=function(n){var o,t=null===(o=this.options)||void 0===o?void 0:o.scope,d=e.get(t);void 0===d&&e.set(t,d=new Map);var v=d.get(n.strings);return void 0===v&&d.set(n.strings,v=new i(n,this.options)),v}}})})),null!==(n=(o=globalThis).litElementPlatformSupport)&&void 0!==n||(o.litElementPlatformSupport=function(i){var n=i.LitElement;if(void 0!==window.ShadyCSS&&(!window.ShadyCSS.nativeShadow||window.ShadyCSS.ApplyShim)){n.J=!0;var o=n.prototype,t=o.createRenderRoot;o.createRenderRoot=function(){return this.renderOptions.scope=this.localName,t.call(this)}}})},"function"==typeof define&&define.amd?define(i):i()}));
  //# sourceMappingURL=polyfill-support.js.map























  