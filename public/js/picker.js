$(function(){
    'use strict'
    $('.ui-datepicker-year').addClass('select2');
    
    // Datepicker
    $('.fc-datepicker').datepicker({
        
        showOtherMonths: true,
        selectOtherMonths: true,
        format: 'dd/mm/yyyy',
        changeYear: true,
        yearRange: "c-100:c+0"
    });

    $('#datepickerNoOfMonths').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2
        
    });

    });
  
  $(function(){
    'use strict'

    // Input Masks
    $('#dateMask').mask('99/99/9999');
    $('#phoneMask').mask('(999) 999-9999');
    $('#ssnMask').mask('999-99-9999');

    // Time Picker
    $('#tpBasic').timepicker();
    $('#tp2').timepicker({'scrollDefault': 'now'});

    $('#setTimeButton').on('click', function (){
      $('#tpBasic').timepicker('setTime', new Date());
    });

    // Color picker
    $('#colorpicker').spectrum({
      color: '#17A2B8'
    });

    $('#showAlpha').spectrum({
      color: 'rgba(23,162,184,0.5)',
      showAlpha: true
    });

    $('#showPaletteOnly').spectrum({
        showPaletteOnly: true,
        showPalette:true,
        color: '#DC3545',
        palette: [
            ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
            ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
        ]
    });

  });