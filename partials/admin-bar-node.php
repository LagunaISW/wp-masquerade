<style>
	#wp-admin-bar-wpmsq-ab-link {
		width: 100%;
		max-width: 190px;
	}
	#wp-admin-bar-wpmsq-ab-link .ab-item.ab-empty-item {
		color: rgb(116, 116, 116);
	}
	#wp-admin-bar-wpmsq-ab-link:hover #wpmsq-user{
		opacity: 1;
		transform: translateY(0px);
	}
	#wpmsq-user {
		opacity: 0;
		transform: translateY(-20px);
		transition: all 100ms ease-in;
	}
</style>

<form id="wpmsq-user">
	<select name="wpmsq-user" id="wpmsq-user-input">
		<option>Please wait...</option>
	</select>
</form>