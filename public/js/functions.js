function Validation(UtenteLivello ) {
    
    if (UtenteLivello == 'nonregistrato')  {
                  
        alert("Sorry! Per poter ritirare il coupon devi esssere un utente registrato");
              
    }else if(UtenteLivello == 'staff' || UtenteLivello == 'admin'){
        
         alert("Azione non consentita");
        
    }
}


function setPromozioni(actionUrl,formName){
    
    
               $.ajax({
                type : 'POST',
		url : actionUrl,
                data : $("#" + formName).serialize(),
                success: function setProm(data) {
                    
    
                var opts = $.parseJSON(data);
                   
                $('#selezProm').find('option').remove();
              $('#selezProm').append('<option>' +' -- Seleziona -- '+ '</option>');
                $.each(opts, function (key, val) {
                $('#selezProm').append('<option value = "'+ val +'">' + val + '</option>');
                });
                }
                    
                    
                         
               

                    });
}



function setAziende(actionUrl,formName){
    
    
               $.ajax({
                type : 'POST',
		url : actionUrl,
                data : $("#" + formName).serialize(),
                success: function setAz(data) {
                    
    
                var opts = $.parseJSON(data);
                   
                $('#selezAz').find('option').remove();
                
                $.each(opts, function (key, val) {
                $('#selezAz').append('<option value = "'+ val +'">' + val + '</option>');
                });
                }
                    
                    
                         
               

                    });
}



                

function setInfo(actionUrl,formName){
    
    
     $.ajax({
                type : 'POST',
		url : actionUrl,
                data : $("#" + formName).serialize(),

                success: function setAzandCoupon(data) {
                    var opts = $.parseJSON(data);
                    var azienda = opts.Azienda;
                    var coupemessi = opts.Coupon_emessi;
                    
                     $('#numcoupon').append('' + coupemessi + '');
                     $('#azienda').append('' + azienda + '');
                }
                    
            });
    
}


function setInfoUser(actionUrl,formName){
    
    
     $.ajax({
                type : 'POST',
		url : actionUrl,
                data : $("#" + formName).serialize(),

                success: function setUserCoupon(data) {
                    
                    var opts = $.parseJSON(data);
                    
                    var coupemessi = opts.Coupon_emessi;
                    
                     $('#numcouponuser').append('' + coupemessi + '');
                 
                }
                    
    });
}











