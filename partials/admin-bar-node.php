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
		background: rgb(51, 51, 51);
		padding: 8px;
		border-radius: 0 0 2px 2px;
		border-width: 0 1px 1px 1px;
		border-style: solid;
		border-color: #222;
	}
</style>

<form id="wpmsq-user">
	<select name="wpmsq-user" id="wpmsq-user-input">
		<option>Please wait...</option>
	</select>
</form>