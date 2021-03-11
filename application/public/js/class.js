/**
 * javascript es6 class
 */
class inputs {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	getVal( id ) { return $( id ).val(); } // verified
	setVal( id , val ) { $( id ).val( val ); return this; }
	removeVal( id ) { $( id ).val( "" ); return this; }
	hasVal( id ) { return this.getVal( id ) ? true : false; } // verified

	enable( id ) { $( id ).attr( "disabled" , false ); return this; }
	disable( id ) { $( id ).attr( "disabled" , true ); return this; }

	setVal_And_Enable( id , val ) { this.setVal( id, val ); this.enable( id ); return this; }
	setVal_And_Disable( id , val ) { this.setVal( id, val ); this.disable( id ); return this; }
	removeVal_And_Enable( id ) { this.removeVal( id ); this.enable( id ); return this; }
	removeVal_And_Disable( id ) { this.removeVal( id ); this.disable( id ); return this; }

	// add new value to input array [] value
	addNewVal_To_InputArray(id, newVal) {
		var ary = JSON.parse( this.getVal( id ) );
		this.setVal( id , JSON.stringify( ary.push( newVal ) ) ); return this;
	}
}

class textarea {
	charactersRemainigCount() {
		var text_max = 160;
		textRemaining();
		$('#sms').keyup(function() {
			textRemaining();
		});
		function textRemaining() {
			var text_length = $('#sms').val().length;
			var text_remaining = text_max - text_length;
			if (text_remaining>=0)
				$('#textarea_feedback').html(text_remaining + ' characters remaining');
		}
	}
}

class selects {
	constructor() { this.value = 0; }

	get val() { return this.value; }
	get selectedText() {
		$( "#myselect option:selected" ).text();
		$("select[name='categories[2][id]'] option:selected").text();
		$('id').find('option:selected').text();
	}

	resetSelect( id , cmd = "--Select--" ) { $( id ).html( "<option value=''>" + cmd + "</option>" ); return this; }
	removeOptions_ExceptFirst( id ) { $( id ).find( "option" ).not( ':first' ).remove(); return this; }
	removeOptions_AfterPositions(id, pos) { $(id+" option:gt("+pos+")").remove(); return this; }
	removeOptions( id ) { $( id ).find( "option" ).remove(); return this; }
}

class select2 {
	clearBox() { $(id).val(null).trigger('change'); }
	show() { $(id).next(".select2-container").show(); }
	hide() { $(id).next(".select2-container").hide(); }
}

class event {
	triggerByClass() {
		document.getElementByClassName("example").click();
		$(".example").trigger("click");
	}

	triggerByQuerySelect() {
		var dest = document.querySelector('#input');
		dest.trigger('focus');
	}

	listenEvent() {
		var dest = document.querySelector('#input');
		dest.addEventListener('focus', function(e){ });
	}

	ver allIframes = document.getElementsByTagName("iframe");

	// $(document).on('keypress',function(e) {
		console.log(e.which);
		if(e.which == 13) // enter
		if(e.which == 110) // n
		if(e.which == 112) // p
	// });
}

class iframe {
	html() {
		var a = '<iframe src="https://ibpsguide.prepdesk.in/api/player/1" id="videoFrame" (load)="playVideo(this)" style="width:100%;height: 230px;overflow: hidden;border: 0px solid transparent;" class="iframe" allow="encrypted-media *;autoplay;" allowfullscreen></iframe>';
	}
	playVideo(frame) {
		let allIframes = document.getElementsByTagName("iframe");
		let iframe =allIframes[0].contentWindow;
		let sourcevideo = this.Livedata.prepdesk_en;
		this.globalservies.getdatafromurl('https://ibpsguide.prepdesk.in/api/video/'+sourcevideo).subscribe((data: any) => {
			iframe.postMessage({ action: 'play', payload: data['item'] }, '*');
		};
	}
}

class javascript {
	select() {
		var dest = document.querySelector("#"+id);
		var dest = document.querySelector("."+className);
		var dest = document.getElementByClassName(className);
	}
	addClass() {
		document.querySelector("#id").classList = "btn btn-primary";
	}
}

class checkboxes {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	check( id ) { $( id ).prop( "checked" , true ); return this; }
	uncheck( id ) { $( id ).prop( "checked" , false ); return this; }
	isChecked( id ) { return $( id ).prop( "checked" ); }
	checkedCount() { return $('[name="ques_id[]"]:checked').length; }

	enable( id ) { $( id ).attr( "disabled" , false ); return this; }
	disable( id ) { $( id ).attr( "disabled" , true ); return this; }

	check_And_Enable( id , val ) { this.check( id , val ); this.enable( id ); return this; }
	check_And_Disable( id , val ) { this.check( id, val ); this.disable( id ); return this; }
	uncheck_And_Enable( id ) { this.uncheck( id ); this.enable( id ); return this; }
	uncheck_And_Disable( id ) { this.uncheck( id ); this.disable( id ); return this; }

	checkall(){
		var select_all = document.getElementById("select_all"); //select all checkbox
		var checkboxes = document.getElementsByClassName("checkBoxClass"); //checkbox items
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	}
}

class radios {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	getVal( id ) { this.value = $( id + ":checked" ).val(); return this; }
}

class csses {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	show( id ) { $( id ).removeClass( "hidden" ); return this; }
	hide( id ) { $( id ).addClass( "hidden" ); return this; }

	addErrorClass(id, cls = "error") { $(id).addClass(cls); return this; }
	removeErrorClass(id, cls = "error") { $(id).removeClass(cls); return this; }

	showModal(id) { $(id).modal("show"); return this; } // verified
	hideModal(id) { $(id).modal("hide"); return this; }
	toggleModal(id) { $(id).modal("toggle"); return this; }

	/** scroll to first error (or) whatever you want */
	scroll( id = ".error:first" ) { $( "html, body").animate({ scrollTop: $( id ).offset().top - 80 }, 1000); return this; }
}

class htmls {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	get pound() { return "&pound;" } // £

	clone(id) { return $(id).clone(); }

	// replace function
	toDoubleQuot( str ) { this.value = str.replace( /&quot;/g , '"' ); return this; }
}

class tables {
	rowCount(id) { return $('#'+id+' tbody tr').length; }

	appendRow(id, tr) { $("#"+id+" tbody").append(tr); }
}

class strings {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	// converting function
	toString( str ) { this.value = str.toString(); return this; }

	toArray( str ) { this.value = Array.from( str ); return this; } // ABCD to A,B,C,D
}

class objects { // { key => "value" }
	constructor() { this.value = 0; }

	get val() { return this.value; }

	/** Determine if an exists for the given field. */
	hasVal( obj , field ) { return this.obj.hasOwnProperty( field ); }

	/** Retrieve the message for a field. */
	getVal( obj , field ) { this.value = this.obj[ field ]; return this; }

	/** Set the message for a field. */
	setVal( obj , field , value ) { this.obj[ field ] = value; return this; }

	/** Record the new. */
	store( obj , DATA ) { this.obj = DATA; return this; }

	// conversion
	toJson( obj ) { this.value = JSON.stringify( obj ); return this; }
}

class jsons { // { "key" => "value" }
	constructor() { this.value = 0; }

	get val() { return this.value; }

	// conversion
	toObject( res ) { this.value = JSON.parse( res ); return this; }

	// encode & decode
	encode( res ) { this.value = JSON.stringify( res ); return this; }
	decode( res ) { this.value = JSON.parse( res ); return this; }
}

class arrays {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	/** find array length */
	length( ary ) { this.value = ary.length; return this; }

	/** check condition will return true/false */
	isArray( ary ) { return Array.isArray( ary ); return this; }
	isEmpty( ary ) { return this.length( ary ) == 0; }

	hasAny( ary ) { return this.length( ary ) > 0; }

	/** return ture if given value exist / also mention the starting position to check */
	hasVal( ary , val , start = 0 ) { return ary.includes( val , start ); }

	/** append text before/after on each array values */
	appendBefore( ary , prefix ) { this.value = ary.map( ( v ) => `${ prefix }${ v }`); return this; }
	appendAfter( ary , postfix ) { this.value = ary.map( ( v ) => `${ v }${ postfix }`); return this; }
	appendBoth( ary , prefix , postfix ) { this.value = ary.map( ( v ) => `${ prefix }${ v }${ postfix }`); return this; }

	/** join two array's */
	join( ary1 , ary2 ) { this.value = ary1.concat( ary2 ); return this; }

	/** convert to string */
	toString( ary ) { this.value = ary.join(); return this; }

	foreach(data) {
		$.each(data, function( index, section ) {
		});
		$(".multi-categories").each(function( k, e ) {
			console.log(e.value);
		});
	}
}

class collections {

	/* laravel ->toJson() collection data's -> parse and use it whereever want */
	toCollection( res ) { return JSON.parse( res.replace( /&quot;/g , '"' ).toString() ); }

	// pluck column only (or) both key->column - from json
	pluck( json , col , key = null ) {
		var res = [];
		if ( key ) $.each( json , function( k , v ) { res [ v [ key ] ] = v [ col ]; });
		else $.each( json , function( k , v ) { res.push( v [ col ] ); });
		return res;
	}
}

class windowses {

	/* Redirect to url */
	set route( URL ) { window.location.href = URL; } // verified

	/* Reload a current page */
	reload() { window.location.reload(); } // verified
}

class ajaxs {
	constructor(LOADERID) {
		this.LOADERID = LOADERID;
		this.value = 0;
	}

	get val() { return this.value; }

	setAjaxHeaderToken() { $.ajaxSetup({ headers : { "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content') } }); }

	ajax( URL , DATA , TYPE = "GET" ) {
		return new Promise(( resolve , reject ) => {
			$.ajax({ type: TYPE, url: URL, data: DATA,
				beforeSend: function () { this.showLoader; },
				success: function ( response ) { resolve( response ); },
				error: function ( jqXHR , textStatus , errorThrown ) { console.log( textStatus ); reject( textStatus ); },
				complete: function() { this.hideLoader; }
			});
		});
	}

	showLoader() { $( this.LOADERID ).removeClass( "hidden" ); return this; }
	hideLoader() { $( this.LOADERID ).addClass( "hidden" ); return this; }
}

class loges {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	log(data) { console.log(data); }
	info(data) { console.info(data); }
	warn(data) { console.warn(data); }
	error(data) { console.error(data); }

	table(data) { console.table(data); } // print array values to table format
	json(data) { console.log( JSON.stringify( data ) ); } // print json format

	/** To check - how long the script will be run */
	startTimer(name = null) { console.time(name); }
	stopTimer(name = null) { console.timeEnd(name); }

	if(status, data) { console.assert(status, data); } // based on status(true/false) data will be displayed

	clear() { console.clear(); } // clear the console area

	count(names = null) { console.count(name); } // count how many times it's called

	/** view console by groupwise */
	startGroup(name = null) { console.group(name); }
	stopGroup(name = null) { console.groupEnd(name); }

	backTrace() { console.trace(); } // trace code how it's called
}

class momentes {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	format( date , from = "YYYY-MM-DD" , to = "YYYY-MM-DD" ) { this.value = moment( date , from ).format( to ); return this; }

	startOfTheDay() { return moment().startOf('day'); }
	endOfTheDay() { return moment().endOf('day'); }

	fromNow( date , format = "YYYY-MM-DD" ) { return moment( date , format ).fromNow(); }
}

class datetimepickers {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	setNull( id ) { $( id ).data( "DateTimePicker" ).date( null ); return this; }
}

class mathses {
	constructor() { this.value = 0; }

	get val() { return this.value; }

	sum( ...args ) { this.value = args.reduce((sum, current) => sum + current, 0); return this; }

	add( val ) { this.value = this.value + val; return this; }

	subtract( val ) { this.value = this.value - val; return this; }

	average( ...args ) { this.value = args.length ? (this.sum(...args).value) / args.length : undefined; return this; }
}

class forms {
	constructor() { this.value = 0; }

	url(id, url) { $(id).attr('action', url); return this; } // verified

	/** submit */
	submit(id) { $(id).submit(); }

	confirm() { if (!confirm('Confirm?')) return false; }
	prompt() {
		var person = prompt("Please enter your name", "Harry Potter");
  		if (person != null) {}
  	}
}

class jses {
	showLoader() { $('.overlay').show(); } // verified
	hideLoader() { $('.overlay').hide(); } // verified
}

////////////////////////
// HTML Tag handling //
////////////////////////
const input = new inputs();
const select = new selects();
const checkbox = new checkboxes();
const radio = new radios();
const css = new csses();
const html = new htmls();
const table = new tables();
const form = new forms();

/////////////////////////
// Data Type handling //
/////////////////////////
const string = new strings();
const object = new objects();
const json = new jsons();
const array = new arrays();
const collection = new collections();

////////////////////
// Page handling //
////////////////////
const ajax = new ajaxs();
const windows = new windowses();
const log = new loges();

/////////////////////////
// 3rd party handling //
/////////////////////////
const moments = new momentes();
const datetimepicker = new datetimepickers();

/////////////////////
// Jquery handling //
/////////////////////
const maths = new mathses();
const js = new jses();
