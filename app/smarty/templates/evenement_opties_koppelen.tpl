{include file="header.tpl"}

<script language="JavaScript">

    function one2two() 
    {
        m1len = m1.length;
        for (i = 0; i < m1len; i++) 
        {
            if (m1.options[i].selected == true) 
            {
                m2len = m2.length;
                m2.options[m2len] = new Option(m1.options[i].text, m1.options[i].value);
            }
        }

        for (i = (m1len - 1); i >= 0; i--) 
        {
            if (m1.options[i].selected == true) 
            {
                m1.options[i] = null;
            }
        }
    }

    function two2one() 
    {
        m2len = m2.length;
        for (i = 0; i < m2len; i++) 
        {
            if (m2.options[i].selected == true) 
            {
                m1len = m1.length;
                m1.options[m1len] = new Option(m2.options[i].text, m2.options[i].value);
            }
        }
        for (i = (m2len - 1); i >= 0; i--) 
        {
            if (m2.options[i].selected == true) 
            {
                m2.options[i] = null;
            }
        }
    }

    function vastleggen() 
    {
        for (i = 0; i < m2.length; i++) 
        {
            m2.options[i].selected = true;
        }
        selectForm.submit("verwerk");
    }

    function clearSelected() {
        var elements = document.getElementById("gekozen").options;

        for (var i = 0; i < elements.length; i++) 
        {
            if (elements[i].selected)
                elements[i].selected = false;
        }
    }

</script>

<!-- <div class="koppel_container" ; width:90%; padding:2em">-->

    <div class="koppel_container window_back">
        <div class="outer">
            <h2>Opties koppelen aan evenement</h2>
            <div class="left_div">
                <form method="POST" name="selectEvent" action="{$SCRIPT_NAME}">
                    {if $evenementNaam == ""}
                      <h2>Kies eerst een evenement</h2>
                    {else}
                      <h2>&nbsp; </h2>
                    {/if}
                    <table border="1" cellpadding="5" cellspacing="2">
                        <tr>
                            <th>Openstaande evenementen</th>
                        </tr>
                        <tr>
                            <td align="center">
                                <div>
                                    <select name="beschikbaar" size="20" onDblClick="this.form.submit()">
                                        {html_options options=$evenementenLijst}
                                    </select><br />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <button name="kies_evenement" >kies evenement</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <form method="POST" name="selectForm" action="{$SCRIPT_NAME}">
                    {if $evenementNaam == ""}
                      <h2>&nbsp; </h2>
                    {else}
                      <h2>Koppel opties voor: {$evenementNaam}</h2>
                    {/if}
                    <table border="1" cellpadding="5" cellspacing="2">
                        <tr>
                            <th>Beschikbare opties</th>
                            <th></th>
                            <th>Gekozen opties</th>
                        </tr>
                        <tr>
                            <td align="center">
                                <select name="beschikbaar" size="20" onDblClick="one2two()" multiple>
                                    {html_options options=$beschikbaarLijst}
                                </select><br />

                            </td>
                            <td align="center">
                                <p><input type="button" onClick="one2two()" value=" >> "></p>
                                <p><input type="button" onClick="two2one()" value=" << "></p>

                            </td>
                            <td align="center">
                                <select name="gekozen[]" id="gekozen" onDblClick="two2one()" size="20" multiple>
                                    {html_options options=$gekozenLijst}
                                </select><br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <button name="opslaan" onclick="vastleggen()">Opslaan</button>
                            </td>
                            <td align="center">
                                <input type="button" value="&uarr;" onClick="moveUp()">
                                <input type="button" value="&darr;" onClick="moveDown()">
                            </td>
                        </tr>
                    </table>
                    
                    <button name="terug">Terug</button> 

                    <input type="hidden" name="evenementId" value="{$evenementId}">

                    {include file="statusregel.tpl"}
                
            </div>
        </div>
    </div>
</div>



<script language="JavaScript">

    // IMPORTANT: this is the extra bit of code
    // shorthand for referring to menus
    // must run after document has been created
    // you can also change the name of the select menus and
    // you would only need to change them in one spot, here

    var m1 = document.selectForm.beschikbaar;
    //var m2 = document.selectForm.menu2;
    var m2 = document.getElementById("gekozen");

    function moveUp() {
        var sel = document.getElementById("gekozen");
        var i1 = 0, i2 = 1;
        while (i2 < sel.options.length) {
            swapIf(sel, i1++, i2++);
        }
    }
    function moveDown() {
        var sel = document.getElementById("gekozen");
        var i1 = sel.options.length - 1, i2 = i1 - 1;
        while (i1 > 0) {
            swapIf(sel, i1--, i2--);
        }
    }
    var swapVar = '';
    function swapIf(sel, i1, i2) {
        if (!sel[i1].selected && sel[i2].selected) {
            swapVar = sel[i2].text;
            sel[i2].text = sel[i1].text;
            sel[i1].text = swapVar;
            swapVar = sel[i2].value;
            sel[i2].value = sel[i1].value;
            sel[i1].value = swapVar;
            sel[i1].selected = true;
            sel[i2].selected = false;
        }
    }

</script>