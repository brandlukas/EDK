// configure tabber
var tabberOptions = {
    manualStartup:true, 
    'onClick': function(argsObj)
        { 
            FleetBattles.loadTab(argsObj); 
        }, 
    'addLinkId': true 
}


// initialize "namespace"
var FleetBattles = new Object();

// loads the content of a tab if there isn't any
FleetBattles.loadTab = function(tabberArgs)
{ 
    var tabTitle = tabberArgs.tabber.tabs[tabberArgs.index].headingText.split(" ").join("")
    var tab = document.getElementById(tabTitle);
    // tab empty?
    if(tab != null && tab.innerHTML == "")
    {
        tab.innerHTML = "<div style=\"width: 100%; text-align: center\"><img src=\""+fleetBattlesLoadingImage+"\" /></div>";
        var ajaxRequestUrl = document.getElementById("ajaxRequestUrl").value;
        if(ajaxRequestUrl.toString().indexOf("?") == -1)
        {
            ajaxRequestUrl += "?"+tabTitle+"="+tabTitle;
        }
        
        else
        {
            ajaxRequestUrl += "&"+tabTitle+"="+tabTitle;
        }
        
        $.get(ajaxRequestUrl, function(html){
            tab.innerHTML = html;
        });
    }
    
}


