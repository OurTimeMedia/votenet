tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		editor_selector :"mceEditor",  
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "code,pastetext,pasteword,|,preview,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,bullist,numlist,|,sub,sup,",
		theme_advanced_buttons3 : "",
		
		remove_script_host : false,

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

	});