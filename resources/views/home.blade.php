@extends('vendor.metronic.assets.global')
@section('page-title', '管理页面')

        @section('plugins-css')
            <link href="{{URL::asset('assets/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/bootstrap-modal/css/bootstrap-modal.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
        @stop



        @section('theme-css')
            @parent
            <link href="{{URL::asset('assets/css/metronic/pages/profile.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/css/metronic/pages/ticket.min.css')}}" rel="stylesheet" type="text/css" />
        @stop

        @section('layout-css')
            @parent
            <link href="{{URL::asset('assets/css/metronic/pages/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
            <link href="{{URL::asset('assets/css/metronic/pages/custom.min.css')}}" rel="stylesheet" type="text/css" />
        @stop
@section('body-class', 'page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-sidebar-closed')
        @section('header')
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <div class="top-menu">

                        <ul class="nav navbar-nav pull-right">
                            <li >
                                <a href="{{URL::route('logout')}}"  class="portlet-body  blue-chambray btn">
                                    <i class="icon-logout"></i>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        @stop
        @section('container')
        <div class="page-container">
            @parent

            @section('content')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">


                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet ">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <img src="{{URL::asset('assets/img/profile/profile_user.jpg')}}" class="img-responsive" alt=""> </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name">{{session('user.nickname')}}  </div>
                                        <div class="profile-usertitle-job"> 管理员 </div>
                                    </div>

                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li class="active">
                                                <a href="#">
                                                    <i class="icon-home"></i> 文章 列表 </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <div class="portlet light ">
                                    <!-- STAT -->
                                    <div class="row list-separated profile-stat">
                                        @foreach($articleTypes as $articleType)
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> {{$articleType['article_num']}} </div>
                                            <div class="uppercase profile-stat-text"> {{$articleType['display']}} </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- END STAT -->
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <!-- BEGIN TICKET LIST CONTENT -->
                            <div class="app-ticket app-ticket-list">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">文 章 列 表</span>
                                                </div>
                                            </div>
                                            <div class="alert alert-danger" id="table-alert">
                                            @if (count($errors) > 0)
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                            @endif
                                            </div>
                                            <div class="portlet-body">
                                                <div class="table-toolbar">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="btn-group">
                                                                <button id="toggleAddArticle" class="btn sbold green" data-toggle="modal" data-target="#addArticle"> 添加文章
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            @if (isset($articleTypes))
                                                            <div class="btn-group">
                                                                <select class="selectpicker show-tick"   title="筛选文章类型"  data-style="btn blue-sharp sbold  btn-outline " data-width="125px" id="siftType">
                                                                    <option value="-1">全部</option>

                                                                        @foreach($articleTypes as $key =>$articleType)
                                                                            <option value="{{$key}}">{{$articleType['display']}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="btn-group pull-right">
                                                                <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">操作
                                                                    <i class="fa fa-angle-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li>
                                                                        <a href="javascript:;" data-operate="delete" data-target="#articleList">
                                                                            <i class="fa fa-remove" ></i> 删 除 </a>
                                                                    </li>
                                                                    {{--<li>--}}
                                                                        {{--<a href="javascript:;">--}}
                                                                            {{--<i class="fa fa-retweet" data-operate="hot" data-target="#articleList"></i> 恢 复 </a>--}}
                                                                    {{--</li>--}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-striped table-bordered table-hover table-checkable " id="articleList">
                                                    <thead>
                                                        <tr>
                                                            <th class="unorderable unsearchable">
                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                    <input type="checkbox" class="group-checkable" data-set="#articleList .checkboxes" />
                                                                    <span></span>
                                                                </label>
                                                            </th>
                                                            <th> 文章编号 </th>
                                                            <th> 文章标题 </th>
                                                            <th> 文章导语 </th>
                                                            <th> 上传人员 </th>
                                                            <th class="unsearchable"> 文章类型 </th>
                                                            <th class="unsearchable"> 文章上传时间 </th>
                                                            <th class="unsearchable unorderable  invisible"> 热门 </th>
                                                            <th class="unorderable invisible"> state </th>
                                                            <th class="unorderable invisible"> article_id </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if (isset($articles))
                                                        @foreach ($articles as $article)
                                                            <tr class="odd gradeX">
                                                                <td>
                                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                        <input type="checkbox" class="checkboxes" value="{{$article['id']}}" />
                                                                        <span></span>
                                                                    </label>
                                                                </td>
                                                                <td> {{sprintf('%04d',$article['id'])}} </td>
                                                                <td> {{$article['title']}} </td>
                                                                <td> {{$article['content']}} </td>
                                                                <td> {{$article['author']}} </td>
                                                                <td class="unsearchable" > {{$article['type']}} </td>
                                                                <td class="center unsearchable"> {{$article['created_at']}} </td>
                                                                <td class="unsearchable unorderable invisible" >
                                                                    <input type="checkbox" @if($article['state']==2) {{"checked"}} @endif class="make-switch switch-large" data-label-icon="fa fa-fullscreen" data-on-text="<i class='fa fa-check'></i>" data-on-color="success" data-id="{{$article['id']}}" data-off-text="<i class='fa fa-times'></i>" data-off-color="danger"／>
                                                                </td>
                                                                <td class="unorderable invisible">{{$article['state']}}</td>
                                                                <td class="unorderable invisible">{{$article['type_id']}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="addArticle"  class="modal fade" tabindex="-1"  data-backdrop="static" data-keyboard="false" role="dialog" >
                                <div class="modal-dialog">
                                    <div class="portlet-body form modal-content" >
                                        {!! Form::open(['action' => 'ArticleController@upload', 'id'=>'article', 'class'=>'form-horizontal', 'enctype'=>"multipart/form-data"]) !!}
                                        {{--<form action="{{URL::action('ArticleController@upload')}}" method="post" id="article" class="form-horizontal"  enctype="muitipart/form-data" >--}}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="false"> × </button>
                                                <h4 class="modal-title"><i class="fa fa-plus"></i> 添加文章 </h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-body margin-top-20" >
                                                    <div class="alert alert-danger display-hide">
                                                        <button class="close" data-close="alert"></button> 你填写的信息有误，请检查后再提交 </div>
                                                    <div class="alert alert-success display-hide">
                                                        <button class="close" data-close="alert"></button> 填写完成 </div>
                                                    @if (isset($articleTypes))
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">文章类型
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-8">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <select class="selectpicker show-tick" name="type"  title="选择添加的文章类型" >
                                                                       @foreach($articleTypes as $key => $articleType)
                                                                           @if ($key !== 0)
                                                                           <option value="{{$articleType['value']}}">{{$articleType['display']}}</option>
                                                                            @endif
                                                                       @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="form-group ">
                                                        <label class="control-label col-md-4">标题
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="title" /> </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">导语
                                                            <span class="required">  </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="content" /> </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">文章外链
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="target_url" /> </div>
                                                            <span class="help-block"> 此处填写文章的网址  不能省略http://</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">
                                                            <input type="checkbox" id="switch-pic" data-size="small" class="make-switch" checked data-on-color="primary" data-off-color="info" data-on-text="外链图片" data-off-text="上传图片">
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-6" id="pictureUrl">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="pictureUrl" /> </div>
                                                            <span class="help-block"> 此处填写图片的网址 不能省略http:// </span>
                                                        </div>
                                                        <div class="col-md-6" id="pictureUpload" style="display: none">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="input-group input-large">
                                                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                        <span class="fileinput-filename"> </span>
                                                                    </div>
                                                                    <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> 选择图片 </span>
                                                                <span class="fileinput-exists"> 修改 </span>
                                                                <input type="file" name="uploadPicture"></span>
                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                                                <button type="submit" class="btn green" action="submit" >添加</button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>

            <!-- END CONTENT -->
            @stop

        </div>

        <!-- END CONTAINER -->
        @stop

        @section('plugins-js')
            <script src="{{URL::asset('assets/plugins/datatables/datatables.min.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/jquery.sparkline.min.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/bootstrap-modal/js/bootstrap-modal.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/jquery-validation/js/additional-methods.min.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/jquery-validation/js/localization/messages_zh.min.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
        @stop


        @section('theme-js')
            <script src="{{URL::asset('assets/js/metronic/home/profile.js')}}" type="text/javascript"></script>
            <script src="{{URL::asset('assets/js/metronic/home/table-datatables-managed.js')}}" type="text/javascript"></script>
            <script src="{{URL::asset('assets/js/metronic/home/ui-extended-modals.js')}}" type="text/javascript"></script>
            @include('vendor.metronic.home.js')
        @stop





