<div style="margin-bottom: 20px; text-align: right;">
    <a styrole="button" class="btn blue btn-primary" href="/room/add">Добавить обьявление <i class="fa fa-plus-circle"></i></a>
</div>
<div class="row list-view-sorting clearfix">

    <!-- BEGIN PRODUCT LIST -->
    <div class="row product-list">
        <?php foreach ($items as $item) { ?>
            <!-- PRODUCT ITEM START -->
            <div class="col-md-12">
                <div class="product-item <?php if ($item->is_vip) { ?> vip <?php } ?>">
                    <div class="control" style="margin-bottom: 5px; padding-left: 6px; text-align: right; overflow: hidden;">
                        <button type="button" class="btn default" style=" margin-right: 15px;"><i class="fa "></i> <?php echo $item->Services->title; ?></button>

                        <?php if ($item->is_published == 1) { ?>
                            <button type="button" class="btn default" >Снять с размещения</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-success"><i class="fa  fa-tags"></i> Разместить</button>
                        <?php } ?>
                        <button type="button" class="btn btn-danger" style="float: left"><i class="fa fa-times"></i> Удалить</button>
                    </div>
                    <div class="photo">
                        <a href="/service-item/view/<?php echo $item->id; ?>">
                            <img src="/timthumb.php?h=171&src=<?php echo $item->logo_src; ?>" />
                        </a>
                        <div class="pi-price">
                            <span class="price"><?php echo $item->price; ?> руб</span>
                            <span class="date"><i class="fa fa-tags"></i> <?php echo $item->date_post; ?></span>
                        </div>
                    </div>
                    <h3><a href="/service-item/view/<?php echo $item->id; ?>"><?php echo $item->title; ?></a></h3>
                    <div class="description" style="  margin-top: 45px;"><?php echo $item->short_description; ?></div>
                    <div class="navigation">
                        <a href="/service-item/edit/<?php echo $item->id; ?>" class="btn btn-primary add2cart" style="color: #E6400C; margin-left: 15px;">Редактировать</a>
                        <a href="/service-item/view/<?php echo $item->id; ?>" class="btn btn-default add2cart">Подробнее</a>
                    </div>
                </div>
            </div>
            <!-- PRODUCT ITEM END -->
        <?php } ?>
    </div>
    <div class="clear"></div>
</div>