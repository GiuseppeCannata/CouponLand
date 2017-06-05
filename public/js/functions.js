function Validation(UtenteLivello ) {
    
    if (UtenteLivello == 'nonregistrato')  {
                  
        alert("Sorry! Per poter ritirare il coupon devi esssere un utente registrato");
              
    }else if(UtenteLivello == 'staff' || UtenteLivello == 'admin'){
        
         alert("Azione non consentita");
        
    }
}





