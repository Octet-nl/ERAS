    <script type="text/JavaScript">
        function isBetaald( )
        {
            var betaald = 0;
            betaald = document.getElementById("totaalBedrag").value;
            betaald -= document.getElementById("korting").value;
            betaald -= document.getElementById("reedsBetaald").value;
            document.getElementById("nuBetaald").value = betaald.toFixed(2);
            addPrices();
        };

        function addPrices( )
        {
            var nogBetalen = 0;
            nogBetalen = document.getElementById("totaalBedrag").value;
            nogBetalen -= document.getElementById("reedsBetaald").value;
            nogBetalen -= document.getElementById("korting").value;
            nogBetalen -= document.getElementById("nuBetaald").value;
            
            document.getElementById("teBetalen").value = nogBetalen.toFixed(2);

            if ( nogBetalen < 0 )
            {
                document.getElementById("teBetalen").classList.add( "inputError" );
            }
            else
            {
                document.getElementById("teBetalen").classList.remove( "inputError" );
            }
        };

        function format()
        {
            document.getElementById("korting").value = document.getElementById("korting").value.replace(',','.');
            document.getElementById("nuBetaald").value = document.getElementById("nuBetaald").value.replace(',','.');
            addPrices();
        }

        window.onload = function() 
        {
            addPrices()
        };

    </script>
