{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
    <div class="window_back_half">
        <h2>{$doctitle}</h2>

            <h3>Kies een thema voor het medewerkergedeelte van het syteem</h3>

            Thema:
            <select name="thema">
                {html_options options=$taglijst selected=$thema}
            </select>

            <button type="submit" name="keuze_thema">Kies thema</button>

            Font:
            <select name="font">
                {html_options options=$fontlijst selected=$font}
            </select>

            <button type="submit" name="keuze_font">Kies font</button>

            <hr />

            <h3>Kies een thema voor het klantgedeelte van het syteem</h3>

            Thema:
            <select name="thema_klant">
                {html_options options=$taglijst selected=$thema_klant}
            </select>

            <button type="submit" name="keuze_thema_klant">Kies thema klant</button>

            Font:
            <select name="font_klant">
                {html_options options=$fontlijst selected=$font_klant}
            </select>

            <button type="submit" name="keuze_font_klant">Kies font klant</button>
        <br/>
        <button name="terug">Terug</button>
    </div>
    
    {include file="statusregel.tpl"}

</form>

{include file="footer.tpl"}