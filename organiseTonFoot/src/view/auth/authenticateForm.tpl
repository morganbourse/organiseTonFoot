<script src="public/js/project/connexion.js" type="text/javascript"></script>

<fieldset>
    <form name="connexion" id="connexionFrm" action="{"authentication"|UrlUtils::rewrite}" method="POST">
        <label>Utilisateur : <span class="error_message" id="login_error_message"></span></label>
        <div class="input-control text size5" data-role="input-control">
            <input type="text" name="login" id="login" placeholder="login" />
            <button class="btn-clear" tabindex="-1" type="button"></button>                        
        </div>
        
        <label>Mot de passe : <span class="error_message" id="pwd_error_message"></span></label>        
        <div class="input-control password size5" data-role="input-control">
            <input type="password" name="pwd" id="pwd" placeholder="mot de passe" />
            <button class="btn-reveal" tabindex="-1" type="button"></button>
        </div>
                
        <br />
        <button class="button primary">Connexion<i class="icon-key fg-yellow on-right"></i></button>
        <a href="#" class="button inverse">S'inscrire<i class="icon-user-2 fg-white on-right"></i></a>        
        <a href="#" class="button inverse">Mot de passe oubli&eacute; ?</a>
    </form>    
</fieldset>