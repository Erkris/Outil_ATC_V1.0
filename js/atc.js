search_field = $('#search');
ul_results = $('#search_results');
ajax_loader = "ajax_loader";

div_results = $("#code_results");
arbo_base = $("#arbo_base");

div_results.find(".link-code").on('click', function(event){
		c = $(this).html();
		getContent(c);
		ul_results.hide();
});

arbo_base.find("li.link-code").on('click', function(event){
		c = $(this).html().substring(0, 1);
		getContent(c);
		ul_results.hide();
		if (!$(this).hasClass("active")) {
			$(".link-code").each(function(event){
				if($(this).hasClass("active")){
					$(this).removeClass("active");
				}
			});
		$(this).addClass("active");	
		};
});

function showResult(data){
	$("#"+ajax_loader).remove();
	div_results.html(data);
	div_results.find(".link-code").on('click', function(event){
		c = $(this).html();
		getContent(c);
		ul_results.hide();
	});
	div_results.find(".downATC").on('click', function(event){
		res = div_results.find("td:first").html();
		getContentLower(res);
		ul_results.hide();
	});
}

function printVal(data) {
	n = div_results.find("td:first").html().length
	switch (n) {
		case 7:
			first = div_results.find("td:first").html().substr(0,(n-2));
		break;
		case 3:
			first = div_results.find("td:first").html()
		break;
		default:
			first = div_results.find("td:first").html().substr(0,(n-1));
		break;
	}
	//firstCode = getContent(getCode(first.html()));
	search_field.val(first);
}

// fonction pour gérer l'affichage dans la div code_results
function getContent(code){
	div_results.html('');
	$('#'+ajax_loader).remove();

	$.ajax({
		type : 'GET', 
		url : 'ajax_search.php',
		data : 'req=2&code='+code,
		            
		beforeSend : function(){
		    search_field.after('<img src="img/ajax-loader.gif" alt="loader" id="'+ajax_loader+'" width="20px" height="20px">');
		},
		success : function(data){ 
			showResult(data);
			printVal(data);
		}
	});
	return false;
}

// fonction pour gérer l'affichage des classes ATC de niveau inférieur dans la div code_results
function getContentLower(code){
	div_results.html('');
	$('#'+ajax_loader).remove();

	$.ajax({
		type : 'GET', 
		url : 'ajax_search.php',
		data : 'req=3&code='+code,
		            
		beforeSend : function(){
		    search_field.after('<img src="img/ajax-loader.gif" alt="loader" id="'+ajax_loader+'" width="20px" height="20px">');
		},
		success : function(data){ 
			size_code = code.length;
			if(size_code > 3){
				switch(size_code){
					case 7 :
						code = code.substr(0, 5);
					break;
					default :
						code = code.substr(0, size_code -1);
					break;
				}
			}
		   	showResult(data);
		   	printVal(data);
		}
	});
	return false;
}

// fonction pour garder uniquement le code de la requête renvoyant : code - libellé
function getCode(str){
	n = str.indexOf("-");
	return str.substring(0, n - 1);
}

// fonction pour gérer l'affichage dans la div search_results
$(document).ready(function(){

	search_field.keydown(function(event){
		if(event.keyCode == 13){                     // key code = 13 --> Touche Enter
			event.preventDefault();		

			first = ul_results.find(":first-child");
			getContent(getCode(first.html()));
			ul_results.hide();

			return false;
		}
	});

   	search_field.keyup(function(event){

		if(event.keyCode == 13){                     // key code = 13 --> Touche Enter
			event.preventDefault();		

			first = ul_results.find(":first-child");
			getContent(getCode(first.html()));
			ul_results.hide();

			return false;
		}

    	$field = $(this);

    	ul_results.html('');
    	ul_results.hide();
      	$("#"+ajax_loader).remove();
            
		if($field.val().length > 0){
        	$.ajax({
  	         	type : 'GET', 
	         	url : 'ajax_search.php',
	         	data : 'req=1&search='+$(this).val(),

	         	beforeSend : function(){
               		$field.after('<img src="img/ajax-loader.gif" alt="loader" id="'+ajax_loader+'" width="20px" height="20px">');
	         	},
				success : function(data){ 
               		$("#"+ajax_loader).remove();
               		ul_results.show();
               		ul_results.html(data);
               		ul_results.children().on('click', function(event){
               			code = getCode($(this).html());
               			getContent(code);
               			ul_results.hide();
               			search_field.val(code);
               			activeArboClass = $( arbo_base.find("li") ).each(function( index ) {
						  	codeLevel1 = $( this ).text().substr(0, 1);
               				for (var i = 0; i < codeLevel1.length; i++) {
	               				if (codeLevel1[i] == code.substr(0, 1)) {
	               					if (!$(this).hasClass("active")) {
										$(".link-code").each(function(event){
											if($(this).hasClass("active")){
												$(this).removeClass("active");
											}
										});
									$(this).addClass("active");	
									};
	               				};
               				};
						});
               		});
            	}
         	});
      	}		
   	});

   	document.body.onclick = function(e) {
	    if(e.target != document.getElementById('search')) {
	        ul_results.hide();
	    } else {
	    	$field = search_field;
	        if($field.val().length > 0){
	        	$.ajax({
	  	         	type : 'GET', 
		         	url : 'ajax_search.php',
		         	data : 'req=1&search='+$field.val(),

		         	beforeSend : function(){
	               		$field.after('<img src="img/ajax-loader.gif" alt="loader" id="'+ajax_loader+'" width="20px" height="20px">');
		         	},
					success : function(data){ 
	               		$("#"+ajax_loader).remove();
	               		ul_results.show();
	               		ul_results.html(data);
	               		ul_results.children().on('click', function(event){
	               			code = getCode($(this).html());
	               			getContent(code);
	               			ul_results.hide();
	               			search_field.val(code);
	               		});
	            	}
	         	});
	      	}
	    }
	}

   	//ul_results.click(function(event){
   	//	ul_results.hide();
    // 	});

});