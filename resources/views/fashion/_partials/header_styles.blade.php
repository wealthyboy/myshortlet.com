<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8" />
    <title>{{ isset( $page_title) ?  $page_title .' |  '.config('app.name') :  $system_settings->meta_title  }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
    <meta name="keywords" content="{{ isset($system_settings->meta_tag_keywords) ? $system_settings->meta_tag_keywords : 'cleanse,detox,flattummy,flattummy tea ng,slimming tea' }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="{{ Config('app.url') }}">

     <!-- Favicone Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
	<link rel="icon" href="/img/favicon.ico" type="image/x-icon">
	<link rel="icon" type="image/png" href="/img/favicon-96x96.png">
	<link rel="apple-touch-icon" href="/img/favicon-96x96.png">
    <!-- CSS -->
    <link rel="stylesheet" href="/f/css/bootstrap.min.css">
	<!-- Main CSS File -->
	<link rel="stylesheet" href="/f/css/style.min.css?version={{ str_random(6) }}">
	<link rel="stylesheet" type="text/css" href="/vendor/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="/f/css/skins/skin-default.css?version={{ str_random(6) }}">

    @yield('page-css')
    <link href="/f/css/custom.css?version={{ str_random(6) }}" rel="stylesheet" type="text/css" />
    <meta property="og:site_name" content="avenuemontaigne Co">
    <meta property="og:url" content="https://avenuemontaigne.ng/">
    <meta property="og:title" content="avenuemontaigne">
    <meta property="og:type" content="website">
    <meta property="og:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
    <meta property="og:image:alt" content="">
    <meta name="twitter:site" content="@avenuemontaigne">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
    <meta name="twitter:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
    <script>
		Window.user = {
			user: {!! auth()->check() ? auth()->user() : 0000 !!},
			loggedIn: {!! auth()->check() ? 1 : 0 !!},
			settings: {!! isset($system_settings) ? $system_settings : '' !!},
			token: '{!! csrf_token() !!}'
		}
	</script>
</head>