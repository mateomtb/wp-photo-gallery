<div class="ng-recommender" id="ng-recommender"></div>
<script src="http://sandbox.dailyme.com/rmv2/js/recommender.js"></script>
<script>
	var ngRec = new Newstogram.recommender({
	    adPosition: 'right',
	    apiKey: 'dailymedemo',
	    source:'dailyme',
	    filter:'2',
	    headlinesRotation:true,
	    customParams:'source=dailyme',
	    cssUrl: 'http://sandbox.dailyme.com/rmv2/css/recommender.css',
	    limit: 6,
	    maxWidth: 400
	});
	ngRec.init();
</script>