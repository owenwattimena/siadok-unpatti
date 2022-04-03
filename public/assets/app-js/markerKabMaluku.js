function icon(L, kota) {
    return new L.DivIcon({
        className: 'my-div-icon',
        html: `<h6 style="white-space:nowrap;">${kota}</h6>`
    });
}

function markerKabMaluku(L, map) {
    L.marker([-3.3163733, 126.5720491],{icon: icon(L, 'KAB. BURU'),opacity: 0.7}).addTo(map);
    L.marker([-3.600275, 126.6161067],{icon: icon(L, 'KAB. BURU SELATAN'),opacity: 0.7}).addTo(map);
    L.marker([-6.161061, 134.4254625],{icon: icon(L, 'KAB. KEP. ARU'),opacity: 0.7}).addTo(map);
    L.marker([-7.4597688, 131.4123121],{icon: icon(L, 'KAB. KEP. TANIMBAR'),opacity: 0.7}).addTo(map);
    L.marker([-8.1439268, 127.7812751],{icon: icon(L, 'KAB. MBD'),opacity: 0.7}).addTo(map);
    L.marker([-3.3054009, 128.9569751],{icon: icon(L, 'KAB. MALUKU TENGAH'),opacity: 0.7}).addTo(map);
    L.marker([-5.8590139, 132.7284509],{icon: icon(L, 'KAB. MALUKU TENGGARA'),opacity: 0.7}).addTo(map);
    L.marker([-3.0591965, 128.1815531],{icon: icon(L, 'KAB. SBB'),opacity: 0.7}).addTo(map);
    L.marker([-3.1096585, 130.4897502],{icon: icon(L, 'KAB. SBT'),opacity: 0.7}).addTo(map);
    L.marker([-3.6933882, 128.1810017],{icon: icon(L, 'AMBON'),opacity: 0.7}).addTo(map);
    L.marker([-5.5868696, 132.7455933],{icon: icon(L, 'TUAL'),opacity: 0.7}).addTo(map);
    // L.popup({keepInView : true, closeButton	:false}).setLatLng([-3.3163733, 126.5720491]).setContent('KAB. BURU').openOn(map);
    // L.marker([-3.3163733, 126.5720491], {
    //     opacity: 0.01
    // }).bindLabel('KAB. BURU', {
    //     noHide: true
    //     , offset: [-42, -40]
    // , }).addTo(map);

    // L.marker([-3.600275, 126.6161067], {
    //     opacity: 0.01
    // }).bindLabel('KAB. BURU SELATAN', {
    //     noHide: true
    //     , offset: [-62, -10]
    // , }).addTo(map);

    // L.marker([-6.161061, 134.4254625], {
    //     opacity: 0.01
    // }).bindLabel('KAB. KEP. ARU', {
    //     noHide: true
    //     , offset: [-52, -10]
    // , }).addTo(map);

    // L.marker([-7.4597688, 131.4123121], {
    //     opacity: 0.01
    // }).bindLabel('KAB. KEP. TANIMBAR', {
    //     noHide: true
    //     , offset: [-72, -10]
    // , }).addTo(map);

    // L.marker([-8.1439268, 127.7812751], {
    //     opacity: 0.01
    // }).bindLabel('KAB. MBD', {
    //     noHide: true
    //     , offset: [-42, -10]
    // , }).addTo(map);

    // L.marker([-3.3054009, 128.9569751], {
    //     opacity: 0.01
    // }).bindLabel('KAB. MALUKU TENGAH', {
    //     noHide: true
    //     , offset: [-42, -10]
    // , }).addTo(map);

    // L.marker([-5.6630139, 132.7284609], {
    //     opacity: 0.01
    // }).bindLabel('KAB. MALUKU TENGGARA', {
    //     noHide: true
    //     , offset: [-62, -10]
    // , }).addTo(map);

    // L.marker([-3.0591965, 128.1815531], {
    //     opacity: 0.01
    // }).bindLabel('KAB. SBB', {
    //     noHide: true
    //     , offset: [-62, -10]
    // , }).addTo(map);

    // L.marker([-3.1096585, 130.4897502], {
    //     opacity: 0.01
    // }).bindLabel('KAB. SBT', {
    //     noHide: true
    //     , offset: [-22, -5]
    // , }).addTo(map);

    // L.marker([-3.6933882, 128.1810017], {
    //     opacity: 0.01
    // }).bindLabel('KOTA AMBON', {
    //     noHide: true
    //     , offset: [-22, -5]
    // , }).addTo(map);

    // L.marker([-5.6318696, 132.7455933], {
    //     opacity: 0.01
    // }).bindLabel('KOTA TUAL', {
    //     noHide: true
    //     , offset: [-22, -5]
    // , }).addTo(map);
}