    <script type="text/JavaScript">
        function addPrices( naam )
        {
            var elements = document.getElementById("form1").elements;
            var totaal = 0.00;
            var subTotaalBedrag = document.getElementById("subtotaal"); 
            var totaalBedrag = document.getElementById("totaal"); 

            for ( i = 1; i < elements.length; i++ )
            {
                if ( document.getElementById("aantal_deelnemers"+i) != null && document.getElementById("aantal_deelnemers"+i).type == "radio" )
                {
                    if ( document.getElementById("aantal_deelnemers"+i).checked )
                    {
                        totaal += parseFloat( computePrice( document.getElementById("prijs"+i), 1 ) );
                    }
                }
                else if ( document.getElementById("aantal"+i) != null && document.getElementById("aantal"+i).type == "radio" )
                {
                    if ( document.getElementById("aantal"+i).checked )
                    {
                        totaal += parseFloat( computePrice( document.getElementById("prijs"+i), 1 ) );
                    }
                }
                else if ( document.getElementById("aantal"+i) != null && document.getElementById("aantal"+i).type == "checkbox" )
                {
                    if ( document.getElementById("aantal"+i).checked )
                    {
                        totaal += parseFloat( computePrice( document.getElementById("prijs"+i), 1 ) );
                    }
                }
                else if ( document.getElementById("aantal"+i) != null && document.getElementById("aantal"+i).type == "number" )
                {
                    totaal += parseFloat ( computePrice( document.getElementById("prijs"+i), computePrice( document.getElementById("aantal"+i).value ) ) );
                }
 
                if (document.getElementById("extra_bedrag"+i) != null)
                {
                    totaal += parseFloat ( computePrice( document.getElementById("extra_prijs"+i), 1 ) );
                }
            }
            subTotaalBedrag.value = totaal.toFixed(2);
        };

        function computePrice( element, aantal )
        {
            var prijs = element.value;
            if ( element.disabled )
            {
                return 0;
            }
            if ( isNaN( prijs ) )
            {
                return 0;
            }
            if ( prijs == 0 )
            {
                return 0;
            }
            if ( isNaN( aantal) )
            {
                return prijs
            }
            if ( aantal >= 0 )
            {
                return aantal * prijs;
            }

            return 0;
        }


        window.onload = function() 
        {
            addPrices();
            disableAllContainers();
        };

        function disableAllContainers()
        {
            var divs = document.getElementsByClassName("option");
            var i;
            for ( i = 0; i < divs.length; i++ )
            {
                var childNodes = divs[i].getElementsByTagName('*');
                for (var node of childNodes) 
                {
                  node.disabled = true;
                  //node.className = "hide";
                  node.style.display = "none";
                }
            }
        }

        function enableVoorwaarde( naam )
        {
            var input = document.getElementsByName( naam );
            for( i = 0; i < input.length; i++ )
            {
                var inputs = input[i].getElementsByTagName( "*" );
                for( j = 0; j < inputs.length; j++ )
                {
                    inputs[j].disabled = false;
                    inputs[j].style.display = "inline";
                }
                input[i].style.display = "inline";
                //input[i].className = "show";
            }
            addPrices()
        }

        function disableVoorwaarde( naam )
        {
            var input = document.getElementsByName( naam );
            for( i = 0; i < input.length; i++ )
            {
                var inputs = input[i].getElementsByTagName( "*" );
                for( j = 0; j < inputs.length; j++ )
                {
                    inputs[j].disabled = true;
                }
                //input[i].className = "hide";
                input[i].style.display = "none";
            }
            addPrices()
        }

    </script>
