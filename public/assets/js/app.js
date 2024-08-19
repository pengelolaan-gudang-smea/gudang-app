

function formatRupiahInput(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString()
        , split = number_string.split(",")
        , sisa = split[0].length % 3
        , rupiah = split[0].substr(0, sisa)
        , ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? rupiah : 0;
}

$('input[name="filter_date"]').daterangepicker({
    ranges: {
        'Hari Ini': [moment(), moment()],
        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Filter",
        "cancelLabel": "Batal",
        "fromLabel": "From",
        "customRangeLabel": "Custom",
        "toLabel": "To",
        "weekLabel": "W",
        "daysOfWeek": ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
        "monthNames": ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        "firstDay": 1
    },
    "autoUpdateInput": false,
    "alwaysShowCalendars": true,
    "opens": "right"
});