myjQuery = (typeof myjQuery != 'undefined' ) ? myjQuery : jQuery;
myjQuery(function(){
(function($) {
	$.fn.rcalendar = function(options){
	    var opt = $.extend({},
				{
				    title:"",
				    colors:["FFF","FCC","FC9","FF9","FFC","9F9","9FF","CFF","CCF","FCF",
                            "CCC","F66","F96","FF6","FF3","6F9","3FF","6FF","99F","F9F",
                            "BBB","F00","F90","FC6","FF0","3F3","6CC","3CF","66C","C6C",
                            "999","C00","F60","FC3","FC0","3C0","0CC","36F","63F","C3C",
                            "666","900","C60","C93","990","090","399","33F","60C","939",
                            "333","600","930","963","660","060","366","009","339","636",
                            "000","300","630","633","330","030","033","006","309","303"
                            ],
				    defaultColor:"F66",
                    partial_colors:["CCC","F66","FF6","6F9","6FF","F9F",
                                    "999","C00","FC3","3C0","36F","C3C",
                                    "333","600","963","060","009","636"
                                    ],
				    partial_defaultColor:"F66",
                    separator2: " - ",
				    ajaxURL:pathCalendar,
				    dialogWidth:400,
				    edition:true,
				    readonly:false,
				    partialDate:true,
				    workingDates:[1,1,1,1,1,1,1],//default [1,1,1,1,1,1,1]
				    holidayDates:[],
				    startReservationWeekly:[1,1,1,1,1,1,1],//default [1,1,1,1,1,1,1]
				    startReservationDates:[],
				    fixedReservationDates:false,//0
				    fixedReservationDates_length:0,
				    firstDay:0,
				    language:"",
				    dformat:"mm/dd/yy",
				    minDate:"",
				    maxDate:"",
				    showTooltipOnMouseOver:false,
				    numberOfMonths:1
				},options, true);
		if (opt.edition) opt.showTooltipOnMouseOver = true;
		if (opt.partialDate)
		{
		    opt.colors = opt.partial_colors;
		    opt.defaultColor = opt.partial_defaultColor;
		}		
		opt.id = $(this).attr("id");
		var id = $(this).attr("id");
		var timeOut = true;
		var data = new Array();
		$("#"+opt.id).html( '<div class="dp" id="dp'+opt.id+'"></div><input type="hidden" name="selDay_start'+opt.id+'" id="selDay_start'+opt.id+'" /><input type="hidden" name="selMonth_start'+opt.id+'" id="selMonth_start'+opt.id+'" /><input type="hidden" name="selYear_start'+opt.id+'" id="selYear_start'+opt.id+'" /><input type="hidden" name="selDay_end'+opt.id+'" id="selDay_end'+opt.id+'" /><input type="hidden" name="selMonth_end'+opt.id+'" id="selMonth_end'+opt.id+'" /><input type="hidden" name="selYear_end'+opt.id+'" id="selYear_end'+opt.id+'" />' );
        var selectedDates = {l:"",u:""};
		var dateToStr = function(d1,d2,dformat){
		    var str = $.datepicker.formatDate(dformat, d1);
		    if (d1.toString()!=d2.toString())
		        str += opt.separator2 + $.datepicker.formatDate(dformat, d2);
		    return str;
		};
		var setHiddenFields = function(dl,du){
		    $("#selDay_start"+opt.id).val((dl=="")?"":dl.getDate());
            $("#selMonth_start"+opt.id).val((dl=="")?"":dl.getMonth()+1);
            $("#selYear_start"+opt.id).val((dl=="")?"":dl.getFullYear());
            $("#selDay_end"+opt.id).val((du=="")?"":du.getDate());
            $("#selMonth_end"+opt.id).val((du=="")?"":du.getMonth()+1);
            $("#selYear_end"+opt.id).val((du=="")?"":du.getFullYear());
	    }
		var showDialogEdition = function(td,eventText,classn){
		    $(".myover").remove();
            $(".myoverAdd").dialog( "close" );
		    td.append("<div class=\""+classn+"\" >"+eventText+"</div>");
                $("."+classn).dialog({width:opt.dialogWidth,
                  close: function( event, ui ) {
                    if ($(this).hasClass("myoverAdd"))
                    {
                        $(".myoverAdd").remove();
                        selectedDates.l = "";
                        selectedDates.u = "";
                        setHiddenFields(selectedDates.l,selectedDates.u);
                        render();
                    }
                  },
                  position: {
                    my: "left top",
                    at: "center bottom",
                    collision: "fit",
                    of: $("."+classn).parent()
                  }
                }).addClass("mv_dlg_nmonth").parent().addClass("mv_dlg");
                $("<div id=\"mv_corner\" />").appendTo($(".mv_dlg .ui-dialog-titlebar"));
                move_mv_dlg();
                $(".comboColor").click(function(){
                    $(this).find(".listColor").css("display","");
                    });
                $(".comboColor .listColor div").click(function(){
                    var c = $(this).attr("c");
                    $(this).parent().css("display","none");
                    $(this).parent().parent().css("background","#"+c).attr("c",c);
                    return false;
                    });
                $(".bCancelEvent").click(function(){   
                    try{
                    $( ".myover" ).dialog( "close" );
                    $( ".myoverAdd" ).dialog( "close" );
                    } catch (e) { }
                    return false;
                });
                $(".bSaveEvent").click(function(){

                    saveData($(this).parent().parent().parent().find(".eIndex").val(),$(this).parent().parent().find(".eTitle").val(),$(this).parent().parent().find(".eDesc").val(),$(this).parent().parent().find(".comboColor").attr("c"));
                    $(".myover").remove();
                    $(".myoverAdd").remove();
                    return false;
                });
		};
        var getEventEdition = function(d){
		    var str = "";
		    for (var i=0;i<data.length;i++)
            {
                if ( (d >= data[i].l && d <=data[i].u))
                {
                    str += '<div style="border-left:3px solid #'+data[i].c+';padding-left:10px;margin-bottom:10px;">';
                    str += '<div >'+dateToStr(data[i].l,data[i].u,opt.dformat)+'</div>';
                    str += '<div><input type="hidden" class="eIndex" id="eIndex'+data[i].id+'" value="'+i+'"/></div>';

                    str += '<div class="eRead">';
                    str += '<div>'+data[i].title+'</div>';
                    str += '<div>'+data[i].description+'</div>';
                    if (opt.edition)
                        str += '<div ><a href="" class="bEditEvent">Edit Event</a> &nbsp;  &nbsp; <a href="" class="bDelEvent">Delete Event</a></div>';
                    str += '</div>';
                    str += '<div class="eWrite" style="display:none">';
                    str +=     '<div class="comboColor" style="background:#'+data[i].c+'" c="'+data[i].c+'"><div class="listColor '+((opt.partialDate)?"partialDate":"")+'" style="display:none">';
                    for (var j=0;j<opt.colors.length;j++)
                        str += '<div style="background:#'+opt.colors[j]+';" c="'+opt.colors[j]+'"></div>';
                    str +=     '</div></div>';
                    str += '<div><input type="text" class="eTitle" id="eTitle'+data[i].id+'" value="'+data[i].title+'"/></div>';
                    str += '<div><textarea id="eDesc'+data[i].id+'" class="eDesc" >'+data[i].description+'</textarea></div>';
                    str += '<div ><a href="" class="bSaveEvent">Save Event</a> &nbsp;  &nbsp; <a href="" class="bCancelEvent">Cancel</a></div>';
                    str += '</div>';
                    str += '</div>';
                }
            }
		    return str;
		};
		var getAddEdition = function(){
		    var str = "";
                    str += '<div>';
                    str += '<div >'+dateToStr(selectedDates.l,selectedDates.u,opt.dformat)+'</div>';
                    str += '<div><input type="hidden" class="eIndex" id="eIndex" value="-1"/></div>';
                    str += '<div class="eWrite" >';
                    str +=     '<div class="comboColor" style="background:#'+opt.defaultColor+'" c="'+opt.defaultColor+'"><div class="listColor '+((opt.partialDate)?"partialDate":"")+'" style="display:none">';
                    for (var j=0;j<opt.colors.length;j++)
                        str += '<div style="background:#'+opt.colors[j]+';" c="'+opt.colors[j]+'"></div>';
                    str +=     '</div></div>';
                    str += '<div>Title<br /><input type="text" class="eTitle" id="eTitle" /></div>';
                    str += '<div>Description<br /><textarea id="eDesc" class="eDesc" ></textarea></div>';
                    str += '<div ><a href="" class="bSaveEvent">Save Event</a> &nbsp;  &nbsp; <a href="" class="bCancelEvent">Cancel</a></div>';
                    str += '</div>';
                    str += '</div>';
		    return str;
		};
		var render = function(){
		    if ($("#dp"+opt.id).find(".ui-datepicker-calendar").length==0)
		      createCalendar();
		    else
		    {
		        timeOut = true;
		        $("#dp"+opt.id).datepicker("refresh");
		    }

		};
		var createCalendar = function()
		{
		    var dStringClass = new Array();
            timeOut = true;
            if ($("#dp"+opt.id)) $("#dp"+opt.id).datepicker("destroy");
            cleanDatepicker();
            $("#dp"+opt.id).datepicker({
                showOtherMonths: false,
                numberOfMonths:opt.numberOfMonths,
                onSelect: function(d,inst) {
                    timeOut = true;
                    if (opt.readonly)
                        return;
                    
                    if ((opt.fixedReservationDates) && (selectedDates.l=="" || (selectedDates.l!="" && selectedDates.u!="")))
                    {
                        selectedDates.l = $.datepicker.parseDate(opt.dformat,d);
                        selectedDates.u = "";
                        var tmpdate = new Date(selectedDates.l.getTime());
                        
                        tmpdate.setDate(tmpdate.getDate() + opt.fixedReservationDates_length - ((opt.partialDate)?0:1));
                        d = $.datepicker.formatDate(opt.dformat, tmpdate);
                    }                            
                    if (selectedDates.l=="" || (selectedDates.l!="" && selectedDates.u!=""))
                    {
                        selectedDates.l = $.datepicker.parseDate(opt.dformat,d);
                        selectedDates.u = "";
                        setHiddenFields(selectedDates.l,selectedDates.u);
                    } 
                    else //if (selectedDates.u=="")
                    {
                        var l = selectedDates.l;
                        var u = $.datepicker.parseDate(opt.dformat,d);
                        var b = (l <= u);
                        var dl = b ? l : u;
                        var du = b ? u : l;
                        //check if possible
                        var isPossible = true;
                        for (var i=0;i<data.length;i++)
                        {
                            if ( (dl <= data[i].l && du >=data[i].u))
                                isPossible = false;
                        }
                        var tmpdate = new Date(dl.getTime());
                        while (tmpdate<=du)
                        {
                            if ((opt.workingDates[tmpdate.getDay()]==0)  || (opt.holidayDates.length>0 && opt.holidayDates.indexOf($.datepicker.formatDate('yy-mm-dd', tmpdate))!="-1"))
                            {
                                isPossible = false;
                                tmpdate = new Date(du.getTime());
                            }
                            tmpdate.setDate(tmpdate.getDate() + 1);    
                        }
                        //if (isPossible && (dl.toString()!=du.toString()))
                        if (isPossible && (!opt.partialDate || (dl.toString()!=du.toString()) ) )
                        {
                            selectedDates.l = dl;
                            selectedDates.u = du;
                            setHiddenFields(selectedDates.l,selectedDates.u);
                            if (opt.edition)
                            {
                                var dString = opt.id+"dmy"+(du.getMonth()+1)+"_"+du.getDate()+"_"+du.getFullYear();
                                setTimeout(function(){
                                    showDialogEdition($("."+dString),getAddEdition(),"myoverAdd");
                                },100);
                            }
                        }
                        else
                        {
                            if (opt.fixedReservationDates)
                                selectedDates.l = "";
                            else
                                selectedDates.l = $.datepicker.parseDate(opt.dformat,d);
                            selectedDates.u = "";
                            setHiddenFields(selectedDates.l,selectedDates.u);
                        }


                    }

                },
                onChangeMonthYear: function(){
                    timeOut = true;
                    $(".myover").remove();
                    try {$(".myoverAdd").dialog( "close" );} catch (e) { }
                },
                beforeShowDay: function (d) {
                        var c = "";
                        var n = 0;
                        var co = "";
                        var co_l = "";
                        var co_r = "";
                        for (var i=0;i<data.length;i++)
                        {
                            if ( (d > data[i].l && d <data[i].u))
                            {
                                c = "specialDate";
                                n = 2;
                                co = data[i].c;
                            }
                            else if (d.toString() == data[i].l.toString())
                            {
                                c = "specialDate"+((opt.partialDate)?"Left":"");
                                n++;
                                if (n>1) c = "specialDate"+((opt.partialDate)?"Middle":"");
                                if (opt.partialDate) co_l = data[i].c; else co = data[i].c;
                            }
                            else if (d.toString() == data[i].u.toString())
                            {
                                c = "specialDate"+((opt.partialDate)?"Right":"");
                                n++;
                                if (n>1) c = "specialDate"+((opt.partialDate)?"Middle":"");;
                                if (opt.partialDate) co_r = data[i].c; else co = data[i].c;
                            }
                        
                        }
                        if ( (d > selectedDates.l && d <selectedDates.u)  )
                        {
                            c = "specialDate";
                            co = opt.defaultColor;
                            //n++;
                        }
                        else if (d.toString() ==selectedDates.l.toString() && selectedDates.u=="")
                        {
                            c = "specialDateStart";
                            if (opt.partialDate) co_l = opt.defaultColor; else co = opt.defaultColor;
                            //n++;
                        }
                        else if (d.toString() ==selectedDates.l.toString())
                        {
                            c = "specialDate"+((opt.partialDate)?"Left":"");;
                            if (opt.partialDate) co_l = opt.defaultColor; else co = opt.defaultColor;
                            //n++;
                        }
                        else if (d.toString() ==selectedDates.u.toString())
                        {
                            c = "specialDate"+((opt.partialDate)?"Right":"");;
                            if (opt.partialDate) co_r = opt.defaultColor; else co = opt.defaultColor;
                            //n++;
                        }
                        dString = "";
                        if (c != "")
                        {
                            dString = opt.id+"dmy"+(d.getMonth()+1)+"_"+d.getDate()+"_"+d.getFullYear();
                            dStringClass[dStringClass.length]= {d:dString,c:co,co_l:co_l,co_r:co_r,n:n};
                            c += " dw_active";
                        }
                        if (timeOut)
                        {
                            setTimeout(function(){
                                for (var i=0;i<dStringClass.length;i++)
                                {
                                    $('#'+opt.id+' .specialDate.'+dStringClass[i].d).css("background-color","#"+dStringClass[i].c);
                                    if (opt.partialDate)
                                    {
                                        
                                        $('#'+opt.id+' .specialDateRight.'+dStringClass[i].d).css("background-color","#"+dStringClass[i].co_r);
                                        $('#'+opt.id+' .specialDateLeft.'+dStringClass[i].d).css("background-color","#"+dStringClass[i].co_l);
                                        if (dStringClass[i].co_l!=dStringClass[i].co_r)
                                            $('#'+opt.id+' .specialDateMiddle.'+dStringClass[i].d).css("background-image","url("+pathCalendar_full+"/c_"+dStringClass[i].co_r+"x"+dStringClass[i].co_l+".png)")
                                        else 
                                            $('#'+opt.id+' .specialDateMiddle.'+dStringClass[i].d).css("background-color","#"+dStringClass[i].co_l);   
                                        if ((selectedDates.l!="") && (dStringClass[i].co_r!="") && (dStringClass[i].n==1) && (dStringClass[i].d == opt.id+"dmy"+(selectedDates.l.getMonth()+1)+"_"+selectedDates.l.getDate()+"_"+selectedDates.l.getFullYear()))
                                            $('#'+opt.id+' .specialDateLeft.'+dStringClass[i].d).css("background-color","none").css("background-image","url("+pathCalendar_full+"/c_"+dStringClass[i].co_r+"x"+opt.defaultColor+".png)");
                                        //else
                                        //    
                                        if ((selectedDates.u!="") && (dStringClass[i].co_l!="") && (dStringClass[i].n==1) && (dStringClass[i].d == opt.id+"dmy"+(selectedDates.u.getMonth()+1)+"_"+selectedDates.u.getDate()+"_"+selectedDates.u.getFullYear()))
                                            $('#'+opt.id+' .specialDateRight.'+dStringClass[i].d).css("background-color","none").css("background-image","url("+pathCalendar_full+"/c_"+opt.defaultColor+"x"+dStringClass[i].co_l+".png)");
                                        //else
                                        //    
                                    }
                                }
                                if (opt.showTooltipOnMouseOver)
                                {
                                    $("#"+opt.id+" .ui-datepicker .dw_active").live('mouseover', function(){
                                        if (!$(this).hasClass("ui-datepicker-other-month"))
                                        {

                                            var tmpd = $(this).attr("class").split("dmy");
                                            var d = tmpd[1].split("_");
                                            var titleDay = new Date(d[2].substring(0,4),d[0]-1,d[1]);
                                            $(".myover").remove();
                                            var eventText = getEventEdition(titleDay);
                                            if (eventText!="")
                                            {
                                                showDialogEdition($(this),eventText,"myover");
                                                $(".bEditEvent").click(function(){
                                                    $(this).parent().parent().parent().find(".eRead").css("display","none");
                                                    $(this).parent().parent().parent().find(".eWrite").css("display","");
                                                    return false;
                                                })
                                                $(".bDelEvent").click(function(){
                                                    var ind = $(this).parent().parent().parent().find(".eIndex").val();
                                                    $.post(opt.ajaxURL+"?dex_bccf_calendar_load2=delete", [
                                                    { name: "id", value:data[ind].id  }
                                                    ], function(d) {
                                                        if (d) {
                                                            if (!d.isSuccess) {
                                                                alert("Deleting data error: "+d.msg)
                                                            }
                                                            else {
                                                                data.splice(ind,1);
                                                                render();
                                                            }
                                                        }
                                                    }, "json");
                                                    $(".myover").remove();
                                                    return false;
                                                })

                                            }
                                            return false;

                                       }
                                    }).live('mouseout',function(){
                                    });
                                }
                                }, 1);
                            timeOut = false;
                        }
                        //if (opt.workingDates[d.getDay()]==0)
                        //    return [false,"ui-non-working"];
                        //else if (opt.holidayDates.indexOf($.datepicker.formatDate('yy-mm-dd', d))!="-1")
                        //    return [false,"ui-non-working"];
                        //else  
                        var r =  (
                        ((n>1 && opt.partialDate) 
                        || (n>0 && !opt.partialDate))
                        || (opt.workingDates[d.getDay()]==0 && (opt.startReservationDates.indexOf($.datepicker.formatDate('yy-mm-dd', d))=="-1"))
                        || (opt.holidayDates.length>0 && opt.holidayDates.indexOf($.datepicker.formatDate('yy-mm-dd', d))!="-1")
                        || (opt.startReservationWeekly[d.getDay()]==0 && (opt.startReservationDates.indexOf($.datepicker.formatDate('yy-mm-dd', d))=="-1"))
                        //|| (
                        //(opt.fixedReservationDates)
                        //&& (opt.startReservationDates.indexOf($.datepicker.formatDate('yy-mm-dd', d))!="-1")
                        //)
                        ?false:true); //startReservationDates
                        //return [(((n>1 && opt.partialDate) || (n>0 && !opt.partialDate))?false:true),c+" "+dString];
                        return [r,c+" "+dString]; 
		    		}


                });
                adaptWH();
                $("#dp"+opt.id).datepicker("option", $.datepicker.regional[opt.language]); 
                $("#dp"+opt.id).datepicker("option", "dateFormat", opt.dformat );
                $("#dp"+opt.id).datepicker("option", "minDate", opt.minDate );
                $("#dp"+opt.id).datepicker("option", "maxDate", opt.maxDate );
                $("#dp"+opt.id).datepicker("option", "firstDay", opt.firstDay );
                $.datepicker.setDefaults($.datepicker.regional['']); 
                $(".myover").remove();
        };
		var loadData = function()
		{   
		    try {
		        $.ajax({
                    type: "POST", //
                    async:false,
                    url: opt.ajaxURL+"?dex_bccf_calendar_load2=list&id="+opt.calendarId,
                    d: [],
			        dataType: "json",
                    dataFilter: function(d, type) {
                        return d;
                      },
                    success: function(d) {
                        if (!d.isSuccess) {
                            alert("Loading data error: "+d.msg)
                        }
                        else {
                            data = d.events;
                            for (var i=0;i<data.length;i++)
		                    {
		                        data[i].l = $.datepicker.parseDate("mm/dd/yy",data[i].dl);
		                        data[i].u = $.datepicker.parseDate("mm/dd/yy",data[i].du);
		                    }
                            render();
                        }
                    },
                    error: function(d) {
						try {
                            alert("Loading (processing) data error: "+d);
                        } catch (e) { }
                    }
                }); 
            } catch (e) { }
		};
		var saveData = function(ind,title,desc,c)
		{
		    if (ind=="-1")
		    {
		        $.post(opt.ajaxURL+"?dex_bccf_calendar_load2=add&id="+opt.calendarId, [
                    { name: "startdate", value: selectedDates.l.getFullYear()+"-"+(selectedDates.l.getMonth()+1)+"-"+selectedDates.l.getDate() },
                    { name: "enddate", value: selectedDates.u.getFullYear()+"-"+(selectedDates.u.getMonth()+1)+"-"+selectedDates.u.getDate() },
                    { name: "title", value: title },
                    { name: "description", value: desc },
                    { name: "color", value: c }

                    ], function(d) {
                        if (d) {
                            if (!d.isSuccess) {
                                alert("Saving (add) data error: "+d.msg)
                            }
                            else {
                                d.events[0].l = $.datepicker.parseDate("mm/dd/yy",d.events[0].dl);
                                d.events[0].u = $.datepicker.parseDate("mm/dd/yy",d.events[0].du);
                                data[data.length] = d.events[0];
                                selectedDates.l = "";
                                selectedDates.u = "";
                                setHiddenFields(selectedDates.l,selectedDates.u);
                                render();
                            }
                        }
                    }, "json");
            }
            else
            {
		        $.post(opt.ajaxURL+"?dex_bccf_calendar_load2=edit", [
                    { name: "id", value:data[ind].id  },
                    { name: "title", value: title },
                    { name: "description", value: desc },
                    { name: "color", value: c }
                    ], function(d) {
                        if (d) {
                            if (!d.isSuccess) {
                                alert("Saving (edit) data error: "+d.msg)
                            }
                            else {
                                data[ind].title = title;
                                data[ind].desc = desc;
                                data[ind].c = c;
                                render();
                            }
                        }
                    }, "json");
            }
		}
		loadData();
        return this;
	}
	function move_mv_dlg(){
        $(".mv_dlg").css("top",parseFloat($(".mv_dlg").css("top"))+17);
        $(".mv_dlg").css("left",parseFloat($(".mv_dlg").css("left"))-29);
    }
	function adaptWH()
	{
	    $(".rcalendar").each(function(){
                $(this).find(".ui-datepicker").css("width","");
                var h = 0;
                var w = 0;
                $(this).find(".ui-datepicker-group").each(function(){
                    if (h < ($(this).css("height").replace("px","")*1)) h = $(this).css("height").replace("px","")*1;
                });
                $(this).find(".ui-datepicker-group").each(function(){
                    if (w < ($(this).css("width").replace("px","")*1)) w = $(this).css("width").replace("px","")*1;
                });
                if (h!=0) $(this).find(".ui-datepicker-group").each(function(){$(this).css("height",h+"px");});
                if (w!=0) $(this).find(".ui-datepicker-group").each(function(){$(this).css("width",(w)+"px");});
            });
	}
	$(window).resize(function() {
        adaptWH();
    });
    function cleanDatepicker() {
       var old_fn = $.datepicker._updateDatepicker;
       $.datepicker._updateDatepicker = function(inst) {
          old_fn.call(this, inst);
          adaptWH();
       }
    }

})(myjQuery);
});