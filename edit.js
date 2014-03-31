/*
 * Another In Place Editor - a jQuery edit in place plugin
 *
 * Copyright (c) 2009 Dave Hauenstein
 *
 * License:
 * This source file is subject to the BSD license bundled with this package.
 * Available online: {@link http://www.opensource.org/licenses/bsd-license.php}
 * If you did not receive a copy of the license, and are unable to obtain it,
 * email davehauenstein@gmail.com,
 * and I will send you a copy.
 *
 * Project home:
 * http://code.google.com/p/jquery-in-place-editor/
 *
 */
  
$(document).ready(function(){
    
	
	// All examples use the commit to function interface for ease of demonstration.
	// If you want to try it against a server, just comment the callback: and 
	// uncomment the url: lines.
	
	// The most basic form of using the inPlaceEditor
	$("div.edits").editInPlace({
		//callback: function(unused, enteredText) { return enteredText; },
		url: '_ferramentas/Boleto_Recall/server.php',
        params: "nome="+ $("div.edits").attr('nome') ,
		show_buttons: true,
        saving_image: "./images/ajax-loader.gif"
	});

	// This example shows how to call the function and display a textarea
	// instead of a regular text box. A few other options are set as well,
	// including an image saving icon, rows and columns for the textarea,
	// and a different rollover color.
    var $nome = "" ;
	$("div.edit").editInPlace({
		//callback: function(unused, enteredText) { return enteredText; },
		url: "_ferramentas/Boleto_Recall/server.php",
		bg_over: "#cff",
		field_type: "textarea",
		textarea_rows: "10",
		textarea_cols: "30",
        show_buttons: true,
        params: "nome="+ $("div.edit").attr('nome') ,
		saving_image: "./images/ajax-loader.gif"
	});

	// A select input field so we can limit our options
	$("#editme3").editInPlace({
		callback: function(unused, enteredText) { return enteredText; },
		// url: "./server.php",
		field_type: "select",
		select_options: "Change me to this, No way:no"
	});

	// Using a callback function to update 2 divs
	$("#editme4").editInPlace({
		callback: function(original_element, html, original){
			$("#updateDiv1").html("The original html was: " + original);
			$("#updateDiv2").html("The updated text is: " + html);
			return(html);
		}
	});
	
	$("#editme5").editInPlace({
		saving_animation_color: "#ECF2F8",
		callback: function(idOfEditor, enteredText, orinalHTMLContent, settingsParams, animationCallbacks) {
			animationCallbacks.didStartSaving();
			setTimeout(animationCallbacks.didEndSaving, 2000);
			return enteredText;
		}
	});
    
    // FILTRAR TABELA
     //add index column with all content.
         $(".filterable tr:has(td)").each(function(){
           var t = $(this).text().toLowerCase(); //all row text
           $("<td class='indexColumn'></td>")
            .hide().text(t).appendTo(this);
         });//each tr
         $("#FilterTextBox").keyup(function(){
           var s = $(this).val().toLowerCase().split(" ");
           //show all rows.
           $(".filterable tr:hidden").show();
           $.each(s, function(){
               $(".filterable tr:visible .indexColumn:not(:contains('"
                  + this + "'))").parent().hide();
           });//each
           $("#mainmiddle").removeAttr("min-height") ;
         });//key up.
     
     $("#mytable td").click(function() {
     //alert($(this).html());
     if($(this).css("background-color")=="blue") {
            $(this).css("background-color", "white");
            $(this).css("color", "black");  
     } else {
            $(this).css("background-color", "blue");
            $(this).css("color", "white");
     }
     
     });
     
     
     var calendarPicker2 = $("#calendarFilterBox").calendarPicker({
    monthNames:["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    //useWheel:true,
    //callbackDelay:500,
    years:2,
    months:4,
    days:5,
    showDayArrows:false,
    callback:function(cal) {
      $("#vd").html(cal.currentDate);
    }});

	
	// If you need to remove an already bound editor you can call

	// > $(selectorForEditors).unbind('.editInPlace')

	// Which will remove all events that this editor has bound. You need to make sure however that the editor is 'closed' when you call this.
	
});