!function(t){function e(e,n){for(var a=this,o=this.data("options"),i=this.data("inputName"),d=0;len=o.length,len>d;d++)if(o[d].id==e){if(o[d].selected&&!n)return;o[d].selected=!0,this.data("options",o);var l=t("<span />",{"data-id":o[d].id,"data-selected":o[d].selected,"data-token-item":!0,"class":"token-item"});l.html(o[d].html);var s=t("<input />",{type:"hidden",name:i,value:o[d].id});l.append(s);var r=t('<a href="#" data-remove class="token-item-remove">&times;</a>');l.append(r),a.append(l)}return this}t.fn.token=function(n){if("selectOption"==n){var a=Array.prototype.slice.call(arguments,1);return e.apply(this,a)}t.extend({},t.fn.token.defaults,n);return this.each(function(){var e=t(this).attr("name"),n=t(this).attr("id");t(this).hide(),t(this).removeAttr("name"),t(this).removeAttr("id");var a=[];t(this).find("option").each(function(){a.push({id:t(this).attr("value"),html:t(this).html(),selected:t(this).attr("selected")?!0:!1})});var o=t("<span />",{name:e,id:n,"data-token-field":!0,"class":"token-field"});o.data("options",a),o.data("inputName",e),o.data("inputId",n);for(var i=0;len=a.length,len>i;i++)a[i].selected&&o.token("selectOption",a[i].id,!0);var d=t('<input type="text" data-token-input class="token-input" />');t(o).append(d),t(this).after(o)})},t.fn.token.defaults={color:"#556b2f",backgroundColor:"white"},t("[data-token]").token(),t(document).on("click","[data-token-field] [data-remove]",function(){for(var e=t(this).closest("[data-token-item]"),n=t(this).closest("[data-token-field]"),a=n.data("options"),o=0;len=a.length,len>o;o++)a[o].id==e.data("id")&&(a[o].selected=!1);return n.data("options",a),t(this).closest("[data-token-field]").find("[data-token-input]").focus(),t(this).closest("[data-token-item]").remove(),!1}),t(document).on("click","[data-token-item]",function(){return t(this).attr("data-selected",!0).addClass("selected"),!1}),t(document).on("focus","[data-token-input]",function(){t("[data-token-optionList]").remove();var e=t(this),n=e.closest("[data-token-field]"),a=n.data("options"),o={defaultPrevented:!1,preventDefault:function(){o.defaultPrevented=!0},callback:function(n){for(var a=t("<ul />",{"data-token-optionList":!0,"class":"token-optionList"}),o=0;len=n.length,len>o;o++){var i=t("<li />",{"data-value":n[o].id,"data-token-option":!0,"class":"token-option"});n[o].text&&i.text(n[o].text),n[o].html&&i.html(n[o].html),a.append(i)}e.after(a)}};n.trigger("lozenge:fetch",o),0==o.defaultPrevented&&o.callback(a)}),t(document).on("blur","[data-token-input]",function(){setTimeout(function(){t("[data-token-optionList]").remove()},500)}),t(document).on("click","[data-token-option]",function(){return t(this).closest("[data-token-field]").token("selectOption",t(this).data("value")),!1}),t(document).on("keyup","[data-token-input]",function(e){var n=t(this).val();if(""===n)return void t("[data-token-newOption]").remove();var a=t("[data-token-newOption]");if(!a.length)var a=t('<li data-token-newOption class="token-newOption" />').prependTo("[data-token-optionList]");return a.data("value",n),a.html(n),13==e.keyCode?!1:void 0}),t(document).on("click","[data-token-newOption]",function(){var e=t(this).closest("[data-token-field]"),n={value:t(this).data("value"),defaultPrevented:!1,preventDefault:function(){n.defaultPrevented=!0},callback:function(t){var n=e.data("options");n.push({id:t.id,html:t.name,selected:!1}),e.data("options",n),e.token("selectOption",t.id)}};e.trigger("lozenge:store",n)})}(jQuery),$(document.body).removeClass("preload"),$(document).on("lozenge:fetch","[data-tags]",function(t,e){e.preventDefault(),$.get(TAGS_URI,function(t){e.callback(t.map(function(t){return{id:t.id,html:t.name}}))})}),$(document).on("lozenge:store",function(t,e){e.preventDefault(),$.post(TAGS_URI,{tag:{name:e.value}},function(t){e.callback(t.map(function(t){return{id:t.id,html:t.name}}))})});