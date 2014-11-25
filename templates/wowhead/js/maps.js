/*
 maps.js version 294
 changed /?maps to ?maps in ma_UpdateLink()
*/
var myMapper;
function ma_Init() {
    ma_AddOptions(ge("maps-ek"), [1, 3, 4, 8, 10, 11, 12, 28, 33, 36, 38, 40, 41, 44, 45, 46, 47, 51, 85, 130, 139, 267, 1497, 1519, 1537, 3430, 3433, 3487, 4080]);
    ma_AddOptions(ge("maps-kalimdor"), [14, 15, 16, 17, 141, 148, 215, 331, 357, 361, 400, 405, 406, 440, 490, 493, 618, 1377, 1637, 1638, 1657, 3524, 3525, 3557]);
    ma_AddOptions(ge("maps-outland"), [3483, 3518, 3519, 3520, 3521, 3522, 3523, 3703]);
    ma_AddOptions(ge("maps-northrend"), [65, 66, 67, 210, 394, 495, 2817, 3537, 3711, 4197, 4395]);
    ma_AddOptions(ge("maps-dungeons-ek"), [4095, 796, 2017, 2057, 209, 133, 1337, 1584, 1583, 717, 1581, 1417]);
    ma_AddOptions(ge("maps-dungeons-kalimdor"), [719, 2437, 718, 2100, 2557, 491, 722, 978, 2367, 2366, 4100]);
    ma_AddOptions(ge("maps-dungeons-outland"), [3849, 3847, 3846, 3717, 3716, 3715, 3562, 3713, 3714, 3792, 3790, 3791, 3789]);
    ma_AddOptions(ge("maps-dungeons-northrend"), [4120, 4228, 3477, 4494, 4196, 206, 1196, 4375, 4415, 4264, 4272, 4723, 4809, 4813, 4820]);
    ma_AddOptions(ge("maps-raids-ek"), [2677, 2562, 2717, 4075, 3805, 19]);
    ma_AddOptions(ge("maps-raids-kalimdor"), [3606, 2159, 3429, 3428]);
    ma_AddOptions(ge("maps-raids-outland"), [3618, 3836, 3959, 3607, 3842]);
    ma_AddOptions(ge("maps-raids-northrend"), [4500, 4273, 4493, 4603, 3456, 4812, 4987, 4722]);
    ma_AddOptions(ge("maps-battlegrounds"), [2597, 3277, 3358, 3820, 4384, 4710]);
    myMapper = new Mapper({
        parent: "dbs3b53",
        editable: true,
        zoom: 1,
        onPinUpdate: ma_UpdateLink,
        onMapUpdate: ma_UpdateLink
    });
    var a = location.href.indexOf("maps=");
    if (a != -1) {
        a = location.href.substr(a + 5);
        if (myMapper.setLink(a)) {
            ge("mapper").style.display = ""
        }
    }
}
function ma_AddOptions(c, b) {
    b.sort(ma_Sort);
    array_apply(b, function (a) {
        var d = ce("option");
        d.value = a;
        ae(d, ct(g_zones[typeof a == "string" ? parseInt(a) : a]));
        ae(c, d)
    })
}
function ma_Sort(d, c) {
    if (typeof d == "string") {
        d = parseInt(d)
    }
    if (typeof c == "string") {
        c = parseInt(c)
    }
    return strcmp(g_zones[d], g_zones[c])
}
function ma_ChooseZone(a) {
    if (a.value && a.value != "0") {
        if (myMapper.getZone() == 0) {
            ge("mapper").style.display = ""
        }
        myMapper.setZone(a.value)
    }
    a.selectedIndex = 0
}
function ma_UpdateLink(d) {
    var a = "?maps",
    c = d.getLink();
    if (c) {
        a += "=" + c
    }
    ge("link-to-this-map").href = a
};