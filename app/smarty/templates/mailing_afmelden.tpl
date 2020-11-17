<!DOCTYPE HTML>
<html>
  <head>
    <title>{$doctitle}</title>
    <link rel="stylesheet" type="text/css" href="css/colors-klant.css">
    <link rel="stylesheet" type="text/css" href="css/font-klant.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="favicon.png" type="image/png" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
  </head>
  <body>
<noscript>Deze website werkt beter met JavaScript.</noscript>
<div class="window_back_half">

<form method="post" action="{$SCRIPT_NAME}">

    <div class="outer">
        <h2>{$doctitle}</h2>
        {if $vraagEmail == "1"}
            <div class="center_div">
                Geef het email adres dat u wilt afmelden:<br/>
                <input type="text" name="email" value="{$mail}"><br/>
                <button name="afmelden">Afmelden</button>
            </div>
        {else}
            {if $bevestig != "" }
            <div class="center_div">
                {$bevestig}
            </div>
            {/if}
        {/if}
    </div>
    
    <input type="hidden" name="evenementnaam" value="{$evenementnaam}">

</form>
</div>
</body>
</html>
