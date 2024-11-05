/**
 * @license RequireJS domReady 2.0.0 Copyright (c) 2010-2012, The Dojo Foundation All Rights Reserved.
 * Available via the MIT or new BSD license.
 * see: http://github.com/requirejs/domReady for details
 */

timely.define("domReady",[],function(){function u(e){var t;for(t=0;t<e.length;t++)e[t](n)}function a(){var e=r;t&&e.length&&(r=[],u(e))}function f(){t||(t=!0,o&&clearInterval(o),a())}function c(e){return t?e(n):r.push(e),c}var e=typeof window!="undefined"&&window.document,t=!e,n=e?document:null,r=[],i,s,o;if(e){if(document.addEventListener)document.addEventListener("DOMContentLoaded",f,!1),window.addEventListener("load",f,!1);else if(window.attachEvent){window.attachEvent("onload",f),s=document.createElement("div");try{i=window.frameElement===null}catch(l){}s.doScroll&&i&&window.external&&(o=setInterval(function(){try{s.doScroll(),f()}catch(e){}},30))}(document.readyState==="complete"||document.readyState==="interactive")&&f()}return c.version="2.0.0",c.load=function(e,t,n,r){r.isBuild?n(null):c(n)},c}),timely.define("external_libs/colorpicker",["jquery_timely"],function(e){var t=function(){var t={},n,r=65,i,s='<div class="colorpicker"><div class="colorpicker_color"><div><div></div></div></div><div class="colorpicker_hue"><div></div></div><div class="colorpicker_new_color"></div><div class="colorpicker_current_color"></div><div class="colorpicker_hex"><input type="text" maxlength="6" size="6" /></div><div class="colorpicker_rgb_r colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_g colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_h colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_s colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_submit"></div></div>',o={eventName:"click",onShow:function(){},onBeforeShow:function(){},onHide:function(){},onChange:function(){},onSubmit:function(){},color:"ff0000",livePreview:!0,flat:!1},u=function(t,n){var r=q(t);e(n).data("colorpicker").fields.eq(1).val(r.r).end().eq(2).val(r.g).end().eq(3).val(r.b).end()},a=function(t,n){e(n).data("colorpicker").fields.eq(4).val(t.h).end().eq(5).val(t.s).end().eq(6).val(t.b).end()},f=function(t,n){e(n).data("colorpicker").fields.eq(0).val(U(t)).end()},l=function(t,n){e(n).data("colorpicker").selector.css("backgroundColor","#"+U({h:t.h,s:100,b:100})),e(n).data("colorpicker").selectorIndic.css({left:parseInt(150*t.s/100,10),top:parseInt(150*(100-t.b)/100,10)})},c=function(t,n){e(n).data("colorpicker").hue.css("top",parseInt(150-150*t.h/360,10))},h=function(t,n){e(n).data("colorpicker").currentColor.css("backgroundColor","#"+U(t))},p=function(t,n){e(n).data("colorpicker").newColor.css("backgroundColor","#"+U(t))},d=function(t){var n=t.charCode||t.keyCode||-1;if(n>r&&n<=90||n==32)return!1;var i=e(this).parent().parent();i.data("colorpicker").livePreview===!0&&v.apply(this)},v=function(t){var n=e(this).parent().parent(),r;this.parentNode.className.indexOf("_hex")>0?n.data("colorpicker").color=r=F(B(this.value)):this.parentNode.className.indexOf("_hsb")>0?n.data("colorpicker").color=r=P({h:parseInt(n.data("colorpicker").fields.eq(4).val(),10),s:parseInt(n.data("colorpicker").fields.eq(5).val(),10),b:parseInt(n.data("colorpicker").fields.eq(6).val(),10)}):n.data("colorpicker").color=r=I(H({r:parseInt(n.data("colorpicker").fields.eq(1).val(),10),g:parseInt(n.data("colorpicker").fields.eq(2).val(),10),b:parseInt(n.data("colorpicker").fields.eq(3).val(),10)})),t&&(u(r,n.get(0)),f(r,n.get(0)),a(r,n.get(0))),l(r,n.get(0)),c(r,n.get(0)),p(r,n.get(0)),n.data("colorpicker").onChange.apply(n,[r,U(r),q(r)])},m=function(t){var n=e(this).parent().parent();n.data("colorpicker").fields.parent().removeClass("colorpicker_focus")},g=function(){r=this.parentNode.className.indexOf("_hex")>0?70:65,e(this).parent().parent().data("colorpicker").fields.parent().removeClass("colorpicker_focus"),e(this).parent().addClass("colorpicker_focus")},y=function(t){var n=e(this).parent().find("input").focus(),r={el:e(this).parent().addClass("colorpicker_slider"),max:this.parentNode.className.indexOf("_hsb_h")>0?360:this.parentNode.className.indexOf("_hsb")>0?100:255,y:t.pageY,field:n,val:parseInt(n.val(),10),preview:e(this).parent().parent().data("colorpicker").livePreview};e(document).bind("mouseup",r,w),e(document).bind("mousemove",r,b)},b=function(e){return e.data.field.val(Math.max(0,Math.min(e.data.max,parseInt(e.data.val+e.pageY-e.data.y,10)))),e.data.preview&&v.apply(e.data.field.get(0),[!0]),!1},w=function(t){return v.apply(t.data.field.get(0),[!0]),t.data.el.removeClass("colorpicker_slider").find("input").focus(),e(document).unbind("mouseup",w),e(document).unbind("mousemove",b),!1},E=function(t){var n={cal:e(this).parent(),y:e(this).offset().top};n.preview=n.cal.data("colorpicker").livePreview,e(document).bind("mouseup",n,x),e(document).bind("mousemove",n,S)},S=function(e){return v.apply(e.data.cal.data("colorpicker").fields.eq(4).val(parseInt(360*(150-Math.max(0,Math.min(150,e.pageY-e.data.y)))/150,10)).get(0),[e.data.preview]),!1},x=function(t){return u(t.data.cal.data("colorpicker").color,t.data.cal.get(0)),f(t.data.cal.data("colorpicker").color,t.data.cal.get(0)),e(document).unbind("mouseup",x),e(document).unbind("mousemove",S),!1},T=function(t){var n={cal:e(this).parent(),pos:e(this).offset()};n.preview=n.cal.data("colorpicker").livePreview,e(document).bind("mouseup",n,C),e(document).bind("mousemove",n,N)},N=function(e){return v.apply(e.data.cal.data("colorpicker").fields.eq(6).val(parseInt(100*(150-Math.max(0,Math.min(150,e.pageY-e.data.pos.top)))/150,10)).end().eq(5).val(parseInt(100*Math.max(0,Math.min(150,e.pageX-e.data.pos.left))/150,10)).get(0),[e.data.preview]),!1},C=function(t){return u(t.data.cal.data("colorpicker").color,t.data.cal.get(0)),f(t.data.cal.data("colorpicker").color,t.data.cal.get(0)),e(document).unbind("mouseup",C),e(document).unbind("mousemove",N),!1},k=function(t){e(this).addClass("colorpicker_focus")},L=function(t){e(this).removeClass("colorpicker_focus")},A=function(t){var n=e(this).parent(),r=n.data("colorpicker").color;n.data("colorpicker").origColor=r,h(r,n.get(0)),n.data("colorpicker").onSubmit(r,U(r),q(r),n.data("colorpicker").el)},O=function(t){var n=e("#"+e(this).data("colorpickerId"));n.data("colorpicker").onBeforeShow.apply(this,[n.get(0)]);var r=e(this).offset(),i=D(),s=e("#tag-color").offset(),o=s.top+e("#tag-color").height(),u=s.left+1;return n.css({left:u+"px",top:o+"px"}),n.data("colorpicker").onShow.apply(this,[n.get(0)])!=0&&n.show(),e(document).bind("mousedown",{cal:n},M),!1},M=function(t){_(t.data.cal.get(0),t.target,t.data.cal.get(0))||(t.data.cal.data("colorpicker").onHide.apply(this,[t.data.cal.get(0)])!=0&&t.data.cal.hide(),e(document).unbind("mousedown",M))},_=function(e,t,n){if(e==t)return!0;if(e.contains)return e.contains(t);if(e.compareDocumentPosition)return!!(e.compareDocumentPosition(t)&16);var r=t.parentNode;while(r&&r!=n){if(r==e)return!0;r=r.parentNode}return!1},D=function(){var e=document.compatMode=="CSS1Compat";return{l:window.pageXOffset||(e?document.documentElement.scrollLeft:document.body.scrollLeft),t:window.pageYOffset||(e?document.documentElement.scrollTop:document.body.scrollTop),w:window.innerWidth||(e?document.documentElement.clientWidth:document.body.clientWidth),h:window.innerHeight||(e?document.documentElement.clientHeight:document.body.clientHeight)}},P=function(e){return{h:Math.min(360,Math.max(0,e.h)),s:Math.min(100,Math.max(0,e.s)),b:Math.min(100,Math.max(0,e.b))}},H=function(e){return{r:Math.min(255,Math.max(0,e.r)),g:Math.min(255,Math.max(0,e.g)),b:Math.min(255,Math.max(0,e.b))}},B=function(e){var t=6-e.length;if(t>0){var n=[];for(var r=0;r<t;r++)n.push("0");n.push(e),e=n.join("")}return e},j=function(e){var e=parseInt(e.indexOf("#")>-1?e.substring(1):e,16);return{r:e>>16,g:(e&65280)>>8,b:e&255}},F=function(e){return I(j(e))},I=function(e){var t={h:0,s:0,b:0},n=Math.min(e.r,e.g,e.b),r=Math.max(e.r,e.g,e.b),i=r-n;return t.b=r,r!=0,t.s=r!=0?255*i/r:0,t.s!=0?e.r==r?t.h=(e.g-e.b)/i:e.g==r?t.h=2+(e.b-e.r)/i:t.h=4+(e.r-e.g)/i:t.h=-1,t.h*=60,t.h<0&&(t.h+=360),t.s*=100/255,t.b*=100/255,t},q=function(e){var t={},n=Math.round(e.h),r=Math.round(e.s*255/100),i=Math.round(e.b*255/100);if(r==0)t.r=t.g=t.b=i;else{var s=i,o=(255-r)*i/255,u=(s-o)*(n%60)/60;n==360&&(n=0),n<60?(t.r=s,t.b=o,t.g=o+u):n<120?(t.g=s,t.b=o,t.r=s-u):n<180?(t.g=s,t.r=o,t.b=o+u):n<240?(t.b=s,t.r=o,t.g=s-u):n<300?(t.b=s,t.g=o,t.r=o+u):n<360?(t.r=s,t.g=o,t.b=s-u):(t.r=0,t.g=0,t.b=0)}return{r:Math.round(t.r),g:Math.round(t.g),b:Math.round(t.b)}},R=function(t){var n=[t.r.toString(16),t.g.toString(16),t.b.toString(16)];return e.each(n,function(e,t){t.length==1&&(n[e]="0"+t)}),n.join("")},U=function(e){return R(q(e))},z=function(){var t=e(this).parent(),n=t.data("colorpicker").origColor;t.data("colorpicker").color=n,u(n,t.get(0)),f(n,t.get(0)),a(n,t.get(0)),l(n,t.get(0)),c(n,t.get(0)),p(n,t.get(0))};return{init:function(t){t=e.extend({},o,t||{});if(typeof t.color=="string")t.color=F(t.color);else if(t.color.r!=undefined&&t.color.g!=undefined&&t.color.b!=undefined)t.color=I(t.color);else{if(t.color.h==undefined||t.color.s==undefined||t.color.b==undefined)return this;t.color=P(t.color)}return this.each(function(){if(!e(this).data("colorpickerId")){var n=e.extend({},t);n.origColor=t.color;var r="collorpicker_"+parseInt(Math.random()*1e3);e(this).data("colorpickerId",r);var i=e(s).attr("id",r);n.flat?i.appendTo(this).show():i.appendTo(document.body),n.fields=i.find("input").bind("keyup",d).bind("change",v).bind("blur",m).bind("focus",g),i.find("span").bind("mousedown",y).end().find(">div.colorpicker_current_color").bind("click",z),n.selector=i.find("div.colorpicker_color").bind("mousedown",T),n.selectorIndic=n.selector.find("div div"),n.el=this,n.hue=i.find("div.colorpicker_hue div"),i.find("div.colorpicker_hue").bind("mousedown",E),n.newColor=i.find("div.colorpicker_new_color"),n.currentColor=i.find("div.colorpicker_current_color"),i.data("colorpicker",n),i.find("div.colorpicker_submit").bind("mouseenter",k).bind("mouseleave",L).bind("click",A),u(n.color,i.get(0)),a(n.color,i.get(0)),f(n.color,i.get(0)),c(n.color,i.get(0)),l(n.color,i.get(0)),h(n.color,i.get(0)),p(n.color,i.get(0)),n.flat?i.css({position:"relative",display:"block"}):e(this).bind(n.eventName,O)}})},showPicker:function(){return this.each(function(){e(this).data("colorpickerId")&&O.apply(this)})},hidePicker:function(){return this.each(function(){e(this).data("colorpickerId")&&e("#"+e(this).data("colorpickerId")).hide()})},setColor:function(t){if(typeof t=="string")t=F(t);else if(t.r!=undefined&&t.g!=undefined&&t.b!=undefined)t=I(t);else{if(t.h==undefined||t.s==undefined||t.b==undefined)return this;t=P(t)}return this.each(function(){if(e(this).data("colorpickerId")){var n=e("#"+e(this).data("colorpickerId"));n.data("colorpicker").color=t,n.data("colorpicker").origColor=t,u(t,n.get(0)),a(t,n.get(0)),f(t,n.get(0)),c(t,n.get(0)),l(t,n.get(0)),h(t,n.get(0)),p(t,n.get(0))}})}}}();e.fn.extend({ColorPicker:t.init,ColorPickerHide:t.hidePicker,ColorPickerShow:t.showPicker,ColorPickerSetColor:t.setColor})}),timely.define("scripts/event_category",["jquery_timely","ai1ec_config","domReady","external_libs/colorpicker"],function(e,t,n){var r,i=function(n){n.preventDefault(),typeof r=="undefined"&&(r=wp.media.frames.file_frame=wp.media({title:t.choose_image_message,button:{text:t.choose_image_message},multiple:!1}),r.on("select",function(){var t=r.state().get("selection").first().toJSON();e("#osec_category_imag_preview").attr("src",t.url),e("#osec_category_image_url").val(t.url)})),r.open()};e("#tag-color").click(function(){var t=e("#tag-color").offset(),n=t.top+e("#tag-color").height(),r=t.left+1,i=e('<ul class="timely colorpicker-list"></ul>'),o=e('<li class="ai1ec-btn ai1ec-btn-xs ai1ec-btn-default ai1ec-btn-block"><i class="ai1ec-fa ai1ec-fa-ellipsis-h ai1ec-fa-lg"></i></li>'),a="",f;for(f=1;f<=32;f++)a+='<li class="color-'+f+'"></li>';a=e(a),o.ColorPicker({onSubmit:function(t,n,r,s){e("#tag-color-background").css("background-color","#"+n),e("#tag-color-value").val("#"+n),e(s).ColorPickerHide(),i.remove()},onBeforeShow:function(){i.hide(),e(document).unbind("mousedown",u);var t=e("#tag-color-value").val();t=t.length>0?t:"#ffffff",e(this).ColorPickerSetColor(t)}}),a.click(function(){var t=e(this).css("background-color");t="rgba(0, 0, 0, 0)"===t?"":s(t),e("#tag-color-background").css("background-color",t),e("#tag-color-value").val(t),i.remove()}),i.append(a).append(o),i.appendTo("body").css({top:n+"px",left:r+"px"}),e(document).bind("mousedown",{ls:i},u)}),e("#tag-color-value-remove").click(function(){e("#tag-color-background").css("background-color",""),e("#tag-color-value").val("")});var s=function(e){return e=e.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/),"#"+o(e[1])+o(e[2])+o(e[3])},o=function(e){return("0"+parseInt(e,10).toString(16)).slice(-2)},u=function(t){a(t.data.ls.get(0),t.target,t.data.ls.get(0))||(e(t.data.ls.get(0)).remove(),e(document).unbind("mousedown",u))},a=function(e,t,n){if(e===t)return!0;if(e.contains)return e.contains(t);if(e.compareDocumentPosition)return!!(e.compareDocumentPosition(t)&16);var r=t.parentNode;while(r&&r!==n){if(r===e)return!0;r=r.parentNode}return!1},f=function(){n(function(){e("#osec_category_image_uploader").click(i);var t=e("#osec_category_imag_preview").attr("src");t&&t.length>0&&e("#osec_category_image_url").val(t)})};return{start:f}}),timely.require(["scripts/event_category"],function(e){e.start()}),timely.define("pages/event_category",function(){});
