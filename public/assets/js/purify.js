!function(e){"use strict";var t="undefined"==typeof window?null:window;"function"==typeof define&&define.amd?define(function(){return e(t)}):"undefined"!=typeof module?module.exports=e(t):t.DOMPurify=e(t)}(function e(t){"use strict";var n=function(t){return e(t)};if(n.version="0.7.4",!t||!t.document||9!==t.document.nodeType)return n.isSupported=!1,n;var r=t.document,o=r,i=t.DocumentFragment,a=t.HTMLTemplateElement,l=t.NodeFilter,s=t.NamedNodeMap||t.MozNamedAttrMap,c=t.Text,u=t.Comment,d=t.DOMParser;if("function"==typeof a){var m=r.createElement("template");m.content&&m.content.ownerDocument&&(r=m.content.ownerDocument)}var p=r.implementation,f=r.createNodeIterator,h=r.getElementsByTagName,g=r.createDocumentFragment,y=o.importNode,b={};n.isSupported=void 0!==p.createHTMLDocument&&9!==r.documentMode;var v=function(e,t){for(var n=t.length;n--;)"string"==typeof t[n]&&(t[n]=t[n].toLowerCase()),e[t[n]]=!0;return e},T=function(e){var t,n={};for(t in e)e.hasOwnProperty(t)&&(n[t]=e[t]);return n},x=null,k=v({},["a","abbr","acronym","address","area","article","aside","audio","b","bdi","bdo","big","blink","blockquote","body","br","button","canvas","caption","center","cite","code","col","colgroup","content","data","datalist","dd","decorator","del","details","dfn","dir","div","dl","dt","element","em","fieldset","figcaption","figure","font","footer","form","h1","h2","h3","h4","h5","h6","head","header","hgroup","hr","html","i","img","input","ins","kbd","label","legend","li","main","map","mark","marquee","menu","menuitem","meter","nav","nobr","ol","optgroup","option","output","p","pre","progress","q","rp","rt","ruby","s","samp","section","select","shadow","small","source","spacer","span","strike","strong","style","sub","summary","sup","table","tbody","td","template","textarea","tfoot","th","thead","time","tr","track","tt","u","ul","var","video","wbr","svg","altglyph","altglyphdef","altglyphitem","animatecolor","animatemotion","animatetransform","circle","clippath","defs","desc","ellipse","filter","font","g","glyph","glyphref","hkern","image","line","lineargradient","marker","mask","metadata","mpath","path","pattern","polygon","polyline","radialgradient","rect","stop","switch","symbol","text","textpath","title","tref","tspan","view","vkern","feBlend","feColorMatrix","feComponentTransfer","feComposite","feConvolveMatrix","feDiffuseLighting","feDisplacementMap","feFlood","feFuncA","feFuncB","feFuncG","feFuncR","feGaussianBlur","feMerge","feMergeNode","feMorphology","feOffset","feSpecularLighting","feTile","feTurbulence","math","menclose","merror","mfenced","mfrac","mglyph","mi","mlabeledtr","mmuliscripts","mn","mo","mover","mpadded","mphantom","mroot","mrow","ms","mpspace","msqrt","mystyle","msub","msup","msubsup","mtable","mtd","mtext","mtr","munder","munderover","#text"]),A=null,w=v({},["accept","action","align","alt","autocomplete","background","bgcolor","border","cellpadding","cellspacing","checked","cite","class","clear","color","cols","colspan","coords","datetime","default","dir","disabled","download","enctype","face","for","headers","height","hidden","high","href","hreflang","id","ismap","label","lang","list","loop","low","max","maxlength","media","method","min","multiple","name","noshade","novalidate","nowrap","open","optimum","pattern","placeholder","poster","preload","pubdate","radiogroup","readonly","rel","required","rev","reversed","rows","rowspan","spellcheck","scope","selected","shape","size","span","srclang","start","src","step","style","summary","tabindex","title","type","usemap","valign","value","width","xmlns","accent-height","accumulate","additivive","alignment-baseline","ascent","attributename","attributetype","azimuth","basefrequency","baseline-shift","begin","bias","by","clip","clip-path","clip-rule","color","color-interpolation","color-interpolation-filters","color-profile","color-rendering","cx","cy","d","dx","dy","diffuseconstant","direction","display","divisor","dur","edgemode","elevation","end","fill","fill-opacity","fill-rule","filter","flood-color","flood-opacity","font-family","font-size","font-size-adjust","font-stretch","font-style","font-variant","font-weight","fx","fy","g1","g2","glyph-name","glyphref","gradientunits","gradienttransform","image-rendering","in","in2","k","k1","k2","k3","k4","kerning","keypoints","keysplines","keytimes","lengthadjust","letter-spacing","kernelmatrix","kernelunitlength","lighting-color","local","marker-end","marker-mid","marker-start","markerheight","markerunits","markerwidth","maskcontentunits","maskunits","max","mask","mode","min","numoctaves","offset","operator","opacity","order","orient","orientation","origin","overflow","paint-order","path","pathlength","patterncontentunits","patterntransform","patternunits","points","preservealpha","r","rx","ry","radius","refx","refy","repeatcount","repeatdur","restart","result","rotate","scale","seed","shape-rendering","specularconstant","specularexponent","spreadmethod","stddeviation","stitchtiles","stop-color","stop-opacity","stroke-dasharray","stroke-dashoffset","stroke-linecap","stroke-linejoin","stroke-miterlimit","stroke-opacity","stroke","stroke-width","surfacescale","targetx","targety","transform","text-anchor","text-decoration","text-rendering","textlength","u1","u2","unicode","values","viewbox","visibility","vert-adv-y","vert-origin-x","vert-origin-y","word-spacing","wrap","writing-mode","xchannelselector","ychannelselector","x","x1","x2","y","y1","y2","z","zoomandpan","accent","accentunder","bevelled","close","columnsalign","columnlines","columnspan","denomalign","depth","display","displaystyle","fence","frame","largeop","length","linethickness","lspace","lquote","mathbackground","mathcolor","mathsize","mathvariant","maxsize","minsize","movablelimits","notation","numalign","open","rowalign","rowlines","rowspacing","rowspan","rspace","rquote","scriptlevel","scriptminsize","scriptsizemultiplier","selection","separator","separators","stretchy","subscriptshift","supscriptshift","symmetric","voffset","xlink:href","xml:id","xlink:title","xml:space","xmlns:xlink"]),E=null,S=null,M=!0,O=!1,L=!1,D=!1,N=/\{\{[\s\S]*|[\s\S]*\}\}/gm,_=/<%[\s\S]*|[\s\S]*%>/gm,C=!1,z=!1,R=!1,F=!1,H=!0,B=!0,W=v({},["audio","head","math","script","style","svg","video"]),j=v({},["audio","video","img","source"]),G=v({},["alt","class","for","id","label","name","pattern","placeholder","summary","title","value","style","xmlns"]),I=null,q=r.createElement("form"),P=function(e){try{e.parentNode.removeChild(e)}catch(t){e.outerHTML=""}},U=function(e){return f.call(e.ownerDocument||e,e,l.SHOW_ELEMENT|l.SHOW_COMMENT|l.SHOW_TEXT,function(){return l.FILTER_ACCEPT},!1)},V=function(e){var t,n,r;if($("beforeSanitizeElements",e,null),!((r=e)instanceof c||r instanceof u||"string"==typeof r.nodeName&&"string"==typeof r.textContent&&"function"==typeof r.removeChild&&r.attributes instanceof s&&"function"==typeof r.removeAttribute&&"function"==typeof r.setAttribute))return P(e),!0;if(t=e.nodeName.toLowerCase(),$("uponSanitizeElement",e,{tagName:t}),!x[t]||E[t]){if(B&&!W[t]&&"function"==typeof e.insertAdjacentHTML)try{e.insertAdjacentHTML("AfterEnd",e.innerHTML)}catch(e){}return P(e),!0}return!L||e.firstElementChild||e.content&&e.content.firstElementChild||(e.innerHTML=e.textContent.replace(/</g,"&lt;")),D&&3===e.nodeType&&(n=(n=(n=e.textContent).replace(N," ")).replace(_," "),e.textContent=n),$("afterSanitizeElements",e,null),!1},K=/^data-[\w.\u00B7-\uFFFF-]/,J=/^(?:(?:(?:f|ht)tps?|mailto|tel):|[^a-z]|[a-z+.\-]+(?:[^a-z+.\-:]|$))/i,Q=/^(?:\w+script|data):/i,X=/[\x00-\x20\xA0\u1680\u180E\u2000-\u2029\u205f\u3000]/g,Y=function(e){var n,o,i,a,l,s,c,u;if($("beforeSanitizeAttributes",e,null),s=e.attributes){for(c={attrName:"",attrValue:"",keepAttr:!0},u=s.length;u--;)if(o=(n=s[u]).name,i=n.value,a=o.toLowerCase(),c.attrName=a,c.attrValue=i,c.keepAttr=!0,$("uponSanitizeAttribute",e,c),i=c.attrValue,"name"===a&&"IMG"===e.nodeName&&s.id?(l=s.id,s=Array.prototype.slice.apply(s),e.removeAttribute("id"),e.removeAttribute(o),s.indexOf(l)>u&&e.setAttribute("id",l.value)):("id"===o&&e.setAttribute(o,""),e.removeAttribute(o)),c.keepAttr&&(!H||"id"!==a&&"name"!==a||!(i in t||i in r||i in q))&&(D&&(i=(i=i.replace(N," ")).replace(_," ")),A[a]&&!S[a]&&(G[a]||J.test(i.replace(X,""))||"src"===a&&0===i.indexOf("data:")&&j[e.nodeName.toLowerCase()])||M&&K.test(a)||O&&!Q.test(i.replace(X,""))))try{e.setAttribute(o,i)}catch(e){}$("afterSanitizeAttributes",e,null)}},Z=function(e){var t,n=U(e);for($("beforeSanitizeShadowDOM",e,null);t=n.nextNode();)$("uponSanitizeShadowNode",t,null),V(t)||(t.content instanceof i&&Z(t.content),Y(t));$("afterSanitizeShadowDOM",e,null)},$=function(e,t,r){b[e]&&b[e].forEach(function(e){e.call(n,t,r,I)})};return n.sanitize=function(e,r){var a,l,s,c,u;if(e||(e=""),"string"!=typeof e){if("function"!=typeof e.toString)throw new TypeError("toString is not a function");e=e.toString()}if(!n.isSupported)return"object"==typeof t.toStaticHTML||"function"==typeof t.toStaticHTML?t.toStaticHTML(e):e;if(function(e){"object"!=typeof e&&(e={}),x="ALLOWED_TAGS"in e?v({},e.ALLOWED_TAGS):k,A="ALLOWED_ATTR"in e?v({},e.ALLOWED_ATTR):w,E="FORBID_TAGS"in e?v({},e.FORBID_TAGS):{},S="FORBID_ATTR"in e?v({},e.FORBID_ATTR):{},M=!1!==e.ALLOW_DATA_ATTR,O=e.ALLOW_UNKNOWN_PROTOCOLS||!1,L=e.SAFE_FOR_JQUERY||!1,D=e.SAFE_FOR_TEMPLATES||!1,C=e.WHOLE_DOCUMENT||!1,z=e.RETURN_DOM||!1,R=e.RETURN_DOM_FRAGMENT||!1,F=e.RETURN_DOM_IMPORT||!1,H=!1!==e.SANITIZE_DOM,B=!1!==e.KEEP_CONTENT,D&&(M=!1),R&&(z=!0),e.ADD_TAGS&&(x===k&&(x=T(x)),v(x,e.ADD_TAGS)),e.ADD_ATTR&&(A===w&&(A=T(A)),v(A,e.ADD_ATTR)),B&&(x["#text"]=!0),Object&&"freeze"in Object&&Object.freeze(e),I=e}(r),!z&&!C&&-1===e.indexOf("<"))return e;if(!(a=function(e){var t,n;try{t=(new d).parseFromString(e,"text/html")}catch(e){}return t||((n=(t=p.createHTMLDocument("")).body).parentNode.removeChild(n.parentNode.firstElementChild),n.outerHTML=e),"function"==typeof t.getElementsByTagName?t.getElementsByTagName(C?"html":"body")[0]:h.call(t,C?"html":"body")[0]}(e)))return z?null:"";for(c=U(a);l=c.nextNode();)3===l.nodeType&&l===s||V(l)||(l.content instanceof i&&Z(l.content),Y(l),s=l);if(z){if(R)for(u=g.call(a.ownerDocument);a.firstChild;)u.appendChild(a.firstChild);else u=a;return F&&(u=y.call(o,u,!0)),u}return C?a.outerHTML:a.innerHTML},n.addHook=function(e,t){"function"==typeof t&&(b[e]=b[e]||[],b[e].push(t))},n.removeHook=function(e){b[e]&&b[e].pop()},n.removeHooks=function(e){b[e]&&(b[e]=[])},n.removeAllHooks=function(){b=[]},n});