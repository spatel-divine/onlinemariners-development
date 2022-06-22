@extends('layouts.app_afterLogin')
@section('content')

<style type="text/css">
  #heading-breadcrumbs {
    background: url("https://onlinemariners.com/public/assets/img/online_mariners_bredcrump.jpg") center center repeat;
    border-top: 1px solid #999;
    border-bottom: 1px solid #999;
    padding: 8rem 0 5rem 0;
    border-top: none !important;
    border-bottom: none !important;
  }
  .heading h2{
    /*line-height: 1.1;
    display: inline-block;
    margin-bottom: 0;
    padding-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.1em;*/
  }
  .heading h2:after
  {
    content: " ";
    display: none;
    width: 100px;
    height: 2px;
    margin-top: .6rem;
    background: #4fbfa8;
  }
  .lead, p, #mission_bullet{
    padding-top: 3%;
    padding-bottom: 2%;
    font-size: 1.8rem;
    text-transform: none;
    text-align: justify;
  }
  .text-center{
    text-align: center!important;
  }
  .card-img, .card-img-top {
    border-top-left-radius: calc(.25rem - 1px);
    border-top-right-radius: calc(.25rem - 1px);
  }
  .card-img-top{
    width: 100%
  }
  /* icon row 1*/
  .box > .icon { text-align: center; position: relative; }
.box > .icon > .image { position: relative; z-index: 2; margin: auto; width: 88px; height: 88px; border: 8px solid white; line-height: 88px; border-radius: 50%; background: #63B76C; vertical-align: middle; }
.box > .icon:hover > .image { background: #333; }
.box > .icon > .image > i { font-size: 36px !important; color: #fff !important; }
.box > .icon:hover > .image > i { color: white !important; }
.box > .icon > .info { margin-top: -24px; background: rgba(0, 0, 0, 0.04); border: 1px solid #e0e0e0; padding: 15px 0 10px 0;min-height: 200px; }
.box > .icon:hover > .info { background: rgba(0, 0, 0, 0.04); border-color: #e0e0e0; color: white; }
.box > .icon > .info > h3.title { font-family: "Poppins" ; font-size: 16px; color: #222; font-weight: 500; }
.box > .icon > .info > p { font-family: "Poppins"; font-size: 13px; color: #666; line-height: 1.5em; margin: 20px;padding-top: 4%;}
.box > .icon:hover > .info > h3.title, .box > .icon:hover > .info > p, .box > .icon:hover > .info > .more > a { color: #222; }
.box > .icon > .info > .more a { font-family: "Poppins"; font-size: 12px; color: #222; line-height: 12px; text-transform: uppercase; text-decoration: none; }
.box > .icon:hover > .info > .more > a { color: #fff; padding: 6px 8px; background-color: #63B76C; }
.box .space { height: 30px; }
/**/
#heading-breadcrumbs .breadcrumb {
    margin-bottom: 0;
    background: none;
    font-size: 1.9rem;
}
.single_img{
  display: inline-block;
  vertical-align: top;
  max-width: 100%;
}
.underline{
  margin-top: 20px;
    margin-bottom: 20px;
    width: 60px;
    height: 2px;
    background: #d9160a;
}
    
.h2{
  padding-left: 2%;
}    
</style>
<!-- Content -->
<?php
  $url = "'".url('/public/assets/img/online_mariners_bredcrump.jpg')."'";
?>
<div id="content">
  <!-- bredcrubmp bar -->
    <!-- <div id="heading-breadcrumbs">
      <div class="container">
        <div class="row d-flex align-items-center flex-wrap">
          <div class="col-sm-12">            
            <h1>About Us</h1>
          </div>          
        </div>
      </div>
    </div> -->
    <!-- End bredcrubmp bar -->
  <!-- Title Header Start -->
  <section class="inner-header-title" style="background-image:url({{ $url }});">
    <div class="container">
      <h1>About Us</h1>
    </div>
  </section>
  <!-- Actual Body -->
  <div class="container">

    <section class="" style="padding-top: 4%;">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading">
            <h2 class="text-center">About Online Mariners</h2>
          </div>
          <p class="lead" >Online Mariners is lead and initiated by the team of the well versed Maritime fraternity of Master-Mariners & Chief Engineers who served for more than 15 years in the sea-going career and offshore industries to shorten the demand and supply ratio of the quality seafarers in the shipping industry with their determined vision and goals.<br><br>Online Mariners job portal is the only platform which reduces the efforts of the shipping companies and the individual seafarers to securely communicate via online chat and share their own values and principles to get hired.<br><br>Online Mariners is the most innovative and one of the largest online job portals for Seafarers. Founded in 2016, over the past years, Online Mariners has become a prominent name in the Maritime industry. The popularity of the portal is evident from the fact that it has crossed the 10,000 registered seafarer’s landmark and has more than 3500 latest job vacancies from leading shipping companies on the site.<br><br>Online Mariners connects seafarers and shipping companies by accurately matching seafarer’s profiles to the relevant openings through an advanced 2-way chat communication technology. While most job portals only focus on getting seafarers the next job, Online Mariners focuses on the entire career growth of Seafarers.<br><br>Online Mariners connects seafarers and shipping companies by accurately matching seafarer’s profiles to the relevant openings through an advanced 2-way chat communication technology. While most job portals only focus on getting seafarers the next job, Online Mariners focuses on the entire career growth of Seafarers.<br><br>As the world shifts towards mobile, Online Mariners is leading the transition and will be launching the fastest growing seafarer’s job portal on mobile devices in a short span of time through the Online Mariners Android / IOS App.<br><br>We work closely to bridge the gap between talent & opportunities and offer 2 way end-to-end supportive solutions.</p>
        </div>
      </div>
      <!-- row 2 vision mission -->
      <div class="row" style="margin-top: 2.0rem;margin-bottom: 2.0rem;">        
        <div class="col-sm-6">
          <?php
            $ourVisionPath = url('/public/assets/img/Our Vision.jpg');
            $ourMisionPath = url('/public/assets/img/Our Mission.jpg');
          ?>
          <img src="{{ $ourVisionPath }}" style="width: 100%;" />          
          <div class="heading">
            <h2 class="text-center" class="text-center">OUR VISION</h2>
          </div>          
          <p class="lead"> To create a great place to work by inspiring our people to continuously innovate and bring greater value to our customers and environment, thereby enhancing stakeholder value.</p>
        </div>
        
        <div class="col-sm-6">
          <img src="{{ $ourMisionPath }}" style="width: 100%;" />          
          <div class="heading">
            <h2 class="text-center">OUR MISSION</h2>
          </div>          
          <ul id="mission_bullet" class="lead">            
            <li>To offer ship owners and managers one place where they can  focus and target their marketing efforts to the largest global pool of maritime professionals.</li>
            <li>To offer seafarers as much information as possible concerning sea-going job vacancies, certificates, education, companies.</li>
            <li>To offer the best available career tool for maritime professionals worldwide.</li>
          </ul>
          
        </div>            
      </div>

      <!-- icon box -->
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-lg-12">
            <div class="heading">
              <h2 class="text-center">OUR VALUES</h2>
            </div>
          </div>
        </div>
      <!-- -->
      <div class="row" style="padding-top: 2.0rem;">
        <div class="col-xs-12 col-sm-6 col-lg-4">
          <div class="box">             
            <div class="icon">
              <div class="image"><i class="fa fa-thumbs-o-up"></i></div>
              <div class="info">
                <h3 class="title">Customer Commitment</h3>
                <p>We develop relationships that make a positive difference in our clients lives</p>
                <!-- <div class="more">
                  <a href="#" title="Title Link">
                    Read More <i class="fa fa-angle-double-right"></i>
                  </a>
                </div> -->
              </div>
            </div>
            <div class="space"></div>
          </div> 
        </div>      
        <div class="col-xs-12 col-sm-6 col-lg-4">
          <div class="box">             
            <div class="icon">
              <div class="image"><i class="fa fa-flag"></i></div>
              <div class="info">
                <h3 class="title">Quality</h3>
                  <p>We provide outstanding products and unsurpassed service that together deliver premium value to our clients.</p>
                <!-- <div class="more">
                  <a href="#" title="Title Link">
                    Read More <i class="fa fa-angle-double-right"></i>
                  </a>
                </div> -->
              </div>
            </div>
            <div class="space"></div>
          </div> 
        </div>
      
        <div class="col-xs-12 col-sm-6 col-lg-4">
          <div class="box">             
              <div class="icon">
                <div class="image"><i class="fa fa-desktop"></i></div>
                <div class="info">
                  <h3 class="title">Integrity</h3>
                    <p>We uphold the highest standards of integrity in all of our actions</p>
                  <!-- <div class="more">
                    <a href="#" title="Title Link">
                      Read More <i class="fa fa-angle-double-right"></i>
                    </a>
                  </div> -->
                </div>
              </div>
              <div class="space"></div>
            </div>
        </div>
      </div>
        <!-- values row 2 -->
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">             
              <div class="icon">
                <div class="image"><i class="fa fa-thumbs-o-up"></i></div>
                <div class="info">
                  <h3 class="title">Teamwork</h3>
                  <p>We work together, across boundaries to meet the needs of our customers and to help the company win.</p>
                  <!-- <div class="more">
                    <a href="#" title="Title Link">
                      Read More <i class="fa fa-angle-double-right"></i>
                    </a>
                  </div>-->
                </div>
              </div>
              <div class="space"></div>
            </div> 
          </div>

          <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">             
              <div class="icon">
                <div class="image"><i class="fa fa-thumbs-o-up"></i></div>
                <div class="info">
                  <h3 class="title">Respect For People</h3>
                  <p>We value our people, encourage their development and reward their performance.</p>
                  <!-- <div class="more">
                    <a href="#" title="Title Link">
                      Read More <i class="fa fa-angle-double-right"></i>
                    </a>
                  </div> -->
                </div>
              </div>
              <div class="space"></div>
            </div> 
          </div>

          <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">             
              <div class="icon">
                <div class="image"><i class="fa fa-thumbs-o-up"></i></div>
                <div class="info">
                  <h3 class="title">A Will To Win</h3>
                  <p>We exhibit a strong will to win in the marketplace and in every aspect of our business.</p>
                  <!-- <div class="more">
                    <a href="#" title="Title Link">
                      Read More <i class="fa fa-angle-double-right"></i>
                    </a>
                  </div> -->
                </div>
              </div>
              <div class="space"></div>
            </div> 
          </div>
      </div>

      <!-- <div class="row"> -->
        
      </div>
          <!-- <div id="accordion" role="tablist">
            <div class="card">
              <div id="headingOne" role="tab" class="card-header">
                <h4 class="mb-0 mt-0"><a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Accordion Item No.1</a></h4>
              </div>
              <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" class="collapse show">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4"><img src="https://d19m59y37dris4.cloudfront.net/universal/2-1-0/img/template-easy-customize.png" alt="" class="img-fluid"></div>
                    <div class="col-md-8">
                      <p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.</p>
                      <p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div id="headingTwo" role="tab" class="card-header">
                <h4 class="mb-0 mt-0"><a data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsed">Accordion Item No.2</a></h4>
              </div>
              <div id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" class="collapse">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4"><img src="https://d19m59y37dris4.cloudfront.net/universal/2-1-0/img/template-easy-code.png" alt="" class="img-fluid"></div>
                    <div class="col-md-8">
                      <p>It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather. Drops of rain could be heard hitting the pane, which made him feel quite sad.</p>
                      <p>It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather. Drops of rain could be heard hitting the pane, which made him feel quite sad.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div id="headingThree" role="tab" class="card-header">
                <h4 class="mb-0 mt-0"><a data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="collapsed">Accordion Item No.3 A little too small</a></h4>
              </div>
              <div id="collapseThree" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion" class="collapse">
                <div class="card-body">
                  <p>His room, a proper human room although a little too small, lay peacefully between its four familiar walls.</p>
                  <p>A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame.</p>
                </div>
              </div>
            </div>
          </div> -->
        </div>
        <!-- <div class="col-md-4">
          <div class="video">
            <div class="embed-responsive embed-responsive-4by3">
              <iframe src="//www.youtube.com/embed/upZJpGrppJA" class="embed-responsive-item"></iframe>
            </div>
          </div>
        </div> -->
      </div>
    </section>
    
  </div>
  <!-- <section class="bar background-pentagon no-mb">
    <div class="container">
      <div class="row showcase text-center">
        <div class="col-md-3 col-sm-6">
          <div class="item">
            <div class="icon-outlined icon-sm icon-thin"><i class="fa fa-align-justify"></i></div>
            <h4><span class="h1 counter">580</span><br> Websites</h4>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="item">
            <div class="icon-outlined icon-sm icon-thin"><i class="fa fa-users"></i></div>
            <h4><span class="h1 counter">100</span><br>Satisfied Clients</h4>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="item">
            <div class="icon-outlined icon-sm icon-thin"><i class="fa fa-copy"></i></div>
            <h4><span class="h1 counter">320</span><br>Projects</h4>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="item">
            <div class="icon-outlined icon-sm icon-thin"><i class="fa fa-font"></i></div>
            <h4><span class="h1 counter">923</span><br>Magazines and Brochures</h4>
          </div>
        </div>
      </div>
    </div>
  </section> -->
    
</div>
      
@endsection