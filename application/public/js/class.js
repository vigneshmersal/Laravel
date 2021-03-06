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
	// Today
		// day
		moment().startOf('day'); || moment().endOf('day');
		moment().startOf('hour'); || moment().endOf('hour');
		// live time
		moment().format();  // 2021-06-03T10:29:32+05:30
		moment().calendar(); // Today at 10:33 AM

	// startOf // endOf
	moment().startOf('year'); 
	moment().startOf('quarter');
	moment().startOf('month');
	moment().startOf('week');
	moment().startOf('isoWeek'); 
	moment().startOf('day');
	moment().startOf('date');
	moment().startOf('hour');
	moment().startOf('minute');
	moment().startOf('second');
	moment().firstDayOfWeek();
	moment().firstDayOfYear();

	// array - [year, month, day, hour, minute, second, millisecond]
	moment([2010, 1, 14, 15, 25, 50, 125]); // February 14th, 3:25:50.125 PM

	// format
	// timestamp
	X - timestamp
	// year
	YYYY - 2014, YY - 14
	// Month
	M - 1 , MM - 01 , MMM - Jan , MMMM - January
	// Week
	w - 1 ,  WW - 53
	// Day
	D - 1 , DD - 01 , Do - 1st ,  DDD - 365 , DDDD - 365
	// Hour
	(0 to 23) H - 0 , HH - 23
	(1 to 24) k - 1, kk - 24
	(1 to 12) h - 1 , hh - 12
	// minute
	m - 0, mm - 59
	// second
	s - 0 , ss - 59
	// am pm
	a - am , A - AM
	moment("2021-6-3").format('dddd, MMMM Do YYYY, h:mm:ss a'); // "Thursday, June 3rd 2021, 12:00:00 am"
	moment("2021-6-3").format("DD MMM YY hh:mm:ss"); // 03 Jun 21 12:00:00
	moment("2021-6-3").format("MM"); // 06
	moment().format("ddd, hA");                       // "Sun, 3PM"
	moment( "2021-6-3" , from = "YYYY-MM-DD" ).format( to = "YYYY-MM-DD" );
	moment().format("[Today is] dddd");  // "Today is Sunday"
	// by locale
	moment().format('LT');   // 10:36 AM // h:mm A
	moment().format('LTS');  // 10:36:22 AM // h:mm:ss A
	moment().format('L');    // 06/03/2021 // MM/DD/YYYY
	moment().format('l');    // 6/3/2021 // M/D/YYYY
	moment().format('LL');   // June 3, 2021 // MMMM Do YYYY
	moment().format('ll');   // Jun 3, 2021 // MMM D YYYY
	moment().format('LLL');  // June 3, 2021 10:36 AM // MMMM Do YYYY LT
	moment().format('lll');  // Jun 3, 2021 10:36 AM // MMM D YYYY LT
	moment().format('LLLL'); // Thursday, June 3, 2021 10:36 AM // dddd, MMMM Do YYYY LT
	moment().format('llll'); // Thu, Jun 3, 2021 10:37 AM // ddd, MMM D YYYY LT

	// locale
	moment.locale();         // en

	// time difference
	moment("20111031", "YYYYMMDD").fromNow(); // 10 years ago
	moment().startOf('day').fromNow();        // 10 hours ago
	moment().endOf('day').fromNow();          // in 14 hours
	moment().startOf('hour').fromNow();       // 32 minutes ago
	moment([2007, 0, 29]).toNow(); // in 4 years
	moment([2007, 0, 29]).toNow(true); // 4 years
	moment("2007-01-28").to("2007-01-29") // "in a day"
	moment("2007-01-29").diff("2007-01-28") // 86400000
	a.diff(b, 'days') // 1
	a.diff(b, 'years');       // 1

	// add | subtract
	moment().add(1, 'day');
	moment().subtract(1, 'day');
	moment().subtract(10, 'days').calendar(); // 05/24/2021
	moment().add(1, 'days').calendar();       // Tomorrow at 10:33 AM
	moment().add(1, 'month');
	moment().add(10, 'months');
	moment().add(1, 'second');
	moment().subtract(1, 'seconds');
	moment().add(1.5, 'months')
	moment().subtract(1.5, 'months')
	moment().add(.7, 'years')
	moment().subtract(.7, 'years') 

	// check
	moment("not a real date").isValid(); // false
	moment('2010-10-20').isBefore('2010-10-21'); // true
	moment('2010-10-20').isBefore('2011-01-01', 'year'); // true
	moment('2010-10-20').isSame('2010-10-20'); // true
	moment('2010-10-20').isSame('2010-01-01', 'year');  // true
	moment('2010-01-01').isSame('2011-01-01', 'month'); // false, different year
	moment('2010-01-01').isSame('2010-02-01', 'day');   // false, different month
	moment('2010-10-20').isAfter('2010-10-19'); // true
	moment('2010-10-20').isAfter('2010-01-01', 'year'); // false
	moment('2010-10-20').isSameOrBefore('2010-10-21');  // true
	moment('2010-10-20').isSameOrBefore('2011-01-01', 'year'); // true
	moment('2010-10-20').isSameOrAfter('2010-10-21'); // false
	moment('2010-10-20').isSameOrAfter('2009-12-31', 'year'); // true
	moment('2010-10-20').isBetween('2010-10-19', '2010-10-25'); // true
	moment('2010-10-20').isBetween('2010-01-01', '2012-01-01', 'year'); // false
	moment().isLeapYear();
	moment.isMoment(new Date()) // false
	moment.isDate(new Date()); // true

	// get
	moment().get('year'); // month,date,hour,minute,second,millisecond
	moment().year()
	moment().month()
	moment().week();
	moment().day();
	moment().date();
	moment().hour();
	moment().minute();
	moment().second();
	moment().millisecond();
	moment().weekday();
	moment().dayOfYear(); // 154
	moment().isoWeek(); // 22
	moment().quarter(); // 2
	moment().valueOf(); // 1318874398806
	moment().daysInMonth(); // no of days in a month
	moment().toArray(); // [2013, 1, 4, 14, 40, 16, 154];
	moment().toObject()  // {years: 2015,months: 6,date: 26,hours: 1,minutes: 53,seconds: 14,milliseconds: 600 }
	moment().toString() // "Sat Apr 30 2016 16:59:46 GMT-0500"

	//set
	moment().set('year', 2013);
	moment().set('month', 3);  // April
	moment().set('date', 1);
	moment().set('hour', 13);
	moment().set('minute', 20);
	moment().set('second', 30);
	moment().set('millisecond', 123);
	moment().set({'year': 2013, 'month': 3});
	var d2 = d1.clone();

	// calendar
	moment().months(); // ['January', .. , 'December']
	moment().calendar(); // Today at 10:33 AM
	moment().weekdays(3); // 'Wednesday'
	moment().weekdays();
	moment().weekdaysShort();
	moment().monthsShort(); // ['jan.', 'feb.']
	moment().subtract(5, 'hours').short(); // 5h ago

	// time travel
	moment().day(-7); // last Sunday (0 - 7)
	moment().day(0); // this Sunday (0)
	moment().day(7); // next Sunday (0 + 7)
	moment().day(10); // next Wednesday (3 + 7)
	moment().day("Sunday");
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
