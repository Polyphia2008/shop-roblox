<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
?>
<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg"
      data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

<head>
 <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?=$VCD->site('description');?>">
  <title><?=$title?></title>
   <meta name="keywords" content="<?=$VCD->site('keywords');?>">
        <!-- Open Graph data -->
        <meta property="og:title" content="<?=$VCD->site('title');?>">
        <meta property="og:type" content="Website">
        <meta property="og:url" content="<?=BASE_URL('');?>">
        <meta property="og:image" content="<?=$VCD->site('anhbia');?>">
        <meta property="og:description" content="<?=$VCD->site('description');?>">
        <meta property="og:site_name" content="<?=$VCD->site('title');?>">
        <meta property="article:section" content="<?=$VCD->site('description');?>">
        <meta property="article:tag" content="<?=$VCD->site('keywords');?>">
        <meta name="author" content="ducapi">
        <link rel="icon" href="<?=$VCD->site('favicon');?>" type="image/x-icon" />
        <!-- Twitter Card data -->
        <meta name="twitter:card" content="<?=$VCD->site('anhbia');?>">
        <meta name="twitter:site" content="@vanducmedia">
        <meta name="twitter:title" content="<?=$VCD->site('title');?>">
        <meta name="twitter:description" content="<?=$VCD->site('description');?>">
        <meta name="twitter:creator" content="@vanducmedia">
        <meta name="twitter:image:src" content="<?=$VCD->site('anhbia');?>">
 


    <!-- Layout config Js -->
    <script src="<?= BASE_URL('public') ?>/assets/js/layout.js"></script>

    <link rel="stylesheet" href="<?= BASE_URL('public') ?>/assets/css/tailwind2.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL('public') ?>/assets/css/custom.css?v=1.0.17">

    <link rel="preload" as="style" href="<?= BASE_URL('public') ?>/assets/css/appv2-DmMK7LU4.css" />
    <link rel="stylesheet" href="<?= BASE_URL('public') ?>/assets/css/appv2-DmMK7LU4.css" data-navigate-track="reload" />  
    <link href="<?= BASE_URL('public') ?>/assets/vendor/css/swiper-bundle.min.css" rel="stylesheet" />
   
    <!-- Livewire Styles --><style >[wire\:loading][wire\:loading], [wire\:loading\.delay][wire\:loading\.delay], [wire\:loading\.inline-block][wire\:loading\.inline-block], [wire\:loading\.inline][wire\:loading\.inline], [wire\:loading\.block][wire\:loading\.block], [wire\:loading\.flex][wire\:loading\.flex], [wire\:loading\.table][wire\:loading\.table], [wire\:loading\.grid][wire\:loading\.grid], [wire\:loading\.inline-flex][wire\:loading\.inline-flex] {display: none;}[wire\:loading\.delay\.none][wire\:loading\.delay\.none], [wire\:loading\.delay\.shortest][wire\:loading\.delay\.shortest], [wire\:loading\.delay\.shorter][wire\:loading\.delay\.shorter], [wire\:loading\.delay\.short][wire\:loading\.delay\.short], [wire\:loading\.delay\.default][wire\:loading\.delay\.default], [wire\:loading\.delay\.long][wire\:loading\.delay\.long], [wire\:loading\.delay\.longer][wire\:loading\.delay\.longer], [wire\:loading\.delay\.longest][wire\:loading\.delay\.longest] {display: none;}[wire\:offline][wire\:offline] {display: none;}[wire\:dirty]:not(textarea):not(input):not(select) {display: none;}:root {--livewire-progress-bar-color: #2299dd;}[x-cloak] {display: none !important;}</style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-02P62RLJ7T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-02P62RLJ7T');
    </script>
    <style>

        :is([data-mode=dark] .dark\:color-yellow-2x) {
            color: #facc70 !important;
        }
        /*.group[data-sidebar=dark] :is([data-mode=dark] .group-data-\[sidebar\=dark\]\:dark\:bg-zink-700){*/
        /*    background-color:#0d0322;*/
        /*}*/
        /*.group[data-topbar=dark] :is([data-mode=dark] .group-data-\[topbar\=dark\]\:dark\:bg-zink-700) {*/
        /*    background-color:#0d0322;*/
        /*}*/
        /*:is([data-mode=dark] .card) {*/
        /*    background-color:#0d0322;*/
        /*}*/
        /*:is([data-mode=dark] .dark\:bg-zink-600) {*/
        /*    background-color:#0d0322;*/
        /*}*/
    </style>
       <!-- jQuery -->
<script src="<?= BASE_URL('public') ?>/assets/vendor/js/jquery-3.6.0.min.js"></script>

<!-- Font Awesome for spinner -->
<link rel="stylesheet" href="<?= BASE_URL('public') ?>/assets/vendor/css/fontawesome6.min.css" />

<!-- SweetAlert2 -->
<script src="<?= BASE_URL('public') ?>/assets/vendor/js/sweetalert2@11.js"></script>

<!-- Simple Notify -->
<link rel="stylesheet" href="<?= BASE_URL('public') ?>/assets/vendor/css/simple-notify.css">
<script src="<?= BASE_URL('public') ?>/assets/vendor/js/simple-notify.min.js"></script>

<!-- Fancybox (if needed) -->
<script src="<?= BASE_URL('public') ?>/assets/vendor/js/jquery.fancybox.min.js"></script>
<style> .success-ducapi {
      background-color: #d9f3f0; /* Màu xanh nhạt mới */
      color: #027368; /* Màu chữ xanh đậm */
      border: 1px solid #b3e4df; /* Viền xanh nhạt hơn */
      padding: 8px 10px; /* Khoảng cách bên trong nút */
      border-radius: 6px; /* Bo góc nút */
      font-size: 12px; /* Kích thước chữ */
      font-weight: 500; /* Chữ in vừa */
      cursor: pointer; /* Con trỏ dạng tay khi hover */
      text-align: center;
      transition: background-color 0.3s, border-color 0.3s;
    }

    /* Hiệu ứng khi hover */
    .success-ducapi:hover {
      background-color: #c8ece8; /* Màu nền khi hover */
      border-color: #9fdcd5; /* Viền khi hover */
    }

    /* Hiệu ứng khi bấm */
    .success-ducapi:active {
      background-color: #b7e4e0; /* Màu nền khi bấm */
      border-color: #89cac3; /* Viền khi bấm */
    }
    .err-ducapi {
  background-color: #f8d7da; /* Màu đỏ nhạt mới */
  color: #721c24; /* Màu chữ đỏ đậm */
  border: 1px solid #f5c6cb; /* Viền đỏ nhạt hơn */
  padding: 8px 10px; /* Khoảng cách bên trong nút */
  border-radius: 6px; /* Bo góc nút */
  font-size: 12px; /* Kích thước chữ */
  font-weight: 500; /* Chữ in vừa */
  cursor: pointer; /* Con trỏ dạng tay khi hover */
  text-align: center;
  transition: background-color 0.3s, border-color 0.3s;
}

/* Hiệu ứng khi hover */
.err-ducapi:hover {
  background-color: #f1b0b7; /* Màu nền khi hover */
  border-color: #f1a7b7; /* Viền khi hover */
}

/* Hiệu ứng khi bấm */
.err-ducapi:active {
  background-color: #f0a7b2; /* Màu nền khi bấm */
  border-color: #e76f72; /* Viền khi bấm */
}
</style>
                   <script>
function showMessageDucapi(message, type) {
  const commonOptions = {
    effect: 'fade',
    speed: 300,
    customClass: null,
    customIcon: null,
    showIcon: true,
    showCloseButton: true,
    autoclose: true,
    autotimeout: 3000,
    gap: 20,
    distance: 20,
    type: 'outline',
    position: 'right top'
  };

  const options = {
    success: {
      status: 'success',
      title: 'Thành công!',
      text: message,
    },
    error: {
      status: 'error',
      title: 'Thất bại!',
      text: message,
    }
  };
  new Notify(Object.assign({}, commonOptions, options[type]));
}

</script>
    
</head>

