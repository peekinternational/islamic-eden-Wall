@extends('master')
@section('breadcrumb')
    @include('partials.breadcrumb')
@stop
@section('content')
    <div class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} section_padding_top_40 section_padding_bottom_100">
        <div class="container">
            <div class="row respnsve-blog">
                <div class="col-lg-12 col-md-12 col-sm-12">
                     <div style="height: 400px; overflow: hidden;">
                         <img  style="position: relative; width: 100%; height: 100%;"  src="{{ asset('assets/images/blog/'.$post->images_data) }}" alt="{{ $post->meta_title }}">
                     </div>
                   <div class="blog_title"> {!!  $post->meta_title  !!}
                    <p style=" font-size: 14px;"> {!!  $post->publish_at !!}  |Admin</p>
                   </div> 
                  

                    <div>
                        {!!  $post->post  !!}
                    </div>
                    
                </div>
                <div class="col-lg-12">
                    <hr />
                    
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')

    <script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://islamic-wall.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@stop