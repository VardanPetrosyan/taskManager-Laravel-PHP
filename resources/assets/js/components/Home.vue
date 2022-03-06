<template>

    <div class="wrapper">
        <v-snackbar
                v-model="snackbar"
                :timeout="2000"
                :top="true"
        >
            Կատարված է
        </v-snackbar>

        <Head v-bind:title="filterFunc" v-bind:property="cartContent" v-bind:filterByCategory="categoryFilter"/>

        <section id="category-grid">
            <div class="container-fluid" style="margin-top:30px">
                <div class="col-xs-12 col-sm-3 no-margin sidebar narrow" >
                    <div class="widget">
                        <div class="body bordered">
                            <div class="category-filter">
                                <h2>Կատեգորիաներ ( Պահեստներ )</h2>
                                <div class="btn-group btn-group-lg" style="width: 100%" role="group"
                                     aria-label="Large button group">
                                    <button type="button" v-on:click="categorytabs(0)"
                                            style="width: 30%; padding-left: 5px;"
                                            v-bind:class="tabIndex==0?'btn btn-success':'btn btn-default'">Առաջին
                                    </button>
                                    <button type="button" v-on:click="categorytabs(1)"
                                            style="width: 30%;padding-left: 3px;"
                                            v-bind:class="tabIndex==1?'btn btn-success':'btn btn-default'">Երկրորդ
                                    </button>
                                    <button type="button" v-on:click="categorytabs(2)"
                                            style="width: 30%;padding-left: 3px;"
                                            v-bind:class="tabIndex==2?'btn btn-success':'btn btn-default'"> Գույք
                                    </button>
                                </div>
                                <hr/>

                                <div v-if="showCategories">
                                    <div v-if="tabIndex == 0">
                                        <v-jstree :data="firstCategories" show-checkbox multiple
                                                  allow-batch whole-row @item-click="filterByCategory"></v-jstree>
                                    </div>
                                    <div v-if="tabIndex == 1">
                                        <v-jstree :data="secondCategories" show-checkbox multiple
                                                  allow-batch whole-row @item-click="filterByCategory"></v-jstree>
                                    </div>
                                    <div v-if="tabIndex == 2">
                                        <v-jstree :data="thirdCategories" show-checkbox multiple
                                                  allow-batch whole-row @item-click="filterByCategory"></v-jstree>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-9 no-margin wide sidebar">
                    <!--<section v-if="showTopProducts" id="recommended-products" class="carousel-holder hover small">-->

                    <!--<div class="title-nav">-->
                    <!--<h2 class="inverse">Հաճախակի պատվիրվող</h2>-->
                    <!--<div class="nav-holder">-->
                    <!--<a href="#prev" data-target="#owl-recommended-products"-->
                    <!--class="slider-prev btn-prev fa fa-angle-left"></a>-->
                    <!--<a href="#next" data-target="#owl-recommended-products"-->
                    <!--class="slider-next btn-next fa fa-angle-right"></a>-->
                    <!--</div>-->
                    <!--</div>-->

                    <!--<carousel :per-page="4" style="margin-bottom: 100px">-->
                    <!--<slide v-bind:id="'topProduct-'+product.id" v-for="product in topProducts" data-index="0"-->
                    <!--v-bind:key="product.id" data-name="MySlideName">-->
                    <!--<div class="no-margin carousel-item product-item-holder hover size-medium">-->
                    <!--<div class="product-item">-->
                    <!--<div class="image">-->
                    <!--<img v-if="product.image" style="height: 145px"-->
                    <!--v-bind:src="'img/products/'+product.image"/>-->
                    <!--<br v-else>-->
                    <!--<span style="position: absolute;right: 2px; font-weight: bold">#{{product.code}}</span>-->
                    <!--</div>-->
                    <!--<div class="body">-->
                    <!--<div class="title">-->
                    <!--<a href="#">{{product.name}}</a>-->
                    <!--</div>-->
                    <!--<p style="overflow: hidden" v-if="product.description"><b>{{product.description.replace(/<[^>]*>/g, '')}}</b></p>-->
                    <!--<span>Առկա է {{product.count}} {{product.unit}}</span>-->
                    <!--</div>-->
                    <!--<div class="prices product-count">-->
                    <!--<button class="btn btn-default"-->
                    <!--v-on:click="deleteCount('topCount-'+product.id)">- -->
                    <!--</button>-->
                    <!--<input class="count-input asdf" type="number" v-bind:id="'topCount-'+product.id" value="1"/>-->
                    <!--<button v-bind:class="'btn btn-default count-'+product.id"-->
                    <!--v-on:click="addCount('topCount-'+product.id, product.count)">+-->
                    <!--</button>-->
                    <!--</div>-->
                    <!--<div class="hovaer-area">-->
                    <!--<div class="add-cart-button">-->
                    <!--<button v-on:click="addToCart('topCount-'+product.id, product.count, 'top')"-->
                    <!--class="le-button">ավելացնել-->
                    <!--</button>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->

                    <!--</slide>-->

                    <!--</carousel>-->


                    <!--</section>-->
                    <section v-if="furnituresTab">
                        <!--                        <p v-for="furniture in furnitures" >{{ furniture.name }}</p>-->


                        <div class="grid-list-products">
                            <div style="float:right">
                                <template>
                                    <div style="width:400px">
                                        <Select2 v-model="categoriesStructureFindValue"
                                                 :options="categoriesStructureFind"
                                                 :settings="{placeholder:'Ընտրել բաժին'}"
                                                 @change="filterFurn($event)"
                                                 @select="mySelectEvent($event)"

                                        />

                                    </div>
                                </template>
                            </div>
                            <h2 class="section-title">Գույք ({{furnitures.length}})</h2>

                            <div v-if="furnitures.length" data-v-6707e3d4="" class="control-bar">
                                <div data-v-6707e3d4="" class="grid-list-buttons">
                                    <ul>
                                        <li class="grid-list-button-item active">
                                            <a data-toggle="tab" href="#grid-view1">
                                                <i class="fa fa-th-large"></i> Ցանց
                                            </a>
                                        </li>
                                        <li class="grid-list-button-item ">
                                            <a data-toggle="tab" href="#list-view1">
                                                <i class="fa fa-th-list"></i> Ցուցակ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div style="margin:15px 10px;height: 15px">
                                <h4>{{ categoriesStructureFindValue }}</h4>
                            </div>

                            <div v-if="furnitures.length == 0" style="text-align: center">
                                <hr>
                                <h1>Գույք չի գտնվել</h1>
                                <hr>
                            </div>
                            <div class="tab-content">
                                <div id="grid-view1" class="products-grid tab-pane in active">
                                    <div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: start;">
                                        <div v-if="furnitures.length"
                                             v-for="product in furnitureNoImage"
                                             v-bind:key="product.id"
                                             style="width:300px;flex-basis:260px;padding:2px; text-align:center; margin:5px;border-radius: 10px;box-shadow:2px 2px 7px #59B210"
                                             class="itemHover"
                                        >
                                            <div  class="product-item " style="">
                                                <!--<div v-if="calculateDay(product.created)" class="ribbon blue"><span>Նոր</span></div>-->
                                                <!--<div class="ribbon red"><span>Պահանջված</span></div>-->
                                                <!--                                                    <div class="imageq" style="position: relative">-->
                                                <!--                                                        <span style="position: absolute; right:5px; font-weight: bold">#{{product.code}}</span>-->
                                                <!--                                                    </div>-->
                                                <div class="body" style="">
                                                    <p style="text-align: right"><b>#{{product.code}}&nbsp;&nbsp;</b>
                                                          </p>
                                                    <div class="title" style="height: 60px;">
                                                        <a href="#">{{product.name}} </a>
                                                    </div>
                                                    <span >Առկա է {{product.count}} հատ</span>
                                                    <br>
                                                    <span style="font-size: 13px" v-if="getSchool(getSchoolParent(product.categoryStructure_id)) != null"><b>{{getSchool(getSchoolParent(product.categoryStructure_id))}}ի</b></span>
                                                    <br>
                                                    <span style="font-size: 13px"><b>{{getSchool(product.categoryStructure_id)}}ում</b></span>
                                                    <br>
                                                    <span style="font-size: 13px">Պատասխանատու՝ {{getUsername(product.user_id)}}</span>
                                                    <!--                                                            <p ><b>{{ getCategory(product.category_id) }}</b></p>-->
                                                </div>
                                                <div class="prices product-count">
                                                    <button class="btn btn-default"
                                                            v-on:click="deleteCount('countfurn1-'+product.id, product.count)">
                                                        -
                                                    </button>
                                                    <input class="count-input asdf" type="number"
                                                           v-bind:id="'countfurn1-'+product.id" value="1"/>
                                                    <button v-bind:class="'btn btn-default count-'+product.id"
                                                            v-on:click="addCount('countfurn1-'+product.id, product.count)">
                                                        +
                                                    </button>
                                                </div>
                                                <div class="hover-area">
                                                    <div class="wish-compare text-center">

                                                        <button style="margin-top: 10px"
                                                                v-if="user == null || product.categoryStructure_id !== user.categoryStructure_id"
                                                                v-on:click="orderFurn(product.id,'countfurn1-'+product.id)"
                                                                v-bind:id="'add-to-cart-no-image-'+product.id"
                                                                class="le-button buttonHover">Պատվիրել
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>


                                    </div>
                                </div>

                                <!--                            </div>-->

                                <div id="list-view1" class="products-grid tab-pane ">
                                    <div class="products-list">
                                        <div v-if="furnitures.length" v-bind:id="'list-product-'+product.id"
                                             v-for="product in furnitureNoImage" v-bind:key="product.id"
                                             class="pPriceroduct-item product-item-holder"
                                             style="border-radius: 10px;box-shadow:2px 2px 7px #59B210;margin-top:2px"
                                        >

                                            <!--<div v-if="calculateDay(product.created)" class="ribbon blue"><span>Նոր</span></div>-->
                                            <!--<div class="ribbon red"><span>Պահանջված</span></div>-->
                                            <div class="row">
                                                <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                    <div class="image" style="position: relative">
                                                        <img alt="" v-bind:src="'img/products/'+product.image"/>
                                                        <span style="position: absolute;right: 5px;bottom: 0px; font-weight: bold">#{{product.code}}</span>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                    <div class="body">
                                                        <div class="title">
                                                            <a href="#">{{product.name}}</a>
                                                            <br/>
                                                            <br/>
                                                        </div>
                                                        <div class="excerpt">
                                                            <span>Առկա է {{product.count}} հատ</span>
                                                            <br>
                                                            <span v-if="getSchool(getSchoolParent(product.categoryStructure_id)) != null"><b>{{getSchool(getSchoolParent(product.categoryStructure_id))}}ի</b></span>
                                                            <br>
                                                            <span><b>{{getSchool(product.categoryStructure_id)}}ում</b></span>
                                                            <br>
                                                            <span>Պատասխանատու՝ {{getUsername(product.user_id)}}</span>

                                                            <!--                                                            <p ><b>{{ getCategory(product.category_id) }}</b></p>-->
                                                        </div>
                                                        <div class="prices product-count">
                                                            <button class="btn btn-default"
                                                                    v-on:click="deleteCount('countfurn2-'+product.id)">-
                                                            </button>
                                                            <!--<p v-bind:id="'count2-'+product.id">1</p>-->
                                                            <input class="count-input asdf" type="number"
                                                                   v-bind:id="'count2-'+product.id" value="1"/>

                                                            <button v-bind:class="'btn btn-default count-'+product.id"
                                                                    v-on:click="addCount('countfurn2-'+product.id, product.count)">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                    <div class="wish-compare text-center"
                                                         style="margin-bottom: 20px;">

                                                        <button style="margin-top: 10px"
                                                                v-if="user == null || product.categoryStructure_id !== user.categoryStructure_id"
                                                                v-on:click="orderFurn(product.id,'countfurn1-'+product.id)"
                                                                v-bind:id="'add-to-cart-no-image-'+product.id"
                                                                class="le-button buttonHover">Պատվիրել
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-12" style="text-align: center" v-if="furnitures.length>10">
                                <paginate
                                        v-model="page"
                                        :page-count="Math.floor(furnitures.length/10+1)"
                                        :page-range="3"
                                        :margin-pages="2"
                                        :click-handler="goToPageFurn"
                                        :prev-text="'Նախորդ'"
                                        :next-text="'Հաջորդ'"
                                        :container-class="'pagination'"
                                        :page-class="'page-item'">
                                </paginate>
                            </div>
                        </div>


                    </section>

                    <section v-if="productsTab" id="gaming">
                        <div class="grid-list-products">
                            <h2 class="section-title">Ապրանքներ ({{products.length}})</h2>

                            <div v-if="products.length" data-v-6707e3d4="" class="control-bar">
                                <div data-v-6707e3d4="" class="grid-list-buttons">
                                    <ul>
                                        <li class="grid-list-button-item active">
                                            <a data-toggle="tab" href="#grid-view">
                                                <i class="fa fa-th-large"></i> Ցանց
                                            </a>
                                        </li>
                                        <li class="grid-list-button-item ">
                                            <a data-toggle="tab" href="#list-view">
                                                <i class="fa fa-th-list"></i> Ցուցակ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div v-else style="text-align: center">
                                <hr>
                                <h1>Ապրանքներ չեն գտնվել</h1>
                                <hr>
                            </div>
                            <div style="margin:15px 10px;height: 15px">

                            </div>
                            <div class="tab-content">
                                <div id="grid-view" class="products-grid tab-pane in active">
                                    <div class="product-grid-holder" style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: start;">
<!--                                        <div class="row no-margin" style="">-->
<!--                                            <div v-if="productsWithImage.length" v-bind:id="'product-'+product.id"-->
<!--                                                 v-for="product in productsWithImage"-->
<!--                                                 v-bind:key="product.id"-->
<!--                                                 class="col-xs-12 col-sm-3 no-margin product-item-holder"-->
<!--                                                 style="height:250px;width:300px; max-width: 300px;; border: 1px solid white;border-radius: 10px;box-shadow:2px 2px 7px #59B210">-->
<!--                                                <div class="product-item">-->
<!--                                                    <div class="imageq" style="position: relative">-->

<!--                                                        <p style="position: absolute;right:5px;bottom:0px; font-weight: bold">-->
<!--                                                            #{{product.code}}</p>-->
<!--&lt;!&ndash;                                                        <img style="height: 167px" id="img-1"&ndash;&gt;-->
<!--&lt;!&ndash;                                                             v-bind:src="'img/products/'+product.image"/>&ndash;&gt;-->
<!--                                                    </div>-->
<!--                                                    <div class="body">-->
<!--                                                        <div class="title" style="height: 50px">-->
<!--                                                            <a href="#">{{product.name}}</a>-->
<!--                                                        </div>-->
<!--                                                        <span>Առկա է {{product.count}} {{product.unit}}</span>-->
<!--                                                        <p> Կատեգորիա՝ {{getCategoryProduct(product.category)}}</p>-->
<!--                                                        &lt;!&ndash;                                                        <p style="overflow: hidden" v-if="product.description"><b>{{product.description.replace(/<[^>]*>/g,&ndash;&gt;-->
<!--                                                        &lt;!&ndash;                                                            '')}}</b></p>&ndash;&gt;-->
<!--                                                    </div>-->
<!--                                                    <div class="prices product-count">-->
<!--                                                        <button class="btn btn-default"-->
<!--                                                                v-on:click="deleteCount('count1-'+product.id)">- -->
<!--                                                        </button>-->
<!--                                                        <input class="count-input asdf" type="number"-->
<!--                                                               v-bind:id="'count1-'+product.id" value="1"/>-->
<!--                                                        <button v-bind:class="'btn btn-default count-'+product.id"-->
<!--                                                                v-on:click="addCount('count1-'+product.id, product.count)">-->
<!--                                                            +-->
<!--                                                        </button>-->
<!--                                                    </div>-->
<!--                                                    <div class="hover-area">-->
<!--                                                        <div class="wish-compare text-center"-->
<!--                                                             style="margin-bottom: 5px;">-->
<!--                                                            <button v-on:click="addToCart('count1-'+product.id, product.count, 'grid')"-->
<!--                                                                    class="le-button buttonHover"-->
<!--                                                                    v-bind:id="'add-to-cart-'+product.id">ավելացնել-->
<!--                                                            </button>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <br>-->
<!--                                            </div>-->
<!--                                        </div>-->

<!--                                        <div class="row no-margin">-->
<!--                                            <div v-if="productsWithDefaultImage.length"-->
<!--                                                 v-bind:id="'product-'+product.id"-->
<!--                                                 v-for="product in productsWithDefaultImage"-->
<!--                                                 v-bind:key="product.id"-->
<!--                                                 class="col-xs-12 col-sm-3 no-margin "-->
<!--                                                 style="text-align:center;">-->
<!--                                                <div class="product-item "-->
<!--                                                     style="height:250px;width:300px; margin: 0 auto;max-width: 300px;; border: 1px solid white;border-radius: 10px;box-shadow:2px 2px 7px #59B210; ">-->
<!--                                                    &lt;!&ndash;<div v-if="calculateDay(product.created)" class="ribbon blue"><span>Նոր</span></div>&ndash;&gt;-->
<!--                                                    &lt;!&ndash;<div class="ribbon red"><span>Պահանջված</span></div>&ndash;&gt;-->
<!--                                                    <div class="imageq">-->
<!--                                                        <span style="position: absolute; right:5px; font-weight: bold">#{{product.code}}</span>-->
<!--                                                    </div>-->
<!--                                                    &lt;!&ndash;                                                    <img style="height:100px" src="/img/products/no-image.png"/>&ndash;&gt;-->
<!--                                                    <div class="body" style="margin-top: 25px">-->
<!--                                                        <div class="title" style="height: 50px">-->
<!--                                                            <a href="#">{{product.name}}</a>-->
<!--                                                        </div>-->
<!--                                                        <span>Առկա է {{product.count}} {{product.unit}}</span>-->
<!--                                                        <p> Կատեգորիա՝ {{getCategoryProduct(product.category)}}</p>-->

<!--                                                        &lt;!&ndash;                                                        <p style="overflow: hidden" v-if="product.description"><b>{{product.description.replace(/<[^>]*>/g,&ndash;&gt;-->
<!--                                                        &lt;!&ndash;                                                            '')}}</b></p>&ndash;&gt;-->
<!--                                                    </div>-->
<!--                                                    <div class="prices product-count">-->
<!--                                                        <button class="btn btn-default"-->
<!--                                                                v-on:click="deleteCount('count1-'+product.id, product.count)">-->
<!--                                                            - -->
<!--                                                        </button>-->
<!--                                                        <input class="count-input asdf" type="number"-->
<!--                                                               v-bind:id="'count1-'+product.id" value="1"/>-->
<!--                                                        <button v-bind:class="'btn btn-default count-'+product.id"-->
<!--                                                                v-on:click="addCount('count1-'+product.id, product.count)">-->
<!--                                                            +-->
<!--                                                        </button>-->
<!--                                                    </div>-->
<!--                                                    <div class="hover-area">-->
<!--                                                        <div class="wish-compare text-center"-->
<!--                                                             style="margin-bottom: 5px;">-->
<!--                                                            <button style="margin-top: 10px"-->
<!--                                                                    v-on:click="addToCart('count1-'+product.id, product.count, 'grid')"-->
<!--                                                                    v-bind:id="'add-to-cart-no-image-'+product.id"-->
<!--                                                                    class="le-button buttonHover">ավելացնել-->
<!--                                                            </button>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <br>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="row no-margin">-->

                                            <div v-if="productsNoImage.length" v-bind:id="'product-'+product.id"
                                                 v-for="product in productsNoImage"
                                                 v-bind:key="product.id"
                                                 class="col-xs-12 col-sm-3 no-margin itemHover "
                                                 style="text-align:center;flex-basis:260px;margin: 5px; border: 1px solid white;border-radius: 10px;box-shadow:2px 2px 7px #59B210">
                                                <div class="product-item "
                                                     style="">
                                                    <!--<div v-if="calculateDay(product.created)" class="ribbon blue"><span>Նոր</span></div>-->
                                                    <!--<div class="ribbon red"><span>Պահանջված</span></div>-->
                                                    <p style="text-align: right"><b>#{{product.code}}&nbsp;&nbsp;</b></p>
                                                    <div class="body" style="">
                                                        <div class="title" style="height: 50px">
                                                            <a href="#">{{product.name}}</a>
                                                        </div>
                                                        <span>Առկա է {{product.count}} {{product.unit}}</span>
                                                        <div style="height: 50px">
                                                            <p> Կատեգորիա՝ {{getCategoryProduct(product.category)}}</p>
                                                        </div>


                                                        <!--                                                        <p style="overflow: hidden" v-if="product.description"><b>{{product.description.replace(/<[^>]*>/g,-->
                                                        <!--                                                            '')}}</b></p>-->
                                                    </div>
                                                    <div class="prices product-count">
                                                        <button class="btn btn-default"
                                                                v-on:click="deleteCount('count1-'+product.id, product.count)">
                                                            -
                                                        </button>
                                                        <input class="count-input asdf" type="number"
                                                               v-bind:id="'count1-'+product.id" value="1"/>
                                                        <button v-bind:class="'btn btn-default count-'+product.id"
                                                                v-on:click="addCount('count1-'+product.id, product.count)">
                                                            +
                                                        </button>
                                                    </div>
                                                    <div class="hover-area">
                                                        <div class="wish-compare text-center"
                                                             style="">
                                                            <button style="margin-top: 10px"
                                                                    v-on:click="addToCart('count1-'+product.id, product.count, 'grid')"
                                                                    v-bind:id="'add-to-cart-no-image-'+product.id"
                                                                    class="le-button buttonHover">ավելացնել
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
<!--                                        </div>-->


                                    </div>

                                </div>
                                <!--_____________________________________________________________________________________________________________________________________-->
                                <div id="list-view" class="products-grid tab-pane">
                                    <div class="products-list">
                                        <div v-if="productsWithImage.length" v-bind:id="'list-product-'+product.id"
                                             v-for="product in productsWithImage" v-bind:key="product.id"
                                             class="product-item product-item-holder"
                                             style="border-radius: 10px;box-shadow:2px 2px 7px #59B210;margin-top:2px;height: 170px">
                                            <!--<div v-if="calculateDay(product.created)" class="ribbon blue"><span>Նոր</span></div>-->
                                            <!--<div class="ribbon red"><span>Պահանջված</span></div>-->
                                            <div class="row">
                                                <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                    <div class="image" style="position: relative">
                                                        <img alt="" v-bind:src="'img/products/'+product.image"/>
                                                        <span style="position: absolute;right: 5px;bottom: 0px; font-weight: bold">#{{product.code}}</span>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                    <div class="body">
                                                        <div class="title">
                                                            <a href="#">{{product.name}}</a>
                                                            <br/>
                                                            <br/>
                                                        </div>
                                                        <div class="excerpt">
                                                            <span>Առկա է {{product.count}} {{product.unit}}</span>
                                                            <p> Կատեգորիա՝ {{getCategoryProduct(product.category)}}</p>
                                                            <!--                                                            <p style="overflow: hidden">{{product.description}}</p>-->
                                                        </div>
                                                        <div class="prices product-count">
                                                            <button class="btn btn-default"
                                                                    v-on:click="deleteCount('count2-'+product.id)">-
                                                            </button>
                                                            <input class="count-input asdf" type="number"
                                                                   v-bind:id="'count2-'+product.id" value="1"/>
                                                            <button v-bind:class="'btn btn-default count-'+product.id"
                                                                    v-on:click="addCount('count2-'+product.id, product.count)">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                    <div class="right-clmn">
                                                        <!--<div class="price-current" v-if="product.description">{{product.description.replace(/<[^>]*>/g, '')}}</div>-->
                                                        <br/>
                                                        <button class="le-button buttonHover"
                                                                v-on:click="addToCart('count2-'+product.id, product.count, 'list')">
                                                            ավելացնել
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products-list">
                                        <div v-if="productsWithDefaultImage.length"
                                             v-bind:id="'list-product-'+product.id"
                                             v-for="product in productsWithDefaultImage" v-bind:key="product.id"
                                             class="pPriceroduct-item product-item-holder"
                                             style="border-radius: 10px;box-shadow:2px 2px 7px #59B210;margin-top:2px;height: 170px">
                                            <!--<div v-if="calculateDay(product.created)" class="ribbon blue"><span>Նոր</span></div>-->
                                            <!--<div class="ribbon red"><span>Պահանջված</span></div>-->
                                            <div class="row">
                                                <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                    <div class="image" style="position: relative">
                                                        <img alt="" v-bind:src="'img/products/'+product.image"/>
                                                        <span style="position: absolute;right: 5px;bottom: 0px; font-weight: bold">#{{product.code}}</span>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                    <div class="body">
                                                        <div class="title">
                                                            <a href="#">{{product.name}}</a>
                                                            <br/>
                                                            <br/>
                                                        </div>
                                                        <div class="excerpt">
                                                            <span>Առկա է {{product.count}} {{product.unit}}</span>
                                                            <p> Կատեգորիա՝ {{getCategoryProduct(product.category)}}</p>
                                                            <p style="overflow: hidden">{{product.description}}</p>
                                                        </div>
                                                        <div class="prices product-count">
                                                            <button class="btn btn-default"
                                                                    v-on:click="deleteCount('count2-'+product.id)">-
                                                            </button>
                                                            <!--<p v-bind:id="'count2-'+product.id">1</p>-->
                                                            <input class="count-input asdf" type="number"
                                                                   v-bind:id="'count2-'+product.id" value="1"/>
                                                            <button v-bind:class="'btn btn-default count-'+product.id"
                                                                    v-on:click="addCount('count2-'+product.id, product.count)">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                    <div class="right-clmn">
                                                        <!--<div class="price-current" v-if="product.description">{{product.description.replace(/<[^>]*>/g, '')}}</div>-->
                                                        <br/>
                                                        <button class="le-button buttonHover"
                                                                v-on:click="addToCart('count2-'+product.id, product.count, 'list')">
                                                            ավելացնել
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div v-else>-->
                                        <!--<h1>Ապրանքներ չեն գտնվել</h1>-->
                                        <!--</div>-->

                                    </div>
                                    <!--_____________________________________________________________________________________________________________________________________________________-->
                                    <div class="products-list">
                                        <div v-if="productsNoImage.length" v-bind:id="'list-product-'+product.id"
                                             v-for="product in productsNoImage" v-bind:key="product.id"
                                             class="pPriceroduct-item product-item-holder"
                                             style="border-radius: 10px;box-shadow:2px 2px 7px #59B210;margin-top:5px;height: 180px">
                                            <!--<div v-if="calculateDay(product.created)" class="ribbon blue"><span>Նոր</span></div>-->
                                            <!--<div class="ribbon red"><span>Պահանջված</span></div>-->
                                            <div class="row">
                                                <div class="no-margin col-xs-12 col-sm-3 image-holder">
                                                    <div class="image" style="">
<!--                                                        <img alt="" v-bind:src="'img/products/'+product.image"/>-->
                                                        <span style="right: 5px;bottom: 0px; font-weight: bold">#{{product.code}}</span>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                    <div class="body">
                                                        <div class="title">
                                                            <a href="#">{{product.name}}</a>
                                                            <br/>
                                                            <br/>
                                                        </div>
                                                        <div class="excerpt">
                                                            <span>Առկա է {{product.count}} {{product.unit}}</span>
                                                            <p> Կատեգորիա՝ {{getCategoryProduct(product.category)}}</p>
                                                            <p style="overflow: hidden">{{product.description}}</p>
                                                        </div>
                                                        <div class="prices product-count">
                                                            <button class="btn btn-default"
                                                                    v-on:click="deleteCount('count2-'+product.id)">-
                                                            </button>
                                                            <!--<p v-bind:id="'count2-'+product.id">1</p>-->
                                                            <input class="count-input asdf" type="number"
                                                                   v-bind:id="'count2-'+product.id" value="1"/>
                                                            <button v-bind:class="'btn btn-default count-'+product.id"
                                                                    v-on:click="addCount('count2-'+product.id, product.count)">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                    <div class="right-clmn">
                                                        <!--<div class="price-current" v-if="product.description">{{product.description.replace(/<[^>]*>/g, '')}}</div>-->
                                                        <br/>
                                                        <button class="le-button buttonHover"
                                                                v-on:click="addToCart('count2-'+product.id, product.count, 'list')">
                                                            ավելացնել
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-12" style="text-align: center" v-if="products.length>10">
                                <paginate
                                        v-model="page"
                                        :page-count="Math.floor(products.length/10+1)"
                                        :page-range="3"
                                        :margin-pages="2"
                                        :click-handler="goToPage"
                                        :prev-text="'Նախորդ'"
                                        :next-text="'Հաջորդ'"
                                        :container-class="'pagination'"
                                        :page-class="'page-item'">
                                </paginate>
                            </div>

                        </div>

                    </section>
                </div>
            </div>
        </section>


    </div>
</template>

<script>
    import Head from "./includes/Head";
    import $ from "jquery";
    import {Carousel, Slide} from 'vue-carousel';
    import VJstree from 'vue-jstree';
    import Paginate from 'vuejs-paginate';
    import router from "../router/index";
    import Select2 from 'v-select2-component';


    export default {
        name: "home",
        categoryFilter: [],

        data() {

            return {
                snackbar: false,
                user: JSON.parse(localStorage.getItem("user")),
                firstCategories: [],
                secondCategories: [],
                thirdCategories: [],
                categoriesStructure: [],
                categoriesStructureFindValue: null,
                categoriesStructureFind: [],
                usernames: [],
                filterCategoriesStructureId: null,
                categoryFilter: [],
                priceFilter: null,
                min: "",
                max: "",
                search: null,
                searchResult: null,
                test: "",
                topProducts: [],
                page: 0,
                products: [],
                showTopProducts: true,
                productsWithImage: [],
                productsWithDefaultImage: [],
                productsNoImage: [],
                cartContent: localStorage.getItem("cartContent") ? JSON.parse(localStorage.getItem("cartContent")) : [],
                productCount: 1,
                count: 1,
                tabIndex: 0,
                productsTab: true,
                furnituresTab: false,
                furnitures: [],
                data: [],
                showCategories: false,
                furnitureNoImage: []

            }
        },
        components: {
            Head,
            Carousel,
            Slide,
            VJstree,
            Paginate,
            Select2


        },
        mounted() {
            this.getSchools();
            this.getUsernames();
            // this.getSchoolParent();


            // console.log('user:',this.user);

            var _this = this;
            $(document).on('click', '.category-class', function (event) {
                _this.filterByCategory(this);
            });


        },
        // computed: {
        // settings: function () {
        //     return {
        //         arrayData: this.arrayData
        //     }
        // }
        // },
        created() {
            this.getCategories();
            this.filterFunc();
            this.getTopProducts();
        },
        methods: {
            categorytabs(index) {
                this.tabIndex = index;
                this.filterFunc();

            },
            mySelectEvent(val) {
                this.categoriesStructureFindValue = val.text;
            },
            filterFurn(id = 0, text) {

                this.filterCategoriesStructureId = id;
                // console.log('sadf',this.filterCategoriesStructureId);
                this.filterFunc();
            },


            getCategory(myid) {
                let cat = null;
                let id = parseInt(myid);
                this.thirdCategories.forEach(function (value) {

                    if (value.id == id) {
                        cat = value.text;
                        return '';
                    }

                });
                return cat;
            },
            getCategoryProduct(myid) {
                let cat = null;
                let id = parseInt(myid);
                this.firstCategories.forEach(function (value) {

                    if (value.id == id) {
                        cat = value.text;
                        return '';
                    }

                });
                return cat;
            },
            getSchool(myid) {
                let categoryStructureName = null;
                let id = parseInt(myid);
                this.categoriesStructure.forEach(function (value) {
                    if (value.id == id) {
                        categoryStructureName = value.category;
                        return '';
                    }
                });
                return categoryStructureName;
            },
            getSchoolParent(myid) {
                let categoryStructureName = null;
                let idParent = null;
                let id = parseInt(myid);
                this.categoriesStructure.forEach(function (value) {
                    if (value.id == id) {
                        idParent = value.parent_category_id;

                    }
                });
                return idParent;
            },

            getUsername(myid) {
                let username = null;
                let id = parseInt(myid);
                this.usernames.forEach(function (value) {
                    if (value.id == id) {
                        username = value.name;
                        return '';
                    }
                });
                return username;
            },
            getUsernames() {
                let id = 1;
                var url = `auth/getUsernames/${id}`;
                axios.get(url)
                    .then((response) => {
                        this.usernames = response.data.data;
                    });

                // console.log(this.usernames);
            },

            getSchools() {
                var url = "auth/categoriesStructure";
                axios.post(
                    url,
                )
                    .then((data) => {
                        this.categoriesStructure = data.data;
                        this.categoriesStructure.forEach(data => {
                            if (data.parent_category_id == null) {
                                this.categoriesStructureFind.push({id: data.id, text: data.category});
                            }
                        });
                        this.categoriesStructureFind.unshift({id: 0, text: "Բոլորը"});
                        // console.log(this.categoriesStructureFind);
                    })
                    .catch((e) => {
                    });
            },

            getCategories() {
                // console.log('fggfg');
                let url = "/auth/category";
                axios.post(
                    url,
                    {category: this.categoryFilter, price: this.priceFilter, story: this.tabIndex},
                )
                    .then((data) => {
                        for (var i = 0; i < data.data.length; i++) {
                            if (data.data[i].story == 0) {
                                this.firstCategories.push(data.data[i]);
                            } else if (data.data[i].story == 1) {
                                this.secondCategories.push(data.data[i]);
                            } else {
                                this.thirdCategories.push(data.data[i]);
                            }
                        }
                        this.showCategories = true;
                    })
                    .catch((e) => {
                        console.log('exception', e);
                    });
            },

            filterByCategory(node) {
                // console.log(node);
                let id = node.model.id;
                let filter = this.categoryFilter;
                if (filter.includes(id)) {
                    filter.splice(filter.indexOf(id), 1);
                } else {
                    filter.push(id);
                }
                this.categoryFilter = filter;
                this.filterFunc("");
            },

            minPrice(min = 0) {
                this.min = min.target.value;
            },

            maxPrice(max = 1) {
                this.max = max.target.value;
            },
            getFurnitures(product) {
                // alert();
                var url = "auth/getFurnitures";
                // console.log(product);
                axios.post(
                    url,
                    {product: product, categories: this.categoryFilter, school: this.filterCategoriesStructureId},
                )
                    .then((data) => {
                        let result = data.data.data;
                        if(this.user != null){
                            this.furnitures = result.filter(item => item.categoryStructure_id != this.user.categoryStructure_id);
                        }else{
                            this.furnitures = result;
                        }

                        this.furnitureSorting();


                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },

            filterFunc(product = null) {
                if (this.tabIndex == 2) {
                    this.productsTab = false;
                    // if(!this.furnitures.length){
                    this.getFurnitures(product);
                    // }
                    this.furnituresTab = true;
                    return;
                } else {
                    this.furnituresTab = false;
                    this.productsTab = true;
                }

                if (!product || product.length == 0) {
                    this.showTopProducts = true
                } else {
                    this.showTopProducts = false
                }

                var url = "auth/products";
                axios.post(
                    url,
                    {product: product, category: this.categoryFilter, price: [this.min, this.max]},
                )
                    .then((data) => {
                        this.products = data.data;
                        this.productSorting();
                        // console.log(this.products);
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },
            goToPageFurn(pageNum) {

                this.page = pageNum;
                this.furnitureSorting();
            },

            goToPage(pageNum) {
                // console.log("page = ", pageNum);
                this.page = pageNum;
                this.productSorting();
            },

            furnitureSorting() {
                var data = this.furnitures;

                var arrWithImage = [];
                var arrWithDefaultImage = [];
                var arrNoImage = [];

                let startPage = (this.page - 1) * 10;

                // alert(startPage);

                if (startPage < 0) {
                    startPage = 0;
                }

                let endPage = startPage + 10;

                if (!data[endPage]) {
                    endPage = data.length;
                    // alert(endPage);

                }

                for (let i = startPage; i < endPage; i++) {
                    arrNoImage.push(data[i]);

                }


                this.furnitureNoImage = arrNoImage;
            },

            productSorting() {
                var data = this.products;

                var arrWithImage = [];
                var arrWithDefaultImage = [];
                var arrNoImage = [];

                let startPage = (this.page - 1) * 10;

                // alert(startPage);

                if (startPage < 0) {
                    startPage = 0;
                }

                let endPage = startPage + 10;

                if (!data[endPage]) {
                    endPage = data.length;
                    // alert(endPage);

                }

                for (let i = startPage; i < endPage; i++) {

                        arrNoImage.push(data[i]);

                }


                this.productsWithImage = arrWithImage;
                this.productsWithDefaultImage = arrWithDefaultImage;
                this.productsNoImage = arrNoImage;
            },


            getTopProducts() {
                let url = "/auth/products";
                axios.post(
                    url,
                    {top: 1},
                )
                    .then((data) => {
                        this.topProducts = data.data;
                        // console.log(data.data);
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },


            animation(id = 0) {
                var cart = $('#cart');
                var imgtodrag = $("#" + id);

                console.log(cart, imgtodrag);
                if (imgtodrag) {
                    var imgclone = imgtodrag.clone()
                        .offset({
                            top: imgtodrag.offset().top,
                            left: imgtodrag.offset().left
                        })
                        .css({
                            'opacity': '1',
                            'position': 'absolute',
                            'width': document.getElementById(id).offsetWidth,
                            'z-index': '100',
                            'border': '1px solid',
                            'box-shadow': '0px 0px 10px 5px rgba(2,181,23,0.5)'
                        })
                        .appendTo($('body'))
                        .animate({
                            'top': cart.offset().top,
                            'left': cart.offset().left,
                            'width': 50,
                            'height': 50,
                            'border-radius': 30 + '%',
                            'opacity': 0.15
                        }, 600);

                    imgclone.animate({
                        'width': 0,
                        'height': 0
                    }, function () {
                        $(this).detach()
                    });
                }
            },

            addToCart(id, storyCount = 0, type = "top") {

                // console.log(this.cartContent);

                let count = parseFloat(document.getElementById(id).value);
                var isset = false;
                var product = null;
                var id = id.split("-")[1];
                for (let i = 0; i < this.cartContent.length; i++) {
                    if (this.cartContent[i].product.id == id) {

                        if (storyCount > this.cartContent[i].count) {
                            this.cartContent[i].count += count;
                            if (type == "top") {
                                this.animation('topProduct-' + id);
                            }
                            if (type == "grid") {
                                this.animation('product-' + id);
                            }
                            if (type == "list") {
                                this.animation('list-product-' + id);
                            }
                        } else {
                            $("#add-to-cart-" + id)
                                .removeClass("btn-success")
                                .addClass("btn-danger")
                                .css({background: "red"})
                                .html("Առկա չէ");

                            $("#add-to-cart-default-image-" + id)
                                .removeClass("btn-success")
                                .addClass("btn-danger")
                                .css({background: "red"})
                                .html("Առկա չէ");

                            $("#add-to-cart-no-image-" + id)
                                .removeClass("btn-success")
                                .addClass("btn-danger")
                                .css({background: "red"})
                                .html("Առկա չէ");

                        }
                        isset = true;
                    }


                }

                if (!isset) {
                    for (let i = 0; i < this.products.length; i++) {
                        if (id == this.products[i].id) {
                            product = this.products[i];
                        }
                    }
                    if (storyCount > count) {
                        if (type == "top") {
                            this.animation('topProduct-' + id);
                        }
                        if (type == "grid") {
                            this.animation('product-' + id);
                        }
                        if (type == "list") {
                            this.animation('list-product-' + id);
                        }
                    }
                    this.cartContent.push({product: product, count: count});
                }
                localStorage.setItem("cartContent", JSON.stringify(this.cartContent));

            },

            orderFurn(id, inptId) {
                let count = document.getElementById(inptId).value;
                // console.log('data',count);

                var user = JSON.parse(localStorage.getItem("user"));
                if (user == null) {

                    return router.push('login');
                }
                if (!user) {

                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furnId: id, user_id: user.id, count: count};


                var url = 'auth/order/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    if (response.data.success) {
                        this.getFurnitures();
                        this.snackbar = true;
                    }
                })
                    .catch((e) => {
                        console.log("exception", e);
                    });

            },

            addCount(id, count = 0) {
                if (parseInt(document.getElementById(id).value) > count) {
                    $(".count-" + id.split("-")[1]).removeClass("btn-default").addClass("btn-danger");
                }

                for (let i = 0; i < this.cartContent.length; i++) {

                    if (this.cartContent[i].product.id == id.split("-")[1]) {

                        if ((parseInt(document.getElementById(id).value) + this.cartContent[i].count) > count - 1) {

                            $(".count-" + id.split("-")[1]).removeClass("btn-default").addClass("btn-danger").prop("disabled", true);


                            $("#add-to-cart-" + id.split("-")[1])
                                .removeClass("btn-success")
                                .addClass("btn-danger")
                                .css({background: "red"})
                                .html("Առկա չէ")
                                .prop("disabled", true);

                            $("#add-to-cart-default-image-" + id.split("-")[1])
                                .removeClass("btn-success")
                                .addClass("btn-danger")
                                .css({background: "red"})
                                .html("Առկա չէ")
                                .prop("disabled", true);

                            $("#add-to-cart-no-image-" + id.split("-")[1])
                                .removeClass("btn-success")
                                .addClass("btn-danger")
                                .css({background: "red"})
                                .html("Առկա չէ")
                                .prop("disabled", true);

                        } else {
                            document.getElementById(id).value++;
                            return;
                        }
                    } else {
                        console.log("mtav");
                    }
                }

                if (parseInt(document.getElementById(id).value) < count) {
                    document.getElementById(id).value++;
                } else {
                    $(".count-" + id.split("-")[1]).removeClass("btn-default").addClass("btn-danger").prop("disabled", true);
                }

            },

            deleteCount(id, count = null) {

                if (document.getElementById(id).value > 1) {
                    document.getElementById(id).value--;
                    $(".count-" + id.split("-")[1]).removeClass("btn-danger").addClass("btn-default").prop("disabled", false);
                }

                for (let i = 0; i < this.cartContent.length; i++) {

                    if (id.split("-")[1] == this.cartContent[i].product.id) {

                        if ((parseInt(document.getElementById(id).value) + this.cartContent[i].count) < count + 1) {
                            $("#add-to-cart-" + id.split("-")[1])
                                .removeClass("btn-danger")
                                .addClass("btn-success")
                                .css({background: "#59B210"})
                                .html("ավելացնել")
                                .prop("disabled", true);

                            $("#add-to-cart-default-image-" + id.split("-")[1])
                                .removeClass("btn-danger")
                                .addClass("btn-success")
                                .css({background: "#59B210"})
                                .html("ավելացնել")
                                .prop("disabled", true);

                            $("#add-to-cart-no-image-" + id.split("-")[1])
                                .removeClass("btn-danger")
                                .addClass("btn-success")
                                .css({background: "#59B210"})
                                .html("ավելացնել")
                                .prop("disabled", true);
                        }
                    }

                }


            },
            calculateDay(data) {
                var today = new Date();
                var date_to_reply = new Date(data);
                var timeinmilisec = today.getTime() - date_to_reply.getTime();
                var day = Math.floor(timeinmilisec / (1000 * 60 * 60 * 24));

                if (day <= 30) {
                    return true;
                }
                return false;
            }
        }
    }
</script>

<style scoped>
    /* Track */
    ::-webkit-scrollbar-track {
        background: #d0d0d0;
    }

    ::-webkit-scrollbar {
        width: 7px;
        height: 7px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 15px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .buttonHover:hover {
        background: white;
        color: #59B210;
        box-shadow: 1px 1px 2px #59B210;
    }

    .itemHover:hover {
        background: rgba(106, 213, 19, 0.1)
    }

</style>
