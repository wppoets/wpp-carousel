+function ($) {
	$(document).ready(function() {
		wpp_slideshow_slides.append_row = function( slide_type ) {
			var new_row = wpp_slideshow_slides.new_row( wpp_slideshow_slides.next_row, slide_type );
			$("#wpp-slideshow-slides-table tbody").append(new_row);
			$("#wpp-slideshow-slides-table .wpp-slideshow-slides-empty-row").hide();
			wpp_slideshow_slides.next_row++;
			wpp_slideshow_slides.visible_slides++;
		};

		wpp_slideshow_slides.fill_data = function( item, value ) {
			if($( item ).is("input:checkbox")) {
				$( item ).prop('checked', value);
			} else if($( item ).is("input")||$( item ).is("textarea")) {
				$( item ).val(value);
			} else if($( item ).is("img")) {
				$( item ).attr("src", value);
			}
		}

		$( "#wpp-slideshow-slides-confirm-delete-dialog" ).dialog({
			autoOpen: false,
			resizable: false,
			height:200,
			modal: true,
			buttons: {
				"Delete slide": function() {
					$(this).data('button').parents('td').children('input.wpp-slideshow-slides-field-removed').val('true');
					$(this).data('button').parents('tr').hide();
					wpp_slideshow_slides.visible_slides--;
					if ( wpp_slideshow_slides.visible_slides <= 0 ) {
						$("#wpp-slideshow-slides-table .wpp-slideshow-slides-empty-row").show();
						wpp_slideshow_slides.visible_slides = 0; 
					}
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});

		$('#wpp-slideshow-slides-slide-type-dialog').dialog({
			autoOpen: false,
			height: 250,
			width: 300,
			modal: true,
			buttons: {
				"Create slide": function() {
					slide_type = $('#wpp-slideshow-slides-slide-type-dialog').find('input[name=slide_type]:checked').val();
					if ( slide_type ) {
						wpp_slideshow_slides.append_row( slide_type );
					}
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});

		$('#wpp-slideshow-slides-table tbody').sortable({
			opacity: 0.6,
			revert: true,
			cursor: 'move',
			handle: '.wpp-slideshow-slides-sort',
		});

		$('#wpp-slideshow-slides-slide-type-dialog').find("input[name=slide_type]:first").attr('checked', true);
		$("#wpp-slideshow-slides-table").on('click', ".wpp-slideshow-slides-add-slide", function(event){
			event.preventDefault();
			$('#wpp-slideshow-slides-slide-type-dialog').dialog( "open" );
		});

		$("#wpp-slideshow-slides-table").on('click', ".wpp-slideshow-slides-select-image-button", function(event){
			event.preventDefault();
			var wpp_slideshow_slide_image_id = $(this).parents('td').children('input.wpp-slideshow-slides-field-image-id');
			var wpp_slideshow_slide_image_src = $(this).parents('td').children('.wpp-slideshow-slides-image').children('img.wpp-slideshow-slides-field-image-src');
			console.log(wpp_slideshow_slide_image_id);
			console.log(wpp_slideshow_slide_image_src);
			var wpp_slideshow_slide_download_frame = wp.media({
				title: 'Select Slide Image',
				button: {
					text: 'Select Slide Image',
				},
				library : {
					type : 'image',
				},
				multiple: false,
			}).on('select', function() {
				var attachment = wpp_slideshow_slide_download_frame.state().get('selection').first().toJSON();
				wpp_slideshow_slide_image_id.val(attachment.id);
				wpp_slideshow_slide_image_src.attr("src", (attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url);
			}).open();
		});

		$("#wpp-slideshow-slides-table tbody").on('click', ".wpp-slideshow-slides-remove-slide", function(event) {
			event.preventDefault();
			$('#wpp-slideshow-slides-confirm-delete-dialog').dialog( "open" )
				.data('button', $(this));
		});

		$.each( wpp_slideshow_slides.starting_data, function( starting_data_key, starting_data_values ) {
			var html_row_id = wpp_slideshow_slides.next_row;
			starting_data_values.slide_type = ( starting_data_values.slide_type || '' );
			wpp_slideshow_slides.append_row( starting_data_values.slide_type );
			$.each( starting_data_values, function( data_key, data_value ) {
				var first_match = '#wpp-slideshow-slides-row-' + html_row_id + ' .wpp-slideshow-slides-field-' + data_key.replace('slide_','').replace('_','-');
				var second_match = '#wpp-slideshow-slides-row-' + html_row_id + ' .wpp-slideshow-slides-field-' + data_key.replace('slide-','').replace('-','_');
				if ( $( first_match ).length ) {
					wpp_slideshow_slides.fill_data(first_match, data_value);
				} else if ( $( second_match ).length ) {
					wpp_slideshow_slides.fill_data(second_match, data_value);
				}
			});
		});

		$("#wpp-slideshow-slides-table .wpp-slideshow-slides-empty").html(wpp_slideshow_slides.empty_message || '');
	});
}(jQuery);