var updateSkull = function() {
	var windowSize = window.innerWidth;
	var mainSize = $("#main")[0].clientWidth;
	
	var restSize = windowSize - mainSize;
	
	useNavigationBar = function() {
		$(".navigation").show();
		$("#skull").hide();
	}
	
	useSkullNavigation = function() {
		$(".navigation").hide();
		$("#skull").show();
	}
	var setBigSkull = function() {
		var spaceLeft = $("#main")[0].offsetLeft;
		var skullSize = 150;
		$("#skull")[0].setAttribute("style", "width:"+skullSize+"px;");
		$("#skull img")[0].setAttribute("style", "width:"+skullSize+"px;");
		$("#skull .links")[0].setAttribute("style", "width:"+skullSize+"px;");
		// Align Skull
		$("#skull")[0].setAttribute("style", "margin-left:"+(spaceLeft-skullSize)/2+"px;");
	};
	
	var setSmallSkull = function() {
		var spaceLeft = $("#main")[0].offsetLeft;
		
		if (spaceLeft < 120) {
			useNavigationBar();
			return;
		}
		useSkullNavigation();
		
		var skullSize = spaceLeft-20;
		$("#skull")[0].setAttribute("style", "width:"+skullSize+"px;");
		$("#skull img")[0].setAttribute("style", "width:"+skullSize+"px;");
		$("#skull .links")[0].setAttribute("style", "width:"+skullSize+"px;");
		// Align skull
		$("#skull")[0].setAttribute("style", "margin-left:"+(spaceLeft-skullSize)/2+"px;");
	}
	
	var centerMainPart = function() {
		$("#main")[0].setAttribute("style", "margin:auto;");
	}
	
	var mainPartToRight = function() {
		$("#main")[0].setAttribute("style", "margin-right:10px;");
	}
	
	/*
	// If big screen
	if (restSize > 320) {
		setBigSkull();
	}
	// Smaller screen, e.g. notebook
	else {
		setSmallSkull();
	}
	*/
	
	useNavigationBar();
};

// Resize Skull on window resize
$(window).resize(updateSkull);

$(document).ready(function() {
	FADETIME = 100;
	
	var enableMenu = true;
	// Set skull size initially
	updateSkull();
	
	/*
	var spaceLeft = $("#main")[0].offsetLeft;
	if (spaceLeft > 120) {
		$("#skull")[0].setAttribute("style", "margin-left:"+(spaceLeft-SKULLSIZE)/2+"px;");
	}
	*/
	
	$("#skull .image").on("mouseenter", function() {
		enableMenu = true;
		$(this).fadeTo(FADETIME, 1, function() {
			$("#skull ul").fadeTo(FADETIME*3, 0.3);
		});
	});

	$("#skull .image").on("mouseleave", function() {
		$(this).fadeTo(FADETIME, 0.3);
	});
	
	$("#lefteye, #righteye").on("mouseenter", function() {
		$(this).fadeTo(FADETIME, 0.5);
	});
	
	$("#lefteye, #righteye").on("mouseleave", function() {
		$(this).fadeTo(FADETIME, 0);
	});
	
	$("#skull .links").on("mouseenter", function() {
		if (enableMenu)
			$("#skull ul").fadeTo(FADETIME*3, 1);
	});
	
	$("#skull .links").on("mouseleave", function() {
		if (enableMenu)
			$("#skull ul").fadeTo(FADETIME, 0.3);
	});
	
	$("#skull").on("mouseleave", function() {
		enableMenu = false;
		$("#skull ul").fadeOut();
	});
	
	$("#lefteye, #righteye").fadeTo(100,1, function() {
		$(this).fadeTo(2000,0);
	});
})