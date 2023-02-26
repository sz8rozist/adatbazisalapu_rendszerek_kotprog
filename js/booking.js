function chooseSeat(seat){
    var max_szemely = seat.getAttribute("id");
    //TODO: Annyi széket lehessen kiválasztani ahány utasnak akarunk foglalni.
    seat.classList.toggle("kivalasztott");
}