{include file="header.tpl"}
<script type="text/javascript" src="js/nicEdit.js"></script> 

<form method="post" action="{$SCRIPT_NAME}">
    <h3>{$mededeling}</h3>
    <div>
        <textarea rows="35" cols="90" name="adressen" id="adressen">{$adressen}</textarea>
    </div>
    <button onclick="copy()">Copy</button>
</form>

<script>
    function copy() 
    {
        let textarea = document.getElementById("adressen");
        textarea.select();
        document.execCommand("copy");
    }
</script>
{include file="footer.tpl"}