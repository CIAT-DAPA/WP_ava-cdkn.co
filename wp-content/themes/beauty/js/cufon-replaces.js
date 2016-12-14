function cufon_replace() {                                              
        Cufon.replace('h1:not(.no-cufon), h2:not(.no-cufon), h3:not(.no-cufon), h4:not(.no-cufon), h5:not(.no-cufon), h6:not(.no-cufon), div#slogan h1, h1#slogan, #slogan strong', {fontFamily: 'champagne', hover:true} );
        
    Cufon.replace('#logo a span.name', {fontFamily: 'halo'});
    Cufon.replace('#logo a span.description', {fontFamily: 'champagne'});
    Cufon.replace('#logo strong, #logo p, .sidebar-nav li, .p404 h1, .p404 h2, .p404 strong', {fontFamily: 'champagne', hover: true});
    Cufon.replace('#sidebar .menu a, h3.title-blog a', {fontFamily: 'champagne', hover: true});
}
cufon_replace();