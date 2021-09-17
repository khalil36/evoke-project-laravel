jQuery(function ($) {
	/* AddClass for parent element <a> to keep highlighted on child page
	https://stackoverflow.com/questions/20060467/add-active-navigation-class-based-on-url*/
	// $(function () {
	// 	var current = location.pathname;
	// 	$("#main-menu .menu .menu-item a").each(function () {
	// 		var $this = $(this);
	// 		// if the current path is like this link, make it active
	// 		if ($this.attr("href").indexOf(current) !== -1) {
	// 			$this.addClass("active");
	// 		}
	// 	});
	// });

	/* https://stackoverflow.com/questions/9983091/jquery-add-class-based-on-page-url */
	// $(function () {
	// 	var loc = window.location.href; // returns the full URL
	// 	if (/resource-library/.test(loc)) {
	// 		$("#main-menu .menu #menu-resources a").addClass("active");
	// 	}
	// });

	// $("#main-menu .menu .menu-item")
	// 	.on("mouseenter", function () {
	// 		$(this).addClass("active");
	// 	})
	// 	.on("mouseleave", function () {
	// 		$(this).removeClass("active");
	// 	});

	// $("#main-menu .menu #menu-platform")
	// 	.on("mouseenter", function () {
	// 		$("#dd-platform").css({
	// 			opacity: "1",
	// 			visibility: "visible",
	// 		});
	// 	})
	// 	.on("mouseleave", function () {
	// 		$("#dd-platform").css({
	// 			opacity: "0",
	// 			visibility: "hidden",
	// 		});
	// 	});

	// $("#main-menu .menu #menu-customers")
	// 	.on("mouseenter", function () {
	// 		$("#dd-customers").css({
	// 			opacity: "1",
	// 			visibility: "visible",
	// 		});
	// 	})
	// 	.on("mouseleave", function () {
	// 		$("#dd-customers").css({
	// 			opacity: "0",
	// 			visibility: "hidden",
	// 		});
	// 	});

	// $("#main-menu .menu #menu-resources")
	// 	.on("mouseenter", function () {
	// 		$("#dd-resources").css({
	// 			opacity: "1",
	// 			visibility: "visible",
	// 		});
	// 	})
	// 	.on("mouseleave", function () {
	// 		$("#dd-resources").css({
	// 			opacity: "0",
	// 			visibility: "hidden",
	// 		});
	// 	});

	// $("#main-menu .menu #menu-company")
	// 	.on("mouseenter", function () {
	// 		$("#dd-company").css({
	// 			opacity: "1",
	// 			visibility: "visible",
	// 		});
	// 	})
	// 	.on("mouseleave", function () {
	// 		$("#dd-company").css({
	// 			opacity: "0",
	// 			visibility: "hidden",
	// 		});
	// 	});

	$("#hamburger").click(function () {
		$("#mobile-menu").toggleClass("active");
		$(this).toggleClass("active");
	});

	 $('#state_telemedicine_policies').on('change', function () {
          var url = $(this).val();
          if (url != 'not_selected') { 
              window.location = url;
          }
          return false;
      });
	 console.log('this is it');
	// $("#hamburger")
	// 	.on("mouseenter", function () {
	// 		$("#mobile-menu").css({
	// 			right: "0",
	// 		});
	// 	})
	// 	.on("mouseleave", function () {
	// 		$("#mobile-menu").css({
	// 			right: "-320px",
	// 		});
	// 	});
});
