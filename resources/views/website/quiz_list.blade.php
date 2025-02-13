@extends('website.layout.template')

@section('content')
 


  <!-- see-your options section start -->
  <div class="cb-band cb-band-panel">
    <div class="container">
      <div class="row align-items-center ">
        <div class="col-xs-12 ">
          <div class="cb-band-panel-content cb-align-center">

            <div class="cb-band-panel-header">
              <div class="row">
                <div class="col-xs-12 col-md-8 offset-md-2 col-2xl-6 offset-2xl-3">


                  <h2 class="cb-band-panel-title" id="panel-145938665-heading">See Your Quizzes</h2>

                  <p class="cb-band-panel-desc" id="panel-145938665-desc">
                    What do you want to do after high school? Answer questions to help you make a plan.
                  </p>

                </div>
              </div>
            </div>
            <div class="cb-band-panel-components cb-align-left">

              <div class="row justify-content-center cb-gutterv-48">


                @forelse ($quizzes as $quiz)
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="cb-text-media-block display-flex flex-xs-column">

                    <div class="cb-media-block cb-margin-bottom-24">
                      
                      <img class="cb-img-fluid cb-active-effect" src="{{ config('constants.AWS_CREDENTIALS.CLOUDFRONTURL') . $quiz->image }}"
                        alt=""
                        id="responsiveImage_VnVzoTi3dU">
                    </div>

                    <div class="cb-text-block cb-align-center">
                      <h3 class="cb-h4 cb-font-weight-regular cb-font-weight-xs-medium">
                        {{ @$quiz->title }}
                      </h3>
                      <div class="cb-margin-top-8">
                        
                        <p>{{ @$quiz->description }}</p>
                      </div>
                      <a href="/continue-quiz/{{ @$quiz->slug }}"
                        class="cb-btn cb-margin-top-24 cb-btn-black ">
                       Take the Career Quiz
                      </a>
                    </div>
                  </div>

                </div>
                @endforeach



                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- see-your options section end -->








  <!-- video-section-start -->
  <div class="cb-band cb-band-panel cb-bf-chartreuse-bg">

    <div class="container">
      <div class="row align-items-center ">
        <div class="col-xs-12 col-md-6 cb-band-panel-50-1 cb-margin-sm-down-bottom-24">
          <div class="cb-band-panel-content cb-align-left">
            <!-- header -->
            <div class="cb-band-panel-header1">



              <h2 class="cb-band-panel-title" id="panel-1726627715-heading">What can you do with BigFuture? </h2>

              <p class="cb-band-panel-desc" id="panel-1726627715-desc">
                You can check out careers you’re interested in. You can find colleges based on what’s important to you.
                You can discover ways to pay for college.
              </p>


            </div>
             <!-- footer -->
            <div class="cb-band-panel-footer">

              <a href="#" class="cb-btn cb-btn-black">About BigFuture</a>

            </div>

          </div>
        </div>
        <div
          class="col-xs-12 col-md-6 cb-band-panel-50-2 order-xs-first-only order-sm-first-only cb-margin-sm-down-bottom-24">
          <div class="cb-band-panel-media">
            <div class="cb-media-block cb-video-block">
              <a href="#" class="cb-custom-outline">
                
                

                
                <img class="cb-img-fluid cb-active-effect"
                  src="/images/CS_BF_Homepage_Brand_vid_thumb_1920x1080_final.png"
                  alt="BigFuture Your Future, Your Way">

                <div class="cb-video-effect cb-black1-bg cb-opacity-7">
                  <span class="cb-icon cb-play-video cb-white-color"
                    ></span>
                </div>
              </a>
            </div>

            <div class="cb-modal  cb-video-modal" id="NBy4MuPwcgE">
              <div class="cb-modal-overlay">
                <div class="cb-modal-container">
                 <div class="cb-modal-content">
                    <iframe src=""
                      data-cb-src="https://www.youtube.com/embed/NBy4MuPwcgE?autoplay=1&amp;modestbranding=1&amp;playsinline=0&amp;rel=0"
                      title="YouTube - College Board Watch video BigFuture: Plan for College, Pay for College, and Explore Careers"
                      frameborder="0" allowfullscreen=""></iframe>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- video-section-end -->




@stop
