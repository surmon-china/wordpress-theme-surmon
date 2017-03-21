//ȫ�ֱ���
var blogUrl = 'http://' + location.host;
console.log(blogUrl);
var templateUrl = blogUrl + '/app/wp-content/themes/Surmon/app/';
console.log(templateUrl);
//��������,��������
angular.module('surmon', ['ngRoute'])

//��ҳ������
.controller('index', ['$scope','$http','$rootScope','$location',function($scope,$http,$rootScope,$location) {

    //ȫ������
    $rootScope.blogUrl = 'http://' + $location.host();
    $rootScope.templateUrl = $rootScope.blogUrl + '/app/wp-content/themes/Surmon/app/';
    $rootScope.a = angular.element(document.getElementsByTagName('a'));
    console.log($rootScope.a);

    //��ҳ���ݵļ���,Ĭ����������
    $http({
        url: $rootScope.blogUrl + '/api/get_posts/',
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.pages = data.pages;
        $scope.postsNum = data.count;
        $scope.posts = data.posts;
    }).error(function(){
        alert('��Ŷ������ʧ����Ŷ');
    })
}])

//��������ҳ������
.controller('single', ['$scope','$http','$rootScope','$routeParams',function($scope,$http,$rootScope,$routeParams) {

    //��ȡ·�ɲ���
    $scope.id = $routeParams.id;

    //����ҳ���ݼ���
    $http({
        url: blogUrl + '/api/get_post/?id='+$scope.id,
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.single = data;
        console.log($scope.single);
    }).error(function(){
        alert('��Ŷ������ʧ����Ŷ');
    })
}])

//����ҳ�������
.controller('page', ['$scope','$http','$rootScope','$routeParams',function($scope,$http,$rootScope,$routeParams) {

    //��ȡ·�ɲ���
    $scope.id = $routeParams.id;

    //ҳ�����ݼ���
    $http({
        url: $rootScope.blogUrl + '/api/get_page/?slug='+$scope.id,
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.contents = data;
    }).error(function(){
        alert('��Ŷ������ʧ����Ŷ');
    })
}])

//�����б�ҳ������
.controller('postlist', ['$scope','$http','$rootScope','$routeParams',function($scope,$http,$rootScope,$routeParams) {

    //��ȡ·�ɲ���
    $scope.action = $routeParams.action;

    //��ȡ·��id����
    $scope.id = $routeParams.id;
    //Ԥ����һ�����������ж�����
    //������������pages/cate/tag�ֱ��Ͳ�ͬ������
    //������ҳ���������ݵļ���
    $http({
        url: $rootScope.blogUrl + '/api/get_tag_posts/?' + $scope.action +'_slug=' + $scope.id,
        method:'GET'
    }).success(function(data,header,config,status){
        $scope.contents = data;
    }).error(function(){
        alert('��Ŷ������ʧ����Ŷ');
    })
}])

//·��
.config(['$routeProvider','$rootScopeProvider',function($routeProvider,$rootScopeProvider){
    $routeProvider

    //��ҳ��ʹ����ҳģ��
    .when('/',{
        templateUrl: templateUrl + 'index.html',
        controller:'index'
    })
    //����ҳ��ʹ������ҳģ��
    .when('/post/:id',{
        templateUrl: templateUrl + 'single.html',
        controller:'single'
    })
    //�����ʶ���ҳ��ʱ��ʹ��ҳ��ģ��
    .when('/page/:id',{
        templateUrl: templateUrl + 'page.html',
        controller:'page'
    })
    //��ǩ/����/Ĭ��/����/�б�ҳ����ʹ�������б�ҳģ��
    .when('/:action/:id',{
        templateUrl: templateUrl + 'postlist.html',
        controller:'postlist'
    });
}])

//ͷ��ģ��
.directive('header', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'header.html'
  };
})

//����ģ��
.directive('aside', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'sidebar.html'
  };
})

//�ײ�ģ��
.directive('footer', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'footer.html'
  };
})

//�����б�ҳģ��
.directive('postlist', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'postlist.html'
  };
})

//���ۿ�ģ��
.directive('comment', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl: templateUrl + 'comment.html'
  };
})

//������ģ��
.directive('search', function() {
  return {
    restrict: 'EA',
    replace: true ,
    templateUrl:  templateUrl + 'search.html'
  };
})