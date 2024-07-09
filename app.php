<!DOCTYPE html>
<html lang="zh-cn" ng-app="surmon">
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" >
  <title>Surmon</title>
  <script src="<?php bloginfo('template_url'); ?>/app/angular/angular.js" ></script>
  <script src="<?php bloginfo('template_url'); ?>/app/angular/angular-route.js" ></script>
  <script src="<?php bloginfo('template_url'); ?>/app/app.js" ></script>
</head>
<body>
  <header></header>
  <article ng-view></article>
  <aside></aside>
  <footer></footer>
</body>
<script src="https://cdn.bootcss.com/jquery/3.0.0-alpha1/jquery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/angular-app.js" ></script>
</html>
