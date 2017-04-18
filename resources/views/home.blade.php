@extends('vendor.metronic.assets.global')
@section('page-title', '管理页面')

        @section('plugins-css')
            <link href="{{URL::asset('assets/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/bootstrap-modal/css/bootstrap-modal.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
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
                                        <div class="profile-usertitle-name"> name  </div>
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
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 37 </div>
                                            <div class="uppercase profile-stat-text"> 学习资料 </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 51 </div>
                                            <div class="uppercase profile-stat-text"> 通知公告 </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 61 </div>
                                            <div class="uppercase profile-stat-text"> 基层动态 </div>
                                        </div>
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
                                            <div class="portlet-body">
                                                <div class="table-toolbar">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="btn-group">
                                                                <button id="toggleAddArticle" class="btn sbold green" data-toggle="modal" data-target="#addArticle"> 添加文章
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="btn-group pull-right">
                                                                <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">操作
                                                                    <i class="fa fa-angle-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-remove" data-operate="delete" ></i> 删 除 </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-retweet" data-operate="recover"></i> 恢 复 </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-refresh" data-operate="refresh"></i> 刷 新 </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="articleList">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                                    <span></span>
                                                                </label>
                                                            </th>
                                                            <th> 文章编号 </th>
                                                            <th> 文章标题 </th>
                                                            <th> 文章内容 </th>
                                                            <th> 上传人员 </th>
                                                            <th> 文章类型 </th>
                                                            <th> 文章上传时间 </th>
                                                            <th> 文章状态 </th>
                                                            <th> 修改 </th>
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
                                                                <td> {{sprintf('%03d',$article['id'])}} </td>
                                                                <td> {{$article['title']}} </td>
                                                                <td> {{$article['content']}} </td>
                                                                <td> {{$article['author']}} </td>
                                                                <td> {{$article['type']}} </td>
                                                                <td class="center"> {{$article['created_time']}} </td>
                                                                <td>
                                                                    <input type="checkbox" @if($article['state']==1) {{"checked"}} @endif class="make-switch switch-large" data-label-icon="fa fa-fullscreen" data-on-text="<i class='fa fa-check'></i>" data-on="success" data-off-text="<i class='fa fa-times'></i>" data-off="danger"／>
                                                                </td>
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
                                        <form action="#" id="article" class="form-horizontal">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="false"> × </button>
                                                <h4 class="modal-title"><i class="fa fa-plus"></i> 添加文章 </h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-body">
                                                    <div class="alert alert-danger display-hide">
                                                        <button class="close" data-close="alert"></button> 你填写的信息有误，请检查后再提交 </div>
                                                    <div class="alert alert-success display-hide">
                                                        <button class="close" data-close="alert"></button> 填写完成 </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">文章类型
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="type" /> </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  margin-top-20">
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
                                                            <span class="help-block"> 此处填写文章的网址 </span>
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
                                                            <span class="help-block"> 此处填写图片的网址 </span>
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
                                                                <input type="file" name="uploadPicture"> </span>
                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                                                <button type="button" class="btn green" action="submit" >添加</button>
                                            </div>
                                        </form>
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
        @stop


        @section('theme-js')
            <script src="{{URL::asset('assets/js/metronic/home/profile.js')}}" type="text/javascript"></script>
            <script src="{{URL::asset('assets/js/metronic/home/table-datatables-managed.js')}}" type="text/javascript"></script>
            <script src="{{URL::asset('assets/js/metronic/home/ui-extended-modals.js')}}" type="text/javascript"></script>
        @stop




