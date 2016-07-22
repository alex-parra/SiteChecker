
	var tOut;
	var checking = false;
	var sites = jQuery('.site');
	var btnCheckNow = jQuery('.btn-check-now');
	runCheck();
	
	function runCheck() {
		
		checking = true;
		btnCheckNow.text('Checking...').addClass('btn-off');
		var tStart = new Date();

		jQuery('.last-check').text('Checked @ '+ checkTime(tStart) );
		
		jQuery('.sites-offline .site').appendTo('.sites-online');
		jQuery('.sites-wrap-offline').slideUp();
		jQuery('.sites-timeout .site').appendTo('.sites-online');
		jQuery('.sites-wrap-timeout').slideUp();
		
		sites.addClass('check');
		checkSites();
	
	}
	
	function checkSites() {
	
		site = jQuery('.site.check')[0];
	
		if( ! site ) {
			checking = false;
			btnCheckNow.text('Check Now').removeClass('btn-off');
			setNextCheck();
			return;
		}
	
		siteStart = new Date();
		
		site = jQuery(site);
		site.find('.time').text('· checking ·');

		jQuery.ajax('index.php?s='+ site.attr('data-url') +'&el='+site.attr('data-el'),
			{
				'timeout': 4000,
				'success': function(response) {
					var site = jQuery('.'+ response.el );
					
					if( response.result ) {
						site.find('.time').text( response.time );
						site.removeClass('check');
						site.appendTo(".sites-online");
						sortSites('.sites-online');
					} else {
						site.find('.time').text( response.time );
						site.removeClass('check');
						site.appendTo(".sites-offline");
						sortSites('.sites-offline');
						jQuery('.sites-wrap-offline').slideDown();
					}
				},
				'complete': function(xhr, status) {
					if( status != 'success' ) {
						tOk = new Date();
						var el = this.url.split('&');
						el = el.reverse();
						el = el[0].replace('el=', '');
						
						var site = jQuery('.'+ el );
						site.find('.time').text( timeDiff(siteStart, tOk) +'s' );
						site.removeClass('check');
						site.appendTo(".sites-timeout");
						
						sortSites('.sites-timeout');
						jQuery('.sites-wrap-timeout').slideDown();
					}
					
					checkSites();
				}
			}
		);
		
	}


	function timeDiff( start, finish ) {
		var t = finish.getTime() - start.getTime();
		t = t / 1000; // to seconds
		t = t.toFixed(2);
		return t;
	}
	
	function withZero(n) {
		return ("0" + n).slice(-2);
	}
	
	function checkTime(t) {
		h = withZero( t.getHours() );
		m = withZero( t.getMinutes() );
		s = withZero( t.getSeconds() );
		return h +':'+ m +':'+ s;
	}

	function sortSites( list ) {
		var list = $( list );
		var items = list.children('.site').get();
		
		items.sort(function(a, b) {
			var compA = $(a).find('.sort').text();
			var compB = $(b).find('.sort').text();
			return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
		});
		jQuery.each(items, function(idx, itm) { list.append(itm); });
	}

	function checkNow() {
		if( checking ) return;
		clearTimeout(tOut);
		runCheck();
	}

	function setNextCheck() {
		var wait = timeToNextCheck();
		tOut = window.setTimeout(runCheck, wait * 1000);
	}
	
	function timeToNextCheck() {
		var secs = new Date().getSeconds();
		var secsLeft;
		if( secs < 15 ) secsLeft = (120 - secs); // short repeat
		else secsLeft = (240 - secs); // longer repeat
		return secsLeft + 1;
	}
	
