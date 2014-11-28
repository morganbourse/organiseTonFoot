<h1>
    <a class="history-back" href="#">
    <i class="icon-arrow-left-3 fg-darker smaller"></i>
    </a>
    Compte utilisateur
</h1>
<div class="row-fluid">
    <div class="span12">
        <form name="account" id="frm" action="{"register"|UrlUtils::rewrite}">
            <fieldset>
                <div class="span6">
                    <p>Les informations ci-dessous marqu&eacute;es par <sup style="color:red;font-weight:bold;">*</sup> sont obligatoires.</p>
                    <label>Pseudo<sup style="color:red;font-weight:bold;">*</sup> (Le pseudo sera utilisé pour la connexion, 20 caract&egrave;res max.)</label>
                    <span class="error_message" id="username_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="username" maxlength="20" id="username" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label>Mot de passe<sup style="color:red;font-weight:bold;">*</sup></label>
                    <span class="error_message" id="password_error_message"></span>
                    <div class="input-control password size4" data-role="input-control">
                        <input type="password" name="password" id="password" maxlength="255" autofocus="" placeholder="type password">
                        <button class="btn-reveal" tabindex="-1" type="button"></button>
                    </div>
                    <label>Confirmation du mot de passe<sup style="color:red;font-weight:bold;">*</sup></label>
                    <span class="error_message" id="pwdConfirm_error_message"></span>
                    <div class="input-control password size4" data-role="input-control">
                        <input type="password" name="pwdConfirm" maxlength="255" id="pwdConfirm" autofocus="" placeholder="type password">
                        <button class="btn-reveal" tabindex="-1" type="button"></button>
                    </div>
                    <label>Nom<sup style="color:red;font-weight:bold;">*</sup> (25 caract&egrave;res max.)</label>
                    <span class="error_message" id="name_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="name" id="name" maxlength="25" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label>Pr&eacute;nom<sup style="color:red;font-weight:bold;">*</sup> (25 caract&egrave;res max.)</label>
                    <span class="error_message" id="surname_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="surname" id="surname" maxlength="25" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label>E-mail (100 caract&egrave;res max.) <sup style="color:red;font-weight:bold;">*</sup></label>
                    <span class="error_message" id="mail_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="mail" id="mail" maxlength="100" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label>T&eacute;l&eacute;phone (Uniquement des chiffres, 10 caract&egrave;res max.)</label>
                    <span class="error_message" id="phone_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="phone" id="phone" maxlength="10" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="span6">
                    <p>Les informations ci-dessous ne sont pas obligatoires, elles ne seront pas diffus&eacute;es mais utilis&eacute;es pour la g&eacute;olocalisation afin de tracer des itin&eacute;raires vous permettant de vous situer par rapport &agrave; certains lieux définis dans l'application.</p>
                    <label>Adresse (200 caract&egrave;res max.)</label>
                    <span class="error_message" id="address_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="address" id="address" maxlength="200" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label>Code postale (num&eacute;rique, 5 caract&egrave;res max.)</label>
                    <span class="error_message" id="cp_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="cp" id="cp" maxlength="5" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                    <label>Ville (num&eacute;rique, 100 caract&egrave;res max.)</label>
                    <span class="error_message" id="city_error_message"></span>
                    <div class="input-control text size4" data-role="input-control">
                        <input type="text" name="city" id="city" maxlength="100" placeholder="type text">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </fieldset>
            <button class="button success">Valider<i class="icon-checkmark fg-white on-right"></i></button>
            <a href="#" class="button inverse">Vider le formulaire<i class="icon-cancel-2 fg-white on-right"></i></a>
        </form>
    </div>
</div>