(()=>{"use strict";var e,t={848:()=>{const e=window.wp.blocks,t=window.wp.i18n,n=window.wp.blockEditor,r=window.wp.components,o=window.ReactJSXRuntime,i=JSON.parse('{"UU":"case-study/case-study"}');(0,e.registerBlockType)(i.UU,{edit:function({attributes:e,setAttributes:i}){const{titleImageUrl:l,content:a}=e;return(0,o.jsxs)("div",{...(0,n.useBlockProps)(),children:[(0,o.jsx)("div",{className:"tab-title",children:(0,o.jsx)(n.MediaUploadCheck,{children:(0,o.jsx)(n.MediaUpload,{onSelect:e=>i({titleImageUrl:e.url}),allowedTypes:["image"],render:({open:e})=>(0,o.jsx)(r.Button,{onClick:e,className:"button",children:l?(0,o.jsx)("img",{src:l,alt:"Tab Title"}):(0,t.__)("Select Image","my-plugin")})})})}),(0,o.jsx)("div",{className:"tab-content",children:(0,o.jsx)(n.RichText,{value:a,onChange:e=>i({content:e}),placeholder:(0,t.__)("Tab Content","my-plugin")})})]})}})}},n={};function r(e){var o=n[e];if(void 0!==o)return o.exports;var i=n[e]={exports:{}};return t[e](i,i.exports,r),i.exports}r.m=t,e=[],r.O=(t,n,o,i)=>{if(!n){var l=1/0;for(d=0;d<e.length;d++){for(var[n,o,i]=e[d],a=!0,s=0;s<n.length;s++)(!1&i||l>=i)&&Object.keys(r.O).every((e=>r.O[e](n[s])))?n.splice(s--,1):(a=!1,i<l&&(l=i));if(a){e.splice(d--,1);var c=o();void 0!==c&&(t=c)}}return t}i=i||0;for(var d=e.length;d>0&&e[d-1][2]>i;d--)e[d]=e[d-1];e[d]=[n,o,i]},r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={665:0,429:0};r.O.j=t=>0===e[t];var t=(t,n)=>{var o,i,[l,a,s]=n,c=0;if(l.some((t=>0!==e[t]))){for(o in a)r.o(a,o)&&(r.m[o]=a[o]);if(s)var d=s(r)}for(t&&t(n);c<l.length;c++)i=l[c],r.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return r.O(d)},n=globalThis.webpackChunknewschannelbd=globalThis.webpackChunknewschannelbd||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})();var o=r.O(void 0,[429],(()=>r(848)));o=r.O(o)})();