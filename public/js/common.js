var s3;
var identity_id = "ap-south-1:6cfbe6e5-6132-4178-9059-bfcf1655c107";
var identity_pool_id = "ap-south-1:6cfbe6e5-6132-4178-9059-bfcf1655c107";
var private_bucket = "littleedvanture";
var public_bucket = "littleedvanture";
var cloudfront_url = "https://d2vmtwtvjnckox.cloudfront.net";
var s3_bucket_region = "ap-south-1";

function uploadS3File(fileUploaderid) {
    // Extract the file uploader name from the ID
    var fileUploaderName = fileUploaderid.replace("fz_", "");

    // Show loader while processing
    $("#loader_" + fileUploaderName).show();
    // Determine the S3 type based on user input
    var bucket = public_bucket;

    // Log the selected bucket
    console.log(bucket);
    // Get the file input element
    var fileChooser = document.getElementById(fileUploaderid);
    var file = fileChooser.files[0];
    if (file) {

        // Generate a unique file name based on timestamp and file extension
        var file_arr = file.name.split(".");
        var fileName = new Date().getTime() + "." + file_arr[file_arr.length - 1];

        if (fileUploaderid) {
            // Check if file extension is allowed
            var ext = file.name.split(".").pop().toLowerCase();
            if ($.inArray(ext, ["jpeg", "jpg", "png", "gif", "pdf", "txt", "docx", "mp4", "mpeg4", "m4v"]) == -1) {
                $("#loader_" + fileUploaderName).hide();
                return false;
            }
        }

        // Replace spaces in file name with dashes
        var fileName = fileName.replace(/\s/g, "-");
        // Set parameters for S3 upload
        var params = {
            Bucket: bucket,
            Key: "/uploads/" + fileName,
            ContentType: file.type,
            ContentDisposition: "inline",
            Body: file,
            // ACL: "public-read" // Uncomment this line if you want to set ACL
        };

        // Upload file to S3
        s3.putObject(params, function (err, res) {
            console.log(res);
            if (err) {
                alert("Error uploading data: " + err); // Show error if upload fails
            } else {
                // Update image source with CloudFront URL
                $("#img" + fileUploaderid).attr("src", cloudfront_url +"/uploads/" + fileName);

                // Set value of hidden input field with uploaded file path
                var filenameValue = "/uploads/" + fileName;
                document.getElementById(fileUploaderName).value = filenameValue;
            }
            $("#loader_" + fileUploaderName).hide(); // Hide loader after upload completes
        });
    } else {
        alert("Nothing to upload."); // Show alert if no file selected
    }
}
