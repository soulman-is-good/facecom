(function($) {
    var regions = $.i18n.regions,
        en = $.i18n.defaults,
        standard = en.calendars.standard,
        region = regions["dsb"] = $.extend(true, {}, en, {
        name: "dsb",
        englishName: "Lower Sorbian",
        nativeName: "dolnoserbšćina",
        language: "dsb",
        numberFormat: {
            ',': ".",
            '.': ",",
            percent: {
                ',': ".",
                '.': ","
            },
            currencies: {'':{
                pattern: ["-n $","n $"],
                ',': ".",
                '.': ",",
                symbol: "€"
            }}
        },
        calendars: {
            standard: $.extend(true, {}, standard, {
                '/': ". ",
                firstDay: 1,
                days: {
                    names: ["njeźela","ponjeźele","wałtora","srjoda","stwortk","pětk","sobota"],
                    namesAbbr: ["nje","pon","wał","srj","stw","pět","sob"],
                    namesShort: ["n","p","w","s","s","p","s"]
                },
                months: {
                    names: ["januar","februar","měrc","apryl","maj","junij","julij","awgust","september","oktober","nowember","december",""],
                    namesAbbr: ["jan","feb","měr","apr","maj","jun","jul","awg","sep","okt","now","dec",""]
                },
                monthsGenitive: {
                    names: ["januara","februara","měrca","apryla","maja","junija","julija","awgusta","septembra","oktobra","nowembra","decembra",""],
                    namesAbbr: ["jan","feb","měr","apr","maj","jun","jul","awg","sep","okt","now","dec",""]
                },
                AM: null,
                PM: null,
                eras: [{"name":"po Chr.","start":null,"offset":0}],
                patterns: {
                    d: "d. M. yyyy",
                    D: "dddd, 'dnja' d. MMMM yyyy",
                    t: "H.mm 'goź.'",
                    T: "H:mm:ss",
                    f: "dddd, 'dnja' d. MMMM yyyy H.mm 'goź.'",
                    F: "dddd, 'dnja' d. MMMM yyyy H:mm:ss",
                    M: "d. MMMM",
                    Y: "MMMM yyyy",
                    l: "d. M. yyyy H.mm 'goź.'",
                    L: "d. M. yyyy H:mm:ss"
                }
            })
        }
    }, regions["dsb"]);
    region.calendar = region.calendars.standard;
    region.numberFormat.currency = region.numberFormat.currencies[''];
})(jQuery);