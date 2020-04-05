<?php
/**
 * Created by PhpStorm.
 * User: Zingfeng-Dragon
 * Date: 22/10/2018
 * Time: 10:59 PM
 */

?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thay đổi profile</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php

    if (isset($mobile)) { // mobile
        echo '<link  rel="stylesheet" type="text/css" href="https://thien.tv/public/core/css/dashboard_mobile.css">';
    } else { // desktop
        echo '<link  rel="stylesheet" type="text/css" href="https://thien.tv/public/core/css/dashboard.css">';
    }

    ?>
    <?php
    if (isset($mobile)) {
        // mobile
        echo '
        <link  rel="stylesheet" type="text/css" href="https://thien.tv/public/core/css/homeuser_mobile.css">
        ';
    } else {
        // desktop
        echo '
        <link  rel="stylesheet" type="text/css" href="https://thien.tv/public/core/css/homeuser.css">
        ';
    }
    ?>

    <script src="https://thien.tv/public/core/js/jquery/jquery-3.1.1.js"></script>
    <script src="https://thien.tv/public/core/js/jquery/jquery-ui.js"></script>
    <script src="https://thien.tv/public/core/js/jquery/jquery.min.js"></script>
    <script src="https://thien.tv/public/core/js/jquery/jquery.form.js"></script>
    <script src="https://thien.tv/public/core/js/jquery/jquery.uploadfile.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css">
    <link rel="stylesheet" href="https://thien.tv/public/core/js/lib_js/cropper/main.css">

    <style type="text/css">
        body {
            background-color: #352f2f !important;
        }
        img {
            max-width: 100%; /* This rule is very important, please do not ignore this! */
        }
        div.container-fluid {
            background-color: white;
        }

        div.container {
            background-color: white;
        }


        .ajax-upload-dragdrop {
            display: block;
            border: none;
            width: auto !important;
        }
        .ajax-file-upload-statusbar {
            width: 350px !important;
            max-width: none !important;
            max-height: none !important;
        }
    </style>

</head>

<body style="background-color: #fffdfd">

<div class="container">
    <br>
    <br>
    <br>
    <div class="container-fluid" style="margin-bottom: 0px; border-bottom: 1px solid lightgrey">
        <h5><?php if (isset($type_text)) echo $type_text;  ?></h5>
        <div id="uploadPart"  class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group d-inline-block">
            <label style="font-weight: bold" for="usr">Bấm Upload để tải ảnh lên</label>
            <div id="upload_image" style="display: block"></div>

            <button class="btn btn-sm btn-info"  id='upload_image_btn' type_pic="avarta" style="display: none"  onclick="ChangeTheWorld(event)">Đồng ý thay đổi</button>
            <div>
                <p class="text-danger" id="err_upload" style="display: none"></p>
            </div>
        </div>
    </div>

    <xmp id="hello" style="display: none"></xmp>
    <xmp id="typeCode" style="display: none"><?php if(isset($typeCode)) echo $typeCode; ?></xmp>
</div>

<!--[if lt IE 9]>
<div class="alert alert-warning alert-dismissible fade show m-0 rounded-0" role="alert">
    You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
    browser</a> to improve your experience.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<![endif]-->


<!-- Content -->
<div class="container" id='cropPart' style="display: none;">
    <div class="row">

        <div class="col-md-7">
            <div>
                <img id="image" src="">
            </div>
        </div>
        <div class="col-md-5">
            <!-- <h3>Preview:</h3> -->
            <div class="docs-preview clearfix">
                <p>Ảnh của bạn: </p>
                <div class="img-preview preview-lg" style="width: 100%;">
                    <img />
                </div>
                <div class="img-preview preview-md" style="width: 128px; height: 72px; display:none;"><img
                        src="https://fengyuanchen.github.io/jquery-cropper/images/picture.jpg"
                        style="display: block; width: 132.231px; height: 74.3802px; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; transform: translateX(-7.93388px) translateY(-6.27979px);">
                </div>
                <div class="img-preview preview-sm" style="width: 64px; height: 36px; display:none;"><img
                        src="https://fengyuanchen.github.io/jquery-cropper/images/picture.jpg"
                        style="display: block; width: 66.1157px; height: 37.1901px; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; transform: translateX(-3.96694px) translateY(-3.13989px);">
                </div>
                <div class="img-preview preview-xs" style="width: 32px; height: 18px; display:none;"><img
                        src="https://fengyuanchen.github.io/jquery-cropper/images/picture.jpg"
                        style="display: block; width: 33.0579px; height: 18.595px; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; transform: translateX(-1.98347px) translateY(-1.56995px);">
                </div>
            </div>

            <div class="container" >
                <button class="btn btn-success" onclick="ZF_GetInfor_Submit()">Đồng ý</button>
                <div>
                    <p class="text-danger" style="display: none" id="err_crop"></p>
                </div>
            </div>
            <!-- <h3>Data:</h3> -->
            <div class="docs-data" style="visibility: hidden; height: 10px">
                <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="dataX">X</label>
            </span>
                    <input type="text" class="form-control" id="dataX" placeholder="x">
                    <span class="input-group-append">
              <span class="input-group-text">px</span>
            </span>
                </div>
                <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="dataY">Y</label>
            </span>
                    <input type="text" class="form-control" id="dataY" placeholder="y">
                    <span class="input-group-append">
              <span class="input-group-text">px</span>
            </span>
                </div>
                <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="dataWidth">Width</label>
            </span>
                    <input type="text" class="form-control" id="dataWidth" placeholder="width">
                    <span class="input-group-append">
              <span class="input-group-text">px</span>
            </span>
                </div>
                <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="dataHeight">Height</label>
            </span>
                    <input type="text" class="form-control" id="dataHeight" placeholder="height">
                    <span class="input-group-append">
              <span class="input-group-text">px</span>
            </span>
                </div>
                <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="dataRotate">Rotate</label>
            </span>
                    <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                    <span class="input-group-append">
              <span class="input-group-text">deg</span>
            </span>
                </div>
                <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="dataScaleX">ScaleX</label>
            </span>
                    <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                </div>
                <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="dataScaleY">ScaleY</label>
            </span>
                    <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="display:none">
        <div class="col-md-9 docs-buttons">
            <!-- <h3>Toolbar:</h3> -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
              <span class="fa fa-arrows"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
              <span class="fa fa-crop"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;zoom&quot;, 0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;zoom&quot;, -0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10"
                        data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;move&quot;, -10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0"
                        title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;move&quot;, 10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                        data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;move&quot;, 0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10"
                        title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;move&quot;, 0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45"
                        title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;rotate&quot;, -45)">
              <span class="fa fa-rotate-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45"
                        title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;rotate&quot;, 45)">
              <span class="fa fa-rotate-right"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1"
                        title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;scaleX&quot;, -1)">
              <span class="fa fa-arrows-h"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1"
                        title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;scaleY&quot;, -1)">
              <span class="fa fa-arrows-v"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;crop&quot;)">
              <span class="fa fa-check"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;clear&quot;)">
              <span class="fa fa-remove"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;disable&quot;)">
              <span class="fa fa-lock"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;enable&quot;)">
              <span class="fa fa-unlock"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;reset&quot;)">
              <span class="fa fa-refresh"></span>
            </span>
                </button>
                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file"
                           accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="Import image with Blob URLs">
              <span class="fa fa-upload"></span>
            </span>
                </label>
                <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;destroy&quot;)">
              <span class="fa fa-power-off"></span>
            </span>
                </button>
            </div>

            <div class="btn-group btn-group-crop">
                <button type="button" class="btn btn-success" data-method="getCroppedCanvas"
                        data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;getCroppedCanvas&quot;, { maxWidth: 4096, maxHeight: 4096 })">
              Get Cropped Canvas
            </span>
                </button>
                <button type="button" class="btn btn-success" data-method="getCroppedCanvas"
                        data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 160, height: 90 })">
              160×90
            </span>
                </button>
                <button type="button" class="btn btn-success" data-method="getCroppedCanvas"
                        data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                  data-original-title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 320, height: 180 })">
              320×180
            </span>
                </button>
            </div>

            <!-- Show the cropped image in modal -->
            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true"
                 aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <button type="button" class="btn btn-secondary" data-method="getData" data-option="" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;getData&quot;)">
            Get Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="setData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;setData&quot;, data)">
            Set Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="getContainerData" data-option=""
                    data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;getContainerData&quot;)">
            Get Container Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="getImageData" data-option=""
                    data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;getImageData&quot;)">
            Get Image Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="getCanvasData" data-option=""
                    data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;getCanvasData&quot;)">
            Get Canvas Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="setCanvasData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;setCanvasData&quot;, data)">
            Set Canvas Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="getCropBoxData" data-option=""
                    data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;getCropBoxData&quot;)">
            Get Crop Box Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="setCropBoxData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="$().cropper(&quot;setCropBoxData&quot;, data)">
            Set Crop Box Data
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="moveTo" data-option="0">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="cropper.moveTo(0)">
            Move to [0,0]
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="zoomTo" data-option="1">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="cropper.zoomTo(1)">
            Zoom to 100%
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="rotateTo" data-option="180">
          <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                data-original-title="cropper.rotateTo(180)">
            Rotate 180°
          </span>
            </button>
            <button type="button" class="btn btn-secondary" data-method="scale" data-option="-2"
                    data-second-option="-1">
          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.scale(-2, -1)">
            Scale (-2, -1)
          </span>
            </button>
            <textarea type="text" class="form-control" id="putData" rows="1"
                      placeholder="Get data to here or set data with this value"></textarea>
        </div><!-- /.docs-buttons -->

        <div class="col-md-3 docs-toggles">
            <!-- <h3>Toggles:</h3> -->
            <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                <label class="btn btn-primary active">
                    <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="aspectRatio: 16 / 9">
              16:9
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="aspectRatio: 4 / 3">
              4:3
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="aspectRatio: 1 / 1">
              1:1
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="aspectRatio: 2 / 3">
              2:3
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="aspectRatio: NaN">
              Free
            </span>
                </label>
            </div>

            <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                <label class="btn btn-primary active">
                    <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked="">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="View Mode 0">
              VM0
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="View Mode 1">
              VM1
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="View Mode 2">
              VM2
            </span>
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title=""
                          data-original-title="View Mode 3">
              VM3
            </span>
                </label>
            </div>

            <div class="dropdown dropup docs-options">
                <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions"
                        data-toggle="dropdown" aria-expanded="true">
                    Toggle Options
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="responsive" type="checkbox" name="responsive"
                                   checked="">
                            <label class="form-check-label" for="responsive">responsive</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="restore" type="checkbox" name="restore" checked="">
                            <label class="form-check-label" for="restore">restore</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="checkCrossOrigin" type="checkbox"
                                   name="checkCrossOrigin" checked="">
                            <label class="form-check-label" for="checkCrossOrigin">checkCrossOrigin</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="checkOrientation" type="checkbox"
                                   name="checkOrientation" checked="">
                            <label class="form-check-label" for="checkOrientation">checkOrientation</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="modal" type="checkbox" name="modal" checked="">
                            <label class="form-check-label" for="modal">modal</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="guides" type="checkbox" name="guides" checked="">
                            <label class="form-check-label" for="guides">guides</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="center" type="checkbox" name="center" checked="">
                            <label class="form-check-label" for="center">center</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="highlight" type="checkbox" name="highlight" checked="">
                            <label class="form-check-label" for="highlight">highlight</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="background" type="checkbox" name="background"
                                   checked="">
                            <label class="form-check-label" for="background">background</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="autoCrop" type="checkbox" name="autoCrop" checked="">
                            <label class="form-check-label" for="autoCrop">autoCrop</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="movable" type="checkbox" name="movable" checked="">
                            <label class="form-check-label" for="movable">movable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="rotatable" type="checkbox" name="rotatable" checked="">
                            <label class="form-check-label" for="rotatable">rotatable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="scalable" type="checkbox" name="scalable" checked="">
                            <label class="form-check-label" for="scalable">scalable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="zoomable" type="checkbox" name="zoomable" checked="">
                            <label class="form-check-label" for="zoomable">zoomable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="zoomOnTouch" type="checkbox" name="zoomOnTouch"
                                   checked="">
                            <label class="form-check-label" for="zoomOnTouch">zoomOnTouch</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="zoomOnWheel" type="checkbox" name="zoomOnWheel"
                                   checked="">
                            <label class="form-check-label" for="zoomOnWheel">zoomOnWheel</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="cropBoxMovable" type="checkbox" name="cropBoxMovable"
                                   checked="">
                            <label class="form-check-label" for="cropBoxMovable">cropBoxMovable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="cropBoxResizable" type="checkbox"
                                   name="cropBoxResizable" checked="">
                            <label class="form-check-label" for="cropBoxResizable">cropBoxResizable</label>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="form-check">
                            <input class="form-check-input" id="toggleDragModeOnDblclick" type="checkbox"
                                   name="toggleDragModeOnDblclick" checked="">
                            <label class="form-check-label"
                                   for="toggleDragModeOnDblclick">toggleDragModeOnDblclick</label>
                        </div>
                    </li>
                </ul>
            </div><!-- /.dropdown -->

        </div><!-- /.docs-toggles -->
    </div>
</div>

<!-- Scripts -->
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://fengyuanchen.github.io/js/common.js"></script>
<script src="https://unpkg.com/cropperjs/dist/cropper.js"></script>
<script src="https://thien.tv/public/core/js/lib_js/cropper/jquery-cropper.js"></script>
<script src="theme/frontend/default/js/uploadimage.js"></script>


<script>

    function log(something,other_className) {
        var node = document.createElement("p");
        if ( typeof(other_className) === 'undefined'){
            node.className = "text-danger";
        }else{
            node.className = other_className;
        }

        node.innerHTML = "&#x2022; " + something ;

        document.getElementById("log").appendChild(node);
    }

    function clearLog() {
        document.getElementById("log").innerHTML ='';
    }


    function ChangeTheWorld(event) {
        var obj = event.target;
        var id_target = obj.id;
        var type_pic = obj.getAttribute('type_pic');
        var name_img = Get_Pic_URL_Client(type_pic);
        var content = {
            opt_cod: "ud2",
            type_pic: type_pic,
            name_img: name_img,
        };

        var mainContent = JSON.stringify(content);
        $.post("/Ajax_socket",
            {
                id_user: localStorage.getItem('idu_wb'),
                token: localStorage.getItem('tkk_wb'),
                number: 1,
                content: mainContent,
            },
            function (data, status) {
                console.log(data);
                var res = getContentObject_ResultAjaxSocket(data);
                if (res === true){

                    $( "#" + id_target).after( "<p style='color:#3caa5d' >Cập nhật thành công</p>" );
                    $( "#" + id_target).css('display','none');
                }
            });
    }

    // -=-=-=-=-=-=-=-=--=-=-=-=--=-=-=-=--=-=-=-=-  TECHNICAL INPUT


    function getContentText_ResultAjaxSocket(data) {
        var n = data.indexOf("Zif!@#$%()");
        var data2 = data.substr(n + 10);
        var m = data2.indexOf("Eif!@#$%()");
        var data3 = data2.substr(0, m);
        return data3;
    }

    function getContentObject_ResultAjaxSocket(data) {
        var n = data.indexOf("Zif!@#$%()");
        var data2 = data.substr(n + 10);
        var m = data2.indexOf("Eif!@#$%()");
        var data3 = data2.substr(0, m);

        var ss = JSON.parse(data3);
        var content = ss[0]; // Status Edit
        return content;
    }

    function Toogle(id_target) {
        $("#" + id_target).toggle();
    }


    // Phần upload ảnh
    $(document).ready(function()
    {
        // initialize Form upload ảnh
        var id_user = localStorage.getItem('idu_wb');
        var token = localStorage.getItem('tkk_wb');
        $("#upload_image").uploadFile({
            url:"users/upload_pic_crop?id_user="+id_user+"&token="+token,
            // url:"uploads/upload_pic_crop?id_user="+id_user+"&token="+token,
            id_user: localStorage.getItem('idu_wb'),
            token: localStorage.getItem('tkk_wb'),
            autoSubmit:true,
            sequential:true,
            sequentialCount:1,
            maxFileSize:5000000,// 5M
            maxFileCount:1,// 1 Files
            allowedTypes:"jpg,jpeg,png,gif,bmp",
            multiple:true,
            showPreview:true,
            showDelete: true, // CÓ LỖI THÌ btn delete sẽ ko thể hiện
            fileName: "INPUT_FILE_NAME",
            onSuccess:function(files,data,xhr,pd)
            {
                console.log("onSuccess");
                console.log(data);

                try {
                    var real_data = JSON.parse(data);

                    console.log("real_data");
                    console.log(real_data);

                    var passCode = real_data[1];

                    $('#image').attr("src","/uploads/images/avarta/" + real_data[0]);
                    $('#image').attr("src_name",real_data[0]);
                    $('#image').attr("passCode",passCode);
                    $('#uploadPart').css('height',0);
                    $('#uploadPart').css('overflow','hidden');
                    ReadyForCrop();
                    $('#cropPart').css('display','block');
                }
                catch(err) {
                    $('#err_upload').css('display','block');
                    $('#err_upload').html('Lỗi: ' + data);
                }


            },
            onSubmit:function(files)
            {
                //files : danh sách file
                //return false; Ngừng upload
//                var showPic = document.getElementById("showPic");
//                if (showPic != null){
//                    showPic.setAttribute("status","uploading");
//                }
                // Để tránh đang upload dở

            },
            afterUploadAll:function(obj)
            {
                //Nội dung cần thực thi khi đã upload xong hết

//                var showPic = document.getElementById("showPic");
//                if (showPic != null){
//                    showPic.setAttribute("status","done");
//                }
            },
            deleteCallback: function(data,pd,files)
            {
                Set_Pic_URL_Client("","avarta");
                var backup_src = $('#avarta_personal_page').attr("backup");
                $('#avarta_personal_page').attr("src",backup_src);
                $('#upload_image_btn').css('display','none');
            }
        });
    });


    function Set_Pic_URL_Client(Pic_URL,type) {
        $('#hello').attr(type,Pic_URL);
    }

    function Get_Pic_URL_Client(type) {
        return $('#hello').attr(type);
    }


</script>
</body>

</html>


