
function bereken_kosten()
{
    var prijs_fjoertoer_met = 24000;
    var prijs_fjoertoer_zonder = 20500;
    var prijs_natuur_april = 71600;
    var prijs_natuur_juni = 71600;
    var prijs_picture = 29900;
    var prijs_voornacht_picture = 2750;
    var prijs_kleintje_natuur = 29900;
    var prijs_voornacht_kleintje_natuur = 2750;
    var prijs_haven = 59250;
    var prijs_terugreis_boot = 4650;
    var prijs_terugreis_bus = 1050;
    var prijs_fietsdagen = 1050;
    var prijs_ebikedagen = 2575;
    var prijs_2p_hut_haven = 2075;
    var prijs_parkeer_haven = 4125;
    var prijs_eilandhoppen = 49500;
    var prijs_voornacht_eilandhoppen = 2750;
    var prijs_2p_hut_eilandhoppen = 2075;
    var prijs_strand = 67500;
    var prijs_parkeer_strand = 4125;
    var prijs_2p_hut_strand = 2075;
    var prijs_havenstrand = 2500;
    var prijs_oostwad = 30500;
    var prijs_voornacht_oostwad = 2550;
    var prijs_incasso = 750;

    if (document.inschrijving.inschrijvers_incasso[1].checked)
    {
        var incasso = 1;
    }

    var te_betalen = 0;
    var prijs_voornacht = 0;
    if (document.inschrijving.inschrijvers_picture_voornacht[1].checked)
    {
        var picture_voornacht = 1;
    } else
    {
        var picture_voornacht = 0;
    }
    if (document.inschrijving.inschrijvers_oostwad_voornacht[1].checked)
    {
        var oostwad_voornacht = 1;
    } else
    {
        var oostwad_voornacht = 0;
    }
    if (document.inschrijving.inschrijvers_kleintje_natuur_voornacht[1].checked)
    {
        var kleintje_natuur_voornacht = 1;
    } else
    {
        var kleintje_natuur_voornacht = 0;
    }
    if (document.inschrijving.inschrijvers_eilandhoppen_voornacht[0].checked)
    {
        var eilandhoppen_voornacht = 1;
    } else
    {
        var eilandhoppen_voornacht = 0;
    }
    var verzekering = 0;
    var prijs_annulering = 0;
    var prijs_ar_annulering = 0;
    if (document.inschrijving.inschrijvers_annulering[1].checked)
    {
        var annulering_soort = 1;
    }
    else if (document.inschrijving.inschrijvers_annulering[2].checked)
    {
        var annulering_soort = 2;
    }
    else
    {
        var annulering_soort = 0;
    }
    var havenstrand = parseInt(document.inschrijving.inschrijvers_aantal_havenstrand.value);
    if (havenstrand > 0)
    {
        document.inschrijving.inschrijvers_aantal_haven.value = havenstrand;
        document.inschrijving.inschrijvers_aantal_strand.value = havenstrand;
        te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_havenstrand.value) * prijs_havenstrand;
    }
    var aantal_haven = parseInt(document.inschrijving.inschrijvers_aantal_haven.value);
    var aantal_eilandhoppen = parseInt(document.inschrijving.inschrijvers_aantal_eilandhoppen.value);
    var aantal_strand = parseInt(document.inschrijving.inschrijvers_aantal_strand.value);
    var aantal_vuurtoren = parseInt(document.inschrijving.inschrijvers_aantal_vuurtoren.value);

    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_fjoertoer_met.value) * prijs_fjoertoer_met;
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_fjoertoer_zonder.value) * prijs_fjoertoer_zonder;
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_natuur_april.value) * prijs_natuur_april;
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_natuur_juni.value) * prijs_natuur_juni;
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_picture.value) * prijs_picture;
    te_betalen += (parseInt(document.inschrijving.inschrijvers_aantal_picture.value) * picture_voornacht * prijs_voornacht_picture);
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_kleintje_natuur.value) * prijs_kleintje_natuur;
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_kleintje_natuur.value) * kleintje_natuur_voornacht * prijs_voornacht_kleintje_natuur;
    te_betalen += aantal_haven * prijs_haven;
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_fietsdagen.value) * prijs_fietsdagen;
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_ebikedagen.value) * prijs_ebikedagen;
    if (document.inschrijving.inschrijvers_aantal_2p_hut_haven[0].checked)
    {
        te_betalen += prijs_2p_hut_haven * aantal_haven;
    }
    var soort_terugreis_haven = parseInt(document.inschrijving.inschrijvers_haven_terugreis.value);
    if (soort_terugreis_haven == 1)
    {
        te_betalen += aantal_haven * prijs_terugreis_boot;
    } else if (soort_terugreis_haven == 2)
    {
        te_betalen += aantal_haven * prijs_terugreis_bus;
    }
    te_betalen += parseInt(document.inschrijving.inschrijvers_haven_parkeren.value) * prijs_parkeer_haven;
    te_betalen += aantal_eilandhoppen * prijs_eilandhoppen;
    if (document.inschrijving.inschrijvers_aantal_2p_hut_eilandhoppen[0].checked)
    {
        te_betalen += prijs_2p_hut_eilandhoppen * aantal_eilandhoppen;
    }
    te_betalen += aantal_eilandhoppen * eilandhoppen_voornacht * prijs_voornacht_eilandhoppen;
    te_betalen += aantal_strand * prijs_strand;
    te_betalen += aantal_vuurtoren * prijs_strand;
    var soort_terugreis_strand = parseInt(document.inschrijving.inschrijvers_strand_terugreis.value);
    if (soort_terugreis_strand == 1)
    {
        te_betalen += (aantal_strand + aantal_vuurtoren) * prijs_terugreis_bus;
        te_betalen += prijs_parkeer_strand;
    } else if (soort_terugreis_strand == 2)
    {
        te_betalen += (aantal_strand + aantal_vuurtoren) * prijs_terugreis_bus;
    }
    if (document.inschrijving.inschrijvers_aantal_2p_hut_strand[0].checked)
    {
        te_betalen += prijs_2p_hut_strand * (aantal_strand + aantal_vuurtoren);
    }
    te_betalen += parseInt(document.inschrijving.inschrijvers_aantal_oostwad.value) * prijs_oostwad;
    te_betalen += (parseInt(document.inschrijving.inschrijvers_aantal_oostwad.value) * oostwad_voornacht * prijs_voornacht_oostwad);

    prijs_annulering += te_betalen * 0.055;
    prijs_annulering += 350;
    prijs_annulering += (prijs_annulering * 0.21);
    document.inschrijving.kosten_annulering.value = (prijs_annulering / 100).toFixed(2);
    prijs_ar_annulering += te_betalen * 0.07;
    prijs_ar_annulering += 350;
    prijs_ar_annulering += (prijs_ar_annulering * 0.21);
    document.inschrijving.kosten_ar_annulering.value = (prijs_ar_annulering / 100).toFixed(2);

    if (annulering_soort == 1)
    {
        te_betalen += prijs_annulering;
    }
    if (annulering_soort == 2)
    {
        te_betalen += prijs_ar_annulering;
    }
    if (incasso == 1)
    {
        te_betalen += prijs_incasso;
    }

    document.inschrijving.inschrijvers_bedrag.value = (te_betalen / 100).toFixed(2);
}