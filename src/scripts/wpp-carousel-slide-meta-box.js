+function ($) {
	$(document).ready(function() {
		wpp_carousel_slides.append_row = function( slide_type ) {
			var new_row = wpp_carousel_slides.new_row( wpp_carousel_slides.next_row, slide_type );
			$("#wpp-carousel-slide-table tbody").append(new_row);
			$("#wpp-carousel-slide-table .wpp-carousel-slide-empty-row").hide();
			wpp_carousel_slides.next_row++;
			wpp_carousel_slides.visible_slides++;
		};

		$( "#wpp-carousel-slide-confirm-delete-dialog" ).dialog({
			autoOpen: false,
			resizable: false,
			height:200,
			modal: true,
			buttons: {
				"Delete slide": function() {
					$(this).data('button').parents('td').children('input.wpp-carousel-slide-field-removed').val('true');
					$(this).data('button').parents('tr').hide();
					wpp_carousel_slides.visible_slides--;
					if ( wpp_carousel_slides.visible_slides <= 0 ) {
						$("#wpp-carousel-slide-table .wpp-carousel-slide-empty-row").show();
						wpp_carousel_slides.visible_slides = 0; 
					}
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});

		$('#wpp-carousel-slide-slide-type-dialog').dialog({
			autoOpen: false,
			height: 250,
			width: 300,
			modal: true,
			buttons: {
				"Create slide": function() {
					slide_type = $('#wpp-carousel-slide-slide-type-dialog').find('input[name=slide_type]:checked').val();
					if ( slide_type ) {
						wpp_carousel_slides.append_row( slide_type );
					}
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});

		$('#wpp-carousel-slide-table tbody').sortable({
			opacity: 0.6,
			revert: true,
			cursor: 'move',
			handle: '.wpp-carousel-slide-sort',
		});

		$('#wpp-carousel-slide-slide-type-dialog').find("input[name=slide_type]:first").attr('checked', true);
		$("#wpp-carousel-slide-table").on('click', ".wpp-carousel-slide-add-slide", function(event){
			event.preventDefault();
			$('#wpp-carousel-slide-slide-type-dialog').dialog( "open" );
		});

		$("#wpp-carousel-slide-table").on('click', ".wpp-carousel-slide-select-image-button", function(event){
			event.preventDefault();
			var wpp_carousel_slide_image_id = $(this).parents('td').children('input.wpp-carousel-slide-field-image-id');
			var wpp_carousel_slide_image_src = $(this).parents('td').children('.wpp-carousel-slide-image').children('img.wpp-carousel-slide-field-image-src');
			console.log(wpp_carousel_slide_image_id);
			console.log(wpp_carousel_slide_image_src);
			var wpp_carousel_slide_download_frame = wp.media({
				title: 'Select Slide Image',
				button: {
					text: 'Select Slide Image',
				},
				library : {
					type : 'image',
				},
				multiple: false,
			}).on('select', function() {
				var attachment = wpp_carousel_slide_download_frame.state().get('selection').first().toJSON();
				wpp_carousel_slide_image_id.val(attachment.id);
				wpp_carousel_slide_image_src.attr("src", (attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url);
			}).open();
		});

		$("#wpp-carousel-slide-table tbody").on('click', ".wpp-carousel-slide-remove-slide", function(event) {
			event.preventDefault();
			$('#wpp-carousel-slide-confirm-delete-dialog').dialog( "open" )
				.data('button', $(this));
		});
		/*
		$.each( wpp_carousel_slides.starting_data, function( i, new_row ) {
			new_row.slide_type = ( new_row.slide_type || '' );
			new_row.row_id = wpp_carousel_slides.next_row;
			if ( new_row.slide_type == 'static' ){
				wpp_carousel_slide_append_static_row();
				if ( new_row.slide_image_id && new_row.slide_image_src ) {
					$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-image-id').val(new_row.slide_image_id || 'false');
					$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-image-src').attr("src", new_row.slide_image_src);
				}
				$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-post-id').val(new_row.slide_post_id || 'false');
				$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-title-enabled').prop('checked', new_row.slide_title_enabled);
				$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-title').val(new_row.slide_title || '');
				$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-link-enabled').prop('checked', new_row.slide_link_enabled);
				$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-link').val(new_row.slide_link || '');
				$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-caption-enabled').prop('checked', new_row.slide_caption_enabled);
				$('#wpp-carousel-slide-row-' + new_row.row_id + ' .wpp-carousel-slide-field-caption').val(new_row.slide_caption || '');
			} else if ( new_row.slide_type == 'dynamic' ) {
				wpp_carousel_slide_append_dynamic_row();
			}
		});
		*/

		$("#wpp-carousel-slide-table .wpp-carousel-slide-empty").html(wpp_carousel_slides.empty_message || '');
	});
}(jQuery);