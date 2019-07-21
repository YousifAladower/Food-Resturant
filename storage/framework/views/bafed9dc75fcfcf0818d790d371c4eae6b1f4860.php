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

                <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">

                    <div class="page-header py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">قائمة الطعام</h4>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mt-4">
                            <div class="rounded-lg shadow-around">
                                <a href="<?php echo e(url("/restaurant/food-menu/list")); ?>"
                                   class="text-center no-decoration text-secondary p-4 d-block">
                                    <img src="<?php echo e(url("/assets/site/img/food-menu/-e-food-menu-icon.svg")); ?>"
                                         class="img-fluid d-block mx-auto"
                                         width="87"
                                         height="99"
                                         alt="">
                                    <h5 class="item-tile font-size-base font-body-bold mt-4">
                                        كل الوجبات
                                    </h5>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 mt-4">
                            <div class="rounded-lg shadow-around">
                                <a href="<?php echo e(url("/restaurant/food-menu/add-new-meal")); ?>"
                                   class="text-center no-decoration text-secondary p-4 d-block">
                                    <img src="<?php echo e(url("/assets/site/img/food-menu/-e-new-kind-icon.svg")); ?>"
                                         class="img-fluid d-block mx-auto"
                                         width="100"
                                         height="100"
                                         alt="">
                                    <h5 class="item-tile font-size-base font-body-bold mt-4">
                                        وجبه جديده
                                    </h5>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 mt-4">
                            <div class="rounded-lg shadow-around">
                                <a href="<?php echo e(url("/restaurant/food-menu/categories")); ?>"
                                   class="text-center no-decoration text-secondary p-4 d-block">
                                    <img src="<?php echo e(url("assets/site/img/food-menu/-e-categories-icon.svg")); ?>"
                                         class="img-fluid d-block mx-auto"
                                         width="111"
                                         height="99"
                                         alt="">
                                    <h5 class="item-tile font-size-base font-body-bold mt-4">
                                        التصنيفات
                                    </h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>