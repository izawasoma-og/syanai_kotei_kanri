<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=1366">
  <meta name="robots" content="noindex" />
  <link rel="icon" href="{{ asset('img/favicon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-help.css') }}">
  <!-- 各ページCSS -->
  @stack('css')
	<!-- font-awesome -->
  <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  @hasSection('title')
      <title>@yield('title') - 日報管理システム</title>
  @else
      <title>日報管理システム</title>
  @endif
</head>
<body>
    @include('components.header')
    @include('components.aside')
    <main class="main @yield('main_class')">
        @yield('content')
    </main>
     @yield('modal')

  @stack('js')
</body>

</html>
