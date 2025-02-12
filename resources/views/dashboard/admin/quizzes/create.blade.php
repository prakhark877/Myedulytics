@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add Quiz</h1>
                        <!-- Display general error messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Quiz Title*</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration (Minutes)*</label>
                                <input type="number" name="duration" id="duration" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="random_questions_count">Random Questions Count*</label>
                                <input type="number" name="random_questions_count" id="random_questions_count" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category*</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->cat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subcategory_id">Subcategory*</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                    <option value="">Select Subcategory</option>
                                    @foreach ($categories as $category)
                                        @foreach ($category->subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->subcat_title }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description*</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-label">Choose File:</label>
                                <input type="file" name="image" class="form-control">
                                
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-label">Choose S3 File:</label>
                                <input class=" upload form-control" id="fz_pg_bgimg" name="fz_pg_bgimg" onchange="uploadS3File(this.id)" type="file">
                                <input id="pg_bgimg" name="pg_bgimg" type="hidden" value="">
                                
                            </div>

                            <button type="submit" class="btn btn-success">Add Quiz</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script src="/js/aws-sdk-2.553.0.min.js"></script>
    <script type="text/javascript">
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
                  url:   "/s3/token",
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

@stop
