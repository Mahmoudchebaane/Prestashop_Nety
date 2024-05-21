
$('#fmm_submit_btn').on("click", function () {
	var fmm_email = document.getElementById('fmm_email');
	var fmm_name = document.getElementById('name');	
	var fmm_brief = document.getElementById('brief');
	var inputCompany = document.querySelector('input[name=company_name]').value
	var inputTel = document.querySelector('input[name=contact_number]').value
	var emailDiv = document.getElementById('emailError');
	var nameError = document.getElementById('nameError');
	var telError = document.getElementById('telError');
	var companyError = document.getElementById('companyError');
	emailDiv.innerHTML=''
	nameError.innerHTML=''
	companyError.innerHTML=''
	telError.innerHTML=''

	var modal_quote = document.getElementById('quoteModal');
    var fmm_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var fmc_filter = /^[0-9]{8}$/
	if(fmm_name.value == null || fmm_name.value === ""){
		$(fmm_name).focus();
		
		nameError.innerHTML = requiredName
	}else if(fmm_email.value == null || fmm_email.value === ""){
		emailDiv.innerHTML = requiredEmail		
	}
	else if (!fmm_filter.test(fmm_email.value)){
		//$(fmm_email).focus();		
		emailDiv.innerHTML = fmm_label_fail
		
		// return false;
	}	else if(inputCompany == null || inputCompany === ""){		
		companyError.innerHTML = requiredCompany
	}
	else if(inputTel == null || inputTel === ""){				
		telError.innerHTML = requiredTel		
	}
	else if (!fmc_filter.test(inputTel)){
		//$(fmm_email).focus();		
		telError.innerHTML = wrongTel
		
		// return false;
	}
	else{
		$('#fmm_submit_btn').prop('disabled', true);
		$('#fmm_submit_btn').attr('disabled', true);
		$('#fmm_submit_btn').css("pointer-events", " none");
		$('#fmm_submit_btn').css("opacity", "0.5");
		$('#fmm_submit_btn').css("cursor", "not-allowed");

		jQuery('#fmm_quote_form').submit();	
	}

})

