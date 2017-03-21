//全局变量
var blogUrl = 'http://' + location.host;
console.log(blogUrl);
var templateUrl = blogUrl + '/app/wp-content/themes/Surmon/app/';
console.log(templateUrl);
//声明程序,引入依赖
angular.module('surmon', ['ngRoute'])

//首页控制器
.controller('index', ['$scope','$http','$rootScope','$location',function($scope,$http,$rootScope,$location) {

    //全局数据
    $rootScope.blogUrl = 'http://' + $location.host();
    $rootScope.templateUrl = $rootScope.blogUrl + '/app/wp-content/themes/Surmon/app/';
    $rootScope.a = angular.element(document.getElementsByTagName('a'));
    console.log($rootScope.a);

    //首页数据的加载,默认请求最新
    $http({
        url: $rootScope.blogUrl + '/api/get_posts/',
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.pages = data.pages;
        $scope.postsNum = data.count;
        $scope.posts = data.posts;
    }).error(function(){
        alert('啊哦！请求失败了哦');
    })
}])

//文章内容页控制器
.controller('single', ['$scope','$http','$rootScope','$routeParams',function($scope,$http,$rootScope,$routeParams) {

    //获取路由参数
    $scope.id = $routeParams.id;

    //内容页数据加载
    $http({
        url: blogUrl + '/api/get_post/?id='+$scope.id,
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.single = data;
        console.log($scope.single);
    }).error(function(){
        alert('啊哦！请求失败了哦');
    })
}])

//独立页面控制器
.controller('page', ['$scope','$http','$rootScope','$routeParams',function($scope,$http,$rootScope,$routeParams) {

    //获取路由参数
    $scope.id = $routeParams.id;

    //页面数据加载
    $http({
        url: $rootScope.blogUrl + '/api/get_page/?slug='+$scope.id,
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.contents = data;
    }).error(function(){
        alert('啊哦！请求失败了哦');
    })
}])

//文章列表页控制器
.controller('postlist', ['$scope','$http','$rootScope','$routeParams',function($scope,$http,$rootScope,$routeParams) {

    //获取路由参数
    $scope.action = $routeParams.action;

    //获取路由id参数
    $scope.id = $routeParams.id;
    //预定义一个参数用来判断类型
    //如果这个参数是pages/cate/tag分别发送不同的请求
    //定义首页控制器数据的加载
    $http({
        url: $rootScope.blogUrl + '/api/get_tag_posts/?' + $scope.action +'_slug=' + $scope.id,
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.contents = data;
    }).error(function(){
        alert('啊哦！请求失败了哦');
    })
}])

//路由
.config(['$routeProvider','$rootScopeProvider',function($routeProvider,$rootScopeProvider){
    $routeProvider

    //首页，使用首页模板
    .when('/',{
        templateUrl: templateUrl + 'index.html',
        controller:'index'
    })
    //文章页，使用文章页模板
    .when('/post/:id',{
        templateUrl: templateUrl + 'single.html',
        controller:'single'
    })
    //当访问独立页面时，使用页面模板
    .when('/page/:id',{
        templateUrl: templateUrl + 'page.html',
        controller:'page'
    })
    //标签/分类/默认/搜索/列表页，均使用文章列表页模板
    .when('/:action/:id',{
        templateUrl: templateUrl + 'postlist.html',
        controller:'postlist'
    });
}])

//头部模板
.directive('header', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'header.html'
  };
})

//边栏模板
.directive('aside', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'sidebar.html'
  };
})

//底部模板
.directive('footer', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'footer.html'
  };
})

//文章列表页模板
.directive('postlist', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'postlist.html'
  };
})

//评论框模板
.directive('comment', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'comment.html'
  };
})

//搜索框模板
.directive('search', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl:  templateUrl + 'search.html'
  };
})