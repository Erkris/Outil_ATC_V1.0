div_results = $('#code_results');

modal_title = $('#myModalLabel');
modal_result = $('.modal-body');

$('#myModal').on('show.bs.modal', function(event){
	elem = $(event.relatedTarget);
	code_atc = elem.attr("data-atc");
	cla = elem.attr("class");
	switch(cla){
		case "title_spe":
			modal_title.html("Spécialité (Cocher au minimum un élément avant d'exporter)");
			getContentSpe(code_atc);
		break;
		default :
			console.log("autre");
		break;
	}
});

// fonction pour gérer l'affichage dans la div code_results
function getContentSpe(code){
	modal_result.html('');

	$.ajax({
		type : 'GET', 
		url : 'ajax_search.php',
		data : 'req=4&code='+code,
		            
		success : function(data){
			modal_result.html(data);

			modal_result.find(".check").on('click', function(event){
				if(!$(this).hasClass("check-checked")){
					$(this).addClass("check-checked");
				}else{
					$(this).removeClass("check-checked");
				}
			});

			checkall = modal_result.find("#checkAll");
			checkall.unbind('click');
			checkall.on('click', function(event){
				if(!$(this).hasClass("check-checked")){
					$(this).addClass("check-checked");
					$(".check").each(function(event){
						if(!$(this).hasClass("check-checked")){
							$(this).addClass("check-checked");
						}
					});
				}else{
					$(this).removeClass("check-checked");
					$(".check").each(function(event){
						if($(this).hasClass("check-checked")){
							$(this).removeClass("check-checked");
						}
					});		
				}
			});
			// Check toutes les cases sauf NSFP

			checkallButNsfp = modal_result.find("#checkAllButNsfp");
			checkallButNsfp.unbind('click');
			checkallButNsfp.on('click', function(event){
				if(!$(this).hasClass("check-checked")){
					$(this).addClass("check-checked");
					$(".nsfp .check").each(function(event){
						if(!$(this).hasClass("check-checked")){
							$(this).addClass("check-checked");
						}
					});
				}else{
					$(this).removeClass("check-checked");
					$(".nsfp .check").each(function(event){
						if($(this).hasClass("check-checked")){
							$(this).removeClass("check-checked");
						}
					});		
				}
			});

		}
	});
	return false;
}

$("#btnExport").on("click", function(event) {
	str = getChecked();

	if(str.trim()){
	    $.ajax({
			type : 'POST', 
			url : 'ajax_export.php',
			data : 'str='+str,
			          
			success : function(data){
				var a = $("#linkExport");
				//a.html(data);
				a.attr("href", data);
				a.attr("target", "_blank");
				a.attr("download", data.substr(data.lastIndexOf('/')+1, data.length - 1));
				a.on("click", function(event){
					window.location.href = data;
				});
				a.trigger("click");
			}
		});
	}else{
		console.log("Veuillez Selectionner au moins une spécialité");
	}

	return false;
});    

function getChecked() {
	str = "";
	checks = modal_result.find('.check-checked').each(function(index){
		if(!$(this).is("#checkAll") && !$(this).is("#checkAllButNsfp")){
			str += $(this).data('info') + "|";
		}
	});

	return str.substr(0, str.length - 1);
}