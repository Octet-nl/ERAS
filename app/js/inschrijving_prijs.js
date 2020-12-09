<script type="text/JavaScript">
    (function () {
        'use strict';
        /* jshint browser: true */

        if ( document.getElementById("controleervoucher") == null )
        {
          return;
        }
        document.getElementById("controleervoucher").disabled = true;
        document.getElementById("waardevoucher").style.visibility='hidden';

        document.getElementById('vouchercode').onchange = function ()
        {
            if ( document.getElementById("vouchercode").value != "" )
            {
                document.getElementById("controleervoucher").disabled = false;
            }
            else
            {
                document.getElementById("controleervoucher").disabled = true;
            }
        };
    }());

  function codeChanged()
  {
        document.getElementById("controleervoucher").disabled = false;
  }
  function loadXMLDoc() {
      var xmlhttp = new XMLHttpRequest();

      document.getElementById("voucherOk").innerHTML = "";

      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
             if (xmlhttp.status == 200)
             {
                 var teBetalen = document.getElementById("teBetalen").value;
                 var totaalBedrag = document.getElementById("totaal").value;
                 var reedsBetaald = 0;
                 if ( document.getElementById("reedsBetaald") != null )
                 {
                    reedsBetaald = document.getElementById("reedsBetaald").value;
                 }
                 document.getElementsByName("voucherid")[0].value = 0;
                 document.getElementsByName("voucherwaarde")[0].value = 0;
                 document.getElementsByName("voucherprijs")[0].value = 0;
                 document.getElementsByName("voucherrest")[0].value = 0;
                 document.getElementById("vouchertype").value = 0;
                 document.getElementById("waardevoucher").style.visibility='hidden';

                 var velden = xmlhttp.responseText.split( "|" );
                 if ( velden[0] == 3 )
                 {
                    console.log("Checked");

                  //"03|voucher-Id|voucherWaarde|voucherVerbruikt|voucher-Email|voucher-Type"
                    var x = "{$contactpersoon_email}";
                    if ( velden[4] != "" && velden[4] != x )
                    {
                        document.getElementById("voucherOk").innerHTML = "Uw mailadres komt niet overeen met dat in de voucher. Neem a.u.b. contact met ons op.";
                    }
                    else
                    {
                      var voucherWaarde = velden[2];
                      var voucherType   = velden[5];
                      var restbedrag = 0;
                      if ( teBetalen > 0 )
                      {
                        if ( parseFloat(voucherWaarde) > parseFloat(teBetalen) )
                        {
                            restbedrag = voucherWaarde - (totaalBedrag - reedsBetaald); //teBetalen;
                            voucherWaarde = (totaalBedrag - reedsBetaald); //teBetalen;
                        }
                        else
                        {
                            //betaalbedrag = totaalBedrag;
                            restbedrag = 0;
                        }
                      }
                      else
                      {
                        restbedrag = voucherWaarde;
                        voucherWaarde = 0;
                      }
                      document.getElementsByName("voucherid")[0].value = velden[1];
                      document.getElementsByName("voucherwaarde")[0].value = toFixed((voucherWaarde), 2);
                      document.getElementsByName("voucherprijs")[0].value = toFixed((voucherWaarde), 2);
                      document.getElementsByName("voucherrest")[0].value = toFixed((restbedrag), 2);
                      document.getElementById("vouchertype").value = voucherType;
                      document.getElementById("waardevoucher").style.visibility='visible';
                      // Totaalprijs bijwerken
                      addPrices();
                    }
                 }
                 else
                 {
                    if ( velden[1] == 1)
                    {
                        document.getElementById("voucherOk").innerHTML = velden[0];
                    }
                    else
                    {
                        document.getElementById("voucherOk").innerHTML = velden[1];
                    }
                 }
             }
             else if (xmlhttp.status == 400)
             {
                document.getElementById("voucherOk").innerHTML = "Opvragen mislukt";
             }
             else
             {
                document.getElementById("voucherOk").innerHTML = "Opvragen mislukt" + xmlhttp.status;
             }
          }
      };

      xmlhttp.open("GET", "app/../checkvoucher.php?id=" + document.getElementById("vouchercode").value, true);
      xmlhttp.send();
  }

        function berekenAlles()
        {
            if ( document.getElementById("waardevoucher") != null && document.getElementById("waardevoucher").style.visibility=='visible' )
            {
                addPrices();
                loadXMLDoc();
//                location.reload();
            }
            else
            {
                addPrices();
            }
        }

        function addPrices( )
        {
            var elements = document.getElementById("form1").elements;
            var subTotaal = 0;
            var totaal = 0;
            var extraBedrag = 0;
            var annulering_gewoon = 0;
            var annulering_allrisk = 0;
            var annulering_geen = 0;
            var subTotaalBedrag = document.getElementById("subtotaal");
            var totaalBedrag = document.getElementById("totaal");
            var reedsBetaald = document.getElementById("reedsBetaald");
            var reedsBetaaldBedrag = 0;
            var teBetalen = document.getElementById("teBetalen");
            var gewoon = document.getElementById("asNorm");
            var allRisk = document.getElementById("asAr");
            var geen = document.getElementById("asGeen");
            var verzekeringGewoon = document.getElementById("annuleringGewoon");
            var verzekeringAllRisk = document.getElementById("annuleringAllRisk");
            var verzekeringGeen = document.getElementById("annuleringGeen");

            if ( reedsBetaald != null )
            {
                reedsBetaaldBedrag = reedsBetaald.value * 100;
            }

            for ( i = 1; i < elements.length; i++ )
            {
                // Aantal deelnemers wordt vermenigvuldigd met de deelnemerprijs
                if ( document.getElementById("aantal_deelnemers"+i) != null )
                {
                    if ( document.getElementById("aantal_deelnemers"+i).value > 0 )
                    {
                        subTotaal += parseInt(computePrice(document.getElementById("prijs" + i), document.getElementById("aantal_deelnemers" + i).value));
                    }
                }
                // Checkboxen en radiobuttons alleen als ze aangevinkt zijn
                else if ( document.getElementById("aantal"+i) != null && ( document.getElementById("aantal"+i).type == "radio" || document.getElementById("aantal"+i).type == "checkbox" ) )
                {
                    if ( document.getElementById("aantal"+i).checked )
                    {
                        subTotaal += parseInt(computePrice(document.getElementById("prijs" + i), 1));
                    }
                }
                // Bij numerieke gegevens wordt aantal vermenigvuldigd met de prijs
                else if ( document.getElementById("aantal"+i) != null && document.getElementById("aantal"+i).type == "number" )
                {
                    subTotaal += parseInt(computePrice(document.getElementById("prijs" + i), document.getElementById("aantal" + i).value));
                }

                // extra_bedragX worden bij subtotaal opgeteld
                if (document.getElementById("extra_bedrag"+i) != null)
                {
                    subTotaal += parseInt(computePrice(document.getElementById("extra_bedrag_prijs" + i), 1));
                }
                // extra_keuzeX worden bij totaal opgeteld
                if (document.getElementById("extra_keuze"+i) != null)
                {
                    if ( document.getElementById("extra_keuze"+i).checked )
                    {
                        extraBedrag += parseInt(computePrice(document.getElementById("extra_keuze_prijs" + i), 1));
                    }
                }
                // reeds_betaaldX wordt van totaal afgetrokken
                if (document.getElementById("reeds_betaald"+i) != null)
                {
                    if ( document.getElementById("reeds_betaald"+i).checked )
                    {
                        reedsBetaaldBedrag += parseInt(computePrice(document.getElementById("reeds_betaald_prijs" + i), 1));
                    }
                }

            }

            subTotaalBedrag.value = toFixed((subTotaal/100), 2);

//            if ( gewoon == null )
//            {
//                // Geen annuleringsverzekering
//                totaalBedrag.value = toFixed(((extraBedrag + subTotaal) / 100), 2);
//                return;
//            }

            totaal = subTotaal + extraBedrag;

            if ( gewoon != null )
            {
                // Annuleringsverzekering
                {$annulering_gewoon_formule}

                gewoon.textContent =  " (€ " + toFixed( (annulering_gewoon/100), 2) + ")";

                {$annulering_allrisk_formule}

                allRisk.textContent =  " (€ " + toFixed( (annulering_allrisk/100), 2) + ")";

                {$annulering_geen_formule}
                geen.textContent =  " (€ " + toFixed((annulering_geen/100), 2) + ")";

                if ( verzekeringGewoon.checked )
                {
                    totaal += annulering_gewoon;
                }
                else if ( verzekeringAllRisk.checked )
                {
                    totaal += annulering_allrisk;
                }
                else if ( verzekeringGeen.checked )
                {
                    totaal += annulering_geen;
                }              
            }

            totaalBedrag.value = toFixed((totaal/100), 2) ;

            if ( totaal - reedsBetaaldBedrag > 0)
            {
                teBetalen.value = toFixed(((totaal - reedsBetaaldBedrag) / 100), 2);
            }
            else
            {
                teBetalen.value = toFixed(0, 2);
            }
        }

        function toFixed( number, precision )
        {
          var multiplier = Math.pow( 10, precision );
          return Number(Math.round( number * multiplier ) / multiplier).toFixed(precision);
        }

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

            prijs *= 100;

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
                    inputs[j].style.removeProperty('display');
                }
                inputs[i].style.removeProperty('display');
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
                    inputs[j].style.setProperty('display', 'none');
                }
                inputs[i].style.setProperty('display', 'none');
            }
            addPrices()
        }

        window.onload = function()
        {
            addPrices()
            disableAllContainers()
        };

    </script>
