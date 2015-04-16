<div id="divMenuRight">
    <div class="navbar">
        <button type="button" class="btn btn-navbar-highlight btn-large btn-primary" data-toggle="collapse" data-target=".nav-collapse">
            NAVIGATION <span class="icon-chevron-down icon-white"></span>
        </button>
        <div class="nav-collapse collapse">
            <ul class="nav nav-pills ddmenu">
                <li><a href='{"home"|UrlUtils::rewrite}'>Accueil</a></li>
                <li><a href='{"home"|UrlUtils::rewrite}'>Salons</a></li>
                <li><a href='{"address/list"|UrlUtils::rewrite}'>Adresses</a></li>
                <li><a href='{"home"|UrlUtils::rewrite}'>&Eacute;v&eacute;nements</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle">Utilisateur <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{"register"|UrlUtils::rewrite}">Cr&eacute;er un compte</a></li>
                        <li><a id="connexionLink" href='{"authentication"|UrlUtils::rewrite}'>Se connecter</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>