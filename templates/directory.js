$(document).ready(function(){
    $("#directory")[0].addEventListener("click",async () => {
        let directoryHandle = await navigator.storage.getDirectory();
        console.log(directoryHandle);
        $("#directory").val(directoryHandle.name);
    })
}
);
