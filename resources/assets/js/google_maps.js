export const loadedGoogleMapsAPI = new Promise( (resolve,reject) => {

    window['GoogleMapsInit'] = resolve;

    let GMap = document.createElement('script');

    GMap.setAttribute('src',
        `https://maps.googleapis.com/maps/api/js?key=AIzaSyDNLg-aR7ZONs41mb9DuBWRIG_ZiTd9SBo&callback=GoogleMapsInit&region=IN`);

    document.body.appendChild(GMap);
});