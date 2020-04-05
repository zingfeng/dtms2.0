function ZF_GetInfor_Submit() {
    var dataX = $('#dataX').val();
    var dataY = $('#dataY').val();
    var dataWidth = $('#dataWidth').val();
    var dataHeight = $('#dataHeight').val();
    var src_name = $('#image').attr("src_name");
    var passCode = $('#image').attr("passCode");
    var typeCode = $('#typeCode').html();

    // console.log("dataX");
    // console.log(dataX);
    //
    // console.log("src_name");
    // console.log(src_name);
    //
    // console.log("typeCode");
    // console.log(typeCode);

    $.post("/users/crop_pic_basic_Cl",
        {
            typeCode: typeCode,
            id_user_capacity: localStorage.getItem('idu_wb'),
            passCode: passCode,
            src_name: src_name,
            dataHeight: dataHeight,
            dataWidth: dataWidth,
            dataX: dataX,
            dataY: dataY,
        },
        function (data, status) {
            console.log(data);
            try {
                var real_data = JSON.parse(data);

                console.log("real_data");
                console.log(real_data);


                var res_final = real_data[0];
                // var user_id = real_data[1];

                if (res_final == true)
                {
                    alert('Cập nhật thành công');
                    window.location.href = "https://www.aland.edu.vn/thong-tin-ca-nhan.html";
                }else{
                    $('#err_crop').css('display','block');
                    $('#err_crop').html('Error: ' + data);
                }

            }
            catch(err) {
                $('#err_crop').css('display','block');
                $('#err_crop').html('Error: ' + data);
            }
            // var res = getContentObject_ResultAjaxSocket(data);


        });

    console.log("dataX");
    console.log(dataX);
    console.log("dataY");
    console.log(dataY);


}

var typeCode = $('#typeCode').html();
console.log("typeCode");
console.log(typeCode);

switch (typeCode) {
    case 'cover':
        var aspectRatio = 2.5; // 2.5:1
        console.log("aspectRatio");
        console.log(aspectRatio);

        var minCanvasWidth =  0;
        var minCanvasHeight =  0;
        var minCropBoxWidth  = 1000;
        var minCropBoxHeight = 0;
        break;
    default:
        var aspectRatio = 1; // 1:1
        var minCanvasWidth =  200;
        var minCanvasHeight =  200;
        var minCropBoxWidth  = 200;
        var minCropBoxHeight = 200;
        break;
}

function ReadyForCrop() {
    'use strict';

    var console = window.console || { log: function () {} };
    var URL = window.URL || window.webkitURL;
    var $image = $('#image');
    var $download = $('#download');
    var $dataX = $('#dataX');
    var $dataY = $('#dataY');
    var $dataHeight = $('#dataHeight');
    var $dataWidth = $('#dataWidth');
    var $dataRotate = $('#dataRotate');
    var $dataScaleX = $('#dataScaleX');
    var $dataScaleY = $('#dataScaleY');
    var options = {
        aspectRatio: aspectRatio,
        preview: '.img-preview',
        checkCrossOrigin: true,
        checkOrientation: true,
        movable: false,
        scalable: false,
        zoomable: false,
        zoomOnWheel:false,
        background: false,
        viewMode: 0,
        dragMode: 'move',
        // minCanvasWidth: minCanvasWidth,
        minCanvasHeight: minCanvasHeight,
        minCropBoxWidth: minCropBoxWidth,
        minCropBoxHeight: minCropBoxHeight,
        crop: function (e) {
            $dataX.val(Math.round(e.detail.x));
            $dataY.val(Math.round(e.detail.y));
            $dataHeight.val(Math.round(e.detail.height));
            $dataWidth.val(Math.round(e.detail.width));
            $dataRotate.val(e.detail.rotate);
            $dataScaleX.val(e.detail.scaleX);
            $dataScaleY.val(e.detail.scaleY);
        }
    };
    var originalImageURL = $image.attr('src');
    var uploadedImageName = 'cropped.jpg';
    var uploadedImageType = 'image/jpeg';
    var uploadedImageURL;

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Cropper
    $image.on({
        ready: function (e) {
            console.log(e.type);
        },
        cropstart: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropmove: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropend: function (e) {
            console.log(e.type, e.detail.action);
        },
        crop: function (e) {
            console.log(e.type);
        },
        zoom: function (e) {
            console.log(e.type, e.detail.ratio);
        }
    }).cropper(options);

    // Buttons
    if (!$.isFunction(document.createElement('canvas').getContext)) {
        $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
    }

    if (typeof document.createElement('cropper').style.transition === 'undefined') {
        $('button[data-method="rotate"]').prop('disabled', true);
        $('button[data-method="scale"]').prop('disabled', true);
    }

    // Download
    if (typeof $download[0].download === 'undefined') {
        $download.addClass('disabled');
    }

    // Options
    $('.docs-toggles').on('change', 'input', function () {
        var $this = $(this);
        var name = $this.attr('name');
        var type = $this.prop('type');
        var cropBoxData;
        var canvasData;

        if (!$image.data('cropper')) {
            return;
        }

        if (type === 'checkbox') {
            options[name] = $this.prop('checked');
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');

            options.ready = function () {
                $image.cropper('setCropBoxData', cropBoxData);
                $image.cropper('setCanvasData', canvasData);
            };
        } else if (type === 'radio') {
            options[name] = $this.val();
        }

        $image.cropper('destroy').cropper(options);
    });

    // Methods
    $('.docs-buttons').on('click', '[data-method]', function () {
        var $this = $(this);
        var data = $this.data();
        var cropper = $image.data('cropper');
        var cropped;
        var $target;
        var result;

        if ($this.prop('disabled') || $this.hasClass('disabled')) {
            return;
        }

        if (cropper && data.method) {
            data = $.extend({}, data); // Clone a new one

            if (typeof data.target !== 'undefined') {
                $target = $(data.target);

                if (typeof data.option === 'undefined') {
                    try {
                        data.option = JSON.parse($target.val());
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }

            cropped = cropper.cropped;

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        $image.cropper('clear');
                    }

                    break;

                case 'getCroppedCanvas':
                    if (uploadedImageType === 'image/jpeg') {
                        if (!data.option) {
                            data.option = {};
                        }

                        data.option.fillColor = '#fff';
                    }

                    break;
            }

            result = $image.cropper(data.method, data.option, data.secondOption);

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        $image.cropper('crop');
                    }

                    break;

                case 'scaleX':
                case 'scaleY':
                    $(this).data('option', -data.option);
                    break;

                case 'getCroppedCanvas':
                    if (result) {
                        // Bootstrap's Modal
                        $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                        if (!$download.hasClass('disabled')) {
                            download.download = uploadedImageName;
                            $download.attr('href', result.toDataURL(uploadedImageType));
                        }
                    }

                    break;

                case 'destroy':
                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                        uploadedImageURL = '';
                        $image.attr('src', originalImageURL);
                    }

                    break;
            }

            if ($.isPlainObject(result) && $target) {
                try {
                    $target.val(JSON.stringify(result));
                } catch (e) {
                    console.log(e.message);
                }
            }
        }
    });

    // Keyboard
    $(document.body).on('keydown', function (e) {
        if (e.target !== this || !$image.data('cropper') || this.scrollTop > 300) {
            return;
        }

        switch (e.which) {
            case 37:
                e.preventDefault();
                $image.cropper('move', -1, 0);
                break;

            case 38:
                e.preventDefault();
                $image.cropper('move', 0, -1);
                break;

            case 39:
                e.preventDefault();
                $image.cropper('move', 1, 0);
                break;

            case 40:
                e.preventDefault();
                $image.cropper('move', 0, 1);
                break;
        }
    });

    // Import image
    var $inputImage = $('#inputImage');

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (!$image.data('cropper')) {
                return;
            }

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    uploadedImageURL = URL.createObjectURL(file);
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }
}
