<html>

<head>
    <script>
        function load() {
            document.ideal.submit()
        }
    </script>
</head>

<body onload="load()">

    <form ACTION="{$checkout_script}" id=ideal name=ideal>
        <input type="hidden" NAME="amount" VALUE="{$bedrag}">
        <input type="hidden" NAME="reference" VALUE="{$inschrijfnummer}">
        <input type="hidden" NAME="description" VALUE="{$evenementnaam} - {$inschrijfnummer}">
        <input type="hidden" NAME="url_payment" VALUE="{$url_payment}">
        <input type="hidden" NAME="url_success" VALUE="{$url_success}">
        <input type="hidden" NAME="url_failure" VALUE="{$url_failure}">
        <input type="hidden" NAME="url_pending" VALUE="{$url_pending}">
    </form>

</body>

</html>