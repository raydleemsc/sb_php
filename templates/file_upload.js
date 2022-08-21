var templates = '';

$().ready(function()
{
    $('#img').change(readImageJpegOrig);
});

// from - https://stackoverflow.com/questions/47913980/js-convert-an-image-object-to-a-jpeg-file
function readImageJpegOrig() {
	var img = new Image;
	img.onload = convert;
	if(this.files&&this.files[0]){
		$('#img').removeClass('no-file-selected');
		img.src = URL.createObjectURL(this.files[0]);
	} else {
		$("#results").html('') ; // wipe visible results if no file selected
		$('#img').addClass('no-file-selected');
	}
	};

