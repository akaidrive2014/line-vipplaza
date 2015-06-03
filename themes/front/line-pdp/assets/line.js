
BOOMR.subscribe("before_beacon", function (e) {

	var pageName = 'Uncategorised';


	BOOMR.addVar('sq_pt', pageName);
});


BOOMR.init({
		beacon_url: "//beacon.squixa.net/navigationtiming",
		site_domain: document.location.hostname.replace("www.", ""),
		log: null,
		cfg_loaded: true,
		RT: {
			strict_referrer: false
		}
	});
