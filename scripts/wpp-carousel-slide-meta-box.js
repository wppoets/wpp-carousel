+function ($) {
	function wpp_carousel_slide_append_static_row() {
		var new_slide = [
			'<tr id="wpp-carousel-slide-row-' + wpp_carousel_slide_next_row_id + '" class="wpp-carousel-slide-row">',
			'	<td class="wpp-carousel-slide-colunm-1">',
			'		<button type="button" class="button wpp-carousel-slide-remove-slide">-</button>',
			'		<input class="wpp-carousel-slide-field-removed" type="hidden" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][removed]" value="false">',
			'	</td>',
			'	<td class="wpp-carousel-slide-colunm-2">',
			'		Image: (<a class="wpp-carousel-slide-select-image-button" href="#">change</a>)<br />',
			'		<div class="wpp-carousel-slide-image wpp-carousel-slide-image-not-selected"><img class="wpp-carousel-slide-field-image-src" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=" width="150" height="150" /></div>',
			'		<input class="wpp-carousel-slide-field-image-id" type="hidden" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][image_id]" value="false">',
			'	</td>',
			'	<td class="wpp-carousel-slide-colunm-3">',
			'		<input class="wpp-carousel-slide-field-post-id" type="hidden" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][post_id]" value="false">',
			'		<input class="wpp-carousel-slide-field-title-enabled" type="checkbox" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][title_enabled]" value="true" />Title:<br />',
			'		<input class="wpp-carousel-slide-field-title widefat" type="text" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][title]" value="" /><br />',
			'		<input class="wpp-carousel-slide-field-link-enabled" type="checkbox" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][link_enabled]" value="true" />Link:<br />',
			'		<input class="wpp-carousel-slide-field-link widefat" type="text" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][link]" value="" /><br />',
			'		<input class="wpp-carousel-slide-field-caption-enabled" type="checkbox" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][caption_enabled]" value="true" />Caption:<br />',
			'		<textarea class="wpp-carousel-slide-field-caption widefat" rows="1" cols="40" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][caption]"></textarea>',
			'	</td>',
			'	<td class="wpp-carousel-slide-colunm-4">',
			'		<div class="wpp-carousel-slide-sort dashicons dashicons-sort"></div>',
			'		<input type="hidden" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][type]" value="static">',
			'		<input type="hidden" name="wpp_carousel_slide_fields[sort_order][]" value="' + wpp_carousel_slide_next_row_id + '">',
			'	</td>',
			'</tr>',
		].join('');
		$("#wpp-carousel-slide-table tbody").append(new_slide);
		$("#wpp-carousel-slide-table .wpp-carousel-slide-empty-row").hide();
		wpp_carousel_slide_next_row_id++;
		wpp_carousel_slide_visible_slides++;
	}
	function wpp_carousel_slide_append_dynamic_row() {
		var new_slide = [
			'<tr id="wpp-carousel-slide-row-' + wpp_carousel_slide_next_row_id + '" class="wpp-carousel-slide-row">',
			'	<td class="wpp-carousel-slide-colunm-1"><button type="button" class="button wpp-carousel-slide-remove-slide">-</button><input type="hidden" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][removed]" class="wpp-carousel-slide-field-removed" value="false"><input type="hidden" name="wpp_carousel_slide_fields[rows][' + wpp_carousel_slide_next_row_id + '][type]" value="dynamic"></td>',
			'	<td class="wpp-carousel-slide-colunm-2">Image: ( N/A )<div class="wpp-carousel-slide-image wpp-carousel-slide-image-not-available"><img class="wpp-carousel-slide-select-image-src" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=" width="150" height="150" /></div></td>',
			'	<td class="wpp-carousel-slide-colunm-3"><div class="wpp-carousel-slide-not-implamented">Feature not implamented yet</div></td>',
			'	<td class="wpp-carousel-slide-colunm-4"><div class="wpp-carousel-slide-sort dashicons dashicons-sort"></div><input type="hidden" name="wpp_carousel_slide_fields[sort_order][]" value="' + wpp_carousel_slide_next_row_id + '"></td>',
			'</tr>',
		].join('');
		$("#wpp-carousel-slide-table tbody").append(new_slide);
		$("#wpp-carousel-slide-table .wpp-carousel-slide-empty-row").hide();
		wpp_carousel_slide_next_row_id++;
		wpp_carousel_slide_visible_slides++;
	}
	$(document).ready(function() {
		console.log('wpp_carousel_slide_post_id = ' + wpp_carousel_slide_post_id);
		console.log('wpp_carousel_slide_last_row_id = ' + wpp_carousel_slide_next_row_id);
		$('#wpp-carousel-slide-table tbody').sortable({
			opacity: 0.6,
			revert: true,
			cursor: 'move',
			handle: '.wpp-carousel-slide-sort',
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
		$("#wpp-carousel-slide-table").on('click', ".wpp-carousel-slide-add-static-slide", function(event){
			event.preventDefault();
			wpp_carousel_slide_append_static_row();
		});
		$("#wpp-carousel-slide-table").on('click', ".wpp-carousel-slide-add-dynamic-slide", function(event){
			event.preventDefault();
			wpp_carousel_slide_append_dynamic_row();
		});
		$("#wpp-carousel-slide-table tbody").on('click', ".wpp-carousel-slide-remove-slide", function(event) {
			event.preventDefault();
			var agree = confirm("Are you sure you want to remove the slide?");
			if(agree) {
				$(this).parents('td').children('input.wpp-carousel-slide-field-removed').val('true');
				$(this).parents('tr').hide();
				wpp_carousel_slide_visible_slides--;
				if ( wpp_carousel_slide_visible_slides <= 0 ) {
					$("#wpp-carousel-slide-table .wpp-carousel-slide-empty-row").show();
					wpp_carousel_slide_visible_slides = 0;
				}
			}
		});
		$.each( wpp_carousel_slide_starting_data, function( i, new_row ) {
			new_row.slide_type = ( new_row.slide_type || '' );
			new_row.row_id = wpp_carousel_slide_next_row_id;
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
		$("#wpp-carousel-slide-table .wpp-carousel-slide-empty").html(wpp_carousel_slide_empty_message || '');
	});
}(jQuery);