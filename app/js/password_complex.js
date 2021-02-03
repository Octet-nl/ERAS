<script type="text/JavaScript">
function passwordComplexity(password, tekst, knop) 
{
    var sterkteTekst = document.getElementById( tekst);
    var gewensteSterkte = document.getElementById("wachtwoordSterkte");;

    if (password.length == 0) 
    {
        sterkteTekst.innerHTML = "";
        document.getElementById(knop).disabled=false;
        return;
    }

    // Array van bonuspunten
    var regex = new Array();
    regex.push("(?=.*[a-z])(?=.*[A-Z])"); //Both uppercase and lowercase.
    regex.push("[0-9]"); //Digit.
    regex.push("[$@$!%*#?&]"); //Special Character.

    var sterkte = 0;

    //Validate for each Regular Expression.
    for (var i = 0; i < regex.length; i++) 
    {
        if (new RegExp(regex[i]).test(password)) 
        {
            sterkte += 2;
        }
    }

    // Lengte password 1 punt per letter
    sterkte += password.length;

    //Display status.
    var kleur = "blue";
    var tekst = "";
    var gewenst = gewensteSterkte.value * 4;

    if ( sterkte >= gewenst )
    {
      kleur = "green";
    }
    else if ( sterkte >= gewenst / 2 )
    {
      kleur = "orange";
    }
    else if ( sterkte >= gewenst / 4 )
    {
      kleur = "orangered";
    }
    else
    {
      kleur = "maroon";
    }

    sterkteTekst.innerHTML = "&bull;";
    sterkteTekst.style.color = kleur;
    if ( sterkte >= gewenst )
    {
      document.getElementById(knop).disabled=false;
      document.getElementById("sterkteOk").value="1";
    }
    else
    {
      document.getElementById(knop).disabled=true;
      document.getElementById("sterkteOk").value="0";
    }
}
</script>
