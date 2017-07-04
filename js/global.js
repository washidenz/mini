//document.onselectstart = function() {return false;}
$(function(){
	//$('button').tooltip()
	// Optencion de Coordenadas de DIV (Config Comprobante)
	$(document).on('click','.SendAjax', function(e)
	{
		$this=this;
		e.preventDefault();
		$(this).ajaxview({
			"success":function(){
				$("form:not(.filter) :input:visible:enabled:first").focus();
				$Form = $($this).data("serialize");
				if(typeof($Form)!='undefined')
				{
					$("#"+$Form)[0].reset();
					$("#"+$Form+":not(.filter) :input:visible:enabled:first").focus();
				}
			},
			"complete":function(){
				$("form:not(.filter) :input:visible:enabled:first").focus();
				$Form = $($this).data("serialize");
				if(typeof($Form)!='undefined')
				{
					$("#"+$Form+":not(.filter) :input:visible:enabled:first").focus();
				}
			}
		});
	});

	$(document).on('click','.CloseModal', function(e)
	{
		$this=this;
		e.preventDefault();
		$(this).ajaxview({
			"success":function(){
				$Modal = $($this).data("target");
				$($Modal).modal('hide');
			}
		});
	});

	$(document).on('click','.OpenModal', function(e)
	{
		$this=this;
		e.preventDefault();
		$(this).ajaxview({
			"success":function()
			{
				$Modal = $($this).data("target");
				
				$type = $($this).data("target-type");
				$($Modal+">div").removeClass("modal-sm");
				$($Modal+">div").removeClass("modal-lg");
				$($Modal+">div").removeClass("modal-full");
				if(typeof($type)!='undefined')
				{
					$($Modal+">div").addClass($type);
				}
				
				$($Modal).modal('show');
				
				$Form = $($this).data("serialize");
				if(typeof($Form)!='undefined')
				{
					$("#"+$Form+":not(.filter) :input:visible:enabled:first").focus();
				}
			},
			"complete":function(){
				$('.modal .input-daterange').datepicker({
					format: "yyyy-mm-dd",
					//startDate: "today",
					autoclose: true,
					todayHighlight: true
				});
				$("form:not(.filter) :input:visible:enabled:first").focus();
				$Form = $(".modal form").attr("id");
				if(typeof($Form)!='undefined')
				{
					$("#"+$Form+":not(.filter) :input:visible:enabled:first").focus();
				}
				$("[data-inputmask]").inputmask();
			}
		});
	});
	$('#sidebar_left_menu').slimScroll({
		height: '350px',
		size: '10px',
		wheelStep: 5
	});
/*
$(selector).slimScroll({
    width: '300px',
    height: '500px',
    size: '10px',
    position: 'left',
    color: '#ffcc00',
    alwaysVisible: true,
    distance: '20px',
    start: $('#child_image_element'),
    railVisible: true,
    railColor: '#222',
    railOpacity: 0.3,
    wheelStep: 10,
    allowPageScroll: false,
    disableFadeOut: false
});
*/
});
