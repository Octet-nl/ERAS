<html>

<head>
    <script>
        function load() {
            document.idealOk.submit()
        }
    </script>
</head>

<body onload="load()">

    <form ACTION="{$url_success}" id=idealOk name=idealOk>
        <input type="hidden" NAME="amount" VALUE="{$bedrag}">
        <input type="hidden" NAME="reference" VALUE="{$inschrijfnummer}">
        <input type="hidden" NAME="description" VALUE="{$evenementnaam} - {$inschrijfnummer}">
        <input type="hidden" NAME="naam" VALUE="{$klantnaam}">
    </form>

</body>

</html>