<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>

    <main class="page-content py-5">
        <div class="container">

            <div class="row">

                <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title"><?php echo e(trans('site.orders')); ?></h4>
                    </div>

                    <?php if(Session::has("success")): ?>
                        <div class="alert alert-success top-margin">
                            <?php echo e(Session::get("success")); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(Session::has("error")): ?>
                        <div class="alert alert-danger top-margin">
                            <?php echo e(Session::get("error")); ?>

                        </div>
                    <?php endif; ?>

                    <div class="py-3 rounded-lg shadow-around my-4">

                        <div class="row align-items-center flex-column flex-lg-row px-3 px-lg-0">
                            <div class="col-lg-2 col-12">
                                <img class="rounded-circle mb-lg-0 mb-3 d-block mx-auto img-fluid"
                                     src="<?php echo e(($orderDetails->user_image_url) ? $orderDetails->user_image_url : url("/storage/app/public/users/avatar.png")); ?>"
                                      style="width:70px;height:70px"
                                     alt="Generic placeholder image">
                            </div>

                            <div class="col-xl-7 col-lg-6 col-12 pr-lg-0">
                                <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                    <?php echo e($orderDetails->username); ?>

                                </h5>

                                <p class="text-gray font-body-md mb-0">
                                    <span class="d-block">
                                           <?php echo e(trans('site.order_num')); ?><span class="orders-number"><?php echo e($orderDetails->order_code); ?></span>
                                    </span>
                                    <span class="d-block">
                                        <span class="orders-date">
                                            <?php echo e(trans('site.time_date')); ?>

                                            <time datetime="2018-10-25 17:30">
                                                <?php echo e($orderDetails->order_date); ?> - <?php echo e($orderDetails->time_extention); ?> <?php echo e($orderDetails->order_time); ?>

                                            </time>
                                        </span>
                                    </span>
                                    <span class="d-block">
                                         <?php echo e(trans('site.payment_method')); ?>:  <span class="orders-payment"><?php echo e($orderDetails->payment_name); ?></span>
                                    </span>
                                    <span class="d-block">
                                        <?php echo e(trans('site.address')); ?>:
                                        <span class="orders-address">
                                            العنوان بشكل مفصل حسب ما كتبه المستخدم
                                        </span>
                                    </span>
                                </p>

                            </div><!-- .media-body -->
                            <div class="col-xl-3 col-lg-4 col-auto mt-3 mt-lg-0 font-body-md text-lg-center">
                                <span class="py-2 bg-pending text-white d-lg-inline d-block px-3 rounded-curved">
                                    <?php echo e($orderDetails->status_name); ?>

                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border-light border">
                        </div>

                        <div class="row px-3 px-lg-0">
                            <div class="col-lg-8 col-12 pr-lg-0 mx-auto">
                                <h6 class="font-size-base text-lg-right text-center">
                                    <?php echo e(trans('site.details')); ?>:
                                </h6>


                                <?php
                                    $sum = 0;
                                ?>
                                <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="item d-flex justify-content-between font-body-md text-gray">
                                        <div class="item-details">
                                            <p class="item-head mb-auto"><?php echo e($meal->meal_name); ?></p>
                                            <div class="item-body d-flex flex-row">
                                                <span class="price"><?php echo e($meal->meal_price); ?></span>
                                                &times;
                                                <span class="count"><?php echo e($meal->meal_qty); ?></span>
                                                &nbsp;
                                                <span class="currency"><?php echo e(trans('site.riyal')); ?>:</span>
                                            </div>
                                        </div>
                                        <div class="result text-primary">
                                            <span class="total"><?php echo e(((int)$meal->meal_price) * ((int)$meal->meal_qty)); ?></span>
                                            <span class="currency"><?php echo e(trans('site.riyal')); ?></span>
                                        </div>
                                    </div><!-- .item -->
                                    <?php
                                        $sum = $sum + ((int)$meal->meal_price) * ((int)$meal->meal_qty);
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <div class="invoice d-flex justify-content-between mt-3">
                                    <h6 class="font-size-base"><?php echo e(trans('site.total')); ?></h6>
                                    <div class="result text-primary font-body-md">
                                        <span class="total"><?php echo e($sum); ?></span>
                                        <span class="currency"><?php echo e(trans('site.riyal')); ?></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border-light border">
                        </div>

                        <div class="row px-3 px-lg-0">
                            <div class="col-lg-8 col-12 pr-lg-0 mx-auto">
                                <div class="order-confirm text-center text-sm-right">
                                    <a href="<?php echo e(url("/user/orders/decline-order/" . $orderDetails->order_id)); ?>" class="btn btn-primary px-xl-5 px-md-3 px-sm-5 px-5 ml-0 mt-2 ml-sm-2"
                                            >
                                        <?php echo e(trans('site.cancel_order')); ?>

                                    </a>

                                </div>
                            </div>
                        </div>

                    </div>

                    <a href="<?php echo e(url("/user/orders")); ?>" class="btn btn-primary px-5"> <?php echo e(trans('site.back')); ?></a>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
















<?php $__env->stopSection(); ?>
<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>