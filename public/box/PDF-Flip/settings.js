var option_PDFF = {

 

   /* BASIC SETTINGS */  

    openPage: 1,

    height: '100%',

    enableSound: false,

    downloadEnable: true, 

    direction: pdfflip.DIRECTION.LTR,

    autoPlay: true,

    autoPlayStart: false,

    autoPlayDuration: 3000,

    autoEnableOutline: false,

    autoEnableThumbnail: false,





	/* TRANSLATE INTERFACE */  

 

    text: {

      toggleSound: "Sonido",

      toggleThumbnails: "Miniaturas",

      toggleOutline: "Contents",

      previousPage: "Pagina anterior",

      nextPage: "Siguiente página",

      toggleFullscreen: "Pantalla compleeta",

      zoomIn: "Zoom In",

      zoomOut: "Zoom Out",

      downloadPDFFile: "Descargar PDF",

      gotoFirstPage: "Primera página",

      gotoLastPage: "Última página",

      play: "Activar Reproducción automática",

      pause: "Desactivar Reproducción automática",

      share: "Compartir"

    },



    /* ADVANCED SETTINGS 
    allControls: "thumbnail,play,startPage,altPrev,pageNumber,altNext,endPage,zoomIn,zoomOut,fullScreen,download,sound,share",
    */  



    hard: "none",

    overwritePDFOutline: true,

    duration: 1000,

    pageMode: pdfflip.PAGE_MODE.AUTO,

    singlePageMode: pdfflip.SINGLE_PAGE_MODE.AUTO,

	transparent: false,

	scrollWheel: true,

    zoomRatio: 1.5,

	maxTextureSize: 1600,

	backgroundImage: "pflip/background.jpg",

    backgroundColor: "#fff",

    controlsPosition: pdfflip.CONTROLSPOSITION.BOTTOM,

    allControls: "thumbnail,play,startPage,altPrev,pageNumber,altNext,endPage,zoomIn,zoomOut,fullScreen,download",

    hideControls: "outline",



};



var pdfflipLocation = "./pflip/";