<?php 
  $params = json_decode($course['params'], true);
?>

<!-- Trending now -->
<?php echo $this->load->get_block('trending'); ?>
<!-- End trending -->

<section id="video-aland">
    <div class="container">
        <div class="row">
            <div class="col-12 information-student">
                <div class="">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title" >
                                    <div class="information-student__title">Chào <span class="username"><?php echo $row['fullname']?></span> - Học viên lớp <?php echo $course['title']?>

                                        <a href="#panel-task-3" data-toggle="collapse" data-parent="#accordion"  aria-expanded="true" style="float:right" > <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="panel-task-3" class="panel-collapse collapse in information-student__content">
                                <div class="panel-body panel-task__body">
                                    <table class="table-information-student table">
                                        <tr class="table-information-student__row">
                                            <td>Họ và tên: <span class="name text-bold"><?php echo $row['fullname']?></span></td>
                                            <td>
                                                Giáo viên: 
                                                <span class="teacher-name text-bold">
                                                <?php if($arrTeacher) { ?>
                                                    <?php 
                                                        $teacherName = array_column($arrTeacher, 'teacher_name');
                                                        echo implode($teacherName, ' | ');
                                                    ?>
                                                <?php } ?>    
                                                </span>
                                            </td>
                                            <td>
                                                <?php if($course['start_time']) { ?>
                                                    Ngày khai giảng: <span class="day-open text-bold"><?php echo date('d/m/Y', $course['start_time'])?></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr class="table-information-student__row">
                                            <td>Tên lớp: <span class="class-name text-bold"><?php echo $course['title']?></span></td>
                                            <td>Đầu vào: <span class="input-point-number text-bold"><?php echo $course['input']?></span>
                                            </td>
                                            <td>Ngày kết thúc (dự kiến): <span
                                                    class="day-close text-bold"><?php echo date('d/m/Y', $course['end_time'])?></span></td>
                                        </tr>
                                        <tr class="table-information-student__row">
                                            <td>Mã lớp: <span class="class-number text-bold"><?php echo $course['sku']?></span></td>
                                            <td>Cam kết đầu ra: <span class="output-point text-bold"><?php echo $course['output']?></span></td>
                                            <!-- <td>Hỗ trợ: <span class="support text-bold">Ms Mai Linh</span></td> -->
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 video-learning">
                <!-- nem video vao day -->
                <div class="video-wrapper">
                    <?php if($classDetail['youtube_id']) { ?>
                            <iframe frameborder="0" width="100%" height="350px" src="https://www.youtube.com/embed/<?php echo $classDetail['youtube_id']?>"></iframe>
                    <?php }else{ ?>
                        <img src="<?php echo getimglink($classDetail['images'], 'size7', 3);?>" alt="<?php echo $classDetail['title'];?>" style="width:100%;">
                    <?php } ?>
                </div>
                <div class="video-overview">
                    <div class="video-overview__title">
                        <?php echo $classDetail['title']?>
                    </div>
                    <?php if($arrTest) { ?>
                    <div class="video-overview__body">
                        <ul class="test-list">
                            <li class="test-list__content -title">
                                Test your skill
                            </li>
                            <?php foreach($arrTest as $item) { ?>
                                <?php if($item['test_list']) { ?>
                                <li class="test-list__content">
                                    <a href="<?php echo str_replace('/test/', '/test/'.strtolower($item['test_list'][0]).'/', $item['share_url']); ?>?skill=1" class="custom-link-color -disable-color">
                                        <?php echo $item['title']?><span><i class="fa fa-check hide-icon" aria-hidden="true"></i></span>
                                    </a>
                                </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>

                <section id="comment">
                    <header class="comment-header">
                        <div class="total-comment">
                            0 Bình luận
                        </div>
                    </header>

                    <section class="comment-list">
                        <!-- bắt đầu form comment-->
                        <div class="comment-block">
                                <!-- bắt đầu comment -->
                                <figure class="comment-block__avatar -color-random-4">
                                    <figcaption class="text-avatar">
                                        K
                                    </figcaption>
                                </figure>
                                <div class="comment-block__content">
                                    <div class="user-comment">
                                        <form class="user-comment__text -form-comment">
                                            <!-- username - content -->
                                            <div class="text-content -custom-answer" contenteditable=true placeholder=" Viết phản hồi..." spellcheck="false">
                                                                                              
                                            </div>
                                        </form>     
                                    </div>
                                    <!-- kết thúc comment -->
                                </div>
                        </div>
                        <!-- kết thúc form comment -->

                    </section> 
                                        
                </section>
            </div>


            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 course-list">
                <div class="course-list__background">
                    <div class="course-list__title">
                        <div class="text-title">Nội dung khóa học</div>
                        <div class="button-filter">
                            <a href="" class="dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-filter" id="filter_learning">
                                <li class="dropdown-filter__items"><a data-learned="1" href="javascript:;">Đã học</a></li>
                                <li class="dropdown-filter__items"><a data-learned="0" href="javascript:;">Chưa học</a></li>
                                <li class="dropdown-filter__items"><a data-type="2" href="javascript:;">Luyện tập</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-filter__items"><a data-learned href="javascript:;">Xem tất cả</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php if($arrTopic) { ?>
                    <div class="single-course">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <?php foreach($arrTopic as $topic) { ?>
                                <div class="panel-heading">
                                    <h4 class="panel-title"  data-toggle="collapse" href="#course1">
                                        <?php echo $topic['name']?>
                                    </h4>
                                </div>
                                <div id="course1" class="panel-collapse collapse single-course__collapse in">
                                    <?php if($arrClass[$topic['topic_id']]) { ?>
                                        <?php foreach($arrClass[$topic['topic_id']] as $class) { ?>
                                            <?php if($class['type'] == 2) { ?>          <!--Test kĩ năng-->
                                                <div class="panel-body lesstion">
                                                    <div class="lesstion__checkbox">
                                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="lesstion-wrapper">
                                                        <div class="lesstion__name">
                                                            <a href="<?php echo $class['share_url']?>">
                                                                <?php echo $class['title']?> <span class="tag-name">Làm ngay</span>
                                                            </a>
                                                        </div>
                                                        <div class="information-wrapper">
                                                            <div class="lesstion__date">
                                                                <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span>  <?php echo date('d/m/Y', $class['create_time'])?>
                                                            </div>
                                                            <a href="<?php echo $class['share_url']?>" class="lesstion__answer">
                                                                 <span><i class="fa fa-puzzle-piece" aria-hidden="true"></i></i></span> Answer
                                                            </a>                                                          
                                                        </div>
                                                    </div>
                                                </div>    
                                            <?php }else{ ?>
                                                <div class="panel-body lesstion <?php echo $class['class_id'] == $classDetail['class_id'] ? '-selected' : ''?>">
                                                    <div class="lesstion__checkbox">
                                                        <i class="<?php echo $class['user_id'] == $row['user_id'] ? 'fa fa-check-circle' : 'fa fa-circle-o'?>" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="lesstion-wrapper">
                                                        <div class="lesstion__name">
                                                            <a href="<?php echo '/hoc-vien'.$class['share_url']?>"><?php echo $class['title']?></a>
                                                        </div>
                                                        <div class="information-wrapper">
                                                            <?php if($class['duration']) { ?>
                                                            <div class="lesstion__time">
                                                                <span class="custom-icon-color"><i class="fa fa-play-circle" aria-hidden="true"></i></span>    <span class="custom-text-color"><?php echo $class['duration']?></span>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="lesstion__date">
                                                                <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span>  <?php echo date('d/m/Y', $class['create_time'])?>
                                                            </div>
                                                            <?php if($class['document']) { ?>
                                                                <a href="<?php echo $class['document']?>" target="_blank" class="lesstion__document">
                                                                    <span><i class="fa fa-file-text-o" aria-hidden="true"></i></span> Document
                                                                </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('#filter_learning a').on("click",function(){
            var url      = document.location.protocol +"//"+ document.location.hostname + document.location.pathname;
            if($(this).data('learned') !== '' && typeof($(this).data('learned')) != 'undefined'){
                url += '?learned='+$(this).data('learned');
            }
            if($(this).data('type') != '' && typeof($(this).data('type')) != 'undefined'){
                url += '?type='+$(this).data('type');
            }
            window.location.href = url;
        })
    });
</script>