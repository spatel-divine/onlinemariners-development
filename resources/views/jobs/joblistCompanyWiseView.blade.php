@extends('layouts.app_afterLogin')
<?php 
    
    
    $city = [];
    foreach ($allPostJobLists as $job) {
        // echo $allPostJobLists[].'<br>';
        // print_r($v);
        // if($allPostJobLists['city'] == 'city'){
            $city[] =  $job->city;           
        // }
    }
    
    $cityName = (isset($_GET['Country']) && $_GET['Country']) ? $_GET['Country'] : '';
    $company_name = (isset($_GET['company_name']) && $_GET['company_name']) ? $_GET['company_name'] : '';
    $rank_position = (isset($_GET['rank_position']) && $_GET['rank_position']) ? $_GET['rank_position'] : '';
?>
@section('content')
<style type="text/css">
    .wrap-search-filter button.btn.btn-primary {
        height: 36px !important;
    }
</style>>
    <!-- <div class="clearfix"></div>             -->
            <!-- Title Header Start -->
            <?php $url =  url('public/assets/img/online_mariners_bredcrump.jpg'); ?>
    <section class="inner-header-title" style="background-image:url({{ $url }})">
        <div class="container">
            <h1>Browse Company</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->
        
    <!-- Browse Company List Start -->
    <section class="browse-company">
        <div class="container">
        
            <!-- Company Searrch Filter Start -->
            <div class="row extra-mrg">
                <div class="wrap-search-filter">
                    <form name="job_searchfilter_form" action="{{ route('joblist.companyfilter') }}" method="get">
                        @csrf
                        <div class="col-md-4 col-sm-4">
                            <input type="text" value="<?php echo $company_name;?>" name="company_name" class="form-control" placeholder="Search By Company Name">
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <input type="text" value="<?php echo $cityName;?>" name="Country" class="form-control" placeholder="Search By City Name">
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select name="rank_position" class="form-control" >
                                <!-- id="j-category" -->
                                
                                <option value="">Select Rank</option>
                                <option <?php echo ($rank_position=='Captain / Master') ? 'selected' : '';?> value="Captain / Master">Captain / Master</option>
                                <option value="Chief Engineer">Chief Engineer</option>
                                <option <?php echo ($rank_position=='Chief Officer') ? 'selected' : '';?> value="Chief Officer">Chief Officer</option>
                                <option <?php echo ($rank_position=='2nd Engineer') ? 'selected' : '';?> value="2nd Engineer">2nd Engineer</option>
                                <option <?php echo ($rank_position=='2nd Officer') ? 'selected' : '';?> value="2nd Officer" >2nd Officer</option>
                                <option <?php echo ($rank_position=='3rd Engineer') ? 'selected' : '';?> value="3rd Engineer">3rd Engineer</option>
                                <option <?php echo ($rank_position=='3rd Officer') ? 'selected' : '';?> value="3rd Officer" >3rd Officer</option>
                                <option <?php echo ($rank_position=='4th Engineer') ? 'selected' : '';?> value="4th Engineer">4th Engineer</option>
                                <option <?php echo ($rank_position=='Electrical Officer') ? 'selected' : '';?> value="Electrical Officer">Electrical Officer</option>
                                <option <?php echo ($rank_position=='Electrical Technical Officer') ? 'selected' : '';?> value="Electrical Technical Officer">Electrical Technical Officer</option>
                                <option <?php echo ($rank_position=='Trainee Electrical Officer') ? 'selected' : '';?> value="Trainee Electrical Officer">Trainee Electrical Officer</option>
                                <option <?php echo ($rank_position=='AB') ? 'selected' : '';?> value="AB">AB</option>
                                <option <?php echo ($rank_position=='Oiler') ? 'selected' : '';?> value="Oiler">Oiler</option>
                                <option <?php echo ($rank_position=='Deck Cadet') ? 'selected' : '';?> value="Deck Cadet">Deck Cadet</option>
                                <option <?php echo ($rank_position=='Engine Cadet') ? 'selected' : '';?> value="Engine Cadet">Engine Cadet</option>
                                <option <?php echo ($rank_position=='OS') ? 'selected' : '';?> value="OS">OS</option>
                                <option <?php echo ($rank_position=='Wiper') ? 'selected' : '';?> value="Wiper">Wiper</option>
                                <option <?php echo ($rank_position=='Trainee OS') ? 'selected' : '';?> value="Trainee OS">Trainee OS</option>
                                <option <?php echo ($rank_position=='Trainee Wiper') ? 'selected' : '';?> value="Trainee Wiper">Trainee Wiper</option>
                                <option <?php echo ($rank_position=='Deck Fitter') ? 'selected' : '';?> value="Deck Fitter">Deck Fitter</option>
                                <option <?php echo ($rank_position=='Engine Fitter') ? 'selected' : '';?> value="Engine Fitter">Engine Fitter</option>
                                <option <?php echo ($rank_position=='Bosun') ? 'selected' : '';?> value="Bosun">Bosun</option>
                                <option <?php echo ($rank_position=='Pumpman') ? 'selected' : '';?> value="Pumpman"> Pumpman</option>
                                <option <?php echo ($rank_position=='Motorman') ? 'selected' : '';?> value="Motorman">Motorman</option>
                                <option <?php echo ($rank_position=='Crane Operator') ? 'selected' : '';?> value="Crane Operator">Crane Operator</option>
                                <option <?php echo ($rank_position=='Chief Cook') ? 'selected' : '';?> value="Chief Cook">Chief Cook</option>
                                <option <?php echo ($rank_position=='Cook') ? 'selected' : '';?> value="Cook">Cook</option>
                                <option <?php echo ($rank_position=='2nd Cook') ? 'selected' : '';?> value="2nd Cook">2nd Cook</option>
                                <option <?php echo ($rank_position=='Assistant Cook') ? 'selected' : '';?> value="Assistant Cook">Assistant Cook</option>
                                <option <?php echo ($rank_position=='General Steward') ? 'selected' : '';?> value="General Steward">General Steward</option>
                                <option <?php echo ($rank_position=='Trainee General Steward') ? 'selected' : '';?> value="Trainee General Steward">Trainee General Steward</option>
                            </select>

                        </div>
                        <div class="col-md-2 col-sm-2">
                            <button type="submit" class="btn btn-primary full-width">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Company Searrch Filter End -->
            
            <!-- Single Browse Company -->
            @foreach($allPostJobLists as $postjob)
            <div class="item-click">
                <a href="{{ route('joblist.browse', [$postjob->company_name]) }}">
                <article>
                    <div class="brows-company">
                        <div class="col-md-6 col-sm-6">
                            <div class="item-fl-box">
                                <div class="brows-company-pic">
                                    <?php 
                                        if(isset($postjob->company_logo)){                                            
                                            $companyLogo = url('public/companyLogo/'.$postjob->company_logo);    
                                        }else{
                                            $companyLogo = url('public/assets/img/company_default_logo.png');    
                                        }
                                         ?>                                        
                                    <img src="{{ $companyLogo }}" class="img-responsive" alt="companyLogo" width="100" height="100"/>
                                </div>
                                <div class="brows-company-name">
                                    <?php // below r oute  ('joblist.browse', [$postjob->company_name,$postjob->city])?>
                                    <h4>{{ mb_strimwidth($postjob->company_name, 0, 35, "...") }}</h4>

                                    <span class="brows-company-tagline">{{ mb_strimwidth($postjob->rank_position, 0, 35,'...') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="brows-company-location">
                                <?php
                                    $country = (isset($postjob->country) && ($postjob->country != '')) ? $postjob->city.'-'.$postjob->country : 'Not Updated Yet';                                    
                                ?>
                                <p><i class="fa fa-map-marker"></i> {{ mb_strimwidth($country, 0, 35,'...') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="brows-company-position">                                
                                <p>{{ $postjob->rankcount.' Opening' }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </article>
            </div>
            @endforeach
            <!-- No result found then below message display -->
            @if(count($allPostJobLists) < 1)                
                <div class="row" style="text-align: center;padding-top: 5%;">
                    <div class="col-sm-12">
                        <h3 style="color: #03a84e">Requested Data Not Found</h3>
                    </div>
                </div>
            @endif
           
            @if(isset($allPostJobLists))
            <div class="row" style="text-align: center;">
                
                {!! $allPostJobLists->render() !!}
               
            </div>
            @endif
        </div>
    </section>
@endsection