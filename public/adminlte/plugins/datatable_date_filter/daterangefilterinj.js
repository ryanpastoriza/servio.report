(function ( $ ) {
 
    $.fn.add_date_pickers = function( options ) {

        var elem = this;

        var settings = $.extend({
            drp_id : "drp_id_default",
        	init : function(){
                var t = this;
                this.hiddenInputs = this.hidden_from_to_inputs(); 
                this.appendTableFilter();
                // console.log(dttbl);

                // check if plugin daterangepicker is already available
                 if(jQuery().DateRangePicker) {
                    // do nothing
                 }
                 else{
                 
                 }


                 // prepend daterangepicker html
        		$(elem[0]).parents('.dataTables_wrapper').prepend("<div class='col-sm-12'>\
        																<div class='pull-right'>\
        																<label>Filter Dates:</label>\
        																<input type='text' id='"+this.drp_id+"'>\
        																</div>\
        															</div>").append(this.hiddenInputs);

                var start = moment().subtract(29, 'days');
                var end = moment();


                $('#'+this.drp_id).daterangepicker({
                                                startDate: start,
                                                endDate: end,
                                                ranges: {
                                                   'Today': [moment(), moment()],
                                                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                                                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                                }
                                                }, function(start, end, label) {
                                                    this.selectedStart = start.format('MM/DD/YYYY');
                                                    this.selectedEnd = end.format('MM/DD/YYYY');

                                                    // console.log(this.selectedStart+" to "+this.selectedEnd );
                                                }).on('apply.daterangepicker', function(ev, picker) {
                                                        $('[from-date][tbl-selector='+elem.selector+']').val(picker.startDate.format('MM/DD/YYYY'));
                                                        $('[to-date][tbl-selector='+elem.selector+']').val(picker.endDate.format('MM/DD/YYYY'));
                                                        t.dttbl.draw();
                                                    });


        	},
            appendTableFilter:function(){
                $.fn.dataTableExt.afnFiltering.push(
                        function( oSettings, aData, iDataIndex ) {
                            var iFini = $('[from-date][tbl-selector='+elem.selector+']').val();
                            var iFfin = $('[to-date][tbl-selector='+elem.selector+']').val();
                            var iStartDateCol = 0;
                            var iEndDateCol = 0;

                            iFini=iFini.substring(6,10) + iFini.substring(0,2)+ iFini.substring(3,5);
                            iFfin=iFfin.substring(6,10) + iFfin.substring(0,2)+ iFfin.substring(3,5);

                            var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(0,2)+ aData[iStartDateCol].substring(3,5);
                            var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(0,2) + aData[iEndDateCol].substring(3,5);


                            if($(oSettings.nTable)[0] == $(elem.selector)[0]){

                                if ( iFini === "" && iFfin === "" )
                                {
                                    return true;
                                }
                                else if ( iFini <= datofini && iFfin === "")
                                {
                                    return true;
                                }
                                else if ( iFfin >= datoffin && iFini === "")
                                {
                                    return true;
                                }
                                else if (iFini <= datofini && iFfin >= datoffin)
                                {
                                    return true;
                                }
                                return false;
                            }
                            
                        }
                    );
            },
            hidden_from_to_inputs: function(){
                var inputs = $("<input type='hidden' tbl-selector="+ elem.selector +" from-date><input type='hidden' tbl-selector="+ elem.selector +" to-date>");
                return inputs;
            }
        }, options );
 
        settings.init();

        return this;

    };
 
}( jQuery ));