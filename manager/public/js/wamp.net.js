/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Alerts                                                                   //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

$(document).ready(function()
{
	$('.notify').prepend($('.alert'));
	$('.alert').slideDown(200);
});

/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Select active menu item and expand tools if we're on a tools page        //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

function highliteMenu()
{
	var current = location.pathname;

	switch (current)
	{
		case '/packages'  : $('[href="/"]').addClass('mnu_active');
						   	break;

		case '/site/add'  : $('[href="/sites"]').addClass('mnu_active');
						   	break;

		default     	  : $('#nav a').each(function()
							{
	    						var $this = $(this);

	    						if ($this.attr('href') == current)
	        					$this.addClass('mnu_active');
							});
	}

	var href = window.location.href;

	if (href.includes("/tools/"))
		$('#mnu_tools').collapse();
}

/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Bassicly popper.js for bootstrap 3 (menu on top or bottom to fit)        //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

$(document).ready(function()
{
	var dd_obj = {jq_win :$(window), jq_doc :$(document)};

	function selfCalc(ele)
	{
		var $this = $(ele);
		var $dd_menu = $this.children(".dropdown-menu");
		var ddOffset = $this.offset();
		var ddMenu_posTop = dd_obj.jq_win.outerHeight() - (($this.outerHeight() + ddOffset.top + $dd_menu.outerHeight()) - dd_obj.jq_doc.scrollTop());
		var ddMenu_posRight = dd_obj.jq_win.outerWidth() - (($this.outerWidth() + ddOffset.left + $dd_menu.outerWidth()) - dd_obj.jq_doc.scrollLeft());

		(ddMenu_posTop <= 0) ? $this.addClass("dropup") : $this.removeClass("dropup");
		(ddMenu_posRight <= 0) ? $this.find('.dropdown-menu').addClass("dropdown-menu-right") : $this.find('.dropdown-menu').removeClass("dropdown-menu-right");
	}

	$('body').on("shown.bs.dropdown", ".btn-group", function()
	{
		var self = this;
		selfCalc(self);
		dd_obj.jq_win.on('resize.custDd scroll.custDd mousewheel.custDd', function()
		{
			selfCalc(self)
		});
	}).on("hidden.bs.dropdown", ".dropdown", function()
	{
		dd_obj.jq_win.off('resize.custDd scroll.custDd mousewheel.custDd')
	});
});

/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Folder Browser                                                           //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

function fb(callback)
{
	modalOverlay('');

	$.get('/tools/fb', function(data)
	{
		callback(data);
		modalOverlay();
	});
}

/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Form Validation                                                          //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

function onSubmit(form)
{
	var submit_btn = $(form).find(':submit');

	// for when the form doesn't have a submit button, use sender.
	if ((submit_btn.length) == 0)
	 	submit_btn = $(event.target);

	submit_btn.focus().blur();
	first = true;
	var existing_text = submit_btn.text();
	submit_btn.html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;&nbsp;Please wait').prop('disabled', true);
	$('.has-error').removeClass('has-error');
	$('.help-block').empty().hide();

	$.post($(form).attr('action'), $(form).serialize(), function(result)
	{
		eval(result);
		try
		{
			$('.nav-tabs a[href="#'+ $(".has-error:first").parent()[0].id +'"]').tab('show');
		} catch(err) {}
	});

	return false;
}

function render(obj)
{
	if (first)
	{
		first = false;
		$('#'+obj.name).focus();
	}

	var input = $('#'+obj.name).closest('.form-group').append('<span class="help-block">'+obj.error+'</span>');
	input.addClass('has-error');

	if (obj.clear)
		$('#'+obj.name).val('');
}

$(document).ready(function()
{
	$('.validate').each(function()
	{
		$(this).on('submit', function()
		{
			return onSubmit(this);
		});
	});
});

/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Modals                                                                   //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

function modalOverlay(msg)
{
	if (msg == undefined)
	{
		$('#overlayModal').modal('hide');
	}
	else
	{
		var dlg = $('<div id="overlayModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
					'</div>');
		dlg.on('hidden.bs.modal', function()
		{
    		$(this).data('bs.modal', null).remove();
		});

		dlg.modal();
	}
}

function modalWait(msg)
{
	if (msg == undefined)
	{
		$('#waitModal').modal('hide');
	}
	else
	{
		var msg = msg || 'Please Wait...';

		var dlg = $('<div id="waitModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
						'<div class="modal-dialog modal-m">' +
							'<div class="modal-content">' +
								'<div class="modal-header"><h3 style="margin:0;">' + msg + '</h3></div>' +
								'<div class="modal-body">' +
									'<div class="progress progress-striped active" style="margin-bottom:0;">' +
										'<div class="progress-bar" style="width: 100%"></div>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>');

		dlg.on('hidden.bs.modal', function()
		{
    		$(this).data('bs.modal', null).remove();
		});

		dlg.modal();
	}
}

function modalInfo(text, type='primary')
{
	var modal_str =  '	<div class="modal fade" tabindex="-1">';
		modal_str += '		<div class="modal-dialog" role="document">';
		modal_str += '	    	<div class="modal-content">';
		modal_str += '	      	<div class="modal-header">';
		modal_str += '	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
		modal_str += '	          		<span aria-hidden="true">&times;</span>';
		modal_str += '	        	</button>';
		modal_str += '	        	<h4 class="modal-title">Information</h4>';
		modal_str += '	      	</div>';
		modal_str += '	      	<div class="modal-body">';
		modal_str += '	        <p>' + text + '</p>';
		modal_str += '	      </div>';
		modal_str += '	      <div class="modal-footer">';
		modal_str += '	        <button type="button" class="btn btn-'+type+'" data-dismiss="modal" id="btn_okay">Okay</button>';
		modal_str += '	      </div>';
		modal_str += '	    </div>';
		modal_str += '	  </div>';
		modal_str += '	</div>';

	var modal = $(modal_str);

	modal.on('hidden.bs.modal', function()
	{
		$(this).remove();
	});

	modal.on('shown.bs.modal', function()
	{
		if (type=='danger')
			btn_cancel.focus();
		else
			btn_okay.focus();
	});

	var m = modal.modal();
}

function modalConfirm(text, callback, options)
{
	type        = (options.type) ? options.type : 'primary';
	header_text = (options.header_text) ? options.header_text : 'Confirm';
	okay_text   = (options.okay_text) ? options.okay_text : 'Okay';

	var modal_str =  '	<div class="modal fade" tabindex="-1">';
		modal_str += '		<div class="modal-dialog" role="document">';
		modal_str += '	    	<div class="modal-content">';
		modal_str += '	      	<div class="modal-header">';
		modal_str += '	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
		modal_str += '	          		<span aria-hidden="true">&times;</span>';
		modal_str += '	        	</button>';
		modal_str += '	        	<h4 class="modal-title">'+header_text+'</h4>';
		modal_str += '	      	</div>';
		modal_str += '	      	<div class="modal-body">';
		modal_str += '	        <p>' + text + '</p>';
		modal_str += '	      </div>';
		modal_str += '	      <div class="modal-footer">';
		modal_str += '	        <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_cancel">Cancel</button>';
		modal_str += '	        <button type="button" class="btn btn-'+type+'" data-dismiss="modal" id="btn_okay">'+okay_text+'</button>';
		modal_str += '	      </div>';
		modal_str += '	    </div>';
		modal_str += '	  </div>';
		modal_str += '	</div>';

	var modal = $(modal_str);

	var btn_okay = modal.find('#btn_okay');

	btn_okay.on('click', function()
	{
		callback();
	});

	modal.on('hidden.bs.modal', function()
	{
		$(this).remove();
	});

	modal.on('shown.bs.modal', function()
	{
		if (type=='danger')
			btn_cancel.focus();
		else
			btn_okay.focus();
	});

	var m = modal.modal();
}

function modalQuery(text, func, default_text)
{
	default_text = (default_text) ? default_text : '';

	var modal_str =  '	<div class="modal fade">';
		modal_str += '		<div class="modal-dialog" role="document">';
		modal_str += '	    	<div class="modal-content">';
		modal_str += '	      	<div class="modal-header">';
		modal_str += '	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
		modal_str += '	          		<span aria-hidden="true">&times;</span>';
		modal_str += '	        	</button>';
		modal_str += '	        	<h4 class="modal-title">Query</h4>';
		modal_str += '	      	</div>';
		modal_str += '	      	<div class="modal-body">';
		modal_str += '	      	<p>' + text + '</p>';
		modal_str += '	        <input type="text" class="form-control" id="modal_text" value="' + default_text + '">';
		modal_str += '	      </div>';
		modal_str += '	      <div class="modal-footer">';
		modal_str += '	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
		modal_str += '	        <button type="button" class="btn btn-success hover" data-dismiss="modal" id="btn_okay">Okay</button>';
		modal_str += '	      </div>';
		modal_str += '	    </div>';
		modal_str += '	  </div>';
		modal_str += '	</div>';

	var modal = $(modal_str);

	var btn_okay = modal.find('#btn_okay');

	var modal_text = modal.find('#modal_text');

	btn_okay.on('click', function()
	{
		func(modal_text.val());
	});

	modal.on('shown.bs.modal', function()
	{
		modal_text.focus();
	});

	modal_text.keypress(function(e)
	{
		if (e.which == 13)
			btn_okay.trigger('click');
	});

	var m = modal.modal();
}

/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Update Functions                                                         //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

function update_check()
{
	modalWait('Checking for updates...');

	$.get('/update/check', function(data)
	{
		modalWait();

		switch (data)
		{
			case '-1': modalInfo("There are no updates available at this time."); break;
			case  '1': sync_available(); break;
			default  : update_available(data);
		}
	});
}

function update_available(version)
{
	modalConfirm('Version <a href="https://wamp.net/changelog" target="_blank">'+version+'</a> is available.<br><br><span class="text-warning"><strong>Warning: updates can take a few minutes to complete. Interrupting the update process could break your installation.</strong></span><br><br>Would you like to update now?', function()
	{
		update();
	}, {'header_text':'Update available', 'okay_text':'Update'});
}

function update(sender)
{
	modalWait('Update in progress...');
	window.location = '/update/update';
}

function sync_available()
{
	modalConfirm('New packages have been added since your last sync with the store.<br><br><span class="text-warning"><strong>Warning: updates can take a few minutes to complete. Interrupting the update process could break your installation.</strong></span><br><br>Would you like to sync now?', function()
	{
		sync();
	}, {'header_text':'New Packages Available', 'okay_text':'Sync'});
}

function sync()
{
	modalWait('Updating Packages...');
	window.location = '/update/sync';
}

/*/////////////////////////////////////////////////////////////////////////////
//                                                                           //
//  Other                                                                    //
//                                                                           //
/////////////////////////////////////////////////////////////////////////////*/

function epoch()
{
	return Math.round(Date.now() / 1000);
}

function formatBytes(bytes)
{
	var marker = 1024; // Change to 1000 if required
	var decimal = 2; // Change as required
	var kiloBytes = marker; // One Kilobyte is 1024 bytes
	var megaBytes = marker * marker; // One MB is 1024 KB
	var gigaBytes = marker * marker * marker; // One GB is 1024 MB
	var teraBytes = marker * marker * marker * marker; // One TB is 1024 GB

	// return bytes if less than a KB
	if(bytes < kiloBytes) return bytes + " Bytes";
	// return KB if less than a MB
	else if(bytes < megaBytes) return(bytes / kiloBytes).toFixed(decimal) + " KB";
	// return MB if less than a GB
	else if(bytes < gigaBytes) return(bytes / megaBytes).toFixed(decimal) + " MB";
	// return GB if less than a TB
	else return(bytes / gigaBytes).toFixed(decimal) + " GB";
}