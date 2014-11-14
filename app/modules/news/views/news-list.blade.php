<?php

    function news_date($field){

        $months = array("01"=>"январь","02"=>"февраль","03"=>"март","04"=>"апрель","05"=>"май","06"=>"июнь","07"=>"июль","08"=>"август","09"=>"сентябрь","10"=>"октябрь","11"=>"ноябрь","12"=>"декабрь");
        $list = explode("-",$field);
        $list[2] = (int)$list[2];
        $field = implode("-",$list);
        $nmonth = $months[$list[1]];
        $pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
        $replacement = "<div class=\"day\">\$5</div><div class=\"date\"><div class=\"month\">$nmonth</div><div class=\"year\">\$1</div></div>";
       return preg_replace($pattern, $replacement,$field);
    }
?>
@if($news->count())
<section class="news-section">
    <ul class="news-ul">
    @foreach($news as $new)
        <li class="news-li clearfix">
            <div class="news-li-left">
                {{ news_date($new->published_at) }}
            </div>
            <div class="news-li-right">
                <h2>{{ $new->meta->first()->title }}</h2>
                <div class="desc">
                    {{ $new->meta->first()->preview }}
                </div>
            </div>
        </li>
    @endforeach
    </ul>
</section>
@endif