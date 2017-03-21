/*
	*mpanel
*/

//Switchery
(function(){function require(path,parent,orig){var resolved=require.resolve(path);if(null==resolved){orig=orig||path;parent=parent||"root";var err=new Error('Failed to require "'+orig+'" from "'+parent+'"');err.path=orig;err.parent=parent;err.require=true;throw err}var module=require.modules[resolved];if(!module._resolving&&!module.exports){var mod={};mod.exports={};mod.client=mod.component=true;module._resolving=true;module.call(this,mod.exports,require.relative(resolved),mod);delete module._resolving;module.exports=mod.exports}return module.exports}require.modules={};require.aliases={};require.resolve=function(path){if(path.charAt(0)==="/")path=path.slice(1);var paths=[path,path+".js",path+".json",path+"/index.js",path+"/index.json"];for(var i=0;i<paths.length;i++){var path=paths[i];if(require.modules.hasOwnProperty(path))return path;if(require.aliases.hasOwnProperty(path))return require.aliases[path]}};require.normalize=function(curr,path){var segs=[];if("."!=path.charAt(0))return path;curr=curr.split("/");path=path.split("/");for(var i=0;i<path.length;++i){if(".."==path[i]){curr.pop()}else if("."!=path[i]&&""!=path[i]){segs.push(path[i])}}return curr.concat(segs).join("/")};require.register=function(path,definition){require.modules[path]=definition};require.alias=function(from,to){if(!require.modules.hasOwnProperty(from)){throw new Error('Failed to alias "'+from+'", it does not exist')}require.aliases[to]=from};require.relative=function(parent){var p=require.normalize(parent,"..");function lastIndexOf(arr,obj){var i=arr.length;while(i--){if(arr[i]===obj)return i}return-1}function localRequire(path){var resolved=localRequire.resolve(path);return require(resolved,parent,path)}localRequire.resolve=function(path){var c=path.charAt(0);if("/"==c)return path.slice(1);if("."==c)return require.normalize(p,path);var segs=parent.split("/");var i=lastIndexOf(segs,"deps")+1;if(!i)i=0;path=segs.slice(0,i+1).join("/")+"/deps/"+path;return path};localRequire.exists=function(path){return require.modules.hasOwnProperty(localRequire.resolve(path))};return localRequire};require.register("abpetkov-transitionize/transitionize.js",function(exports,require,module){module.exports=Transitionize;function Transitionize(element,props){if(!(this instanceof Transitionize))return new Transitionize(element,props);this.element=element;this.props=props||{};this.init()}Transitionize.prototype.isSafari=function(){return/Safari/.test(navigator.userAgent)&&/Apple Computer/.test(navigator.vendor)};Transitionize.prototype.init=function(){var transitions=[];for(var key in this.props){transitions.push(key+" "+this.props[key])}this.element.style.transition=transitions.join(", ");if(this.isSafari())this.element.style.webkitTransition=transitions.join(", ")}});require.register("switchery/switchery.js",function(exports,require,module){var transitionize=require("transitionize");module.exports=Switchery;var defaults={color:"#64bd63",secondaryColor:"#dfdfdf",className:"switchery",disabled:false,disabledOpacity:.5,speed:"0.4s"};function Switchery(element,options){if(!(this instanceof Switchery))return new Switchery(element,options);this.element=element;this.options=options||{};for(var i in defaults){if(this.options[i]==null){this.options[i]=defaults[i]}}if(this.element.type=="checkbox")this.init()}Switchery.prototype.hide=function(){this.element.style.display="none"};Switchery.prototype.show=function(){var switcher=this.create();this.insertAfter(this.element,switcher)};Switchery.prototype.create=function(){this.switcher=document.createElement("span");this.jack=document.createElement("small");this.switcher.appendChild(this.jack);this.switcher.className=this.options.className;return this.switcher};Switchery.prototype.insertAfter=function(reference,target){reference.parentNode.insertBefore(target,reference.nextSibling)};Switchery.prototype.isChecked=function(){return this.element.checked};Switchery.prototype.isDisabled=function(){return this.options.disabled||this.element.disabled};Switchery.prototype.setPosition=function(clicked){var checked=this.isChecked(),switcher=this.switcher,jack=this.jack;if(clicked&&checked)checked=false;else if(clicked&&!checked)checked=true;if(checked===true){this.element.checked=true;if(window.getComputedStyle)jack.style.left=parseInt(window.getComputedStyle(switcher).width)-jack.offsetWidth+"px";else jack.style.left=parseInt(switcher.currentStyle["width"])-jack.offsetWidth+"px";if(this.options.color)this.colorize();this.setSpeed()}else{jack.style.left=0;this.element.checked=false;this.switcher.style.boxShadow="inset 0 0 0 0 "+this.options.secondaryColor;this.switcher.style.borderColor=this.options.secondaryColor;this.switcher.style.backgroundColor="";this.setSpeed()}};Switchery.prototype.setSpeed=function(){var switcherProp={},jackProp={left:this.options.speed.replace(/[a-z]/,"")/2+"s"};if(this.isChecked()){switcherProp={border:this.options.speed,"box-shadow":this.options.speed,"background-color":this.options.speed.replace(/[a-z]/,"")*3+"s"}}else{switcherProp={border:this.options.speed,"box-shadow":this.options.speed}}transitionize(this.switcher,switcherProp);transitionize(this.jack,jackProp)};Switchery.prototype.setAttributes=function(){var id=this.element.getAttribute("id"),name=this.element.getAttribute("name");if(id)this.switcher.setAttribute("id",id);if(name)this.switcher.setAttribute("name",name)};Switchery.prototype.colorize=function(){this.switcher.style.backgroundColor=this.options.color;this.switcher.style.borderColor=this.options.color;this.switcher.style.boxShadow="inset 0 0 0 16px "+this.options.color};Switchery.prototype.handleOnchange=function(state){var evt=new Event("click");this.element.dispatchEvent(evt);if(typeof Event==="function"){var event=new Event("change",{cancelable:true});this.element.dispatchEvent(event)}else{this.element.fireEvent("onchange")}};Switchery.prototype.handleClick=function(){var self=this,switcher=this.switcher;if(this.isDisabled()===false){if(switcher.addEventListener){switcher.addEventListener("click",function(){self.setPosition(true);self.handleOnchange(self.element.checked)})}else{switcher.attachEvent("onclick",function(){self.setPosition(true);self.handleOnchange(self.element.checked)})}}else{this.element.disabled=true;this.switcher.style.opacity=this.options.disabledOpacity}};Switchery.prototype.init=function(){this.hide();this.show();this.setPosition();this.setAttributes();this.handleClick()}});require.alias("abpetkov-transitionize/transitionize.js","switchery/deps/transitionize/transitionize.js");require.alias("abpetkov-transitionize/transitionize.js","switchery/deps/transitionize/index.js");require.alias("abpetkov-transitionize/transitionize.js","transitionize/index.js");require.alias("abpetkov-transitionize/transitionize.js","abpetkov-transitionize/index.js");require.alias("switchery/switchery.js","switchery/index.js");if(typeof exports=="object"){module.exports=require("switchery")}else if(typeof define=="function"&&define.amd){define(function(){return require("switchery")})}else{this["Switchery"]=require("switchery")}})();

//cxCalendar
!function(a){a.fn.cxCalendar=function(b,c){var d,e,f,g,h,i,j,k,m,n,o,p,q,r,s,t,u,v,w,x,y,z;if(!(this.length<1)){for(d={},e=d.jqobj=this,f=d.fun={},b=a.extend({},a.cxCalendar.defaults,b,{beginyear:e.data("beginyear"),endyear:e.data("endyear"),type:e.data("type"),hyphen:e.data("hyphen"),wday:e.data("wday")}),c=a.extend({},a.cxCalendar.language,c),h=function(a){var b=a;return b=b.replace(/\./g,"/"),b=b.replace(/-/g,"/"),b=b.replace(/\//g,"/"),b=Date.parse(b)},i=function(a){return 0==a%4&&0!=a%100||0==a%400?1:0},e.val().length>0&&(b.date=h(e.val())),b.date=new Date(b.date),isNaN(b.date.getFullYear())&&(b.date=new Date),b.date.setHours(0),b.date.setMinutes(0),b.date.setSeconds(0),j=b.date.getFullYear(),k=b.date.getMonth()+1,b.date.getDate(),m=new Array(31,28+i(j),31,30,31,30,31,31,30,31,30,31),n=c.weekList,o=6-b.wday,p=7-b.wday>=7?0:7-b.wday,q=a("<div></div>",{"class":"cxcalendar"}),r=a("<div></div>",{"class":"date_hd"}).appendTo(q),t=a("<table></table>").appendTo(q),r.html("<a class='date_pre' href='javascript://' rel='pre'>&lt;</a><a class='date_next' href='javascript://' rel='next'>&gt;</a>"),w=a("<div></div>",{"class":"date_txt"}).appendTo(r),s=a("<div></div>",{"class":"date_set"}).appendTo(r),v="",z=b.beginyear;z<=b.endyear;z++)v+="<option value='"+z+"'>"+z+"</option>";for(x=a("<select></select>",{"class":"year_set"}).html(v).appendTo(s).val(j),s.append(" - "),v="",z=0;12>z;z++)v+="<option value='"+(z+1)+"'>"+c.monthList[z]+"</option>";for(y=a("<select></select>",{"class":"month_set"}).html(v).appendTo(s).val(k),v="<thead><tr>",z=0;7>z;z++)v+="<th class='",z==o?v+=" sat":z==p&&(v+=" sun"),v+="'>",v+=z+b.wday<7?n[z+b.wday]:n[z+b.wday-7],v+="</th>";return v+="</tr></thead>",v+="<tbody></tbody>",t.html(v),q.appendTo("body"),u=a("<div></div>",{"class":"cxcalendar_lock"}).appendTo("body"),f.show=function(){var a=document.body.clientWidth,b=document.body.clientHeight,d=q.outerWidth(),f=q.outerHeight(),g=e.offset().top,h=e.offset().left,i=e.outerWidth(),j=e.outerHeight();return g=g+f+j>b?g-f:g+j,h=h+d>a?h-(d-i):h,w.html("<span class='y'>"+x.val()+"</span>"+c.year+"<span class='m'>"+c.monthList[y.val()-1]+"</span>"+c.month),q.css({top:g,left:h}).show(),u.css({width:a,height:b}).show(),this},f.hide=function(){return q.hide(),u.hide(),s.hide(),w.show(),this},f.change=function(a,d){var f,g,j,k,l,n,q,r,s,u,z,A;for(1>d?(a--,d=12):d>12&&(a++,d=1),f=d,d--,a<b.beginyear?a=b.endyear:a>b.endyear&&(a=b.beginyear),m[1]=28+i(a),v="",g=new Date(a,d,1),j=new Date,j.setHours(0),j.setMinutes(0),j.setSeconds(0),k=new Date,k.setHours(0),k.setMinutes(0),k.setSeconds(0),k=h(e.val()),k=new Date(k),isNaN(k.getFullYear())&&(k=null),l=g.getDay()-b.wday<0?g.getDay()-b.wday+7:g.getDay()-b.wday,n=Math.ceil((m[d]+l)/7),z=0;n>z;z++){for(v+="<tr>",A=0;7>A;A++)q=7*z+A,r=q-l+1,r=0>=r||r>m[d]?"":q-l+1,v+="<td","number"==typeof r&&(s=null,u=null,g=new Date(a,d,r),s=Date.parse(j)-Date.parse(g),u=Date.parse(k)-Date.parse(g),v+=" title='"+a+b.hyphen+f+b.hyphen+r+"' class='num",0==u?v+=" selected":0==s?v+=" now":A==o?v+=" sat":A==p&&(v+=" sun"),v+="'"),v+=" data-day='"+r+"'>"+r+"</td>";v+="</tr>"}return t.find("tbody").html(v),w.html("<span class='y'>"+a+"</span>"+c.year+"<span class='m'>"+c.monthList[d]+"</span>"+c.month),x.val(a),y.val(d+1),this},f.selected=function(a){var c,d;return c=y.val(),d=a,"yyyy-mm-dd"==b.type&&(c="0"+y.val(),d="0"+a,c=c.substr(c.length-2,c.length),d=d.substr(d.length-2,d.length)),e.val(x.val()+b.hyphen+c+b.hyphen+d),e.trigger("change"),f.hide(),this},f.clear=function(){return e.val(""),f.change(j,k),f.hide(),this},f.getdate=function(){return e.val()},f.setdate=function(b,c,d){if("string"==typeof b)return f.setdate({date:b}),void 0;if("number"==typeof b&&"number"==typeof c&&"number"==typeof d)return f.setdate({year:b,month:c,day:d}),void 0;if("object"!=typeof b)return!1;b=a.extend({},{date:null,year:null,month:null,day:null,set:!0},b);var e;return"string"==typeof b.date&&(b.date=h(b.date),e=new Date(b.date),e.setHours(0),e.setMinutes(0),e.setSeconds(0),b.year=e.getFullYear(),b.month=e.getMonth()+1,b.day=e.getDate()),f.change(b.year,b.month),b.set&&f.selected(b.day),this},f.gotodate=function(a,b){return"string"==typeof a?f.setdate({date:a,set:!1}):"number"==typeof a&&"number"==typeof b&&f.setdate({year:a,month:b,day:1,set:!1}),this},q.delegate("a","click",function(){if(this.rel){var a=this.rel;switch(a){case"pre":return f.change(x.val(),parseInt(y.val(),10)-1),!1;case"next":return f.change(x.val(),parseInt(y.val(),10)+1),!1;case"clear":return f.clear(),!1}}}),t.delegate("td","click",function(){var b=a(this);b.hasClass("num")&&(t.find("td").removeClass("selected"),b.addClass("selected"),f.selected(b.data("day")))}),e.bind("click",f.show),u.bind("click",f.hide),w.bind("click",function(){w.hide(),s.show()}),x.bind("change",function(){f.change(x.val(),y.val())}),y.bind("change",function(){f.change(x.val(),y.val())}),f.change(j,k),g={jqobj:d.jqobj,show:f.show,hide:f.hide,getdate:f.getdate,setdate:f.setdate,gotodate:f.gotodate,clear:f.clear}}},a.cxCalendar={defaults:{beginyear:1950,endyear:2030,date:new Date,type:"yyyy-mm-dd",hyphen:"-",wday:0},language:{year:"年",month:"月",monthList:["1","2","3","4","5","6","7","8","9","10","11","12"],weekList:["日","一","二","三","四","五","六"]}}}(jQuery);

jQuery(function($){
	//颜色选择器
	$('.colorSelector').wpColorPicker();

	//日期选择器
	$('input.mpanel-cxcalendar').each(function(){
		$(this).cxCalendar();
	});

	//文件上传
	$('.mpanel-upload-button').click(function(e){
		var upload_frame,
			value = $( '#' + $(this).data('value') ),
			mthis = $(this);
		e.preventDefault();
		if( upload_frame ){
			upload_frame.open();
			return;
		}
		upload_frame = wp.media({
			title: 'Upload',
			button: {
				text: 'Upload',
			},
			multiple: false
		});
		upload_frame.on( 'select',function(){
			attachment = upload_frame.state().get('selection').first().toJSON();
			var url = attachment.url,
				box = mthis.next('.upload-img-box');
			if( box.length !== 0 ) box.find('img').attr('src', url);
			else mthis.after('<div class="upload-img-box"><img src="' + url + '" /><span class="delete"></span></div>');				
			value.val( url ).trigger('change');
			DeleteUpload();
		});
		upload_frame.open();
	});
	function DeleteUpload(){
		var s = $('.upload-img-box .delete');
		s.unbind('click');
		s.click(function(){
			var box = $(this).parent('div.upload-img-box');
			$( '#' + box.prev('a.mpanel-upload-button').data('value') ).val('');
			box.hide('normal', function(){
				$(this).remove();
			});
		});		
	}
	DeleteUpload();

	//Ajax 表单
	$('#mpanel-form').submit(function(){
		var load = $('#mpanel-load'),
			save = $('.mpanel-save,.mpanel-save2');
		if( $('#mpanel-item-import').val() ) return true;
		save.attr('disabled',true);
		load.show(100);
		$.post( ajaxurl, $('#mpanel-form').serialize() + '&action=mpanel-save', function(data){
			if( data === '1' ){
				load.addClass('mpanel-done');
				setTimeout(function(){
					load.hide(100);
					save.attr('disabled',false);
				} ,1200);
				setTimeout(function(){
					load.removeClass('mpanel-done');
				} ,1400);
				return false;
			}
			load.addClass('mpanel-error');
			setTimeout(function(){
				load.hide(100);
				save.attr('disabled',false);
			} ,1200);
			setTimeout(function(){
				load.removeClass('mpanel-done');
			} ,1400);
		});
		return false;
	});

	//菜单高亮和分页
	$('.mpanel-menu li:first').addClass('current');
	$('.mpanel-mian-panel .mpanel-page').hide(100);
	$('.mpanel-mian-panel .mpanel-page:first').show(100);
	$('.mpanel-menu li').on('click',function(){
		$('.mpanel-menu li').removeClass('current');
		$(this).addClass('current');
		$('.mpanel-mian-panel .mpanel-page').hide(100);
		$('.mpanel-mian-panel .mpanel-page:eq(' + $(this).index() + ')').show(100);
	});

	//复选框样式
	var elems = Array.prototype.slice.call(document.querySelectorAll('.mpanel-checkbox'));
	elems.forEach(function(html){
		var switchery = new Switchery(html);
	});

	//提示框
	var s = $('.mpanel-help'),
		id = '#mpanel-tooltip';
	$(s).mouseover(function(){
		if( !this.title ) return;
		$(this).data('tptitle', this.title);
		this.title = '';
		$('body').append( '<div id="mpanel-tooltip">'+ $(this).data('tptitle') +'</div>' );
		$(id).css({
			'left': $(this).offset().left + $(this).outerWidth( false ) / 2 - $(id).outerWidth( false ) / 2,
			'top': $(this).offset().top - 8
		});
	});
	$(s).mouseout(function(){
		if( !$(this).data('tptitle') ) return;
		$(id).remove();
		this.title = $(this).data('tptitle');
	});
});

//自定义列表
function Custom_List(HtmlId,ValueID,Blank,Repeat,not){
	var $ = jQuery;
	$('#'+HtmlId+' .mpanel-list-add').click(function(){
		var value = $('#'+HtmlId+' .mpanel-list-enter').attr('value');
		if( value ){
			if( value.indexOf(' ') >= 0 ) alert(Blank);
			else{
				var NameRepeat = false;
				$('#'+HtmlId+' .mpanel-list-li li .mpanel-list-li-name').each(function(){
					if( $(this).text() == value ) NameRepeat = true;
				});
				if( NameRepeat ) alert(Repeat);
				else{
					$('#'+HtmlId+' .mpanel-list-li').append('<li><input type="hidden" name="mpanel['+ValueID+'][]" class="mpanel-list-hidden-content" value="'+value+'"><span class="mpanel-list-li-name">'+value+'</span><a href="javascript:;" class="mpanel-list-li-delete"></a></li>');
					$('#'+HtmlId+' .mpanel-list-enter').attr('value','');
					$('#'+HtmlId+' .mpanel-list-li li .mpanel-list-li-delete').click(function(){
						var ThisParent = $(this).parent();
						ThisParent.hide(200, function(){
							ThisParent.remove();
						});
					});
				}
			}
		}else alert(not);
	});
	$('#'+HtmlId+' .mpanel-list-li li .mpanel-list-li-delete').click(function(){
		var ThisParent = $(this).parent();
		ThisParent.hide(200, function(){
			ThisParent.remove();
		});
	});
}