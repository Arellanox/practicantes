<?php
$url = $_POST['url'];
$nombreArchivo = $_POST['nombreArchivo'];


header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<div id="adobe-dc-view" style="height:100%"></div>
<script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
<script type="text/javascript">
    document.addEventListener("adobe_dc_view_sdk.ready", function() {
        var adobeDCView = new AdobeDC.View({
            clientId: "cd0a5ec82af74d85b589bbb7f1175ce3",
            divId: "adobe-dc-view"
        });
        adobeDCView.previewFile({
            content: {
                location: {
                    url: "<?php echo $url; ?>"
                }
            },
            metaData: {
                fileName: "<?php echo $nombreArchivo; ?>"
            }
        }, {});
    });
</script>