<header class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }}">
    <div class="page_header header-01" style="height: 70px; background-color: white">
        <div class="container">
            <div class="row respnsve" style="background-color: white; height: 20px;">
                <div class=" col-md-2 col-sm-12 text-md-center col-xs-4">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </a>
                </div>
                <div class=" col-md-8 col-sm-4 text-lg-center">
         <span class="toggle_menu">
          <span></span>
         </span>
                    <!-- main nav start -->
                    <nav class="mainmenu_wrapper">
                        <ul class="mainmenu nav sf-menu ">
                            @foreach($navs as $key=>$nav)
                                @if(!$nav->hidden)
                                    <li class="a-shop {{ $key==0?'active':'' }}">
                                         <?php
                                            $url = '#';
                                            if(trim($nav->slug) == 'about'){
                                                $url = url('/').'#about-us';
                                            }elseif($nav->slug == 'home'){
                                                $url = url('/');
                                            }elseif($nav->slug == 'blog'){
                                                $url = url('/blog');
                                            }elseif($nav->slug =='shop'){
                                                $url = url('/').'#shop';
                                            }elseif($nav->page_id>0 && isset($nav->page->slug) && !empty($nav->page->slug)){
                                                $url = url($nav->page->slug.'/page');
                                            }
                                            if(!empty($nav->url) && filter_var($nav->url,FILTER_VALIDATE_URL) == true){
                                                $url = $nav->url;
                                            }
                                        ?>
                                        <a href="{{ $url }}" class="sf-with-ul" style="color: {{ $nav->color }};padding: 25px 10px;font-size: 18px;"  onmouseout="this.style.color='{{ $nav->color }}'" onmouseover="this.style.color = 'inherit'">{{ $nav->title }}</a>
                                        @if($nav->sub_navs->count()>0)
                                        <ul style="display: none;">
                                            @foreach($nav->sub_navs as $sub_nav)
                                                @if(!$sub_nav->hidden)
                                                    <li>
                                                        @if($nav->slug == 'shop')
                                                            <a href="{{ url('shop/'.$sub_nav->slug) }}">{{ $sub_nav->title }}</a>
                                                        @elseif($nav->slug =='useful')
                                                            @if($sub_nav->slug=='download-menu')
                                                                @if(!empty($Menu->value && file_exists(public_path('assets/'.$Menu->value))))
                                                                       <a download href="{{ asset('assets/'.$Menu->value) }}">{{ $sub_nav->title }}</a>
                                                                  @else
                                                                       <a href="#">{{ $sub_nav->title }}</a>
                                                                 @endif
                                                                
                                                            @endif
                                                             @if($sub_nav->slug=='download-recipes')
                                                                @if(!empty($Recipes->value && file_exists(public_path('assets/'.$Recipes->value))))
                                                                       <a download href="{{ asset('assets/'.$Recipes->value) }}">{{ $sub_nav->title }}</a>
                                                                  @else
                                                                       <a href="#">{{ $sub_nav->title }}</a>
                                                                 @endif
                                                            @endif
                                                        @else
                                                            <?php
                                                                $url = '#';
                                                                if(isset($sub_nav->page->slug)){
                                                                    $url = url($sub_nav->page->slug.'/page');
                                                                }
                                                                if(!empty($sub_nav->url) && filter_var($sub_nav->url,FILTER_VALIDATE_URL) == true){
                                                                     $url = $sub_nav->url;
                                                               }
                                                            ?>
                                                            <a href="{{ $url }}">{{ $sub_nav->title }}</a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                          {{--  <li class="active flex-col hide-for-medium flex-center">
                                <a href="{{ url('/') }}" class="sf-with-ul">HOME</a>
                            </li>
                            <li class="a-shop">
                                <a href="#shop" class="sf-with-ul">ART</a>
                                <ul style="display: none;">
                                    @foreach($shop_categories as $category)
                                        <li>
                                            <a href="{{ url('category/'.$category->slug) }}">{{ $category->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <!-- pages -->
                            <li class="a-eat" >
                                <a href="#" onmouseout="this.style.color='inherit'" onmouseover="this.style.color = 'red'"  class="sf-with-ul">DECOR</a>
                                <ul style="display: none;">
                                    <li>
                                        <a href="#">Cafe</a>
                                    </li>
                                    <li>
                                        <a href="#">Functions</a>
                                    </li>
                                    <li>
                                        <a href="#">Catering</a>
                                    </li>
                                    <li>
                                        <a href="#">Recipes</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="a-play">
                                <a href="#play" class="sf-with-ul">HOME GOODS</a>
                                <ul style="display: none;">
                                    <li>
                                        <a href="#">Soft Play</a>
                                    </li>
                                    <li>
                                        <a href="#">Birthday Parties</a>
                                    </li>
                                    <li>
                                        <a href="#">Outdoor Animals</a>
                                    </li>
                                    <li>
                                        <a href="#">Outdoor Play</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="a-rest">
                                <a href="#" class="sf-with-ul">FAQS</a>
                                <ul style="display: none;">
                                    <li>
                                        <a href="#">Bunkhouse</a>
                                    </li>
                                    <li>
                                        <a href="#">Wigwams</a>
                                    </li>
                                    <li>
                                        <a href="#">Video button</a>
                                    </li>
                                    <li>
                                        <a href="#">Location</a>
                                    </li>
                                    <li>
                                        <a href="#">Awards</a>
                                    </li>
                                    <li>
                                        <a href="#">Newsletter Sign up</a>
                                    </li>
                                    <li>
                                        <a href="#">Offers/Special Events</a>
                                    </li>
                                </ul>
                            </li>
                            
                             
                           
                            <li class="">
                                <a href="{{ url('/contact') }}" class="sf-with-ul">Contact </a>
                            </li>--}}
                    </nav>
                    <!-- eof main nav -->
                </div>

                <div class="col-md-2 col-sm-4 text-sm-center text-right" style="padding-top: 4px; position: relative;">
                        <!-- {!! Form::open(['route' => 'search','class'=>'searchform search-form','method'=>'get']) !!}
                        <input type="text" value="{{ ((isset($_GET['q']) && !empty($_GET['q'])?$_GET['q']:'')) }}" name="q" class="search-form__search form-control"
                               placeholder="Search keyword" id="modal-search-input">
                        <button type="submit" class="search-form__button">Search</button>
                        {!! Form::close() !!}

                        <div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal"
                             id="search_modal"></div> -->
                            
                        <div class="inner-addon right-addon header-search-bar">
                        
                            {!! Form::open(['route' => 'search','class'=>'searchform search-form','method'=>'get']) !!}
                            <button type="submit" class="search-form__button"><i class="fa fa-search"></i></button>
                            <input type="text" class="form-control" name="q" value="{{ ((isset($_GET['q']) && !empty($_GET['q'])?$_GET['q']:'')) }}" placeholder="Search keyword"  id="modal-search-input">
                            {!! Form::close() !!}
                        </div>
                        <div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal"
                           id="search_modal"></div>
                    </div>
              
            </div>
        </div>
    </div>
</header>