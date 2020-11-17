{include file="openheader.tpl"}
    <link href="css/tail.datetime-default-blue.css" rel="stylesheet">
    <link href="css/the-datepicker.css" rel="stylesheet" />
    <script type="text/javascript" src="js/tail.datetime.js"></script>
    <script type="text/javascript" src="js/tail.datetime-nl.js"></script>
    <script type="text/javascript" src="js/the-datepicker.js"></script>
    <script type="text/javascript" src="js/nicEdit.js"></script> 
{include file="closeheader.tpl"}

    <h2>Evenementgegevens</h2>

    <form method="post" name="evenementgegevens" action="{$SCRIPT_NAME}">

        {include file="evenementgegevens.tpl"}
        
        <button name="opslaan">Opslaan</button> 
        <button name="leegmaken">Formulier leeg maken</button>
        <button name="opslaanOpties">Opslaan en opties toevoegen</button>
        {if $id != null}
        <button name="alsNieuw">Opslaan als nieuw evenement</button>
        {/if}
        <button name="terug">Terug</button> 
        
        <input type="hidden" name="isWijziging" value="{$isWijziging}">

        {include file="statusregel.tpl"}

    </form>

<script>

var korteOmschrijving;
var langeOmschrijving;

// {if $toonWysiwig}

bkLib.onDomLoaded(function() { toggleKorteOmschrijving(); } );
bkLib.onDomLoaded(function() { toggleLangeOmschrijving(); } );

// {/if}

function toggleKorteOmschrijving() {
	if(!korteOmschrijving) {
		korteOmschrijving = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('korteOmschrijving' );
	} else {
		korteOmschrijving.removeInstance('korteOmschrijving');
		korteOmschrijving = null;
	}
}

function toggleLangeOmschrijving() {
	if(!langeOmschrijving) {
		langeOmschrijving = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('langeOmschrijving' );
	} else {
		langeOmschrijving.removeInstance('langeOmschrijving');
		langeOmschrijving = null;
	}
}

function dateDifference( )
{
    // month is 0-based, that's why we need dataParts[1] - 1
    var dateParts = document.getElementById("datumBegin").value.split("-");
    const date1 = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]); 
    var dateParts = document.getElementById("datumEind").value.split("-");
    const date2 = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]); 

    //const diffTime = Math.abs(date2 - date1);
    const diffTime = (date2 - date1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    // Add one for the number of days in the interval
    document.getElementById( 'aantalDagen' ).value = diffDays + 1;
}

    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }
    Date.prototype.addMonths = function(months) {
        var date = new Date(this.valueOf());
        date.setMonth(date.getMonth() + months);
        return date;
    }
    Date.prototype.addYears = function(years) {
        var date = new Date(this.valueOf());
        date.setFullYear(date.getFullYear() + years);
        return date;
    }

// {if $toonKalenders}

    var today = new Date();

// https://www.cssscript.com/developer-date-picker/    
    const beginEvt = document.getElementById('datumBegin');
    const datepicker1 = new TheDatepicker.Datepicker(beginEvt);
    datepicker1.options.setInputFormat('d-m-Y');
    datepicker1.options.setMinDate( today.addMonths(-1) );
    datepicker1.options.setMaxDate( today.addYears(5) );
    datepicker1.options.setShowResetButton( true );
    datepicker1.options.setTitle('Startdatum');
    datepicker1.render();

    const eindEvt = document.getElementById('datumEind');
    const datepicker2 = new TheDatepicker.Datepicker(eindEvt);
    datepicker2.options.setInputFormat('d-m-Y');
    datepicker2.options.setMinDate( today.addDays(-14) );
    datepicker2.options.setMaxDate( today.addYears(5) );
    datepicker2.options.setShowResetButton( true );
    datepicker2.options.setTitle('Einddatum evenement');
    datepicker2.render();

	const beginIns = document.getElementById('inschrijfDatumBegin');
	const datepicker3 = new TheDatepicker.Datepicker(beginIns);
    datepicker3.options.setInputFormat('d-m-Y');
    datepicker3.options.setMinDate( today.addMonths(-1) );
    datepicker3.options.setMaxDate( today.addYears(5) );
    datepicker3.options.setShowResetButton( true );
    datepicker3.options.setPositionFixing( true );
    datepicker3.options.setTitle('Begindatum inschrijving');
    datepicker3.render();

    const eindIns = document.getElementById('inschrijfDatumEind');
    const datepicker4 = new TheDatepicker.Datepicker(eindIns);
    datepicker4.options.setInputFormat('d-m-Y');
    datepicker4.options.setMinDate( today.addDays(-14) );
    datepicker4.options.setMaxDate( today.addYears(5) );
    datepicker4.options.setShowResetButton( true );
    datepicker4.options.setPositionFixing( true );
    datepicker4.options.setTitle('Einddatum inschrijving');
    datepicker4.render();

    function myFunction()
    {
        datepicker2.options.setInitialDate( datepicker1.getSelectedDate() );
    }

// https://github.com/pytesNET/tail.DateTime/tree/0.4.10
// Documentatie: https://github.com/pytesNET/tail.DateTime/wiki

    tail.DateTime("#inschrijfTijdBegin", {
    dateFormat: false,
    timeFormat: 'HH:ii:ss',
    viewDecades: false,
    locale: "nl",
    weekStart: 1,
    position: "top",
    closeButton: false,
    startOpen: false,
    stayOpen: false
    });

    tail.DateTime("#inschrijfTijdEind", {
    dateFormat: false,
    timeFormat: 'HH:ii:ss',
    viewDecades: false,
    locale: "nl",
    weekStart: 1,
    position: "top",
    dateStart: new Date(),
    startOpen: false,
    stayOpen: false
    });

// {/if}

</script>
{include file="footer.tpl"}