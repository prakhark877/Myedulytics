<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="#"></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
    var s3;
      var identity_id = "";
      var token = "";
      var identity_pool_id = "";
      var private_bucket = "";
      var public_bucket = "";
      var cloudfront_url = "";
      var s3_bucket_region = "";
      $(document).ready(function () {
          getS3Details();
      });
      function getS3Details() {
          //  debugger;
          $.ajax({
              type: "GET",
              async: true,
              ContentDisposition: "attachment",
              url: "/s3/token",
              // url: "https://api.segwik.com/api/s3/cloudUrl/",
              cache: false,
              success: function (data) {
                  var d = JSON.parse(data);
                  //debugger;
                  if (d.success == false) {
                      alert("token error " + d.message);
                      return false;
                  }
                  identity_id = d.identity_id;
                  token = d.token;
                  identity_pool_id = d.identity_pool_id;
                  private_bucket = d.private_bucket;
                  public_bucket = d.public_bucket;
                  cloudfront_url = d.cloudfront_url;
                  s3_bucket_region = "ap-south-1";
                  AWS.config.region = s3_bucket_region; // Region
                  AWS.config.credentials = new AWS.CognitoIdentityCredentials({
                      IdentityPoolId: identity_pool_id,
                      IdentityId: identity_id,
                      Logins: {
                          "cognito-identity.amazonaws.com": token,
                      },
                  });
                  AWS.config.apiVersions = {
                      s3: "2006-03-01",
                  };
                  s3 = new AWS.S3({
                      httpOptions: {
                          connectTimeout: 1000 * 1000, // time succeed in starting the call
                          timeout: 1000 * 1000, // time to wait for a response
                          // the aws-sdk defaults to automatically retrying
                          // if one of these limits are met.
                      },
                  });
              },
              error: function (error) {
                  //   debugger;
                  alert("Error token : ", error);
                  return false;
                  console.log(error.statusText);
              },
          });
      }
   
  


function uploadS3File(fileUploaderid) {
    var fileUploaderName = fileUploaderid.replace("fz_", "");

    $("#loader_" + fileUploaderName).show(); // Show loader
    var bucket = public_bucket;

    console.log("Uploading to bucket:", bucket);

    var fileChooser = document.getElementById(fileUploaderid);
    var file = fileChooser.files[0];

    if (file) {
        var file_arr = file.name.split(".");
        var fileName = new Date().getTime() + "." + file_arr[file_arr.length - 1];

        var ext = file.name.split(".").pop().toLowerCase();
        if ($.inArray(ext, ["jpeg", "jpg", "png", "gif", "pdf", "txt", "docx", "mp4", "mpeg4", "m4v"]) == -1) {
            $("#loader_" + fileUploaderName).hide();
            alert("Invalid file type!");
            return false;
        }

        fileName = fileName.replace(/\s/g, "-");

        var params = {
            Bucket: bucket,
            Key: "uploads/" + fileName,  // Removed leading "/"
            ContentType: file.type,
            ContentDisposition: "inline",
            Body: file
        };

        // Ensure `s3` is properly initialized
        if (!s3) {
            console.error("S3 is not initialized.");
            $("#loader_" + fileUploaderName).hide();
            return;
        }

        s3.putObject(params, function (err, res) {
            $("#loader_" + fileUploaderName).hide();
            
            if (err) {
                console.error("Error uploading file:", err);
                alert("Error uploading file: " + err.message);
            } else {
                console.log("File uploaded successfully:", res);
                $("#img" + fileUploaderid).attr("src", cloudfront_url + "/uploads/" + fileName);
                document.getElementById(fileUploaderName).value = "/uploads/" + fileName;
            }
        });
    } else {
        alert("No file selected.");
    }
}

  </script>