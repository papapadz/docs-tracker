<div class="card-panel z-depth-0" style="margin-top:0%;">
	<div class="inline center-align">
		<button id="gototask" class="btn-large btn-flat">TASKS</button>
		<button id="gotoinvreq" class="btn-large btn-flat">INVENTORY REQUESTS</button>
		<button id="gotologs" class="btn-large btn-flat">STAFF LOGS</button>
		<button id="gotodogs" class="btn-large btn-flat">DOGS ON BOARD</button>
		<button id="gotostaffs" class="btn-large btn-flat">STAFF ON DUTY</button>
	</div>
	<div class="divider"></div>
</div>
<script>
$(document).ready(function(){

	$(document).on("click", "#gototask", function(){

		  $.ajax({
            type: 'GET'
        })
        .done(function(data){
					window.open('/dogcoachfrancis/public/admin/home','_self');
        })
        .fail(function() {
            alert( "Failed." );
        });
        // to prevent refreshing the whole page page
        return false;
    });

		$(document).on("click", "#gotoinvreq", function(){

			  $.ajax({
	            type: 'GET'
	        })
	        .done(function(data){
						window.open('inventory-requests','_self');
	        })
	        .fail(function() {
	            alert( "Failed." );
	        });
	        // to prevent refreshing the whole page page
	        return false;
	    });

			$(document).on("click", "#gotologs", function(){

				  $.ajax({
		            type: 'GET'
		        })
		        .done(function(data){
							window.open('staff-logs','_self');
		        })
		        .fail(function() {
		            alert( "Failed." );
		        });
		        // to prevent refreshing the whole page page
		        return false;
		    });

				$(document).on("click", "#gotodogs", function(){

					  $.ajax({
			            type: 'GET'
			        })
			        .done(function(data){
								window.open('dogs-onboard','_self');
			        })
			        .fail(function() {
			            alert( "Failed." );
			        });
			        // to prevent refreshing the whole page page
			        return false;
			    });

					$(document).on("click", "#gotostaffs", function(){

						  $.ajax({
				            type: 'GET'
				        })
				        .done(function(data){
									window.open('staff-onduty','_self');
				        })
				        .fail(function() {
				            alert( "Failed." );
				        });
				        // to prevent refreshing the whole page page
				        return false;
				    });

});
</script>
