(function($, document, undefined) {
	$(document).ready(function() {
		var $requestResponseModal = $('#request-response-modal');
		
		$('.copy-request-url').on('click', function(e) {
			e.preventDefault();
			
			var requestUrl = $(this).closest('form').data('requestUrl');
			var url = $(this).closest('form').find('[name="url"]').val();
			
			requestUrl = requestUrl.replace('{url}', url);
			
			window.prompt('Copy to clipboard: Ctrl+C, Enter', requestUrl);
		});
		
		$('.request-form').on('submit', function(e) {
			e.preventDefault();
			
			var $submitButton = $(this).find('[type="submit"]');
			
			var $url = $(this).find('[name="url"]');
			
			var requestUrl = $(this).data('requestUrl');
			var url = $url.val();
			
			if (url.trim() === '') {
				alert('Please enter the URL before sending the request.');
				$url.focus();
				return false;
			}
			
			$submitButton.addClass('disabled');
			
			requestUrl = requestUrl.replace('{url}', url);
			
			$.ajax(requestUrl, {
				before: function() {
					alert('test');
				},
				success: function(data) {
					var body = data.body;
					
					$requestResponseModal.find('.request-url').text(requestUrl);
					$requestResponseModal.find('.response-body').text(body);
					
					$requestResponseModal.modal({
						show: true
					});
				},
				error: function(jqXHR, textStatus) {
					var responseJson = JSON.parse(jqXHR.responseText);
					var errorText = responseJson.error || textStatus || 'Unknown error.';
					
					alert('Request failed: ' + errorText + ' We apologize for any inconvenience.');
				},
				complete: function() {
					$submitButton.removeClass('disabled');
				}
			});
		});
		
		$('body').scrollspy({
			target: '#main-navbar',
			offset: 80
		});
	});
})(jQuery, document);
