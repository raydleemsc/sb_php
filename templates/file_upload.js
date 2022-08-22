var templates = '';

$(document).ready(function()
{
    $('#img').change(readImageJpegOrig);

    let fileHandle;
    $('#img').addEventListener("click", pickFile, false );

});

async function pickFile() {
    [fileHandle] = await window.showOpenFilePicker({
      startIn: 'documents'
    });
    const file = await fileHandle.getFile();
    const contents = await file.text();
  //   textArea.value = contents;
  }

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

    function convert() {
        URL.revokeObjectURL(this.src);             // free up memory
        var c = document.createElement("canvas"),  // create a temp. canvas
            ctx = c.getContext("2d");
        c.width = this.width;                      // set size = image, draw
        c.height = this.height;
        ctx.drawImage(this, 0, 0);
    
        // convert to File object, NOTE: we're using binary mime-type for the final Blob/File
        var jpeg = c.toDataURL("image/jpeg", 0.75);  // mime=JPEG, quality=0.75
        console.log(jpeg.length);
    
        if(jpeg.length < (2*1024*1024))
        {
            $('#input_picture').val(jpeg);
            $("#results").html('<img src="'+jpeg+'" class="img-responsive" style="max-height:100%;"/>') ;
        }
        else
        {
            alert("ต้องเลือกรูปภาพขนาดไม่เกิน 2M/Images must be selected no larger than 2M") ;
            $("#results").html('') ; // wipe visible results if file too big
            $('#img').addClass('no-file-selected');
        }
    };
    