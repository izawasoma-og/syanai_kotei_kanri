@php
$nowTimeHour = date("G");
@endphp
<header>
    <p class="header__hello">
        @if(6 <= $nowTimeHour && $nowTimeHour < 10)
        おはようございます
        @elseif(10 <= $nowTimeHour && $nowTimeHour < 18)
        こんにちは
        @else
        こんばんは
        @endif
        、 
        @guest
            ログインしてください！
        @else
            {{ Auth::user()->name }} さん！
        @endguest
    </p>
</header>