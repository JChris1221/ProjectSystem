$(document).ready(function(e){


	$("#SubmitForm").click(function(e){
		if(confirm("Are you ok with the grades? All grades submitted are final.")){
			$("#EvaluationForm").submit();
		}
	});

});