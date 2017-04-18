var Profile = function() {

    var dashboardMainChart = null;

    return {

        //main function
        init: function() {
            $('.dropdown-toggle').dropdown();
            Profile.initMiniCharts();

            var ArticleModal = $('#addArticle');
            ArticleModal.on("shown.bs.modal", function() {
                $('#switch-pic', ArticleModal).on('switchChange.bootstrapSwitch', function (e, state) {
                   if(state) {
                       $('#pictureUpload', ArticleModal).hide();
                       $('#pictureUrl', ArticleModal).show();
                   } else {
                       $('#pictureUpload', ArticleModal).show();
                       $('#pictureUrl', ArticleModal).hide();
                   }
                });
                Profile.handleValidation();
            });
        },
          handleValidation : function() {
              // for more info visit the official plugin documentation:
              // http://docs.jquery.com/Plugins/Validation

              var form = $('#article');
              var error = $('.alert-danger', form);
              var success = $('.alert-success', form);

              form.validate({
                  errorElement: 'span', //default input error message container
                  errorClass: 'help-block help-block-error', // default input error message class
                  focusInvalid: false, // do not focus the last invalid input
                  ignore: "",  // validate all fields including form hidden input
                  rules: {
                      title: {
                          minlength: 2,
                          maxlength:255,
                          required: true
                      },
                      content: {
                          maxlength:255,
                      },
                      target_url: {
                          required: true,
                          url: true
                      },
                      pictureUrl: {
                          required: true,
                          url: true
                      },
                      pictureUpload: {
                          extension: ['png','jpeg','jpg','bmp','gif']
                      }

                  },

                  invalidHandler: function (event, validator) { //display error alert on form submit
                      success.hide();
                      error.show();
                      App.scrollTo(error, -200);
                  },

                  errorPlacement: function (error, element) { // render error placement for each input type
                      var icon = $(element).parent('.input-icon').children('i');
                      icon.removeClass('fa-check').addClass("fa-warning");
                      icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                  },

                  highlight: function (element) { // hightlight error inputs
                      $(element)
                          .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                  },

                  unhighlight: function (element) { // revert the change done by hightlight

                  },

                  success: function (label, element) {
                      var icon = $(element).parent('.input-icon').children('i');
                      $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                      icon.removeClass("fa-warning").addClass("fa-check");
                  },

                  submitHandler: function (form) {
                      success.show();
                      error.hide();
                      form[0].submit(); // submit the form
                  }
              });
          },
        initMiniCharts: function() {

            // IE8 Fix: function.bind polyfill
            if (App.isIE8() && !Function.prototype.bind) {
                Function.prototype.bind = function(oThis) {
                    if (typeof this !== "function") {
                        // closest thing possible to the ECMAScript 5 internal IsCallable function
                        throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
                    }

                    var aArgs = Array.prototype.slice.call(arguments, 1),
                        fToBind = this,
                        fNOP = function() {},
                        fBound = function() {
                            return fToBind.apply(this instanceof fNOP && oThis ? this : oThis,
                                aArgs.concat(Array.prototype.slice.call(arguments)));
                        };

                    fNOP.prototype = this.prototype;
                    fBound.prototype = new fNOP();

                    return fBound;
                };
            }

            $("#sparkline_bar").sparkline([8, 9, 10, 11, 10, 10, 12, 10, 10, 11, 9, 12, 11], {
                type: 'bar',
                width: '100',
                barWidth: 6,
                height: '45',
                barColor: '#F36A5B',
                negBarColor: '#e02222'
            });

            $("#sparkline_bar2").sparkline([9, 11, 12, 13, 12, 13, 10, 14, 13, 11, 11, 12, 11], {
                type: 'bar',
                width: '100',
                barWidth: 6,
                height: '45',
                barColor: '#5C9BD1',
                negBarColor: '#e02222'
            });
        }

    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        Profile.init();
    });
}