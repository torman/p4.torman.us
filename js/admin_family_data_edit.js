var options = {
	type: 'POST',
	url: '/admin/p_admin_family_data_edit',
	beforeSubmit: function() {
		$('#result').html("Updating .....").delay(2000);
	},
	success: function(response) {
		$('#result').html("Your changes are updated.");
	}
};

$('form').ajaxForm(options);