var number_format = function(num){
	// var fx = num.toFixed(2); 
	return parseFloat(num).toFixed(2).toLocaleString();
}
 var intVal = function ( i ) {
	return typeof i === 'string' ?
    i.replace(/[\$,]/g, '')*1 :
    typeof i === 'number' ?
        i : 0;
};