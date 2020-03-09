$(document).ready(function(e){
	var studentCount = 1;
	var memberField = '<div class = "form-row align-items-center" id ="studentContainer">'+
                                                '<div class="col-md-4">'+
                                                    '<div class="form-group">'+
                                                        '<label class="small mb-1" for="inputFirstName">First Name</label>'+
                                                        '<input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" name = "Firstname[]" value = "">'+
                                                    '</div>'+
                                                '</div>'+
                                                '<div class="col-md-4">'+
                                                    '<div class="form-group">'+
                                                        '<label class="small mb-1" for="inputLastName">Last Name</label>'+
                                                        '<input class="form-control py-4" id="inputLastName" name="Lastname[]" type="text" placeholder="Enter last name" />'+
                                                    '</div>'+
                                                '</div>'+
                                                '<div class="col-md-3">'+
                                                    '<div class="form-group pt-3">'+
                                                        '<button type="button" class="btn btn-danger" id = "removeStudent">Remove Student</button>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'

	$("#addStudent").click(function(e){
		if(studentCount <= 5){
			$("#memberContainer").append(memberField);
			studentCount++;
		}
	});

	$("#memberContainer").on("click","#removeStudent", function(e){
		$(this).parent('div').parent('div').parent('div').remove();
		studentCount--;
	});

	
});
