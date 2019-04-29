//Records Lookup
var Lookup_objname='';
var Lookup_rcname='';
var JSActionPage = '';
var Records_oDtTable;
//Get Lookup
function Records_getLookup(rcname,obname) {
	Lookup_objname = obname;
	Lookup_rcname = rcname;
	var popboxhead = '';
	var ajxmethod='';
	if(JSActionPage=="CONTACT-EDIT") $(".new_account").hide();
	if(rcname=="contact") {
		popboxhead = 'Contact Lookup';
		ajxmethod='contacts_lookup';
	} else if(rcname=="account") {
		popboxhead = 'Account Lookup';
        ajxmethod='accounts_lookup';
        if(JSActionPage=="CONTACT-EDIT") {
        	$("#new_account_name").val('');
        	$(".new_account").show();
        }
	}
	$("#cLookup .abox1").html(popboxhead);
	$("#cLookup").show();
	$("#cLookup .search-list").html('<img src="'+BASE_URL+'images/spinner.gif" />');
	$( "#cLookup .search-list" ).load( BASE_URL+"crm/"+ajxmethod, function() {
		Records_MorePages();
	});
}
//Set lookup
function Records_setLookup(dis) {
	var scname = $(dis).html();
	var scid = $(dis).attr("data_id");	
	var LKPobjname = Lookup_objname.search("_id")==-1?Lookup_objname+"_id":Lookup_objname;
	$("#"+Lookup_objname+"_title").val(scname);
	$("#"+LKPobjname).val(scid);
	$("#cLookup").hide();
	//Category list view page
	if(JSActionPage=="CATG-LIST") {save_record();return;}

	//CRM Send Mail page
	if(JSActionPage=="CRM-COMPOSE") {
		//Unsubscribe message
		$("#ermessage").html("");
		if($(dis).attr("data_uns")=="1") {
			$("#ermessage").html($(dis).text()+" Unsubscribed");
			$("#btnsave").hide();
		} else $("#btnsave").show();

		var name_arr = scname.split(" ");
		$("#cname").val(name_arr[0]);
		cfname=name_arr[0];
		if(cfname) {
			var evar = '';
			for(var n1=0;n1<emailContent.length;n1++) {
				evar = emailContent[n1];
				if(evar==undefined) continue;
				if(evar.length==0) continue;
				while(evar.indexOf("[Prospect First Name]")!=-1) {
					x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
					evar = evar.replace(x2,cfname);
					x2 = '[Prospect First Name]';
					evar = evar.replace(x2,cfname);
					tinyMCE.get('econtent'+(n1+1)).setContent(evar);
					tinyMCE.triggerSave();
				}
			}
		}
		if(name_arr.length>1) $("#lname").val(scname.replace(name_arr[0],""));
		else $("#lname").val("");
		$("#cemail").val($("#em_"+scid).text());	
	}
}


//Get more pages data
function Records_MorePages() {
    $(".search-list #morepages a").click(function(){
        $("#cLookup .search-list").html('<img src="'+BASE_URL+'images/spinner.gif" />');
        $.ajax({
          type: "GET",
          url: $(this).attr("href")
            }).done(function( resp ) {                   
                $("#cLookup .search-list").html(resp);
                Records_MorePages();
                Records_oDtTable = $('.rsldtskTable').dataTable({
                    "bJQueryUI": true,
                    "bAutoWidth": false,
                    "iDisplayLength": 50,
                    "sPaginationType": "full_numbers",
                    "sDom": '<"H"fl>t<"F"ip>',
                    "deferRender": true,
                    paging: false,
                    "bInfo" : false,
                    searching: false
                    //"bSort": false,
                });
                Records_oDtTable.fnSort( [ [0,'asc'] ] );
          })
          .fail(function() {            
            	$("#cLookup .search-list").html( "Unable to load page, please try to refresh the page" );
          });
        return false;
    });
}
//Search records
function Records_searchLike() {
	var skey = $("#rlskey").val();
	var ajxmethod='contacts_lookup';    
    if(Lookup_rcname=="contact") {
		ajxmethod='contacts_lookup';
	} else if(Lookup_rcname=="account") {
        ajxmethod='accounts_lookup';
	}
	$("#cLookup .search-list").html('<img src="'+BASE_URL+'images/spinner.gif" />');
    $.ajax({
      type: "GET",
      url: BASE_URL+"crm/"+ajxmethod,
      data: 'search='+skey,
        }).done(function( resp ) {   
            $("#cLookup .search-list").html(resp);
            Records_MorePages();
            Records_oDtTable = $('.rsldtskTable').dataTable({
                "bJQueryUI": true,
                "bAutoWidth": false,
                "iDisplayLength": 50,
                "sPaginationType": "full_numbers",
                "sDom": '<"H"fl>t<"F"ip>',
                "deferRender": true,
                paging: false,
                "bInfo" : false,
                searching: false
                //"bSort": false,
            });
            Records_oDtTable.fnSort( [ [0,'asc'] ] );
      })
      .fail(function() {
        	$("#cLookup .search-list").html( "Unable to search, please try to refresh the page" );
      });        
}