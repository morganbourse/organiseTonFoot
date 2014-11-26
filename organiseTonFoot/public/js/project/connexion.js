$(function(){    
    $("#connexionFrm").submit(
        function(event)
        {        	
            $().executeQuery(event, $(this), $(this).attr("action"), function(){
            	//success function
            	$.Dialog.close();
            }, function(){
            	//failed function
            	$().displayWarnNotification("Veuillez verifier le formulaire de connexion.<br /><br />Certaines donn&eacute;es envoy&eacute;es sont incorrectes, ou non renseign&eacute;es", 10000);
            });
        }
    );
});