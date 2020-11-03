<!-- Latest compiled and minified JS -->

{{--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
--}}

<!-- For the Alpha-vue update: -->
<script>
	window.addEventListener("message", function (event) {
		console.log(event);
		console.log(event.data);
		console.log(event.target);

	});
</script>

<script type="text/javascript">
	function switchKeyVisualFrame() {
		var $frameIos = $('#keyvisual_ios'),
			$frameAndroid = $('#keyvisual_android');

		$frameAndroid.css('visibility', 'visible'); // FIXME

		if ($frameIos.is(':visible')) {
			$frameIos.hide();
			$frameAndroid.css("display", "inherit");
		} else if ($frameAndroid.is(':visible')) {
			$frameAndroid.hide();
			$frameIos.css("display", "inherit");
		}
	}

	// iframe lazy loader
	$(function() {
		$.extend($.lazyLoadXT, {
			autoInit: false,
			edgeY: 0,
			srcAttr: 'data-src',
			throttle: 1000
		});

		var iframe = $('iframe');
		if (iframe.length > 0 && iframe.lazyLoadXT instanceof Function) {
			iframe.lazyLoadXT();
		}
	});
</script>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>